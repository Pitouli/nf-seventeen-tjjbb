<?php

if(isset($_POST))
{
	// On rajoute les % pour indiquer que le motif n'est ni nécessairement en début, ni nécessairement en fin de chaîne
	$id_aeroport = $getSSection;

	$selectTerminaux=array();
	
	$selectTerminaux = $bdd->prepare("SELECT t.id as id, t.nom as nom, m.nom as modele model FROM terminal t, supporte s, modele m WHERE t.id_aeroport = :id_aeroport AND s.id_terminal=t.id AND s.id_model=m.id AND LIMIT 100");
	$selectTerminaux->execute(array(":id_aeroport" => $id_aeroport));
	$resultTerminaux = $selectTerminaux->fetchAll();
	
	$resultSearch = $resultTerminaux;
		
	//Valider les requête et arrêter la transaction
	if(!isset($resultTerminaux))*/
		$infos[] = "Aucun résultat.";
}
else
	$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
	
$showTerminal=true;
