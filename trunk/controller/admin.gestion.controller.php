<?php

// Si une section est specifié, on regarde s'il existe
if (!empty($getSSection)) {

	$controllerFile = DIR_CONTROLLER.'admin.gestion.'.$getSSection.'.controller.php';
	
	// Si le contrôleur existe, on l'inclus
	if (is_file($controllerFile)) {

		require $controllerFile;

	}
	else {
		require(DIR_ERRORS.'404.php');
		exit();		
	}
}
else {
	require(DIR_ERRORS.'404.php');
	exit();		
}