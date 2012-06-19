<?php

if(isset($_POST))
{
	echo "id aeroport :";
	$id_aeroport = $_POST['idAeroport'];
	echo $id_aeroport;
	echo ".";
	$Term=array();
	$Modele=array();
	$Aeroport=array();
	$Ville=array();
	
	$Term = $bdd->prepare("SELECT id, nom FROM terminal WHERE id_aeroport = :id_aeroport");
	$Term->execute(array(":id_aeroport" => $id_aeroport));
	$resultTerminaux = $Term->fetchAll();
	
	$Modele = $bdd->prepare("SELECT s.id_terminal, s.id_modele, m.nom as nom FROM supporte s, modele m WHERE s.id_terminal = :id AND s.id_modele=m.id");
	
	foreach($resultTerminaux as $key => $Terminal){
		$Modele->execute(array(":id" => $resultTerminaux[$key]['id']));
		$resultTerminaux[$key]['modele'] = $Modele->fetchAll();
	}
	
	$Aeroport = $bdd->prepare("SELECT nom FROM aeroport WHERE id = :id_aeroport");
	$Aeroport->execute(array(":id_aeroport" => $id_aeroport));
	$tempA = $Aeroport->fetchAll();
	$nomAeroport=$tempA[0]['nom'];
	
	$Ville = $bdd->prepare("SELECT v.nom as ville FROM aeroport a, ville v WHERE a.id= :id_aeroport AND a.id_ville=v.id");
	$Ville->execute(array(":id_aeroport" => $id_aeroport));
	$tempV = $Ville->fetchAll();

	$nomVille=$tempV[0]['ville'];
	
	//Valider les requête et arrêter la transaction
	if(!isset($resultTerminaux))
		$infos[] = "Aucun résultat.";
}
else
	$infos[] = "Aucune information reçue. La recherche n'a pas été effectuée";
	
$showTerminal=true;
