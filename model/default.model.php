<?php 
// On choisit une photo aleatoirement
$nbPhotosVisible = $bdd->getNbRow("photos", "status='visible'");

if($nbPhotosVisible>0)
{
	$numPhoto = rand(0,$nbPhotosVisible-1);
	
	// On récupère la photo
	$recupPhoto = $bdd->query("SELECT * FROM photos WHERE status='visible' LIMIT ".$numPhoto.",1");	
	$photo = $recupPhoto->fetch();
	$urlBg = ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension'];
	
	// On fait le lien vers l'album
	$recupAlbum = $bdd->query("SELECT title, web_title FROM albums WHERE id=".$photo['id_album']." LIMIT 1");
	$album = $recupAlbum->fetch();
	$linkAlbum = ROOT."gallery/".$photo['id_album']."-".$album['web_title'].".html#pict".$photo['id'];
	$textLink = $photo['title'];
}
else
{
	$urlBg = NULL;
	$linkAlbum = ROOT."gallery.html";
	$textLink = "Galerie vide";
}



$pageTitle = SITE_TITLE.' | '.BROWSER_SITE_TITLE;
$title = SITE_TITLE;
$description = SITE_DESCRIPTION;