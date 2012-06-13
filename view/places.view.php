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
		<form method="post" action="<?php echo ROOT; ?>?v=ville&s1=new">
		
				<td><label for="newVille">Ville&nbsp;: </label></td>
				<td><input name="newVille" title="Nom de la nouvelle ville" type="text" id="newVille" class="inputText extended" value="" /></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'une nouvelle ville ?');"value="Ajouter Ville" /></td>
					
		</form>
		<form method="post" action="<?php echo ROOT; ?>?v=ville&s1=del">
			<td>
				<select name="ville" id="ville">
						<option values="villes1">ville1</option>
						<option values="villes2">ville2</option>
				</select>
			</td>	
			<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous la suppression de la ville ? Cela supprimera les aeroports et terminaux associés');"value="Supprimer Ville" /></td>
		</form>
		</tr>
	</table>

	
 	<h2>Ajout d'un aeroport</h2>

	<!-- <?php if(isset($resultSearch)) require DIR_INC.'places.search.inc.php'; ?> -->
	
	<!-- <?php if(isset($resultShow)) require DIR_INC.'places.show.inc.php'; ?>  -->
 
</div>


<?php require DIR_INC.'footer.inc.php' ?> 