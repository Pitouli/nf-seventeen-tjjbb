<?php

if(isset($_POST))
{
	// On rajoute les % pour indiquer que le motif n'est ni n�cessairement en d�but, ni n�cessairement en fin de cha�ne
	$id_aeroport = $GetSSection;

	$selectTerminaux=array();
	
	//
	if(is_int($id_aeroport)){
		$selectAeroport = $bdd->prepare("SELECT a.id as id, a.nom as aeroport, v.nom as ville FROM aeroport a, ville v WHERE a.id_ville=v.id AND v.id = :ville AND UPPER(a.nom) LIKE UPPER(:nom) LIMIT 100");
		$selectAeroport->execute(array(":nom" => $nom, ":ville" => $ville));
		$resultAeroport = $selectAeroport->fetchAll();
	}else{
		$selectAeroport = $bdd->prepare("SELECT a.id, a.nom as aeroport, v.nom as ville FROM aeroport a, ville v WHERE a.id_ville=v.id AND UPPER(a.nom) LIKE UPPER(:nom) LIMIT 100");
		$selectAeroport->execute(array(":nom" => $nom));
		$resultAeroport = $selectAeroport->fetchAll();
	}	
	
	$resultSearch = $resultAeroport;
		
	//Valider les requ�te et arr�ter la transaction
	if(!isset($resultSearch))
		$infos[] = "Aucun r�sultat.";
}
else
	$infos[] = "Aucune information re�ue. La recherche n'a pas �t� effectu�e";
	
$showTerminal=true;
