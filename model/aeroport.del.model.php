<?php

if(isset($_POST['delId']) && is_numeric($_POST['delId']))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$id_aeroport = $_POST['delId'];
		
		$deleteAeroport = $bdd->prepare("DELETE FROM aeroport WHERE id = :id");
		$r1 = $deleteAeroport->execute(array(":id" => $id_aeroport));
		$c = $deleteAeroport->rowCount();
		
		if($r1)
		{
			$bdd->commit();
			
			if($c > 0)
				$success[] = "La suppression a réussi.";			
			else
				$infos[] = "L'aeroport était déjà supprimé.";
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
	$infos[] = "L'identifiant de l'aeroport à supprimer n'est pas valable.";