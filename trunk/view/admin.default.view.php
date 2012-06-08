<?php require DIR_INC.'admin.header.inc.php' ?>

<h1>Panneau d'administration</h1>

<?php require DIR_INC.'admin.report.inc.php' ?>

<div class="explain">
	<p>Bienvenue sur votre interface d'administration !</p>
</div>

<h2>Statistiques du contenu</h2>

<div id="statsContentDiv">
<table class="largeTable statsTable">
	<tr>
		<td>&nbsp;</td>
		<td><strong>Visibles</strong></td>
		<td><strong>Masqués</strong></td>
		<td><strong>A supprimer</strong></td>
		<td><strong>Stock / regeMin</strong></td>
		<td><strong>Autre</strong></td>
		<td><strong>Total</strong></td>
	</tr>
	<tr>
		<td><strong>Photos</strong></td>
		<td><?php echo $photosVisible ?></td>
		<td><?php echo $photosHide ?></td>
		<td><?php echo $photos2Suppr ?></td>
		<td><?php echo $photosStock ?></td>
		<td <?php if($photosOther>0) echo 'class="errors"' ?>><?php echo $photosOther ?></td>
		<td><strong><?php echo $photosTotal ?></strong></td>
	</tr>
	<tr>
		<td><strong>Pièces jointes</strong></td>
		<td><?php echo $attchmtVisible ?></td>
		<td><?php echo $attchmtHide ?></td>
		<td><?php echo $attchmt2Suppr ?></td>
		<td>-</td>
		<td <?php if($attchmtOther>0) echo 'class="errors"' ?>><?php echo $attchmtOther ?></td>
		<td><strong><?php echo $attchmtTotal ?></strong></td>
	</tr>
	<tr>
		<td><strong>Albums</strong></td>
		<td><?php echo $albumsVisible ?></td>
		<td><?php echo $albumsHide ?></td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td><strong><?php echo $albumsTotal ?></strong></td>
	</tr>
</table>
<hr />
<table class="largeTable statsTable">
	<tr>
		<td><strong>Fichiers en attente d'import</strong></td>
		<td><strong>Crédit Webcron restant</strong></td>
	</tr>
	<tr>
		<td><?php echo $nb_files ?></td>
		<td <?php if($credits < 0.5) echo 'class="errors"' ?>><?php echo $credits ?>&nbsp;€</td>
	</tr>
</table>
</div>

<h2>Statistiques de fréquentation</h2>

<div id="statsFreqDiv">
	<p>Les statistiques sont en train d'être récupérées... Veuillez patienter...</p>
</div>

<h2>Journal de bord</h2>

<div id="logbookDiv">
	<p>Le journal est en cours de chargement... Veuillez patienter...</p>
</div>

<?php require DIR_INC.'admin.footer.inc.php' ?> 