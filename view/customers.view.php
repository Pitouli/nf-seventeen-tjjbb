<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion des clients &amp; réservation</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez gérer les clients, que ce soit l'ajout d'un nouveau ou la consultation d'un existant, ainsi que gérer les réservations.</p>
	<p>La gestion des réservations est accessible à partir de chaque client.</p>
</div>

<div class="corps">

	<h2>Ajout d'un nouveau client</h2>

	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=new">
		<table class="largeTable">
			<tr>
				<td><label for="newNom">Nom&nbsp;: </label></td>
				<td><input name="newNom" title="Nom du nouveau client" type="text" id="newNom" class="inputText extended" value="" /></td>
				<td><label for="newPrenom">Prénom&nbsp;: </label></td>
				<td><input name="newPrenom" title="Prénom du nouveau client (Facultatif dans le cas d'une entreprise)" type="text" id="newPrenom" class="inputText extended" value="" /></td>
				<td><label for="newEntreprise">Entreprise&nbsp;: </label><input type="radio" id="newEntreprise" name="newStatut" value="entreprise" /></td>
				<td><label for="newParticulier">Particulier&nbsp;: </label><input type="radio" id="newParticulier" name="newStatut" value="particulier" checked="checked" /></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouveau client ?');"value="Ajouter client" /></td>
			</tr>
		</table>
	</form>

	<h2>Recherche des clients existants</h2>
	
	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=search">
		<table class="largeTable">
			<tr>
				<td><label for="searchNom">Nom&nbsp;: </label></td>
				<td><input name="searchNom" title="Partie du nom du client" type="text" id="searchNom" class="inputText extended" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" /></td>
				<td><label for="searchPrenom">Prénom&nbsp;: </label></td>
				<td><input name="searchPrenom" title="Partie du prénom du client" type="text" id="searchPrenom" class="inputText extended" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" /></td>
				<td><label for="searchEntreprise">Entreprise&nbsp;: </label><input type="checkbox" id="searchEntreprise" name="searchEntreprise" value="checked" <?php if(isset($_POST['searchEntreprise']) && $_POST['searchEntreprise'] == "checked") echo 'checked="checked" ' ?>/></td>
				<td><label for="searchParticulier">Particulier&nbsp;: </label><input type="checkbox" id="searchParticulier" name="searchParticulier" value="checked" <?php if(isset($_POST['searchParticulier']) && $_POST['searchParticulier'] == "checked") echo 'checked="checked" ' ?>/></td>
				<td><input type="submit" class="inputSubmit" value="Rechercher client" /></td>
			</tr>
		</table>
	</form>
	
	<?php if(isset($resultSearch)) require DIR_INC.'aeroport.search.inc.php'; ?>
	
	<?php if(isset($resultShow)) require DIR_INC.'aeroport.show.inc.php'; ?>

</div>

<?php require DIR_INC.'footer.inc.php' ?> 