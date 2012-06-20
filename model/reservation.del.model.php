<?php

if(isset($_POST['delResId']) && is_numeric($_POST['delResId']))
{
	$id_reservation = $_POST['delResId'];
	
	$deleteReservation = $bdd->prepare("DELETE FROM reservation r WHERE r.id = :id_reservation");
	$r = $deleteReservation->execute(array(":id_reservation" => $id_reservation));
	$c = $deleteReservation->rowCount();
	
	if($r)
		if($c > 0)
			$success[] = "La suppression de la réservation s'est bien effectuée.";
		else
			$infos[] = "La réservation était déjà supprimée.";
	else
		$errors[] = "Erreur lors de la suppression de la réservation.";
}
else
	$infos[] = "L'identifiant de la réservation à supprimer n'est pas valable.";