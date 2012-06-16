<table class="largeTable">
	<tr>
		<th>Nom</th>
		<th>Capacité en voyageurs</th>
		<th>Capacité en fret</th>
		<th>Actions</th>
	</tr>
<?php
	foreach($resultats as $modele)
	{
?>
	<tr>
		<td><?php echo $modele['nom'] ?></td>
		<td><?php echo $modele['capacite_voyageur'] ?></td>
		<td><?php echo $client['capacite_fret'] ?></td>
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