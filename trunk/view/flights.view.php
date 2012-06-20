<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion du trafic aérien</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez ajouter un nouveau vol, ou bien consulter ou supprimer un vol existant.</p>
</div>

<div class="corps">

	<h2>Créer un vol - étape 1 - Chercher un avion</h2>

	<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=new">
		<table class="largeTable">
			<tr>
				<td><label for="depart"><strong>Départ :</strong></label></td>
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
				<td><label for="arrivee"><strong>Arrivée :</strong></label></td>
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
					<label for="Ddepart">Date de départ</label><br />
					<input type="text" name="Ddepart" id="Ddepart" value="<?php //On gère l'affichage de la date :
					if (isset($showDatesDefined) AND $showDatesDefined)
					{
						echo $showStartText; //Cette variable a été définie dans le new.model
					}
					else echo "JJ/MM/AAAA";
					?>"/>
					<select name="Hdepart">
						<?php
						for ($i = 0; $i <= 23; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['Hdepart']) AND ($_POST['Hdepart'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="Mdepart">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['Mdepart']) AND ($_POST['Mdepart'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td>
					<label for="Darrivee">Date d'arrivée</label><br />
					<input type="text" name="Darrivee" id="Darrivee" value="<?php //On gère l'affichage de la date :
					if (isset($showDatesDefined) AND $showDatesDefined)
					{
						echo $showEndText; //Cette variable a été définie dans le new.model
					}
					else echo "JJ/MM/AAAA";
					?>"/>
					<select name="Harrivee">
						<?php
						for ($i = 0; $i <= 23; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['Harrivee']) AND ($_POST['Harrivee'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="Marrivee">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['Marrivee']) AND ($_POST['Marrivee'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td rowspan="2"><input type="submit" class="inputSubmit" value="Valider" /></td>
			</tr>
			
			<tr>
				<td><label for="capaciteMin"><strong>Capacité passager :</strong></label></td>
				<td>
					<label for="capaciteMin">Minimum</label><br />
					<input type="number" name="capaciteMin" id="capaciteMin" <?php if(isset($capaciteMin)) echo 'value="' . $capaciteMin . '"' ?>/>
				</td>
				<td>
					<label for="capaciteMax">Maximum</label><br />
					<input type="number" name="capaciteMax" <?php if(isset($capaciteMax)) echo 'value="' . $capaciteMax . '"' ?>/>
				</td>
				<td><label for="fretMin"><strong>Fret :</strong></label></td>
				<td>
					<label for="fretMin">Minimum</label><br />
					<input type="number" name="fretMin" id="fretMin" <?php if(isset($fretMin)) echo 'value="' . $fretMin . '"' ?>/>
				</td>
				<td>
					<label for="fretMax">Maximum</label><br />
					<input type="number" name="fretMax" <?php if(isset($fretMax)) echo 'value="' . $fretMax . '"' ?>/>
				</td>
				<td><input type="submit" class="inputSubmit" value="Chercher" /></td>
			</tr>
			
		</table>
	</form>
		
	<?php if(isset($resultAvion)) if(!empty($resultAvion)) require DIR_INC.'flights.create.inc.php'; else echo "<p>La recherche n'a renvoyé aucun résultat</p>" ?>
		
		
		
		
		
		
		
		
		
		
		
	<h2>Chercher un vol</h2>
		
	<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=search">
		<table class="largeTable">
			<tr>
				<td><label for="departSearch">Départ</label></td>
				<td>
				   <select name="departSearch" id="departSearch">
						<?php foreach($listeVilles as $ville)
						{
						?>
						  <option value="<?php echo $ville['id'] ?>" <?php if(isset($_POST['departSearch']) AND ($_POST['departSearch'] == $ville['id'])) echo 'selected' ?>><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
				</td>
				<td><label for="arrivee">Arrivée</label></td>
				<td>
				   <select name="arriveeSearch" id="arriveeSearch">
					   <?php foreach($listeVilles as $ville)
						{
						?>
						  <option value="<?php echo $ville['id'] ?>" <?php if(isset($_POST['arriveeSearch']) AND ($_POST['arriveeSearch'] == $ville['id'])) echo 'selected' ?>><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
				   </select>
				</td>
				<td>
					<label for="DdepartSearch">Date de départ</label><br />
					<input type="text" name="DdepartSearch" id="DdepartSearch" value="<?php //On gère l'affichage de la date :
					if (isset($showDatesDefinedSearch) AND $showDatesDefinedSearch)
					{
						echo $showStartTextSearch; //Cette variable a été définie dans le new.model
					}
					else echo "JJ/MM/AAAA";
					?>"/>
					<select name="HdepartSearch">
						<?php
						for ($i = 0; $i <= 23; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['HdepartSearch']) AND ($_POST['HdepartSearch'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="MdepartSearch">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['MdepartSearch']) AND ($_POST['MdepartSearch'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td>
					<label for="DarriveeSearch">Date d'arrivée</label><br />
					<input type="text" name="DarriveeSearch" id="DarriveeSearch" value="<?php //On gère l'affichage de la date :
					if (isset($showDatesDefinedSearch) AND $showDatesDefinedSearch)
					{
						echo $showEndTextSearch; //Cette variable a été définie dans le new.model
					}
					else echo "JJ/MM/AAAA";
					?>"/>
					<select name="HarriveeSearch">
						<?php
						for ($i = 0; $i <= 23; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['HarriveeSearch']) AND ($_POST['HarriveeSearch'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="MarriveeSearch">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php if($i<10) echo 0; echo $i ?>" <?php if(isset($_POST['MarriveeSearch']) AND ($_POST['MarriveeSearch'] == $i)) echo 'selected' ?>><?php if($i<10) echo 0; echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td><input type="submit" class="inputSubmit" value="Chercher" /></td>
			</tr>
		</table>
	</form>
	
	
	<?php if(isset($resultVol)) require DIR_INC.'flights.show.inc.php'; ?>
	
</div>

<?php require DIR_INC.'footer.inc.php' ?> 
