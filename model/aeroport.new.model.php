<?php

if(isset($_POST, $_POST['newAeroport']))
{
	// On convertit nom en majuscule
	$nom = mb_strtoupper(trim($_POST['newAeroport']), 'UTF-8');
	$nom = $nom != '' ? $nom : NULL; // On met à NULL si la chaîne est vide

	//on recupere la ville
	$id_ville=

	if(isset($nom) && isset(&id_ville))
	{
		try 
		{
			//Commencer une transaction
			$bdd->beginTransaction();
			
			$newVille = $bdd->prepare("INSERT INTO aeroport(id, nom, id_ville) VALUES (nextval('ville_id_seq'), :nom, :id_ville);");
			$r = $newVille->execute(array(":nom" => $nom, ":id_ville"=> $id_ville));
			
			if($r)
				$commit = true;
			else
				$commit = false;
			
			if($commit) // 1 ligne a été ajoutée
			{				
				$bdd->commit();
				$success[] = "Nouvel aeroport (".$nom.") ajoutée avec succès.";
				}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de l'ajout de la ville.";
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
	$infos[] = "Aucune information reçue. Aucune nouvelle ville n'a été ajoutée.";
