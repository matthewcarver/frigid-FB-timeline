<?php

/*

Template Functions

*/

/*

get_template() pulls a template file from the /content folder. Pass a template name (without .php) and any meta information you'd like to pass to that template file (apart from the globals). If you'd like to retrieve the template file (using the output buffer) rather than include the file, pass a false for the echo variable.

get_template('sidebar', array('myvar' => 'example'));

*/
function get_template($file, $metas = array(), $echo = true)
{
	global $build;
	if(!$echo) ob_start();
	$build->load($file . '.php', $metas);
	if(!$echo) return ob_get_clean();
}

function get_header($metas = array())
{
	get_template('header', $metas);
}

function get_sidebar($metas = array())
{
	get_template('sidebar', $metas);
}

function get_footer($metas = array())
{
	get_template('footer', $metas);
}

/*

Same as the WP function:

if(is_page('home')) echo 'Homepage!';

*/
function is_page($page)
{
	return (meta('body_class', false) == $page) ? true : false;
}

/*

Returns meta information. If you pass meta data to the template file, you can pull it with this function. This also carries the global metadata. Pass a false to the echo variable to return the meta item and not print it.

meta('body_class');

You can also change what a global meta item returns. If, for example, you would like to change the meta('title') item, you would do this:

function meta_title() {
	return 'My New Title';
}

*/
function meta($item, $echo = true)
{
	global $meta;
	if(is_callable('meta_' . $item)) $meta[$item] = call_user_func('meta_' . $item);
	if(isset($meta[$item]) && $echo) echo $meta[$item];
	elseif(isset($meta[$item]) && !$echo) return $meta[$item];
	else return false;
}

function load_scripts($load = array('all'), $extra = array())
{
	$scripts = array(
		'modernizr' => array('url' => meta('resources', false) . '/js/modernizr.js'),
		'jquery' => array('url' => '//ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js'),
		'swfobject' => array('url' => '//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js'),
		'facebook' => array('url' => '//connect.facebook.net/en_US/all.js'),
		'easing' => array('url' => meta('resources', false) . '/js/easing.js'),
		'pngfix' => array('url' => meta('resources', false) . '/js/pngfix.js'),
		'master' => array('url' => meta('resources', false) . '/js/master.js'),
		'scripts' => array('url' => meta('content', false) . '/js/scripts.js')
	);
	array_merge($scripts, $extra);
	
	foreach($scripts as $name => $info)
	{
		if(in_array('all', $load) || in_array($name, $load)) 
		{
			if(isset($info['conditional'])) echo '<!--[if ' . $info['conditional'] . ']>';
			echo '<script src="' . $info['url'] . '"></script>';
			if(isset($info['conditional'])) echo '<![endif]-->';
			echo '
	';
		}
	}
	echo '
';
}

function load_styles($load = array('all'), $extra = array())
{
	$styles = array(
		'master' => array('url' => meta('resources', false) . '/styles/master.css'),
		'style' => array('url' => meta('content', false) . '/styles/style.css')
	);
	array_merge($styles, $extra);
	
	foreach($styles as $name => $info)
	{
		$info['media'] = (isset($info['media'])) ? $info['media'] : 'all';
		
		if(in_array('all', $load) || in_array($name, $load))
		{
			if(isset($info['conditional'])) echo '<!--[if ' . $info['conditional'] . ']>';
			echo '<link rel="stylesheet" href="' . $info['url'] . '" media="' . $info['media'] . '" />';
			if(isset($info['conditional'])) echo '<![endif]-->';
			echo '
	';
		}
	}
	echo '
';
}