<?php

$pageTitle = 'Villes/Aeroports/terminaux';

$selectVilles = $bdd->prepare("SELECT id, nom FROM ville");
$selectVilles->execute();

$listeVilles = $selectVilles->fetchAll();
	