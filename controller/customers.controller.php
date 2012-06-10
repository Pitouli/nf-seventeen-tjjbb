<?php

require DIR_MODEL.'customers.model.php';

if($getSection == 'new')
{
	require DIR_MODEL.'customers.new.model.php';
}
else if($getSection == 'del')
{
	require DIR_MODEL.'customers.del.model.php';
	require DIR_MODEL.'customers.search.model.php';
}
if($getSection == 'search')
{
	require DIR_MODEL.'customers.search.model.php';
}

require DIR_VIEW.'customers.view.php';