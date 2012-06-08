<?php  

// On supprime les cookies pseudo et mot de passe
setcookie('pseudo', '',1,'/'); 
setcookie('password', '',1,'/'); 

// Réinitialisation du tableau de session
// On le vide intégralement
$_SESSION = array();

// Destruction de la session
session_destroy();

$success[] = "La déconnexion s'est bien effectuée";