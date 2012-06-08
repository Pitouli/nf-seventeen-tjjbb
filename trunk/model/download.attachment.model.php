<?php

$id_attachment = (is_numeric($getSSection)) ? $getSSection : NULL; 

if(isset($id_attachment))
{
	$getAttchmt = $bdd->prepare("SELECT * FROM attachments WHERE id=:id_attachment LIMIT 1");
	$getAttchmt->execute(array(':id_attachment' => $id_attachment));
	$attchmt = $getAttchmt->fetch();
		
	if(file_exists(DIR_ATTACHMENTS.$attchmt['webname']) && ($_SESSION['usr_status'] == 'admin' || $attchmt['status'] == 'visible')) 
	{		
		header('Content-type: application/force-download');
		header('Content-Length: '.$attchmt['size']);
		header('Content-Disposition: attachment; filename="'.$attchmt['web_title'].$attchmt['extension'].'"');
		header('Content-Transfer-Encoding: binary');
		readfile(DIR_ATTACHMENTS.$attchmt['webname']);
		//header('Location: '.ROOT.DIR_ATTACHMENTS.$attchmt['webname']);
		exit();
	}
	else 
	{
		$getSection = 'error';
		$getSSection = 404;
		
		require DIR_CONTROLLER.'default.controller.php';
		
		exit();
	}
}
else
{
	$getSection = 'error';
	$getSSection = 404;
	
	require DIR_CONTROLLER.'default.controller.php';
	
	exit();
}