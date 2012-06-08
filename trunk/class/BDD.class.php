<?php

class BDD extends PDO {

	/* Constructeur : héritage public obligatoire par héritage de PDO */
	public function __construct($power = 'public') {
		if($power == 'admin') parent::__construct(SQL_DSN, SQL_USERNAME_ADMIN, SQL_PASSWORD_ADMIN);
		else parent::__construct(SQL_DSN, SQL_USERNAME_PUBLIC, SQL_PASSWORD_PUBLIC);
	}
	
	public function getNbRow($table, $condition) {
		$sql = 'SELECT COUNT(*) AS nb FROM '.$table.' WHERE '.$condition;
		$result = $this->query($sql);
		$columns = $result->fetch();
		$nb = $columns['nb'];
		return $nb;
	}
	
	// Retourne le premier id issu de la table $table respectant la condition $condition
	// exemple : $id_album = $bdd->getId('albums', 'id_parent="'.$id_parent.'" AND web_title="'.$web_title.'"');
	public function getId($table, $condition) {
		$sql = 'SELECT id FROM '.$table.' WHERE '.$condition.' LIMIT 1';
		$result = $this->query($sql);
		$columns = $result->fetch();
    	$id = $columns['id'];
		return $id;
	}
}