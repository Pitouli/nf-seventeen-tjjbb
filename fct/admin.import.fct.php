<?php 

//////////////////////////////////////////////////////////////////////////////////////////
//								 VARIABLES GLOBAL										//
// On dresse la liste des variables qui seront utilisées dans les différentes fonctions //
//////////////////////////////////////////////////////////////////////////////////////////

$str = new String(); // Un objet avec lequel on va pouvoir créer nos noms "webifiés"

$sql = "UPDATE albums SET updated = :date, description = :description WHERE id_parent= :id_parent AND web_title= :web_title";
$updateAlbum = $bdd->prepare($sql);

$sql = "INSERT INTO albums SET title = :title, web_title = :web_title, id_parent = :id_parent, created = :date, updated = :date, description = :description";
$insertAlbum = $bdd->prepare($sql);

///////////////////////////////////////////////////////////////////////////////////////////

function addAlbumInBDD($title, $id_parent, $description = NULL) {
	
	// note : $bdd est un objet correpondant à la base de donnée ; $updateAlbum et $insertAlbum sont des objets pdo préparés
	global $bdd, $updateAlbum, $insertAlbum, $str, $nb_albums_created, $nb_albums_updated;
	
	$date = date('Y-m-d');
	
	$str->setStr($title);
	$web_title = $str->getWebify();
	$web_title = substr($web_title, 0, 50);
	
	// On compte le nombre d'album portant le même titre dans l'album parent
	$nb = $bdd->getNbRow('albums', 'id_parent="'.$id_parent.'" AND web_title="'.$web_title.'"');
	
	// Si l'album existe déja
	if($nb>=1) {
		// On met à jour
		$updateAlbum->execute(array(':date' => $date, ':description' => $description, ':id_parent' => $id_parent, ':web_title' => $web_title));
		// Et on récupère son id pour pouvoir ajouter les nouvelles photos
    	$id_album = $bdd->getId('albums', 'id_parent="'.$id_parent.'" AND web_title="'.$web_title.'"');
		
		$nb_albums_updated++;
	}
	// Si l'album n'existe pas
	else {
		// On le crée
		$insertAlbum->execute(array(':date' => $date, ':description' => $description, ':id_parent' => $id_parent, ':title' => htmlspecialchars($title), ':web_title' => $web_title));
		// Et on récupère son id pour pouvoir ajouter les nouvelles photos
		$id_album = $bdd->lastInsertId();
		
		$nb_albums_created++;
	}
	
	return $id_album;
}

function addPhotoInBDD($collected)
{
	// note : $bdd est un objet correpondant à la base de donnée
	global $bdd;	
	
	$sql = "INSERT INTO photos SET id_album = :id_album, folder = :folder, webname = :webname, extension = :extension,  title = :title, web_title = :web_title, uploaded = :uploaded, hd_token = :hd_token, id_price = :id_price, size = :size, status = :status";
	$insertPhoto = $bdd->prepare($sql);

	foreach ($collected as $photo)
	{
		$insertPhoto->execute(array(':id_album' => $photo['id_album'], ':folder' => $photo['folder'], ':webname' => $photo['webname'], ':extension' => $photo['extension'], ':title' => $photo['title'], ':web_title' => $photo['web_title'], ':uploaded' => $photo['uploaded'], ':hd_token' => $photo['hd_token'], ':id_price' => $photo['id_price'], ':size' => $photo['size'], ':status' => $photo['status']));
	}
}

function addAttachmentsInBDD($collected)
{
	// note : $bdd est un objet correpondant à la base de donnée
	global $bdd;	
	
	$sql = "INSERT INTO attachments SET id_album = :id_album, webname = :webname, extension = :extension,  title = :title, web_title = :web_title, uploaded = :uploaded, size = :size, status = :status";
	$insertAttachment = $bdd->prepare($sql);

	foreach ($collected as $attachment)
	{
		$insertAttachment->execute(array(':id_album' => $attachment['id_album'], ':webname' => $attachment['webname'], ':extension' => $attachment['extension'], ':title' => $attachment['title'], ':web_title' => $attachment['web_title'], ':uploaded' => $attachment['uploaded'], ':size' => $attachment['size'], ':status' => $attachment['status']));
	}
}

