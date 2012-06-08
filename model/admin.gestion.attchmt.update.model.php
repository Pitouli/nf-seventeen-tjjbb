<?php

if(isset($_POST['update_attchmt_type']) && !empty($_POST['update_attchmt_type'])) {
	
	if($_POST['update_attchmt_type'] == 'attchmtTitle') {
	
		$title = trim($_POST['update_attchmt_value']);
		$id = $_POST['update_attchmt_id'];
		
		$str = new String;
		
		$str->setStr($title);
		$web_title = $str->getWebify();
		$web_title = substr($web_title, 0, 50);
		
		if(!empty($web_title))
			{
				$update_attchmt_title = $bdd->prepare("UPDATE attachments SET title=:title, web_title=:web_title WHERE id=:id LIMIT 1");
				
				if(is_numeric($id)) {
					$update_attchmt_title->execute(array('title' => $title, 'web_title' => $web_title, 'id' => $id));
					$success[] = 'Le titre de la pièce-jointe a bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'Le titre de la pièce-jointe n\'a pas pu être mis à jour : la pièce-jointe à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}	
			}
		else
			{
				$errors[] = 'Le titre de la pièce-jointe n\'a pas pu être mis à jour. NB: il ne doit pas être composé uniquement de caractères spéciaux.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	elseif($_POST['update_attchmt_type'] == 'attchmtAlbum') {
	
		$id_album = trim($_POST['update_attchmt_value']);
		$id = $_POST['update_attchmt_id'];
		
		if(is_numeric($id_album))
			{				
				$update_attchmt_album = $bdd->prepare("UPDATE attachments SET id_album=:id_album WHERE id=:id LIMIT 1");
				
				if(is_numeric($id)) {
					$update_attchmt_album->execute(array('id_album' => $id_album, 'id' => $id));
					$success[] = 'L\'album de la pièce-jointe a bien été mis à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'L\'album de la pièce-jointe n\'a pas pu être mis à jour : la pièce-jointe à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}					
			}
		else
			{
				$errors[] = 'L\'album de la pièce-jointe n\'a pas pu être mis à jour.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	elseif($_POST['update_attchmt_type'] == 'attchmtStatus') {
	
		$status = trim($_POST['update_attchmt_value']);
		$id = $_POST['update_attchmt_id'];
		
		if(!empty($status))
			{			
				$update_attchmt_status = $bdd->prepare("UPDATE attachments SET status=:status WHERE id=:id LIMIT 1");;
				
				if(is_numeric($id)) {
					$update_attchmt_status->execute(array('status' => $status, 'id' => $id));
					$success[] = 'La visibilité de la pièce-jointe a bien été mise à jour';				
					if($getController == 'ajax') { echo TRUE; }
				}
				else {
					$errors[] = 'La visibilité de la pièce-jointe n\'a pas pu être mise à jour : la pièce-jointe à modifier n\' a pas pu être déterminée.';
					if($getController == 'ajax') { echo FALSE; }
				}					
			}
		else
			{
				$errors[] = 'La visibilité de la pièce-jointe n\'a pas pu être mise à jour.';
				
				if($getController == 'ajax') { echo FALSE; }			
			}
	}
	
	// On supprime le cache des albums de la galerie

	require DIR_MODEL.'admin.cleanCache.model.php';
}
else
{
	if($getController == 'ajax') { echo FALSE; }
}