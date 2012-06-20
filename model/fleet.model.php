<?php 

$pageTitle = 'Flotte';

$selectModeles = $bdd->prepare("SELECT id, nom FROM modele");
$selectModeles->execute();

$listeModeles = $selectModeles->fetchAll();


// Requêtes pour stats

// Nombre d'avions dans la flotte

$resultNbAvions = $bdd->query("SELECT count(id) FROM avion");
$nbAvions = $resultNbAvions->fetchColumn();	// On n'a besoin de récupérer qu'une valeur unique

// Capacité totale de transport de voyageurs

$resultTotalVoyageurs = $bdd->query("SELECT sum(capacite_voyageur) FROM avion, modele WHERE avion.id_modele = modele.id");
$totalVoyageurs = $resultTotalVoyageurs->fetchColumn();

// Capacité totale de transport de fret

$resultTotalFret = $bdd->query("SELECT sum(capacite_fret) FROM avion, modele WHERE avion.id_modele = modele.id");
$totalFret = $resultTotalFret->fetchColumn();
