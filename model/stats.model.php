<?php

$pageTitle = 'Statistiques';

// On va pouvoir calculer ici pleins de statistiques rigolotes


/* ###########
#  PARTIE 1  #
########### */

// Nombre d'avions dans la flotte

$resultNbAvions = $bdd->query("SELECT count(*) FROM avion");
$nbAvions = $resultNbAvions->fetchColumn();	// On n'a besoin de récupérer qu'une valeur unique

// Nombre de clients

$resultNbClients = $bdd->query("SELECT count(*) FROM v_client");
$nbClients = $resultNbClients->fetchColumn();	// On n'a besoin de récupérer qu'une valeur unique

// Capacité totale de transport de voyageurs

$resultTotalVoyageurs = $bdd->query("SELECT sum(capacite_voyageur) FROM avion, modele WHERE avion.id_modele = modele.id");
$totalVoyageurs = $resultTotalVoyageurs->fetchColumn();

// Capacité totale de transport de fret

$resultTotalFret = $bdd->query("SELECT sum(capacite_fret) FROM avion, modele WHERE avion.id_modele = modele.id");
$totalFret = $resultTotalFret->fetchColumn();

// Nb d'aéroports desservis

$resultNbAeroports = $bdd->query("SELECT count(*) FROM aeroport");
$nbAeroports = $resultNbAeroports->fetchColumn();

// Nb de vols dans les prochaines 24 heures

$countNbVol24heures = $bdd->prepare("SELECT COUNT(*) FROM vol WHERE depart > to_timestamp(:now) AND depart < to_timestamp(:h24)");
$countNbVol24heures->execute(array(":now" => time(), ":h24" => time()+3600*24));
$nbVol24heures = $countNbVol24heures->fetchColumn();

/* ###########
#  PARTIE 2  #
########### */
$resultHeure = $bdd->query("SELECT p.nom as nom ,p.prenom as prenom, SUM(v.arrive-v.depart) as duree
								FROM billet b, particulier p, utilise u, vol v
								WHERE b.id_particulier=p.id_client AND b.id_reservation=u.id_reservation AND u.id_vol=v.id
								GROUP BY p.nom, p.prenom");
$totalHeure = $resultHeure->fetchAll();


/* ###########
#  PARTIE 3  #
########### */

$resultPopularite = $bdd->query("SELECT nom, MAX(resa) nb
								FROM (
									SELECT vi.nom nom, count(u.id_reservation) resa
									FROM utilise u, vol v, terminal t, aeroport a, ville vi
									WHERE u.id_vol=v.id AND v.id_terminal_ar=t.id AND t.id_aeroport=a.id AND a.id_ville=vi.id
									GROUP BY vi.nom
								) as nb_reservation
								GROUP BY nom
								ORDER BY nb DESC
								LIMIT 10");
$Popularite = $resultPopularite->fetchAll();


/* ###########
#  PARTIE 4  #
########### */