<?php require DIR_INC.'admin.header.inc.php' ?>
<h1>Importation</h1>

<?php require DIR_INC.'admin.report.inc.php' ?>

<div class="explain">
	<p>C'est ici que l'on peut rajouter des fichiers dans la galerie. L'ajout peut se faire de plusieurs manières, dont le choix dépendra du nombre de fichiers à importer. On peut bien évidemment mettre en ligne des photos qui seront ajoutées dans la galerie, mais aussi des fichiers documents (doc, txt, pdf) qui seront automatiquement mis comme pièce-jointe de l'album dans lequel ils sont placés.</p>
	<ul>
		<li><strong>L'importation manuelle</strong><br />
		    On sélectionne 1 par 1 les images à importer (mais on peut en envoyer plusieurs d'un coup, dans la limite de 50 Mo). Cette méthode est la plus simple mais de loin la plus longue. A réserver pour des petites mises à jour du contenu.    	</li>
		<li><strong>L'importation en archive zip</strong><br />
			Cette méthode à l'avantage face à l'importation de masse d'être effectuable directement depuis l'interface d'administration, mais l'archive zip est limitée à 50 Mo, et en cas d'erreur d'upload, il faut recommencer à zéro. Remarque : l'import zip peut se faire en parallèle de l'importation de masse.</li>
		
		<li><strong>L'importation de masse</strong><br />
		  Il s'agit de mettre en ligne tous les dossiers avec les images qui doivent être ajouter dans la galerie en conservant la hiérarchisation.	Cette	méthode permet de mettre en ligne des milliers de photos facilement : il suffit d'importer dans le dossier <em>import</em> du serveur les dossiers et images. Quand l'upload est fini (une fois lancé, il ne nécessite en général pas d'intervenetion de l'utilisateur. Donc ça peut être long, mais ça on ne perd pas son temps), il suffit de suivre les instructions pour l'importation de masse sur cette page.  </li>
	</ul>
  <p>Dans le cas de l'importation de masse et de l'importation d'archive zip, il y conservation de la hiérarchisation des dossiers. Il suffit d'indiquer l'album parent et toute la hiérarchisation d'album et sous-album sera reconstruite à partir de cet album parent. Si un dossier porte le même nom qu'un album existant, alors les documents du dossier seront importés dans cet ancien album. Sinon, un nouvel album sera créé (remarque : il peut y avoir plusieurs album avec le même nom, à condition qu'il soit inclus dans des albums différents. Exemple : il peut y avoir plusieurs dossiers <em>Capitale du pays</em>, mais l'un est dans l'album <em>France</em>, et l'autre dans l'album <em>Italie</em>).</p>
</div>

