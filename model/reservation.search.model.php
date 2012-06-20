<?php
//
if(isset($_POST))
{
	// On gère la problématique de la date

	if(isset($_POST['Ddepart']))
	{
		if(preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", trim($_POST['Ddepart']), $pregStart))
		{	
			if(checkdate((int)$pregStart[2], (int)$pregStart[1], (int)$pregStart[0]))
			{				
				$showStartText = $pregStart[1].'/'.$pregStart[2].'/'.$pregStart[3];
				
				$hourStart = $_POST['Hdepart'] >= 0 && $_POST['Hdepart'] < 24 ? $_POST['Hdepart'] : 0;
				$minuteStart = $_POST['Mdepart'] >= 0 && $_POST['Mdepart'] < 60 ? $_POST['Mdepart'] : 0;
				
				//Formatage de la date+heure pour rappatriement de l'escale précédente et suivante
				$dateStartText = $showStartText . " " . $hourStart . ":" . $minuteStart;
				
				//On crée la variable showDatesDefined : dans la view elle indiquera si des dates ont déjà été saisies et les remplira
				$showDatesDefined = TRUE;
				
				//On vérifie les autres saisies :
				if(isset($_POST['depart'],$_POST['arrivee'],$_POST['fret']))
				{
					if ($_POST['depart'] != $_POST['arrivee'])
					{											
						$dateStart = date_parse_from_format('d/m/Y H:i', $dateStartText);
						$dateStartTimestamp = mktime($dateStart['hour'], $dateStart['minute'], 0, $dateStart['month'], $dateStart['day'], $dateStart['year']);
						$dateStartTimestampPlus36h = $dateStartTimestamp + 3600*36;
						
						$selectDirect = $bdd->prepare("
						SELECT v.id, v.depart, v.arrive 
						FROM vol v, terminal t_d, aeroport a_d, terminal t_a, aeroport a_a
						WHERE v.depart > :dateStart AND v.depart < :dateTimestampPlus36hours
							AND v.id_terminal_depart = t_d.id AND t_d.id_aeroport = a_d.id AND a_d.id_ville = :depart 
							AND v.id_terminal_arrive = t_a.id AND t_a.id_aeroport = a_a.id AND a_a.id_ville = :arrivee
							AND (
								SELECT SUM(masse_fret) + :fret 
								FROM utilise u, v_reservation v_r
								WHERE v.id = u.id_vol AND u.id_reservation = v_r.id_reservation
								) <= (
								SELECT m.capacite_fret
								FROM avion a, modele m
								WHERE v.id_avion = a.id AND a.id_modele = m.id
								)
							AND (
								SELECT COUNT(*) + 1 
								FROM utilise u, v_reservation v_r
								WHERE v.id = u.id_vol AND u.id_reservation = v_r.id_reservation
								) <= (
								SELECT m.capacite_voyageur
								FROM avion a, modele m
								WHERE v.id_avion = a.id AND a.id_modele = m.id
								)
						ORDER BY v.depart ASC
						");
						
						$selectDirect->execute(array(":fret" => $_POST['fret'], ":depart" => $_POST['depart'], ":arrivee" => $_POST['arrivee'], ":dateStart" => $dateStartText, ":dateTimestampPlus36hours" => $dateStartTimestampPlus36h));
						$resultDirect = $selectDirect->fetchAll();
					}
					else 
						$infos[] = "La ville de départ doit être différente de la ville d'arrivée.";
				}
				else 
					$infos[] = "Le fret n'a pas été indiqué. Mettre 0 si vous voulez un billet passager et non un titre de transport de marchandise.";
			}
			else
				$showDatesDefined = FALSE;
		}
		else
		{
			$showDatesDefined = FALSE;
			$infos[] = "Le champs date n'a pas été correctement saisie";
		}
	}
	else
		$showDatesDefined = FALSE;	
}
else
	$infos[] = "Toutes les informations requises n'ont pas été reçues. La recherche n'a pas été effectuée";
