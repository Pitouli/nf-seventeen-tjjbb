<?php

require DIR_MODEL.'security.model.php';

if(!isset($_SESSION['connected']) || !$_SESSION['connected'])
{
	require DIR_VIEW.'connect.view.php';
	exit();
}