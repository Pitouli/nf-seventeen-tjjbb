<?php

if(isset($_POST, $_POST['newAeroport']))
{
	// On convertit nom en majuscule
	$nom = mb_strtoupper(trim($_POST['newAeroport']), 'UTF-8');
	$nom = $nom != '' ? $nom : NULL; // On met � NULL si la cha�ne est vide

	//on recupere la ville
	$id_ville= $_POST['ville'];

	if(isset($nom) && isset($id_ville))
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
			
			if($commit) // 1 ligne a �t� ajout�e
			{				
				$bdd->commit();
				$success[] = "Nouvel aeroport (".$nom.") ajout�e avec succ�s.";
				}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de l'ajout de l'aeroport";
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
	$infos[] = "Aucune information re�ue. Aucun aeroport ajout�.";
