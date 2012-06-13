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
			
			$n = $bdd->exec("INSERT INTO ville(id, nom) VALUES (nextval('ville_id_seq'),"&nom");");
			
			if($n == 1) // 1 ligne a �t� ajout�e
			{				
				$bdd->commit();
				$success[] = "Nouvelle ville ("$nom") ajout�e avec succ�s.";
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
