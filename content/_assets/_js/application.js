(function($){
	
// The DOM is now ready



$(function() {

  $.fn.extend({
    newsSlider: function(){

      var link = $("#slide-nav .slide-link")

      link.mouseenter(function(){

        var num = $(this).attr('rel');
        var leftPos = 122 * num;

        $('#nav-arrow-01').animate({
          left: leftPos
        });

        $('.slide-link.active').removeClass('active');
        $(this).addClass('active');
      });
      //end hover stuff

      link.click(function(){
        var num = $(this).attr('rel');
        var leftPos = 731 * (num - 1);

        $('#slides .slide-wrapper').animate({
          marginLeft: "-"+ leftPos
        });

      });

    }

  });

  $('#slides').newsSlider();


});


})( jQuery.noConflict() ); // Pass in jQuery so we can safely use the $ alias within this block
