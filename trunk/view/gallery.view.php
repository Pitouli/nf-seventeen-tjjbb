<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $page_description ?>"  />
<link rel="canonical" href="<?php echo $currentAlbumLink ?>" />
<title><?php echo BROWSER_SITE_TITLE.' - '.$current_album_title ?></title>
<?php require DIR_STYLE.'style.php' ?>
</head>

<body>
<div id="pageGallery">
	<div id="header">
		<div id="headerContent">
			<div id="title"><a href="<?php echo ROOT ?>" title="Retourner à l'accueil"><img src="<?php echo ROOT ?>style/images/title.png" alt="<?php echo SITE_TITLE ?>" width="200" height="55" /></a></div>
			<div id="menu">
				<ul>
					<li><a href="<?php echo ROOT ?>gallery.html" title="Racine de la Galerie">Galerie</a> &bull; </li>
					<li><span class="nbItemInFav notificationBadge" style="top: -5px; right: 15px;">0</span><a href="<?php echo ROOT ?>gallery/selection.html" title="Photos et Albums mis en favoris par l'utilisateur">Favoris</a> &bull; </li>
					<li><a href="<?php echo BLOG ?>" title="Le blog">Théologie</a> &bull; </li>
					<li><a href="<?php echo BLOG ?>static1/boutique" title="La boutique des photos">Boutique</a> &bull; </li>
					<li><a href="<?php echo BLOG ?>static2/plus" title="En savoir plus">Infos+</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="nav">
		<div id="navPanelGroup">
			<div id="navPanelDescription" class="navPanel">
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Description de l'album&nbsp;:</p>
					<div class="navPanelSectionContent">
						<p>
							<?php echo $current_album_description ?>
						</p>
					</div>
				</div>
				<hr />
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Pièces jointes de l'album (<?php echo $nb_attchmts ?>)&nbsp;:</p>
					<div class="navPanelSectionContent">	
						<?php 
						if(empty($list_attchmts))
							{
								echo '<p>Pas de pièces jointes pour cet album.</p>';
							}
						else
							{
						?>
						<ul>
						<?
								foreach($list_attchmts as $attchmt)
									{
						?>
							<li><a href="<?php echo ROOT.'download/attachment/'.$attchmt['id'].'-'.$attchmt['web_title'].'.html' ?>" title="Télécharger la pièce jointe"><?php echo $attchmt['title'] ?></a></li>			
						<?php
									}
						?>
						</ul>
						<?php
							}
						?>
					</div>
				</div>			
			</div>
			<div id="navPanelParam" class="navPanel">
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Taille des miniatures&nbsp;:</p>
					<div class="navPanelSectionContent">
						<p>
							<em>Cliquer-glisser vers la droite pour agrandir les miniatures, vers la gauche pour les rapetisser.</em>
						</p>
						<div id="testGalMinSize"></div>
					</div>
				</div>
				<hr />
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Optimisation des performances&nbsp;:</p>
					<div class="navPanelSectionContent">
						<p>
							<em>Si la navigation dans un album n'est pas fluide, désactiver certaines des options suivantes</em>
							<br /><input name="galMinShadow" type="checkbox" id="checkboxGalMinShadow" /> Ombrage sous les miniatures
							<br /><input name="galMinRounded" type="checkbox" id="checkboxGalMinRounded" /> Miniatures arrondies
						</p>
					</div>
				</div>
				<hr />
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Paramètres du diaporama :</p>
					<div class="navPanelSectionContent">
						<p>
							<em>Recharger la page pour que les modifications prennent effet</em>
							<br />Vitesse du diaporama&nbsp;: 
							<select name="selectSlideshowSpeed" id="selectSlideshowSpeed">
								<option selected="selected">Temps</option>
								<option value="500">0.5 sec</option>
								<option value="1000">1 sec</option>
								<option value="2000">2 sec</option>
								<option value="3000">3 sec</option>
								<option value="5000">5 sec</option>
								<option value="10000">10 sec</option>
								<option value="15000">15 sec</option>
								<option value="20000">20 sec</option>
								<option value="30000">30 sec</option>
								<option value="60000">1 min</option>
							</select>
							<br />Transition du diaporama&nbsp;:
							<select name="selectSlideshowTransition" id="selectSlideshowTransition">
								<option selected="selected">Choisir la transition</option>
								<option value="elastic">Elastique</option>
								<option value="fade">En fondu</option>
								<option value="none">Pas de transition</option>
							</select>
						</p>
					</div>
				</div>
				<hr />
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Naviguer en plein écran&nbsp;:</p>
					<div class="navPanelSectionContent">
						<p>
							<em>La galerie est encore plus belle en plein écran &nbsp;! Pour mettre le navigateur en plein écran, les raccourcis "classiques" sont&nbsp;:</em>
							<br />Sur PC &nbsp;: la plupart du temps, utiliser la touche F11 <br />Sur mac &nbsp;: essayer ["Pomme" (ou Cmd) + Entrée] ou ["Pomme" (ou Cmd) + Maj + F] 
						</p>
					</div>
				</div>
				<hr />
				<p><em>Info &nbsp;: Ces paramètres sont stockées sous forme de cookie sur l'ordinateur. Il seront ainsi sauvegardé 6 mois !</em></p>
			</div>
			<div id="navPanelCart" class="navPanel">
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Explications sur les achats&nbsp;:</p>
					<div class="navPanelSectionContent">
						<p>
							Les photos <acronym title="Haute Définition">HD</acronym> sont des photos de 2.000 pixels de large. Elles peuvent être téléchargées gratuitement (mais avec des marquages), ou achetées à l'unité, voire par album complet.
							<br />
							<strong>Le lien de téléchargement est immédiatement envoyé par mail après le paiement.</strong>
							<br />
							De plus, on peut acheter les photo en <acronym title="Full Définition">FD</acronym>, c'est à dire dans la définition native de l'appareil photo (avec l'éventuelle post-production du photographe).
							<br />
						<strong>L'envoi des photo en FD n'est pas instantané&nbsp;! Il est fait manuellement par les administrateurs&nbsp;!</strong><br />
						Les prix peuvent varier en fonction de la qualité, ou de la quantité (en cas d'achat par album complet).
						</p>
					</div>
				</div>
				<hr />
				<div class="navPanelSection">
					<p class="navPanelSectionTitle" id="cartContentSectionTitle">Contenu du caddie&nbsp;:</p>
					<div class="navPanelSectionContent">
						<div id="cartContentSectionContent">
							<p><em>Caddie en cours de chargement...</em></p>
						</div>
						<p id="cartContentSectionRefresh"><input type="submit" value="Recharger le caddie" class="button" id="cartContentSectionRefreshButton" /></p>
					</div>
				</div>
				<hr />
				<div class="navPanelSection">
					<p class="navPanelSectionTitle">Finaliser l'achat&nbsp;:</p>
					<div class="navPanelSectionContent">
						<p>Indiquer où devra être envoyé le lien de téléchargement après achat, puis cliquer sur &quot;finaliser l'achat&quot; pour être redirigé vers le récapitulatif de la commande avant achat.</p>
						<p>
							<input type="text" onfocus="if(this.value=='Votre email')this.value='';" onblur="if(this.value=='')this.value='Votre email';" value="Votre email" />
							<input type="submit" value="Finaliser l'achat" class="button" />
						</p>	
					</div>
				</div>
				<hr />
				<p><span class="nbItemInCart">0</span> article(s) dans le caddie</p>			
			</div>			
		</div>
		<div id="navBar">
			<div id="navRight">
				<p id="navButtons">
					<span id="navButtonDescription" class="navButton"><span class="navButtonBubble"></span><img src="<?php echo ROOT ?>style/images/navText.png" alt="Descr." width="31" height="35" /></span>
					<span id="navButtonCart" class="navButton"><span class="navButtonBubble"></span><span class="nbItemInCart notificationBadge" style="top: 5px; right: -5px;">0</span><img src="<?php echo ROOT ?>style/images/navCart.png" alt="caddie" width="35" height="35" /></span>
					<span id="navButtonSlideshow" class="navButton"><span class="navButtonBubble"></span><img src="<?php echo ROOT ?>style/images/navPlay.png" alt="Diapo." width="28" height="35" /></span>
					<!--<span id="navButtonFav" class="navButton"><span class="navButtonBubble"></span><img src="<?php echo ROOT ?>style/images/navFav.png" alt="Fav." width="37" height="35" /></span>-->
					<span id="navButtonParam" class="navButton"><span class="navButtonBubble"></span><img src="<?php echo ROOT ?>style/images/navParam.png" alt="Param." width="40" height="35" /></span>
				</p>
			</div> 
			<div id="navLeft">
				<p id="navParentLink"><span id="navParentLinkText"><?php echo $navParentLink ?></span></p> 
				<p id="navAlbTitle"><?php echo $current_album_title ?></p>
			</div>
		</div>
	</div>
	<div id="cuerpo">
		<h2><?php echo $current_album_title ?></h2>		
		<div id="gal">		
			<div id="gallery">
				<?php 
				if(empty($galPictImage) AND empty($galAlbImage)) // S'il y a des images et des album
					{ 
						echo '<p>Cet album est vide.</p>';;
					}
				else
					{
						if(!empty($galAlbImage))
							{
								foreach($galAlbImage as $album) 
									{
				?>
				<div class="galMin galAlb inlineBlock"><div> <!-- On enferme dans une div neutre pour éviter des pb avec firefox 1 et 2 -->
					<p class="galMinMenu">
						<a href="#" onclick="return switchInFav(<?php echo $album['id'] ?>,'alb')" class="add2fav" title="Ajouter l'album aux favoris<br /><em>Accès via le menu supérieur</em>"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictFav.png" alt="&hearts;" /></a>
						<a href="#" onclick="return switchInCart(<?php echo $album['id'] ?>,'alb')" class="add2cart" title="Ajouter l'album au caddie<br /><strong><?php echo $album['nb_photos'] ?> photos HD&nbsp;: <?php echo $album['price'] ?>€</strong><br /><em>Explications dans le caddie en bas à droite</em>"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictCartAlb.png" alt="€" /></a>
					</p>
					<div class="galMinDivImage galAlbDivImage">
						<p class="galMinPImage galAlbPImage">
							<a href="<?php echo $album['link'] ?>" title="&laquo;&nbsp;<?php echo $album['title'] ?>&nbsp;&raquo;">
								<img src="<?php echo ROOT.DIR_STYLE ?>images/album.png" alt="<?php echo $album['title'] ?>" width="100%" height="100%" class="galMinImage galAlbImage" />
							</a>
						</p>			
					</div>
					<p class="galMinTitle galAlbTitle">
						<?php echo $album['title'] ?>
					</p>
				</div></div>
				<?php
									}
							}
						if(!empty($galPictImage))
							{
								foreach($galPictImage as $picture) 
									{
				?>
				<div class="galMin galPict inlineBlock" id="pict<?php echo $picture['id'] ?>"><div> <!-- On enferme dans une div neutre pour éviter des pb avec firefox 1 et 2 -->
					<p class="galMinMenu">
						<a href="<?php echo ROOT.'download/photo/'.$picture['id'].'-'.$picture['web_title'].'.html' ?>" title="Télécharger l'image en HD<br /><em>Gratuit, avec marquages</em>"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictDownload.png" alt="DL" /></a> 
						<a href="#" onclick="return switchInFav(<?php echo $picture['id'] ?>,'pict')" class="add2fav" title="Ajouter la photos aux favoris<br /><em>Accès via le menu supérieur</em>"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictFav.png" alt="&hearts;" /></a> 
						<a href="#" onclick="return switchInCart(<?php echo $picture['id'] ?>,'HD')" class="add2cart" title="Ajouter la photo au caddie<br /><strong>Haute Définition&nbsp;: <?php echo $picture['HD'] ?>€</strong><br /><em>Explications dans le caddie en bas à droite</em>"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictCartHD.png" alt="€HD" /></a> 
						<a href="#" onclick="return switchInCart(<?php echo $picture['id'] ?>,'FD')" class="add2cart" title="Ajouter la photo au caddie<br /><strong>Full Définition&nbsp;: <?php echo $picture['FD'] ?>€</strong><br /><em>Explications dans le caddie en bas à droite</em>"><img src="<?php echo ROOT.DIR_STYLE ?>images/pictCartFD.png" alt="€FD" /></a>
					</p>
					<div class="galMinDivImage galPictDivImage">
						<p class="galMinPImage galPictPImage">
							<noscript>
								<a href="<?php echo $picture['sd'] ?>" rel="gallery" title="<?php echo $picture['title'] ?>">
									<img src="<?php echo $picture['min'] ?>" alt="<?php echo $picture['title'] ?>" width="<?php echo $picture['w'] ?>%" height="<?php echo $picture['h'] ?>%" class="galMinImage galPictImage" />
								</a>
							</noscript>
						</p>				
					</div>
					<p class="galMinTitle galPictTitle"> 
						<?php echo $picture['title'] ?>
					</p>
				</div></div> 
				<?php 
									}
							}
					}
				?>
			</div>
		</div>
	</div>
	<div id="footer">			
		<div id="footerContent">
			<h1><?php echo SITE_TITLE ?></h1>
			<p><?php echo SITE_FOOTER ?></p>
		</div>
	</div>
</div>
<noscript>
	<p id="noscript">Nous recommandons vivement d'activer javascript ! <a href="http://www.enable-javascript.com/fr/">Aide</a></p>
</noscript>
<script type="text/javascript">
galPictFolderMIN = '<?php echo ROOT.DIR_PHOTOS_MIN ?>';
galPictFolderSD = '<?php echo ROOT.DIR_PHOTOS_SD ?>';
galPictImage = <?php echo $json_galPictImage ?>;
</script>
<?php require 'js/js.php' ?>
</body>
</html>

<!-- 
Il te plaît mon code source ? Je sais pas si l'indentation est nickelle une fois le rendu effectué, mais en tout cas chez moi elle est assez clean...
Ca se voit peut être pas, mais c'était un long projet hein !
Le design te plaît ? Et les photos ? Elles sont sympas ? Autant tu as pas intérêt à dire des méchancetés du design, autant les photos, tu sais, tu peux y aller !
C'est pas moi qui les ai prises et à l'heure actuelle, je sais même pas à quoi elles vont ressembler...
Enfin bon, c'est pas tout ça, mais faut aller se coucher ! Allez, au dodo !
-->

<!-- Page générée le : <?php echo date('l jS \of F Y H:i:s') ?> -->
