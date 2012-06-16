<h2>Terminaux de l'aeroport : </h2> <?php echo $nomAeroport?> <h2> (</h2><?php echo $nomVille ?><h2>)</h2>


<table class="largeTable">
	<tr>
	<form method="post" action="<?php echo ROOT; ?>?c=places&s1=newterminal">
			<td><label for="newterminal">Nom du terminal&nbsp;: </label></td>
			<input type="hidden" name="aeroport" value="<?php if(isset($getSSection)) echo $getSSection ?>"/>
			<td><input name="newVille" title="Nom de la nouvelle ville" type="text" id="newVille" class="inputText extended" value="" /></td>
			<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'une nouvelle ville ?');"value="Ajouter Ville" /></td>
			<td>
				<select name="modele" id="modele">
						<option>Modele d'avion supporte
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
		<th>Aeroport</th>
		<th>Ville</th>
		<th>Modele supporte</th>
	</tr>
<?php
	foreach($resultSearch as $terminal)
	{

?>
	<tr>
		<td><?php echo $terminal['nom'] ?></td>
		<td><?php echo $terminal['modele'] ?></td>
		<td>
			<form method="post" action="<?php echo ROOT; ?>?c=places&s1=delterminal">
				<input type="hidden" name="delId" value="<?php echo $terminal['id'] ?>" />
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