<?php

if(isset($_POST['delAvionId']) && is_numeric($_POST['delAvionId']))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$idAvion = $_POST['delAvionId'];
		
		
		$deleteAvion = $bdd->prepare("DELETE FROM avion WHERE id = :idAvion");
		$r = $deleteAvion->execute(array(":idAvion" => $idAvion));
		$c = $deleteAvion->rowCount();
		
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