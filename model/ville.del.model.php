<?php

if(is_numeric($getSSection))
{
	try 
	{		
		$bdd->beginTransaction();
		
		$id_ville = $_POST['ville'];
		
		// Puis on supprime le client lui m�me (d�clenchant des cascades dans toutes les autres tables)
		$deleteVille = $bdd->prepare("DELETE FROM ville WHERE id = :id_ville");
		$r2 = $deleteVille->execute(array(":id_ville" => $id_ville['id']));
		$c = $deleteVille->rowCount();
		
		if($r1 && $r2)
		{
			$bdd->commit();
			
			if($c > 0)
				$success[] = "La suppression a r�ussi.";			
			else
				$infos[] = "La ville a d�j� �t� supprim�e.";
		}
		else
		{
			$bdd->rollback();
			$errors[] = "Echec lors de la suppression.";
		}
	} 
	catch (PDOException $e)  //Gestion des erreurs caus�es par les requ�tes PDO
	{		
		//Annulation des requ�tes
		if($bdd) $bdd->rollback();
		
		//Afficher l'erreur
		$errors[] = "�chec : " . $e->getMessage();
	}
}
else
	$infos[] = "Ville inconnue.";