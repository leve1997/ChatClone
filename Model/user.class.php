<?php

class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private $niz;
    private $has_registered;

    public function __construct($id, $username, $password, $email, $niz, $has_registered) 
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->niz = $niz;
        $this->has_registered = $has_registered;
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