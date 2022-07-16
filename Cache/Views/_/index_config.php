<?php
	return [
		'template' => 'main',
		'routes' => [
			'/',
			'/home/*',
			'index'
		],
		'canonical_route' => '',
		'title' => 'Homepage', // Page title
		'description' => 'This is the page description for SEO and Google.',
		'breadcrumbs' => [
			'home'
		],
		'scripts' => [
			'jquery',
			'_self'
		],
		'styles' => [
			'main',
			'_self'
		],
	];
?>