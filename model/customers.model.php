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
			$bdd->beginTransaction();
			
			$bdd->query("INSERT INTO client VALUES()");
			$newId = $bdd->lastInsertId('client_id_seq');
			
			if($_POST['statut'] == 'particulier')
			{
				$newParticulier = $bdd->prepare("INSERT INTO particulier(id_client,nom,prenom) VALUES (:id_client, :nom, :prenom)");
				$newParticulier->execute(array(":id_client" => $newId, ":nom" => $nom, ":prenom" => $prenom));
				$commit = true;
			}
			else if($_POST['statut'] == 'entreprise')
			{
				$newEntreprise = $bdd->prepare("INSERT INTO entreprise(id_client,nom) VALUES (:id_client, :nom)");
				$newEntreprise->execute(array(":id_client" => $newId, ":nom" => $nom));
				$commit = true;
			}
			else
			{
				$commit = false;
				$errors[] = "Le client est un particulier ou une entreprise ?";
			}
			
			//Valider les requête et arrêter la transaction
			if($commit)
			{
				$bdd->commit();
				$success[] = "Nouveau client (n°".$newId.") ajouté avec succès.";
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
else if($getSection == 'searchCustomer')
{
	if(isset($_POST))
	{
		// On convertit nom en majuscule
		$nom = trim($_POST['nom']);
		// On convertit prenom en minuscule avec les 1ere lettres accentuées (y compris après un tiret)
		$prenom = trim($_POST['prenom']);
		
		$bdd->query("INSERT INTO client");
		$newId = $bdd->lastInsertId('client_id_seq');
		
		$resultParticulier = array();
		$resultEntreprise = array();
		
		echo 'plop';
		
		if(isset($_POST['particulier']))
		{
			echo 'plip';
			
			$selectParticulier = $bdd->query("SELECT * FROM particulier");
			//$selectParticulier->execute(array());
			$resultParticulier = $selectParticulier->fetchAll();
			print_r($resultParticulier);
		}
		if(isset($_POST['entreprise']))
		{
			$selectEntreprise = $bdd->prepare("SELECT id_client, nom, FROM entreprise WHERE UPPER(nom) LIKE %UPPER(:nom)% LIMIT 100");
			$selectEntreprise->execute(array(":nom" => $nom));
			$resultEntreprise = $selectEntreprise->fetchAll();
		}
		
		$resultSearch = array_merge($resultParticulier, $resultEntreprise);
		
		//Valider les requête et arrêter la transaction
		if(!isset($resultSearch))
			$infos[] = "La recherche n'a renvoyée aucun résultat.";
	}
	else
		$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
}