<?php

/* INTRODUCTION

Pour regénérer toutes les miniatures des photos déjà présentes dans la galerie 
(si par exemple on veut des miniatures qui conservent le ratio alors qu'elles étaient carrées
ou carrées alors qu'elles conservaient le ratio -- voir fichier config pour ce réglage)
il est nécessaire de mettre à jour la BDD pour indiquer quelles sont les photos dont la 
miniature doit être regénérée.

Pour regénérer toutes les miniatures des photos visibles, masquées et à supprimer, 
lancer ce code sql.

UPDATE photos SET status = 'regeMinVisible' WHERE status = 'visible';
UPDATE photos SET status = 'regeMinHide' WHERE status = 'hide';
UPDATE photos SET status = 'regeMin2suppr' WHERE status = '2suppr';

*/

///////////////////////////////////////////////////////////////////////////////////////////
//								 ELEMENTS GLOBAUX										 //
// On dresse la liste des éléments qui seront utilisés plusieurs fois au cours du script //
///////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM photos WHERE status = 'regeMinVisible' OR status = 'regeMinHide' OR status = 'regeMin2suppr' LIMIT 1";
$selectPhotoRegeMin = $bdd->prepare($sql);

$sql = "UPDATE photos SET status = :status WHERE id = :id";
$updateStatus = $bdd->prepare($sql);

$nbPhotoRegeMin = $bdd->getNbRow("photos", "status = 'regeMinVisible' OR status = 'regeMinHide' OR status = 'regeMin2suppr'");

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
				
				if($time_remain > 3 * $time_by_passage) 
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
$nbPhotosRegeMinDone = 0;
$nbPhotosRegeMinFail = 0;

while($nbPhotoRegeMin >= 1) 
{
	if(!have_enough_time($nb_execution)) break;
	
	$nb_execution = $nb_execution+1;
	
	$selectPhotoRegeMin->execute();
	$photo = $selectPhotoRegeMin->fetch();
	
	$updateStatus->execute(array(':status' => 'regeMinStart', ':id' => $photo['id']));
		
	///////////////////////////////////////////////////////////////////////////////////////////
	//								 		RECADRAGE										 //
	///////////////////////////////////////////////////////////////////////////////////////////	
	
	$hd_name = $photo['webname'].$photo['hd_token'].$photo['extension'];
	$pict_name = $photo['webname'];
	$pict_ext = $photo['extension'];
	$folder = $photo['folder'];
	
	$hd_img = DIR_PHOTOS_HD.$folder.$hd_name; // L'adresse de l'image HD
	 
	if(file_exists($hd_img))
	{
		// Si le dossier d'arrivée n'existe pas on les crée
		if(!is_dir(DIR_PHOTOS_MIN.$folder)) mkdir(DIR_PHOTOS_MIN.$folder, 0755, true); 

		// On anticipe le fait que cette étape va mal se passer...
		$updateStatus->execute(array(':status' => 'regeMinFailGD', ':id' => $photo['id']));

		// On fait la version min
		
		$min_pict = new Image($hd_img);
		if(PICT_MIN_FORMAT == 'ratio') $min_pict->biggest_side(PICT_MIN_LENGHT); // Si on veut une miniature qui respecte le ratio et qui tienne dans un carré de x pixels
		else $min_pict->square_thumb(PICT_MIN_LENGHT); // Si on veut une miniature carrée
		$min_pict->name($pict_name);
		$min_pict->dir(DIR_PHOTOS_MIN.$folder);
		$min_pict->quality(PICT_MIN_QUALITY);
		$min_pict->save();
		
		///////////////////////////////////////////////////////////////////////////////////////////
		//								MISE A JOUR DANS LA BDD									 //
		///////////////////////////////////////////////////////////////////////////////////////////	

		if(file_exists(DIR_PHOTOS_MIN.$folder.$pict_name.$pict_ext)) // Si la nouvelle miniature est créée
		{
			if($photo['status'] == 'regeMinHide') $updateStatus->execute(array(':status' => 'hide', ':id' => $photo['id']));
			else if($photo['status'] == 'regeMin2suppr') $updateStatus->execute(array(':status' => '2suppr', ':id' => $photo['id']));
			else $updateStatus->execute(array(':status' => 'visible', ':id' => $photo['id']));			
			
			$nbPhotosRegeMinDone++;
		}
		else
		{
			$nbPhotosRegeMinFail++;	
		}		

	}
	else // Le fichier HD n'existe pas
	{
		$updateStatus->execute(array(':status' => 'regeMinNoHD', ':id' => $photo['id']));
		$nbPhotosRegeMinFail++;
	}
	
	$nbPhotoRegeMin--;
			
}

// On supprime le cache des albums de la galerie

require DIR_MODEL.'admin.cleanCache.model.php';

// On rajoute les infos dans le journal de bord, et on affiche plus ou moins de texte à l'écran selon si c'est un humain ou un robot

$event = new Event;
$event->setType('regeMin');

if($param->getValue('usr') == 'Admin')
{ 
	echo $nbPhotosRegeMinDone.' miniature(s) regeneree(s)'.'<br>';
	echo 'reste : '.$nbPhotoRegeMin.' miniature(s)<br>';
	echo '--- FIN DU SCRIPT ---';
	
	$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
}
else
{
	echo $nbPhotosRegeMinDone." miniature(s) regeneree(s)";
	
	$event->setAuthor('cron');
}

if($nbPhotosRegeMinDone>0) {
	$event->setDescription("La regénération de ".$nbPhotosRegeMinDone." miniature(s) a été effectué.");
	$event->setSuccess(1);
	$event->save();
}
if($nbPhotosRegeMinFail>0) {
	$event->setDescription("La regénération de ".$nbPhotosRegeMinFail." miniature(s) a été un échec.");
	$event->setSuccess(0);
	$event->save();
}