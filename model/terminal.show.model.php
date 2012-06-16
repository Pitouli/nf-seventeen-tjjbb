<?php

if(isset($_POST))
{
	// On rajoute les % pour indiquer que le motif n'est ni n�cessairement en d�but, ni n�cessairement en fin de cha�ne
	$id_aeroport = $getSSection;

	$selectTerminaux=array();
	
	$selectTerminaux = $bdd->prepare("SELECT t.id as id, t.nom as nom, m.nom as modele model FROM terminal t, supporte s, modele m WHERE t.id_aeroport = :id_aeroport AND s.id_terminal=t.id AND s.id_model=m.id AND LIMIT 100");
	$selectTerminaux->execute(array(":id_aeroport" => $id_aeroport));
	$resultTerminaux = $selectTerminaux->fetchAll();
	
	$resultSearch = $resultTerminaux;
		
	//Valider les requ�te et arr�ter la transaction
	if(!isset($resultTerminaux))*/
		$infos[] = "Aucun r�sultat.";
}
else
	$infos[] = "Aucune information re�ue. La recherche n'a pas �t� effectu�e";
	
$showTerminal=true;
