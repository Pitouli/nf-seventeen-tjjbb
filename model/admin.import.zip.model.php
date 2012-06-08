<?php 

//////////////////////////////////////////////////////////////////////////////////
//							VERIFS DE BASE										//
//////////////////////////////////////////////////////////////////////////////////

(isset($_POST['id_price']) && is_numeric($_POST['id_price']) && $bdd->getNbRow('prices', 'id='.$_POST['id_price']) == 1) ? $id_price = $_POST['id_price'] : $errors[] = "Le prix par défaut n'a pas été correctement défini."; // On défini le prix
(isset($_POST['id_parent']) && is_numeric($_POST['id_parent']) && $bdd->getNbRow('albums', 'id='.$_POST['id_parent']) == 1) ? $id_album_root = $_POST['id_parent'] : $errors[] = "L'album parent n'a pas été correctement défini.";

//////////////////////////////////////////////////////////////////////////////////////////
//							EXTRACTION DE L'ARCHIVE ZIP									//
// On va commencer par extraire le contenu de l'archive zip dans un dossier temporaire  //
//////////////////////////////////////////////////////////////////////////////////////////

if(!isset($errors))
{
	// Si aucun fichier n'a été envoyé
	if(!isset($_FILES['fileZip']))
	{
		$errors[] = "L'archive n\'a pas été envoyée.";
	}
	// Sinon, si un fichier a été envoyé
	else
	{
		//$_FILES['fileZip']['name']     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
		//$_FILES['fileZip']['type']     //Le type du fichier. Par exemple, cela peut être « image/png ».
		//$_FILES['fileZip']['size']     //La taille du fichier en octets.
		//$_FILES['fileZip']['tmp_name'] //L'adresse vers le fichier uploadé dans le répertoire temporaire.
		//$_FILES['fileZip']['error']    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
		
		// Si il y a eu une erreur lors du transfert du fichier
		if ($_FILES['fileZip']['error']  > 0) 
		{
			$errors[] = "Erreur lors du transfert de l'archive.";
			if($_FILES['fileZip']['error']  == UPLOAD_ERR_NO_FILE) $errors[] = 'L\'archive est manquante.';
			if($_FILES['fileZip']['error']  == UPLOAD_ERR_INI_SIZE) $errors[] = 'L\'archive dépasse la taille maximale autorisée par le serveur.';
			if($_FILES['fileZip']['error']  == UPLOAD_ERR_FORM_SIZE) $errors[] = 'L\'archive dépasse la taille maximale autorisée par le formulaire.';
			if($_FILES['fileZip']['error']  == UPLOAD_ERR_PARTIAL) $errors[] = 'L\'archive n\'a été transférée que partiellement.';
		}
		// Sinon, s'il n'y a pas eu d'erreur
		else
		{
			// On crée un objet ZipArchive
			$zip = new ZipArchive;
			
			// Si on a réussi à ouvrir l'archive
			if ($zip->open($_FILES['fileZip']['tmp_name']) === TRUE) 
			{
				$tmp_zip_import_directory = 'ZIPdir_'.uniqid().'/';
				
				// Si on arrive à créer un dossier temporaire pour extraire l'archive zip
				if(mkdir(DIR_IMPORT.$tmp_zip_import_directory)) 
				{
					$zip->extractTo(DIR_IMPORT.$tmp_zip_import_directory);
					$zip->close();
					$success[] = 'L\'archive a bien été décompressée.';					
				}
				else
				{
					$error[] = 'Erreur lors de la création du dossier temporaire d\'importation.';
				}
			} 
			// Si l'ouverture est un échec cuisant
			else {
				$error[] = 'L\'archive n\'a pas pu être ouverte.';
			}
		}
	}
}

//////////////////////////////////////////////////////////////////////////////////
//								IMPORTATION										//
//////////////////////////////////////////////////////////////////////////////////

if(!isset($errors)) 
	{
		$nb_files_imported = 0;
		$nb_albums_created = 0;
		$nb_albums_updated = 0;
		
		// On effectue la collecte des fichiers
		$collected = collect(DIR_IMPORT.$tmp_zip_import_directory, $id_album_root); // On importe
		rmdir(DIR_IMPORT.$tmp_zip_import_directory); // Et on supprime le sous dossier

		// On les rajoute dans la base de donnée
		if(is_array($collected['photos'])) addPhotoInBDD($collected['photos']);
		if(is_array($collected['attachments'])) addAttachmentsInBDD($collected['attachments']);
		
		if($nb_files_imported == 0 && $nb_albums_created == 0 && $nb_albums_updated == 0) 
			{
				$infos[] = "Aucun fichier ou dossier à importer n'a été trouvé.";		
			}
		else 
			{
				$success[] = "L'importation a réussie.";
				$success[] = $nb_files_imported." fichiers ont été importés et seront automatiquement ajoutés dans la galerie.";
				$success[] = $nb_albums_created." albums ont été créés.";
				$success[] = $nb_albums_updated." albums ont été mis à jour.";
				
				// On ajoute les infos dans le journal de bord
				$event = new Event;
				$event->setType('import');
				$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
				$event->setDescription($nb_files_imported." fichier(s) importé(s), ".$nb_albums_created." album(s) créé(s), ".$nb_albums_updated." album(s) mis à jour.");
				$event->setSuccess(1);
				$event->save();
			}
	}