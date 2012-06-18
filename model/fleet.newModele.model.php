<?php

if(isset($_POST, $_POST['newNomModele'], $_POST['newCapacite'], $_POST['newFret']))
{
	$nom = $_POST['newNomModele'];
	$nom = $nom != '' ? $nom : NULL; // On met à NULL si la chaîne est vide
	// On récupère les autres variables
	$capacite = $_POST['newCapacite'];
	$fret = $_POST['newFret'];

	if(isset($nom))
	{
		try 
		{
			//Commencer une transaction
			$bdd->beginTransaction();
			
			$newVille = $bdd->prepare("INSERT INTO modele(id, nom, capacite_fret, capacite_voyageur) VALUES (nextval('modele_id_seq'), :nom, :fret, :capacite);");
			$r = $newVille->execute(array(":nom" => $nom, ":fret" => $fret, ":capacite" => $capacite));
			
			if($r)
				$commit = true;
			else
				$commit = false;
			
			if($commit) // 1 ligne a été ajoutée
			{				
				$bdd->commit();
				$success[] = "Nouveau modèle (".$nom.") ajoutée avec succès.";
				}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de l'ajout du modèle";
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
	$infos[] = "Aucune information reçue. Aucun modèle ajouté.";
