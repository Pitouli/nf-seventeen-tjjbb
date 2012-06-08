
<p>
	Vos choix d'affichages :
	<select name="logbookType" id="logbookType">
		<option value="all" <?php if($logbookType=='all') echo 'selected="selected"' ?>>type : Tous</option>
		<?php
		foreach($arrayType as $type)
		{
		?>
		<option value="<?php echo $type ?>"  <?php if($logbookType==$type) echo 'selected="selected"' ?>>type : <?php echo $type ?></option>
		<?php
		}
		?>
	</select>
	<select name="logbookSuccess" id="logbookSuccess">
		<option value="all" <?php if($logbookSuccess=='all') echo 'selected="selected"' ?>>état : Tous</option>
		<option value="1" <?php if($logbookSuccess=='1') echo 'selected="selected"' ?>>état : Succès</option>
		<option value="0" <?php if($logbookSuccess=='0') echo 'selected="selected"' ?>>état : Echec</option>
	</select>
	<select name="logbookLimit" id="logbookLimit">
		<option value="10" <?php if($logbookLimit==10) echo 'selected="selected"' ?>>nombre : 10</option>
		<option value="20" <?php if($logbookLimit==20) echo 'selected="selected"' ?>>nombre : 20</option>
		<option value="50" <?php if($logbookLimit==50) echo 'selected="selected"' ?>>nombre : 50</option>
		<option value="100" <?php if($logbookLimit==100) echo 'selected="selected"' ?>>nombre : 100</option>
		<option value="200" <?php if($logbookLimit==200) echo 'selected="selected"' ?>>nombre : 200</option>
		<option value="400" <?php if($logbookLimit==400) echo 'selected="selected"' ?>>nombre : 400</option>
	</select>
	<input type="button" value="Recharger" id="logbookReboot" />
</p>

<hr />

<table class="largeTable statsTable">
	<tr>
		<td><strong>Type</strong></td>
		<td><strong>Auteur</strong></td>
		<td><strong>Description</strong></td>
		<td><strong>Date</strong></td>
	</tr>
	<?php
	foreach($listEvents as $event)
	{
	?>
	<tr class="<?php if($event['success']) echo 'success'; else echo 'errors'; ?>">
		<td><?php echo $event['type'] ?></td>
		<td><?php echo $event['author'] ?></td>
		<td><?php echo $event['description'] ?></td>
		<td><?php echo $event['datetime'] ?></td>
	</tr>
	<?php
	}
	?>
</table>
