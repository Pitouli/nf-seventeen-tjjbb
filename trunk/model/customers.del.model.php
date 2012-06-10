<?php

if(is_numeric($getSSection))
{
	$id_client = $getSSection;
	
	$deleteClient = $bdd->prepare("DELETE FROM client WHERE id = :id_client");
	$r = $deleteClient->execute(array(":id_client" => $id_client));
	$c = $deleteClient->rowCount();
	
	if($r)
		if($c > 0)
			$success[] = "La suppression a réussi.";
		else
			$infos[] = "Le client était déjà supprimé.";
	else
		$errors[] = "Echec lors de la suppression.";
}
else
	$infos[] = "L'identifiant du client à supprimer n'est pas valable.";