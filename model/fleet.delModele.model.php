<?php

if(isset($_POST['delModeleId']) && is_numeric($_POST['delModeleId']))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$idModele = $_POST['delModeleId'];
		
		
		$deleteModele = $bdd->prepare("DELETE FROM modele WHERE id = :idModele");
		$r = $deleteModele->execute(array(":idModele" => $idModele));
		$c = $deleteModele->rowCount();
		
		if($r)
		{
			$bdd->commit();
			if($c > 0)
				$success[] = "La suppression a réussi.";			
			else
				$infos[] = "Le modèle était déjà supprimé.";
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
	$infos[] = "L'identifiant du modèle à supprimer n'est pas valable.";