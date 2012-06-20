<?php

if(isset($getSSection))
{
	$id_aeroport = $getSSection;
	echo $getSSection
	$historiqueVol=array();

	$historiqueVol = $bdd->prepare("SELECT v.depart as dep, v.arrive as ar, a1.nom as aero_dep, a2.nom as aero_ar
									FROM vol v, terminal t1, terminal t2, aeroport a1, aeroport a2
									WHERE v.id_terminal_dep=t1.id AND v.id_terminal_ar=t2.id AND (t1.id_aeroport=:id_aero or t2.id_aeroport=:id_aero) LIMIT 100"
									);
	$historiqueVol->execute(array(":id_aero" => $id_aeroport));
	$historique=$historiqueVol->fetchAll();
	
	$Aeroport = $bdd->prepare("SELECT nom, id FROM aeroport WHERE id = :id_aeroport");
	$Aeroport->execute(array(":id_aeroport" => $id_aeroport));
	$tempA = $Aeroport->fetchAll();
	$nomAeroport=$tempA[0]['nom'];
	$idAeroport=$tempA[0]['id'];
	
	$Ville = $bdd->prepare("SELECT v.nom as ville FROM aeroport a, ville v WHERE a.id= :id_aeroport AND a.id_ville=v.id");
	$Ville->execute(array(":id_aeroport" => $id_aeroport));
	$tempV = $Ville->fetchAll();

	$nomVille=$tempV[0]['ville'];
	
	if(!isset($historique))
		$infos[] = "Aucun vol pour l'aéroport selectionné.";
	else
		$showHistorique=true;
}
else
	$infos[] = "L'identifiant de l'aéroport n'est pas valable.";