<?php

require_once __DIR__ . '/../Model/chatservice.class.php';

class MessageController {
    public function index() 
    {
        $title = "My Messages";
        $currUser = $_SESSION['user'];
        $user = "@" . $currUser;

        $cs = new ChatService();
        $messageList = $cs->getAllMessages($currUser);
        if ($messageList !== false)
            require_once __DIR__ . '/../View/messages_view.php';
    }

    public function channelMessage ($channelId) {
        // funkcija koja otvara stranicu na kojoj su sve poruke za dani channel
        // do nje dolazimo preko linkova na razgovore
        $cs = new ChatService();
        $currUser = $_SESSION['user'];
        $user = "@" . $currUser;
        $title = $cs->getChannelById($channelId);
        $messageList = $cs->getAllMessagesFromChannel($channelId);

        if ($title !== false)
            require_once __DIR__ . '/../View/chMessages_view.php';
        // jos ubaci klikabilni lajk
    }

    public function sendMessage($channelId) {
        if (isset($_POST['msg']) && !empty($_POST['msg'])) {
            $newMsg = $_POST['msg'];
            $cs = new ChatService();
            $currUser = intval($cs->getUserByName($_SESSION['user']));
            $cs->SendNewMessage($currUser, $channelId, $newMsg);

            //unset($_GET['id_channel']);
            //unset($_GET['rt']);
            //header("index.php?rt=message/channelMessage&id_channel=" . $channelId);
            $this->channelMessage($channelId);
        }
    }

    public function setThumbs ($id) {
        $cs = new ChatService();
        $cs->UpdateThumbsUp($id);
        // treba nam i channelId
        $channelId = $cs->getChannelIdByMessageId($id);

        $this->channelMessage($channelId);
    }
};

?>