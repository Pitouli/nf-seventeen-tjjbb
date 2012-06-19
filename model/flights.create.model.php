<?php
try 
{
	
	
	//Commencer une transaction
	$bdd->beginTransaction();

	
	$newAvion = $bdd->prepare("
	INSERT INTO vol(id, depart, arrive, id_terminal_dep, id_terminal_ar, id_avion) 
	VALUES (nextval('vol_id_seq'), to_date(':d_Depart :h_depart::m_depart', 'DD/MM/YYYY HH24:MI'), to_date(':d_Arrivee :h_arrive::m_arrive', 'DD/MM/YYYY HH24:MI'), :terminalDepart, :terminalArrivee, :idAvion)
	");
	
	/*
	C'est ici que ça merdea avec la requête PDO...
	A la base j'utilisais les variables :
	$checkStartText = $showStartText . " " . $_POST['Hdepart'] . ":" . $_POST['Mdepart'];
	$checkEndText = $showEndText . " " . $_POST['Harrivee'] . ":" . $_POST['Marrivee'];
	Définies ainsi dans fligths.new.model.php et qui contiennent les dates de départ et d'arrivée sous la forme 'DD/MM/YYYY HH24:MI'
	J'ai essayé de les echo elles sont dans le bon format...
	*/
	
	$plop = array(":d_Depart" => $showStartText, ":h_depart" => $_POST['Hdepart'], ":m_depart" => $_POST['Mdepart'], ":d_Arrivee" => $showEndText, ":h_arrive" => $_POST['Harrivee'], ":m_arrive" => $_POST['Marrivee'], ":terminalDepart" => $_POST['id_terminal_depart'],":terminalArrivee" => $_POST['id_terminal_arrivee'],":idAvion" => $_POST['id_avion']);
	
	$r = $newAvion->execute($plop);
	echo $_POST['Date_depart'];
	if($r)
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