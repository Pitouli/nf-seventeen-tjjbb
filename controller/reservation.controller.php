<?php

if($getSection == 'search')
{
	require DIR_MODEL.'reservation.search.model.php';
}
elseif($getSection == 'save')
{
	require DIR_MODEL.'reservation.save.model.php';
}
require DIR_MODEL.'reservation.model.php';

require DIR_VIEW.'reservation.view.php';