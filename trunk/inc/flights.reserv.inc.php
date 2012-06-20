

	<table class="largeTable">
		<tr>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Catégorie<br />du client</th>
			<th>Prix du billet</th>
			<th>Fret</th>
			<th>Catégorie<br/>du billet</th>
		</tr>
		<?php
		if (!empty($resultReserv)) {
		foreach($resultReserv AS $reserv)
		{
		?>
		<tr>
			<td><?php echo $reserv['nom'] ?></td>
			<td><?php echo $reserv['prenom'] ?></td>
			<td><?php echo $reserv['cat_client'] ?></td>
			<td><?php echo $reserv['prix'] ?></td>
			<td><?php echo $reserv['fret'] ?></td>
			<td><?php echo $reserv['cat_billet'] ?></td>
		</tr>
		
		<?php
		}
		}
		
		?>
	</table>
	<?php
		if (empty($resultReserv)) echo "<p>La recherche n'a renvoyé aucun résultat</p>";
	?>