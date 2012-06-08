<?php require DIR_INC.'admin.header.inc.php' ?>

<h1>Paramètres du site</h1>
<table style="width: 100%">
	<tr>
		<td style="width : 300px"><label for="metaDescription">Description du site :</label></td>
		<td>
		<input type="text" name="metaDescription" id="metaDescription" style="width: 100%" /></td>
	</tr>
	<tr>
		<td><label for="metaKeywords">Mots-clefs séparés par une virgule :</label></td>
		<td><input type="text" name="metaKeywords" id="metaKeywords" style="width: 100%" /></td>
	</tr>
	<tr>
		<td><label for="metaAuthor">Auteur du site :</label></td>
		<td><input type="text" name="metaAuthor" id="metaAuthor" style="width: 100%" /></td>
	</tr>
	<tr>
		<td><label for="metaReplyto">Adresse mail de contact :</label></td>
		<td><input type="text" name="metaReplyto" id="metaReplyto" style="width: 100%" /></td>
	</tr>
</table>

<?php require DIR_INC.'admin.footer.inc.php' ?>