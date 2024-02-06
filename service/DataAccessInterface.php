<?php

namespace service;
interface DataAccessInterface
{
    public function getUser($login, $password);

    public function getAllAnnonces();

    public function getPost($id);

    public function insertUser($login, $password, $name, $lastName, $dateCreate);

    public function getLogin($login);

    public function insertAnnonce($title, $body, $id, $dateCreate);
}

?>