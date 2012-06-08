<?php

class Chrono {

	private $timeStart;
	private $timeEnd;
	private $timeTotal = 0;

	public function __construct() 
		{
			$this->timeStart = microtime(TRUE);
		}

	public function start() 
		{
			$this->timeStart = microtime(TRUE);
		}
		
	public function restart() 
		{
			$this->timeTotal = 0;
			$this->timeStart = microtime(TRUE);
		}

	public function stop() 
		{
			$this->timeEnd = microtime(TRUE);
			$this->timeTotal = $this->timeTotal + $this->timeEnd-$this->timeStart;
		}

	public function getTime($Comment = NULL) 
		{
			$this->timeEnd = microtime(TRUE);
			
			if($Comment = 'html')
				{
					echo '<!-- Temps écoulé : '.$this->timeTotal.'s -->';
				}
			elseif($Comment = 'css')
				{
					echo '/* Temps écoulé : '.$this->timeTotal.'s */';
				}
			elseif($Comment = 'js')
				{
					echo '// Temps écoulé : '.$this->timeTotal.'s';
				}
			else
				{
					echo 'Temps écoulé : '.$this->timeTotal.'s';
				}
		}
}