<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion des clients &amp; réservation</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez gérer les clients, que ce soit l'ajout d'un nouveau ou la consultation d'un existant, ainsi que gérer les réservations.</p>
	<p>La gestion des réservations est accessible à partir de chaque client.</p>
</div>

<div class="corps">

	<h2>Ajout d'un nouveau client</h2>

	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=newCustomer">
		<table class="largeTable">
			<tr>
				<td><label for="newNom">Nom&nbsp;: </label></td>
				<td><input name="newNom" title="Nom du nouveau client" type="text" id="newNom" class="inputText" value="" /></td>
				<td><label for="newPrenom">Prénom&nbsp;: </label></td>
				<td><input name="newPrenom" title="Prénom du nouveau client (Facultatif dans le cas d'une entreprise)" type="text" id="newPrenom" class="inputText" value="" /></td>
				<td><label for="newEntreprise">Entreprise&nbsp;: </label><input type="radio" id="newEntreprise" name="newStatut" value="entreprise" /></td>
				<td><label for="newParticulier">Particulier&nbsp;: </label><input type="radio" id="newParticulier" name="newStatut" value="particulier" checked="checked" /></td>
				<td><input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouveau client ?');"value="Ajouter client" /></td>
			</tr>
		</table>
	</form>

	<h2>Recherche des clients existants</h2>
	
	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=searchCustomer">
		<table class="largeTable">
			<tr>
				<td><label for="searchNom">Nom&nbsp;: </label></td>
				<td><input name="searchNom" title="Partie du nom du client" type="text" id="searchNom" class="inputText" value="<?php echo $_POST['searchNom'] ?>" /></td>
				<td><label for="searchPrenom">Prénom&nbsp;: </label></td>
				<td><input name="searchPrenom" title="Partie du prénom du client" type="text" id="searchPrenom" class="inputText" value="<?php echo $_POST['searchPrenom'] ?>" /></td>
				<td><label for="searchEntreprise">Entreprise&nbsp;: </label><input type="checkbox" id="searchEntreprise" name="searchEntreprise" <?php if($_POST['searchEntreprise']) echo 'checked="checked" ' ?>/></td>
				<td><label for="searchParticulier">Particulier&nbsp;: </label><input type="checkbox" id="searchParticulier" name="searchParticulier"  <?php if($_POST['searchParticulier']) echo 'checked="checked" ' ?>/></td>
				<td><input type="submit" class="inputSubmit" value="Rechercher client" /></td>
			</tr>
		</table>
	</form>
	
	<?php 
		if(isset($resultSearch))
		{
	?>
	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=newCustomer">
		<table class="largeTable">
			<tr>
				<td>Nom</td>
				<td>Prénom</td>
				<td>Catégorie</td>
				<td>Actions</td>
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
					<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=delCustomer&s2=<?php echo $client['id_client'] ?>">
						<input type="hidden" name="searchNom" value="<?php echo $_POST['searchNom'] ?>" />
						<input type="hidden" name="searchPrenom" value="<?php echo $_POST['searchPrenom'] ?>" />						
						<input type="hidden" name="searchEntreprise" value="<?php echo $_POST['searchEntreprise'] ?>" />						
						<input type="hidden" name="searchParticulier" value="<?php echo $_POST['searchParticulier'] ?>" />
						<input type="submit" class="inputSubmit" value="Supprimer" onclick="return confirm('Confirmez vous la suppression de cet utilisateur ? Cette action est irreversible et supprimera aussi tous les historiques le concernant.')">
					</form>
				</td>
			</tr>
		<?php
			}
		?>
		</table>
	</form>
	<?php
		}
	?>

</div>

<?php require DIR_INC.'footer.inc.php' ?> 