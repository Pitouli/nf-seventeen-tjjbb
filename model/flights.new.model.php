<?php

if(isset($_POST['depart'],$_POST['arrivee'],$_POST['Hdepart'],$_POST['Harrivee'],$_POST['capaciteMin'],$_POST['capaciteMax'],$_POST['fretMin'],$_POST['fretMax'])
{
	$result = array();
	
	$selectParticulier = $bdd->prepare("SELECT id_client, nom, prenom, 'PARTICULIER' as cat FROM particulier WHERE UPPER(nom) LIKE UPPER(:nom) AND UPPER(prenom) LIKE UPPER(:prenom) LIMIT 100");
	$selectParticulier->execute(array(":nom" => $nom, ":prenom" => $prenom));
	$resultParticulier = $selectParticulier->fetchAll();
	}
	if(isset($_POST['searchEntreprise']) && $_POST['searchEntreprise'] == "checked")
	{
		$selectEntreprise = $bdd->prepare("SELECT id_client, nom, '-' as prenom, 'ENTREPRISE' as cat FROM entreprise WHERE UPPER(nom) LIKE UPPER(:nom) LIMIT 100");
		$selectEntreprise->execute(array(":nom" => $nom));
		$resultEntreprise = $selectEntreprise->fetchAll();
	}
	
	$resultSearch = array_merge($resultParticulier, $resultEntreprise);
		
	//Valider les requête et arrêter la transaction
	if(!isset($resultSearch))
		$infos[] = "Aucun résultat.";
}
else
	$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
