<?php

require_once __DIR__ . '/../App/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/channel.class.php';
require_once __DIR__ . '/message.class.php';

class ChatService {
    public function getUserByName($user) 
    {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT id FROM dz2_users WHERE username=:username");
            $st->execute(array('username' => $user));
        }
        catch(PDOException $e)
        {
            echo "Greska [getUserByName] " . $e->getMessage();
        }
        if ($st->rowCount() == 0)
            return false;

        $row = $st->fetch();
        return $row['id'];
    }

    public function checkLogIn($username, $pass) 
    {
        $errorMsg = false;
        $db = DB::getConnection();
        try 
        {
            // prvo treba provjeriti postoji li taj username
            $st = $db->prepare("SELECT password_hash FROM dz2_users WHERE username=:username");
            $st->execute(array('username' => $username));
        }
        catch(PDOException $e)
        {
            echo "Greska [Log in username] " . $e->getMessage();
        }

        if ($st->rowCount() == 0) 
        {
            // taj username ne postoji
            $errorMsg = "Unesen nepostojeci username!";
        }
        else 
        {
        $row = $st->fetch();
        // za taj username moramo provjeriti je li dobar password
        if (!password_verify($pass, $row['password_hash'])) 
            $errorMsg = "Pogresna lozinka!";
        }

        return $errorMsg;
    }

    public function getAllChannels() 
    {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT * FROM dz2_channels");
            $st->execute();
        }
        catch(PDOException $e)
        {
            echo "Greska [All Channels]" . $e->getMessage();
        }

        $result = array();
        while ($row = $st->fetch()) 
        {
            $result[] = new Channel($row['id'], $row['id_user'], $row['name']);
        }

        return $result;
    }

    public function getMyChannels($user) 
    {
        $db = DB::getConnection();
        $id_user = $this->getUserByName($user);
        if ($id_user === false) return false;
        try
        {
            $st = $db->prepare("SELECT * FROM dz2_channels WHERE id_user=:id_user");
            $st->execute(array('id_user' => $id_user));
        }
        catch(PDOException $e)
        {
            echo "Greska [My Channels]" . $e->getMessage();
        }

        $result = array();
        while ($row = $st->fetch()) 
        {
            $result[] = new Channel($row['id'], $row['id_user'], $row['name']);
        }

        return $result;
    }

    public function createNewChannel($user, $name) {
        $db = DB::getConnection();
        $id_user = $this->getUserByName($user);
        try
        {
            $st = $db->prepare("INSERT INTO dz2_channels (id_user, name) VALUES (:id_user, :name)");
            $st->execute(array('id_user' => $id_user, 'name' => $name));
        }
        catch(PDOException $e)
        {
            echo "Greska [NewChannel] " . $e->getMessage();
        }
    }

    public function getAllMessages($user) {
        $db = DB::getConnection();
        $id_user = $this->getUserByName($user);
        try
        {
            $st = $db->prepare("SELECT * FROM dz2_messages WHERE id_user=:id_user ORDER BY date DESC");
            $st->execute(array('id_user' => $id_user));
        }
        catch(PDOException $e) 
        {
            echo "Greska [getAllMessages] " . $e->getMessage(); 
        }

        $result = array();
        while ($row = $st->fetch())
        {
            $username = $this->getUserById($row['id_user']);
            $result[] = new Message($row['id'], $username, $row['id_channel'], 
                                    $row['content'], $row['thumbs_up'], $row['date']);
        }

        return $result;
    }

    public function getChannelById ($id_channel) {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT name FROM dz2_channels WHERE id=:id");
            $st->execute(array('id' => $id_channel));
        }
        catch(PDOException $e)
        {
            echo "Greska [getChannelById] " . $e->getMessage();
        }
        if ($st->rowCount() == 0)
            return false;
        
        $row = $st->fetch();
        return $row['name'];
    }

    public function getChannelByName($channelName)
    {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT id FROM dz2_channels WHERE name=:name");
            $st->execute(array('name' => $channelName));
        }
        catch(PDOException $e)
        {
            echo "Greska [getUserByName] " . $e->getMessage();
        }
        if ($st->rowCount() == 0)
            return false;

        $row = $st->fetch();
        return $row['id'];
    }

    public function getUserById ($user_id) 
    {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT username FROM dz2_users WHERE id=:id");
            $st->execute(array('id' => $user_id));
        }
        catch(PDOException $e)
        {
            echo "Greska [getChannelById] " . $e->getMessage();
        }
        if ($st->rowCount() == 0)
            return false;
        
        $row = $st->fetch();
        return $row['username'];
    }

    public function getAllMessagesFromChannel ($id_channel) 
    {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT * FROM dz2_messages WHERE id_channel=:id_channel ORDER BY date");
            $st->execute(array('id_channel' => $id_channel));
        }
        catch(PDOException $e)
        {
            echo "Greska [ChannelMessages] " . $e->getMessage();
        }
        
        $result = array();
        while ($row = $st->fetch())
        {
            $username = $this->getUserById($row['id_user']);
            $result[] = new Message($row['id'], $username, $row['id_channel'], 
                                    $row['content'], $row['thumbs_up'], $row['date']);
        }

        return $result;
    }

    public function SendNewMessage($id_user, $id_channel, $content) 
    {
        $db = DB::getConnection();
        $sDate = date("Y-m-d H:i:s");
        try
        {
            $st = $db->prepare("INSERT INTO dz2_messages (id_user, id_channel, content, thumbs_up, date) VALUES (:id_user, :id_channel, :content, :thumbs_up, :date)");
            $st->execute(array('id_user' => $id_user,
                                'id_channel' => $id_channel,
                                'content' => $content,
                                'thumbs_up' => 0,
                                'date' => $sDate));
        }
        catch(PDOException $e)
        {
            echo "Greska [NewMessage] " . $e->getMessage();
        }
    }

    public function getThumbsUpById ($id)
    {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT thumbs_up FROM dz2_messages WHERE id=:id");
            $st->execute(array('id' => $id));
        }
        catch(PDOException $e)
        {
            echo "Greska [getThumbsUpById] " . $e->getMessage();
        }

        if ($st->rowCount() == 0) 
            return false;
        
        $row = $st->fetch();
        return $row['thumbs_up'];
    }

    public function getChannelIdByMessageId($id) 
    {
        $db = DB::getConnection();
        try
        {
            $st = $db->prepare("SELECT id_channel FROM dz2_messages WHERE id=:id");
            $st->execute(array('id' => $id));
        }
        catch(PDOException $e)
        {
            echo "Greska [getChannelIdByMessageID] " . $e->getMessage();
        }

        if ($st->rowCount === 0)
            return false;
        
        $row = $st->fetch();
        return $row['id_channel'];
    }

    public function UpdateThumbsUp($id) 
    {
        $db = DB::getConnection();
        $thumbs_up = $this->getThumbsUpById($id) + 1;
        try
        {
            $st = $db->prepare("UPDATE dz2_messages SET thumbs_up=:thumbs_up WHERE id=:id");
            $st->execute(array('thumbs_up' => $thumbs_up, 'id' => $id));
        }
        catch(PDOException $e)
        {
            echo "Greska [UpdateThumbsUp] " . $e->getMessage();
        }
    }
};
?>