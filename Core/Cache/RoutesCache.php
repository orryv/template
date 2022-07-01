<?php

namespace Core\Cache;

use Core\FileSystem\Folder;

class RoutesCache
{

	public function __construct()
	{
		$files = Folder::getFiles(BASE_DIR.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.'src');

		$cache = [
			'templates' => [],
			'components' => [],
			'routes' => []
		];

		foreach ($files as $file) {
			if(substr($file, -4) !== '.php')
				continue;

			$f = substr($file, strlen(BASE_DIR)+16);
			echo $f.'<br>';

			if(substr($f, 0, strlen('components')) === 'components'){
				$cache['components'][str_replace('\\', '/', substr($f, strlen('components')+1, -4))] = substr($f, strlen('components')+1);
			} else if(substr($f, 0, strlen('templates')) === 'templates'){
				$cache['templates'][str_replace('\\', '/', substr($f, strlen('templates')+1, -4))] = substr($f, strlen('templates')+1);
			} else {
				$cache['routes'][str_replace('\\', '/', substr($f, 0, -4))] = $f;
			}

		}

		pp($cache);
		pp($files);
	}
}

?>