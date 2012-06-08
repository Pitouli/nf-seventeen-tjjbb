<?php

if(isset($_POST['update_photo_type']) && !empty($_POST['update_photo_type'])) {
	
	if($_POST['update_photo_type'] == 'photoTitle') {
	
		$title = trim($_POST['update_photo_value']);
		$id = $_POST['update_photo_id'];
		
		$str = new String;
		
		$str->setStr($title);
		$web_title = $str->getWebify();
		$web_title = substr($web_title, 0, 50);
		
		if(!empty($web_title))
			{
				$update_photo_title = $bdd->prepare("UPDATE photos SET title=:title, web_title=:web_title WHERE id=:id LIMIT 1");
				
				if(is_array($id)) {
					foreach($id as $idPhoto) {
						if(is_numeric($idPhoto)) {
							$update_photo_title->execute(array('title' => $title, 'web_title' => $web_title, 'id' => $idPhoto));
						}
					}
					$success[] = 'Le titre des photos a normalement bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				elseif(is_numeric($id)) {
					$update_photo_title->execute(array('title' => $title, 'web_title' => $web_title, 'id' => $id));
					$success[] = 'Le titre de la photo a bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'Le titre de la photo n\'a pas pu être mis à jour : la photo à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}	
			}
		else
			{
				$errors[] = 'Le titre de la photo n\'a pas pu être mis à jour. NB: il ne doit pas être composé uniquement de caractères spéciaux.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	elseif($_POST['update_photo_type'] == 'photoPrice') {
	
		$id_price = $_POST['update_photo_value'];
		$id = $_POST['update_photo_id'];
		
		if(is_numeric($id_price) && $bdd->getNbRow('prices', 'id='.$id_price) == 1)
			{
				$update_photo_price = $bdd->prepare("UPDATE photos SET id_price=:id_price WHERE id=:id LIMIT 1");
				
				if(is_array($id)) {
					foreach($id as $idPhoto) {
						if(is_numeric($idPhoto)) {
							$update_photo_price->execute(array('id_price' => $id_price, 'id' => $idPhoto));
						}
					}
					$success[] = 'Le prix des photos a normalement bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				elseif(is_numeric($id)) {
					$update_photo_price->execute(array('id_price' => $id_price, 'id' => $id));
					$success[] = 'Le prix de la photo a bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'Le prix de la photo n\'a pas pu être mis à jour : la photo à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}					
			}
		else
			{
				$errors[] = 'Le prix de la photo n\'a pas pu être mis à jour.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	elseif($_POST['update_photo_type'] == 'photoAlbum') {
	
		$id_album = trim($_POST['update_photo_value']);
		$id = $_POST['update_photo_id'];
		
		if(is_numeric($id_album))
			{				
				$update_photo_album = $bdd->prepare("UPDATE photos SET id_album=:id_album WHERE id=:id LIMIT 1");
				
				if(is_array($id)) {
					foreach($id as $idPhoto) {
						if(is_numeric($idPhoto)) {
							$update_photo_album->execute(array('id_album' => $price, 'id' => $idPhoto));
						}
					}
					$success[] = 'L\'album des photos a normalement bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				elseif(is_numeric($id)) {
					$update_photo_album->execute(array('id_album' => $id_album, 'id' => $id));
					$success[] = 'L\'album de la photo a bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'L\'album de la photo n\'a pas pu être mis à jour : la photo à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}					
			}
		else
			{
				$errors[] = 'L\'album de la photo n\'a pas pu être mis à jour.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	elseif($_POST['update_photo_type'] == 'photoStatus') {
	
		$status = trim($_POST['update_photo_value']);
		$id = $_POST['update_photo_id'];
		
		if(!empty($status))
			{			
				$update_photo_status = $bdd->prepare("UPDATE photos SET status=:status WHERE id=:id LIMIT 1");;
				
				if(is_array($id)) {
					foreach($id as $idPhoto) {
						if(is_numeric($idPhoto)) {
							$update_photo_status->execute(array('status' => $status, 'id' => $idPhoto));
						}
					}
					$success[] = 'La visibilité des photos a normalement bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				elseif(is_numeric($id)) {
					$update_photo_status->execute(array('status' => $status, 'id' => $id));
					$success[] = 'La visibilité de la photo a bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'La visibilité de la photo n\'a pas pu être mise à jour : la photo à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}					
			}
		else
			{
				$errors[] = 'La visibilité de la photo n\'a pas pu être mise à jour.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	
	// On supprime le cache des albums de la galerie
	
	require DIR_MODEL.'admin.cleanCache.model.php';
}