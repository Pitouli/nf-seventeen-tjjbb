<?php
setcookie("javascriptOn", 0, 60*60, ROOT); // On cree un cookie qui dit que le javascript est désactivé. Si ce n'est pas le cas, javascript écrasera le cookie;

$bdd = new BDD; // On crée directement un objet PDO
	
$current_album_title = 'Favoris';
$currentAlbumLink = SITE_DOMAIN.ROOT.'gallery/selection.html'; // Si c'est l'album racine
$current_album_description = "Cet album se rempli avec les photos et albums marqués comme favori. Survoler la miniature d'un album ou d'une photo pour faire apparaître l'icône d'ajout aux favoris.<noscript><br /><strong>Il faut activer javascript pour bénéficier de cet album</strong></noscript>";
$page_description = "Album des favoris regroupant les photos et albums que l'utilisateur a préféré et souhaité rendre facilement accessible lors d'une visite ultérieure.";

$galSel = new CookieParam('galSel');
$photos = $galSel->getVal('pict');
$albums = $galSel->getVal('alb');
	
// Photos de l'album
if(isset($photos)) {
	$recup_photos = $bdd->prepare("SELECT pict.id, pict.folder, pict.webname, pict.extension, pict.title, pict.web_title, pict.width, pict.height, IFNULL(pr.HD,0) as HD, IFNULL(pr.FD,0) as FD 
									FROM photos pict LEFT JOIN prices pr ON pict.id_price = pr.id 
									WHERE pict.id=:id AND pict.status='visible'
									LIMIT 1");
	foreach($photos as $id_photo) {
		if(is_numeric($id_photo)) {
			$recup_photos->execute(array(':id'=>$id_photo));
			$list_photos[] = $recup_photos->fetch();
		}
	}
}
else $list_photos = array();

// Sous-Albums de l'album
if(isset($albums)) {
	$recup_subalbums = $bdd->prepare("SELECT alb.id, alb.title, alb.web_title, alb.description, IFNULL(COUNT(pict.id),0) as nb_photos, IFNULL(SUM(pr.inAlbum),0) as price
										FROM albums alb 
										LEFT JOIN photos pict ON alb.id = pict.id_album 
										LEFT JOIN prices pr ON pict.id_price = pr.id
										WHERE alb.id=:id AND alb.hide=0 
										GROUP BY (alb.id)
										LIMIT 1");
	foreach($albums as $id_album) {
		if(is_numeric($id_album)) {
			$recup_subalbums->execute(array(':id'=>$id_album));
			$list_subalbums[] = $recup_subalbums->fetch();
		}
	}
}
else $list_subalbums = array();

// On crée le fil d'Ariane
$recup_album_parent = $bdd->query("SELECT title FROM albums WHERE id=1 LIMIT 1");
$infos_album_parent = $recup_album_parent->fetch();
$navParentLink='<a href="'.ROOT.'gallery.html">'.$infos_album_parent['title'].'</a> >';

// On liste les sous albums
if(!empty($list_subalbums)) {
	foreach($list_subalbums as $subalbum) {
		$galAlbImage[] = array("id"=>$subalbum['id'], "title"=>$subalbum['title'], "web_title"=>$subalbum['web_title'], "link"=>ROOT.'gallery/'.$subalbum['id'].'-'.$subalbum['web_title'].'.html', "nb_photos"=>$subalbum['nb_photos'], "price"=>number_format($subalbum['price']/100,2,'.',''));
	}
}

// On liste les images
foreach($list_photos as $photo) {
	$url_image_min = ROOT.DIR_PHOTOS_MIN.$photo['folder'].$photo['webname'].$photo['extension'];
	$url_image_sd = ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension'];
	
	if(PICT_MIN_FORMAT == 'ratio')
	{		
		if($photo['width'] > $photo['height']) {
			$width = 100;
			$height = round($photo['height']/$photo['width'] * 100, 1);
		}
		else {
			$height = 100;
			$width = round($photo['width']/$photo['height'] * 100, 1);
		}
	}
	else
	{
		$width = 100;
		$height = 100;
	}

	$json_galPictImage[] = array("photo"=>$photo['folder'].$photo['webname'].$photo['extension'], "title"=>$photo['title'], "w"=>$width, "h"=>$height); 
	$galPictImage[] = array("id"=>$photo['id'], "min"=>$url_image_min, "sd"=>$url_image_sd, "title"=>$photo['title'], "web_title"=>$photo['web_title'], "w"=>$width, "h"=>$height, "HD"=>number_format($photo['HD']/100,2,'.',''), "FD"=>number_format($photo['FD']/100,2,'.',''));
}

// On met toutes les infos concernant les images dans une variable qui sera par la suite interprétée par javascript
$json_galPictImage = (isset($json_galPictImage)) ? json_encode($json_galPictImage) : NULL;

// On crée la variable qui ne contient pas les pièces jointes :
$nb_attchmts = 0;
$list_attchmts = array();