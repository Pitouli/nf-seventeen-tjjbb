<?php

// La fonction qui va nous permettre de formater les prix

function priceInCents($price = NULL)
{
	$price = trim($price);
	
	if(!isset($price)) return NULL; // s'il n'y a pas de prix, ça va pas
	
	$priceFormatPattern = '/^(\d+)(?:[,|.](\d{2}))?$/';
	preg_match($priceFormatPattern, $price, $matches);
	
	if(!isset($matches[1])) return NULL; // s'il n'y a pas de partie entière, ça va pas
	
	$euro = $matches[1];
	$centimes = (isset($matches[2])) ? $matches[2] : 0;
	
	$price = 100 * $euro + $centimes;
	
	if(is_numeric($price)) return $price;
	else return NULL;
}

if(isset($_POST['priceForm']) && $_POST['priceForm'] == 'add') 
{

	$add_prices_values['title'] = substr(trim($_POST['priceTitle']), 0, 254);
	
	$str = new String;
	
	$str->setStr($_POST['priceHD']);
	$add_prices_values['HD'] = $str->getPriceInCents(); 
	$str->setStr($_POST['priceFD']);
	$add_prices_values['FD'] = $str->getPriceInCents();
	$str->setStr($_POST['priceInAlbum']);
	$add_prices_values['inAlbum'] = $str->getPriceInCents();
	
	if(!empty($add_prices_values['title'])) // On fait quelques vérfications de base
	{	
		$insertPrices = $bdd->prepare("INSERT INTO prices SET title = :title, HD = :HD, FD = :FD, inAlbum = :inAlbum");
		$nb = $insertPrices->execute($add_prices_values);
		
		if($nb > 0) $success[] = "Une nouvelle catégorie de prix a été créée.";
		else $errors[] = "Il manque des informations pour créer la nouvelle catégorie de prix.";	
	}
	else {
		$errors[] = "Il manque des informations pour créer la nouvelle catégorie de prix.";
	}

}
else if(isset($_POST['priceForm']) && $_POST['priceForm'] == 'fusion')
{
	if(is_numeric($_POST['fusionSuppr']) && is_numeric($_POST['fusionRecup']))
	{
		if($_POST['fusionSuppr'] != $_POST['fusionRecup'])
		{
			if($bdd->getNbRow('prices','id = '.$_POST['fusionRecup']) == 1)
			{
				$updatePhoto = $bdd->prepare("UPDATE photos SET id_price = :fusionRecup WHERE id_price = :fusionSuppr");
				$nb = $updatePhoto->execute(array(':fusionRecup' => $_POST['fusionRecup'], ':fusionSuppr' => $_POST['fusionSuppr']));
				
				$deletePrice = $bdd->prepare("DELETE FROM prices WHERE id = :fusionSuppr");
				$nb = $deletePrice->execute(array(':fusionSuppr' => $_POST['fusionSuppr']));
				
				if($nb == 1) $success[] = "La suppression de la catégorie de prix a réussi.";
				else $errors[] = "Erreur lors de la suppression de la catégorie de prix.";
			}
			else $errors[] = "La catégorie d'arrivée n'existe pas !";
		}
		else $infos[] = "Il ne sert à rien de fusionner une catégorie avec elle-même !";
	}
	else $errors[] = "Les catégories à fusionner n'ont pas pu être déterminées.";
}

// On récupère la liste des prix

$select_prices = $bdd->query("SELECT * FROM prices");
$listPrices = $select_prices->fetchAll();