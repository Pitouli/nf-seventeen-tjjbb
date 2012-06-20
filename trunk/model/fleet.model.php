<?php 

$pageTitle = 'Flotte';

$selectModeles = $bdd->prepare("SELECT id, nom FROM modele");
$selectModeles->execute();

$listeModeles = $selectModeles->fetchAll();
