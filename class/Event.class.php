<?php

class Event extends BDD {

	private $author = NULL;
	private $type = NULL;
	private $description = NULL;
	private $success = 1;
	private $datetime;
	private $saveEvent;

	/* Constructeur : héritage public obligatoire par héritage de BDD */
	public function __construct() {
		parent::__construct();
		$sql = 'INSERT INTO logbook SET author=:author, type=:type, description=:description, success=:success, datetime=:datetime';
		$this->saveEvent = parent::prepare($sql);
		$this->datetime = date('y-m-d H:i:s');
	}
	
	public function setAuthor($author) {
		$this->author = $author;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function setDescription($description) {
		$this->description = $description;
	}
	
	public function setSuccess($success=1) {
		if($success==1) {
			$this->success = 1;
		}
		else {
			$this->success = 0;
		}
	}
	
	public function setDatetime($datetime=NULL) {
		if(!$datetime) {
			$this->datetime = date('y-m-d H:i:s');
		}
		else {
			$this->datetime = $datetime;
		}
	}
	
	public function save() {
		$this->saveEvent->execute(array(':author'=>$this->author, ':type'=>$this->type, ':description'=>$this->description, ':success'=>$this->success, ':datetime'=>$this->datetime));
	}

}