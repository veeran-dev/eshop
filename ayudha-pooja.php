<?php
require(dirname(__FILE__).'/config/config.inc.php');
$city_details = Db::getInstance()->ExecuteS("SELECT id_seller_city, city_name FROM "._DB_PREFIX_."seller_cities order by city_name asc");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Ayudha Pooja - Corporate Gifts for Employees, Clients and Office Staff | Kobster.com</title>
    <meta name="description" content="Get the pleasant taste of flavourful sweets. Experience exquisite chocolates with a relish, Gift your employees the most astonishing set of gifts for this Ayudha Pooja">
    <meta name="author" content="Kobster">
   
    <link rel="stylesheet" type="text/css" href="static/css/style2.css">
    <link rel="stylesheet" href="back-to-top/css/style.css">
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
    </script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
	<script>
		  dataLayer = [];
		</script>
		<!-- Google Tag Manager -->
		 
		<script>
		    (function(w, d, s, l, i) {
		        w[l] = w[l] || [];
		        w[l].push({
		            'gtm.start': new Date().getTime(),
		            event: 'gtm.js'
		        });
		        var f = d.getElementsByTagName(s)[0],
		            j = d.createElement(s),
		            dl = l != 'dataLayer' ? '&l=' + l : '';
		        j.async = true; 
		        j.src =
		            '//www.googletagmanager.com/gtm.js?id=' + i + dl;
		        f.parentNode.insertBefore(j, f);
		    })(window, document, 'script', 'dataLayer', 'GTM-WGMT78');
		</script> 
		<!-- End Google Tag Manager -->
  </head>

  <body class="sell-with-us">
    <!-- HEADER -->
    <!-- <nav class="fixed_side_nav">
        <a class="wow bounceIn" href="#features0"> &nbsp; </a>
        <a class="wow bounceIn" href="#features1"> &nbsp; </a>
        <a class="wow bounceIn" href="#features2"> &nbsp; </a>
        <a class="wow bounceIn" href="#features3"> &nbsp; </a>
    </nav> -->
    
    
<nav class="navbar navbar-festival navbar-default navbar-fixed-top">
  <div class="container">
    <a href="https://www.kobster.com" class="festival-logo"><img class="logo" src="static/img/logo-white.png" /></a>
  </div>
</nav>
	<header class="col-md-12 padding_zero">
		
        <div class="container-fluid padding_zero">
              <div class="row padding_zero">
                <div class="col-md-12 padding_zero">
                  <img src="static/img/festivals/ayudha-pooja.jpg" class="img-responsive sell-with-us" alt="Happy Adudha pooja" />
                </div>
            </div>
        </div>

    </header>
    <!-- HEADER END --> 
    
    <section>
    	<div>
          
            <!-- Heading And Texts -->
            <div class="container no_border">
            
              <div class="row festival-content">
                
                <div class="col-md-8 mt30 wow fadeInLeft" data-wow-duration="0.80s">
                	<h1 class="small-title">Huge Discounts on Sweets, Chocolates &amp; Dry Fruits</h1>
                    
                    <div class="col-md-4">
                    	<div class="sweet-box">
                        	<img src="static/img/festivals/sweet-box/sweets.jpg" class="img-responsive" alt="color hearts" />
                            <p>Get the Pleasant taste of flavourful <b>Sweets</b></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                    	<div class="sweet-box">
                        	<img src="static/img/festivals/sweet-box/chocolates.jpg" class="img-responsive" alt="color hearts" />
                            <p>Experience Exquisite <b>Chocolates</b> with a relish</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                    	<div class="sweet-box">
                        	<img src="static/img/festivals/sweet-box/gifts.jpg" class="img-responsive" alt="color hearts" />
                            <p>Gift your Employees the most Astonishing <b>Dry Fruits</b>.</p>
                        </div>
                    </div>
                    
                    <p class="alert">We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</p>
                    
                    <p class="alert">Elite Customers can directly contact their RMs to know the offers</p>
                    
                </div>
                
                <div class="col-md-4 mt30 wow fadeInRight" data-wow-duration="0.80s">
                	
                    <h2 id="thanks">Please fill the form to know the offers!</h2>
                    <form role="form"  method="post" id="ayudha_pooja_form" >
                    	<input type="hidden" name="festival" id="festival" value="1" />
                        <input type="text" class="form-control" id="cust_name" name="cust_name" placeholder="Name *" /> 
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email ID *" />
                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name *" />
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Phone / Mobile Number *" />
                        <button type="submit" name="submit_ayudha_pooja" id="submit_ayudha_pooja" class="btn btn-common submit-button" />
                            <span>Know More!</span>
                        </button>
                        <img id="submit_loading" class="submit_loading" src="img/loadingAnimation.gif" width="208" height="13" alt="Loading" />
                    </form>
                    
                    <p class="alert loading"></p>

                </div>

              </div>
             
            </div>
            <!-- Heading And Texts End-->
		</div>
    </section>
    


    
        
    
    <!-- jQuery Load -->
    <script src="static/js/jquery-min.js"></script>
    <!-- Bootstrap -->
    <script src="static/js/bootstrap.min.js"></script>
    <!--WOW Scroll Spy-->
    <script src="static/js/wow.js"></script>
    <!-- Smooth Scroll -->
    <script src="static/js/smooth-on-scroll.js"></script>
    <script src="static/js/smooth-scroll.js"></script>
    <!-- All JS plugin Triggers -->
    <script src="static/js/main.js"></script>

	<script src="static/js/owl.carousel.min.js"></script>
	
    <script src="js/static-validate.js" type="text/javascript"></script> 
    <script src="js/jquery/jquery.validate.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <script type="text/javascript">
	  $('#city').select2();
	</script>
	<script src="static/js/footer-interaction.js"></script> 
    <script type="text/javascript">

    //Fixed Header
    $(window).scroll(function(){
      if ($(window).scrollTop() >= 1) {
        $('.navbar').addClass('nav-fixed');
      }
      else {
        $('.navbar').removeClass('nav-fixed');
      }
    });
		
    $(document).ready(function() {
		
		//WOW Scroll Spy
		var wow = new WOW({
			//disabled for mobile
			mobile: false,
			offset:       100
		});
		wow.init();
				
		$('html,body').animate({
		  scrollTop: 0
		}, 1000);
		

		
		$(".manufacturer_btn").click(function(){
			$('#seller_type option[value="Manufacturer"]').attr("selected",true);	
		});
		$(".trader_btn").click(function(){
			$('#seller_type option[value="Trader"]').attr("selected",true);
		});
		$(".importer_btn").click(function(){
			$('#seller_type option[value="Importer"]').attr("selected",true);
		});
		
		
		

		
	});
	
	 // Carusel
      $('.owl-carousel').owlCarousel({
        items:1,
        loop:false,
        dots: true,
        dotsEach: true,
        autoplay:true,
        autoplayTimeout:3000,
        animateOut: false,
        responsiveClass:true,
        autoplayHoverPause:true
        });
	
	</script>
    <a href="#0" class="cd-top">Top</a>	
	<script src="back-to-top/js/main.js"></script>

    </body>
</html>