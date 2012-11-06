<?php

// GENERAL CONFIGURATION

define('SITE_TITLE', 'Facebook App');
define('SITE_URL', 'http://frigidaire.dev');
define('UPLOAD_PATH', '/uploads');
define('SITE_LANGUAGE', 'en');
define('SITE_CHARSET', 'utf-8');

// DEFINE ANY ADDITIONAL METADATA HERE

$meta = array(
	'fb_url' => ''
);

// CLASSES ON/OFF

define('DB_CLASS', 'OFF');
define('AUTH_CLASS', 'OFF');
define('FILE_CLASS', 'OFF');
define('IMG_CLASS', 'OFF');
define('FACEBOOK_CLASS', 'OFF');

// FUNCTION FILES ON/OFF

define('MASTER_FUNCS', 'ON');

// MYSQL DB SETUP

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_DATABASE', 'app_db_name');

// KEYS

define('SECRET_KEY', 'qazwsx890');
define('FB_APP_ID', '');
define('FB_APP_SECRET', '');
define('GA_ID', '');


// AND AWAY WE GO!
require_once(INCPATH . 'load.php');