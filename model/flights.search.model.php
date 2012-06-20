<?php

if(isset($_POST))
{
	// On gère la problématique de la date

	if(isset($_POST['DdepartSearch'], $_POST['DarriveeSearch']))
	{
		if(preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", trim($_POST['DdepartSearch']), $pregStart)
			&& preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", trim($_POST['DarriveeSearch']), $pregEnd))
		{
			
			
			if(checkdate((int)$pregStart[2], (int)$pregStart[1], (int)$pregStart[0]) && checkdate((int)$pregEnd[2], (int)$pregEnd[1], (int)$pregEnd[0]))
			{
				$showStart['d']=$pregStart[1];
				$showStart['m']=$pregStart[2];
				$showStart['y']=$pregStart[3];
				$showEnd['d']=$pregEnd[1];
				$showEnd['m']=$pregEnd[2];
				$showEnd['y']=$pregEnd[3];
				
				$showStartTextSearch = $showStart['d'].'/'.$showStart['m'].'/'.$showStart['y'];
				$showEndTextSearch = $showEnd['d'].'/'.$showEnd['m'].'/'.$showEnd['y'];
				
				//Formatage de la date+heure pour rappatriement de l'escale précédente et suivante, et pour l'enregistrement dans le formulaire de l'étape 2 (en "hidden")
				$checkStartTextSearch = $showStartTextSearch . " " . $_POST['HdepartSearch'] . ":" . $_POST['MdepartSearch'];
				$checkEndTextSearch = $showEndTextSearch . " " . $_POST['HarriveeSearch'] . ":" . $_POST['MarriveeSearch'];
				
				//On crée la variable showDatesDefinedSearch : dans la view elle indiquera si des dates ont déjà été saisies et les remplira
				$showDatesDefinedSearch = TRUE;
				
				
				
				$resultVol = $bdd->query("
				SELECT v.id AS id, v.depart AS date_depart, v.arrive AS date_arrive, td.nom AS terminal_depart, ad.nom AS aeorport_depart, ta.nom AS terminal_arrive, aa.nom AS aeroport_arrive, m.nom AS avion, av.id AS n_avion
				FROM vol v, terminal td, terminal ta, aeroport ad, aeroport aa, ville vd, ville va, avion av, modele m
				WHERE v.id_terminal_dep = td.id AND td.id_aeroport = ad.id AND ad.id_ville = vd.id AND v.id_terminal_ar = ta.id AND ta.id_aeroport = aa.id AND aa.id_ville = va.id AND v.id_avion = av.id AND av.id_modele = m.id AND
				vd.id = ". $_POST['departSearch'] ." AND va.id = ". $_POST['arriveeSearch'] ." AND (v.depart > '". $checkStartTextSearch ."') AND (v.arrive < '". $checkEndTextSearch ."')
				");
				
				
			}
			else
				$showDatesDefined = FALSE;
		}
		else
		{
			$showDatesDefined = FALSE;
			$infos[] = "Le champs date n'a pas étéorrectement saisie";
		}
	}
	else
		$showDatesDefined = FALSE;
	
}
else
	$infos[] = "Toutes les informations requises n'ont pas été reçues. La recherche n'a pas été effectuée";