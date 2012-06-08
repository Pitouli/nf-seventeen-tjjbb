<?php

if(isset($_POST['album_id']) && is_numeric($_POST['album_id']))
{
	if($_POST['part'] == 'form_album_edit' || $_POST['part'] == 'form_album_suppr')
	{	
		$sql = "SELECT id, id_parent, title, description, hide FROM albums WHERE id = :idAlbum LIMIT 1";
		$select = $bdd->prepare($sql);
		$select->execute(array('idAlbum' => $_POST['album_id']));
		$alb = $select->fetch();
		
		if($_POST['part'] == 'form_album_edit')
		{
			$sql = "SELECT * FROM prices";
			$result = $bdd->query($sql);
			$listPrices = $result->fetchAll();
		}
	}
	else if($_POST['part'] == 'form_album_attchmt')
	{		
		$recupAttachments = $bdd->prepare("SELECT id, title, id_album, status FROM attachments WHERE id_album = :id_album ORDER BY title ASC");		
		$recupAttachments->execute(array('id_album' => $_POST['album_id']));	
		$attachments = $recupAttachments->fetchAll();
	}
}