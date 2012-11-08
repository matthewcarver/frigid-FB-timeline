(function($){
	
// The DOM is now ready


$(function() {

  $.fn.extend({
    newsSlider: function(){

      var link = $("#slide-nav .slide-link")

      link.click(function(){

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
      var leftPos = 164 * (num - 1) + 50;

      $("#cta-block .arrow").animate({
          left: leftPos
        });
    });
  

  $("#cta-block a").click(function(){

    var which = $(this).attr('id');

    $("#section-2").animate({
      height: "530px"
    });

    $("#cta-block").fadeOut(1000, function(){
      $('#form').load('/form').fadeIn(1000,function(){
        $('#form #support-block').load('/' + which + '').fadeIn(500);
        $('#form input[name="cta-type"]').attr('value', which);
      });
    });
  });





  var card;
  var cardImg;

  
  $("#card-gallery").find(".card-thumb").hover(function(){

    card = $(this);
    cardImg = $(this).attr('rel');
    
    var cardTip = '<div class="tooltip"><img src="/content/images/cards/card001-m.jpg"></div>';
  
    card.append(cardTip);


  },function(){
    card = $(this);

    card.empty();

  });


  $("#card-gallery").find(".card-thumb").click(function(){

    card = $(this);
    cardImg = $(this).attr('rel');
    cardImgHTML = '<img src="/content/images/cards/card001.jpg">'

    var cardHTML = '<div class="featured-card">'+ cardImgHTML +'<div class="social"><a href="#" class="social-link pinterest"></a><a href="#" class="social-link facebook"></a><a href="#" class="social-link twitter"></a></div></div>';

    $("#card-gallery .featured-card").remove();

    card.parent().prepend(cardHTML);

  });

  $('#expandToggle').click(function(){

    $(this).remove();

    $('#card-gallery').animate({
      height: '1735px'
    }, 1000);

    $('#section-3').animate({
      height: '1335px'
    }, 1000);

  });

  var arrow = $("span#arrow");
  var dish = $("#modal-copy-dish");
  var stove = $("#modal-copy-stove");
  var washer = $("#modal-copy-washer");

  $("#modal-dish").mouseenter(function(){

    arrow.animate({
      left: '100px'
    });

    stove.fadeOut();
    washer.fadeOut();
    dish.fadeIn();

  });

  $("#modal-stove").mouseenter(function(){

    arrow.animate({
      left: '270px'
    });

    stove.fadeIn();
    washer.fadeOut();
    dish.fadeOut();

  });

    $("#modal-washer").mouseenter(function(){

    arrow.animate({
      left: '500px'
    });

    stove.fadeOut();
    washer.fadeIn();
    dish.fadeOut();

  });

  $('#close').click(function(){

    $('#modal .modal-wrap').animate({
      top: "-820px"
    }, 700, function(){
      $('#modal').fadeOut(700);
    });

  });


  $('#open-modal').click(function(){

    $('#modal').fadeIn(700, function(){
      $('#modal .modal-wrap').animate({
        top: "0px"
      }, 700);
    });
  });


  $('.cta.enter-now').click(function(){
     $('html, body').animate({
         scrollTop: $("#section-2").offset().top
     }, 700);
  });

  $('.cta.see-the-cards').click(function(){
     $('html, body').animate({
         scrollTop: $("#section-3").offset().top
     }, 700);
  });

});


})( jQuery.noConflict() ); // Pass in jQuery so we can safely use the $ alias within this block
