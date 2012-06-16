<table class="largeTable">
	<tr>
		<th>Nom</th>
		<th>Ville</th>
		<th>Actions</th>
	</tr>
<?php
	foreach($resultSearch as $aeroport)
	{

?>
	<tr>
		<td><?php echo $aeroport['aeroport'] ?></td>
		<td><?php echo $aeroport['ville'] ?></td>
		<td>
			<form method="post" action="<?php echo ROOT; ?>?c=places&s1=historique&s2=<?php if(isset($aeroport['id'])) echo $aeroport['id'] ?>">
				<input type="hidden" name="searchAeroport" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" />
				<input type="hidden" name="searchVille" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" />
				<input type="submit" class="inputSubmit" value="Historique" />
			</form>
			<form method="post" action="<?php echo ROOT; ?>?c=places&s1=showterminal&s2=<?php if(isset($aeroport['id'])) echo $aeroport['id'] ?>">
				<input type="hidden" name="searchNom" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" />
				<input type="hidden" name="searchPrenom" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" />
				<input type="submit" class="inputSubmit" value="Terminaux" />
			</form>
			<form method="post" action="<?php echo ROOT; ?>?c=places&s1=delaeroport">
				<input type="hidden" name="searchAeroport" value="<?php if(isset($_POST['searchAeroport'])) echo $_POST['searchAeroport'] ?>" />
				<input type="hidden" name="ville" value="<?php if(isset($_POST['ville'])) echo $_POST['ville'] ?>" />
				<input type="hidden" name="delId" value="<?php echo $aeroport['id'] ?>" />
				<input type="submit" class="inputSubmit" value="Supprimer" onclick="return confirm('Confirmez vous la suppression de cet utilisateur ? Cette action est irreversible et supprimera aussi tous les historiques le concernant.')" />
			</form>
		</td>
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