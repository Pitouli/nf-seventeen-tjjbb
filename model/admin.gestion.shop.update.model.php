<?php

if(isset($_POST['update_price_type']) && !empty($_POST['update_price_type'])) {
	
	if($_POST['update_price_type'] == 'title') {
	
		$title = trim($_POST['update_price_value']);
		$id = $_POST['update_price_id'];

		if(!empty($title))
			{
				$update_price_title = $bdd->prepare("UPDATE prices SET title=:title WHERE id=:id LIMIT 1");
				
				if(is_numeric($id)) {
					$update_price_title->execute(array('title' => $title, 'id' => $id));
					$success[] = 'Le titre de la catégorie de prix a bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'Le titre de la catégorie de prix n\'a pas pu être mis à jour : la catégorie de prix à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}	
			}
		else
			{
				$errors[] = 'Le titre de la catégorie de prix n\'a pas pu être mis à jour.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	elseif($_POST['update_price_type'] == 'HD' || $_POST['update_price_type'] == 'FD' || $_POST['update_price_type'] == 'inAlbum') {
	
		$str = new String;
		
		$str->setStr($_POST['update_price_value']);
		$price = $str->getPriceInCents();

		$id = $_POST['update_price_id'];

		if(is_numeric($id) && is_numeric($price))
			{
				if($bdd->getNbRow('prices', 'id='.$id) == 1) // Si la catégorie de prix demandée existe
					{
						$update_price = $bdd->prepare("UPDATE prices SET ".$_POST['update_price_type']."=:price WHERE id=:id LIMIT 1");
						$nb = $update_price->execute(array('price' => $price, 'id' => $id));
						
						if($nb > 0) {						
							$success[] = 'Le prix '.$_POST['update_price_type'].' de la catégorie de prix a bien été mis à jour';				
							if($getController == 'ajax') { echo TRUE; }	
						}
						else {					
							$errors[] = 'Le prix '.$_POST['update_price_type'].' de la catégorie de prix n\'a pas pu être mis à jour.';				
							if($getController == 'ajax') { echo FALSE; }	
						}
					}
				else
					{
						$errors[] = 'Le prix '.$_POST['update_price_type'].' de la catégorie de prix n\'a pas pu être mis à jour.';
						
						if($getController == 'ajax') { echo FALSE; }			
					}
			}
		else
			{
				$errors[] = 'Le prix '.$_POST['update_price_type'].' de la catégorie de prix n\'a pas pu être mis à jour.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	
	// On supprime le cache des albums de la galerie
	
	require DIR_MODEL.'admin.cleanCache.model.php';
}