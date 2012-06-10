<?php

if(isset($_POST))
{
	// On convertit nom en majuscule
	$nom = mb_strtoupper(trim($_POST['newNom']), 'UTF-8');
	$nom = $nom != '' ? $nom : NULL; // On met à NULL si la chaîne est vide
	// On convertit prenom en minuscule avec les 1ere lettres accentuées (y compris après un tiret)
	$prenom = str_replace('- ','-',ucwords(str_replace('-','- ',mb_strtolower(trim($_POST['newPrenom']), 'UTF-8'))));
	$prenom = $prenom != '' ? $prenom : NULL; // On met à NULL si la chaîne est vide

	try 
	{
		//Commencer une transaction
		$bdd->beginTransaction();
		
		$n = $bdd->exec("INSERT INTO client(id) VALUES (nextval('client_id_seq'));");
		$newId = $bdd->lastInsertId('client_id_seq');
		
		if($n == 1) // 1 ligne a été ajoutée
		{				
			if($_POST['newStatut'] == 'particulier' && isset($nom, $prenom))
			{
				$newParticulier = $bdd->prepare("INSERT INTO particulier(id_client,nom,prenom) VALUES (:id_client, :nom, :prenom)");
				$r = $newParticulier->execute(array(":id_client" => $newId, ":nom" => $nom, ":prenom" => $prenom));
				
				if($r)
					$commit = true;
				else
					$commit = false;
			}
			else if($_POST['newStatut'] == 'entreprise' && isset($nom))
			{
				$newEntreprise = $bdd->prepare("INSERT INTO entreprise(id_client,nom) VALUES (:id_client, :nom)");
				$success = $newEntreprise->execute(array(":id_client" => $newId, ":nom" => $nom));
				
				if($r)
					$commit = true;
				else
					$commit = false;
			}
			else
				$commit = false;
			
			//Valider les requête et arrêter la transaction
			if($commit)
			{
				$bdd->commit();
				$success[] = "Nouveau client (n°".$newId.") ajouté avec succès.";
			}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de la création du client.";
			}
		}
		else
		{
			$bdd->rollback();
			$errors[] = "Echec lors de l'initialisation du client.";
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
