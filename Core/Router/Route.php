<?php

namespace Core\Router;

class Route
{

	public function __construct()
	{
		if(PHP_SAPI === 'cli'){

			// Command line

		} else {

			if(!file_exists(BASE_DIR.'/Cache/Routes'.REQUEST_URI.'__src.php')){
				# Page not found
				//thrown new \Exception('PAGE NOT FOUND, INTEGRATE THIS!');
				echo '<h1>PAGE NOT FOUND</h1>';
			} else {
				if(!USE_SOURCE_FILES){
					require BASE_DIR.'/Cache/Routes'.REQUEST_URI.'__min.php';
				} else {
					require BASE_DIR.'/Cache/Routes'.REQUEST_URI.'__src.php';
				}
			}

		}
	}

}