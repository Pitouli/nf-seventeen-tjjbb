<?php

require DIR_MODEL.'fleet.model.php';

if($getSection == 'newModele')
{
	require DIR_MODEL.'fleet.newModele.model.php';
}
elseif($getSection == 'newAvion')
{
	require DIR_MODEL.'fleet.newAvion.model.php';
}

require DIR_VIEW.'fleet.view.php';
