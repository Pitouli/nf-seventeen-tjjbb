<?php


if($getSection == 'new')
{
	require DIR_MODEL.'flights.new.model.php';
}
elseif($getSection == 'create')
{
	require DIR_MODEL.'flights.new.model.php';
	require DIR_MODEL.'flights.create.model.php';
}
elseif($getSection == 'search')
{
	require DIR_MODEL.'flights.search.model.php';
}
else if($getSection == 'del')
{
	require DIR_MODEL.'flights.del.model.php';
	require DIR_MODEL.'flights.search.model.php';
}

require DIR_MODEL.'flights.model.php';

require DIR_VIEW.'flights.view.php';

