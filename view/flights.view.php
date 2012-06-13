<?php require DIR_INC.'header.inc.php' ?>

<h1>Gestion du traffic aérien</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>A travers cette page, vous pourrez ajouter un nouveau vol, ou bien consulter ou supprimer un vol existant.</p>
	<p><strong>WARNING : PAGE EN CHANTIER, C'EST NORMAL DE VOIR DES CHOSES ABERRANTES... :D</strong></p>
</div>

<div class="corps">

	<h2>Créer un vol - étape 1</h2>

	<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=new">
		<table class="largeTable">
			<tr>
				<td><label for="depart">Départ</label></td>
				<td>
				   <select name="depart" id="depart">
					   <option value="qqchose">Ville Bidon 1</option> <?php /* COMMENT FAIRE AVEC LE SQL... ? */?>
					   <option value="qqchose">Ville Bidon 2</option>
				   </select>
				</td>
				<td><label for="pays">Arrivée</label></td>
				<td>
				   <select name="depart" id="depart">
					   <option value="qqchose">Ville Bidon 1</option> <?php /* COMMENT FAIRE AVEC LE SQL... ? */?>
					   <option value="qqchose">Ville Bidon 2</option>
				   </select>
				</td>
				<td><label for="Hdepart">H Départ</label></td>
				<td><input type="datetime" name="Hdepart" /></td>
				<td><label for="Harrivee">H Départ</label></td>
				<td><input type="datetime" name="Harrivee" /></td>
			</tr>
			
			<tr>
				<td><label for="capaciteMin"><strong>Capacité passager</strong></label></td>
				<td><label for="capaciteMin">Minimum :</label></td>
				<td><input type="number" name="capaciteMin" /></td>
				<td><label for="capaciteMax">Maximum :</label></td>
				<td><input type="number" name="capaciteMax" /></td>
				<td><label for="fretMin"><strong>Fret</strong></label></td>
				<td><label for="fretMin">Minimum :</label></td>
				<td><input type="number" name="fretMin" /></td>
				<td><label for="fretMax">Maximum :</label></td>
				<td><input type="number" name="fretMax" /></td>
				<td><input type="submit" class="inputSubmit" value="Valider" /></td>
			</tr>
			
		</table>
	</form>
		
		
	<h2>Chercher un vol</h2>
		
	<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=search">
		<table class="largeTable">
			<tr>
				<td><label for="depart">Départ</label></td>
				<td>
				   <select name="depart" id="depart">
					   <option value="qqchose">Ville Bidon 1</option> <?php /* COMMENT FAIRE AVEC LE SQL... ? */?>
					   <option value="qqchose">Ville Bidon 2</option>
				   </select>
				</td>
				<td><label for="pays">Arrivée</label></td>
				<td>
				   <select name="depart" id="depart">
					   <option value="qqchose">Ville Bidon 1</option> <?php /* COMMENT FAIRE AVEC LE SQL... ? */?>
					   <option value="qqchose">Ville Bidon 2</option>
				   </select>
				</td>
			</tr>
			<tr>
				<td><label for="Hdepart">H Départ</label></td>
				<td><input type="datetime" name="Hdepart" /></td>
				<td><label for="Harrivee">H Départ</label></td>
				<td><input type="datetime" name="Harrivee" /></td>
			</tr>
		</table>
	</form>
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