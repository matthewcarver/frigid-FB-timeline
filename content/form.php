<style type="text/css">
  
  form#entry-form{
    width:100%;
    height:50px;
    display: block;

    position: relative;

    margin-top:20px;

    background-image:url(/content/_assets/_img/form.jpg);
    background-repeat: no-repeat;
  }

  form#entry-form input, form#entry-form label{
    position: absolute;
    border:none;
    background:none; 
    font-size: 14px;
  }

  form#entry-form input[name="firstname"], form#entry-form input[name="lastname"], form#entry-form input[name="email"]{
    display: block;
    top:7px;
    left:10px;
  }

  form#entry-form input[name="lastname"]{left:145px;}
  form#entry-form input[name="email"]{left:290px;}

  form#entry-form input[name="privacy"], form#entry-form label[for="privacy"]{ top:50px;}
  form#entry-form input[name="emails"], form#entry-form label[for="emails"]{top:70px;}
  form#entry-form label[for="privacy"], form#entry-form label[for="emails"]{left:30px; font-size:12px; color:#fff; margin-top:5px;}

  #submit{
    width:150px;
    height:30px;
    position: absolute;

    top:196px;
    left:547px;
  }

  .error-messages{
    width:500px;

    position: absolute;
    top:100px;
    left:12px;

  }

  #support-block{
    width:550px;
    height:160px;
    margin:0 auto;

    position: relative;
    top:80px;

    background-image:url(/content/_assets/_img/form-bubble.jpg);
    background-repeat: no-repeat;
    background-position: left top;
  }

  #support-block p{
    width:345px;
    float: left;
    padding: 25px 145px 50px 25px;

    color:#003d57;

    
    background-repeat: no-repeat;
    background-position: right top;
  }

</style>

<script type="text/javascript">

(function($){  
// The DOM is now ready
$(function() {

  $('#submit').click(function(){
    $('form#entry-form').hide();
    $('#support-block').hide();
    $('#submit').hide();



    $('#section-2').addClass('thanks').attr('style', 'height:240px;');
    $('#section-2 .copy p').html('<br/>You\'re entered into the sweeps for today\'s prize, this week\'s Frigidaire Gallery&reg; Range with Symmetry&trade; Double Ovens, and the Grand Prize. Come back tomorrow to enter again, but first send some holiday cheer to your friends!')

    $('#section-3').attr('style', 'background-image:url(/content/_assets/_img/section-3-alt.jpg);padding-top:50px;')
    $('#section-3 h2').hide();
  });

});
})( jQuery.noConflict() );
</script>

<form id="entry-form" method="post">
  <input name="firstname" placeholder="First Name">
  <input name="lastname" placeholder="Last Name">
  <input name="email" placeholder="E Mail"><br/>
  <input name="privacy" type="checkbox">
  <label for="privacy">I have read and agree to the Official Rules and Privacy Policy.</label><br/>
  <input name="emails" type="checkbox">
  <label for="emails">Yes, I would like to receive email and information from Frigidaire®.</label><br/>
  <input type="submit" value=" " class="submit">
  <input name="giveaway" value="giveaway" type="hidden">
  <input name="cta-type" value="giveaway" type="hidden">
</form>

<div id="submit"></div>

<div class="error-messages">
	<ul></ul>
</div>

<div id="support-block">
</div>