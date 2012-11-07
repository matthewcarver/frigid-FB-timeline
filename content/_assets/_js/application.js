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

  $("#cta-block a").mouseenter(function(){
      var num = $(this).attr('rel');
      var leftPos = 161 * (num - 1) + 50;

      $("#cta-block .arrow").animate({
          left: leftPos
        });
    });
  
  $("#cta-block a").click(function(){
    $("#cta-block").fadeOut();
    $("#form").fadeIn();
  });


  var card;
  var cardImg;

  
  $("#card-gallery").find(".card-thumb").hover(function(){

    card = $(this);
    cardImg = $(this).attr('rel');
    
    var cardTip = '<div class="tooltip"><img src="//placehold.it/289x165?text='+ cardImg +'"></div>';
  
    card.append(cardTip);


  },function(){
    card = $(this);

    card.empty();

  });


  $("#card-gallery").find(".card-thumb").click(function(){

    var cardHTML = '<div class="featured-card"><img src="//placehold.it/572x327&text=ecard+001"><div class="social"><a href="#" class="social-link pinterest"></a><a href="#" class="social-link facebook"></a><a href="#" class="social-link twitter"></a></div></div>';

    $("#card-gallery .featured-card").remove();

  });

});


})( jQuery.noConflict() ); // Pass in jQuery so we can safely use the $ alias within this block
