<table class="largeTable">
	<tr>
		<th>Nom</th>
		<th>Capacité en voyageurs</th>
		<th>Capacité en fret</th>
		<th>Actions</th>
	</tr>
<?php
	foreach($resultats as $ligneModele)
	{
?>
	<tr>
		<td><?php echo $ligneModele['nom'] ?></td>
		<td><?php echo $ligneModele['capacite_voyageur'] ?></td>
		<td><?php echo $ligneModele['capacite_fret'] ?></td>
		<td>
			<form method="post" action="<?php echo ROOT; ?>?c=fleet&s1=delModele">
				<input type="hidden" name="delModeleId" value="<?php echo $ligneModele['id'] ?>" />
				<input type="submit" class="inputSubmit" value="Supprimer" onclick="return confirm('Confirmez vous la suppression de ce modèle ? Cette action est irreversible et supprimera aussi tous les historiques le concernant.')" />
			</form>
		</td>
	</tr>
<?php
	}
?>
</table>

<?php
	if(empty($resultats))
	{
?>
	<p>La recherche n'a renvoyé aucun résultat</p>
<?php
	}
?>
