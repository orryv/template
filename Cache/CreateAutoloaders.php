<?php

	$folders = [
		[
			'folder' => 'Config/',
			'exclusions' => [
				'State.php'
			]
		],
		[
			'folder' => 'Init/',
		],
	];


	foreach ($folders as $folderData) {
		$dir = scandir(BASE_DIR.'/'.$folderData['folder']);

		$exclusions = (isset($folderData['exclusions']))
			? $folderData['exclusions']
			: [];

		$files = [];
		foreach ($dir as $key => $value) {
			
			if(in_array($value, array_merge(['.', '..', 'autoload.php'], $exclusions)))
				continue;

			if(substr($value, -4) !== '.php')
				continue;

			$files[] = $value;
		}

		$src = '<?php ';
		foreach ($files as $file) {
			$src.= 'require(BASE_DIR.\'/'.$folderData['folder'].$file.'\');';
		}
		$src.= '?>';

		file_put_contents(BASE_DIR.'/'.$folderData['folder'].'autoload.php', $src);
	}



?>