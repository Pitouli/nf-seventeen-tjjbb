<?php

// On crée l'objet qui va nous permettre de sauvegarder les différents évènements dans le journal

$event = new Event;
$event->setType('checkCron');

// On regarde qui est l'auteur 

if($param->getValue('usr') == 'Admin')
{ 
	$usr = "admin";
	$event->setAuthor('admin:'.$_SESSION['usr_pseudo']);
}
else
{
	$usr = "cron";
	$event->setAuthor('cron');
}

///////////////////////////////////////////////////////////////////////////////////////////
//							GESTION DES CRONS UTILISANT GD								 //
///////////////////////////////////////////////////////////////////////////////////////////

// On fait en sorte de ne pas exécuter en même temps les scripts qui utilisent GD.
// On donne la priorité au cron regeMin par rapport au cron stock2gal

$nbPhotoStocked = $bdd->getNbRow("photos", "status = 'stock'");
$nbPhotoRegeMin = $bdd->getNbRow("photos", "status='regeMinVisible' OR status='regeMinHide' OR status='regeMin2suppr'");

// On regarde si les tâches gérées par Webcron sont actives
$webcron = new WebcronAPI;
$cronStock2galActif = $webcron->getCronActivity('stock2gal');
$cronRegeMinActif = $webcron->getCronActivity('regeMin');

// REGEMIN

if($nbPhotoRegeMin>0) // Si des miniatures sont en attentes de regénération
{
	if($cronRegeMinActif==0) // Si le cron regeMin n'est pas actif
	{
		if($cronStock2galActif==1) // Si le cron stock2gal est actif
		{
			// On le désactive
			$status = $webcron->setCronActivity('stock2gal',0);
			echo 'Desactivation du cron stock2gal (regeMin en cours) : '.$status.' ; ';
			
			if($status == 'ok')	
			{
				$event->setDescription("La tâche stock2gal a été correctement désactivée (regeMin en cours).");
				$event->setSuccess(1);
				$event->save();
				
				$cronStock2galActif = 0; // On indique que le cron stock2gal est désactivé
			}
			else 
			{
				$event->setDescription("La tâche stock2gal n'a pas pu être désactivée. RegeMin n'est donc pas activé.");
				$event->setSuccess(0);
				$event->save();		
			}
		}
		if($cronStock2galActif==0) // Si le cron stock2gal est désactivé (éventuellement après avoir été désactivé dans le if précédent)
		{
			// On peut activer le cron regeMin
			$status = $webcron->setCronActivity('regeMin',1);
			echo 'Activation du cron regeMin : '.$status.' ; ';
					
			if($status == 'ok')	
			{
				$event->setDescription("La tâche regeMin a été correctement activée.");
				$event->setSuccess(1);
				$event->save();
				
				$cronRegeMinActif = 1; // On indique que le cron regeMin est actif
			}
			else 
			{
				$event->setDescription("La tâche regeMin n'a pas pu être activée.");
				$event->setSuccess(0);
				$event->save();		
			}
		}
	}
	else
	{
		echo 'Le cron regeMin est deja actif ; ';	
	}
}
else // S'il n'y a aucune photos en attente de regeMin
{
	if($cronRegeMinActif==1) // Si le cron est actif
	{
		// On le désactive
		$status = $webcron->setCronActivity('regeMin',0);
		echo 'Desactivation du cron regeMin : '.$status.' ; ';
		
		if($status == 'ok')	
		{
			$event->setDescription("La tâche regeMin a été correctement désactivée.");
			$event->setSuccess(1);
			$event->save();
			
			$cronRegeMinActif = 0; // On indique que le cron regeMin est inactif
		}
		else 
		{
			$event->setDescription("La tâche regeMin n'a pas pu être désactivée.");
			$event->setSuccess(0);
			$event->save();		
		}		
	}
	else
	{
		echo 'Le cron regeMin est deja inactif ; ';	
	}
}


// STOCK2GAL

