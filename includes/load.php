<?php

session_start();

// TEMPLATE INCLUDES

require_once(INCPATH . 'class.build.php');
require_once(INCPATH . 'functions.template.php');

// GLOBAL VARS

$db; $auth; $build; $f; $img; $facebook;

$build = new Build();

$meta['url'] = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? str_replace('http://', 'https://', SITE_URL) : SITE_URL;
$meta['content'] = $meta['url'] . '/content';
$meta['resources'] = $meta['url'] . '/content/_assets';
$meta['uploads'] = $meta['url'] . '/' . UPLOAD_PATH;
$meta['body_class'] = CURRENT_PAGE;
$meta['language'] = SITE_LANGUAGE;
$meta['charset'] = SITE_CHARSET;

// JSON FUNCTIONS INCLUDE

if(!function_exists('json_encode'))
{
	require_once(INCPATH . 'class.json.php');
	function json_encode($data)
	{
		$json = new Services_JSON();
		return($json->encode($data));
	}
}
if(!function_exists('json_decode'))
{
	require_once(INCPATH . 'class.json.php');
	function json_decode($data, $bool)
	{
		if($bool)
		{
			$json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		else
		{
			$json = new Services_JSON();
		}
		return( $json->decode($data) );
	}
}

// SERVICES

if(DB_CLASS == 'ON')
{
	require_once(INCPATH . 'class.database.php');
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	$db->connect();
}
if(AUTH_CLASS == 'ON')
{
	if(DB_CLASS != 'ON')
	{
		require_once(INCPATH . 'class.database.php');
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
		$db->connect();
	}
	require_once(INCPATH . 'class.authentication.php');
	$auth = new Authentication();
}
if(FILE_CLASS == 'ON')
{
	require_once(INCPATH . 'class.file.php');
	$f = new File();
}
if(IMG_CLASS == 'ON')
{
	if(FILE_CLASS != 'ON')
	{ 
		require_once(INCPATH . 'class.file.php'); 
		$f = new File(); 
	}
	require_once(INCPATH . 'class.image.php');
	$img = new Image();
}
if(FACEBOOK_CLASS == 'ON')
{
	header('P3P: CP="CAO PSA OUR"');
	require_once INCPATH . 'class.facebook.php';
	require_once INCPATH . 'functions.facebook.php';
	$facebook = new Facebook(array('appId' => FB_APP_ID, 'secret' => FB_APP_SECRET, 'cookie' => true));
}
if(MASTER_FUNCS == 'ON') require_once(INCPATH . 'functions.php');

// USER FUNCTIONS

if(file_exists(CNTPATH . 'functions.php')) require_once(CNTPATH . 'functions.php');

// LOAD PAGE

if(LOAD_TEMPLATE == 'YES')
{
	$build->page();
	if(DB_CLASS == 'ON') $db->close();
}