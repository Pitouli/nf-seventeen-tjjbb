<?php
setcookie("javascriptOn", 0, 60*60, ROOT); // On cree un cookie qui dit que le javascript est désactivé. Si ce n'est pas le cas, javascript écrasera le cookie;

$bdd = new BDD; // On crée directement un objet PDO

$recup_album = $bdd->prepare("SELECT * FROM albums WHERE id=:id LIMIT 1");
$recup_album->execute(array(':id'=>$currentAlbum));
$infosAlbum = $recup_album->fetch();

// Si l'album n'existe pas ou est caché
if(empty($infosAlbum))
{
	$getSection = 'error';
	$getSSection = 404;
	require DIR_CONTROLLER.'default.controller.php';
	exit();
}
// Si l'album est masqué
elseif($infosAlbum['hide'])
{
	$getSection = 'error';
	$getSSection = 404;
	require DIR_CONTROLLER.'default.controller.php';
	exit();
}
// Sinon
else {
	
	$current_album_title = $infosAlbum['title'];
	
	if($infosAlbum['id'] == 1) $currentAlbumLink = SITE_DOMAIN.ROOT.'gallery.html'; // Si c'est l'album racine
	else $currentAlbumLink = SITE_DOMAIN.ROOT.'gallery/'.$infosAlbum['id'].'-'.$infosAlbum['web_title'].'.html'; // sinon
	
	if(isset($infosAlbum['description']) && !empty($infosAlbum['description'])) {
		$current_album_description = nl2br($infosAlbum['description']);
		$page_description = htmlspecialchars($infosAlbum['description']);
	}
	else {
		$current_album_description = 'Album &laquo;&nbsp;'.$infosAlbum['title'].'&nbsp;&raquo;';
		$page_description = 'Album &laquo;&nbsp;'.$infosAlbum['title'].'&nbsp;&raquo; de la galerie '.SITE_TITLE;		
	}
	
	// Photos de l'album
	$recup_photos = $bdd->prepare("SELECT pict.id, pict.folder, pict.webname, pict.extension, pict.title, pict.web_title, pict.width, pict.height, IFNULL(pr.HD,0) as HD, IFNULL(pr.FD,0) as FD 
									FROM photos pict LEFT JOIN prices pr ON pict.id_price = pr.id 
									WHERE pict.id_album=:id_album AND pict.status='visible' 
									ORDER BY pict.title");
	$recup_photos->execute(array(':id_album'=>$currentAlbum));
	$list_photos = $recup_photos->fetchAll();
	
	// Sous-Albums de l'album
	$recup_subalbums = $bdd->prepare("SELECT alb.id, alb.title, alb.web_title, alb.description, IFNULL(COUNT(pict.id),0) as nb_photos, IFNULL(SUM(pr.inAlbum),0) as price
										FROM albums alb 
										LEFT JOIN photos pict ON alb.id = pict.id_album 
										LEFT JOIN prices pr ON pict.id_price = pr.id
										WHERE alb.id_parent=:id_parent AND alb.hide=0 
										GROUP BY (alb.id)
										ORDER BY alb.title");
	$recup_subalbums->execute(array(':id_parent'=>$currentAlbum));
	$list_subalbums = $recup_subalbums->fetchAll();
	
	// Pièces-jointes de l'album
	$recup_attchmts = $bdd->prepare("SELECT * FROM attachments WHERE id_album=:id_album AND status='visible'");
	$recup_attchmts->execute(array(':id_album'=>$currentAlbum));
	$list_attchmts = $recup_attchmts->fetchAll();
	$nb_attchmts = count($list_attchmts);
	
	// On crée le fil d'Ariane
	$id_parent=$infosAlbum['id_parent'];
	$navParentLink = '&nbsp;';
	$recup_album_parent = $bdd->prepare("SELECT id_parent, web_title, title FROM albums WHERE id=:id LIMIT 1");
	while($id_parent!=0) {
		$recup_album_parent->execute(array(':id' => $id_parent));
		$infos_album_parent = $recup_album_parent->fetch();
		$navParentLink='<a href="'.ROOT.'gallery/'.$id_parent.'-'.$infos_album_parent['web_title'].'.html">'.$infos_album_parent['title'].'</a> > '.$navParentLink;
		$id_parent=$infos_album_parent['id_parent'];
	}
	
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

}