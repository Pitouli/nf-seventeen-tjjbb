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
			
			$n = $bdd->exec("INSERT INTO ville(id, nom) VALUES (nextval('ville_id_seq'),"&nom");");
			
			if($n == 1) // 1 ligne a été ajoutée
			{				
				$bdd->commit();
				$success[] = "Nouvelle ville ("$nom") ajoutée avec succès.";
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
