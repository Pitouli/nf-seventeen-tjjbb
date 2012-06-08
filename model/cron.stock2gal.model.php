<?php

///////////////////////////////////////////////////////////////////////////////////////////
//								 ELEMENTS GLOBAUX										 //
// On dresse la liste des éléments qui seront utilisés plusieurs fois au cours du script //
///////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM photos WHERE status = 'stock' LIMIT 1";
$selectPhotoInStock = $bdd->prepare($sql);

$sql = "UPDATE photos SET exif = :exif, width = :width, height = :height, status = :status WHERE id = :id";
$updatePhoto = $bdd->prepare($sql);

$sql = "UPDATE photos SET status = :status WHERE id = :id";
$updateStatus = $bdd->prepare($sql);

//$sql = "INSERT INTO photos_exif SET id_photo = :id_photo, focalLength = :focalLength, make = :make, model = :model, exposureTime = :exposureTime, ISOSpeedRatings = :ISOSpeedRatings, dateTimeOriginal= :dateTimeOriginal WHERE id = :id";
//$insertEXIF = $bdd->prepare($sql);

$nbPhotoStocked = $bdd->getNbRow("photos", "status = 'stock'");

function have_enough_time($nb_execution) 
	{
		if($nb_execution == 0) 
			{ 
				return TRUE; 
			}
		else
			{	
				$time_from_start = microtime(TRUE) - CRON_START_TIME;
				$time_by_passage = $time_from_start / $nb_execution;
				$time_remain = CRON_MAX_TIME - $time_from_start;
				
				if($time_remain > 2 * $time_by_passage) 
					{
						return TRUE;
					}
				else 
					{
						return FALSE;
					}
			}
	}

///////////////////////////////////////////////////////////////////////////////////////////
//										 LA BOUCLE										 //
//  On va traiter une photo après l'autre, et faire en sorte que le script dure le plus  // 
//   longtemps possible, sans jamais être hors temps (histoire de ne pas abandonner une  //
// 					une photo qui n'aurait été qu'à moitié transférée)					 //
///////////////////////////////////////////////////////////////////////////////////////////

$nb_execution = 0;
$nbPhotosMoved = 0;
$nbPhotosUnmoved = 0;

