<?php require DIR_INC.'header.inc.php' ?>

<h1>Statistiques</h1>

<?php require DIR_INC.'report.inc.php' ?>

<div class="explain">
	<p>Cher administrateur de notre réseau aérien, nous vous invitons à découvrir ici quelques statistiques pour vous donner un aperçu de l'importance de ne système&nbsp;!</p>
</div>

<div class="corps">

	<h2>Des chiffres simples...</h2>
	<ul>
		<li>Nombre d'avions dans la flotte : <?php echo $nbAvions; ?></li>
		<li>Nombre de clients : <?php echo $nbClients; ?></li>
		<li>Capacité totale de transport de passagers : <?php echo $totalVoyageurs; ?></li>
		<li>Capacité totale de transport de fret : <?php echo $totalFret; ?></li>
		<li>Nombre d'aéroports desservis : <?php echo $nbAeroports; ?></li>
		<li>Nombre de vols au départ dans les 24 prochaines heures : <?php echo $nbVol24heures; ?></li>
	</ul>
	<h2>...jusqu'aux plus compliqués !</h2>
	<ul>
		<li>Destination finale la plus populaire&nbsp;: </li>
		<li>Temps moyen d'un voyage lors du dernier mois&nbsp;: </li>
	</ul>
	<p>...</p>

</div>

<?php require DIR_INC.'footer.inc.php' ?> 