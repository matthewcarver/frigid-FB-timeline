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
    var myCounter = new flipCounter('flip-counter', {value:123455, inc:120, pace:500, auto:true});
  });
  })( jQuery.noConflict() );
  </script>

</head>
<body class="<?php meta('body_class'); ?>">
	
<header role="main">
	<div id="logo"></div>
	<div id="flip-counter" class="flip-counter"></div>
  <span id="open-modal"></span>
</header>

<div id="modal" style="display:none;">
  <div class="modal-wrap">
    <span id="close"></span>
    <div class="top-copy">
      <p>For more than 90 years we've looked toward the future to make your life more convenient and efficient. And we're just getting started. This holiday we’re giving you the gift of time and the chance to win some of our time sacCtttving appliances, such as the Frigidiare Gallery® Range with Symmetry™ Double Ovens. Take a look at how our appliances could save you time.</p>
    </div>
    <span id="modal-dish" class="modal-target"></span>
    <span id="modal-stove" class="modal-target"></span>
    <span id="modal-washer" class="modal-target"></span>
    <span id="arrow"></span>
    <span class="saved">saved</span>
    <div id="modal-copy-dish" class="modal-copy">
      <span class="time">37 min</span>
      <p>Hate doing the dishes? We do too. Soaking them to avoid scrubbing off sticky food is a thing of the past. The <a href="http://www.frigidaire.com/products/Kitchen/Dishwashers/FGHD2465NF.aspx" target="_blank">Exclusive OrbitClean&trade; Spray Arm</a> provides 4x better water coverage so you don't have to soak.</p>
    </div>
    <div id="modal-copy-stove" class="modal-copy" style="display:none;">
      <span class="time">10 Min</span>
      <p>Love to bake? <a href="http://www.frigidaire.com/products/Kitchen/gas-electric-ranges/FGEF306TMF.aspx" target="_blank">The Frigidaire Gallery 30" Freestanding Electric Double Oven Range</a> preheats in just four minutes. Faster preheat time means less waiting.  And your guests will be able to enjoy your delicious meals &amp; desserts in no time.</p>
    </div>
    <div id="modal-copy-washer" class="modal-copy" style="display:none;">
      <span class="time">37 Min</span>
      <p>Equipped with TimeWise&trade; technology, wash time equals dry time – so you don't have to wait around for clothes to dry.  You'll also enjoy a more precise dry cycle and fewer wrinkles with DrySense&trade; technology. Combine that with the largest capacity dryer in a standard size, and you'll be able to enjoy more "you" time.</p>
    </div>
  </div>
</div>
