<?php

namespace service;

class UserChecking
{

    public function getLogin($login, $data)
    {
        return $data->getLogin($login);
    }

    public function inscription($login, $password, $name, $lastName, $data)
    {
        $data->insertUser($login, $password, $name, $lastName, date("D d M Y H:i:s"));
    }

}