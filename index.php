<?php

	use Core\App;

	ob_start();
	
	define('BASE_DIR', __DIR__);

	require 'Config/State.php';
	
	if(DEV_MODE){
		require BASE_DIR.'/Scripts/CreateAutoloaders.php';
	}

	define('API_REQUEST', false);

	require 'vendor/autoload.php';

	if(DEV_MODE || DEBUG_PRODUCTION_SERVER){
		require 'AssertConfig.php';
	}

	new App();

	if(DEV_MODE){

	}



?>