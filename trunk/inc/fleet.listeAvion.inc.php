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
		<td>
			<form method="post" action="<?php echo ROOT; ?>?c=fleet&s1=delAvion">
				<input type="hidden" name="delAvionId" value="<?php echo $ligneAvion['id'] ?>" />
				<input type="submit" class="inputSubmit" value="Supprimer" onclick="return confirm('Confirmez vous la suppression de cet avion ? Cette action est irreversible et supprimera aussi tous les historiques le concernant.')" />
			</form>
		</td>
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
