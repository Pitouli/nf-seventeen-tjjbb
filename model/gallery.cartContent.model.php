<?php

$galCart = new CookieParam('galCart');
$cartHD = $galCart->getVal('HD');
$cartFD = $galCart->getVal('FD');
$cartAlb = $galCart->getVal('alb');
	
// Photos
if(isset($cartHD) || isset($cartFD)) {
	$recup_photos = $bdd->prepare("SELECT pict.id, pict.folder, pict.webname, pict.extension, pict.title, pict.web_title, IFNULL(pr.HD,0) as HD, IFNULL(pr.FD,0) as FD 
									FROM photos pict LEFT JOIN prices pr ON pict.id_price = pr.id 
									WHERE pict.id=:id AND pict.status='visible'
									LIMIT 1");
	
	if(isset($cartHD)) {
		foreach($cartHD as $id_photo) {
			if(is_numeric($id_photo)) {
				$recup_photos->execute(array(':id'=>$id_photo));
				$list_photos_HD[] = $recup_photos->fetch();
			}
		}
	}
	else $list_photos_HD = array();
	
	if(isset($cartFD)) {
		foreach($cartFD as $id_photo) {
			if(is_numeric($id_photo)) {
				$recup_photos->execute(array(':id'=>$id_photo));
				$list_photos_FD[] = $recup_photos->fetch();
			}
		}
	}
	else $list_photos_FD = array();
}
else {
	$list_photos_HD = array();
	$list_photos_FD = array();
}

// Albums
if(isset($cartAlb)) {
	$recup_albums = $bdd->prepare("SELECT alb.id, alb.title, alb.web_title, IFNULL(SUM(pr.inAlbum),0) as sumPrices
										FROM albums alb 
										LEFT JOIN photos pict ON alb.id = pict.id_album 
										LEFT JOIN prices pr ON pict.id_price = pr.id
										WHERE alb.id=:id AND alb.hide=0 
										GROUP BY (alb.id)
										LIMIT 1");
	foreach($cartAlb as $id_album) {
		if(is_numeric($id_album)) {
			$recup_albums->execute(array(':id'=>$id_album));
			$list_albums[] = $recup_albums->fetch();
		}
	}
}
else $list_albums = array();

// On liste les achats
foreach($list_photos_HD as $key => $photo) {
	$list_photos_HD[$key]['url_sd'] = ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension'];	
	$list_photos_HD[$key]['url_min'] = ROOT.DIR_PHOTOS_MIN.$photo['folder'].$photo['webname'].$photo['extension'];
	$list_photos_HD[$key]['price'] = number_format($photo['HD']/100,2,'.','');
}

foreach($list_photos_FD as $key => $photo) {
	$list_photos_FD[$key]['url_sd'] = ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension'];
	$list_photos_FD[$key]['url_min'] = ROOT.DIR_PHOTOS_MIN.$photo['folder'].$photo['webname'].$photo['extension'];
	$list_photos_FD[$key]['price'] = number_format($photo['FD']/100,2,'.','');
}

foreach($list_albums as $key => $album) {
	$list_albums[$key]['link'] = ROOT.'gallery/'.$album['id'].'-'.$album['web_title'].'.html';
	$list_albums[$key]['price'] = number_format($album['sumPrices']/100,2,'.','');
}

// On calcule le prix du panier

$cartSumPrices = 0;
foreach($list_photos_HD as $photo) $cartSumPrices += $photo['HD'];
foreach($list_photos_FD as $photo) $cartSumPrices += $photo['FD'];
foreach($list_albums as $album) $cartSumPrices += $album['sumPrices'];
$cartPrice = number_format($cartSumPrices/100,2,'.','');