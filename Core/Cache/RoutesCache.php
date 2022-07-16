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

		$files = Folder::getFiles(BASE_DIR.DS.'Views');

		foreach ($files as $file) {
			if(substr($file, -4) !== '.css')
				continue;

			$f = substr($file, strlen(BASE_DIR)+15);

			$cache['css'][substr($f, 0, -4)] = $f;
		}


		//$files = Folder::getFiles(BASE_DIR.DS.'Views'.DS.'js'.DS.'min');

		foreach ($files as $file) {
			if(substr($file, -7) !== '.min.js')
				continue;

			$f = substr($file, strlen(BASE_DIR)+14);

			$cache['js'][substr($f, 0, -7)] = $f;
		}

		//$files = Folder::getFiles(BASE_DIR.DS.'Views'.DS.'html'.DS.'src');

		// Delete Cache/Routes folder contents
		array_map( 'unlink', array_filter((array) glob(BASE_DIR.DS.'Cache'.DS.'Routes'.DS.'*') ) );


		$folder = [];
		foreach ($files as $file) {
			if(substr($file, -4) !== '.php')
				continue;

			// get file name without path
			$file_name = substr($file, strrpos($file, DS) + 1);

			// if first character of $file is an _ continue
			if(substr($file_name, 0, 1) === '_')
				continue;

			

			if(strpos($file, '/_components'))
				continue;

			$folder_name = substr($file, 0, strrpos($file, DS));

			// if folder name is not in $folder array, add it
			if(!in_array($folder_name, $folder))
				$folder[] = $folder_name;




			// exit;

			/*
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

						file_put_contents(BASE_DIR.'/Cache/Routes/'.$value.'__config.php', json_encode($config));
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
					file_put_contents(BASE_DIR.'/Cache/Routes/'.$config['routes'].'__config.php', json_encode($config));
				}



				//pp($current_routes);

				
				foreach ($current_routes as $route_name => $route_path) {



					$route_path = str_replace('\\','\'.DS.\'' , str_replace('/','\'.DS.\'' , $route_path));

					$file_content = '<?php require BASE_DIR.DS.\'Views\'.DS.\'html\'.DS.\'min\'.DS.\''.$route_path.'\'; ?>';
					file_put_contents(BASE_DIR.'/Cache/Routes/'.$route_name.'__min.php', $file_content);

					$file_content = '<?php require BASE_DIR.DS.\'Views\'.DS.\'html\'.DS.\'src\'.DS.\''.$route_path.'\'; ?>';
					file_put_contents(BASE_DIR.'/Cache/Routes/'.$route_name.'__src.php', $file_content);			
				}
			}
			*/
		}

		foreach($folder as $folder){
			echo $folder.'<br>';

			foreach(Folder::getFiles($folder) as $file){
				if(substr($file, -4) !== '.php')
					continue;

				if(substr($file, -11) === '_config.php')
					continue;

				if(substr($file, -15) === '_controller.php')
					continue;

				$file_name = substr($file, strrpos($file, DS) + 1);

				$file_name_ext = substr($file_name, 0, -4);

				if(!file_exists($folder.DS.$file_name_ext.'_config.php'))
					throw new FileNotFoundException('The config file "'.$folder.DS.$file_name_ext.'_config.php" was not found.');

				$config = require $folder.DS.$file_name_ext.'_config.php';

				foreach($config['routes'] as $route){
					if(substr($route, 0, 1) === '/')
						$route = substr($route, 1);

					if(substr($route, -1) === '/')
						$route = substr($route, 0, -1);
					$cache['routes'][$route] = $file;
				}
				
			}

		}

		pp($cache);

		$html_cache = '<?php ';
		$else = '';
		foreach($cache['routes'] as $route => $file){
			if(substr($route, -1) === '*'){
				if(substr($route, -2) === '/*')
					$route = substr($route, 0, -2);
				else
					$route = substr($route, 0, -1);
				$html_cache .= $else.'if(substr(REQUEST_URI, 0, '.strlen($route).') === \''.$route.'\') require \''.$file.'\'; ';
			} else {
				$html_cache .= $else.'if(REQUEST_URI === \''.$route.'\') require \''.$file.'\'; ';
			}
			$else = 'else';
		}
		file_put_contents(BASE_DIR.'/Cache/Routes/html.php', $html_cache.' ?>');

		exit;

		//pp($cache);
		//pp($files);
	}
}

?>