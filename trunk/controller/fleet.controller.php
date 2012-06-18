<?php

if($getSection == 'newModele')
{
	require DIR_MODEL.'fleet.newModele.model.php';
}
elseif($getSection == 'newAvion')
{
	require DIR_MODEL.'fleet.newAvion.model.php';
}
elseif($getSection == 'searchModele')
{
	require DIR_MODEL.'fleet.searchModele.model.php';
}
elseif($getSection == 'listeAvion')
{
	require DIR_MODEL.'fleet.listeAvion.model.php';
}
else if($getSection == 'delAvion')
{
	require DIR_MODEL.'fleet.delAvion.model.php';
}
else if($getSection == 'delModele')
{
	require DIR_MODEL.'fleet.delModele.model.php';
}
/*
else if($getSection == 'showModele')
{
	require DIR_MODEL.'fleet.showModele.model.php';
	require DIR_MODEL.'fleet.searchModele.model.php';
}
*/

require DIR_MODEL.'fleet.model.php';



require DIR_VIEW.'fleet.view.php';
