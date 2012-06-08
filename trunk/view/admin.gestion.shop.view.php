<?php require DIR_INC.'admin.header.inc.php' ?>

<h1>Gestion de la boutique</h1>

<?php require DIR_INC.'admin.report.inc.php' ?>

<div class="explain">
  <p>La gestion de la boutique se fait dans cette section.</p>
    <p>Cela se résume à choisir les catégories de prix.</p>
    <ul>
    	<li>On peut choisir le nom de la catégorie</li>
    	<li>Puis les prix associés 
    		<ul>
    			<li>En cas d'achat de la photo HD à l'unité</li>
    			<li>En cas d'achat de l'album qui la contient</li>
    			<li>En cas d'achat de la photo en FD</li>
   			</ul>
    	</li>
   	</ul>
    <p>Si besoin, on peut créer une nouvelle catégorie de prix.</p>
    <p>Rappel : paypal prélève 0.25€ fixe par achat, plus 3.4% de variable.</p>
</div>

<div class="corps">

	<h2>Création d'une nouvelle catégorie de prix</h2>

	<form method="post" action="<?php echo ROOT; ?>admin/gestion/shop.html">
		<input name="priceForm" type="hidden" value="add" />
		<table class="largeTable tableListPrices">
			<tr class="trListPrices">
				<td>Intitulé de la catégorie de prix</td>
				<td>Prix version HD seule</td>
				<td>Prix version FD seule</td>
				<td>Prix si achat de l'album complet</td>
				<td>Valider</td>
			</tr>
			<tr class="trListPrices">
				<td><input name="priceTitle" title="Nom de la catégorie de prix" type="text" class="inputText priceTitle" value="" id="priceTitle_new" /></td>
				<td><input name="priceHD" title="Prix en cas d'achat version HD à l'unité" type="text" class="inputText priceHD" value="" id="priceHD_new" /></td>
				<td><input name="priceFD" title="Prix en cas d'achat version FD à l'unité" type="text" class="inputText priceFD" value="" id="priceFD_new" /></td>
				<td><input name="priceInAlbum" title="Prix en cas d'achat de l'album complet" type="text" class="inputText priceInFolder" value="" id="priceInFolder_new" /></td>
				<td><input type="submit" class="inputSubmit priceSubmit" value="Nouvelle catégorie" id="price_new" /></td>
			</tr>
		</table>
	</form>

	<h2>Gestion des catégories de prix existantes</h2>
	
	<form method="post" action="<?php echo ROOT; ?>admin/gestion/shop.html">
		<input name="priceForm" type="hidden" value="fusion" />
		<table class="largeTable tableListPrices">
			<tr class="trListPrices">
				<td>Intitulé de la catégorie de prix</td>
				<td>Prix version HD seule</td>
				<td>Prix version FD seule</td>
				<td>Prix si achat de l'album complet</td>
				<td colspan="2" title="On peut fusionner deux catégories de prix. Les photos de la 1ere hériteront des prix de la 2eme"><input type="submit" class="inputSubmit fusionSubmit" value="Fusion" id="price_fusion" /></td>
			</tr>
		<?php
			foreach($listPrices as $price)
			{
		?>
			<tr class="trListPrices">
				<td><input type="hidden" name="priceId" class="priceId" value="<?php echo $price['id']; ?>" /><input name="title" title="Nom de la catégorie de prix" type="text" class="inputText priceTitle updateAjax" value="<?php echo $price['title']; ?>" id="price_title_<?php echo $price['id']; ?>" /></td>
				<td><input name="HD" title="Prix en cas d'achat version HD à l'unité" type="text" class="inputText priceHD updateAjax" value="<?php echo number_format($price['HD']/100,2,'.','') ?>" id="price_HD_<?php echo $price['id']; ?>" /></td>
				<td><input name="FD" title="Prix en cas d'achat version FD à l'unité" type="text" class="inputText priceFD updateAjax" value="<?php echo number_format($price['FD']/100,2,'.','') ?>" id="price_FD_<?php echo $price['id']; ?>" /></td>
				<td><input name="inAlbum" title="Prix en cas d'achat de l'album complet" type="text" class="inputText priceInFolder updateAjax" value="<?php echo number_format($price['inAlbum']/100,2,'.','') ?>" id="price_inAlbum_<?php echo $price['id']; ?>" /></td>
				<td><input name="fusionSuppr" title="Catégorie supprimée dans la fusion" type="radio" value="<?php echo $price['id']; ?>" /></td>
				<td><input name="fusionRecup" title="Catégorie réceptrice dans la fusion" type="radio" value="<?php echo $price['id']; ?>" /></td>
			</tr>
		<?php
			}
		?>
		</table>
	</form>
</div>

<?php require DIR_INC.'admin.footer.inc.php' ?> 