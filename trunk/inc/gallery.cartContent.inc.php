<?php 
if((!isset($list_photos_HD) || $list_photos_HD == array()) && (!isset($list_photos_FD) || $list_photos_FD == array()) && (!isset($list_albums) || $list_albums == array()))
{
?>
<p>Le caddie est vide. Pour l'instant...</p>
<?php
}
else
{
?>
<p><strong>Photos HD&nbsp;:</strong></p>
<?php
	if(isset($list_photos_HD) && $list_photos_HD != array()) 
	{
?>
<ul>
<?php
		foreach($list_photos_HD as $photo) {
			//$photo['url_sd'] = ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension'];
			//$photo['price'] = number_format($photo['HD']/100,2,'.','');
?>
	<li>
		<img src="<?php echo ROOT.DIR_STYLE ?>images/pictView.png" alt="Voir" />
		<a href="#" onclick="return switchInCart(<?php echo $photo['id'] ?>,'HD')" class="add2cart" title="Enlever la photo HD du caddie"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictSuppr.png" alt="Suppr" /></a>
		<?php echo $photo['title'] ?> <em>(<?php echo $photo['price'] ?>€)</em>
	</li>
<?php
		}
?>
</ul>
<?php
	}
	else
	{
?>
<p><em>Pas de photo HD dans le caddie. Pour l'instant...</em></p>
<?php
	}
?>
<p><strong>Photos FD&nbsp;:</strong></p>
<?php
	if(isset($list_photos_FD) && $list_photos_FD != array()) 
	{
?>
<ul>
<?php
		foreach($list_photos_FD as $photo) {
			//$photo['url_sd'] = ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension'];
			//$photo['price'] = number_format($photo['HD']/100,2,'.','');
?>
	<li>
		<img src="<?php echo ROOT.DIR_STYLE ?>images/pictView.png" alt="Voir" />
		<a href="#" onclick="return switchInCart(<?php echo $photo['id'] ?>,'FD')" class="add2cart" title="Enlever la photo FD du caddie"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictSuppr.png" alt="Suppr" /></a>
		<?php echo $photo['title'] ?> <em>(<?php echo $photo['price'] ?>€)</em>
	</li>
<?php
		}
?>
</ul>
<?php
	}
	else
	{
?>
<p><em>Pas de photo FD dans le caddie Pour l'instant...</em></p>
<?php
	}
?>
<p><strong>Albums&nbsp;:</strong></p>
<?php
	if(isset($list_albums) && $list_albums != array()) 
	{
?>
<ul>
<?php
		foreach($list_albums as $album) {
?>
	<li>
		<img src="<?php echo ROOT.DIR_STYLE ?>images/pictView.png" alt="Voir" />
		<a href="#" onclick="return switchInCart(<?php echo $album['id'] ?>,'alb')" class="add2cart" title="Enlever l'album du caddie"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictSuppr.png" alt="Suppr" /></a>
		<?php echo $album['title'] ?> <em>(<?php echo $album['price'] ?>€)</em>
	</li>
<?php
		}
?>
</ul>
<?php
	}
	else
	{
?>
<p><em>Pas d'album dans le caddie. Pour l'instant...</em></p>
<?php
	}
?>
<p><strong>Prix du caddie&nbsp;: <?php echo $cartPrice ?>€</strong></p>
<?php 
}
?>
