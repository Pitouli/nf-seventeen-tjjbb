<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="none" />
<title><?php echo BROWSER_SITE_TITLE.' - Administration'?></title>
<?php require 'style/style.php' ?>
</head>

<body>
<div id="menu">
	<ul>
		<li>Menu
			<ul>
				<li><a href="<?php echo ROOT ?>admin.html">Vue générale</a> </li>
		    	<li><a href="<?php echo ROOT ?>admin/gestion/albums.html">Gestion Albums</a> </li>
				<li><a href="<?php echo ROOT ?>admin/gestion/photos.html">Gestion Photos</a></li>
				<li><a href="<?php echo ROOT ?>admin/gestion/shop.html">Gestion Boutique</a></li>
				<li><a href="<?php echo ROOT ?>admin/gestion/cron.html">Gestion Tâches</a></li>
				<li><a href="<?php echo ROOT ?>admin/import.html">Importation</a> </li>
				<li><a href="<?php echo ROOT ?>gallery.html">Retour au site</a></li>
				<li><a href="<?php echo ROOT ?>admin/deconnect.html">Déconnexion</a></li>
			</ul>
		</li>
	</ul>
</div>
<div id="page">