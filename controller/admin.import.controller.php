<?php

if($getSSection == 'cleanImport') {
	require DIR_MODEL.'admin.import.cleanImport.model.php';
}
elseif($getSSection == 'mass') {
	require DIR_FCT.'admin.import.fct.php';
	require DIR_MODEL.'admin.import.mass.model.php';
}
elseif($getSSection == 'zip') {
	require DIR_FCT.'admin.import.fct.php';
	require DIR_MODEL.'admin.import.zip.model.php';
}
elseif($getSSection == '1n1') {
	require DIR_FCT.'admin.import.fct.php';
	require DIR_MODEL.'admin.import.1n1.model.php';
}	

require DIR_MODEL.'admin.import.model.php';
require DIR_VIEW.'admin.import.view.php';