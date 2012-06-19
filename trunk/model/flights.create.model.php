<?php
try 
{
	
	
	//Commencer une transaction
	$bdd->beginTransaction();

	$sql="
	INSERT INTO vol(id, depart, arrive, id_terminal_dep, id_terminal_ar, id_avion) 
	VALUES (nextval('vol_id_seq'), to_date('".$checkStartText."', 'DD/MM/YYYY HH24:MI'), to_date('".$checkEndText."', 'DD/MM/YYYY HH24:MI'), ".$_POST['id_terminal_depart'].", ".$_POST['id_terminal_arrivee'].", ".$_POST['id_avion'].")
	";
	
	$newAvion = $bdd->query($sql);
	
	
	
	if($newAvion)
		$commit = true;
	else
		$commit = false;
	
	if($commit)
	{
		$bdd->commit();
		$success[] = "Nouveau vol ajouté avec succès.";
	}
	else
	{
		$bdd->rollback();
		$errors[] = "Echec lors de l'ajout du vol.";
	}
}

catch(PDOException $e)
{
	//Annuler la transaction
	if($bdd) $bdd->rollBack();
		
	//Afficher l'erreur
	$errors[] = "Échec : " . $e->getMessage();
}

?>