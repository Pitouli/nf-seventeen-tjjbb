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
		if(empty($resultVol)) echo "<p>La recherche n'a renvoyé aucun résultat";
		else 
		{
		?>
		<th>
			<td><?php echo $resultVol['id'] ?></td>
			<td><?php echo $resultVol['date_depart'] ?></td>
			<td><?php echo $resultVol['date_arrive'] ?></td>
			<td><?php echo $resultVol['terminal_depart'] . "<br />(" . $resultVol['aeorport_depart'] . ")" ?></td>
			<td><?php echo $resultVol['terminal_arrive'] . "<br />(" . $resultVol['aeorport_depart'] . ")" ?></td>
			<td><?php echo $resultVol['avion'] ?></td>
			<td><?php echo $resultVol['n_avion'] ?></td>
			<td>
				<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=del">
				
				<input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous la suppression du vol selectionnés? (ACTION IRREVERSIBLE !)');"value="Choisir" />
				</form>
			</td>
		</th>
		
		<?php
		}
		
		?>
	</table>