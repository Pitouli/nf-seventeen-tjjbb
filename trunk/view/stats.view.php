<?php require DIR_INC.'header.inc.php' ?>

<h1>Statistiques</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>Cher administrateur de notre réseau aérien, nous vous invitons à découvrir ici quelques statistiques pour vous donner un aperçu de l'importance de ne système&nbsp;!</p>
	<p>Cela permet d'avoir un rapide aperçu des données entrées dans la base, et d'implementer quelques requetes plus complexes&nbsp;!</p>
</div>

<div class="corps">

	<h2>Quelques chiffres :</h2>
	<ul>
		<li>Nombre de clients : <?php echo $nbClients; ?></li>
		<li>Nombre d'avions dans la flotte : <?php echo $nbAvions; ?></li>
		<li>Capacité totale de transport de passagers : <?php echo $totalVoyageurs; ?></li>
		<li>Capacité totale de transport de fret : <?php echo $totalFret; ?></li>
		<li>Nombre d'aéroports desservis : <?php echo $nbAeroports; ?></li>
		<li>Nombre de vols au départ dans les 24 prochaines heures : <?php echo $nbVol24heures; ?></li>
	</ul>
	<h2>Quelques statistiques</h2>
	<ul>
		<li>Destination(s) la(les) plus populaire(s) : </li>
		<?php
		foreach($Popularite as $ville){
		?>
		<ul><?php echo $ville['nom'];?> : <?php echo $ville['nb'];?> resevation(s)</ul>
		<?php };?>
		</li>
		
		<li>Total des heures de vol par clients</li>
		<?php
		foreach($totalHeure as $client){
		?>
		<ul><?php echo $client['nom'];?>, <?php echo $client['prenom'];?> : <?php echo $client['duree'];?> heure(s) de vol</ul>
		<?php };?>
	</ul>

</div>

<?php require DIR_INC.'footer.inc.php' ?> 