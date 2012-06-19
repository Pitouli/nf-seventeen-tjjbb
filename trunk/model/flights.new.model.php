<?php
//
if(isset($_POST))
{
	// On gère la problématique de la date

	if(isset($_POST['Ddepart'], $_POST['Darrivee']))
	{
		if(preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", trim($_POST['Ddepart']), $pregStart)
			&& preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", trim($_POST['Darrivee']), $pregEnd))
		{
			
			
			if(checkdate((int)$pregStart[2], (int)$pregStart[1], (int)$pregStart[0]) && checkdate((int)$pregEnd[2], (int)$pregEnd[1], (int)$pregEnd[0]))
			{
				$showStart['d']=$pregStart[1];
				$showStart['m']=$pregStart[2];
				$showStart['y']=$pregStart[3];
				$showEnd['d']=$pregEnd[1];
				$showEnd['m']=$pregEnd[2];
				$showEnd['y']=$pregEnd[3];
				
				$showStartText = $showStart['d'].'/'.$showStart['m'].'/'.$showStart['y'];
				$showEndText = $showEnd['d'].'/'.$showEnd['m'].'/'.$showEnd['y'];
				
				//Formatage de la date+heure pour rappatriement de l'escale précédente et suivante, et pour l'enregistrement dans le formulaire de l'étape 2 (en "hidden")
				$checkStartText = $showStartText . " " . $_POST['Hdepart'] . ":" . $_POST['Mdepart'];
				$checkEndText = $showEndText . " " . $_POST['Harrivee'] . ":" . $_POST['Marrivee'];
				
				//On crée la variable showDatesDefined : dans la view elle indiquera si des dates ont déjà été saisies et les remplira
				$showDatesDefined = TRUE;
				
				
				
				//On vérifie les autres saisies :
				if(isset($_POST['capaciteMin'],$_POST['capaciteMax'],$_POST['fretMin'],$_POST['fretMax']))
				{
					//On gère les valeur de capacité et fret :
					$capaciteMin = (!empty($_POST['capaciteMin'])) ? $_POST['capaciteMin'] : 0;	// Au cas où l'utilisateur n'entre rien, afin de prendre tous les résultats.
					$capaciteMax = (!empty($_POST['capaciteMax'])) ? $_POST['capaciteMax'] : 32000;
					$fretMin = (!empty($_POST['fretMin'])) ? $_POST['fretMin'] : 0;
					$fretMax = (!empty($_POST['fretMax'])) ? $_POST['fretMax'] : 100000;
					if(($capaciteMin<$capaciteMax)AND($fretMin<$fretMax))
					{
						//On exécute la requête :
						$selectAvion = array();
						$selectTerminal = array();
						$selectPreviousAirport = array();
						$selectAeroport = array();
						
						$selectAvion = $bdd->prepare("
						SELECT m.nom AS nom, m.capacite_fret AS capacite_fret, m.capacite_voyageur AS capacite_voyageur, m.id AS id_modele, a.id AS id
						FROM avion a INNER JOIN modele m
						ON a.id_modele = m.id
						WHERE m.capacite_fret >= :fret_min AND m.capacite_fret <= :fret_max AND m.capacite_voyageur >= :cap_min AND m.capacite_voyageur <= :cap_max
						");
						
						
						
						$selectAvion->execute(array(":fret_min" => $fretMin, "fret_max" => $fretMax, ":cap_max" => $capaciteMax, ":cap_min" => $capaciteMin));
						$resultAvion = $selectAvion->fetchAll();
						
						//selection de l'aeroport et du terminal de départ
						$selectTerminal = $bdd->prepare("
						SELECT a.nom AS nom_aeroport, t.id AS id_terminal, t.nom AS nom_terminal
						FROM aeroport a, terminal t, supporte s
						WHERE a.id_ville = :id_ville AND s.id_modele = :id_modele AND a.id = t.id_aeroport AND t.id = s.id_terminal
						");
						
						//selection de l'aeroport et du terminal d'arrivee
						$selectAeroport = $bdd->prepare("
						SELECT a.nom AS nom_aeroport, t.id AS id_terminal, t.nom AS nom_terminal
						FROM aeroport a, terminal t, supporte s
						WHERE a.id_ville = :id_ville AND s.id_modele = :id_modele AND a.id = t.id_aeroport AND t.id = s.id_terminal
						");
						
						//Affichage de la précédente escale
						$selectPreviousAirport = $bdd->prepare("
						SELECT a.nom
						FROM aeroport a, terminal t, vol v
						WHERE a.id = t.id_aeroport AND t.id = v.id_terminal_ar AND :checkstart < depart
						ORDER BY date DESC
						LIMIT 1
						");
						
						
						//Affichage de la prochaine escale
						//TODO
						
						foreach($resultAvion as $key => $avion)
						{
							$selectTerminal->execute(array(":id_ville" => $_POST['depart'], ":id_modele" => $resultAvion[$key]['id_modele']));
							$resultAvion[$key]['terminal'] = $selectTerminal->fetchAll();
							
							//$selectPreviousAirport->execute(array(":checkdate", to_date($checkStartText, 'DD/MM/YYYY HH:MM')));
							//$resultAvion[$key]['PreviousAirport'] = $selectPreviousAirport->fecth();
							
							$selectAeroport->execute(array(":id_ville" => $_POST['arrivee'], ":id_modele" => $resultAvion[$key]['id_modele']));
							$resultAvion[$key]['aeroport'] = $selectAeroport->fetchAll();
							//TODO : prochaine escale
							
							
						}
						
						
						
						
						
					}
					else $infos[] = "Les champs capacité et/ou fret n'ont pas été correctement saisie";
				}
				else $infos[] = "Les champs capacité et/ou fret n'ont pas été saisie";
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
