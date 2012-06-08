<?php

$bdd = new BDD; // On crée directement un objet PDO

if($getSection == 'HD') 
	{
		require DIR_MODEL.'buy.HD.model.php';
		require DIR_VIEW.'default.view.php';
	}