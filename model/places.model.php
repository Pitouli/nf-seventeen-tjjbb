<?php

$pageTitle = 'Villes/Aeroports/terminaux';

$selectVilles = $bdd->prepare("SELECT id, nom FROM ville");
$selectVilles->execute();

$listeVilles = $selectVilles->fetchAll();

if(isset($_POST['idAero'])){
	$Aeroport = $bdd->prepare("SELECT nom, id FROM aeroport WHERE id = :id_aeroport");
	$Aeroport->execute(array(":id_aeroport" => $id_aeroport));
	$tempA = $Aeroport->fetchAll();
	$nomAeroport=$tempA[0]['nom'];
	$idAeroport=$tempA[0]['id'];
	
	$Ville = $bdd->prepare("SELECT v.nom as ville FROM aeroport a, ville v WHERE a.id= :id_aeroport AND a.id_ville=v.id");
	$Ville->execute(array(":id_aeroport" => $id_aeroport));
	$tempV = $Ville->fetchAll();

	$nomVille=$tempV[0]['ville'];
}