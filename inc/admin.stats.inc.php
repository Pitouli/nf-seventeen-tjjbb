<table class="largeTable statsTable">
	<tr>
		<td>&nbsp;</td>
		<td><strong>Depuis 24 heures </strong><em>(7 jours avant)</em></td>
		<td><strong>Depuis 1 mois </strong><em>(1 an avant)</em></td>
		<td><strong>Depuis 1 an</strong><em> (1 an avant)</em></td>
		<td rowspan="4"><strong>Nb de visiteurs uniques depuis le début</strong><br />
		<span style="font-size: 400%"><?php echo $stat['visitors']['sinceBeginning'] ?></span></td>
	</tr>
	<tr>
		<td><strong>Visiteurs</strong></td>
		<td><?php echo $stat['visitors']['sinceDay'] ?> <em>(<?php echo $stat['visitors']['dayWeekAgo'] ?>)</em></td>
		<td><?php echo $stat['visitors']['sinceMonth'] ?> <em>(<?php echo $stat['visitors']['monthYearAgo'] ?>)</em></td>
		<td><?php echo $stat['visitors']['sinceYear'] ?> <em>(<?php echo $stat['visitors']['yearYearAgo'] ?>)</em></td>
	</tr>
	<tr>
		<td><strong>Visites</strong></td>
		<td><?php echo $stat['visits']['sinceDay'] ?> <em>(<?php echo $stat['visits']['dayWeekAgo'] ?>)</em></td>
		<td><?php echo $stat['visits']['sinceMonth'] ?> <em>(<?php echo $stat['visits']['monthYearAgo'] ?>)</em></td>
		<td><?php echo $stat['visits']['sinceYear'] ?> <em>(<?php echo $stat['visits']['yearYearAgo'] ?>)</em></td>
	</tr>
	<tr>
		<td><strong>Pages vues</strong></td>
		<td><?php echo $stat['pageviews']['sinceDay'] ?> <em>(<?php echo $stat['pageviews']['dayWeekAgo'] ?>)</em></td>
		<td><?php echo $stat['pageviews']['sinceMonth'] ?> <em>(<?php echo $stat['pageviews']['monthYearAgo'] ?>)</em></td>
		<td><?php echo $stat['pageviews']['sinceYear'] ?> <em>(<?php echo $stat['pageviews']['yearYearAgo'] ?>)</em></td>
	</tr>
</table>

<hr />

<p>Provenance de vos visiteurs pour les 3 derniers mois (nombre de visites via ce domaine) :</p>
<p>
<?php
if(isset($stat['source']))
{
	foreach($stat['source'] as $src)
	{
?>
	|&nbsp;<a href="http://<?php echo $src['url'] ?>" title="Visiter <?php echo $src['url'] ?>"><?php echo $src['url'] ?></a> (<?php echo $src['occur'] ?>) 
<?php
	}
}
?>
|</p>

<hr />

<p>Mots clefs qui ont permis de trouver votre site ces 3 derniers mois (nombre de visites via ce mot clef) :</p>
<p>
<?php
if(isset($stat['keyword']))
{
	foreach($stat['keyword'] as $keyword)
	{
?>
	|&nbsp;<?php echo $keyword['word'] ?> (<?php echo $keyword['occur'] ?>) 
<?php
	}
}
?>
</p>