<?php

	use Core\Error\ErrorHandler;
	use Core\Error\ExceptionHandler;

	set_error_handler('error_handler', E_ALL);
    set_exception_handler ('exception_handler'); 
    register_shutdown_function( "shutdown_handler");

    function shutdown_handler()
    {
        $file = "unknown file";
        $message  = "shutdown";
        $errno   = E_CORE_ERROR;
        $line = 0;
        $error = error_get_last();
        if($error !== NULL) {
            $errno   = $error["type"];
            $file = $error["file"];
            $line = $error["line"];
            $message  = $error["message"];
            die(new ErrorHandler($message, $errno, 0, $file, $line));
        }
        
    }

    function error_handler($number, $message, $file, $line, $context = null)
    {
        die(new ErrorHandler($message, 0, $number, $file, $line, $context));
    }

    function exception_handler($exception)
    {
        die(new ExceptionHandler($exception));
    }

?>