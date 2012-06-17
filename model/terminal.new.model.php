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
			$newId = $bdd->lastInsertId('terminal_id_seq');
			
			if($r1){
				if(isset($_POST['modele'])){
					$newSupp = $bdd->prepare("INSERT INTO supporte(id_modele, id_terminal) VALUES (:id_modele, :id_terminal)");
					$r2 = $newSupp ->execute(array(":id_modele" => $_POST['modele'], "id_terminal" => $newId));
				
					if ($r2)
						$commit = true;
					else
						$commit = false;
				}else
					$commit = blop;
					
				if($commit=true) // 1 ligne a été ajoutée
				{				
					$bdd->commit();
					$success[] = "Nouveau terminal (".$nom.") ajoutee avec succes.";
				}
				else if($commit=false)
				{
					$bdd->rollback();
					$errors[] = "Echec lors de l'ajout du terminal.";
				}
				else if($commit=blop){
					$bdd->rollback();
					$errors[] = "Pas de model passer en argument";
				}
			}
			else
			{
				$bdd->rollback();
				$errors[] = "Echec lors de l'initialisation du terminal.";
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
