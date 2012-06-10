<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo BROWSER_SITE_TITLE ?> | <?php echo $pageTitle ?></title>
<?php require DIR_STYLE.'style.php' ?>
</head>
<body>
<div id="minPage">
<?php require DIR_INC.'report.inc.php' ?>

<div>
    <h1><?php echo $pageTitle ?></h1>
	<?php echo $description ?>
	<p><a href="<?php echo ROOT ?>" title="Retourner à l'accueil">Retour à l'accueil</a></p>    
</div>

</div>
<?php require 'js/js.php' ?>
</body>
</html>
