<?php 

function empty_folder($folder){ 

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
} 
	
empty_folder(DIR_IMPORT);

// On ajoute les infos dans le journal de bord
$event = new Event;
$event->setType('vidangeStock');
$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);

if(!$errors) 
{
	// On fait une annonce sur la page
	$success[] = "Le dossier d'importation a été vidé.";
	
	$event->setDescription("Le dossier d'importation a été vidé.");
	$event->setSuccess(1);
	$event->save();
}
else
{
	$event->setDescription(count($errors)." erreur(s) lors de la vidange du dossier d'importation.");
	$event->setSuccess(0);
	$event->save();	
}