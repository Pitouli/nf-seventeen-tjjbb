<?php

if(isset($_POST['ville']))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$id_ville = $_POST['ville'];
		
		// Puis on supprime le client lui même (déclenchant des cascades dans toutes les autres tables)
		$deleteVille = $bdd->prepare("DELETE FROM ville WHERE id = :id_ville");
		$r2 = $deleteVille->execute(array(":id_ville" => $id_ville));
		$c = $deleteVille->rowCount();
		
		if($r2)
		{
			$bdd->commit();
			
			if($c > 0)
				$success[] = "La suppression a reussi.";			
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