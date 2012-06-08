<?php 

function empty_folder($folder){ 

	$errors = array();

	$d = dir($folder); 
	
	while (false !== ($entry = $d->read())) { 
		
		$isdir = is_dir($folder."/".$entry); 
		
		if (!$isdir and $entry!="." and $entry!="..") { 
		
			if(!unlink($folder."/".$entry)) $errors[] = "Erreur lors de la suppression du fichier ".$entry; 
		
		} elseif ($isdir  and $entry!="." and $entry!="..") { 
		
			empty_folder($folder."/".$entry); 
		
			if(!rmdir($folder."/".$entry)) $errors[] = "Erreur lors de la suppression du dossier ".$entry;
		
		} 
	} 
	
	$d->close(); 
	
	return $errors;
} 
	
$errors_vidange = empty_folder(DIR_CACHE_PAGES_GALLERY);

if($errors_vidange)
{
	// On ajoute les infos dans le journal de bord
	$event = new Event;
	$event->setType('vidangeCache');
	
	if(isset($_SESSION['usr_pseudo'])) $event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
	else $event->setAuthor('cron');

	$event->setDescription(count($errors_vidange)." erreur(s) lors de la vidange du cache des albums de la galerie");
	$event->setSuccess(0);
	$event->save();	
}