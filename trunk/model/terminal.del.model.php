<?php

if(isset($_POST['delId']))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$id = $_POST['delId'];
		
		// Puis on supprime le client lui même (déclenchant des cascades dans toutes les autres tables)
		$deleteVille = $bdd->prepare("DELETE FROM terminal WHERE id = :id");
		$r = $deleteVille->execute(array(":id" => $id));
		$c = $deleteVille->rowCount();
		
		if($r)
		{
			$bdd->commit();
			
			if($c > 0)
				$success[] = "La suppression du terminal a reussi.";			
			else
				$infos[] = "Le terminal a déjà été supprimé.";
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
	$infos[] = "Terminal inconnu.";