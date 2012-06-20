<?php

if(isset($_POST))
{
	// On gère la problématique de la date

	if(isset($_POST['id']) && is_numeric($_POST['id']))
	{
		
		echo "TEST";
		
		$selectReserv = $bdd->prepare("
		SELECT c.nom AS nom, c.prenom AS prenom, c.cat AS cat_client, r. prix AS prix, r.masse_fret AS fret, r.cat AS cat_billet
		FROM v_reservation r, v_client c, utilise u	
		WHERE u.id_vol = :idVol AND r.id_reservation = u.id_reservation AND v.id_client = c.id_client
		");
		$selectReserv->execute(array(":idVol" => $_POST['id']));
		$resultReserv = $selectReserv->fetchAll();
		
				
				
			
	}
	
	
}
else
	$infos[] = "Toutes les informations requises n'ont pas été reçues. La recherche n'a pas été effectuée";