<?php

if(isset($_POST, $_POST['modele']))
{
	$idModele = $_POST['modele'];
	

	if(isset($idModele))
	{
		try 
		{
			//Commencer une transaction
			$bdd->beginTransaction();
			
			$newAvion = $bdd->prepare("INSERT INTO avion(id, id_modele) VALUES (nextval('avion_id_seq'), :idModele);");
			$r = $newVille->execute(array(":idModele" ==> $idModele));
			
			if($r)
				$commit = true;
			else
				$commit = false;
			
			if($commit) // 1 ligne a été ajoutée
			{				
				$bdd->commit();
				$success[] = "Nouvel avion ajouté avec succès.";	// Pas de nom :'(
				}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de l'ajout de l'avion";
			}
		} 
		catch (PDOException $e)  //Gestion des erreurs causées par les requêtes PDO
		{
			//Annuler la transaction
			if($bdd) $bdd->rollBack();
			
			//Afficher l'erreur
			$errors[] = "Échec : " . $e->getMessage();
		}
	}
}
else
	$infos[] = "Aucune information reçue. Aucun avion ajouté.";
