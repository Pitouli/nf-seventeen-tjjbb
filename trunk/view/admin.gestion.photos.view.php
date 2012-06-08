<?php require DIR_INC.'admin.header.inc.php' ?>

<h1>Gestion des photos</h1>

<?php require DIR_INC.'admin.report.inc.php' ?>

<div class="explain">
  <p>La gestion des photos se fait dans cette section.</p>
    <p>Il faut d'abord retrouver les photos sur lesquelles on veut agir. Pour cela, on peut choisir au choix d'afficher un album, ou alors faire une recherche avec le nom de la photo. Les mots clefs doivent être séparés par un espace, et il est possible de choisir le comportement du moteur de recherche : s'il est réglé sur <em>OR</em>, ce sont toutes les photos comportant <strong>au moins un</strong> des mots clefs qui seront sélectionnées&nbsp;; s'il est réglé sur <em>AND</em>, ce sont toutes les photos comportant <strong>tous</strong> les mots clef qui seront sélectionnées. </p>
  <p>Quand la liste des photos apparaît, il y a deux manières d'agir.</p>
  <ul>
    <li><strong>On peut modifier les caractéristiques photo par photo</strong><strong></strong><br />
      Pour cela, il suffit de changer les paramètres, à savoir réécrire le titre ou modifier les valeurs des listes déroulantes.
       La sauvegarde est automatique lors du changement de valeur dans les listes ou lorsqu'on clique à l'extérieur de la zone de texte (et que le &quot;|&quot;
    arrête de clignoter dans la zone de texte). Si la sauvegarde a réussie, l'élément deviendra briévement tout vert (texte, bordures et fond) puis l'effet s'estompera pour ne laisser que les bordures de vertes (ce qui laisse une indication visible &quot;longtemps&quot;, tout en permettant de constater le résultat des éventuels changements suivants). En cas d'échec, même principe mais en rouge.<br />
    Il est conseillé d'attendre qu'un élément soit revenu à la normale (bordure exceptée) avant de faire de nouvelles modifications. Il est aussi conseillé de ne pas multiplier les appels à la base de donnée (ie ne pas faire de modifications &quot;pour rien&quot;).</li>
    <li><strong>On peut modifier des caractéristiques de plusieurs photos à la fois</strong><strong></strong><br />
      Pour cela, il faut sélectionner les photos sur lesquelles on veut agir avec la petite case à cocher en début de ligne. En haut du tableau se trouve des liens qui permettent d'accélérer le processus. De plus, si on clique sur une case à la ligne <em>x</em>, et qu'on clique ensuite sur une case à la ligne <em>y</em> alors qu'on appuie sur la touche <em>majuscule</em> du clavier, toutes les cases des lignes <em>x</em> à <em>y</em> (<em>x</em> et <em>y</em> comprises, que <em>x</em> soit au dessus ou au-dessous de <em>y</em>) seront passées dans le même état que la case <em>x</em> (coché ou décoché, selon que <em>x</em> est cochée ou décochée).<br />
    La sélection faite, on trouve <strong>en bas du tableau</strong> des options que l'on peut appliquer à toutes les photos cochées d'un coup (modification du prix, de la visibilité, de l'album, suppression, etc.)</li>
  </ul>
  <p>Quelques remarques importantes :</p>
<ul>
    <li><strong>Masquer une photo</strong>, c'est ne plus la faire apparaître dans l'album, sans pour autant qu'elle ne soit supprimée. On gère cette option dans la liste &quot;visible/masquée/supprimée&quot;.</li>
    <li>On <strong>supprime</strong> une photo en choisissant cette option dans la liste &quot;visible/masquée/supprimée&quot;. La suppression masque la photo d'une part, et la signale d'autre part comme devant être supprimée. Cette suppression n'a pas un effet immédiat, mais est effectuée par un script appelé périodiquement. Ce script peut être lancé manuellement dans la section <em>Tâches automatiques</em> du panneau d'administration. Tant qu'une photo n'a pas été effectivement supprimée, sa suppression peut être annulée en changeant la valeur dans la liste.</li>
    <li>Pour éviter d'avoir à sélectionner photo par photo, utiliser à bon escient le moteur de recherche peut faire gagner un temps précieux !</li>
</ul>
</div>

<div class="corps">
  <table class="minTable center">
    <tr>
      <td><form method="post"><input type="hidden" name="explore_by" value="album" /><select name="id_album">
        <?php
        foreach($listAlbums as $alb) {
    ?>
        <option value="<?php echo $alb['id']; ?>" />      
        <?php for ($i = 1; $i <= $alb['rank']; $i++){ echo "&nbsp;-&nbsp;";} ?>
        <?php echo $alb['title']; ?>
        </option>
        <?php
        }
    ?>
      </select>
        <br />
<input type="submit" value="Choisir un album" /></form></td>
      <td>ou</td>
      <td><form method="post"><input type="hidden" name="explore_by" value="search" /><input type="text" name="search" />
        <select name="search_type">
          <option value="and">AND</option>
          <option value="or">OR</option>
        </select>
        <br />
<input type="submit" value="Faire une recherche"  /></form></td>
    </tr>
  </table>
  <noscript><p><strong>Javascript n'est pas activé !</strong> La sauvegarde des changements ne sera pas fonctionnelle !</p></noscript>
  <?php
if(isset($listPhotos) && !empty($listPhotos))
{
?>
<p>Sélectionner les photos&nbsp;: <a href="#" id="checkPhotoAll">toutes</a> - <a href="#" id="checkPhotoNone">aucunes</a> - <a href="#" id="checkPhotoInv">inverser</a> - <a href="#" id="checkPhoto2suppr">supprimées</a> - <a href="#" id="checkPhotoVisible">visibles</a> - <a href="#" id="checkPhotoHide">masquées</a> - 
<select name="checkPhotoPrice" id="checkPhotoPrice">
	<option value="titleOfTheSelect" selected="selected">Prix</option>
<?php
foreach($listPrices as $price) {
?>
	<option value="<?php echo $price['id']; ?>" ><?php echo $price['title']; ?></option>
<?php
}
?>
</select></p>
  <table class="largeTable tableListPhotos">
<?php
	foreach($listPhotos as $photo)
	{
?>
    <tr class="trListPhotos">
      <td><input type="hidden" name="photoId" class="photoId" value="<?php echo $photo['id']; ?>" /><input type="hidden" name="albumId" class="albumId" value="<?php echo $photo['id_album']; ?>" /><input type="checkbox" name="photoChecked" title="Sélectionner la photo" class="photoChecked" /></td>
      <td class="tdPreview"><a href="<?php echo ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension']; ?>" title="Afficher la version SD"><img src="<?php echo ROOT.'style/images/loading.gif'; ?>" rel="<?php echo ROOT.DIR_PHOTOS_MIN.$photo['folder'].$photo['webname'].$photo['extension']; ?>" alt="miniature" />Aperçu</a></td>
      <td><input name="photoTitle" title="Titre de la photo" type="text" class="inputText photoTitle updateAjax" value="<?php echo $photo['title']; ?>" id="photoTitle_<?php echo $photo['id']; ?>" /></td>
      <td><select name="photoPrice" title="Prix de la photo" class="photoPrice updateAjax" id="photoPrice_<?php echo $photo['id']; ?>">
        <?php
        foreach($listPrices as $price) {
    	?>
			<option value="<?php echo $price['id']; ?>" <?php if($photo['id_price']==$price['id']) { echo 'selected="selected"'; } ?> ><?php echo $price['title']; ?></option>
        <?php
        }
  		?>
      </select></td>
      <td><select name="photoAlbum" title="Album de la photo" class="photoAlbum updateAjax" id="photoAlbum_<?php echo $photo['id']; ?>">
		<option>Chargement des albums en cours...</option>
      </select></td>
      <td><select name="photoStatus" title="Visiblité de la photo" class="photoStatus updateAjax" id="photoStatus_<?php echo $photo['id']; ?>">
          <option value="visible">Visible</option>
          <option value="hide" <?php if($photo['status']=="hide") { echo 'selected="selected"'; } ?>>Masquée</option>
          <option value="2suppr" <?php if($photo['status']=="2suppr") { echo 'selected="selected"'; } ?>>Supprimée</option>
          <?php if(!in_array($photo['status'],array("2suppr","hide","visible"))) {?>
          <option value="<?php echo $photo['status']; ?>" selected="selected"><?php echo $photo['status']; ?></option><?php } ?>
      </select></td>
    </tr>
<?php
	}
?>
  </table>

<table class="minTable centre">
<tr><td>Appliquer aux photos séléctionnées&nbsp;</td></tr>
<tr><td>
<input type="hidden" name="photoId" class="photoId" value="check" />
  <select name="photoPrice" title="Prix des photos sélectionnées" class="photoPrice updateAjax" id="photoPrice_check">
    <option value="titleOfTheSelect" selected="selected">Prix</option>
        <?php
        foreach($listPrices as $price) {
    	?>
			<option value="<?php echo $price['id']; ?>" <?php if($photo['id_price']==$price['id']) { echo 'selected="selected"'; } ?> ><?php echo $price['title']; ?></option>
        <?php
        }
  		?>
  </select>
  <select name="photoAlbum" title="Album des photos sélectionnées" class="photoAlbum updateAjax" id="photoAlbum_check">
	<option>Chargement des albums en cours...</option>
  </select>
  <select name="photoStatus" title="Visiblité des photos sélectionnées" class="photoStatus updateAjax" id="photoStatus_check">
    <option value="titleOfTheSelect" selected="selected">Visibilité</option>
    <option value="visible">Visible</option>
    <option value="hide">Masquée</option>
    <option value="2suppr">Supprimée</option>
  </select>
</td></tr>
</table>
<?php
}
?>
</div>

<script type="text/javascript">
listAlbumsOptions = <?php echo $json_listAlbumsOptions ?>;
</script>

<?php require DIR_INC.'admin.footer.inc.php' ?> 