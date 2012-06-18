<?php

if(isset($_POST))
{
	$idModele = $_POST['modele2'];

	$selectAffichageAvions = $bdd->prepare("SELECT id FROM avion
											WHERE id_modele = :idModele
											LIMIT 100");
									
	$selectAffichageAvions->execute(array(":idModele" => $idModele));
	$affichageAvions = $selectAffichageAvions->fetchAll();
		
	//Valider les requête et arrêter la transaction
	if(!isset($affichageAvions))
		$infos[] = "Aucun résultat.";
}
else
	$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
