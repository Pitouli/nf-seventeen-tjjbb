<h2>Créer un vol - étape 2 - Sélectionner un avion</h2>

<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=create">
	<table class="largeTable">
		<tr>
			<th> </th>
			<th>Modèle</th>
			<th>Capacité pers.</th>
			<th>Capacité fret</th>
			<th>Num avion</th>
			<th>Précédent<br />aéroport</th>
			<th>Terminal<br />compatible</th>
			<th>Aéroport (terminal) d'arrivée</th>
			<th>Prochaine<br />escale</th>
		</tr>
		<!-- TODO : mettre les hidden pour faire réapparaitre les critères de recherches pr�c�dents!!! -->
		<?php foreach($resultAvion as $avion) 
		{
		?>
		<tr>
			<td><input type="radio" name="avion" value="<?php echo ''; ?>" /></td>
			<td><?php echo $avion['nom'] ?></td>
			<td><?php echo $avion['capacite_voyageur'] ?></td>
			<td><?php echo $avion['capacite_fret'] ?></td>
			<td><?php echo $avion['id'] ?></td>
			<td><?php echo "Comming soon..." ?></td>
			<td><?php echo "Comming soon..." ?></td>
			<td><?php echo "Comming soon..." ?></td>
			<td><?php echo "Comming soon..." ?></td>
		</tr><?php
		}
		?>
	</table>
	<input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouveau vol ?');"value="Ajouter vol" />
</form>