while($nbPhotoStocked >= 1) 
{
	if(!have_enough_time($nb_execution)) break;
	
	$nb_execution = $nb_execution+1;
	
	$selectPhotoInStock->execute();
	$photo = $selectPhotoInStock->fetch();
	
	// On precise que le deplacement a commencé
	$updateStatus->execute(array(':status' => 'startMove', ':id' => $photo['id']));
	
	$stock_img = DIR_STOCKAGE.$photo['webname']; // L'adresse de l'image dans son répertoire de stockage avant manipualation et déplacement.

	///////////////////////////////////////////////////////////////////////////////////////////
	//								 	DONNEES EXIF										 //
	///////////////////////////////////////////////////////////////////////////////////////////	
	
//	if(in_array($photo['extension'], array('.jpg', '.jpeg', '.tif', '.tiff'))) // Si fichier Jpeg ou Tiff on peut chercher des données exif
//	{
//		if($exif = exif_read_data($stock_img, EXIF, true)) // Si le fichier $img contient des infos Exif
//		{
//			$exif = 1; // Il y a des données exif			
//
//			foreach ($exif as $key => $section) // On parcourt la première partie du tableau multidimensionnel
//			{       
//				foreach ($section as $name => $value) // On parcourt la seconde partie
//				{
//					$exif_tab[$name] .= $value; // Récupération des valeurs dans le tableau $exif_tab
//				}
//			}
//			
//		if($exif_tab['FocalLength']) { // Si les données de la distance focale existent
//			$exif_tab['FocalLength'] = round($exif_tab['FocalLength'], 0); // j'arrondis la valeur
//			$exif_tab['FocalLength'] = $exif_tab['FocalLength']." mm"; // Je rajoute l'unité millimètre
//		} else { $exif_tab['FocalLength'] = NULL; }
//		
//		if($exif_tab['Make']) // Marque de l'appareil
//			$marque = $exif_tab['Make'];
//		if($exif_tab['Model'])// Modèle de l'appareil
//			$modele = $exif_tab['Model'];
//		if($exif_tab['ExposureTime'])// Vitesse d'obturation
//			$vit_obt = $exif_tab['ExposureTime'];
//		if($exif_tab['ISOSpeedRatings']) // Valeur iso
//			$iso = $exif_tab['ISOSpeedRatings'];
//			
//		if($exif_tab['DateTimeOriginal'])
//			$date = $exif_tab['DateTimeOriginal']; // Date de la prise de vue (heure de l'appareil)
//		
//		// La date est d'un format spécial, on va donc la rendre lisible
//		$date2 = explode(":", current(explode(" ", $date)));
//		$heure = explode(":", end(explode(" ", $date))); // Utile dans le cas où vous souhaitez extraire l'heure
//		$annee = current($date2); // Je lis la valeur courante de date2
//		$mois = next($date2); // Puis la suivante (c'est un tableau)
//		$jour = next($date2); // Puis la suivante			  
//		}
//		else { $exif = 0; } // pas de données exif
//				
//	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	//								 		RECADRAGE										 //
	///////////////////////////////////////////////////////////////////////////////////////////	
	
	$hd_name = $photo['webname'].$photo['hd_token'].$photo['extension'];
	$pict_name = $photo['webname'];
	$pict_ext = $photo['extension'];
	$folder = $photo['folder'];
	 
	if(file_exists($stock_img))
	{
		// Si les dossiers d'arrivée n'existent pas on les crée
		if(!is_dir(DIR_PHOTOS_HD.$folder)) mkdir(DIR_PHOTOS_HD.$folder, 0700, true); 
		if(!is_dir(DIR_PHOTOS_SD.$folder)) mkdir(DIR_PHOTOS_SD.$folder, 0755, true); 
		if(!is_dir(DIR_PHOTOS_MIN.$folder)) mkdir(DIR_PHOTOS_MIN.$folder, 0755, true); 

		if(rename($stock_img, DIR_PHOTOS_HD.$folder.$hd_name)) // Si on a réussi à déplacer la photo dans son répertoire
		{
			$hd_size = getimagesize(DIR_PHOTOS_HD.$folder.$hd_name);
			$width = $hd_size[0];
			$height = $hd_size[1];
			
			// On anticipe le fait que cette étape va mal se passer...
			$updateStatus->execute(array(':status' => 'failGD', ':id' => $photo['id']));
			
			// On fait la version sd
			
			$sd_pict = new Image(DIR_PHOTOS_HD.$folder.$hd_name);
			$sd_pict->biggest_side(PICT_SD_MAX_LENGHT);
			$sd_pict->name($pict_name);
			$sd_pict->dir(DIR_PHOTOS_SD.$folder);
			$sd_pict->quality(PICT_SD_QUALITY);
			$sd_pict->add_image(WATERMARK_SD, 'topright', 15, 15); // source, position (default : topleft), marge verticale (default : 0), marge horizontale (default : 0), opacité (0 transparent à 100 ; default : 100), largeur image a rajouter (default : calcul auto), hauteur image a rajouter (default : calcul auto), type (default : détermination auto)
			$sd_pict->save();
			
			// On fait la version min
			
			$min_pict = new Image(DIR_PHOTOS_HD.$folder.$hd_name);
			if(PICT_MIN_FORMAT == 'ratio') $min_pict->biggest_side(PICT_MIN_LENGHT); // Si on veut une miniature qui respecte le ratio et qui tienne dans un carré de x pixels
			else $min_pict->square_thumb(PICT_MIN_LENGHT); // Si on veut une miniature carrée
			$min_pict->name($pict_name);
			$min_pict->dir(DIR_PHOTOS_MIN.$folder);
			$min_pict->quality(PICT_MIN_QUALITY);
			$min_pict->save();
			
			///////////////////////////////////////////////////////////////////////////////////////////
			//								MISE A JOUR DANS LA BDD									 //
			///////////////////////////////////////////////////////////////////////////////////////////	
			
			if(file_exists(DIR_PHOTOS_MIN.$folder.$pict_name.$pict_ext) && file_exists(DIR_PHOTOS_SD.$folder.$pict_name.$pict_ext)) // Si les nvlles images sont créées
			{
				$updatePhoto->execute(array(':exif' => 0, ':width' => $width, ':height' => $height, ':status' => 'visible', ':id' => $photo['id']));
				
				$nbPhotosMoved++;
			}
			else
			{
				$nbPhotosUnmoved++;		
			}
				
		}
		else // On n'est pas arrivé à déplacer le fichier
		{
			$updateStatus->execute(array(':status' => 'failMove', ':id' => $photo['id']));
			$nbPhotosUnmoved++;
		}
		
	}
	else // Le fichier n'est plus dans le dossier de stockage
	{
		$updateStatus->execute(array(':status' => 'notInStock', ':id' => $photo['id']));
		$nbPhotosUnmoved++;
	}
	
	$nbPhotoStocked--;
			
}

// On supprime le cache des albums de la galerie

require DIR_MODEL.'admin.cleanCache.model.php';

// On rajoute les infos dans le journal de bord, et on affiche plus ou moins de texte à l'écran selon si c'est un humain ou un robot

$event = new Event;
$event->setType('stock2gal');

if($param->getValue('usr') == 'Admin')
{ 
	echo $nbPhotosMoved.' photo(s) deplacee(s)'.'<br>';
	echo 'reste : '.$nbPhotoStocked.' photo(s)<br>';
	echo '--- FIN DU SCRIPT ---';
	
	$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
}
else
{
	echo $nbPhotosMoved." photo(s) deplacee(s)";
	
	$event->setAuthor('cron');
}

if($nbPhotosMoved>0) {
	$event->setDescription("Le déplacement de ".$nbPhotosMoved." photo(s) depuis le stockage vers la galerie a été effectué.");
	$event->setSuccess(1);
	$event->save();
}
if($nbPhotosUnmoved>0) {
	$event->setDescription("Le déplacement de ".$nbPhotosUnmoved." photo(s) depuis le stockage vers la galerie a été un échec.");
	$event->setSuccess(0);
	$event->save();
}