<?php

// On récupère tous les types existant
$enumType = $bdd->query("SHOW COLUMNS FROM logbook LIKE 'type'");
$result = $enumType->fetch(); //
$arrayType = explode( "','", substr($result[1],6,-2) ); // $result[1] est de la forme enum('blab','bli','blo') 


// On va compléter au fur et à mesure la clause WHERE
$where = 'WHERE';

// On regarde si un nombre précis d'évenement est à afficher
if(isset($_POST['logbookLimit']) && is_numeric($_POST['logbookLimit']) && $_POST['logbookLimit'] <= 400)
{
	$logbookLimit = $_POST['logbookLimit'];
}
else
{
	$logbookLimit = 10;	
}
// On regarde si un type de succès précis est demandé
if(isset($_POST['logbookSuccess']) && ($_POST['logbookSuccess'] == '1' OR $_POST['logbookSuccess'] == '0'))
{
	$logbookSuccess = $_POST['logbookSuccess'];
	$where = $where.' success='.$logbookSuccess;
}
else
{
	$logbookSuccess = 'all';
	$where = $where.' 1=1';	
}
// On regarde si un type d'événement précis est demandé
if(isset($_POST['logbookType']) AND in_array($_POST['logbookType'], $arrayType))
{
	$logbookType = $_POST['logbookType'];
	$where = $where." AND type='".$logbookType."'";
}
else
{
	$logbookType = 'all';
	$where = $where.' AND 1=1';
}
	
// On prépare la requête pour récupérer les évents
$sql = "SELECT * FROM logbook ".$where." ORDER BY datetime DESC LIMIT ".$logbookLimit;
$recupLogbook = $bdd->query($sql);
$listEvents = $recupLogbook->fetchAll();