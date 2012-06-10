<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="none" />
<title><?php echo BROWSER_SITE_TITLE.' | '.$pageTitle ?></title>
<?php require 'style/style.php' ?>
</head>

<body>
<div id="menu">
	<ul>
		<li>Menu
			<ul>
				<li><a href="<?php echo ROOT ?>?c=customers" title="Gérer les clients et les réservations">Clients</a> </li>
		    	<li><a href="<?php echo ROOT ?>?c=fleet" title="Gérer les modèles et les avions">Flotte</a> </li>
				<li><a href="<?php echo ROOT ?>?c=places" title="Gérer les villes, aéroports et terminaux">Lieux</a></li>
				<li><a href="<?php echo ROOT ?>?c=flights" titlte="Gérer les vols">Vols</a></li>
		    	<li><a href="<?php echo ROOT ?>?c=stats" title="Apprendre quelques statistiques">Stats</a> </li>
				<li><a href="<?php echo ROOT ?>?c=deconnect" title="Se déconnecter de l'administration">Déco.</a></li>
			</ul>
		</li>
	</ul>
</div>
<div id="page">