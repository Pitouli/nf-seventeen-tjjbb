<table class="largeTable">
	<tr>
		<th>Nom</th>
		<th>Capacit� en voyageurs</th>
		<th>Capacit� en fret</th>
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
	<p>La recherche n'a renvoy� aucun r�sultat</p>
<?php
	}
?>