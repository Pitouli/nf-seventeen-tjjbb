<?php

if(isset($_POST))
{
	$id_aeroport = $getSSection;

	$selectTerminaux=array();
	$Aeroport=array();
	$Ville=array();
	
	$selectTerminaux = $bdd->prepare("SELECT t.id as id, t.nom as nom, m.nom as modele FROM terminal t, supporte s, modele m WHERE t.id_aeroport = :id_aeroport AND s.id_terminal=t.id AND s.id_modele=m.id AND LIMIT 100");
	$selectTerminaux->execute(array(":id_aeroport" => $id_aeroport));
	$resultTerminaux = $selectTerminaux->fetchAll();
	
	$resultSearch = $resultTerminaux;
	
	$Aeroport = $bdd->prepare("SELECT nom FROM aeroport WHERE id = :id_aeroport");
	$Aeroport->execute(array(":id_aeroport" => $id_aeroport));
	$tempA = $Aeroport->fetchAll();
	$nomAeroport=$tempA[0]['nom'];
	
	$Ville = $bdd->prepare("SELECT v.nom as ville FROM aeroport a, ville v WHERE a.id= :id_aeroport AND a.id_ville=v.id");
	$Ville->execute(array(":id_aeroport" => $id_aeroport));
	$tempV = $Ville->fetchAll();

	$nomVille=$tempV[0]['ville'];
	
	//Valider les requête et arrêter la transaction
	if(!isset($resultTerminaux))
		$infos[] = "Aucun résultat.";
}
else
	$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
	
$showTerminal=true;
