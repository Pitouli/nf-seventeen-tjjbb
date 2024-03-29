<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion des villes, aeroports, et terminaux</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez gérer l'ajout ou la suppression de lieux, tel que les villes, aeroports, et terminaux.</p>
</div>

<div class="corps">

	<h2>Ajout d'une nouvelle ville</h2>

	<table class="largeTable">
		<tr>
		<form method="post" action="<?php echo ROOT; ?>?c=places&s1=newville">
				<td><label for="newVille">Ville&nbsp;: </label></td>
				<td><input name="newVille" title="Nom de la nouvelle ville" type="text" id="newVille" class="inputText extended" value="" /></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'une nouvelle ville ?');"value="Ajouter Ville" /></td>
		</form>
		<form method="post" action="<?php echo ROOT; ?>?c=places&s1=delville">
			<td>
				<select name="ville" id="ville">
						<option value="">Selectionner une ville
						<?php foreach($listeVilles as $ville)
						{
						?>
						  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
				</select>
			</td>	
			<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous la suppression de la ville ? Cela supprimera les aeroports et terminaux associés');"value="Supprimer Ville" /></td>
		</form>
		</tr>
	</table>

	
 	<h2>Ajout d'un aeroport</h2>
	
	<table class="largeTable">
		<tr>
		<form method="post" action="<?php echo ROOT; ?>?c=places&s1=newaeroport">
				<td><label for="newAeroport">Aeroport&nbsp;: </label></td>
				<td><input name="newAeroport" title="Nom de l'aeroport" type="text" id="newAeroport" class="inputText extended" value="" /></td>
				<td><select name="ville" id="ville">
						<option value="">Selectionner une ville
						<?php foreach($listeVilles as $ville)
						{
						?>
						  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
				</select></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouvel aeroport ?');"value="Ajouter Aeroport" /></td>
		</form>
		</tr>
	</table>
		
	<h2>Recherche d'un aeroport</h2>
	
	<form method="post" action="<?php echo ROOT; ?>?c=places&s1=searchaeroport">
		<table class="largeTable">
			<tr>
				<td><label for="searchAeroport">Aeroport&nbsp;: </label></td>
				<td><input name="searchAeroport" title="Nom de l'aeroport" type="text" id="searchAeroport" class="inputText extended" value="<?php if(isset($_POST['searchAeroport'])) echo $_POST['searchAeroport'] ?>" /></td>
				<td><select name="ville" id="ville">
						<option value="">Selectionner une ville
						<?php foreach($listeVilles as $ville)
						{
						?>
						  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
				</select></td>
				<td><input type="submit" class="inputSubmit" value="Recherche Aeroports" /></td>
			</tr>
		</table>
	</form>

	<?php if(isset($resultSearch)) require DIR_INC.'aeroport.search.inc.php'; ?>
	
	<?php if(isset($showHistorique)) require DIR_INC.'aeroport.historique.inc.php'; ?>
 
	<?php if(isset($showTerminal)) require DIR_INC.'terminal.inc.php'; ?>
	
</div>


<?php require DIR_INC.'footer.inc.php' ?> 
