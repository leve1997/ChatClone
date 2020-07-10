<?php

class Channel {
    private $id;
    private $id_user;
    private $name;

    public function __construct($id, $id_user, $name) 
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->name = $name;
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
        return $this;
    }

    public function __get($property)
    {
        return $this->$property;
    }
};

?>