<?php
	
	define('BASE_DIR', __DIR__);

	require 'Config/State.php';
	
	if(DEV_MODE){
		require BASE_DIR.'/Cache/CreateAutoloaders.php';
	}

	require 'vendor/autoload.php';

	echo TEST;


?>