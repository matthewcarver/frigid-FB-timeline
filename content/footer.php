		</div> <!-- end .main -->
	</div> <!-- end .container -->
	<div id="fb-root"></div>
	<script type="text/javascript">
		// Load Facebook SDK and resize iframe
	    window.fbAsyncInit = function() {
	        FB.init({appId: '<?php echo FB_APP_ID; ?>', status: false, cookie: false, xfbml: true});
	        FB.Canvas.setAutoGrow();
	    };
	    (function() {
	        var e = document.createElement('script'); e.async = true;
	        e.src = document.location.protocol +
	          '//connect.facebook.net/en_US/all.js';
	        document.getElementById('fb-root').appendChild(e);
	    }());
	</script>
	<script type="text/javascript">
		//Asynchronous Google Analytics
		var _gaq = [['_setAccount', '<?php echo GA_ID; ?>'], ['_trackPageview']];
		(function(d, t) {
		var g = d.createElement(t),
			s = d.getElementsByTagName(t)[0];
		g.async = true;
		g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g, s);
		})(document, 'script');
	</script>
</body>
</html>