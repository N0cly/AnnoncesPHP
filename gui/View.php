<?php
namespace gui;
include_once "Layout.php";

abstract class View
{
    protected $title = '';
    protected $content = '';

    protected $nav= '';
    protected $layout;

    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    public function display()
    {

        if (isset($_SESSION['login'])) {
            $this->nav = '<ul>
        <li><a href="/annonces">Accueil</a></li>
        <li><a href="/annonces/index.php/annonces">Liste des articles</a></li>
        <li><a href="/annonces/index.php/create">Ajouter un article</a></li>
        <li><a href="/annonces/index.php/logout">Déconnexion</a></li>
    </ul>';
        } else {
            $this->nav = ' ';
        }

        $this->layout->display( $this->title, $this->content , $this->nav);
    }
}
?>
