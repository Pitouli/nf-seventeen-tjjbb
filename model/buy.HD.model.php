<?php

$id_photo = (is_numeric($getSSection)) ? $getSSection : NULL; 

if(isset($id_photo))
{
	$pageTitle = BROWSER_SITE_TITLE.' - Téléchargement';
	$title = 'Téléchargement d\'une photo';

	// On récupère la photo
	$getPhoto = $bdd->prepare("SELECT * FROM photos WHERE id=:id_photo LIMIT 1");
	$getPhoto->execute(array(':id_photo' => $id_photo));
	$photo = $getPhoto->fetch();
	
	if((isset($_SESSION['usr_status']) && $_SESSION['usr_status'] == 'admin') || $photo['status'] == 'visible') // Si on a le droit d'acheter la photo
	{	
		$urlBg = ROOT.DIR_PHOTOS_SD.$photo['folder'].$photo['webname'].$photo['extension'];
		
		// On fait le lien vers l'album
		$recupAlbum = $bdd->query("SELECT title, web_title FROM albums WHERE id=".$photo['id_album']." LIMIT 1");
		$album = $recupAlbum->fetch();
	
		$linkAlbum = ROOT."gallery/".$photo['id_album']."-".$album['web_title'].".html";
		$textLink = 'Retour à l\'album';
		
		// On se prépare à gérer le captcha
		require DIR_FCT.'recaptcha.fct.php';	
			
		if(isset($_POST['formPosted']))
		{
			// On vérifie que le captcha est bon
			
			$captcha = recaptcha_check_answer (RECAPTCHA_PRIVATE_KEY,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
	
			if (!$captcha->is_valid) // Captha invalide
			{
				$description = 'Il y a eu une erreur lors de la recopie des deux mots. Il est possible de réessayer&nbsp;:</p>';
				$description .= '<script type="text/javascript"> var RecaptchaOptions = { lang : \'fr\', theme : \'blackglass\'}; </script>';
				$description .= '<form method="post">';
				$description .= recaptcha_get_html(RECAPTCHA_PUBLIC_KEY);
				$description .= '<p style="text-align: center"><input type="hidden" name="formPosted" value="1" /><input type="submit" value="Valider le formulaire anti-robot" /></p></form>';
				$description .= '<p style="text-align: center"><a href="'.$linkAlbum.'" title="&laquo;&nbsp;'.$album['title'].'&nbsp;&raquo;" >Retour à l\'album</a>';
			} 
			else // Captcha valide
			{
				$photoFileHD = DIR_PHOTOS_HD.$photo['folder'].$photo['webname'].$photo['hd_token'].$photo['extension'];
				$photoFileHDwatermarked = DIR_CACHE_PHOTOS_HD.$photo['webname'].$photo['extension'];
					
				if(file_exists($photoFileHDwatermarked)) // Si la photo a déjà été watermarkée (en cache)
				{							
					// On lance le téléchargement
					
					header('Content-type: application/force-download');
					header('Content-Length: '.$photo['size']);
					header('Content-Disposition: attachment; filename="'.$photo['web_title'].$photo['extension'].'"');
					header('Content-Transfer-Encoding: binary');
					readfile($photoFileHDwatermarked);
					//header('Location: '.ROOT.DIR_ATTACHMENTS.$attchmt['webname']);
					exit();
				}
				else 
				{
					if(file_exists($photoFileHD)) // Si la photo est bien trouvée sur le serveur
					{							
						// On watermark la photo
						
						$hd_pict = new Image($photoFileHD); 
						$hd_pict->name($photo['webname']);
						$hd_pict->dir(DIR_CACHE_PHOTOS_HD);
						$hd_pict->quality(PICT_HD_WATERMARKED_QUALITY);
						$hd_pict->add_image(WATERMARK_HD, 'topleft', 20, 20); // source, position (default : topleft), marge verticale (default : 0), marge horizontale (default : 0), opacité (0 transparent à 100 ; default : 100), largeur image a rajouter (default : calcul auto), hauteur image a rajouter (default : calcul auto), type (default : détermination auto)
						$hd_pict->add_image(WATERMARK_HD_LOGO, 'bottomright', 20, 20); // source, position (default : topleft), marge verticale (default : 0), marge horizontale (default : 0), opacité (0 transparent à 100 ; default : 100), largeur image a rajouter (default : calcul auto), hauteur image a rajouter (default : calcul auto), type (default : détermination auto)						
						$hd_pict->save();
						
						// On lance le téléchargement
						
						header('Content-type: application/force-download');
						header('Content-Length: '.filesize($photoFileHDwatermarked));
						header('Content-Disposition: attachment; filename="'.$photo['web_title'].$photo['extension'].'"');
						header('Content-Transfer-Encoding: binary');
						readfile($photoFileHDwatermarked);
						//header('Location: '.ROOT.DIR_ATTACHMENTS.$attchmt['webname']);
						exit();
					}
					else 
					{
						$getSection = 'error';
						$getSSection = 404;
						
						require DIR_CONTROLLER.'default.controller.php';
						
						exit();
				}
				}
			}
		}
		else
		{
			$description = '</p>';
			$description .= '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="paypal">
								<input type="hidden" value="15.00" name="amount" />
								<input name="currency_code" type="hidden" value="EUR" />
								<input name="shipping" type="hidden" value="0.00" />
								<input name="tax" type="hidden" value="0.00" />
								<input name="return" type="hidden" value="'.SITE_DOMAIN.ROOT.'buy/paymentSuccess.html" />
								<input name="cancel_return" type="hidden" value="'.SITE_DOMAIN.ROOT.'buy/paymentFail.html" />
								<input name="notify_url" type="hidden" value="'.SITE_DOMAIN.ROOT.'buy/paymentIPN.html" />
								<input name="cmd" type="hidden" value="_cart" />
								<input type="hidden" name="add" value="1">
								<input name="business" type="hidden" value="pitoul_1329239883_biz@gmail.com" />
								<input name="item_name" type="hidden" value="Photo HD : '.$photo['web_title'].'" />
								<input name="item_number" type="hidden" value="HD-128" />
								<input type="hidden" name="undefined_quantity" value="1" />
								<input name="no_note" type="hidden" value="1" />
								<input name="lc" type="hidden" value="FR" />
								<input type="image" src="http://www.paypalobjects.com/fr_FR/FR/i/btn/x-click-but22.gif" border="0" name="submit" width="87" height="23" alt="Effectuez vos paiements via PayPal : une solution rapide, gratuite et sécurisée">							</form>';						
			$description .= '<p style="text-align: center"><a href="'.$linkAlbum.'" title="&laquo;&nbsp;'.$album['title'].'&nbsp;&raquo;" >Retour à l\'album</a>';
		}
	}
	else
	{
		$getSection = 'error';
		$getSSection = 404;
		
		require DIR_CONTROLLER.'default.controller.php';
		
		exit();		
	}
}
else
{
	$getSection = 'error';
	$getSSection = 404;
	
	require DIR_CONTROLLER.'default.controller.php';
	
	exit();
}