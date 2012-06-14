<?php

$pageTitle = 'Vols';

$selectVilles = $bdd->prepare("SELECT id, nom FROM villes");
$selectVilles->execute();

$listeVilles = $selectVilles->fetchAll();
