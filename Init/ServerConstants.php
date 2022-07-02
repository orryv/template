<?php

	$request_uri = substr($_SERVER['REQUEST_URI'], strlen(REQUEST_ROOT));

	if($request_uri !== '/' && substr($request_uri, -1) === '/')
        $request_uri = substr($_SERVER['REQUEST_URI'], 0, -1);

    # Set Request URI to '/' if empty string
    if($request_uri === '')
        $request_uri = '/';

    if(substr($request_uri,0,1) !== '/')
        $request_uri = '/'.$request_uri;



    //define('PHP_REQUEST_URI', $_SERVER['REQUEST_URI']);
    define('FULL_REQUEST_URI', $request_uri);

    # Delete ? and everything after it in Request URI
    if(strpos($request_uri, '?')){
        
        $request_uri = substr($request_uri,0,strpos($request_uri, '?'));
    }

    define('REQUEST_URI', $request_uri);

?>