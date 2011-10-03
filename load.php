<?php

/* 

Bootstrap file for setting the ABSPATH constant, the CNTPATH constant, the INCPATH constant and loading the config.php file within the includes/ folder. The config.php file loads the necessary classes and functions to setup the environment.

We look for the includes/ folder in this file's directory, its parent directory, and that directory's parent directory. If the includes/ folder cannot be found, an error is displayed.

*/

define('ABSPATH', dirname(__FILE__) . '/');
define('CNTPATH', ABSPATH . 'content/');
define('INCPATH', ABSPATH . 'includes/');
define('RSCPATH', ABSPATH . 'resources/');

if(file_exists(ABSPATH . 'config.php')) $config = ABSPATH . 'config.php';
elseif(file_exists(dirname(ABSPATH) . '/config.php')) $config = dirname(ABSPATH) . '/config.php';
elseif(file_exists(dirname(dirname(ABSPATH)) . '/config.php')) $config = dirname(dirname(ABSPATH)) . '/config.php';
else die('FAIL: Cannot find configuration file!');

require_once($config);