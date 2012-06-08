<?php

// Initialisation
require 'global/init.php';

// Début de la tamporisation de sortie
ob_start();

// On récupère les valeurs des arguments passé par la méthode GET
$getController = isset($_GET['controller']) ? $_GET['controller'] : NULL;
$getSection = isset($_GET['section']) ? $_GET['section'] : NULL;
$getSSection = isset($_GET['ssection']) ? $_GET['ssection'] : NULL;
$getSSSection = isset($_GET['sssection']) ? $_GET['sssection'] : NULL;
$getSSSSection = isset($_GET['ssssection']) ? $_GET['ssssection'] : NULL;
$getParam = isset($_GET['param']) ? $_GET['param'] : NULL;
$getOther = isset($_GET['other']) ? $_GET['other'] : NULL;

// On crée un nouvel objet
$param = new GetParam($getParam);

if (empty($getController) OR $getController == 'index') // Si on a pas précisé de controllern ou que c'est l'index
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
		$getSection = 'error';
		$getSSection = 404;
		
		require DIR_CONTROLLER.'default.controller.php';
	}
}

// Fin de la tamporisation de sortie. On affiche tout ce qui a été généré 
$contenu = ob_end_flush();

//$chrono->stop(); // On arrête le chrono
//$chrono->getTime(); // On demande le temps (préciser en argument le type de commentaire : css, html, js ou NULL)

?>