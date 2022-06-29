<?php

phpinfo();exit;
	
	define('BASE_DIR', __DIR__);

	require 'Config/State.php';
	
	if(DEV_MODE){
		require BASE_DIR.'/Cache/CreateAutoloaders.php';
	}

	define('API_REQUEST', false);

	require 'vendor/autoload.php';

	echo TEST;


?>