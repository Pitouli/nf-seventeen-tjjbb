<?php

if(isset($_POST, $_POST['newVille']))
{
	// On convertit nom en majuscule
	$nom = mb_strtoupper(trim($_POST['newVille']), 'UTF-8');
	$nom = $nom != '' ? $nom : NULL; // On met � NULL si la cha�ne est vide

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
			
			if($commit) // 1 ligne a �t� ajout�e
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
		catch (PDOException $e)  //Gestion des erreurs caus�es par les requ�tes PDO
		{
			//Annuler la transaction
			if($bdd) $bdd->rollBack();
			
			//Afficher l'erreur
			$errors[] = "�chec : " . $e->getMessage();
		}
	}
}
else
	$infos[] = "Aucune information re�ue. Aucune nouvelle ville n'a �t� ajout�e.";
	
require DIR_MODEL.'places.model.php';
