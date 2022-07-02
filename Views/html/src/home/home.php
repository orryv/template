<?php
	
	$config = [
		'controller' => 'Home/Home',
		'template' => 'main',
		'routes' => [
			'/',
			'/home',
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

	pp(get_defined_vars());
	exit;
	$vars = get_defined_vars();

	pp($vars);
	exit;

	if(isset($page_date)){
		'ISsET';
	}

	//echo $$value;
	//pp($page_data);
?>

<h1>THIS IS THE HOMEPAGE</h1>
<?php 
		pp(get_defined_vars());
?>
<?php
 	//pp($value) 
 ?> 