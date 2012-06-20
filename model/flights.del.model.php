<?php 
if (isset($_POST['delete']) && is_numeric($_POST['delete']))
{
try 
	{		
		$bdd->beginTransaction();
		
		$id_vol = $_POST['delete'];
		
		$deleteVol = $bdd->prepare("DELETE FROM vol WHERE id = :id");
		$r1 = $deleteVol->execute(array(":id" => $id_vol));
		$c = $deleteVol->rowCount();
		
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
	$infos[] = "L'identifiant du vol à supprimer n'est pas valable.";