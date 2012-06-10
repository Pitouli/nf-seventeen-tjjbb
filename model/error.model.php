<?php 

$error = $getSection;

$pageTitle = 'Erreur '.$error;

$description = '<p>';

switch($error){
	case 403:
		header('HTTP/1.1 403 Forbidden');
		$description .= 'L\'accès à cette ressource ne vous est pas autorisé.';
		break;
	case 404:
	 	header("HTTP/1.0 404 Not Found");
		$description .= 'La page demandée est introuvable : elle a peut être été déplacée ou supprimée du serveur.';
		break;
	case 500:
		header('HTTP/1.1 500 Internal Server Error');
		$description .= 'Le serveur a eu un problème. Nous espérons le régler le plus vite possible.';
		break;
	default: 
		$description .= 'Une erreur inconnue est apparue.';
}

$description .= '</p><p>Nous nous excusons de la gêne occasionée. Veuillez retourner à l\'accueil.';	