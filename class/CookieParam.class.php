<?php

class CookieParam {

	private $cookie = NULL;
	private $cookieContent = NULL;

	public function __construct($cookie) 
		{
			$this->cookie = $cookie;
			$this->cookieContent = $_COOKIE[$this->cookie];
		}
	
	public function getVal($name) // name de l'élément : pict ou alb... ; type de l'élément : A pour "array", V pour "value"
		{
			if(!isset($this->cookieContent)) return NULL;
			
			$reg = "<".$name.":(A|V):([-a-zA-Z0-9]+)?>";
			if(preg_match($reg,$this->cookieContent,$match)) // Si le cookie correspond à la structure recherchée
			{
				$type = $match[1];
				
				if($match[2]) $val = $match[2];
				else return NULL;
				
				if($type == 'A') return explode('-',$val);
				else if($type == 'V') return $val;
				else return NULL;
			}
			else return NULL;			
		}
}