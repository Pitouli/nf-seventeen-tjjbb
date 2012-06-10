<?php

if(is_numeric($getSSection))
{
	$id_client = $getSSection;
	
	$deleteClient = $bdd->prepare("DELETE * FROM client WHERE id = :id_client
}