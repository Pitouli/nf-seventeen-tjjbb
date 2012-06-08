<?php require DIR_INC.'admin.header.inc.php' ?>

<h1>Gestion des albums</h1>

<?php require DIR_INC.'admin.report.inc.php' ?>

<div class="explain">
	<p>C'est ici que l'on peut gérer les albums</p>
	<p>On peut créer un nouvel album, en lui donnat un titre et une description et en indiquant son <em>album parent</em>. Cela permet de mieux &quot;répartir&quot; les albums (et de rendre la navigation plus intuitive pour l'utilisateur), ou d'y importer par la suite des photos grâce à la page d'<em>Importation</em>.</p>
	<p>En dessous, on voit la liste des albums actuels. </p>
	<p>En cliquant sur <em>modifier</em>, on peut pour chaque album&nbsp;:</p>
	<ul>
		<li>
			<strong>Modifier la description de l'album</strong><br />
			Il suffit d'écrire dans la &quot;boîte&quot; apparue sous le titre de l'album.
		</li>
		<li>
			<strong>Modifier la hiérarchie de l'album</strong><br />
			Il suffit de choisir quel sera le nouvel <em>album parent</em> dans la liste. Bien entendu, l'album ne peut pas être un &quot;fils&quot; de lui-même ou de ses propres albums &quot;fils&quot;. L'album <em>racine</em> (le 1er de la liste) sert de référence et ne peut donc pas être déplacé. Les <em>albums fils</em> suivent l'album déplacé.
		</li>
		<li>
			<strong>Modifier globablement le prix des photos de l'album</strong><br />
			Il faut choisir avec la liste déroulante le prix qui sera appliqué à toutes les photos contenues dans l'album. Par la sutie, il est possible dans la section <em>Gestion des photos</em> de modifier individuellement le prix de certaines photos.
		</li>
		<li>
			<strong>Modifier le titre de l'album</strong>
		</li>
	</ul>
	<p>En cliquant sur <em>supprimer/masquer</em>, on peut pour chaque album (sauf l'album <em>racine</em>) :</p>
	<ul>
		<li>
			<strong>Supprimer l'album et les photos qu'il contient</strong><br />
			Pour cela, il faut sélectionner l'option avec le &quot;bouton rond&quot; et valider le choix en cochant la case en bout de ligne. L'album sera supprimé, ses albums fils seront automatiquement &quot;remontés&quot; à son niveau (et ne seront donc pas supprimés), et ses photos seront indiquées par le système comme devant être supprimées. Leur suppression sera effectuée automatiquement par la suite.
		</li>
		<li>
			<strong>Supprimer l'album et déplacer les photos dans un autre album<br />
			</strong>Pour cela, il faut sélectionner l'option avec le &quot;bouton rond&quot; et indiquer dans quel album doivent être déplacées les photos que l'album à supprimer contient grâce à la liste déroulante en bout de ligne. Les sous-albums de l'album à supprimer seront eux aussi déplacés dans cet album cible.
		</li>
		<li>
			<strong>Masquer/démasquer l'album</strong><br />
			Pour cela, il faut sélectionner l'option avec le &quot;bouton rond&quot;. Il faut alors cocher la case en bout de ligne pour masquer l'album, ou la décocher pour rendre l'album visible. Les albums masqués ont leur noms barrés. Ils ne sont pas visibles dans la galerie. En particulier, les sous-albums d'un album masqué ne sont pas atteignables en naviguant simplement dans la galerie. Ils restent cependant visible pour quelqu'un qui connaît leur adresse.<br />
			NB: On peut créer un album &quot;Section privée&quot; masqué. Tout les sous-albums de cette section ne seront pas visible directement dans la galerie, mais resteront visible pour ceux qui connaissent leur adresse.
		</li>
	</ul>
	<p>En cliquant sur <em>pièces-jointes</em>, on peut pour chaque album gérer les pièces jointes qui y sont rattachées, à savoir :</p>
	<ul>
		<li>
			<strong>Renommer la pièce-jointe<br />
			</strong>Il suffit de remplacer le nom dans la case par un nom valide
		</li>
		<li>
			<strong>Changer l'album<br />
			</strong>En sélectionnant le nouvel album auquel se rattache la pièce jointe dans la liste déroulante
		</li>
		<li>
			<strong>Changer le statut de la pièce-jointe</strong><br />
			On peut la rendre visible dans la galerie, la masquer, ou la supprimer. Attention : la suppression n'est pas immédiate. Une pièce-jointe signalée comme à supprimer n'apparaît immédiatement plus dans la galerie, mais la suppression proprement dite est réalisée par une tâche automatique (que l'on peut lancer manuellement en allant dans l'interface de gestion des tâches).
		</li>
	</ul>
</div>

<div class="corps">

	<h2>Création d'un nouvel album</h2>
	
	<form method="post" action="<?php echo ROOT; ?>admin/gestion/albums.html" id="form_album_add">
		<table class="largeTable">
			<tr>
				<td style="width: 150px;">
					Titre&nbsp;:
				</td>
				<td>
					<input type="text" name="album_title" value="" class="inputText" />
				</td>
				<td rowspan="3" style="width: 200px;">
					<input type="hidden" name="album_form" value="add" />
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
						foreach($listAlbumsOptions as $alb) 
						{
						?>
						<option value="<?php echo $alb['id']; ?>" /><?php echo $alb['title']; ?></option>
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
					<textarea name="album_description"></textarea>
				</td>
			</tr>
		</table>
	</form>
	
	<h2>Gestion des titres et hiérarchies</h2>  
	
	<?php
	foreach($listAlbums as $alb) 
	{
	?>
	<div style="margin-left: <?php echo $alb['rank']*50; ?>px;" class="tree_album" id="tree_album_<?php echo $alb['id']; ?>">
		
		<input type="hidden" name="album_id" class="album_id" value="<?php echo $alb['id']; ?>" />
		<input type="hidden" name="album_rank" class="album_rank" value="<?php echo $alb['rank']; ?>" />
		<input type="hidden" name="album_parent" class="album_parent" value="<?php echo $alb['id_parent']; ?>" />
		
		<p class="tree_album_title <?php if($alb['hide']) echo 'tree_album_title_hide'; ?>">
			<span class="tree_album_title_text"><?php echo $alb['title']; ?></span>
			<span class="tree_album_form_selector"> 
				&nbsp;-&nbsp;<a href="#" class="show_form_album_edit"><em>modifier</em></a>
				<?php 
				if($alb['id'] != 1) 
				{ 
				?>
				&nbsp;-&nbsp;<a href="#" class="show_form_album_suppr"><em>supprimer/masquer</em></a>
				<?php 
				} 
				?>
				&nbsp;-&nbsp;<a href="#" class="show_form_album_attchmt"><em>pièces-jointes (<?php echo $alb['nb_attachments'] ?>)</em></a>
			</span>
		</p>
		
		<form method="post" action="<?php echo ROOT; ?>admin/gestion/albums.html#tree_album_<?php echo $alb['id']; ?>" id="form_album_edit_<?php echo $alb['id']; ?>" class="form_album">
		</form>

		<form method="post" action="<?php echo ROOT; ?>admin/gestion/albums.html#tree_album_<?php echo $alb['id']; ?>" id="form_album_suppr_<?php echo $alb['id']; ?>" class="form_album">        
		</form> 

		<div id="form_album_attchmt_<?php echo $alb['id']; ?>" class="form_album">     
		</div>

	</div>    
	<?php
	}
	?>
	
	<div style="position: fixed; top: 0px;" id="tree_album_fixed"></div>  
	
</div>

<script type="text/javascript">
listAlbumsOptions = <?php echo $json_listAlbumsOptions ?>;
</script>

<?php require DIR_INC.'admin.footer.inc.php' ?> 