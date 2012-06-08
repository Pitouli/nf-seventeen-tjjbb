<?php 

//////////////////////////////////////////////////////////////////////////////
//						IMPORTATION DES FICHIERS							//
//    On récupère les fichiers après téléchargements et les déplace dans    //
//   dossiers adéquats. En même temps, on rempli un array avec les infos.   //
//////////////////////////////////////////////////////////////////////////////

// Si le formulaire est vide
if(!isset($_POST['id_parent']))
{
	$errors[] = "Aucune données n'a été reçue.";
}
else
{
	// On définit deux variables qui vont nous permettre de compter les fichiers importés
	$nb_photos_imported = 0;
	$nb_attachments_imported = 0;
	
	//////////////////////////////////////////////////////////////////////////////
	//					ON ETUDIE CHACUN DES FICHIER							//
	//////////////////////////////////////////////////////////////////////////////
	
	foreach($_POST['id_parent'] as $i => $id_parent)
	{
		$num = $i+1; // On compte les fichiers à partir de 1 pour els humaines, et 0 pour le serveur
		
		// Si aucun fichier n'a été envoyé
		if(!isset($_FILES['file']))
		{
			$infos[] = "Le fichier ".$num." n'a pas été transféré.";
		}
		// Sinon, si un fichier a été envoyé
		else
		{
			//$_FILES['name'][$i]     //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
			//$_FILES['type'][$i]     //Le type du fichier. Par exemple, cela peut être « image/png ».
			//$_FILES['size'][$i]     //La taille du fichier en octets.
			//$_FILES['tmp_name'][$i] //L'adresse vers le fichier uploadé dans le répertoire temporaire.
			//$_FILES['error'][$i]    //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
			
			// Si il y a eu une erreur lors du transfert du fichier
			if ($_FILES['file']['error'][$i]  > 0) 
			{
				if($_FILES['file']['error'][$i]  == UPLOAD_ERR_NO_FILE) $infos[] = "Le fichier ".$num." n'a pas été reçu.";
				if($_FILES['file']['error'][$i]  == UPLOAD_ERR_INI_SIZE) $errors[] = "Le fichier ".$num." dépasse la taille maximale autorisée par le serveur.";
				if($_FILES['file']['error'][$i]  == UPLOAD_ERR_FORM_SIZE) $errors[] = "Le fichier ".$num." dépasse la taille maximale autorisée par le formulaire.";
				if($_FILES['file']['error'][$i]  == UPLOAD_ERR_PARTIAL) $errors[] = "Le fichier ".$num." n'a été transféré que partiellement.";
			}
			// Sinon, s'il n'y a pas eu d'erreur
			else
			{
				
				//////////////////////////////////////////////////////////////////////////////
				//					ON DETERMINE LE TYPE DU FICHIER							//
				//  On regarde l'extension et on ajout les caractéristiques dans un array   //
				//////////////////////////////////////////////////////////////////////////////

				// Si l'on arrive à récupérer une extension
				if (preg_match('#(\.[a-zA-Z0-9]+)$#', $_FILES['file']['name'][$i], $matches))
				{
					$file_ext = strtolower($matches[1]);
					
					// Si l'extension est dans l'array des extensions autorisées
					if (in_array($file_ext, $ext_photo))
					{
						// On vérifie que le prix et l'album parents a bien été indiqué
						if(isset($_POST['id_price'][$i]) && is_numeric($_POST['id_price'][$i]) && $bdd->getNbRow('prices', 'id='.$_POST['id_price'][$i]) == 1) { 
							$id_price = $_POST['id_price'][$i];
							
						if(isset($_POST['id_parent'][$i]) && is_numeric($_POST['id_parent'][$i]) && $bdd->getNbRow('albums', 'id='.$_POST['id_parent'][$i]) == 1) { 
							$id_parent = $_POST['id_parent'][$i];
								
						// On crée un identifiant unique
						$webname = uniqid();
						$newname = DIR_STOCKAGE . $webname;
						
						// Si on a réussi à déplacer le fichier
						if (rename($_FILES['file']['tmp_name'][$i], $newname))
						{
							$title = basename($_FILES['file']['name'][$i], $file_ext); // On supprime l'extension
							
							$str->setStr($title);
							$web_title = $str->getWebify();
							$web_title = substr($web_title, 0, 50);
							
							$hd_token = $str->getGenerate(5, 'alphanum');
							
							$folder = $str->getGenerate(1, 'alpha').'/'.$str->getGenerate(1, 'alpha').'/'.$str->getGenerate(1, 'alpha').'/';
							
							// On rajoute ses caractéristiques dans l'array
							$info_files['photos'][] = array(
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
							
							$nb_photos_imported++;
						}
						else
						{
							$errors[] = "Erreur lors du déplacement du fichier ".$num." (photo).";
						}
						
						} else { $errors[] = "L'album parent du fichier ".$num." n'a pas été correctement défini."; }
						
						} else { $errors[] = "Le prix du fichier ".$num." n'a pas été correctement défini."; }
					}
					elseif (in_array($file_ext, $ext_attachment))
					{
						// On vérifie que le dossier parent a bien été indiqué
						if(isset($_POST['id_parent'][$i]) AND is_numeric($_POST['id_parent'][$i])) { 
							$id_parent = $_POST['id_parent'][$i];
						
						// On crée un identifiant unique
						$webname = uniqid();
						$newname = DIR_ATTACHMENTS . $webname;
						// Si on a réussi à déplacer le fichier
						if (rename($_FILES['file']['tmp_name'][$i], $newname))
						{
							$title = basename($_FILES['file']['name'][$i], $file_ext); // On supprime l'extension
							
							$str->setStr($title);
							$web_title = $str->getWebify();
							$web_title = substr($web_title, 0, 50);
							
							$nb_files_imported++;
							
							// On rajoute ses caractéristiques dans l'array
							$info_files['attachments'][] = array(
								'id_album' => $id_parent,
								'title' => htmlspecialchars($title),
								'web_title' => $web_title,
								'webname' => $webname,
								'extension' => $file_ext,
								'uploaded' => date('Y-m-d H:i:s'),
								'size' => filesize($newname),
								'status' => 'visible'
							);
							
							$nb_attachments_imported++;
						}
						else
						{
							$errors[] = "Erreur lors du déplacement du fichier ".$num." (pièce jointe).";
						}
						
						} else { $errors[] = "L'album parent du fichier ".$num." n'a pas été correctement défini."; }
					}
					// Si le fichier n'est pas un fichier autorisé
					else
					{
						$errors[] = "Le fichier ".$num." n'est pas dans un format autorisé";
					}
				}
				// Si le fichier on arrive pas à savoir ce que c'est
				else
				{
					$errors[] = "Impossible de déterminer l'extension du fichier ".$num;
				}
			}
		}
	}
}

//////////////////////////////////////////////////////////////////////////////
//						AJOUT A LA BASE DE DONNEE							//
//      On termine l'importation en rajoutant les fichiers dans la BDD      //
//////////////////////////////////////////////////////////////////////////////

if(isset($info_files['photos']) && is_array($info_files['photos'])) addPhotoInBDD($info_files['photos']);
if(isset($info_files['attachments']) && is_array($info_files['attachments'])) addAttachmentsInBDD($info_files['attachments']);

if($nb_photos_imported != 0 || $nb_attachments_imported != 0) 
	{
		$success[] = "L'importation a réussie.";
		$success[] = $nb_photos_imported." photos ont été importées et seront automatiquement ajoutées dans la galerie.";
		$success[] = $nb_attachments_imported." pièce jointes ont été importées.";
			
		// On ajoute les infos dans le journal de bord
		$event = new Event;
		$event->setType('import');
		$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
		$event->setDescription($nb_photos_imported." photo(s) et ".$nb_attachments_imported." pièce(s) jointe(s) importée(s)");
		$event->setSuccess(1);
		$event->save();
	}