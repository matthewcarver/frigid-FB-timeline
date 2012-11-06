<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="<?php meta('language'); ?>" class="ie ie6 lte9 lte8 lte7 lte6 no-js"> <![endif]-->
<!--[if IE 7 ]>    <html lang="<?php meta('language'); ?>" class="ie ie7 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="<?php meta('language'); ?>" class="ie ie8 lte9 lte8 no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="<?php meta('language'); ?>" class="ie ie9 lte9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="<?php meta('language'); ?>" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php meta('charset'); ?>" />
	<meta name="description" content="<?php meta('description'); ?>" />
	<meta name="keywords" content="<?php meta('keywords'); ?>" />
	
	<title><?php meta('title'); ?></title>
	

	<!-- css -->
  <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
	<?php load_styles(); ?>

	<!-- js --> 
	<?php load_scripts( array( 'modernizr', 'jquery', 'flip-counter' ) ); ?>
	
	<script type="text/javascript">
  (function($){
    $(function() {
    var myCounter = new flipCounter('flip-counter', {value:123455, inc:100, pace:1000, auto:true});
  });
  })( jQuery.noConflict() );
  </script>

</head>
<body class="<?php meta('body_class'); ?>">
	
<header role="main">
	<div id="logo"></div>
	<div id="flip-counter" class="flip-counter"></div>
</header>