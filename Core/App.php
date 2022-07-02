<?php

namespace Core;

class App
{

	public function __construct()
	{
		if(DEV_MODE){
			new \Core\Cache\RoutesCache();
		}

		new \Core\Router\Route();
		
	}

}