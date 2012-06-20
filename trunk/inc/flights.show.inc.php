<h2>Créer un vol - étape 2 - Sélectionner un avion</h2>

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
		if(empty($resultVol)) echo "<p>La recherche n'a renvoyé aucun résultat</p>";
		else 
		{
		while($vol = $resultVol->fetch())
		{
		?>
		<tr>
			<td><?php echo $vol['id'] ?></td>
			<td><?php echo $vol['date_depart'] ?></td>
			<td><?php echo $vol['date_arrive'] ?></td>
			<td><?php echo $vol['terminal_depart'] . "<br />(" . $vol['aeorport_depart'] . ")" ?></td>
			<td><?php echo $vol['terminal_arrive'] . "<br />(" . $vol['aeorport_depart'] . ")" ?></td>
			<td><?php echo $vol['avion'] ?></td>
			<td><?php echo $vol['n_avion'] ?></td>
			<td>
				<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=del">
				
				<input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous la suppression du vol selectionnés? (ACTION IRREVERSIBLE !)');"value="Supprimer" />
				</form>
			</td>
		</tr
		
		<?php
		}
		}
		
		?>
	</table>