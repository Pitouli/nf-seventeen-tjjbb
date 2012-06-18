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
				
				//On crée la variable showDatesDefined : dans la view elle indiquera si des dates ont déjà été saisies et les remplira
				$showDatesDefined = TRUE;
				
				//On vérifie les autres saisies :
				if(isset($_POST['capaciteMin'],$_POST['capaciteMax'],$_POST['fretMin'],$_POST['fretMax']))
				{
					if(($_POST['capaciteMin']<$_POST['capaciteMax'])AND($_POST['fretMin']<$_POST['fretMax']))
					{
						//On exécute la requête :
						$resultAvion = array();
						
						$selectAvion = $bdd->prepare("
						SELECT m.nom_modele, m.capacite_fret, m.capacite_voyageurs, a.id_avion
						FROM modele m INNER JOIN avion a
						ON m.id_avion = a.id_avion
						WHERE m.capacite_fret >= :fret_min AND m.capacite_fret <= :fret_max AND m.capacite_voyageurs >= :cap_min AND m.capacite_voyageurs <= :cap_max AND
						");
						$selectAvion->execute(array(":fret_min" => $_POST['fretMin'], ":fret_max" => $_POST['fretMax'], ":cap_min" => $_POST['capaciteMin'], ":cap_max" => $_POST['fretMax']));
						$resultAvion = $selectAvion->fetchAll();
						
						//Valider les requête et arréter la transaction
						if(!isset($resultAvion))
							$infos[] = "Aucun résultat.";
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
