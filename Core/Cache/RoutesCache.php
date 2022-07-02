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

		$files = Folder::getFiles(BASE_DIR.DS.'Views'.DS.'css'.DS.'min');

		foreach ($files as $file) {
			if(substr($file, -4) !== '.css')
				continue;

			$f = substr($file, strlen(BASE_DIR)+15);

			$cache['css'][substr($f, 0, -4)] = $f;
		}


		$files = Folder::getFiles(BASE_DIR.DS.'Views'.DS.'js'.DS.'min');

		foreach ($files as $file) {
			if(substr($file, -7) !== '.min.js')
				continue;

			$f = substr($file, strlen(BASE_DIR)+14);

			$cache['js'][substr($f, 0, -7)] = $f;
		}

		$files = Folder::getFiles(BASE_DIR.DS.'Views'.DS.'html'.DS.'src');

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
            	
            	$current_routes = [];
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
						$current_routes[$value] = $f;
					}
				} else {
					$config['routes'] = (substr($config['routes'], 0, 1) === '/') 
						? substr($config['routes'], 1) 
						: $config['routes'];

					if(isset($cache['routes'][$config['routes']])){
						$v = (strlen($config['routes']) == 0) ? '/' : $config['routes'];
						throw new RouteAlreadyExistsException('The route "'.$v.'" is already in use in "'.$cache['routes'][$config['routes']].'", trying to redefine it in "'.$f.'".');
					}
					
					$cache['routes'][$config['routes']] = $f;
					$current_routes[$config['routes']] = $f;
				}

				pp($current_routes);

				array_map( 'unlink', array_filter((array) glob(BASE_DIR.'/Cache/Routes/*') ) );
				foreach ($current_routes as $route_name => $route_path) {

					$route_path = str_replace('\\','\'.DS.\'' , str_replace('/','\'.DS.\'' , $route_path));

					$file_content = '<?php require BASE_DIR.DS.\'Views\'.DS.\'html\'.DS.\'min\'.DS.\''.$route_path.'\'; ?>';
					file_put_contents(BASE_DIR.'/Cache/Routes/'.$route_name.'__min.php', $file_content);

					$file_content = '<?php require BASE_DIR.DS.\'Views\'.DS.\'html\'.DS.\'src\'.DS.\''.$route_path.'\'; ?>';
					file_put_contents(BASE_DIR.'/Cache/Routes/'.$route_name.'__src.php', $file_content);			
				}
			}
		}

		

		pp($cache);
		//pp($files);
	}
}

?>