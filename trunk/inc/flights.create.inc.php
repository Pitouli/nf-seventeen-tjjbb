<h2>Cr�er un vol - �tape 2 - S�lectionner un avion</h2>

<form method="post" action="<?php echo ROOT; ?>?c=flights&s1=create">
	<table class="largeTable">
		<tr>
			<th> </th>
			<th>Mod�le</th>
			<th>Capacit� pers.</th>
			<th>Capacit� fret</th>
			<th>Num avion</th>
			<th>Pr�c�dent<br />a�roport</th>
			<th>Terminal<br />compatible</th>
			<th>A�rport (terminal) d'arriv�e</th>
			<th>Prochaine<br />escale</th>
		</tr>
		<tr>
			<td><input type="radio" name="avion" value="<?php echo ''; ?>" /></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<input type="submit" class="inputSubmit" onclick="return confirm('Confirmez vous l\'ajout d\'un nouveau vol ?');"value="Ajouter vol" />
</form>