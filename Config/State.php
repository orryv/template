<?php
	
	/**
	 * Development Mode
	 * 
	 * Set to true when developing because it will generate cache files on every request.
	 */
	define('DEV_MODE', true);

	/**
	 * Debug the production server
	 *
	 * When turned on some tests and asserts will be done to check if the
	 * production server is configured properly. Turning this option on could
	 * help debugging production server access issues.
	 */
	define('DEBUG_PRODUCTION_SERVER', false);

	/**
	 * Production Server
	 * 
	 * Only turn this on when running app on a production server.
	 */
	define('PRODUCTION_SERVER', false);

	/**
	 * Use Source Files
	 * 
	 * Helpful when developing (so the reported error line is correct in html and js.)
	 * This applies to html and js files, it will use the src/ file when true, and
	 * will use the minified file when false.
	 */
	define('USE_SOURCE_FILES', true);

?>