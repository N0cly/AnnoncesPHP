<?php

namespace data;

use domain\{Post,User};
include_once "domain/User.php";
include_once "domain/Post.php";
use service\DataAccessInterface;
include_once "service/DataAccessInterface.php";

class DataAccess implements DataAccessInterface
{
    protected $dataAccess = null;

    public function __construct($dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function __destruct()
    {
        $this->dataAccess = null;
    }

    public function getUser($login, $password)
    {
        $user = null;

        $query = 'SELECT login FROM Users WHERE login="' . $login . '" and password="' . $password . '"';
        $result = $this->dataAccess->query($query);

        if ($result->rowCount())
            $user = new User($login, $password, );

        $result->closeCursor();

        return $user;
    }

    public function getLogin($login)
    {
        $user = null;

        $query = 'SELECT login FROM Users WHERE login="' . $login . '"';
        $result = $this->dataAccess->query($query);

        if ($result->rowCount())
            $user = true;

        $result->closeCursor();

        return $user;
    }
    public function insertUser($login, $password, $name, $lastName, $dateCreate)
    {
        $query = 'INSERT INTO Users (login, password, name, lastName, dateCreate) VALUES ("' . $login . '", "' . $password . '", "' . $name . '", "' . $lastName . '", "' . $dateCreate . '")';
        $this->dataAccess->exec($query);
    }



    public function getAllAnnonces()
    {
        // Modifiez votre requête SQL pour inclure la clause ORDER BY
        $result = $this->dataAccess->query('SELECT * FROM Post ORDER BY dateCreate DESC');
        $annonces = array();

        while ($row = $result->fetch()) {
            $currentPost = new Post($row['id'], $row['title'], $row['body'], $row['dateCreate']);
            $annonces[] = $currentPost;
        }

        $result->closeCursor();

        return $annonces;
    }


    public function getPost($id)
    {
        $id = intval($id);
        $result = $this->dataAccess->query('SELECT * FROM Post WHERE id=' . $id);
        $row = $result->fetch();

        $post = new Post($row['id'], $row['title'], $row['body'], $row['dateCreate']);

        $result->closeCursor();

        return $post;
    }

    public function insertAnnonce($title, $body, $user, $dateCreate)
    {
        $query = 'INSERT INTO Post (title, body, user, dateCreate) VALUES ("' . $title . '", "' . $body . '", "' . $user . '", "' . $dateCreate . '")';
        $this->dataAccess->exec($query);
    }
}
?>