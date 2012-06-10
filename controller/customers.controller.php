<?php

require DIR_MODEL.'customers.model.php';

if($getSection == 'newCustomer')
	require DIR_MODEL.'customers.newCustomer.model.php';
	
if($getSection == 'searchCustomer' || $getSection == 'delCustomer')
	require DIR_MODEL.'customers.searchCustomer.model.php';
	
if($getSection == 'delCustomer')
	require DIR_MODEL.'customers.delCustomer.model.php';

require DIR_VIEW.'customers.view.php';