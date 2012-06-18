<?php

if(isset($_POST['delAvionId']) && is_numeric($_POST['delAvionId']))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$idAvion = $_POST['delAvionId'];
		
		/*
		// On commence par supprimer les réservations faites par le client (le système de CASCADE aurait seulement supprimé les billets, et pas les réservations)
		$deleteReservation = $bdd->prepare("DELETE FROM reservation r WHERE r.id IN (SELECT b.id_particulier FROM billet b WHERE b.id_reservation = r.id AND b.id_particulier = :id_client)");
		$r1 = $deleteReservation->execute(array(":id_client" => $id_client));
		
		// Puis on supprime le client lui même (déclenchant des cascades dans toutes les autres tables)
		$deleteClient = $bdd->prepare("DELETE FROM client WHERE id = :id_client");
		$r2 = $deleteClient->execute(array(":id_client" => $id_client));
		$c = $deleteClient->rowCount();
		*/
		
		// Que faut-il supprimer dans la cascade?
		
		$deleteAvion = $bdd->prepare("DELETE FROM avion WHERE id = :idAvion");
		$r = deleteAvion->execute(array(":idAvion" => $idAvion));
		$c = deleteAvion->rowCount();
		
		if($r)
		{
			$bdd->commit();
			if($c > 0)
				$success[] = "La suppression a réussi.";			
			else
				$infos[] = "L'avion était déjà supprimé.";
		}
		else
		{
			$bdd->rollback();
			$errors[] = "Echec lors de la suppression.";
		}
	} 
	catch (PDOException $e)  //Gestion des erreurs causées par les requêtes PDO
	{		
		//Annulation des requêtes
		if($bdd) $bdd->rollback();
		
		//Afficher l'erreur
		$errors[] = "Échec : " . $e->getMessage();
	}
}
else
	$infos[] = "L'identifiant de l'avion à supprimer n'est pas valable.";