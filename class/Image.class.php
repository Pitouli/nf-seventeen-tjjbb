<?php

class Image {
    
    private $file;
    private $original_sample_width;
    private $original_sample_height;
    private $original_image_width;
    private $original_image_height;
    private $new_image_width;
    private $new_image_height;
    private $ext;
    private $types = array('','gif','jpeg','png','swf');
    private $quality = 80;
    private $top = 0;
    private $left = 0;
    private $crop = false;
    private $type;
	private $add_images = array();
    
    public function Image($name='') {
        $this->file = $name;
        $info = getimagesize($name);
        $this->original_sample_width = $info[0];
        $this->original_sample_height = $info[1];
        $this->original_image_width = $info[0];
        $this->original_image_height = $info[1];
        $this->type = $this->types[$info[2]];
        $info = pathinfo($name);
        $this->dir = $info['dirname'];
        $this->name = str_replace('.'.$info['extension'], '', $info['basename']);
        $this->ext = $info['extension'];
    }
	
	///////////////////////////////////////////////////
	//            MODIFICATIONS SIMPLES             //
	/////////////////////////////////////////////////
    
	// Dossier pour sauvegarder la nouvelle image
    public function dir($dir='') {
        if(!$dir) return $this->dir;
        $this->dir = $dir;
    }
    
	// Nom de la nouvelle image
    public function name($name='') {
        if(!$name) return $this->name;
        $this->name = $name;
    }
    
	// Largeur de la nouvelle image
    public function width($width='') {
        if(is_numeric($width)) $this->new_image_width = $width;
    }
    
	// Hauteur de la nouvelle image
    public function height($height='') {
        if(is_numeric($height)) $this->new_image_height = $height;
    }
	
	// Plus grand côté de la nouvelle image
	public function biggest_side($side_size='') {
		if($this->original_image_width >= $this->original_image_height) { 
			$this->width($side_size);
		}
		else { 
			$this->height($side_size);
		}
	}
	
	// Point de prélévement (coordonnées depuis le coin haut gauche)
    public function sample_point($left='',$top='') {
        if(is_numeric($left)) $this->left = $left;
		if(is_numeric($top)) $this->top = $top;
    }
	
	// Largeur du prélévement de l'image d'origine
	public function sample_width($width=1) {
        $this->original_sample_width = $width;
    }
	
	// Hauteur du prélévement de l'image d'origine
	public function sample_height($height=1) {
        $this->original_sample_height = $height;
    }
	
	// Qualité de la nouvelle image (si jpg)
    public function quality($quality=80) {
        $this->quality = $quality;
    }    

	///////////////////////////////////////////////////
	//     FONCTIONS DE MODIFICATIONS AVANCEES      //
	/////////////////////////////////////////////////

	// Faire une vignette carrée d'une largeur donnée à partir de l'image
	public function square_thumb($width='200') {
		if($this->original_image_width > $this->original_image_height) { 
			$this->top = 0;
			$this->left = floor(($this->original_image_width - $this->original_image_height)/2);
			$this->original_sample_width = $this->original_image_height;
			$this->original_sample_height = $this->original_image_height;
		}
		elseif($this->original_image_width < $this->original_image_height) { 
			$this->top = floor(($this->original_image_height - $this->original_image_width)/2);
			$this->left = 0;
			$this->original_sample_height = $this->original_image_width;
			$this->original_sample_width = $this->original_image_width;
		}
		$this->new_image_width = $width;
		$this->new_image_height = $width;
    }
	
	// Incruster une image dans l'image finale
	// src : source de l'image à incruster ;
	// position : Position générake de l'ajout (topleft, topright, bottomleft, bottomright ou middle)
	// hor : distance "horizontale" entre l'ajout et le bord vertical (left ou right) de l'image
	// ver : distance "verticale" entre l'ajout et le bord horizontal (top ou bottom) de l'image 
	// alpha : coefficient de transparence, de 0 (transparent) à 100 (opaque). NB : la transparence du png ne sera préservée que si alpha=100 
	public function add_image($src, $pos='topleft', $hor=0, $ver=0, $alpha=100, $width=NULL, $height=NULL, $type='') {
		if(file_exists($src)) {
			if(!is_numeric($hor)) $hor=0;
			if(!is_numeric($ver)) $ver=0;
			if(!is_integer($alpha) || $alpha<0 || $alpha>100) $alpha=100;
			
			// Si la largeur et/ou la hauteur n'a pas été définie manuellement
			if(empty($width) || !is_numeric($width)) {
				$info = getimagesize($src);
				$width = $info[0];
				// On regarde si la hauteur a été définie manuellement
				if(empty($height) || !is_numeric($height)) $height = $info[1];
				// On check si l'extension a déjà été définie manuellement
				if(!in_array($type, array('png', 'jpeg', 'gif'))) $type = $this->types[$info[2]];
			}
			elseif(empty($height) || !is_numeric($height)) {
				$info = getimagesize($src);
				$height = $info[1];
				// On check si l'extension a déjà été définie manuellement
				if(!in_array($ext, array('png', 'jpeg', 'gif'))) $type = $this->types[$info[2]];
			}
			
			$this->add_images[] = array('src' => $src, 'type' => $type, 'width' => $width, 'height' => $height, 'pos' => $pos, 'hor' => $hor, 'ver' => $ver, 'alpha' => $alpha);
		}
	}

