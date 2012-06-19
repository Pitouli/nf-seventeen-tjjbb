<h2>Terminaux de l'aeroport : <?php echo $nomAeroport?> (<?php echo $nomVille?>) </h2>
<?php echo " test " ?>
<?php echo $_POST['searchAeroport'] ?>
<?php echo $_POST['ville'] ?>
<?php echo " test fin " ?>

<table class="largeTable">
	<tr>
	<form method="post" action="<?php echo ROOT; ?>?c=places&s1=newterminal>
			<td><label for="nomterminal">Nom du terminal&nbsp;: </label></td>
			<td><input name="nomterminal" title="Nom du terminal" type="text" id="nomterminal" class="inputText extended" value="" /></td>
			<input type="hidden" name="idAeroport" value="<?php if(isset($tempA['id'])) echo $tempA['id'] ?>" />
			<input type="hidden" name="aeroport" value="<?php if(isset($getSSection)) echo $getSSection ?>" />
			<input type="hidden" name="searchAeroport" value="<?php if(isset($_POST['searchAeroport'])) echo $_POST['searchAeroport'] ?>" />
			<input type="hidden" name="ville" value="<?php if(isset($_POST['ville'])) echo $_POST['ville'] ?>" />
			<td>
				<select multiple="multiple" name="modele[]" id="modele">
						<option value="">Modèles d'avion supportés
						<?php foreach($listeModeles as $modele)
						{
						?>
						  <option value="<?php echo $modele['id'] ?>"><?php echo $modele['nom'] ?></option>
						<?php
						}
						?>
				</select>
			</td>	
		<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l'ajout du terminal ?');"value="Ajout Terminal" /></td>
	</form>
	</tr>
</table>

<table class="largeTable">
	<tr>
		<th>Nom</th>
		<th>Modèles supportés</th>
		<th>Action</th>
	</tr>
<?php
	foreach($resultTerminaux as $terminal)
	{
?>
	<tr>
		<td><?php echo $terminal['nom'] ?></td>
		<td><select>
				<?php foreach($terminal['modele'] as $modele)
				{
				?>
				 <option><?php echo $modele['nom'] ?>
				<?php
				}
				?>
			</select>
		<td>
			<form method="post" action="<?php echo ROOT; ?>?c=places&s1=delterminal">
				<input type="hidden" name="delId" value="<?php echo $terminal['id'] ?>" />
				<input type="hidden" name="aeroport" value="<?php if(isset($getSSection)) echo $getSSection ?>" />
				<input type="hidden" name="searchAeroport" value="<?php if(isset($_POST['searchAeroport'])) echo $_POST['searchAeroport'] ?>" />
				<input type="hidden" name="ville" value="<?php if(isset($_POST['ville'])) echo $_POST['ville'] ?>" />
				<input type="submit" class="inputSubmit" value="Supprimer" onclick="return confirm('Confirmez vous la suppression de ce terminal ? Cette action est irreversible.')" />
			</form>
		</td>
	</tr>
<?php
	}
?>
</table>

<?php
	if(empty($resultSearch))
	{
?>
	<p>La recherche n'a renvoyé aucun résultat</p>
<?php
	}
?>