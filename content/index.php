<?php get_header(array('title' => '', 'description' => '', 'keywords' => '')); ?>

<section id="slides">
	<nav id="slide-nav">
		<div id="nav-arrow-01"></div>
		<ul>
			<li rel="1" class="slide-link active">Holiday Time</li>
			<li rel="2" class="slide-link">Daily Prizes</li>
			<li rel="3" class="slide-link">Weekly Prize</li>
			<li rel="4" class="slide-link">Grand Prize</li>
			<li rel="5" class="slide-link">Cheer Cards</li>
		</ul> 
	</nav>
	<div class="slide-wrapper">
		<div id="slide-01" class="slide">
			<?php include("_includes/slides/slide-1.php"); ?>
		</div>
		<div id="slide-02" class="slide">
			<?php include("_includes/slides/slide-2.php"); ?>
		</div>
		<div id="slide-03" class="slide">
			<?php include("_includes/slides/slide-3.php"); ?>
		</div>
		<div id="slide-04" class="slide">
			<?php include("_includes/slides/slide-4.php"); ?>
		</div>
		<div id="slide-05" class="slide">
			<?php include("_includes/slides/slide-5.php"); ?>
		</div>
	</div>
</section>

<section id="section-2">
	<div class="copy">
		<p>What do you spend a lot of time doing during the holidays? Choose
		a task below for the chance to win daily and weekly prizes,
		plus a grand prize, a full suite of Frigidaire appliances!</p>
	</div>

	<div id="cta-block-wrapper" style="display:none;">
		<div id="cta-block">
			<div class="arrow"></div>
			<a href="javascript:void(0);" id="cooking" rel="1">&nbsp;</a>
			<a href="javascript:void(0);" id="laundry" rel="2">&nbsp;</a>
			<a href="javascript:void(0);" id="shopping" rel="3">&nbsp;</a>
			<a href="javascript:void(0);" id="cleaning" rel="4">&nbsp;</a>
		</div>
	</div>

	<div id="form">
		<?php include("_includes/form.php"); ?>
	</div>

</section>
<section id="section-3"></section>

<?php get_footer(); ?>