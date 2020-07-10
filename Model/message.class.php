<?php

class Message {
    private $id;
    private $id_user;
    private $id_channel;
    private $content;
    private $thumbs_up;
    private $date;

    public function __construct($id, $id_user, $id_channel, $content, $thumbs_up, $date)    
    {   
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_channel = $id_channel;
        $this->content = $content;
        $this->thumbs_up = $thumbs_up;
        $this->date = $date;
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
        return $this;
    }
};

?>