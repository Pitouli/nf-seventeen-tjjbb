<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT ?>js/jquery.colorbox.min.js"></script>

<?php 
if($getController == 'gallery') 
{ 
?>

<script type="text/javascript" src="<?php echo ROOT ?>js/jquery.tipsy.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT ?>js/perso.gallery.js"></script>

<?php 
} 
elseif($getController == 'admin') 
{ 
?>

<script type="text/javascript" src="<?php echo ROOT ?>js/perso.admin.js"></script>
<script type="text/javascript" src="<?php echo ROOT ?>js/jquery.autoresize.min.js"></script>

<?php 
	if(!isset($getSection) OR $getSection == NULL)
	{
?>

<script type="text/javascript" src="<?php echo ROOT ?>js/perso.admin.default.js"></script>

<?php
	}
	elseif($getSection == 'gestion' && $getSSection == 'photos') 
	{
?>

<script type="text/javascript" src="<?php echo ROOT ?>js/jquery.coloranimate.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT ?>js/perso.admin.gestion.photos.js"></script>

<?php 
	}
	elseif($getSection == 'gestion' && $getSSection == 'shop') 
	{
?>

<script type="text/javascript" src="<?php echo ROOT ?>js/jquery.coloranimate.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT ?>js/perso.admin.gestion.shop.js"></script>

<?php 
	}
	elseif($getSection == 'gestion' && $getSSection == 'albums') 
	{
?>

<script type="text/javascript" src="<?php echo ROOT ?>js/jquery.coloranimate.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT ?>js/perso.admin.gestion.albums.js"></script>

<?php
	}
} 
?>

<?php
if($getController != 'admin')
{
?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo GA_ACCOUNT ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php
}
?>