<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="<?php meta('language'); ?>" class="ie ie6 lte9 lte8 lte7 lte6 no-js"> <![endif]-->
<!--[if IE 7 ]>    <html lang="<?php meta('language'); ?>" class="ie ie7 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="<?php meta('language'); ?>" class="ie ie8 lte9 lte8 no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="<?php meta('language'); ?>" class="ie ie9 lte9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="<?php meta('language'); ?>" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php meta('charset'); ?>" />
	<meta name="description" content="<?php meta('description'); ?>" />
	<meta name="keywords" content="<?php meta('keywords'); ?>" />
	
	<title><?php meta('title'); ?></title>
	
	<?php load_styles(); ?>
	<script>
		var site = {
			url:'<?php meta("url"); ?>',
			ajax: '<?php meta("url"); ?>/ajax',
			page: '<?php meta("body_class"); ?>',
			fb: '<?php meta("fb_url"); ?>'
		};
	</script>
	<?php load_scripts( array( 'modernizr', 'jquery', 'scripts' ) ); ?>
</head>
<body class="<?php meta('body_class'); ?>">
	<div id="container" class="container clear">
		<div id="content" class="main clear">