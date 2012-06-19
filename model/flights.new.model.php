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
					if ($_POST['depart'] != $_POST['arrivee'])
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
						
						
						//détermine la liste des avions compatible avec les critères saisis par l'utilisateur:
						$selectAvion = $bdd->prepare("
						SELECT m.nom AS nom, m.capacite_fret AS capacite_fret, m.capacite_voyageur AS capacite_voyageur, m.id AS id_modele, a.id AS id
						FROM avion a INNER JOIN modele m
						ON a.id_modele = m.id
						WHERE m.capacite_fret >= :fret_min AND m.capacite_fret <= :fret_max AND m.capacite_voyageur >= :cap_min AND m.capacite_voyageur <= :cap_max
						");
						
						
						
						
						$selectAvion->execute(array(":fret_min" => $fretMin, "fret_max" => $fretMax, ":cap_max" => $capaciteMax, ":cap_min" => $capaciteMin));
						$resultAvion = $selectAvion->fetchAll();
						
						//Pour chacun des resultats de la requete, on prepare les sous requetes :
						
						$selectTerminal = array();
						$selectAeroport = array();
						$selectPreviousAirport = array();
						$selectNextAirport = array();
						
						$selectUtilise = array();
						
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
						SELECT vi.nom AS nom_ville, a.nom AS nom_aeroport
						FROM aeroport a, terminal t, vol v, ville vi
						WHERE vi.id = a.id_ville AND a.id = t.id_aeroport AND t.id = v.id_terminal_ar AND v.id_avion = :idAvion AND :checkstart > arrive
						ORDER BY arrive DESC
						LIMIT 1
						");
						
						//Affichage de la prochaine escale
						$selectNextAirport =  $bdd->prepare("
						SELECT vi.nom AS nom_ville, a.nom AS nom_aeroport
						FROM aeroport a, terminal t, vol v, ville vi
						WHERE vi.id = a.id_ville AND a.id = t.id_aeroport AND t.id = v.id_terminal_dep AND v.id_avion = :idAvion AND :checkend < depart
						ORDER BY depart
						LIMIT 1
						");
						
						//Determine si l'avion est en vol dans le laps de temps saisi par l'utilisateur :
						$selectUtilise = $bdd->prepare("
						SELECT id_avion 
						FROM avion a INNER JOIN vol v 
						ON a.id = v.id_avion 
						WHERE a.id = :idAvion AND( ((v.arrive > :leDepart) AND (v.arrive < :lArrive)) OR ( (v.depart > :leDepart) AND (v.depart < :lArrive) ));
						");
						
						//Exemple fonctionnel :
						//SELECT id_avion FROM avion a INNER JOIN vol v ON a.id = v.id_avion WHERE a.id = 2 AND ( ((v.arrive > '11/11/1111 01:00') AND (v.arrive < '11/11/1111 12:00')) OR ( (v.depart > '11/11/1111 01:00') AND (v.depart < '11/11/1111 12:00') ));
						
						foreach($resultAvion as $key => $avion)
						{
							//selection de l'aeroport et du terminal de départ
							$selectTerminal->execute(array(":id_ville" => $_POST['depart'], ":id_modele" => $resultAvion[$key]['id_modele']));
							$resultAvion[$key]['terminal'] = $selectTerminal->fetchAll();
							
							//selection de l'aeroport et du terminal d'arrivee
							$selectAeroport->execute(array(":id_ville" => $_POST['arrivee'], ":id_modele" => $resultAvion[$key]['id_modele']));
							$resultAvion[$key]['aeroport'] = $selectAeroport->fetchAll();
							
							//Affichage de la précédente escale
							$selectPreviousAirport->execute(array(":idAvion" => $resultAvion[$key]['id'], ":checkstart" => $checkStartText));
							$resultAvion[$key]['PreviousAirport'] = $selectPreviousAirport->fetch(); //on utilise fetch (et pas fetchAll) car on a au plus un seul resultat grace a LIMIT 1
							
							//Affichage de la prochaine escale
							$selectNextAirport->execute(array(":idAvion" => $resultAvion[$key]['id'], ":checkend" => $checkEndText));
							$resultAvion[$key]['NextAirport'] = $selectNextAirport->fetch(); //on utilise fetch (et pas fetchAll) car on a au plus un seul resultat grace a LIMIT 1
							
							//Determine si l'avion est en vol dans le laps de temps saisi par l'utilisateur :
							$selectUtilise->execute(array(":idAvion" => $resultAvion[$key]['id'], ":leDepart" => $checkStartText, ":lArrive" => $checkEndText));
							$resultAvion[$key]['utilise'] = $selectUtilise->fetchAll(); 
							
							
						}
						
						
					}
					else $infos[] = "Les champs capacité et/ou fret n'ont pas été correctement saisie";
					
					}
					
					else $infos[] = "La ville de départ doit être différente de la ville d'arrivée.";
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
