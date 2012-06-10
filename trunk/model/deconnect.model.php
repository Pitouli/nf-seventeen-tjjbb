<?php  

// On supprime le cookie mot de passe
setcookie('password', '',1,'/'); 

// Réinitialisation du tableau de session

// On sauvegarde le nb d'essais de connexion
$connection_tried = $_SESSION['tried'];

// On le vide intégralement
$_SESSION = array();

// Destruction de la session
session_destroy();

// On rappelle le nombre d'essais
$_SESSION['tried'] = $connection_tried;

$success[] = "La déconnexion s'est bien effectuée";