<table class="largeTable">
	<tr>
		<th>Nom</th>
		<th>Capacit� en voyageurs</th>
		<th>Capacit� en fret</th>
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
?>
	<p>La recherche n'a renvoy� aucun r�sultat</p>
<?php
	}
?>