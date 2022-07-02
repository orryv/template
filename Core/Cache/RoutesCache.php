<?php

namespace Core\Cache;

use Core\FileSystem\Folder;
use Core\Exceptions\RouteAlreadyExistsException;

class RoutesCache
{

	public function __construct()
	{

		$cache = [
			'templates' => [],
			'components' => [],
			'routes' => [],
			'css' => [],
			'js' => []
		];

		$files = Folder::getFiles(BASE_DIR.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'html'.DIRECTORY_SEPARATOR.'src');

		foreach ($files as $file) {
			if(substr($file, -4) !== '.php')
				continue;

			$f = substr($file, strlen(BASE_DIR)+16);

			if(substr($f, 0, strlen('components')) === 'components'){
				$cache['components'][str_replace('\\', '/', substr($f, strlen('components')+1, -4))] = substr($f, strlen('components')+1);
			} else if(substr($f, 0, strlen('templates')) === 'templates'){
				$cache['templates'][str_replace('\\', '/', substr($f, strlen('templates')+1, -4))] = substr($f, strlen('templates')+1);
			} else {

				$buffer = (ob_get_length())
            		? ob_get_contents()
            		: '';
				require $file;
				if (ob_get_length()){
            		ob_end_clean();
            		ob_start();
            		echo $buffer;
				}
            	
				if(is_array($config['routes'])){
					foreach ($config['routes'] as $value) {
						$value = (substr($value, 0, 1) === '/') 
							? substr($value, 1) 
							: $value;

						if(isset($cache['routes'][$value])){
							$v = (strlen($value) == 0) ? '/' : $value;
							throw new RouteAlreadyExistsException('The route "'.$v.'" is already in use in "'.$cache['routes'][$value].'", trying to redefine it in "'.$f.'".');
						}
						
						$cache['routes'][$value] = $f;
					}
				} else {
					$cache['routes'][$config['routes']] = (substr($cache['routes'][$config['routes']], 0, 1) === '/') 
						? substr($cache['routes'][$config['routes']], 1) 
						: $cache['routes'][$config['routes']];

					if(isset($cache['routes'][$config['routes']])){
						$v = (strlen($cache['routes'][$config['routes']]) == 0) ? '/' : $cache['routes'][$config['routes']];
						throw new RouteAlreadyExistsException('The route "'.$v.'" is already in use in "'.$cache['routes'][$value].'", trying to redefine it in "'.$f.'".');
					}
					
					$cache['routes'][$config['routes']] = (substr($f, 0, 1) === '/') ? substr($f, 1) : $f;
				}
			}
		}

		$files = Folder::getFiles(BASE_DIR.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'min');

		foreach ($files as $file) {
			if(substr($file, -4) !== '.css')
				continue;

			$f = substr($file, strlen(BASE_DIR)+15);

			$cache['css'][substr($f, 0, -4)] = $f;
		}


		$files = Folder::getFiles(BASE_DIR.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'min');

		foreach ($files as $file) {
			if(substr($file, -7) !== '.min.js')
				continue;

			$f = substr($file, strlen(BASE_DIR)+14);

			$cache['js'][substr($f, 0, -7)] = $f;
		}

		pp($cache);
		//pp($files);
	}
}

?>