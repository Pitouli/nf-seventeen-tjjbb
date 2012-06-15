<?php

if(isset($_POST))
{
	// On rajoute les % pour indiquer que le motif n'est ni nécessairement en début, ni nécessairement en fin de chaîne
	$nom = isset($_POST['searchAeroport']) ? '%'.trim($_POST['searchAeroport']).'%' : NULL;
	$ville = isset($_POST['ville']) ? '%'.trim($_POST['ville']).'%' : NULL;

		
	$selectAeroport = $bdd->prepare("SELECT a.id_aeroport, a.nom, v.nom FROM aeroport a, ville v WHERE a.id_ville=v.id AND UPPER(a.nom) LIKE UPPER(:nom) AND UPPER(v.nom) LIKE UPPER(:ville) LIMIT 100");
	$selectAeroport->execute(array(":nom" => $nom, ":ville" => $ville));
	$resultAeroport = $selectAeroport->fetchAll();
	
	$resultSearch = array_merge($resultParticulier, $resultEntreprise);
		
	//Valider les requête et arrêter la transaction
	if(!isset($resultSearch))
		$infos[] = "Aucun résultat.";
}
else
	$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
