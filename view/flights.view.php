<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion du trafic aérien</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez ajouter un nouveau vol, ou bien consulter ou supprimer un vol existant.</p>
	<p><strong>WARNING : PAGE EN CHANTIER, C'EST NORMAL DE VOIR DES CHOSES ABERRANTES... :D</strong></p>
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
						  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom'] ?></option>
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
						  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom'] ?></option>
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
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="Mdepart">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
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
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="Marrivee">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label for="capaciteMin"><strong>Capacité passager :</strong></label></td>
				<td><label for="capaciteMin">Minimum</label><br /><input type="number" name="capaciteMin" id="capaciteMin"/></td>
				<td><label for="capaciteMax">Maximum</label><br /><input type="number" name="capaciteMax" /></td>
				<td><label for="fretMin"><strong>Fret :</strong></label></td>
				<td><label for="fretMin">Minimum</label><br /><input type="number" name="fretMin" id="fretMin"/></td>
				<td><label for="fretMax">Maximum</label><br /><input type="number" name="fretMax" /></td>
				<td><input type="submit" class="inputSubmit" value="Valider" /></td>
			</tr>
			
		</table>
	</form>
		
	<?php if(isset($resultAvion)) require DIR_INC.'flights.create.inc.php'; ?>
		
	<h2>Chercher un vol</h2>
		
	<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=search">
		<table class="largeTable">
			<tr>
				<td><label for="depart">Départ</label></td>
				<td>
				   <select name="depart" id="depart">
					   <?php foreach($listeVilles as $ville)
						{
						?>
						  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
				   </select>
				</td>
				<td><label for="arrivee">Arrivée</label></td>
				<td>
				   <select name="arrivee" id="arrivee">
					   <?php foreach($listeVilles as $ville)
						{
						?>
						  <option value="<?php echo $ville['id'] ?>"><?php echo $ville['nom'] ?></option>
						<?php
						}
						?>
				   </select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="Ddepart">Date de départ</label>
				</td>
				<td>
					<input type="text" name="Ddepart" id="Ddepart"/>
					<select name="Hdepart">
						<?php
						for ($i = 0; $i <= 23; $i++) {
						?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="Mdepart">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td><label for="Darrivee">Date d'arrivée</label></td>
				<td>
					<input type="text" name="Darrivee" id="Darrivee"/>
					<select name="Harrivee">
						<?php
						for ($i = 0; $i <= 23; $i++) {
						?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
						}
						?>
					</select>
					:
					<select name="Marrivee">
						<?php
						for ($i = 0; $i <= 60; $i++) {
						?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
		</table>
	</form>
	
	
	<?php if(isset($resultShow)) require DIR_INC.'flights.show.inc.php'; ?>
	
		<!-- 
	<h2>Chercher un vol</h2>
	
	<form method="post" action="<?php echo ROOT; ?>?c=customers&s1=search">
		<table class="largeTable">
			<tr>
				<td><label for="searchNom">Nom&nbsp;: </label></td>
				<td><input name="searchNom" title="Partie du nom du client" type="text" id="searchNom" class="inputText extended" value="<?php if(isset($_POST['searchNom'])) echo $_POST['searchNom'] ?>" /></td>
				<td><label for="searchPrenom">Prénom&nbsp;: </label></td>
				<td><input name="searchPrenom" title="Partie du prénom du client" type="text" id="searchPrenom" class="inputText extended" value="<?php if(isset($_POST['searchPrenom'])) echo $_POST['searchPrenom'] ?>" /></td>
				<td><label for="searchEntreprise">Entreprise&nbsp;: </label><input type="checkbox" id="searchEntreprise" name="searchEntreprise" value="checked" <?php if(isset($_POST['searchEntreprise']) && $_POST['searchEntreprise'] == "checked") echo 'checked="checked" ' ?>/></td>
				<td><label for="searchParticulier">Particulier&nbsp;: </label><input type="checkbox" id="searchParticulier" name="searchParticulier" value="checked" <?php if(isset($_POST['searchParticulier']) && $_POST['searchParticulier'] == "checked") echo 'checked="checked" ' ?>/></td>
				<td><input type="submit" class="inputSubmit" value="Rechercher client" /></td>
			</tr>
		</table>
	</form>
	-->
</div>

<?php require DIR_INC.'footer.inc.php' ?> 
