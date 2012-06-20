<?php

if(isset($getSSection))
{
	$id_aeroport = $getSSection;
	$historiqueVol=array();

	$historiqueVol = $bdd->prepare("SELECT v.depart, v.arrive, a1.nom as aero_dep, a2.nom as aero_ar
									FROM vol v, terminal t1, terminal t2, aeroport a1, aeroport a2
									WHERE v.id_terminal_dep=t1.id AND v.id_terminal_ar=t2.id AND (t1.id_aeroport=:id_aero or t2.id_aeroport=:id_aero"
									);
	$historiqueVol->execute(array(":id_aero" => $id_aeroport));
	$historique=$historiqueVol->fetchAll();
	
	if(!isset($historique))
		$infos[] = "Aucun vol pour l'aeroport selectionné.";

}
else
	$infos[] = "L'identifiant de l'aeroport n'est pas valable.";