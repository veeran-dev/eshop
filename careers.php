<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Join Kobster.com, the Indian B2B Wholesale e-commerce platform for Industries">
  <meta name="author" content="Kobster">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Careers | Kobster.com</title>
  <link href='https://fonts.googleapis.com/css?family=Merriweather:400,700italic,700|Source+Sans+Pro' rel='stylesheet' type='text/css'>
  <link href="static/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="https://www.kobster.com"><img class="logo" src="static/img/kob-logo.png"/></a>
    <div class="header-action"><a href="https://www.glassdoor.co.in/Overview/Working-at-Kobster-com-EI_IE1155185.11,22.htm" target="_blank"><img src="static/img/glassdoor-rating.png"/></a></div>
  </div>
</nav>
  
  <section class="career-home">
    <div class="container">
    <div class="owl-carousel">
      <div class="item"><img src="static/img/future-career.jpg" /></div>
      <div class="item"><img src="static/img/career-family.jpg" /></div>
      <div class="item"><img src="static/img/career-party.jpg" /></div>
    </div>
    <div class="row headshot-row">
      <div class="col-md-15 col-sm-3">
        <div class="department-title">
          Technology
        </div>
        <div class="headshot emp-tech"></div>
        <div class="quote">
          "I make businesses shop online"
        </div>
      </div>
      <div class="col-md-15 col-sm-3">
        <div class="department-title">
          Supply Chain
        </div>
        <div class="headshot emp-scn"></div>
        <div class="quote">
          "I make supply meet demand, just-in-time"
        </div>
      </div>
      <div class="col-md-15 col-sm-3">
        <div class="department-title">
          People Operations
        </div>
        <div class="headshot emp-operations"></div>
        <div class="quote">
          "I inspire people to believe in their dreams"
        </div>
      </div>
      <div class="col-md-15 col-sm-3">
        <div class="department-title">
          Category
        </div>
        <div class="headshot emp-category"></div>
        <div class="quote">
          "I bring even the rarest of rare products online"
        </div>
      </div>
      <div class="col-md-15 col-sm-3">
        <div class="department-title">
          Sales & Marketing
        </div>
        <div class="headshot emp-sales"></div>
        <div class="quote">
          "I fuel the business to grow"
        </div>
      </div>
    </div>
    <div class="row actions">
      <p>Together, we revolutionize the way businesses shop!</p>
      <a class="cta smooth-scroll" href="#goto-form">Join The Revolution!</a>
    </div>
  </div>
  </section>
  <section class="career-form" id="goto-form">
    <h2>FILL IN YOUR APPLICATION</h2>
    <div class="form-section">
      <div class="col-md-12">
        <form class="career-form" role="form" id="career_form" method="post" enctype="multipart/form-data" >
          <div class="form-group">
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name *" required>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email *" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile *" required>
          </div>
          <div class="form-group">
            <select class="form-control" id="department" name="department" required>
              <option value="">Choose Department</option>
              <option value="Technology">Technology</option>
              <option value="Supply Chain">Supply Chain</option>
              <option value="Human Resources">Human Resources</option>
              <option value="Finance & Accounts">Finance & Accounts</option>
              <option value="Customer Relationship Manager">Customer Relationship Manager</option>
              <option value="Category">Category</option>
              <option value="Sales & Marketing">Sales & Marketing</option>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="LinkedIn Profile URL (optional)">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="website" name="website" placeholder="Portfolio/Website (optional)">
          </div>
          <div class="form-group">
            <textarea class="form-control" rows="2" name="message" id="message" placeholder="Tell us anything you want us to know about you (optional)"></textarea>
          </div>
          <div class="form-group">
            <p><strong>Upload Resume</strong> (We accept: PDF, DOC, DOCX, JPG &amp; PNG)</p>
            <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx,.jpg,.png" required>
          </div>
          <button type="submit" class="btn btn-default" id="career_submit">Join Us</button>
          <img id="submit_loading" src="img/loadingAnimation.gif" width="208" height="13" alt="Loading" />
        </form>
      </div>
  </div>
</section>

	<!-- Footer container -->
	<?php include ("static/inc/static_footer.html"); ?>
    <!-- End of Footer container -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="static/js/owl.carousel.min.js"></script>
  
  <script src="js/static-validate.js" type="text/javascript"></script> 	
  <script src="js/jquery/jquery.validate.min.js" type="text/javascript"></script>
  <script src="static/js/footer-interaction.js" type="text/javascript"></script> 
  
  <script type="text/javascript">
    //Fixed Header
    $(window).scroll(function(){
        if ($(window).scrollTop() >= 5) {
            $('.navbar').addClass('nav-fixed');
        }
        else {
            $('.navbar').removeClass('nav-fixed');
        }
    });
    // Carusel
    $(document).ready(function(){
      $('.owl-carousel').owlCarousel({
        items:1,
        loop:true,
        dots: true,
        dotsEach: true,
        autoplay:true,
        autoplayTimeout:3000,
        animateOut: 'fadeOut',
        responsiveClass:true,
        autoplayHoverPause:true
        });
    });
    //Animation for Scrolling
    $(document).ready(function(){
      $('a.smooth-scroll').on('click',function (e) {
          e.preventDefault();

          var target = this.hash;
          var $target = $(target);

          $('html, body').stop().animate({
              'scrollTop': $target.offset().top
          }, 1200, 'swing', function () {
              window.location.hash = target;
          });
      });
    });
  </script>
</body>
</html>