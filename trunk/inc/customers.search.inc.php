<table class="largeTable">
	<tr>
		<th>Nom</th>
		<th>Prénom</th>
		<th>Catégorie</th>
		<th>Actions</th>
	</tr>
<?php
	foreach($resultSearch as $client)
	{
?>
	<tr>
		<td><?php echo $client['nom'] ?></td>
		<td><?php echo $client['prenom'] ?></td>
		<td><?php echo $client['cat'] ?></td>
		<td>
			<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=show&s2=<?php if(isset($client['id_client'])) echo $client['id_client'] ?>">
				<input type="hidden" name="searchNom" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" />
				<input type="hidden" name="searchPrenom" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" />						
				<input type="hidden" name="searchEntreprise" value="<?php if(isset($_POST['searchEntreprise'])) echo $_POST['searchEntreprise'] ?>" />						
				<input type="hidden" name="searchParticulier" value="<?php if(isset($_POST['searchParticulier'])) echo $_POST['searchParticulier'] ?>" />
				<input type="submit" class="inputSubmit" value="Voir les détails" />
			</form>
			<a href="<?php echo ROOT; ?>?c=reservation&s1=<?php echo $getSection; ?>" title="Créer une nouvelle réservation"><input type="button" class="inputSubmit" value="Nvlle Réservation" /></a>
			<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=del">
				<input type="hidden" name="searchNom" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" />
				<input type="hidden" name="searchPrenom" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" />						
				<input type="hidden" name="searchEntreprise" value="<?php if(isset($_POST['searchEntreprise'])) echo $_POST['searchEntreprise'] ?>" />						
				<input type="hidden" name="searchParticulier" value="<?php if(isset($_POST['searchParticulier'])) echo $_POST['searchParticulier'] ?>" />
				<input type="hidden" name="delId" value="<?php echo $client['id_client'] ?>" />
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