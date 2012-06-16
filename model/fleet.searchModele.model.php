<?php

if(isset($_POST))
{
	// On rajoute les % pour indiquer que le motif n'est ni n�cessairement en d�but, ni n�cessairement en fin de cha�ne
	$nom = isset($_POST['searchNomModele']) ? '%'.trim($_POST['searchNomModele']).'%' : NULL;
	$capaciteMin = isset($_POST['searchCapaciteMin']) ? $_POST['searchCapaciteMin'] : 0;	// Au cas o� l'utilisateur n'entre rien, afin de prendre tous les r�sultats.
	$capaciteMax = isset($_POST['searchCapaciteMax']) ? $_POST['searchCapaciteMax'] : 1000000;
	$fretMin = isset($_POST['searchFretMin']) ? $_POST['searchFretMin'] : 0;
	$fretMax = isset($_POST['searchFretMax']) ? $_POST['searchFretMax'] : 1000000;
	
	$selectResultats= array();

	$selectResultats = $bdd->prepare("SELECT id, nom, capacite_fret, capacite_voyageur
									FROM modele WHERE UPPER(nom) LIKE UPPER(:nom)
									AND capacite_fret BETWEEN :fretMin AND :fretMax
									AND capacite_voyageur BETWEEN :capaciteMin AND :capaciteMax
									AND  LIMIT 100");
	$selectResultats->execute(array(":nom" => $nom, ":fretMin" => $fretMin, ":fretMax" => $fretMax, ":capaciteMin" => $capaciteMin, ":capaciteMax" => $capaciteMax));
	$resultats = $selectResultats->fetchAll();
		
	//Valider les requ�te et arr�ter la transaction
	if(!isset($resultats))
		$infos[] = "Aucun r�sultat.";
}
else
	$infos[] = "Aucune information re�ue. La recherche n'a pas �t� effectu�e";
