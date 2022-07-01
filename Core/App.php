<?php

namespace Core;

class App
{

	public function __construct()
	{
		new \Core\Cache\RoutesCache();
	}

}