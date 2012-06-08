<?php

class GetParam {

	private $varParam = NULL;

	public function __construct($varGetParam) 
		{
			$this->varParam = $varGetParam;
		}
	
	public function getValue($pattern,$type=NULL)
		{			
			if($this->varParam != NULL)
				{
					$regexp = "#".$pattern."([^,]+)#";
					preg_match($regexp, $this->varParam, $param);
					$result = $param[1];

					// Si le résultat doit être un nombre					
					if($type == 'numeric') {
						if(is_numeric($result)) { return $result; }	
						else { return NULL; }
					}
					elseif($type == 'integer') {
						if(ctype_digit($result)) { return $result; }	
						else { return NULL; }
					}
					else {
						return $result;
					}	
				}
			else
				{
					return NULL;
				}
		}
}