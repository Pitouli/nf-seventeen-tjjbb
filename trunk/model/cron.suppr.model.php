<?php

//////////////////////////////////////
//  SUPPRESSION DES PHOTOS         //
////////////////////////////////////

// On récupère toutes les photos qu'il faut supprimer
$sql = "SELECT id, webname, extension, hd_token, folder FROM photos WHERE status = '2suppr'";
$selectPhotos2suppr = $bdd->prepare($sql);
$selectPhotos2suppr->execute();
$photos2suppr = $selectPhotos2suppr->fetchAll();

// On prépare des requêtes et des variables qui seront utilisées lors de l'exécution du script

$sql = "UPDATE photos SET status='failSuppr' WHERE id=:id";
$updatePhotoFailSuppr = $bdd->prepare($sql);

$sql = "DELETE FROM photos WHERE id=:id";
$deletePhoto = $bdd->prepare($sql);

$nbPhotosSuppr = 0; // On se prépare à compter le nombre de photos supprimées
$nbPhotosFailSuppr = 0; // On se prépare à compter le nombre de photos qui ont eu un échec lors de la suppression

foreach($photos2suppr as $photo) {
	
	// Si on a bien supprimé tous les fichiers
	if(unlink(DIR_PHOTOS_HD.$photo['folder'].$photo['webname'].$photo['hd_token'].$photo['extension'])
		&& unlink(DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension']) 
		&& unlink(DIR_PHOTOS_MIN.$photo['folder'].$photo['webname'].$photo['extension'])) 
	{
		$deletePhoto->execute(array(':id'=>$photo['id'])); // On supprime la ligne dans la BDD
		$nbPhotosSuppr++;		
	}
	else { // La suppression des fichiers n'a pas réussie
		$updatePhotoFailSuppr->execute(array(':id'=>$photo['id'])); // On indique le pb dans la BDD
		$nbPhotosFailSuppr++;
	}
}

//////////////////////////////////////
//  SUPPRESSION DES PIECES JOINTES //
////////////////////////////////////

// On récupère toutes les pièces-jointes qu'il faut supprimer
$sql = "SELECT id, webname FROM attachments WHERE status = '2suppr'";
$selectAttchmt2suppr = $bdd->prepare($sql);
$selectAttchmt2suppr->execute();
$attchmt2suppr = $selectAttchmt2suppr->fetchAll();

// On prépare des requêtes et des variables qui seront utilisées lors de l'exécution du script

$sql = "UPDATE attachments SET status='failSuppr' WHERE id=:id";
$updateAttchmtFailSuppr = $bdd->prepare($sql);

$sql = "DELETE FROM attachments WHERE id=:id";
$deleteAttchmt = $bdd->prepare($sql);

$nbAttchmtSuppr = 0; // On se prépare à compter le nombre de pièces-jointes supprimées
$nbAttchmtFailSuppr = 0; // On se prépare à compter le nombre de pièces'jointes qui ont eu un échec lors de la suppression

foreach($attchmt2suppr as $attchmt) {
	
	// Si on a bien supprimé le fichier
	if(unlink(DIR_ATTACHMENTS.$attchmt['webname'])) 
	{
		$deleteAttchmt->execute(array(':id'=>$attchmt['id'])); // On supprime la ligne dans la BDD
		$nbAttchmtSuppr++;		
	}
	else { // La suppression du fichier n'a pas réussie
		$updateAttchmtFailSuppr->execute(array(':id'=>$attchmt['id'])); // On indique le pb dans la BDD
		$nbAttchmtFailSuppr++;
	}
}

//////////////////////////////////////
//      SUPPRESSION DU CACHE       //
////////////////////////////////////

// On supprime le cache des albums de la galerie

require DIR_MODEL.'admin.cleanCache.model.php';

//////////////////////////////////////
//   MISE A JOUR JOURNAL DE BORD   //
////////////////////////////////////

// On ajoute les infos dans le journal de bord

$event = new Event;
$event->setType('suppr');

if($param->getValue('usr') == 'Admin')
{ 
	echo "La suppression de ".$nbPhotosSuppr." photo(s) a ete effectuee.<br/>";
	echo "La suppression de ".$nbPhotosFailSuppr." photo(s) a ete un echec.<br>";
	echo "La suppression de ".$nbAttchmtSuppr." piece(s) jointe(s) a ete effectuee.<br/>";
	echo "La suppression de ".$nbAttchmtFailSuppr." piece(s) jointe(s) a ete un echec.<br>";
	echo '--- FIN DU SCRIPT ---';
	
	$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
}
else
{
	echo $nbPhotosSuppr." photo(s) et ".$nbAttchmtSuppr." piece(s) jointe(s) supprimees. ".$nbPhotosFailSuppr+$nbAttchmtFailSuppr." erreur(s)";
	
	$event->setAuthor('cron');
}

if($nbPhotosSuppr + $nbAttchmtSuppr >0) {
	$event->setDescription("La suppression de ".$nbPhotosSuppr." photo(s) et ".$nbAttchmtSuppr." pièce(s) jointe(s) a été effectuée.");
	$event->setSuccess(1);
	$event->save();
}
if($nbPhotosFailSuppr + $nbAttchmtFailSuppr >0) {
	$event->setDescription("La suppression de ".$nbPhotosFailSuppr." photo(s) et ".$nbAttchmtSuppr." pièce(s) jointe(s) a été un échec.");
	$event->setSuccess(0);
	$event->save();
}