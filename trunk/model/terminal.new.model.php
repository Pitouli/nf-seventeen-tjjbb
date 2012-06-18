<?php

if(isset($_POST, $_POST['nomterminal']))
{
	// On convertit nom en majuscule
	$nom = $_POST['nomterminal'];
	$nom = $nom != '' ? $nom : NULL; // On met à NULL si la chaîne est vide
	
	if(isset($nom))
	{
		try 
		{
			//Commencer une transaction
			$bdd->beginTransaction();
			
			$newTerminal = $bdd->prepare("INSERT INTO terminal(id, nom, id_aeroport) VALUES (nextval('ville_id_seq'),:nom, :id_aeroport)");
			$r1 = $newTerminal->execute(array(":nom" => $nom, ":id_aeroport" => $_POST['aeroport']));			
			
			if($r1){
				$bdd->commit();
				$success[] = "Nouveau terminal (".$nom.") ajoutee avec succes.";
				$newId = $bdd->lastInsertId('terminal_id_seq');
				echo $newId;
			}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de l'initialisation du terminal.";
			}
			
			$newSupp = $bdd->prepare("INSERT INTO supporte(id_modele, id_terminal) VALUES (:id_modele, :id_terminal)");
			
			foreach($_POST['modele'] as $modele){
				echo $newId;
				//Commencer une transaction
				$bdd->beginTransaction();
				
				if(isset($_POST['modele'])){
					$r2 = $newSupp->execute(array(":id_modele" => $modele, ":id_terminal" => $newId));
					if ($r2)
						$commit = true;
					else
						$commit = false;
				}else
					$commit = false;
				
				if($commit==true)
				{				
					$bdd->commit();
				}
				else
				{
					$bdd->rollback();
					$errors[] = "Echec de l'ajout dans la base Supporte.";
				}
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
}else
	$infos[] = "Aucune information reçue. Aucune nouvelle ville n'a été ajoutée.";
	
require DIR_MODEL.'places.model.php';
