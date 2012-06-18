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
	</tr>
<?php
	}
?>
</table>

<?php
	if(empty($resultats))
	{
	// Pourquoi c'est toujours viiiiide :'(
?>
	<p>La recherche n'a renvoyé aucun résultat</p>
<?php
	}
?>