	///////////////////////////////////////////////////
	//         SAUVEGARDE DES MODIFICATIONS         //
	/////////////////////////////////////////////////

	// Afficher l'image sans l'enregistrer
    public function show() {
        $this->save(true);
    }
    
	// Sauver l'image
    public function save($show=false) {
	
		///////////////////////////////////////////////////
		//       CALCUL DE LA TAILLE DE NEW_IMAGE       //
		/////////////////////////////////////////////////		
		
		// Si on a spécifié ni nouvelle largeur, ni nouvelle hauteur
        if(!is_numeric($this->new_image_width) && !is_numeric($this->new_image_height)) {
			// On réattribue les dimension du prélévement
            $this->new_image_width = $this->original_sample_width;
            $this->new_image_height = $this->original_sample_height;
		// Si on a donné une nouvelle largeur mais pas une nouvelle hauteur
        } elseif (is_numeric($this->new_image_width) && !is_numeric($this->new_image_height)) {
			// On attribue comme nouvelle hauteur le ratio du prélévement
            $this->new_image_height = round($this->new_image_width/($this->original_sample_width/$this->original_sample_height));
		// Si on a pas donné une nouvelle largeur mais une nouvelle hauteur
        } elseif (!is_numeric($this->new_image_width) && is_numeric($this->new_image_height)) {
            // On attribue comme nouvelle largeur le ratio du prélévement
			$this->new_image_width = round($this->new_image_height/($this->original_sample_height/$this->original_sample_width));
		// Sinon, c'est qu'on a spécifié explicitement la largeur et hauteur de la nouvelle image
		}

		///////////////////////////////////////////////////
		//            CREATION DE L'IMAGE               //
		/////////////////////////////////////////////////				

        if($this->type=='jpeg') $image = imagecreatefromjpeg($this->file);
        elseif($this->type=='png') $image = imagecreatefrompng($this->file);
        elseif($this->type=='gif') $image = imagecreatefromgif($this->file);
        
        $new_image = imagecreatetruecolor($this->new_image_width, $this->new_image_height);
        imagecopyresampled($new_image, $image, 0, 0, $this->left, $this->top, $this->new_image_width, $this->new_image_height, $this->original_sample_width, $this->original_sample_height);
		
		///////////////////////////////////////////////////
		//          INCRUSTATION DES IMAGES             //
		/////////////////////////////////////////////////	
		
		// Si il y a des images à ajouter
		if(!empty($this->add_images)) {
			foreach ($this->add_images as $add_image_info) {
				//$this->$add_images[] = array('src' => $src, 'pos' => $pos, 'hor' => $hor, 'ver' => $ver, 'alpha' => $alpha);
				
				if($add_image_info['type']=='jpeg') $add_image = imagecreatefromjpeg($add_image_info['src']);
				elseif($add_image_info['type']=='png') $add_image = imagecreatefrompng($add_image_info['src']);
				elseif($add_image_info['type']=='gif') $add_image = imagecreatefromgif($add_image_info['src']);
				
				if($add_image_info['pos'] == 'topright') {
					$new_image_x = $this->new_image_width - ($add_image_info['width'] + $add_image_info['hor']);
					$new_image_y = $add_image_info['ver'];
				}
				elseif($add_image_info['pos'] == 'bottomleft') {
					$new_image_x = $add_image_info['hor'];
					$new_image_y = $this->new_image_height - ($add_image_info['height'] + $add_image_info['ver']);
				}
				elseif($add_image_info['pos'] == 'bottomright') {
					$new_image_x = $this->new_image_width - ($add_image_info['width'] + $add_image_info['hor']);
					$new_image_y = $this->new_image_height - ($add_image_info['height'] + $add_image_info['ver']);
				}
				elseif($add_image_info['pos'] == 'middle') {
					$new_image_x = floor(($this->new_image_width - $add_image_info['width']) / 2) + $add_image_info['hor'];
					$new_image_y = floor(($this->new_image_height - $add_image_info['height']) / 2) + $add_image_info['ver'];
				}
				else {
					$new_image_x = $add_image_info['hor'];
					$new_image_y = $add_image_info['ver'];
				}
				
				if($add_image_info['alpha'] == 100) {
					imagecopy($new_image, $add_image, $new_image_x, $new_image_y, 0, 0, $add_image_info['width'], $add_image_info['height']);
				}
				else {
					imagecopymerge($new_image, $add_image, $new_image_x, $new_image_y, 0, 0, $add_image_info['width'], $add_image_info['height'], $add_image_info['alpha']);
				}
			}
		}

		///////////////////////////////////////////////////
		//          ENREGISTREMENT/AFFICHAGE            //
		/////////////////////////////////////////////////	
 
        if($show) @header('Content-Type: image/'.$this->type); 
        
        $name = $show ? null: $this->dir.DIRECTORY_SEPARATOR.$this->name.'.'.$this->ext;
        if($this->type=='jpeg') imagejpeg($new_image, $name, $this->quality);
        elseif($this->type=='png') imagepng($new_image, $name);
        elseif($this->type=='gif') imagegif($new_image, $name);
        
        imagedestroy($image); 
        imagedestroy($new_image);
        
    }	
	
}