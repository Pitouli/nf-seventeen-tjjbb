<?php

//require 'WebcronOfficialAPI.class.php'; 

class WebcronAPI extends WebcronOfficialAPI {

	private $user = WEBCRON_USERNAME;
	private $pass = WEBCRON_PASSWORD;

	/* Constructeur : héritage public obligatoire par héritage de PDO */
	public function __construct( ) {
		parent::__construct($this->user, $this->pass);
	}
	
	public function getCredits() {
		$xml = $this->call('info');
		if($xml != NULL) {
			$data = new SimpleXMLElement($xml);
			$credits = $data->user[0]->attributes()->credits;
		}
		else $credits = 0;
		return $credits;	
	}
	
	public function getCronActivity($cronName) {
		$xml = $this->call('cron.get',array('name'=>$cronName));
		if($xml != NULL) {
			$data = new SimpleXMLElement($xml);
			$cronActivity = $data->cron[0]->attributes()->status;
		}
		else $cronActivity = 0;
		return $cronActivity;	
	}
	
	public function setCronActivity($cronName, $value) {
		$xml = $this->call('cron.edit',array('name'=>$cronName,'status'=>$value));
		if($xml != NULL) {
			$data = new SimpleXMLElement($xml);
			$status = $data->attributes()->status;
		}
		else $status = 'error';
		return $status;	
	}	
}