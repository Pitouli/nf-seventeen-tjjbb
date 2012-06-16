<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion de la flotte</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>Dans cette page, vous pourrez gérer les modèles d'avion, c'est-à-dire les ajouter, consulter ou supprimer.</p>
	<p>Il vous sera alors possible de faire de même pour votre flotte d'avions de ces modèles.<p>
</div>

<div class="corps">

	<h2>Ajout d'un nouveau modèle</h2>

	<form method="post" action="<?php echo ROOT; ?>?c=fleet&s1=newModele"> 
		<table class="largeTable">
			<tr>
				<td><label for="newNomModele">Nom&nbsp;: </label></td>
				<td><input name="newNomModele" title="Nom du nouveau modèle" type="text" id="newNomModele" class="inputText extended" value="" /></td>
				<td><label for="newCapacite">Capacité en passagers&nbsp;: </label></td>
				<td><input name="newCapacite" title = "Capacité du modèle en passagers" type="number" id="newCapacite"/></td>
				<td><label for="newFret">Capacité en fret&nbsp;: </label></td>
				<td><input name="newFret" title = "Capacité du modèle en fret" type="number" id="newFret"/></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouveau modèle ?');"value="Ajouter modèle" /></td>
			</tr>
		</table>
	</form>
	
	<h2>Recherche des modèles existants</h2>
	
	<form method="post" action="<?php echo ROOT; ?>?c=fleet&s1=searchModele">
		<table class="largeTable">
			<tr>
				<td><label for="searchNomModele">Nom&nbsp;: </label></td>
				<td><input name="searchNomModele" title="Partie du nom du modèle" type="text" id="searchNomModele" class="inputText extended" value="<?php if(isset($_POST['searchNomModele'])) echo $_POST['searchNomModele'] ?>" /></td>
				<td><label for="searchCapaciteMin">Capacité minimale en passagers</label></td>
				<td><input name="searchCapaciteMin" title="Capacité minimale en passagers" type="number" id="searchCapaciteMin" /></td>
				<td><label for="searchCapaciteMax">Capacité maximale en passagers</label></td>
				<td><input name="searchCapaciteMax" title="Capacité maximale en passagers" type="number" id="searchCapaciteMax" /></td>
				<td><label for="searchFretMin">Capacité minimale en fret</label></td>
				<td><input name="searchFretMin" title="Capacité minimale en fret" type="number" id="searchFretMin" /></td>
				<td><label for="searchFretMax">Capacité maximale en fret</label></td>
				<td><input name="searchFretMax" title="Capacité maximale en fret" type="number" id="searchFretMax" /></td>
				<td><input type="submit" class="inputSubmit" value="Rechercher modèle" /></td>
			</tr>
		</table>
	</form>
	
	<h2>Ajout d'un nouvel avion</h2>
	
	<form method="post" action="<?php echo ROOT; ?>?c=fleet&s1=newAvion"> 
		<table class="largeTable">
			<tr>
				<td><select name="modele" id="modele">
						<?php foreach($listeModeles as $modele)
						{
						?>
						  <option value="<?php echo $modele['id'] ?>"><?php echo $modele['nom'] ?></option>
						<?php
						}
						?>
				</select></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouvel avion ?');"value="Ajouter avion" /></td>
			</tr>
		</table>
	</form>
	

	<h2>Un peu de statistiques</h2>
	<ul>
		<li>Nombre d'avions dans la flotte : xxxx</li>
		<li>Nombre d'aéroports desservis : xxx</li>
		<li>Nombre de vols au départ dans les 24 prochaines heures : xxxx</li>
	</ul>
	<p>...</p>

</div>

<?php require DIR_INC.'footer.inc.php' ?> 
