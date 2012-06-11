<?php

if(is_numeric($getSSection))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$id_client = $getSSection;
		
		$deleteReservation = $bdd->prepare("DELETE FROM reservation r WHERE r.id IN (SELECT b.id_particulier FROM billet b WHERE b.id_reservation = r.id AND b.id_particulier = :id_client)");
		$r1 = $deleteReservation->execute(array(":id_client" => $id_client));
		
		$deleteClient = $bdd->prepare("DELETE FROM client WHERE id = :id_client");
		$r2 = $deleteClient->execute(array(":id_client" => $id_client));
		$c = $deleteClient->rowCount();
		
		if($r1 && $r2)
		{
			$bdd->commit();
			
			if($c > 0)
				$success[] = "La suppression a réussi.";			
			else
				$infos[] = "Le client était déjà supprimé.";
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
	$infos[] = "L'identifiant du client à supprimer n'est pas valable.";