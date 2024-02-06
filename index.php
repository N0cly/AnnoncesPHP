<?php
// Démarre ou restaure une session
session_start();

// Charge et initialise les bibliothèques globales
include_once 'data/DataAccess.php';
include_once 'control/Controllers.php';
include_once 'control/Presenter.php';
include_once 'service/AnnoncesChecking.php';
include_once 'service/UserChecking.php';
include_once "gui/Layout.php";
include_once 'gui/ViewLogin.php';
include_once 'gui/ViewInscription.php';
include_once 'gui/ViewAnnonces.php';
include_once 'gui/ViewPost.php';
include_once 'gui/ViewCreatePost.php';

// Importation des classes avec un alias
use control\{Controllers, Presenter};
use data\DataAccess;
use gui\{Layout, ViewAnnonces, ViewLogin, ViewPost, ViewInscription, ViewCreatePost};
use service\AnnoncesChecking;
use service\UserChecking;

// Vérification si la session est déjà démarrée
if (session_id() == '') {
    session_start();
}


// Initialisation du DataAccess
try {
    $data = new DataAccess(new PDO('mysql:host=mysql-[compte].alwaysdata.net;dbname=[compte]_annonces_db', '[compte]_annonces', 'password'));
} catch (PDOException $e) {
    // En cas d'échec de connexion, affichez un message d'erreur et arrêtez le script
    print "Erreur de connexion !: " . $e->getMessage() . "<br/>";
    die();
}

// Initialisation des objets nécessaires
$controller = new Controllers();
$annoncesCheck = new AnnoncesChecking();
$userServices = new UserChecking();
$presenter = new Presenter($annoncesCheck);
$layout = new Layout("gui/layout.html");

// Récupération de l'URL demandée par le navigateur
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Traitement des différentes routes
if ($uri == '/annonces/' || $uri == '/annonces/index.php') {
    // Affichage de la page de connexion
    $vueLogin = new ViewLogin($layout);
    $vueLogin->display();
} elseif ($uri == '/annonces/index.php/annonces') {
    // Vérification des informations de connexion
    if (isset($_POST['login']) || isset($_POST['password'])) {
        $user = $userServices->getLogin($_POST['login'], $data);

        if ($user !== null) {
            // Affichage de la liste des annonces si l'utilisateur est connecté
            $controller->annoncesAction($_POST['login'], $_POST['password'], $data, $annoncesCheck);
            $vueAnnonces = new ViewAnnonces($layout, $_POST['login'], $presenter);
            $vueAnnonces->display();
        }
    } elseif(!isset($_POST['login']) || !isset($_POST['password'])) {
        $user = $userServices->getLogin($_SESSION['login'], $data);

        if ($user !== null) {
            // Affichage de la liste des annonces si l'utilisateur est connecté
            $controller->annoncesAction($_SESSION['login'], $_SESSION['password'], $data, $annoncesCheck);
            $vueAnnonces = new ViewAnnonces($layout, $_SESSION['login'], $presenter);
            $vueAnnonces->display();
        }
    }
    else {
        // Redirection vers la page de connexion si les informations de connexion sont incorrectes
        header("Location: /annonces/");
        exit();
    }
} elseif ($uri == '/annonces/index.php/post' && isset($_GET['id'])) {
    // Vérification de l'authentification de l'utilisateur
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    if ($userId !== null) {
        $controller->postAction($_GET['id'], $data, $annoncesCheck);
        $vuePost = new ViewPost($layout, $presenter);
        $vuePost->display();
    } else {
        // Redirection vers la page de connexion si l'utilisateur n'est pas authentifié
        header("Location: /annonces/");
        exit();
    }
} elseif ($uri == '/annonces/index.php/inscription') {
    // Affichage de la page d'inscription
    $vueInscription = new ViewInscription($layout);
    $vueInscription->display();
} elseif ($uri == '/annonces/index.php/inscription/register' && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['lastname'])) {
    // Vérification de l'unicité du login
    if ($userServices->getLogin($_POST['login'], $data) == null) {
        $userServices->inscription($_POST['login'], $_POST['password'], $_POST['name'], $_POST['lastname'], $data);
        // Redirection vers la page de connexion après inscription réussie
        header("Location: /annonces/");
        exit();
    } else {
        echo "Login déjà utilisé";
        $vueInscription = new ViewInscription($layout);
        $vueInscription->display();
    }
} elseif ($uri == '/annonces/index.php/create') {
    // Affichage de la page de création d'une nouvelle annonce
    $vueCreatePost = new ViewCreatePost($layout, $presenter);
    $vueCreatePost->display();
} elseif ($uri == '/annonces/index.php/createPost' && isset($_POST['title']) && isset($_POST['body']) && isset($_SESSION['id'])) {
    // Vérification de l'authentification de l'utilisateur
    if ($_SESSION['id']) {
        $controller->createPostAction($_POST['title'], $_POST['body'], $_SESSION['id'], $data, $annoncesCheck);
        // Redirection vers la liste des annonces après création de l'annonce
        header("Location: /annonces/index.php/annonces");
        exit();
    } else {
        // Redirection vers la page de connexion si l'utilisateur n'est pas authentifié
        header("Location: /annonces/");
        exit();
    }
} elseif ($uri == '/annonces/index.php/logout') {
    // Déconnexion de l'utilisateur en détruisant la session
    session_destroy();

    // Redirection vers la page de connexion après la déconnexion
    header("refresh:5;url=/annonces/index.php");
    echo 'Déconnexion réussie (redirection automatique dans 5 secondes)';
    exit();
}

else {
    // Gestion de la page non trouvée
    header('Status: 404 Not Found');
    echo '<html><body><h1>My Page NotFound</h1></body></html>';
}
?>
