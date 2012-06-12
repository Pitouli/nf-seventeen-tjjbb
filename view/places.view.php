<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion des villes, aeroports, et terminaux</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez gérer l'ajout ou la suppression de lieux, tel que les villes, aeroports, et terminaux.</p>
</div>

<div class="corps">

	<h2>Ajout d'une nouvelle ville</h2>

	<table class="largeTable">
		<form method="post" action="<?php echo ROOT; ?>?v=ville&s1=new">
			<tr>
				<td><label for="newVille">Ville&nbsp;: </label></td>
				<td><input name="newVille" title="Nom de la nouvelle ville" type="text" id="newVille" class="inputText extended" value="" /></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'une nouvelle ville ?');"value="Ajouter Ville" /></td>
			</tr>			
		</form>
		<form method="post" action="<?php echo ROOT; ?>?v=ville&s1=del">
			<tr>
				<td><select name="ville" id="ville"></td>
					<option values="villes1">ville1</option>
					<option values="villes1">ville1</option>
				</select>
			</tr>
		</form>
	</table>

 	<h2>Recherche des clients existants</h2>
<!-- 	
	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=search">
		<table class="largeTable">
			<tr>
				<td><label for="searchNom">Nom&nbsp;: </label></td>
				<td><input name="searchNom" title="Partie du nom du client" type="text" id="searchNom" class="inputText extended" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" /></td>
				<td><label for="searchPrenom">Prénom&nbsp;: </label></td>
				<td><input name="searchPrenom" title="Partie du prénom du client" type="text" id="searchPrenom" class="inputText extended" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" /></td>
				<td><label for="searchEntreprise">Entreprise&nbsp;: </label><input type="checkbox" id="searchEntreprise" name="searchEntreprise" value="checked" <?php if($_POST['searchEntreprise'] == "checked") echo 'checked="checked" ' ?>/></td>
				<td><label for="searchParticulier">Particulier&nbsp;: </label><input type="checkbox" id="searchParticulier" name="searchParticulier" value="checked" <?php if($_POST['searchParticulier'] == "checked") echo 'checked="checked" ' ?>/></td>
				<td><input type="submit" class="inputSubmit" value="Rechercher client" /></td>
			</tr>
		</table>
	</form>
-->	
	<!-- <?php if(isset($resultSearch)) require DIR_INC.'customers.search.inc.php'; ?> -->
	
	<!-- <?php if(isset($resultShow)) require DIR_INC.'customers.show.inc.php'; ?>  -->
 
</div>


<?php require DIR_INC.'footer.inc.php' ?> 