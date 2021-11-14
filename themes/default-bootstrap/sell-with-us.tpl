<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Sell with Us | Kobster.com</title>
    <meta name="description" content="Sell office stationery supplies, hardware and plumbing tools, electrical supplies, fasteners, abrasives, car accessories, power tools, hospital equipment supplies, lab supplies, lamps and lighting, safety and security equipment, furniture online at wholesale in India from Kobster.com.">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="{$img_ps_dir}favicon.ico?{$img_update_time}">
    <link rel="stylesheet" type="text/css" href="static/css/style2.css">
    <link rel="stylesheet" href="back-to-top/css/style.css">
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
    </script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
  </head>

  <body class="sell-with-us">
    <!-- HEADER -->
    <!-- <nav class="fixed_side_nav">
        <a class="wow bounceIn" href="#features0"> &nbsp; </a>
        <a class="wow bounceIn" href="#features1"> &nbsp; </a>
        <a class="wow bounceIn" href="#features2"> &nbsp; </a>
        <a class="wow bounceIn" href="#features3"> &nbsp; </a>
    </nav> -->
    
    
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="https://www.kobster.com"><img class="logo" src="static/img/kob-logo.png"/></a>
  </div>
</nav>
  <header class="col-md-12 padding_zero"  id="features0">
    
        <div class="container-fluid padding_zero">
              <div class="row padding_zero">
                <div class="col-md-12 padding_zero">
                  <img src="static/img/sellwithus/Sell-with-us-banner.jpg" class="img-responsive sell-with-us" alt="Sell with Us" />
                </div>
            </div>
        </div>

    </header>
    <!-- HEADER END --> 
    
    <section>
      <div>
          
            <!-- Heading And Texts -->
            <div class="container padding_bottom40 no_border">
            
              <div class="row reduced-padding">
                
                <div class="col-md-4 align_center">
                    <div class="col-md-12 icon-medium text-center">
                        <img src="static/img/sellwithus/Sell-with-us.png" class="wow fadeInLeft" data-wow-duration="0.80s" alt="">
                    </div>
                    <div class="col-md-12 text-center">
                        <p class="sub-heading">Are you a <a class="manufacturer_btn" href="#features1">Manufacturer</a> who wants to launch your products nationwide?</p>
                        <a class="btn btn-common wow bounceIn manufacturer_btn" href="#features1">Let's Take You Places</a>
                    </div>
                </div>
                
                <div class="col-md-4 align_center">
                    <div class="col-md-12 icon-medium">
                        <img src="static/img/sellwithus/Sell-with-us-2.png" class="wow" data-wow-duration="0.80s" alt="">
                    </div>
                    <div class="col-md-12">
                        <p class="sub-heading">Are you a <a class="trader_btn" href="#features1">Trader</a> who wants to sell at bulk to businesses & retailers?</p>
                        <a class="btn btn-common wow bounceIn trader_btn" href="#features1">Let's Expand Your Business</a>
                    </div>
                </div>
                
                <div class="col-md-4 align_center">
                    <div class="col-md-12 icon-medium">
                        <img src="static/img/sellwithus/Sell-with-us-3.png" class="wow fadeInRight" data-wow-duration="0.80s" alt="">
                    </div>
                    <div class="col-md-12">
                        <p class="sub-heading">Are you an <a class="importer_btn" href="#features1">Importer</a> who is trying to clear your stocks?</p>
                        <a class="btn btn-common wow bounceIn importer_btn" href="#features1">Let's Do It Together</a>
                    </div>
                </div>
                
                
              </div>
             
            </div>
            <!-- Heading And Texts End-->
    </div>
    </section>
    
    <!-- Features Section -->    
    <section id="main-features" class="col-md-12 grey_bg">
    
      <div class="feature-list item-1" id="features1">
 
          <div class="container">
        
          <div class="row" id="form_holder">
            
            <div class="col-md-7">
              <div class="feature-content wow fadeInLeft" data-wow-duration="0.80s">
                
                <form class="form-inline" role="form" id="sell_reg_form" method="post" >
                  
                    <div class="form-group">
                      <label for="seller_name">Your Name</label>
                      <input type="text" class="form-control" id="seller_name" name="seller_name" placeholder="Enter Name"> 
                    </div>
                    <div class="form-group">
                      <label for="firm_name">Your Firm Name</label>
                      <input type="text" class="form-control" id="firm_name" name="firm_name" placeholder="Enter Firm Name">
                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <select class="form-control" id="city" name="city">
                        <option value="">Select City</option>
                        {foreach from=$cities item=data}
                          <option value="{$data.id_seller_city}">{$data.city_name}</option>
                        {/foreach}
                      </select>
                      <label for="city" class="error"></label>
                    </div>
                    <div class="form-group">
                      <label >Seller Type </label>
                      <select class="form-control" id="seller_type" name="seller_type">
                        <option value="">Select Seller type</option>
                        <option value="Manufacturer">Manufacturer</option>
                        <option value="Trader">Trader</option>
                        <option value="Importer">Importer</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="mobile">Mobile Number</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile Number">
                    </div>
                    <div class="form-group">
                      <label for="email">Email ID</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ID">
                    </div>
                    
                    <div class="form-group">
                        <label></label>
                        <input type="hidden" name="registrationFlag" value="1" id="registrationFlag">
                        <button type="submit" name="submit_sell" id="submit_sell" class="btn btn-common wow bounceIn reg_now_btn">Register Now</button>
                        <img id="submit_loading" class="pull-right reg_now_btn" src="img/loadingAnimation.gif" width="208" height="13" alt="Loading" />
                    </div>
                    
              </form>
                
              </div>
            </div>
            
            <div class="col-md-5">
              <div class="feature-content wow fadeInRight" data-wow-duration="0.80s">
                
          
                <div class="owl-carousel">
                    <div class="item">
                        <h1 class="small-title">Benefits of Manufacturer</h1>
                        <ul>
                            <li>✔ Nationwide reach</li>
                            <li>✔ Let us be your Multichannel Marketer</li>
                            <li>✔ Let us be your trusted Distributor</li>
                            <li>✔ We take care of buyer credit</li>
                            <li>✔ Pan India logistics support</li>
                            <li>✔ Increased brand awareness</li>
                        </ul>
                    </div>
                    <div class="item">
                        <h1 class="small-title">Benefits of Trader</h1>
                        <ul>
                            <li>✔ Expand your retailer network</li>
                            <li>✔ Reach more purchase managers</li>
                            <li>✔ Secure & Faster Payment</li>
                            <li>✔ Repeat buyers</li>
                            <li>✔ Unlimited product listing</li>
                        </ul>
                    </div>
                    <div class="item">
                        <h1 class="small-title">Benefits of Importer</h1>
                        <ul>
                            <li>✔ Buy globally, sell locally.</li>
                            <li>✔ Expand your reseller network.</li>
                            <li>✔ Pan India logistics support.</li>
                            <li>✔ Increased product awareness &amp; reach.</li>
                            <li>✔ Let us be your Multichannel Marketer.</li>
                        </ul>
                    </div>
                </div>
                   
                
              </div>
            </div>
            
            
            
          </div>
        </div>
      </div> 
  </section>
  <!-- Features Section End -->    
  <!-- Footer container -->
  <div class="footer-container col-sm-12 col-md-12">
      <footer id="footer"  class="container">
      <div class="row">
      
        <!-- Links Column -->
        <div class="links-section">
          <div class="footer-block">
            <h4>Information <span class="toggle-icon">&nbsp;</span></h4>
            <ul class="toggle-footer">
              <li><a rel="nofollow" href="/about.php">About Us</a></li>
              <li><a rel="nofollow" href="/sell-with-us.php">Sell with Us</a></li>
              <li><a rel="nofollow" href="/careers.php">Careers</a></li>
              <li><a rel="nofollow" href="/blogs/">Blog</a></li>
            </ul>
          </div>
          <div class="footer-block">
            <h4>Policy <span class="toggle-icon">&nbsp;</span></h4>
            <ul class="toggle-footer">
              <li><a rel="nofollow" href="/index.php?controller=cms?id_cms=3">Terms and Conditions</a></li>
              <li><a rel="nofollow" href="/index.php?controller=cms?id_cms=6">Privacy Policy</a></li>
              <li><a rel="nofollow" href="/index.php?controller=cms?id_cms=9">Cancellation & Return</a></li>
              <li><a rel="nofollow" href="/index.php?controller=cms?id_cms=10">Shipping Policy</a></li>            
            </ul>
          </div>
          <div class="footer-block">
            <h4>Help <span class="toggle-icon">&nbsp;</span></h4>
            <ul class="toggle-footer">
              <li><a rel="nofollow" href="/contact.php">Contact Us</a></li>
              <li><a rel="nofollow" href="/my-account">Your Account</a></li>
              <!--<li><a rel="nofollow" href="/guest-tracking">Order Tracking</a></li>-->
              <li><a rel="nofollow" href="/sitemap">Sitemap</a></li>
            </ul>
          </div>
          <div class="footer-block">
            <h4>Others <span class="toggle-icon">&nbsp;</span></h4>
            <ul class="toggle-footer">
              <li><a rel="nofollow" href="/new-products">New Products</a></li>
              <li><a rel="nofollow" href="/best-sales">Top Sellers</a></li>
              <li><a rel="nofollow" href="/prices-drop">Discounted Products</a></li>
              <li><a rel="nofollow" href="/brands">Brands</a></li>
            </ul>
          </div>
        </div>
        
        <!-- Newsletter Column -->
        <div class="subscribe-section">
          <h4>Be first to save</h4>
          <form action="" method="post" class="">
            <div class="newsletter-form">
              <input class="inputNew form-control newsletter-input" id="newsletter-input" type="text" name="email" size="18" value="" placeholder="Enter your email"/>
              <button type="submit" name="submitNewsletter" class="red-button"><span>&nbsp;</span></button>
              <input type="hidden" name="action" value="0" />
            </div>
          </form>
                  <div class="social-links" itemscope itemtype="http://schema.org/Organization">
                      <link itemprop="url" href="https://www.kobster.com">
                      <a itemprop="sameAs" class="facebook" href="http://www.facebook.com/kobsterIndia" target="_blank">&nbsp;</a>
                      <a itemprop="sameAs" class="twitter" href="http://www.twitter.com/kobsterOfficial" target="_blank">&nbsp;</a>
                      <a itemprop="sameAs" class="google-plus" href="https://plus.google.com/+KobsterIndia" target="_blank">&nbsp;</a>
                      <a itemprop="sameAs" class="linkedin" href="https://www.linkedin.com/company/kobster" target="_blank">&nbsp;</a>
                      <a class="rss" href="/blogs/" target="_blank">&nbsp;</a>
                  </div>
        </div>
      </div>

          <div class="row">
              <div class="copyright">
                  <div class="payment-methods-wrapper">
                      <div class="payment-methods visa" title="Visa"></div>
                      <div class="payment-methods master-card" title="Master Card"></div>
                      <div class="payment-methods maestro" title="Maestro"></div>
                      <div class="payment-methods net-banking" title="Net Banking"></div>
                      <div class="payment-methods cheque" title="Cheque Payment"></div>
                      <div class="payment-methods cod" title="Cash on Delivery"></div>
                      <div class="payment-methods credit" title="Credit Payment"></div>
                  </div>
                  <div class="copyright-info">
                      <p><span>Made with <span class="heart">&#10084;</span> in India &#124; </span><span>&copy;</span> <span>Kobster.com - 2012-2016</span></p>
                  </div>
              </div>
          </div>
      </footer>
  </div><!-- #footer -->

  <!-- End of Footer container --> 
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
  <script src="js/jquery/jquery.validate.min.js" type="text/javascript"></script>
  <script src="static/js/static-validate.js" type="text/javascript"></script> 
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