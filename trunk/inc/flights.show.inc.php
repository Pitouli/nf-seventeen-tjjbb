

	<table class="largeTable">
		<tr>
			<th>Id Vol</th>
			<th>Aéroport<br />(terminal) départ</th>
			<th>Aéroport<br />(terminal) arrivée</th>
			<th>Date<br />départ</th>
			<th>Date<br />arrivée</th>
			<th>Modèle avion</th>
			<th>Id avion</th>
			<th>Action</th>
		</tr>
		<?php
		$flag = 0;
		while($vol = $resultVol->fetch())
		{
		$flag++;
		?>
		<tr>
			<td><?php echo $vol['id'] ?></td>
			<td><?php echo $vol['aeorport_depart'] . "<br />(" . $vol['terminal_depart'] . ")" ?></td>
			<td><?php echo $vol['aeroport_arrive'] . "<br />(" . $vol['terminal_arrive'] . ")" ?></td>
			<td><?php echo $vol['date_depart'] ?></td>
			<td><?php echo $vol['date_arrive'] ?></td>
			<td><?php echo $vol['avion'] ?></td>
			<td><?php echo $vol['n_avion'] ?></td>
			<td>
				<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=del">
				
				<input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous la suppression du vol selectionnés? (ACTION IRREVERSIBLE : Toute les réservations sur ce vol seront supprimées !)');"value="Supprimer" />
				</form>
			</td>
		</tr>
		
		<?php
		}
		
		?>
	</table>
	<?php
		if(!$flag) echo "<p>La recherche n'a renvoyé aucun résultat</p>";
	?>