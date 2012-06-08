<?php
$bdd = new BDD; // On crée directement un objet PDO

if($getSection == 'error') include DIR_MODEL.'error.model.php';
else include DIR_MODEL.'default.model.php';

include DIR_VIEW.'default.view.php';