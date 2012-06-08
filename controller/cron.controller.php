<?php

$bdd = new BDD; // On crée directement un objet PDO

require DIR_MODEL.'cron.model.php';

if($getSection == 'stock2gal') {
	require DIR_MODEL.'cron.stock2gal.model.php';
}
elseif($getSection == 'regeMin') {
	require DIR_MODEL.'cron.regeMin.model.php';
}
elseif($getSection == 'suppr') {
	require DIR_MODEL.'cron.suppr.model.php';
}
elseif($getSection == 'checkCron') {
	require DIR_MODEL.'cron.checkCron.model.php';
}