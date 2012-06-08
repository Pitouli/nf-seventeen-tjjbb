<?php

$webcron = new WebcronAPI;

// On compte le crédit restant
$credits = $webcron->getCredits();

// On regarde si les tâches gérées par Webcron sont actives
// stock2gal
$cronStatus['stock2gal'] = $webcron->getCronActivity('stock2gal') == 1 ? 'On' : 'Off';
// suppr
$cronStatus['suppr'] = $webcron->getCronActivity('suppr') == 1 ? 'On' : 'Off';
// checkCron
$cronStatus['checkCron'] = $webcron->getCronActivity('checkCron') == 1 ? 'On' : 'Off';
// stock2gal
$cronStatus['regeMin'] = $webcron->getCronActivity('regeMin') == 1 ? 'On' : 'Off';

