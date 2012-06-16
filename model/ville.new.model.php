<?php

if(isset($_POST, $_POST['newVille']))
{
	// On convertit nom en majuscule
	$nom = mb_strtoupper(trim($_POST['newVille']), 'UTF-8');
	$nom = $nom != '' ? $nom : NULL; // On met à NULL si la chaîne est vide

	if(isset($nom))
	{
		try 
		{
			//Commencer une transaction
			$bdd->beginTransaction();
			
			$newVille = $bdd->prepare("INSERT INTO ville(id, nom) VALUES (nextval('ville_id_seq'),:nom);");
			$r = $newVille->execute(array(":nom" => $nom));
			
			if($r)
				$commit = true;
			else
				$commit = false;
			
			if($commit) // 1 ligne a été ajoutée
			{				
				$bdd->commit();
				$success[] = "Nouvelle ville (".$nom.") ajoutee avec succes.";
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
	
require DIR_MODEL.'places.model.php';
