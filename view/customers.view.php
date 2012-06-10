<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion des clients &amp; réservation</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez gérer les clients, que ce soit l'ajout d'un nouveau ou la consultation d'un existant, ainsi que gérer les réservations.</p>
	<p>La gestion des réservations est accessible à partir de chaque client.</p>
</div>

<div class="corps">

	<h2>Ajout d'un nouveau client</h2>

	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=newCustomer">
		<table class="largeTable">
			<tr>
				<td><label for="newNom">Nom&nbsp;: </label></td>
				<td><input name="nom" title="Nom du nouveau client" type="text" id="newNom" class="inputText" value="" /></td>
				<td><label for="newPrenom">Prénom&nbsp;: </label></td>
				<td><input name="prenom" title="Prénom du nouveau client (Facultatif dans le cas d'une entreprise)" type="text" id="newPrenom" class="inputText" value="" /></td>
				<td><label for="newEntreprise">Entreprise&nbsp;: </label><input type="radio" id="newEntreprise" name="statut" value"entreprise" /></td>
				<td><label for="newParticulier">Particulier&nbsp;: </label><input name="statut" type="radio" id="newParticulier" value="particulier" checked="checked" /></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouveau client ?');"value="Ajouter client" /></td>
			</tr>
		</table>
	</form>

	<h2>Recherche des clients existants</h2>
	
	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=searchCustomer">
		<table class="largeTable">
			<tr>
				<td><label for="searchNom">Nom&nbsp;: </label></td>
				<td><input name="nom" title="Partie du nom du client" type="text" id="searchNom" class="inputText" value="" /></td>
				<td><label for="searchPrenom">Prénom&nbsp;: </label></td>
				<td><input name="prenom" title="Partie du prénom du client" type="text" id="searchPrenom" class="inputText" value="" /></td>
				<td><label for="searchEntreprise">Entreprise&nbsp;: </label><input type="checkbox" id="searchEntreprise" name="entreprise" /></td>
				<td><label for="searchParticulier">Particulier&nbsp;: </label><input type="checkbox" id="searchParticulier" name="particulier" /></td>
				<td><input type="submit" class="inputSubmit" value="Rechercher client" /></td>
			</tr>
		</table>
	</form>
	
	<?php 
		if(isset($resultSearch))
		{
	?>
	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=newCustomer">
		<table class="largeTable tableListPrices">
			<tr class="trListPrices">
				<td>Intitulé de la catégorie de prix</td>
				<td>Prix version HD seule</td>
				<td>Prix version FD seule</td>
				<td>Prix si achat de l'album complet</td>
				<td colspan="2" title="On peut fusionner deux catégories de prix. Les photos de la 1ere hériteront des prix de la 2eme"><input type="submit" class="inputSubmit fusionSubmit" value="Fusion" id="price_fusion" /></td>
			</tr>
			<em>
		<?php
			foreach($resultSearch as $client)
			{
				print_r($client);
		?>
			
			<!-- <tr class="trListPrices">
				<td><input type="hidden" name="priceId" class="priceId" value="<?php echo $price['id']; ?>" /><input name="title" title="Nom de la catégorie de prix" type="text" class="inputText priceTitle updateAjax" value="<?php echo $price['title']; ?>" id="price_title_<?php echo $price['id']; ?>" /></td>
				<td><input name="HD" title="Prix en cas d'achat version HD à l'unité" type="text" class="inputText priceHD updateAjax" value="<?php echo number_format($price['HD']/100,2,'.','') ?>" id="price_HD_<?php echo $price['id']; ?>" /></td>
				<td><input name="FD" title="Prix en cas d'achat version FD à l'unité" type="text" class="inputText priceFD updateAjax" value="<?php echo number_format($price['FD']/100,2,'.','') ?>" id="price_FD_<?php echo $price['id']; ?>" /></td>
				<td><input name="inAlbum" title="Prix en cas d'achat de l'album complet" type="text" class="inputText priceInFolder updateAjax" value="<?php echo number_format($price['inAlbum']/100,2,'.','') ?>" id="price_inAlbum_<?php echo $price['id']; ?>" /></td>
				<td><input name="fusionSuppr" title="Catégorie supprimée dans la fusion" type="radio" value="<?php echo $price['id']; ?>" /></td>
				<td><input name="fusionRecup" title="Catégorie réceptrice dans la fusion" type="radio" value="<?php echo $price['id']; ?>" /></td>
			</tr> -->
		<?php
			}
		?>
		</em>
		</table>
	</form>
	<?php
		}
	?>

</div>

<?php require DIR_INC.'footer.inc.php' ?> 