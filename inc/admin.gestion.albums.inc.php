<?php
if($_POST['part'] == 'form_album_edit')
{
?>
<table class="largeTable">
	<tr>
		<td style="width: 150px;">
			Titre&nbsp;:
		</td>
		<td>
			<input type="text" name="album_title" value="<?php echo $alb['title']; ?>" class="inputText" />
		</td>
		<td rowspan="4" style="width: 200px;">
			<input type="hidden" name="album_id" value="<?php echo $alb['id']; ?>" />
			<input type="hidden" name="album_form" value="edit" />
			<input type="submit" value="Sauvegarder les changements" class="inputSubmit" />
		</td>
	</tr>
	<tr>
		<td>
			Album parent&nbsp;:
		</td>
		<td>
			<select name="album_parent">
				<?php
				if($alb['id'] == 1) 
				{
				?>
				<option>Cet album ne peut pas être bougé</option>
				<?php
				}
				?>        
			</select>            
		</td>
	</tr>
	<tr>
		<td>
			Description&nbsp;:
		</td>
		<td>
			<textarea name="album_description"><?php echo $alb['description']; ?></textarea>
		</td>
	</tr>
	<tr>
		<td>
			Prix des photos&nbsp;:
		</td>
		<td>
			<select name="album_prix">
				<option value="titleOfTheSelect" selected="selected">Ne pas modifier le prix des photos</option>
			<?php
			foreach($listPrices as $price) {
			?>
				<option value="<?php echo $price['id']; ?>"><?php echo $price['title']; ?></option>
			<?php
			}
			?>
			</select>
		</td>
	</tr>
</table>
<?php
}
else if($_POST['part'] == 'form_album_suppr')
{
?>
<table class="largeTable">
	<tr>
		<td>
			<input type="radio" name="album_suppraction" id="album_suppraction_suppr_<?php echo $alb['id']; ?>" value="suppr" />
		</td>
		<td>
			<label for="album_suppraction_suppr_<?php echo $alb['id']; ?>">Supprimer  l'album et les photos qu'il contient</label>
		</td>
		<td>
			<input type="checkbox" name="album_suppr_confirm" id="album_suppr_confirm_<?php echo $alb['id']; ?>" />
			<label for="album_suppr_confirm_<?php echo $alb['id']; ?>">(cocher pour confirmer)</label>
		</td>
		<td rowspan="3">
			<input type="hidden" name="album_id_parent" value="<?php echo $alb['id_parent']; ?>" />
			<input type="hidden" name="album_id" value="<?php echo $alb['id']; ?>" />
			<input type="hidden" name="album_form" value="suppr" />
			<input type="submit" value="Supprimer/Masquer" onclick="return confirm('Attention ! Les actions de suppressions sont irréversibles ! Confirmez vous votre action ?');" class="inputSubmit" />
		</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="album_suppraction" id="album_suppraction_move_<?php echo $alb['id']; ?>" value="move" />
		</td>
		<td>
			<label for="album_suppraction_move_<?php echo $alb['id']; ?>">Supprimer l'album et déplacer les photos dans cet album&nbsp;:</label>
		</td>
		<td>
			<select name="album_dest">       
			</select>          
		</td>
	</tr>
	<tr>
		<td>
			<input type="radio" name="album_suppraction" id="album_suppraction_hide_<?php echo $alb['id']; ?>" value="hide" />
		</td>
		<td>
			<label for="album_suppraction_hide_<?php echo $alb['id']; ?>">Masquer l'album (cocher la case pour &quot;oui&quot;)&nbsp;:</label>
		</td>
		<td>
			<input type="checkbox" name="album_hide" id="album_hide" <?php if($alb['hide']) echo 'checked="checked"'; ?> />
		</td>
	</tr>
</table>
<?php
}
else if($_POST['part'] == 'form_album_attchmt')
{
?>
<table class="largeTable">
	<?php
	if(isset($attachments) && $attachments != NULL)
	{
		foreach($attachments as $attchmt)
		{
	?>
	<tr class="trListPhotos">
		<td class="tdPreview">
			<input type="hidden" name="attchmtId" class="attchmtId" value="<?php echo $attchmt['id']; ?>" />
			<a href="<?php echo ROOT ?>download/attachment,a<?php echo $attchmt['id']; ?>.html" title="Télécharger la pièce-jointe">Télécharger</a>
		</td>
		<td>
			<input name="attchmtTitle" title="Titre de la pièce jointe" type="text" class="inputText attchmtTitle updateAjax" value="<?php echo $attchmt['title']; ?>" id="attchmtTitle_<?php echo $attchmt['id']; ?>" />
		</td>
		<td>
			<select name="attchmtAlbum" title="Album auquel rattacher la pièce-jointe" class="attchmtAlbum updateAjax" id="attchmtAlbum_<?php echo $attchmt['id']; ?>">   
			</select>
		</td>
		<td>
			<select name="attchmtStatus" title="Visiblité de la pièce-jointe" class="attchmtStatus updateAjax" id="attchmtStatus_<?php echo $attchmt['id']; ?>">
				<option value="visible">Visible</option>
				<option value="hide" <?php if($attchmt['status']=="hide") { echo 'selected="selected"'; } ?>>Masquée</option>
				<option value="2suppr" <?php if($attchmt['status']=="2suppr") { echo 'selected="selected"'; } ?>>Supprimée</option>
				<?php 
				if(!in_array($attchmt['status'],array("2suppr","hide","visible"))) 
				{
				?>
				<option value="<?php echo $attchmt['status']; ?>" selected="selected"><?php echo $attchmt['status']; ?></option>
				<?php 
				} 
				?>
			</select>
		</td>
	</tr>
	<?php
		}
	}
	else
	{
	?>
	<tr>
		<td>
			Il n'y a pas de pièce-jointe dans cet album
		</td>
	</tr>
	<?php
	}
	?>
</table>
<?php
}
?>