<?php

$bdd = new BDD('admin'); // On cr�e directement un objet PDO

// Model qui comporte du code commun � tous les panneaux d'administrations
require DIR_MODEL.'admin.model.php'; 

// Model qui g�re la s�curit�
require DIR_MODEL.'admin.security.model.php'; 

if($_SESSION['usr_status'] == 'admin')
{
	// Si une section est specifi�, on regarde s'il existe
	if (!empty($getSection)) {
	
		$controllerFile = DIR_CONTROLLER.'admin.'.$getSection.'.controller.php';
		
		// Si le contr�leur existe, on l'inclus
		if (is_file($controllerFile)) {
	
			require $controllerFile;
	
		// Sinon, on inclus le controlleur apr defaut
		} else {
	
			require DIR_MODEL.'admin.default.model.php';
			require DIR_VIEW.'admin.default.view.php';
			
		}
	
	// Module non specifi� ou invalide ? On affiche la page d'accueil !
	} else {
	
		require DIR_MODEL.'admin.default.model.php';
		require DIR_VIEW.'admin.default.view.php';
	}
}
else
{
	require DIR_VIEW.'admin.security.view.php';
}