if($cronRegeMinActif==0) // Si regeMin est inactif
{
	if($nbPhotoStocked>0) // s'il y a des photos en stock
	{
		if($cronStock2galActif==0) // Si le cron n'est pas actif
		{
			// On l'active
			$status = $webcron->setCronActivity('stock2gal',1);
			echo 'Activation du cron stock2gal : '.$status.' ; ';
					
			if($status == 'ok')	
			{
				$event->setDescription("La tâche stock2gal a été correctement activée.");
				$event->setSuccess(1);
				$event->save();
			}
			else 
			{
				$event->setDescription("La tâche stock2gal n'a pas pu être activée.");
				$event->setSuccess(0);
				$event->save();		
			}
		}
		else
		{
			echo 'Le cron stock2gal est deja actif ; ';	
		}
	}
	else
	{
		if($cronStock2galActif==1) // Si le cron est actif
		{
			// On le désactive
			$status = $webcron->setCronActivity('stock2gal',0);
			echo 'Desactivation du cron stock2gal : '.$status.' ; ';
			
			if($status == 'ok')	
			{
				$event->setDescription("La tâche stock2gal a été correctement désactivée.");
				$event->setSuccess(1);
				$event->save();
			}
			else 
			{
				$event->setDescription("La tâche stock2gal n'a pas pu être désactivée.");
				$event->setSuccess(0);
				$event->save();		
			}		
		}
		else
		{
			echo 'Le cron stock2gal est deja inactif ; ';	
		}
	}
}
else // Si regeMin est actif
{
	if($cronStock2galActif==1) // Si le cron stock2gal est actif
	{
		// On le désactive
		$status = $webcron->setCronActivity('stock2gal',0);
		echo 'Desactivation du cron stock2gal (regeMin en cours) : '.$status.' ; ';
		
		if($status == 'ok')	
		{
			$event->setDescription("La tâche stock2gal a été correctement désactivée (regeMin en cours).");
			$event->setSuccess(1);
			$event->save();
			
			$cronStock2galActif = 0; // On indique que le cron stock2gal est désactivé
		}
		else 
		{
			$event->setDescription("La tâche stock2gal n'a pas pu être désactivée. Il risque d'y avoir saturation du serveur entre regeMin et stock2gal.");
			$event->setSuccess(0);
			$event->save();		
		}
	}	
}

///////////////////////////////////////////////////////////////////////////////////////////
//								GESTION DU CRON SUPPR   								 //
///////////////////////////////////////////////////////////////////////////////////////////

$nbPhoto2Suppr = $bdd->getNbRow("photos", "status = '2suppr'");
$nbAttchmt2Suppr = $bdd->getNbRow("attachments", "status = '2suppr'");
$nbFiles2Suppr = $nbPhoto2Suppr + $nbAttchmt2Suppr;

// On regarde si les tâches gérées par Webcron sont actives
$webcron = new WebcronAPI;
$cronSupprActif = $webcron->getCronActivity('suppr');

if($nbFiles2Suppr>0)
{
	if($cronSupprActif==0) // Si le cron n'est pas actif
	{
		// On l'active
		$status = $webcron->setCronActivity('suppr',1);
		echo 'Activation du cron suppr : '.$status.' ; ';
		
		if($status == 'ok')	
		{
			$event->setDescription("La tâche suppr a été correctement activée.");
			$event->setSuccess(1);
			$event->save();
		}
		else 
		{
			$event->setDescription("La tâche suppr n'a pas pu être activée.");
			$event->setSuccess(0);
			$event->save();		
		}
	}
	else
	{
		echo 'Le cron suppr est deja actif ; ';
	}
}
else
{
	if($cronSupprActif==1) // Si le cron est actif
	{
		// On le désactive
		$status = $webcron->setCronActivity('suppr',0);
		echo 'Desactivation du cron suppr : '.$status.' ; ';
		
		if($status == 'ok')	
		{
			$event->setDescription("La tâche suppr a été correctement désactivée.");
			$event->setSuccess(1);
			$event->save();
		}
		else 
		{
			$event->setDescription("La tâche suppr n'a pas pu être désactivée.");
			$event->setSuccess(0);
			$event->save();		
		}		
	}
	else
	{
		echo 'Le cron suppr est deja inactif ; ';
	}
}

if($usr=='admin') echo '<br>--- FIN DU SCRIPT ---<br>';