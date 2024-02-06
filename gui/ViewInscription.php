<?php
namespace gui;
include_once "View.php";

class ViewInscription extends View
{
    public function __construct($layout)
    {
        parent::__construct($layout);

        $this->title = 'Exemple Annonces Basic PHP: Inscription';


        $this->content = '
            <form method="post" action="/annonces/index.php/inscription/register">
                <label for="login"> Votre identifiant </label> :
                <input type="text" name="login" id="login" placeholder="N0cly" maxlength="12" required />
                <br />
                <label for="password"> Votre mot de passe </label> :
                <input type="password" name="password" id="password" minlength="12" required />
                <br />
                <label for="name"> Votre nom </label> :
                <input type="text" name="name" id="name" maxlength="25" required />
                <br />
                <label for="lastname"> Votre prénom </label> :
                <input type="text" name="lastname" id="lastname" maxlength="25" required />
        
                <input type="submit" value="Envoyer">
            </form>
            <a href="/annonces">Connexion</a>';
    }
}