<?php
namespace control;
include_once "gui/ViewLogin.php";
include_once "gui/ViewAnnonces.php";
include_once "gui/ViewPost.php";
include_once "service/AnnoncesChecking.php";

class Controllers
{
    public function annoncesAction($login, $password, $data, $annoncesCheck)
    {
        $annoncesTxt = null;
        if ($annoncesCheck->authenticate($login, $password, $data)){
            $annoncesCheck->getAllAnnonces($data);
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
        }
    }

    public function postAction($id, $data, $annoncesCheck)
    {
        $annoncesCheck->getPost($id, $data);
    }

    public function inscriptionAction($login, $password, $name, $lastName, $data, $userServices)
    {
        if ($userServices->getLogin($login, $data) == null){
            if ($userServices->strongPasswordChecking($password)){
                $userServices->inscription($login, $password, $name, $lastName, $data);
            }
        }
    }

    public function createPostAction($title, $body, $user, $data, $annoncesCheck)
    {
        $annoncesCheck->insertAnnonce($title, $body, $user, date("D d M Y H:i:s"), $data);
    }



}

?>
