<?php

$bdd = new BDD; // On crée directement un objet PDO

if($getSection == 'admin')
	{
		if($_SESSION['usr_status'] != 'admin') 
			{
				exit();
			}
		elseif($getSSection == 'updatePhoto') 
			{		
				require DIR_MODEL.'admin.gestion.photos.update.model.php'; 
			}
		elseif($getSSection == 'updateShop') 
			{		
				require DIR_MODEL.'admin.gestion.shop.update.model.php'; 
			}
		elseif($getSSection == 'updateAttchmt') 
			{		
				require DIR_MODEL.'admin.gestion.attchmt.update.model.php'; 
			}
		elseif($getSSection == 'loadAlbTree') 
			{		
				require DIR_MODEL.'admin.gestion.albums.loadAlbTree.model.php'; 
				require DIR_INC.'admin.gestion.albums.inc.php';
			}
		elseif($getSSection == 'stats') 
			{		
				require DIR_MODEL.'admin.stats.model.php';
				require DIR_INC.'admin.stats.inc.php';
			}
		elseif($getSSection == 'logbook') 
			{		
				require DIR_MODEL.'admin.logbook.model.php';
				require DIR_INC.'admin.logbook.inc.php';
			}
	}
elseif($getSection == 'gallery')
	{
		if($getSSection == 'cartContent') 
			{		
				require DIR_MODEL.'gallery.cartContent.model.php';
				require DIR_INC.'gallery.cartContent.inc.php';
			}
	}