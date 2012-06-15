<?php

require DIR_MODEL.'places.model.php';

if($getSection == 'newville')
{
	require DIR_MODEL.'ville.new.model.php';
}
elseif($getSection == 'searchville')
{
	require DIR_MODEL.'ville.search.model.php';
}
else if($getSection == 'delville')
{
	require DIR_MODEL.'ville.del.model.php';
}
if($getSection == 'newaeroport')
{
	require DIR_MODEL.'aeroport.new.model.php';
}
elseif($getSection == 'searchaeroport')
{
	require DIR_MODEL.'aeroport.search.model.php';
}
else if($getSection == 'delaeroport')
{
	require DIR_MODEL.'aeroport.del.model.php';
	require DIR_MODEL.'aeroport.search.model.php';
}
else if($getSection == 'show')
{
	require DIR_MODEL.'aeroport.show.model.php';
	require DIR_MODEL.'aeroport.search.model.php';
}

require DIR_VIEW.'places.view.php';