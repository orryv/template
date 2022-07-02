<?php

	use Core\Exceptions\ConfigurationException;


	if(REQUEST_ROOT === '/')
		throw new ConfigurationException('Found a bad configuration: Can\'t use value "/" for REQUEST_ROOT in "Config/App.php, leave empty if request root is at the base host folder.');

	if(strlen(REQUEST_ROOT) > 0 && substr(REQUEST_ROOT, -1) !== '/')
		throw new ConfigurationException('Found a bad configuration: REQUEST_ROOT in "Config/App.php value must end with a slash /.');

	if(strpos($_SERVER['REQUEST_URI'], REQUEST_ROOT) === false)
		throw new ConfigurationException('Found a bad configuration: REQUEST_ROOT (= "'.REQUEST_ROOT.'") in "Config/App.php is configured badly. Did not found the REQUEST_ROOT value inside the $_SERVER[\'REQUEST_URI\'] (= "'.$_SERVER['REQUEST_URI'].'") value."');

	if(PRODUCTION_SERVER && USE_SOURCE_FILES)
		throw new ConfigurationException('Found a bad configuration: PRODUCTION_SERVER and USE_SOURCE_FILES in "Config/App.php are both turned on. USE_SOURCE_FILES must be turned off on a production server."');
?>