<?php

$clientShow['name'] = 'LEBON Paul';
$clientShow['nbFlights'] = 27;
$clientShow['cat'] = 'PARTICULIER';
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