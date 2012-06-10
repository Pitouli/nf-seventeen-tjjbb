<?php

$pageTitle = 'Clients';

if($getSection == 'newCustomer')
{
	if(isset($_POST))
	{
		// On convertit nom en majuscule
		$nom = mb_strtoupper(trim($_POST['nom']), 'UTF-8');
		// On convertit prenom en minuscule avec les 1ere lettres accentuées (y compris après un tiret)
		$prenom = str_replace('- ','-',ucwords(str_replace('-','- ',mb_strtolower(trim($_POST['prenom']), 'UTF-8'))));

		try 
		{
			//Commencer une transaction
			$connexion->beginTransaction();
			
			$bdd->query("INSERT INTO client");
			$newId = $bdd->lastInsertId();
			
			if($_POST['statut'] == 'particulier')
			{
				$newParticulier = $bdd->prepare("INSERT INTO particulier(id_client,nom,prenom) VALUES (:id_client, :nom, :prenom)");
				$newParticulier = $bdd->execute(array(":id_client" => newId, ":nom" => $nom, ":prenom" => $prenom));
				$commit = true;
			}
			else if($_POST['statut'] == 'entreprise')
			{
				$newEntreprise = $bdd->prepare("INSERT INTO entreprise(id_client,nom) VALUES (:id_client, :nom)");
				$newParticulier = $bdd->execute(array(":id_client" => newId, ":nom" => $nom));
				$commit = true;
			}
			else
			{
				$commit = false;
				$errors = "Le client est un particulier ou une entreprise ?";
			}
			
			//Valider les requête et arrêter la transaction
			if($commit)
			{
				$connexion->commit();
				$success[] = "Nouveau client ajouté avec succès.";
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
	else
		$infos[] = "Aucune information reçue. Aucun nouveau client n'a été ajouté.";
}