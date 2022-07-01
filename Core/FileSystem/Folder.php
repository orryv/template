<?php


namespace Core\FileSystem;

class Folder
{

	public static function getFiles(array|string $folder)
	{
		$files = [];
		foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS)) as $path) {
			if ($path->isDir()) 
				continue;
		  	$files[] = $path->getPathname();
		}
		return $files;
	}

}