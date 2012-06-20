<?php

$pageTitle = 'Réservation';

$selectVilles = $bdd->prepare("SELECT id, nom FROM ville");
$selectVilles->execute();
$listeVilles = $selectVilles->fetchAll();