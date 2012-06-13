<?php

if(is_numeric($getSSection))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$id_client = $getSSection;
		
		// Puis on supprime le client lui même (déclenchant des cascades dans toutes les autres tables)
		$deleteClient = $bdd->prepare("DELETE FROM ville WHERE id = :id_ville");
		$r2 = $deleteClient->execute(array(":id_ville" => $id_ville));
		$c = $deleteClient->rowCount();
		
		if($r1 && $r2)
		{
			$bdd->commit();
			
			if($c > 0)
				$success[] = "La suppression a réussi.";			
			else
				$infos[] = "La ville a déjà été supprimée.";
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
	$infos[] = "Ville inconnue.";