<?php

// Initialisation
require 'global/init.php';

// On récupère les valeurs des arguments passé par la méthode GET
$getController = isset($_GET['c']) ? $_GET['c'] : NULL;
$getSection = isset($_GET['s1']) ? $_GET['s1'] : NULL;
$getSSection = isset($_GET['s2']) ? $_GET['s2'] : NULL;
$getSSSection = isset($_GET['s3']) ? $_GET['s3'] : NULL;
$getSSSSection = isset($_GET['s4']) ? $_GET['s4'] : NULL;
$getParam = isset($_GET['p']) ? $_GET['p'] : NULL;
$getOther = isset($_GET['o']) ? $_GET['o'] : NULL;

// On crée un nouvel objet
$param = new GetParam($getParam);

require DIR_CONTROLLER.'security.controller.php';

// Début de la tamporisation de sortie
ob_start();

if (empty($getController) OR $getController == 'index') // Si on a pas précisé de controller ou que c'est l'index
{
	require DIR_CONTROLLER.'default.controller.php';
}
// Sinon
else
{
	$controllerFile = DIR_CONTROLLER.$getController.'.controller.php';
	
	if (is_file($controllerFile)) // Si le contrôleur existe, on l'inclus
	{
		require $controllerFile;	
	} 
	else // Sinon, on declare une erreur 404
	{
		$getController = 'error';
		$getSection = 404;
		
		require DIR_CONTROLLER.'error.controller.php';
	}
}

// Fin de la tamporisation de sortie. On affiche tout ce qui a été généré 
$contenu = ob_end_flush();

//$chrono->stop(); // On arrête le chrono
//$chrono->getTime(); // On demande le temps (préciser en argument le type de commentaire : css, html, js ou NULL)

?>