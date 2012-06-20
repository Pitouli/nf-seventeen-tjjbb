<h2>Choisir vos vols</h2>
<p>Nous vous réunissons ici tous les itinéraires qui pourraient vous convenir. Cochez les vols qui vous conviennent le mieux.</p>

<form method="post" action="<?php echo ROOT; ?>?c=reservation&s1=save&s2=<?php echo $getSSection; ?>">

<h3>Vols directs</h3>

<?php
	if(!empty($resultDirect))
	{
		foreach($resultDirect as $direct)
		{
?>
	<table class="largeTable">
		<tr>
			<th>ID</th>
			<th>Lieu de Départ</th>
			<th>Heure de Départ</th>
			<th>Lieu d'Arrivée</th>
			<th>Heure d'Arrivée</th>
			<th rowspan="2"><input type="radio" name="reservationVol" value="<?php echo $direct['id'] ?>" title="Réserver ce voyage" /></th>
		</tr>
		<tr>
			<td><?php echo $direct['id'] ?></td>
			<td><?php echo $direct['citystart'] ?></td>
			<td><?php echo $direct['depart'] ?></td>
			<td><?php echo $direct['cityend'] ?></td>
			<td><?php echo $direct['arrive'] ?></td>
		</tr>
	</table>
<?php
		}
	}
	else
	{
?>
	<p>Aucun vol direct ne répond à la commande.</p>
<?php
	}
?>
	
<h3>Vols avec 1 escale</h3>

<?php
	if(!empty($resultUneEscale))
	{
		foreach($resultUneEscale as $uneEscale)
		{
?>
	<table class="largeTable">
		<tr>
			<th>ID</th>
			<th>Lieu de Départ</th>
			<th>Heure de Départ</th>
			<th>Lieu d'Arrivée</th>
			<th>Heure d'Arrivée</th>
			<th rowspan="3"><input type="radio" name="reservationVol" value="<?php echo $uneEscale['id1'] ?>#<?php echo $uneEscale['id2'] ?>" title="Réserver ce voyage" /></th>
		</tr>
		<?php
			for($i = 1; $i < 3; ++$i)
			{
		?>
		<tr>
			<td><?php echo $uneEscale['id'.$i] ?></td>
			<td><?php echo $uneEscale['citystart'.$i] ?></td>
			<td><?php echo $uneEscale['depart'.$i] ?></td>
			<td><?php echo $uneEscale['cityend'.$i] ?></td>
			<td><?php echo $uneEscale['arrive'.$i] ?></td>
		</tr>
		<?php
			}
		?>
	</table>
<?php
		}
	}
	else
	{
?>
	<p>Aucun vol ayant 1 escale ne répond à la commande.</p>
<?php
	}
?>
	
<h3>Vols avec 2 escales</h3>

<?php
	if(!empty($resultDeuxEscales))
	{
		foreach($resultDeuxEscales as $deuxEscales)
		{
?>
	<table class="largeTable">
		<tr>
			<th>ID</th>
			<th>Lieu de Départ</th>
			<th>Heure de Départ</th>
			<th>Lieu d'Arrivée</th>
			<th>Heure d'Arrivée</th>
			<th rowspan="4"><input type="radio" name="reservationVol" value="<?php echo $deuxEscales['id1'] ?>#<?php echo $deuxEscales['id2'] ?>#<?php echo $deuxEscales['id3'] ?>" title="Réserver ce voyage" /></th>
		</tr>
		<?php
			for($i = 1; $i < 4; ++$i)
			{
		?>
		<tr>
			<td><?php echo $deuxEscales['id'.$i] ?></td>
			<td><?php echo $deuxEscales['citystart'.$i] ?></td>
			<td><?php echo $deuxEscales['depart'.$i] ?></td>
			<td><?php echo $deuxEscales['cityend'.$i] ?></td>
			<td><?php echo $deuxEscales['arrive'.$i] ?></td>
		</tr>
		<?php
			}
		?>
	</table>
<?php
		}
	}
	else
	{
?>
	<p>Aucun vol en deux escales ne répond à la commande.</p>
<?php
	}
?>

<h2>Réserver le vol</h2>

<table class="largeTable">
	<tr>
		<th>Prix de la réservation&nbsp;:</th>
		<td><input type="text" name="reservationPrice" title="Coût de la réservation" value="" />€</td>
		<th>Type de réservation&nbsp;:</th>
		<td>
			<?php if($_POST['fret'] == 0) echo 'BILLET'; else echo 'TITRE ('.$_POST['fret'].'Kg)'; ?>
			<input type="hidden" name="reservationFret" title="Coût de la réservation" value="<?php echo $_POST['fret'] ?>" />
		</td>
		<td><input type="submit" value="Réserver" /></td>
	</tr>
</table>
</form>