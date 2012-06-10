<?php

if(isset($_POST))
{
	// On rajoute les % pour indiquer que le motif n'est ni nécessairement en début, ni nécessairement en fin de chaîne
	$nom = isset($_POST['searchNom']) ? '%'.trim($_POST['searchNom']).'%' : NULL;
	$prenom = isset($_POST['searchPrenom']) ? '%'.trim($_POST['searchPrenom']).'%' : NULL;
	
	$resultParticulier = array();
	$resultEntreprise = array();

	if(isset($_POST['searchParticulier']) && $_POST['searchParticulier'] == "checked")
	{			
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
		$infos[] = "La recherche n'a renvoyée aucun résultat.";
}
else
	$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