<div class="corps">
<h2>Importation 1 par 1</h2>
<p>Pour l'importation 1 par 1, il suffit de sélectionner les images et/ou documents qu'il faut mettre en ligne. Le prix et l'album associé est à indiquer individuellement (remarque : seules les photos prendront en compte le prix). Si il y a plus d'une dizaine de fichiers à importer, il est conseillé d'utiliser l'importation par zip.</p>
			<p>La somme des fichiers ne doit pas être de plus de <?php echo MAX_UPLOAD_SIZE_MO?> Mo (remarque : l'importation peut être très longue, en fonction de la taille des fichiers et de votre connexion).</p>
			<form enctype="multipart/form-data" method="post" action="<?php echo ROOT ?>admin/import/1n1.html">
			<table class="minTable">
				<tr>
					<td colspan="2"><label for="1n1_1_file"><strong>Le&nbsp;fichier&nbsp;n°1&nbsp;:</strong></label>					</td>
			  </tr>
				<tr>
					<td colspan="2"><input type="file" name="file[]" id="1n1_1_file" /></td>
			  </tr>
				<tr>
					<td><label for="1n1_1_id_parent">Album&nbsp;parent&nbsp;: </label></td>
					<td><select size="1" name="id_parent[]" id="1n1_1_id_parent">
						<?php echo $listSelectOptionAlbum ?>
					</select></td>
			  </tr>
				<tr>
					<td><label for="1n1_1_price">Prix&nbsp;:</label></td>
					<td><select size="1" name="id_price[]" id="1n1_1_price">
						<?php echo $listSelectOptionPrices ?>
					</select></td>
				</tr>
				<tr>
					<td colspan="2"><label for="1n1_2_file"><strong>Le&nbsp;fichier&nbsp;n°2&nbsp;:</strong></label>					</td>
			  </tr>
				<tr>
					<td colspan="2"><input type="file" name="file[]" id="1n1_2_file" /></td>
			  </tr>
				<tr>
					<td><label for="1n1_2_id_parent">Album&nbsp;parent&nbsp;: </label></td>
					<td><select size="1" name="id_parent[]" id="1n1_2_id_parent">
						<?php echo $listSelectOptionAlbum ?>
					</select>										</td>
			  </tr>
				<tr>
					<td><label for="1n1_2_price">Prix&nbsp;:</label></td>
					<td><select size="1" name="id_price[]" id="1n1_2_price">
						<?php echo $listSelectOptionPrices ?>
					</select></td>
				</tr>
				<tr>
					<td colspan="2"><label for="1n1_3_file"><strong>Le&nbsp;fichier&nbsp;n°3&nbsp;:</strong></label></td>
			  </tr>
				<tr>
					<td colspan="2"><input type="file" name="file[]" id="1n1_3_file" /></td>
			  </tr>
				<tr>
					<td><label for="1n1_3_id_parent">Album&nbsp;parent&nbsp;: </label></td>
					<td>
					<select size="1" name="id_parent[]" id="1n1_3_id_parent">
						<?php echo $listSelectOptionAlbum ?>
					</select>					</td>
			  </tr>
				<tr>
					<td><label for="1n1_3_price">Prix&nbsp;:</label></td>
					<td><select size="1" name="id_price[]" id="1n1_3_price">
						<?php echo $listSelectOptionPrices ?>
					</select></td>
			  </tr>
				<tr>
					<td colspan="2"><input type="submit" class="submit" value="Importer les fichiers" /></td>
				</tr>
			</table>
			</form>
			<h2>Importation par zip</h2>
  <p>Si le zip a une structure en dossier, chaque dossier sera interprété comme un album et les fichiers contenus dans le dossier seront rattachés à l'album.</p>
			<p>Le zip ne doit pas faire plus de <?php echo MAX_UPLOAD_SIZE_MO?> Mo (remarque : l'importation peut être très longue, en fonction de la taille des fichiers et de votre connexion).</p>
			<form enctype="multipart/form-data" method="post" action="<?php echo ROOT ?>admin/import/zip.html">
			<table class="minTable">
				<tr>
					<td colspan="2"><label for="fileZip">Le&nbsp;fichier&nbsp;zip&nbsp;:</label></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="MAX_FILE_SIZE" value="55000000" />
						<input type="file" name="fileZip" id="fileZip" />					
					</td>
				</tr>
				<tr>
					<td><label for="id_parentZip">Album&nbsp;parent&nbsp;: </label></td>
					<td>
						<select size="1" name="id_parent" id="id_parentZip">
							<?php echo $listSelectOptionAlbum ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="priceZip">Catégorie&nbsp;de&nbsp;prix&nbsp;: </label></td>
					<td>
						<select size="1" name="id_price" id="priceZip">
							<?php echo $listSelectOptionPrices ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" class="submit" value="Importer l'archive zip" /></td>
				</tr>
			</table>
			</form>			
<h2>Importation de masse</h2>
			<h3>Mise en ligne dans le dossier <em>import</em></h3>
			<p>Pour commencer, il faut importer les dossiers et photos dans le dossier <em>import</em> du serveur. Pour cela, il faut utiliser un gestionnaire de transfert ftp, avec les identifiants suivants :</p>
		<ul>
			<li>hôte ftp : <strong><?php echo FTP_HOST?></strong></li>
			<li>nom d'utilisateur : <strong><?php echo FTP_USERNAME?></strong></li>
			<li>mot de passe : <strong><?php echo FTP_PASSWORD?></strong></li>
  </ul>
		<p>Pour l'instant, le dossier <em>import</em> comporte <strong><?php echo $nb_files?></strong> fichiers.</p>
		<ul>
			<li><a href="#" onclick="alert('<?php echo $foldersInImportJsAlert ?>'); return false;" title="afficher arboserscence des dossiers" />Voir l'arborescence des dossiers</a></li>
			<li><a href="<?php echo ROOT ?>admin/import/cleanImport.html" onclick="return confirm('Voulez-vous vraiment vider complétement le dossier d\'importation et ses <?php echo $nb_files?> fichiers ? Cette action est irréversible');">Vider le dossier <em>import</em></a></li>
  </ul>
		<h3>Finalisation de l'importation</h3>
		<p>Quand l'importation des dossiers et photos est terminée, il faut finir l'importation en indiquant la catégorie de prix par défaut des photos et l'album parent.</p>
		<form method="post" action="<?php echo ROOT ?>admin/import/mass.html">
			<table class="minTable">
				<tr>
					<td><label for="id_parentMass">Album&nbsp;parent&nbsp;: </label></td>
					<td>
						<select size="1" name="id_parent" id="id_parentMass">
							<?php echo $listSelectOptionAlbum ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="priceMass">Catégorie&nbsp;de&nbsp;prix&nbsp;: </label></td>
					<td>
						<select size="1" name="id_price" id="priceMass">
							<?php echo $listSelectOptionPrices ?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" class="submit" onclick="return confirm('Confirmez vous l\'importation ?\nLe prochain chargement peut durer jusqu\'à 30 secondes');" value="Finir l'importation" /></td>
			  </tr>
			</table>
		</form>	
		<p>Remarque : pour des raisons techniques, les photos ne sont pas directement ajoutées dans la galerie, mais elles y sont mises petit à petit de manière totalement automatique. Le temps nécessaire pour la mise en ligne complète dépend du nombre de photo importées (pour plus d'informations sur le sujet, rendez vous sur la vue générale.)</p>
</div>

<?php require DIR_INC.'admin.footer.inc.php' ?>