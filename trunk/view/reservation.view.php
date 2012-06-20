<?php require DIR_INC.'header.inc.php' ?>

<h1>Ajout d'une réservation pour <a href="<?php echo ROOT ?>?c=customers&s1=show&s2=<?php echo $getSSection ?>" title="Retourner à la fiche client"><?php echo $clientShow['name'] ?></a></h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>Veuillez fournir les indications demandées pour permettre une recherche efficace des vols les plus adaptés à votre besoin.</p>
</div>

<div class="corps">

	<h2>Informations sur le voyage</h2>

	<form method="post" action="<?php echo ROOT; ?>?c=reservation&s1=search&s2=<?php echo $getSSection; ?>">
		<table class="largeTable">
			<tr>
				<th><label for="depart">Départ :</label></th>
				<th><label for="arrivee">Arrivée :</label></th>
				<th><label for="Ddepart">Départ à partir de :</label></th>
				<th><label for="fret">Fret :</label></th>
				<th rowspan="2"><input type="submit" class="inputSubmit" value="Valider" /></th>
			</tr>
			<tr>
				<td>
					<select name="depart" id="depart">
						<?php foreach($listeVilles as $ville)
						{
						?>
						<option value="<?php echo $ville['id'] ?>" <?php if(isset($_POST['depart']) AND ($_POST['depart'] == $ville['id'])) echo 'selected' ?>><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td>
					<select name="arrivee" id="arrivee">
						<?php foreach($listeVilles as $ville)
						{
						?>
						<option value="<?php echo $ville['id'] ?>" <?php if(isset($_POST['arrivee']) AND ($_POST['arrivee'] == $ville['id'])) echo 'selected' ?>><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td>
					<input type="text" name="Ddepart" id="Ddepart" value="<?php //On gère l'affichage de la date :
					if (isset($showDatesDefined) AND $showDatesDefined)
					{
						echo $showStartText; //Cette variable a été définie dans le new.model
					}
					else echo "JJ/MM/AAAA";
					?>"/>
					<select name="Hdepart">
						<?php
						for ($i = 0; $i < 24; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['Hdepart']) AND ($_POST['Hdepart'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="Mdepart">
						<?php
						for ($i = 0; $i < 60; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['Mdepart']) AND ($_POST['Mdepart'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td><input type="number" name="fret" id="fret" value="<?php if(isset($_POST['fret'])) echo $_POST['fret']; else echo 0; ?>" /></td>
			</tr>
			
		</table>
	</form>
	
	<?php if(isset($resultReservations)) require DIR_INC.'reservation.search.inc.php'; ?>

</div>

<?php require DIR_INC.'footer.inc.php' ?> 