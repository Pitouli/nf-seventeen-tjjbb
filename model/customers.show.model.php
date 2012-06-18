<?php

// On gère la problématique de la date

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

// On récupère les informations sur l'utilisateur

$selectClient = $bdd->prepare("SELECT id_client, nom, prenom, cat FROM v_client WHERE id_client = :id_client LIMIT 1");
$selectClient->execute(array(":id_client" => $getSSection));
$resultClient = $selectClient->fetch();

// On récupère les réservations de l'utilisateur

$selectReservations = $bdd->prepare("SELECT id_client, nom, prenom, cat FROM v_client WHERE id_client = :id_client LIMIT 1");
$selectReservations->execute(array(":id_client" => $getSSection));
$resultReservations = $selectReservations->fetchAll();

$clientShow['name'] = $resultClient['nom'].' '.$resultClient['prenom'];
$clientShow['nbFlights'] = 27;
$clientShow['cat'] = $resultClient['cat'];
$clientShow['cost'] = '12780€';

$start = time() + 10000;

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

// $resultShow = array();