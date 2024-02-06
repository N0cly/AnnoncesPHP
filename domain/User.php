<?php

namespace domain;
class User
{
    protected $login;
    protected $password;

    protected $name;
    protected $lastName;
    protected $dateCreate;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }


    public function getLogin()
    {
        return $this->login;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    public function getFullName()
    {
        return $this->name . " " . $this->lastName;
    }

}

?>