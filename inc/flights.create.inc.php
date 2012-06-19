<h2>Créer un vol - étape 2 - Sélectionner un avion</h2>

	<table class="largeTable">
		<tr>
			<th>Modèle</th>
			<th>Capacité<br />pers.</th>
			<th>Capacité<br />fret</th>
			<th>Num<br />avion</th>
			<th>Précédente<br />escale</th>
			<th>Aéroport (terminal)<br />de départ</th>
			<th>Aéroport (terminal)<br />d'arrivée</th>
			<th>Prochaine<br />escale</th>
			<th>Validation</th>
		</tr>
		<?php 
		$flag = 0;
		$flagDejaUtilise = 0;
		foreach($resultAvion as $avion) 
		{
		if ((!empty($avion['aeroport']))AND(!empty($avion['terminal']))) {
		
		if (!empty($avion['utilise'])) $flagDejaUtilise++;
		
		else
		{
		
		$flag++;
		?>
	<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=create">
		<tr>
			<td><?php echo $avion['nom'] ?></td>
			<td><?php echo $avion['capacite_voyageur'] ?></td>
			<td><?php echo $avion['capacite_fret'] ?></td>
			<td><?php echo $avion['id'] ?></td>
			<td>
				<?php 
				if (!empty($avion['PreviousAirport'])) echo $avion['PreviousAirport']['nom_ville'] . "<br />(" . $avion['PreviousAirport']['nom_aeroport'] . ")";
				else echo "Aucune";
				?>
			</td>
			<td>
				<select name="id_terminal_depart">
				<?php foreach($avion['terminal'] as $terminal)
				{
				?>
					<option value="<?php echo $terminal['id_terminal'] ?>"><?php echo $terminal['nom_aeroport'] ?> (<?php echo $terminal['nom_terminal'] ?>)</option>
				<?php
				}
				?>
				</select>
			</td>
			<td>
				<select name="id_terminal_arrivee">
				<?php foreach($avion['aeroport'] as $aeroport)
				{
				?>
					<option value="<?php echo $aeroport['id_terminal'] ?>"><?php echo $aeroport['nom_aeroport'] ?> (<?php echo $aeroport['nom_terminal'] ?>)</option>
					
				<?php
				}
				?>
				</select>
			</td>
			<td>
				<?php 
				if (!empty($avion['NextAirport'])) echo $avion['NextAirport']['nom_ville'] . "<br />(" . $avion['NextAirport']['nom_aeroport'] . ")";
				else echo "Aucune";
				?>
			</td>
			<td>
				<input type="hidden" name="Date_depart" value="<?php echo $checkStartText ?>" />
				<input type="hidden" name="Date_arrivee" value="<?php echo $checkEndText ?>" />
				<input type="hidden" name="id_avion" value="<?php echo $avion['id'] ?>" />
				
				<!-- Ajout des données saisies à l'étape 1 afin de réafficher le formulaire : -->
				<input type="hidden" name="depart" value="<?php echo $_POST['depart'] ?>" />
				<input type="hidden" name="arrivee" value="<?php echo $_POST['arrivee'] ?>" />
				<input type="hidden" name="Ddepart" value="<?php echo $_POST['Ddepart'] ?>" />
				<input type="hidden" name="Hdepart" value="<?php echo $_POST['Hdepart'] ?>" />
				<input type="hidden" name="Mdepart" value="<?php echo $_POST['Mdepart'] ?>" />
				<input type="hidden" name="Darrivee" value="<?php echo $_POST['Darrivee'] ?>" />
				<input type="hidden" name="Harrivee" value="<?php echo $_POST['Harrivee'] ?>" />
				<input type="hidden" name="Marrivee" value="<?php echo $_POST['Marrivee'] ?>" />
				<input type="hidden" name="capaciteMin" value="<?php echo $_POST['capaciteMin'] ?>" />
				<input type="hidden" name="capaciteMax" value="<?php echo $_POST['capaciteMax'] ?>" />
				<input type="hidden" name="fretMin" value="<?php echo $_POST['fretMin'] ?>" />
				<input type="hidden" name="fretMax" value="<?php echo $_POST['fretMax'] ?>" />
				
				<input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous la création d\'un nouveau vol avec les paramètres selectionnés?');"value="Choisir" />
			</td>
		</tr>
	</form>
		<?php
		}
		}
		}
		?>
</table>
<?php 
if(!$flag) echo "<p>La recherche n'a renvoyé aucun résultat : aucun terminaux compatibles dans la ville de départ ou d'arrivé pour la gamme d'avions sélectionnée</p>"; 
if($flagDejaUtilise) echo "<p><strong>Remarque</strong> : certains avions compatibles ont été retirés du résultat de la recherche car ils sont déjà en vol dans la plage horaire recherchée</p>"
?>
