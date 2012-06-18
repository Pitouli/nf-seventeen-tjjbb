<table class="largeTable">
	<tr>
		<th>ID</th>
		<th>Actions</th>
	</tr>
<?php
	foreach($affichageAvions as $ligneAvion)
	{
?>
	<tr>
		<td><?php echo $ligneAvion['id'] ?></td>
	</tr>
<?php
	}
?>
</table>

<?php
	if(empty($affichageAvions))
	{
?>
	<p>La recherche n'a renvoyé aucun résultat</p>
<?php
	}
?>