function collect($directory, $id_parent = 0, $array = array(), $parent = '')
{
	global $ext_photo, $ext_attachment, $id_price, $dossier_stockage, $nb_files_imported; // On récupère les variables communes
	global $str; // On récupère l'objet qui nous permet de travailler des chaines
	
	$directory = realpath($directory);
	$d = dir($directory);
	
	// Tant qu'il y a des fichiers
	while (false !== ($file = $d->read()))
	{
		// Si le fichier est un dossier
		if (is_dir(realpath($directory . '/' . $file)))
		{
			// Si ce n'est pas un élément de navigation
			if ($file != '.' && $file != '..')
			{			
				//  On ajoute l'album dans la base de donnée
				$id_album = addAlbumInBDD($file, $id_parent);

				// On réexecute la collecte pour ce dossier
				$array = collect($directory . '/' . $file, $id_album, $array, $file);
				// On efface le dossier quand on l'a vidé de ses fichiers
				@rmdir($directory . '/' . $file);
			}
		}
		// Si le fichier n'est pas un dossier et que l'on arrive à récupérer une extension
		elseif (preg_match('#(\.[a-zA-Z0-9]+)$#', $file, $matches))
		{
			$file_ext = strtolower($matches[1]);
			
			// Si l'extension est dans l'array des extensions autorisées
			if (in_array($file_ext, $ext_photo))
			{
				// On crée un identifiant unique
				$webname = uniqid();
				$newname = DIR_STOCKAGE . $webname;
				// Si on a réussi à déplacer le fichier
				if (rename($directory . '/' . $file, $newname))
				{
					$title = basename($file, $file_ext); // On supprime l'extension
					
					$str->setStr($title);
					$web_title = $str->getWebify();
					$web_title = substr($web_title, 0, 50);
					
					$hd_token = $str->getGenerate(5, 'alphanum');
					
					$folder = $str->getGenerate(1, 'alpha').'/'.$str->getGenerate(1, 'alpha').'/'.$str->getGenerate(1, 'alpha').'/';
					
					$nb_files_imported++;
					
					// On rajoute ses caractéristiques dans l'array
					$array['photos'][] = array(
						'id_album' => $id_parent,
						'title' => htmlspecialchars($title),
						'web_title' => $web_title,
						'webname' => $webname,
						'folder' => $folder,
						'extension' => $file_ext,
						'uploaded' => date('Y-m-d H:i:s'),
						'hd_token' => '_'.$hd_token,
						'id_price' => $id_price,
						'size' => filesize($newname),
						'status' => 'stock'
					);
				}
				else
				{
					$errors[] = "Erreur lors du déplacement de la photo.";
				}
			}
			elseif (in_array($file_ext, $ext_attachment))
			{
				// On crée un identifiant unique
				$webname = uniqid();
				$newname = DIR_ATTACHMENTS . $webname;
				// Si on a réussi à déplacer le fichier
				if (rename($directory . '/' . $file, $newname))
				{
					$title = basename($file, $file_ext); // On supprime l'extension
					
					$str->setStr($title);
					$web_title = $str->getWebify();
					$web_title = substr($web_title, 0, 50);
					
					$nb_files_imported++;
					
					// On rajoute ses caractéristiques dans l'array
					$array['attachments'][] = array(
						'id_album' => $id_parent,
						'title' => htmlspecialchars($title),
						'web_title' => $web_title,
						'webname' => $webname,
						'extension' => $file_ext,
						'uploaded' => date('Y-m-d H:i:s'),
						'size' => filesize($newname),
						'status' => 'visible'
					);
				}
				else
				{
					$errors[] = "Erreur lors du déplacement du fichier joints.";
				}
			}
			// Si le fichier n'est pas un fichier autorisé
			else
			{
				// On supprime le fichier interdit
				@unlink($directory . '/' . $file);
			}
		}
		// Si le fichier on arrive pas à savoir ce que c'est
		else
		{
			// On supprime le fichier
			@unlink($directory . '/' . $file);
		}
	}

	return $array;
}