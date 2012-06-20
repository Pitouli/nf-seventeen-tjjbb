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
						SELECT v.id, v.depart, v.arrive, v_d.nom||' ('||a_d.nom||')' as cityStart, v_a.nom||' ('||a_a.nom||')' as cityEnd
						FROM vol v, terminal t_d, aeroport a_d, ville v_d, terminal t_a, aeroport a_a, ville v_a
						WHERE v.depart > to_timestamp(:dateStart) AND v.depart < to_timestamp(:dateTimestampPlus36hours)
							AND v.id_terminal_dep = t_d.id AND t_d.id_aeroport = a_d.id AND a_d.id_ville = :depart AND a_d.id_ville = v_d.id
							AND v.id_terminal_ar = t_a.id AND t_a.id_aeroport = a_a.id AND a_a.id_ville = :arrivee AND a_a.id_ville = v_a.id
							AND (
								SELECT COUNT(*) + 1 
								FROM utilise u, v_reservation v_r
								WHERE v.id = u.id_vol AND u.id_reservation = v_r.id_reservation
								) <= (
								SELECT m.capacite_voyageur
								FROM avion a, modele m
								WHERE v.id_avion = a.id AND a.id_modele = m.id
								)
							AND (
								SELECT COALESCE(SUM(v_r.masse_fret) + :fret ,0)
								FROM utilise u, v_reservation v_r
								WHERE v.id = u.id_vol AND u.id_reservation = v_r.id_reservation
								) <= (
								SELECT m.capacite_fret
								FROM avion a, modele m
								WHERE v.id_avion = a.id AND a.id_modele = m.id
								)						
						ORDER BY v.arrive ASC
						");
						
						$selectDirect->execute(array(":fret" => $_POST['fret'], ":depart" => $_POST['depart'], ":arrivee" => $_POST['arrivee'], ":dateStart" => $dateStartTimestamp, ":dateTimestampPlus36hours" => $dateStartTimestampPlus36h));
						$resultDirect = $selectDirect->fetchAll();
						
						$selectUneEscale = $bdd->prepare("
						SELECT v1.id as id1, v1.depart as depart1, v1.arrive as arrive1, v_d1.nom||' ('||a_d1.nom||')' as cityStart1, v_a1.nom||' ('||a_a1.nom||')' as cityEnd1,
							v2.id as id2, v2.depart as depart2, v2.arrive as arrive2, v_d2.nom||' ('||a_d2.nom||')' as cityStart2, v_a2.nom||' ('||a_a2.nom||')' as cityEnd2
						FROM vol v1, terminal t_d1, aeroport a_d1, ville v_d1, terminal t_a1, aeroport a_a1, ville v_a1,
							vol v2, terminal t_d2, aeroport a_d2, ville v_d2, terminal t_a2, aeroport a_a2, ville v_a2
						WHERE v1.depart > to_timestamp(:dateStart) AND v1.arrive < v2.depart AND v2.depart < to_timestamp(:dateTimestampPlus36hours)
							AND v1.id_terminal_dep = t_d1.id AND t_d1.id_aeroport = a_d1.id AND a_d1.id_ville = v_d1.id AND v_d1.id = :depart
							AND v1.id_terminal_ar = t_a1.id AND t_a1.id_aeroport = a_a1.id AND a_a1.id_ville = v_a1.id
							AND v2.id_terminal_dep = t_d2.id AND t_d2.id_aeroport = a_d2.id AND a_d2.id_ville = v_d2.id AND v_d2.id = v_a1.id
							AND v2.id_terminal_ar = t_a2.id AND t_a2.id_aeroport = a_a2.id AND a_a2.id_ville = v_a2.id AND v_a2.id = :arrivee
							AND (
								SELECT COUNT(*) + 1 
								FROM utilise u1, v_reservation v_r1
								WHERE v1.id = u1.id_vol AND u1.id_reservation = v_r1.id_reservation
								) <= (
								SELECT m1.capacite_voyageur
								FROM avion a1, modele m1
								WHERE v1.id_avion = a1.id AND a1.id_modele = m1.id
								)
							AND (
								SELECT COALESCE(SUM(v_r1.masse_fret) + :fret ,0)
								FROM utilise u1, v_reservation v_r1
								WHERE v1.id = u1.id_vol AND u1.id_reservation = v_r1.id_reservation
								) <= (
								SELECT m1.capacite_fret
								FROM avion a1, modele m1
								WHERE v1.id_avion = a1.id AND a1.id_modele = m1.id
								)
							AND (
								SELECT COUNT(*) + 1 
								FROM utilise u2, v_reservation v_r2
								WHERE v2.id = u2.id_vol AND u2.id_reservation = v_r2.id_reservation
								) <= (
								SELECT m2.capacite_voyageur
								FROM avion a2, modele m2
								WHERE v2.id_avion = a2.id AND a2.id_modele = m2.id
								)
							AND (
								SELECT COALESCE(SUM(v_r2.masse_fret) + :fret ,0)
								FROM utilise u2, v_reservation v_r2
								WHERE v2.id = u2.id_vol AND u2.id_reservation = v_r2.id_reservation
								) <= (
								SELECT m2.capacite_fret
								FROM avion a2, modele m2
								WHERE v2.id_avion = a2.id AND a2.id_modele = m2.id
								)						
						ORDER BY v2.arrive ASC
						");
						
						$selectUneEscale->execute(array(":fret" => $_POST['fret'], ":depart" => $_POST['depart'], ":arrivee" => $_POST['arrivee'], ":dateStart" => $dateStartTimestamp, ":dateTimestampPlus36hours" => $dateStartTimestampPlus36h));
						$resultUneEscale = $selectUneEscale->fetchAll();
						
						$selectDeuxEscales = $bdd->prepare("
						SELECT v1.id as id1, v1.depart as depart1, v1.arrive as arrive1, v_d1.nom||' ('||a_d1.nom||')' as cityStart1, v_a1.nom||' ('||a_a1.nom||')' as cityEnd1,
							v2.id as id2, v2.depart as depart2, v2.arrive as arrive2, v_d2.nom||' ('||a_d2.nom||')' as cityStart2, v_a2.nom||' ('||a_a2.nom||')' as cityEnd2
							v3.id as id3, v3.depart as depart3, v3.arrive as arrive3, v_d3.nom||' ('||a_d3.nom||')' as cityStart3, v_a3.nom||' ('||a_a3.nom||')' as cityEnd3
						FROM vol v1, terminal t_d1, aeroport a_d1, ville v_d1, terminal t_a1, aeroport a_a1, ville v_a1,
							vol v2, terminal t_d2, aeroport a_d2, ville v_d2, terminal t_a2, aeroport a_a2, ville v_a2,
							vol v3, terminal t_d3, aeroport a_d3, ville v_d3, terminal t_a3, aeroport a_a3, ville v_a3
						WHERE v1.depart > to_timestamp(:dateStart) AND v1.arrive < v2.depart AND v2.arrive < v3.depart AND v3.depart < to_timestamp(:dateTimestampPlus36hours)
							AND v1.id_terminal_dep = t_d1.id AND t_d1.id_aeroport = a_d1.id AND a_d1.id_ville = v_d1.id AND v_d1.id = :depart
							AND v1.id_terminal_ar = t_a1.id AND t_a1.id_aeroport = a_a1.id AND a_a1.id_ville = v_a1.id
							AND v2.id_terminal_dep = t_d2.id AND t_d2.id_aeroport = a_d2.id AND a_d2.id_ville = v_d2.id AND v_d2.id = v_a1.id
							AND v2.id_terminal_ar = t_a2.id AND t_a2.id_aeroport = a_a2.id AND a_a2.id_ville = v_a2.id
							AND v3.id_terminal_dep = t_d3.id AND t_d3.id_aeroport = a_d3.id AND a_d3.id_ville = v_d3.id AND v_d3.id = v_a2.id
							AND v3.id_terminal_ar = t_a3.id AND t_a3.id_aeroport = a_a3.id AND a_a3.id_ville = v_a3.id AND v_a3.id = :arrivee
							AND (
								SELECT COUNT(*) + 1 
								FROM utilise u1, v_reservation v_r1
								WHERE v1.id = u1.id_vol AND u1.id_reservation = v_r1.id_reservation
								) <= (
								SELECT m1.capacite_voyageur
								FROM avion a1, modele m1
								WHERE v1.id_avion = a1.id AND a1.id_modele = m1.id
								)
							AND (
								SELECT COALESCE(SUM(v_r1.masse_fret) + :fret ,0)
								FROM utilise u1, v_reservation v_r1
								WHERE v1.id = u1.id_vol AND u1.id_reservation = v_r1.id_reservation
								) <= (
								SELECT m1.capacite_fret
								FROM avion a1, modele m1
								WHERE v1.id_avion = a1.id AND a1.id_modele = m1.id
								)
							AND (
								SELECT COUNT(*) + 1 
								FROM utilise u2, v_reservation v_r2
								WHERE v2.id = u2.id_vol AND u2.id_reservation = v_r2.id_reservation
								) <= (
								SELECT m2.capacite_voyageur
								FROM avion a2, modele m2
								WHERE v2.id_avion = a2.id AND a2.id_modele = m2.id
								)
							AND (
								SELECT COALESCE(SUM(v_r2.masse_fret) + :fret ,0)
								FROM utilise u2, v_reservation v_r2
								WHERE v2.id = u2.id_vol AND u2.id_reservation = v_r2.id_reservation
								) <= (
								SELECT m2.capacite_fret
								FROM avion a2, modele m2
								WHERE v2.id_avion = a2.id AND a2.id_modele = m2.id
								)	
							AND (
								SELECT COUNT(*) + 1 
								FROM utilise u3, v_reservation v_r3
								WHERE v3.id = u3.id_vol AND u3.id_reservation = v_r3.id_reservation
								) <= (
								SELECT m3.capacite_voyageur
								FROM avion a3, modele m3
								WHERE v3.id_avion = a3.id AND a3.id_modele = m3.id
								)
							AND (
								SELECT COALESCE(SUM(v_r3.masse_fret) + :fret ,0)
								FROM utilise u3, v_reservation v_r3
								WHERE v3.id = u3.id_vol AND u3.id_reservation = v_r3.id_reservation
								) <= (
								SELECT m3.capacite_fret
								FROM avion a3, modele m3
								WHERE v3.id_avion = a3.id AND a3.id_modele = m3.id
								)					
						ORDER BY v3.arrive ASC
						");
						
						$selectDeuxEscales->execute(array(":fret" => $_POST['fret'], ":depart" => $_POST['depart'], ":arrivee" => $_POST['arrivee'], ":dateStart" => $dateStartTimestamp, ":dateTimestampPlus36hours" => $dateStartTimestampPlus36h));
						$resultDeuxEscales = $selectDeuxEscales->fetchAll();						
						
						$resultReservations = true;
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
