<h2>Historique des vols de l'aéroport : <?php echo $nomAeroport?> (<?php echo $nomVille?>) </h2>

<table class="largeTable">
	<tr>
		<th>Aéroport de départ</th>
		<th>Aéroport d'arrivé</th>
		<th>Date Départ</th>
		<th>Date Arrivée</th>
	</tr>
<?php
	foreach($historique as $vol)
	{

?>
	<tr>
		<td><?php echo $historique['aero_dep'] ?></td>
		<td><?php echo $historique['aero_ar'] ?></td>
		<td><?php echo $historique['dep'] ?></td>
		<td><?php echo $historique['ar'] ?></td>
	</tr>
<?php
	}
?>
</table>

<?php
	if(empty($resultSearch))
	{
?>
	<p>La recherche n'a renvoyé aucun résultat</p>
<?php
	}
?>