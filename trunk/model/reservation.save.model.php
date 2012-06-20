<?php

if(isset($_POST['reservationPrice'], $_POST['reservationVol'], $_POST['reservationFret']) 
	&& is_numeric($_POST['reservationPrice']) && $_POST['reservationPrice'] > 0
	&& is_numeric($_POST['reservationFret']) && $_POST['reservationFret'] >= 0
	&& is_numeric($getSSection) && $getSSection > 0)
{
	$idClient = $getSSection;
	
	// On récupère les informations sur l'utilisateur
	$selectCatClient = $bdd->prepare("SELECT cat FROM v_client WHERE id_client = :id_client LIMIT 1");
	$selectCatClient->execute(array(":id_client" => $idClient));
	$resultCatClient = $selectCatClient->fetch();
	
	if($resultCatClient['cat'] == 'ENTREPRISE' && $_POST['reservationFret'] == 0)
		$errors[] = "Une entreprise ne peut acheter que des titres de transport de fret.";
	else
	{
		try 
		{
			//Commencer une transaction
			$bdd->beginTransaction();
			
			$insertReservation = $bdd->prepare("INSERT INTO reservation(id, prix) VALUES (nextval('reservation_id_seq'), :price);");
			$r = $insertReservation->execute(array(":price" => $_POST['reservationPrice']));
			$newId = $bdd->lastInsertId('reservation_id_seq');
			
			if($r) // 1 ligne a été ajoutée
			{				
				// On crée le billet ou le titre
				
				if($_POST['reservationFret'] == 0)
				{
					$newBillet = $bdd->prepare("INSERT INTO billet(id_reservation, id_particulier) VALUES (:id_reservation, :id_particulier)");
					$r = $newBillet->execute(array(":id_reservation" => $newId, ":id_particulier" => $idClient));
					
					if($r)
						$commit = true;
					else
						$commit = false;
				}
				else
				{
					$newTitre = $bdd->prepare("INSERT INTO titre(id_reservation, id_client, masse_fret) VALUES  (:id_reservation, :id_client, :masse_fret)");
					$r = $newTitre->execute(array(":id_reservation" => $newId, ":id_client" => $idClient, ":masse_fret" => $_POST['reservationFret']));
					
					if($r)
						$commit = true;
					else
						$commit = false;
				}
				
				// On relis réservation et vols
				
				if($commit) // Si les insertions précédentes se sont bien passées
				{
					$volsID = explode('#', $_POST['reservationVol']);
					
					$insertUtilise = $bdd->prepare("INSERT INTO utilise(id_vol, id_reservation) VALUES (:id_vol, :id_reservation)");
					
					foreach($volsID as $volID)
						if(!$insertUtilise->execute(array(":id_vol" => $volID, ":id_reservation" => $newId))) // Si l'insertion est un échec
							$commit = false; // On ne commit pas
				}
				
				//Valider les requête et arrêter la transaction
				if($commit)
				{
					$bdd->commit();
					$success[] = "Nouvelle réservation (n°".$newId.") ajoutée avec succès.";
				}
				else
				{
					$bdd->rollback();
					$errors[] = "Echec lors de la création de la réservation.";
				}
			}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de l'initialisation de la réservation.";
			}
		} 
		catch (PDOException $e)  //Gestion des erreurs causées par les requêtes PDO
		{
			//Annuler la transaction
			if($bdd) $bdd->rollBack();
			
			//Afficher l'erreur
			$errors[] = "Échec : " . $e->getMessage();
		}	
	}
}
else
	$infos[] = "Tous les champs n'ont pas été correctement remplis.";
