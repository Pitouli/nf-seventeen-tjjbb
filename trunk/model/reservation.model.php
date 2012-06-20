<?php

$pageTitle = 'Réservation';

$selectVilles = $bdd->prepare("SELECT id, nom FROM ville");
$selectVilles->execute();
$listeVilles = $selectVilles->fetchAll();

// On récupère les informations sur l'utilisateur

$selectClient = $bdd->prepare("SELECT id_client, nom, prenom, cat FROM v_client WHERE id_client = :id_client LIMIT 1");
$selectClient->execute(array(":id_client" => $getSSection));
$resultClient = $selectClient->fetch();
$clientShow['name'] = $resultClient['nom'].' '.$resultClient['prenom'];