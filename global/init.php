<?php

// Inclusion du fichier de configuration (qui définit des constantes)
include 'global/config.php';

// Désactivation des guillemets magiques (sur OVH, il suffit de faire un fichier htaccess)
/*ini_set('magic_quotes_runtime', 0);

if (1 == get_magic_quotes_gpc())
{
	function remove_magic_quotes_gpc(&$value) {
	
		$value = stripslashes($value);
	}
	array_walk_recursive($_GET, 'remove_magic_quotes_gpc');
	array_walk_recursive($_POST, 'remove_magic_quotes_gpc');
	array_walk_recursive($_COOKIE, 'remove_magic_quotes_gpc');
}*/

// On met en place un système de chargement automatique des classes
function loadClass ($class)
	{
		require DIR_CLASS.$class.'.class.php'; // On inclue la classe correspondante au paramètre passé
	}
spl_autoload_register ('loadClass'); // On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera une classe non déclarée

//$chrono = new Chrono; // On crée un objet de chronométrage

session_start(); // On démarre la session

$bdd = new BDD; // On crée directement un objet PDO