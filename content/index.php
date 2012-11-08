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

<section id="section-2" class="clearfix">
	<div class="copy">
		<p>What do you spend a lot of time doing during the holidays? Choose
		a task below for the chance to win daily and weekly prizes,
		plus a grand prize, a full suite of Frigidaire appliances!</p>
	</div>

	<div id="cta-block-wrapper">
		<div id="cta-block">
			<div class="arrow-wrap">
				<div class="arrow"></div>
			</div>
			<a href="javascript:void(0);" id="cooking" rel="1">&nbsp;</a>
			<a href="javascript:void(0);" id="laundry" rel="2">&nbsp;</a>
			<a href="javascript:void(0);" id="shopping" rel="3">&nbsp;</a>
			<a href="javascript:void(0);" id="cleaning" rel="4">&nbsp;</a>
		</div>
	</div>

	<div id="form" style="display:none;">
	</div>

</section>
<section id="section-3" class="clearfix" style="height:800px">
	<h2>Share a holiday laugh (or two!) with your loved ones.</h2>
	<div id="card-gallery" style="height:525px">


		<div class="card-row">
			<div class="featured-card">
					<img src="/content/images/cards/card001.jpg">
					<div class="social">
						<a href="#" class="social-link pinterest"></a>
						<a href="#" class="social-link facebook"></a>
						<a href="#" class="social-link twitter"></a>
					</div>
			</div>
		<!-- .featured-card -->

			<div class="card-thumb card001" rel="card001"></div>
			<div class="card-thumb card002" rel="card002"></div>
			<div class="card-thumb card003" rel="card003"></div>
			<div class="card-thumb card004" rel="card004"></div>
		</div>
		<div class="card-row">
			<div class="card-thumb card005" rel="card005"></div>
			<div class="card-thumb card006" rel="card006"></div>
			<div class="card-thumb card007" rel="card007"></div>
			<div class="card-thumb card008" rel="card008"></div>
		</div>
		<div class="card-row">
			<div class="card-thumb card009" rel="card009"></div>
			<div class="card-thumb card010" rel="card010"></div>
			<div class="card-thumb card011" rel="card011"></div>
			<div class="card-thumb card012" rel="card012"></div>
		</div>
		<div class="card-row">
			<div class="card-thumb card013" rel="card013"></div>
			<div class="card-thumb card014" rel="card014"></div>
			<div class="card-thumb card015" rel="card015"></div>
			<div class="card-thumb card016" rel="card016"></div>
		</div>
		<div class="card-row">
			<div class="card-thumb card017" rel="card017"></div>
			<div class="card-thumb card018" rel="card018"></div>
			<div class="card-thumb card019" rel="card019"></div>
			<div class="card-thumb card020" rel="card020"></div>
		</div>
		<div class="card-row">
			<div class="card-thumb card021" rel="card021"></div>
			<div class="card-thumb card022" rel="card022"></div>
			<div class="card-thumb card023" rel="card023"></div>
			<div class="card-thumb card024" rel="card024"></div>
		</div>
		<div class="card-row">
			<div class="card-thumb card025" rel="card025"></div>
			<div class="card-thumb card026" rel="card026"></div>
			<div class="card-thumb card027" rel="card027"></div>
			<div class="card-thumb card028" rel="card028"></div>
		</div>
		<div class="card-row">
			<div class="card-thumb card029" rel="card029"></div>
		</div>
	</div>
	<a id="expandToggle" href="javascript:void(0);">&nbsp;</a>
</section>

<?php get_footer(); ?>