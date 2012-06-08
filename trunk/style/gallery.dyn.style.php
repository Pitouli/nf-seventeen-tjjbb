<?php
header("Content-type: text/css"); // On déclare une feuille de style css
header("Cache-Control: no-cache, must-revalidate"); // On empêche la mise en cache

require '../global/config.php';

$galMinSize = (isset($_COOKIE['galMinSize']) AND is_numeric($_COOKIE['galMinSize']) AND $_COOKIE['galMinSize'] >= 100 AND $_COOKIE['galMinSize'] <= 200) ? $_COOKIE['galMinSize'] : GAL_MIN_SIZE;
$galMinShadow = (isset($_COOKIE['galMinShadow'])) ? $_COOKIE['galMinShadow'] : GAL_MIN_SHADOW;
$galMinRounded = (isset($_COOKIE['galMinRounded'])) ? $_COOKIE['galMinRounded'] : GAL_MIN_ROUNDED;

?>

.galMin {
	width: <?php echo $galMinSize ?>px;
}
.galMinPImage {
	width: <?php echo $galMinSize ?>px;
	height: <?php echo $galMinSize ?>px;
}
#testGalMinSize {
	width: <?php echo $galMinSize ?>px;
	height: <?php echo $galMinSize ?>px;	
} 

<?php
if($galMinShadow)
	{
?>

.galMinImage {
	-moz-box-shadow: 5px 5px 5px #050505;
	-webkit-box-shadow: 5px 5px 5px #050505;
	box-shadow: 5px 5px 5px #050505;
}

<?php 
	}
?>

<?php
if($galMinRounded)
	{
?>

.galPictImage {
	-moz-border-radius: 10px; 
	-webkit-border-radius: 10px;
	border-radius: 10px; 
}

<?php 
	}
?>