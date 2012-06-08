<?php 

(isset($_POST['id_price']) && is_numeric($_POST['id_price']) && $bdd->getNbRow('prices', 'id='.$_POST['id_price']) == 1) ? $id_price = $_POST['id_price'] : $errors[] = "Le prix par défaut n'a pas été correctement défini."; // On défini le prix
(isset($_POST['id_parent']) && is_numeric($_POST['id_parent']) && $bdd->getNbRow('albums', 'id='.$_POST['id_parent']) == 1) ? $id_album_root = $_POST['id_parent'] : $errors[] = "L'album parent n'a pas été correctement défini.";

if(!isset($errors)) 
	{
		$nb_files_imported = 0;
		$nb_albums_created = 0;
		$nb_albums_updated = 0;
		
		// On effectue la collecte des fichiers
		$collected = collect(DIR_IMPORT, $id_album_root);
		
		// On les rajoute dans la base de donnée
		if(isset($collected['photos']) && is_array($collected['photos'])) addPhotoInBDD($collected['photos']);
		if(isset($collected['attachments']) && is_array($collected['attachments'])) addAttachmentsInBDD($collected['attachments']);
		
		if($nb_files_imported == 0 && $nb_albums_created == 0 && $nb_albums_updated == 0) 
			{
				$infos[] = "Aucun fichier ou dossier à importer n'a été trouvé.";		
			}
		else 
			{
				$success[] = "L'importation a réussie.";
				$success[] = $nb_files_imported." fichier(s) ont été importé(s) et seront automatiquement ajouté(s) dans la galerie.";
				$success[] = $nb_albums_created." album(s) ont été créé(s).";
				$success[] = $nb_albums_updated." album(s) ont été mis à jour.";
				
				// On ajoute les infos dans le journal de bord
				$event = new Event;
				$event->setType('import');
				$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
				$event->setDescription($nb_files_imported." fichier(s) importé(s), ".$nb_albums_created." album(s) créé(s), ".$nb_albums_updated." album(s) mis à jour.");
				$event->setSuccess(1);
				$event->save();
			}
	}