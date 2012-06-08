<?php

$bdd = new BDD; // On crée directement un objet PDO

if($getSection == 'attachment') 
	{
		require DIR_MODEL.'download.attachment.model.php';
	}
if($getSection == 'photo') 
	{
		require DIR_MODEL.'download.photo.model.php';
		require DIR_VIEW.'default.view.php';
	}