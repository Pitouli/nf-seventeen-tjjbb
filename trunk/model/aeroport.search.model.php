<?php

if(isset($_POST))
{
	// On rajoute les % pour indiquer que le motif n'est ni n�cessairement en d�but, ni n�cessairement en fin de cha�ne
	$nom = isset($_POST['searchAeroport']) ? '%'.trim($_POST['searchAeroport']).'%' : NULL;
	$ville = isset($_POST['ville']) ? '%'.trim($_POST['ville']).'%' : NULL;

		
	$selectAeroport = $bdd->prepare("SELECT a.id_aeroport, a.nom, v.nom FROM aeroport a, ville v WHERE a.id_ville=v.id AND UPPER(a.nom) LIKE UPPER(:nom) AND UPPER(v.nom) LIKE UPPER(:ville) LIMIT 100");
	$selectAeroport->execute(array(":nom" => $nom, ":ville" => $ville));
	$resultAeroport = $selectAeroport->fetchAll();
	
	$resultSearch = array_merge($resultParticulier, $resultEntreprise);
		
	//Valider les requ�te et arr�ter la transaction
	if(!isset($resultSearch))
		$infos[] = "Aucun r�sultat.";
}
else
	$infos[] = "Aucune information re�ue. La recherche n'a pas �t� effectu�e";
