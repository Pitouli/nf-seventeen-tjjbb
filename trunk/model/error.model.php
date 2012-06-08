<?php 
$error = $getSSection;

$urlBg = ROOT.'style/images/errors/'.$error.'.png';

// On choisit un album aleatoirement
$nbAlbumsVisible = $bdd->getNbRow("albums", "hide=0");
$numAlbum = rand(1,$nbAlbumsVisible-1);

// On fait le lien vers l'album
$recupAlbum = $bdd->query("SELECT id, title, web_title FROM albums WHERE hide=0 LIMIT ".$numAlbum.",1");
$album = $recupAlbum->fetch();
$linkAlbum = ROOT."gallery/".$album['id']."-".$album['web_title'].".html";
$textLink = "Regarder un album au hasard !";

$pageTitle = BROWSER_SITE_TITLE.' - Erreur '.$error;
$title = 'ERREUR '.$error;
$description = 'Erreur '.$error.'</p>';

switch($error){
	case 403:
		header('HTTP/1.1 403 Forbidden');
		$description = 'L\'accès à cette ressource ne vous est pas autorisé.';
		break;
	case 404:
	 	header("HTTP/1.0 404 Not Found");
		$description = 'La page demandée est introuvable : elle a peut être été déplacée ou supprimée du serveur.';
		break;
	case 500:
		header('HTTP/1.1 500 Internal Server Error');
		$description = 'Le serveur a eu un problème. Nous espérons le régler le plus vite possible.';
		break;
	default: 
		$description = 'Une erreur inconnue est apparue.';
}

$description .= '</p><p>Nous nous excusons de la gêne occasionée et vous invitons à reprendre votre navigation à partir d\'un des liens à droite ci-dessous.';	