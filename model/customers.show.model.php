<?php

// On gère la problématique de la date
/*
if(isset($_POST['showStart'], $_POST['showEnd']))
{
	if(preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", trim($_POST['showStart']), $pregStart)
		&& preg_match("#^([0-9]{2})/([0-9]{2})/([0-9]{4})$#", trim($_POST['showEnd']), $pregEnd))
	{
		echo 'plop';
		
		if(checkdate((int)$pregStart[2], (int)$pregStart[1], (int)$pregStart[0]) && checkdate((int)$pregEnd[2], (int)$pregEnd[1], (int)$pregEnd[0]))
		{
			$showStart['d']=$pregStart[1];
			$showStart['m']=$pregStart[2];
			$showStart['y']=$pregStart[3];
			$showEnd['d']=$pregEnd[1];
			$showEnd['m']=$pregEnd[2];
			$showEnd['y']=$pregEnd[3];
			
			$showDatesDefined = TRUE;
		}
		else
			$showDatesDefined = FALSE;
	}
	else
		$showDatesDefined = FALSE;
}
else
	$showDatesDefined = FALSE;

if(!$showDatesDefined)
{
	$showStart['d']=date("d", time()-3600*24);
	$showStart['m']=date("m", time()-3600*24);
	$showStart['y']=date("Y", time()-3600*24);
	$showEnd['d']=date("d", time()+3600*24*30);
	$showEnd['m']=date("m", time()+3600*24*30);
	$showEnd['y']=date("Y", time()+3600*24*30);			
}

$showStartText = $showStart['d'].'/'.$showStart['m'].'/'.$showStart['y'];
$showEndText = $showEnd['d'].'/'.$showEnd['m'].'/'.$showEnd['y'];
*/
// On récupère les informations sur l'utilisateur

$selectClient = $bdd->prepare("SELECT id_client, nom, prenom, cat FROM v_client WHERE id_client = :id_client LIMIT 1");
$selectClient->execute(array(":id_client" => $getSSection));
$resultClient = $selectClient->fetch();
$clientShow['name'] = $resultClient['nom'].' '.$resultClient['prenom'];
$clientShow['cat'] = $resultClient['cat'];

// On récupère les réservations de l'utilisateur

$selectReservations = $bdd->prepare("SELECT id_reservation as id, prix, masse_fret, cat FROM v_reservation WHERE id_client = :id_client");
$selectReservations->execute(array(":id_client" => $getSSection));
$resultReservations = $selectReservations->fetchAll();

$selectStatsReservations = $bdd->prepare("SELECT COALESCE(SUM(prix), 0) as cost, COUNT(*) as nbFlights FROM v_reservation WHERE id_client = :id_client");
$selectStatsReservations->execute(array(":id_client" => $getSSection));
$resultStatsReservations = $selectStatsReservations->fetch();

$clientShow['cost'] = empty($resultStatsReservations) ? 0 : $resultStatsReservations['cost'];
$clientShow['nbFlights'] = empty($resultStatsReservations) ? 0 : $resultStatsReservations['nbflights'];

$selectVol = $bdd->prepare("SELECT v.id as id, v.depart as dateStart, v.arrive as dateEnd, v_d.nom||' ('||a_d.nom||')' as cityStart, v_a.nom||' ('||a_a.nom||')' as cityEnd, av.id||' ('||mod.nom||')' as plane
							FROM vol v, utilise u, terminal t_d, aeroport a_d, ville v_d, terminal t_a, aeroport a_a, ville v_a, avion av, modele mod
							WHERE v.id_terminal_dep = t_d.id AND t_d.id_aeroport = a_d.id AND a_d.id_ville = v_d.id
								AND v.id_terminal_ar = t_a.id AND t_a.id_aeroport = a_a.id AND a_a.id_ville = v_a.id
								AND v.id_avion = av.id AND av.id_modele = mod.id
								AND u.id_vol = v.id 
								AND u.id_reservation = :id_reservation
							ORDER BY v.depart ASC");

foreach($resultReservations as $key => $reservation)
{
	$selectVol->execute(array(":id_reservation" => $reservation['id']));
	$resultReservations[$key]['vols'] = $selectVol->fetchAll();
	$resultReservations[$key]['cityStart'] = $resultReservations[$key]['vols'][0]['citystart'];
	$resultReservations[$key]['dateStart'] = $resultReservations[$key]['vols'][0]['datestart'];
	$resultReservations[$key]['cityEnd'] = $resultReservations[$key]['vols'][count($resultReservations[$key]['vols'])-1]['cityend'];
	$resultReservations[$key]['dateEnd'] = $resultReservations[$key]['vols'][count($resultReservations[$key]['vols'])-1]['dateend'];	

	$now = new DateTime(date('Y-m-d h:m:s')); 
	$now = $now->format('Ymd'); 
	$dateFlight = new DateTime($resultReservations[$key]['dateStart']); 
	$dateFlight = $dateFlight->format('Ymd'); 
	
	$resultReservations[$key]['cancelable'] = $dateFlight > $now;
}

/*
$resultShow[0]['id'] = 124;
$resultShow[0]['cityStart'] = 'Paris';
$resultShow[0]['cityEnd'] = 'San Francisco';
$resultShow[0]['dateStart'] = '10/02/2013 8:00';
$resultShow[0]['dateEnd'] = '10/02/2013 18:00';
$resultShow[0]['price'] = '1280€';
$resultShow[0]['cancelable'] = ($start > time());

$resultShow[0]['vols'][0]['id'] = 1847;
$resultShow[0]['vols'][0]['cityStart'] = 'Paris';
$resultShow[0]['vols'][0]['cityEnd'] = 'New York';
$resultShow[0]['vols'][0]['dateStart'] = '10/02/2013 8:00';
$resultShow[0]['vols'][0]['dateEnd'] = '10/02/2013 12:00';
$resultShow[0]['vols'][0]['plane'] = '127856 (A380)';

$resultShow[0]['vols'][1]['id'] = 3247;
$resultShow[0]['vols'][1]['cityStart'] = 'New York';
$resultShow[0]['vols'][1]['cityEnd'] = 'San Francisco';
$resultShow[0]['vols'][1]['dateStart'] = '10/02/2013 14:00';
$resultShow[0]['vols'][1]['dateEnd'] = '10/02/2013 18:00';
$resultShow[0]['vols'][1]['plane'] = '475669 (B747)';
*/

// $resultShow = array();