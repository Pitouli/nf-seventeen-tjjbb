<h2>Choisir vos vols</h2>
<p>Nous vous réunissons ici tous les itinéraires qui pourraient vous convenir. Cochez les vols qui vous conviennent le mieux.</p>

<form method="post" action="<?php echo ROOT; ?>?c=reservation&s1=search&s2=<?php echo $getSection; ?>">

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
</form>