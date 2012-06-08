<?php

class String {
	
	private $str = NULL;
	private $str_original = NULL;	
	
	public function __construct($string = NULL)
        {
			isset($string) ? $this->str = $string : $this->str = NULL;
			$this->str_original = $this->str;
        }
	
	public function getStr()
		{
			return $this->str;
		}
	
	public function setStr($string = NULL)
        {
			isset($string) ? $this->str = $string : $this->str = NULL;
        }

	public function setStrOriginal()
        {
			$this->str = $this->str_original;
        }
	
	public function unaccent($encoding = 'utf-8')
		{
			mb_regex_encoding($encoding); // jeu de caractères courant pour les expressions rationnelles. 
		 
			// Tableau des corespondance
			$str_ascii = array(
				'A'		=> 'ÀÁÂÃÄÅĀĂǍẠẢẤẦẨẪẬẮẰẲẴẶǺĄ',
				'a'		=> 'àáâãäåāăǎạảấầẩẫậắằẳẵặǻą',
				'C'		=> 'ÇĆĈĊČ',
				'c'		=> 'çćĉċč',
				'D'		=> 'ÐĎĐ',
				'd'		=> 'ďđ',
				'E'		=> 'ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ',
				'e'		=> 'èéêëēĕėęěẹẻẽếềểễệ',
				'G'		=> 'ĜĞĠĢ',
				'g'		=> 'ĝğġģ',
				'H'		=> 'ĤĦ',
				'h'		=> 'ĥħ',
				'I'		=> 'ÌÍÎÏĨĪĬĮİǏỈỊ',
				'J'		=> 'Ĵ',
				'j'		=> 'ĵ',
				'K'		=> 'Ķ',
				'k'		=> 'ķ',
				'L'		=> 'ĹĻĽĿŁ',
				'l'		=> 'ĺļľŀł',
				'N'		=> 'ÑŃŅŇ',
				'n'		=> 'ñńņňŉ',
				'O'		=> 'ÒÓÔÕÖØŌŎŐƠǑǾỌỎỐỒỔỖỘỚỜỞỠỢ',
				'o'		=> 'òóôõöøōŏőơǒǿọỏốồổỗộớờởỡợð',
				'R'		=> 'ŔŖŘ',
				'r'		=> 'ŕŗř',
				'S'		=> 'ŚŜŞŠ',
				's'		=> 'śŝşš',
				'T'		=> 'ŢŤŦ',
				't'		=> 'ţťŧ',
				'U'		=> 'ÙÚÛÜŨŪŬŮŰŲƯǓǕǗǙǛỤỦỨỪỬỮỰ',
				'u'		=> 'ùúûüũūŭůűųưǔǖǘǚǜụủứừửữự',
				'W'		=> 'ŴẀẂẄ',
				'w'		=> 'ŵẁẃẅ',
				'Y'		=> 'ÝŶŸỲỸỶỴ',
				'y'		=> 'ýÿŷỹỵỷỳ',
				'Z'		=> 'ŹŻŽ',
				'z'		=> 'źżž',
				// Ligatures
				'AE'	=> 'Æ',
				'ae'	=> 'æ',
				'OE'	=> 'Œ',
				'oe'	=> 'œ'
			);
			
			$str = html_entity_decode(htmlentities($this->str), ENT_COMPAT, 'UTF-8');
		 
			// Conversion
			foreach ($str_ascii as $k => $v) {
				$str = mb_ereg_replace('['.$v.']', $k, $str);
			}
			
			$this->str = trim($str);
		}
	
	public function getUnaccent($encoding = 'utf-8')
		{
			$this->unaccent($encoding);
			return $this->str;
		}
	
	public function webify()
		{
			$this->unaccent();
			$search = array ('@[ ,_-]@i','@[^a-zA-Z0-9-]@');
			$replace = array ('-','');
			$this->str = strtolower(preg_replace($search, $replace, $this->str));
		}
		
	public function getWebify()
		{
			$this->webify();
			return $this->str;
		}

	public function generate($length = 5, $type = 'Alphanum')
		{
			$caract_num = '0123456789';
			$caract_alpha = 'abcdefghijklmnopqrstuvwxyz';
			$caract_ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			 
			if($type == 'num') {
				$caract = $caract_num;
				$nb_caract = 9;
			}
			elseif($type == 'alpha') {
				$caract = $caract_alpha;
				$nb_caract = 25;
			}
			elseif($type == 'ALPHA') {
				$caract = $caract_ALPHA;
				$nb_caract = 25;
			}
			elseif($type == 'Alpha') {
				$caract = $caract_alpha.$caract_ALPHA;
				$nb_caract = 51;
			}
			elseif($type == 'alphanum') {
				$caract = $caract_alpha.$caract_num;
				$nb_caract = 35;
			}
			elseif($type == 'ALPHAnum') {
				$caract = $caract_ALPHA.$caract_num;
				$nb_caract = 35;
			}
			else {
				$caract = $caract_alpha.$caract_ALPHA.$caract_num;
				$nb_caract = 61;
			}
			
			$i = 0;
			$token = "";

			while($i < $length){
				$token.= $caract[rand(0,$nb_caract)];
				$i++;
			}
			
			$this->str = $token;
		}
		
	public function getGenerate($length = 5, $type = 'Alphanum')
		{
			$this->generate($length, $type);
			return $this->str;
		}
	
	public function getStrNtime($nb_of_occurence)
		{
			$str = NULL;
			for ($i = 1; $i <= $nb_of_occurence; $i++) {
				$str = $str.$this->str;
			}
			return $str;
		}
		
	public function priceInCents()
		{
			$price = trim($this->str);
			
			if(!isset($price)) $this->str = NULL; // s'il n'y a pas de prix, ça va pas
			
			$priceFormatPattern = '/^(\d+)(?:[,|.](\d{2}))?$/';
			preg_match($priceFormatPattern, $price, $matches);
			
			if(!isset($matches[1])) $this->str = NULL; // s'il n'y a pas de partie entière, ça va pas
			else {
				$euro = $matches[1];
				$centimes = (isset($matches[2])) ? $matches[2] : 0;
				
				$price = 100 * $euro + $centimes;
				
				if(is_numeric($price)) $this->str = $price;
				else $this->str = NULL;
			}
		}
	
	public function getPriceInCents()
		{
			$this->priceInCents();
			return $this->str;
		}		
			
}