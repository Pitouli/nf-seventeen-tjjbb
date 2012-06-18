<?php 

$pageTitle = 'Flotte';

$selectModeles = $bdd->prepare("SELECT id, nom FROM modele");
$selectModeles->execute();

$listeModeles = $selectModeles->fetchAll();


// Requêtes pour stats

// Nombre d'avions dans la flotte

$resultNbAvions = $bdd->query("SELECT count(id) FROM avion");
$nbAvions = $resultNbAvions->fetchColumn();	// On n'a besoin de récupérer qu'une valeur unique

