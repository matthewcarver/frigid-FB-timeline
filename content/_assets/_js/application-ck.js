(function(e){e(function(){e.fn.extend({newsSlider:function(){var t=e("#slide-nav .slide-link");t.mouseenter(function(){var t=e(this).attr("rel"),n=122*t;e("#nav-arrow-01").animate({left:n});e(".slide-link.active").removeClass("active");e(this).addClass("active")});t.click(function(){var t=e(this).attr("rel"),n=731*(t-1);e("#slides .slide-wrapper").animate({marginLeft:"-"+n})})}});e("#slides").newsSlider();e("#cta-block a").mouseenter(function(){var t=e(this).attr("rel"),n=161*(t-1)+50;e("#cta-block .arrow").animate({left:n})});e("#cta-block a").click(function(){e("#cta-block").fadeOut();e("#form").fadeIn()})})})(jQuery.noConflict());