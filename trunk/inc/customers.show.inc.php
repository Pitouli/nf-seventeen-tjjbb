<h2>Informations sur le client</h2>

<ul>
	<li>Identification&nbsp;: <?php echo $clientShow['name'] ?></li>
	<li>Type&nbsp;: <?php echo $clientShow['cat'] ?></li>
	<li>Dépenses totales&nbsp;: <?php echo $clientShow['cost'] ?></li>
	<li>Nombre de vols&nbsp;: <?php echo $clientShow['nbFlights'] ?></li>
</ul>

<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=show&s2=<?php echo $client['id_client'] ?>">
	<input type="hidden" name="searchNom" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" />
	<input type="hidden" name="searchPrenom" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" />						
	<input type="hidden" name="searchEntreprise" value="<?php if(isset($_POST['searchEntreprise'])) echo $_POST['searchEntreprise'] ?>" />						
	<input type="hidden" name="searchParticulier" value="<?php if(isset($_POST['searchParticulier'])) echo $_POST['searchParticulier'] ?>" />
<table class="largeTable">
	<tr>
		<td><label for="showStart">Depuis le&nbsp;: </label></td>
		<td><input name="showStart" title="Au format JJ/MM/AAAA" type="text" id="showStart" class="inputText" value="<?php if(isset($showStartText)) echo $showStartText; ?>" /></td>
		<td><label for="showEnd">Jusqu'à&nbsp;: </label></td>
		<td><input name="showEnd" title="Au format JJ/MM/AAAA" type="text" id="showEnd" class="inputText" value="<?php if(isset($showEndText)) echo $showEndText; ?>" /></td>
		<td><input type="submit" class="inputSubmit" value="Rechercher les réservations" /></td>
	</tr>
</table>
</form>

<table class="largeTable">
	<tr>
		<th>ID</th>
		<th>Ville de départ</th>
		<th>Ville d'arrivée</th>
		<th>Date de départ</th>
		<th>Date d'arrivée</th>
		<th>Prix</th>
		<th>Annulation</th>
	</tr>
<?php
	foreach($resultShow as $reservation)
	{
?>
	<tr>
		<td><?php echo $reservation['id'] ?></td>
		<td><?php echo $reservation['cityStart'] ?></td>
		<td><?php echo $reservation['cityEnd'] ?></td>
		<td><?php echo $reservation['dateStart'] ?></td>
		<td><?php echo $reservation['dateEnd'] ?></td>
		<td><?php echo $reservation['price'] ?></td>
		<td>
		<?php
			if($reservation['cancelable'])
			{
		?>
			<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=del&s2=<?php echo $client['id_client'] ?>">
				<input type="hidden" name="searchNom" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" />
				<input type="hidden" name="searchPrenom" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" />						
				<input type="hidden" name="searchEntreprise" value="<?php if(isset($_POST['searchEntreprise'])) echo $_POST['searchEntreprise'] ?>" />						
				<input type="hidden" name="searchParticulier" value="<?php if(isset($_POST['searchParticulier'])) echo $_POST['searchParticulier'] ?>" />
<input type="submit" class="inputSubmit" value="Supprimer" onclick="return confirm('Confirmez vous la suppression de cet utilisateur ? Cette action est irreversible et supprimera aussi tous les historiques le concernant.')">
			</form>
		<?php
			}
		?>
		</td>
	</tr>
	<tr>
		<td>Vol(s)&nbsp;:</td>
		<td colspan="6">
			<table class="largeTable">
				<tr>
					<th>ID</th>
					<th>Ville de départ</th>
					<th>Ville d'arrivée</th>
					<th>Date de départ</th>
					<th>Date d'arrivée</th>
					<th>Avion</th>
				</tr>
				<?php
					foreach($reservation['vols'] as $vol)
					{
				?>
				<tr>
					<td><?php echo $vol['id'] ?></td>
					<td><?php echo $vol['cityStart'] ?></td>
					<td><?php echo $vol['cityEnd'] ?></td>
					<td><?php echo $vol['dateStart'] ?></td>
					<td><?php echo $vol['dateEnd'] ?></td>
					<td><?php echo $vol['plane'] ?></td>
				</tr>				
				<?php
					}
				?>
			</table>
		</td>
	</tr>
<?php
	}
?>
</table>

<?php
	if(empty($resultShow))
	{
?>
	<p>La recherche n'a renvoyé aucun résultat</p>
<?php
	}
?>