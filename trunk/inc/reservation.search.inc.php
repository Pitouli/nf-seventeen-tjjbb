<h2>Choisir vos vols
<p>Nous vous réunissons ici tous les itinéraires qui pourraient vous convenir. Cochez les vols qui vous conviennent le mieux.</p>

<form method="post" action="<?php echo ROOT; ?>?c=reservation&s1=search&s2=<?php echo $getSection; ?>">

<h3>Vols directs</h3>

	<table class="largeTable">
		<tr>
			<th>ID </th>
			<th>Départ</th>
			<th>Arrivée</th>
		</tr>
		<?php
			foreach($resultDirect as $direct)
			{
		?>
		<tr>
			<td><?php echo $direct['id'] ?></td>
			<td><?php echo $direct['depart'] ?></td>
			<td><?php echo $direct['arrivee'] ?></td>
		</tr>
		<?php
			}
		?>
	</table>
</form>