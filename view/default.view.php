<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="google-site-verification" content="<?php echo GGL_SITE_VERIF ?>" />
<link rel="canonical" href="<?php echo SITE_DOMAIN.ROOT ?>" />
<title><?php echo $pageTitle ?></title>
<?php require 'style/style.php' ?>
</head>

<body>
<div id="pageDefault">
	<div id="cuerpo" style="background-image: url('<?php echo $urlBg ?>')">
		<div id="introduction">
			<h1><?php echo $title ?></h1>
			<p><?php echo $description ?></p>
		</div>
		<div id="menu">
			<ul>
				<li><a href="<?php echo ROOT ?>gallery.html" title="Accéder à la galerie"><strong>Galerie</strong></a></li>
				<li><a href="<?php echo BLOG ?>" title="Accéder au blog">Théologie</a></li>
				<li><a href="<?php echo BLOG ?>static2/plus" title="En savoir plus">+</a></li>
			</ul>			
		</div>
		<p id="titlePhoto"><a href="<?php echo $linkAlbum ?>" title="Ouvrir l'album &laquo;&nbsp;<?php echo $album['title'] ?>&nbsp;&raquo;"><?php echo $textLink ?></a></p>
	</div>
	<div id="footer">			
		<div id="footerContent">
			<p><?php echo SITE_FOOTER ?></p>
		</div>
	</div>
</div>
<noscript>
	<p id="noscript">Nous recommandons vivement d'activer javascript ! <a href="http://www.enable-javascript.com/fr/">Aide</a></p>
</noscript>
<?php require 'js/js.php' ?>
</body>
</html>