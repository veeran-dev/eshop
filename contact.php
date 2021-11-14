<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Join Kobster.com, the Indian B2B Wholesale e-commerce platform for Industries">
  <meta name="author" content="Kobster">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Contact Us | Kobster.com</title>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
  <link href="static/css/contact.css" rel="stylesheet">
    <link href="static/css/footer_static.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="https://www.kobster.com"><img class="logo" src="static/img/kob-logo.png"/></a>
  </div>
</nav>
  
  <div class="container main">
    <div class="row">
      <div class="col-md-4 col-sm-4">
        <h3>Support</h3>
        <p>For general questions and help in using our website mail us at <a href="mailto:support@kobster.com">support@kobster.com</a> or call us at <a href="tel:18001210405">1800-121-0405 (Toll Free)</a> or simply <a href="#" onclick="online_chat();">chat with us</a>.</p>
      </div>

      <div class="col-md-4 col-sm-4">
        <h3>Sales</h3>
        <p>For personal presentation by our wonderful Sales Team about the advantages of being our beloved customer mail us at <a href="mailto:support@kobster.com">support@kobster.com</a> or call us at <a href="tel:18001210405">1800-121-0405 (Toll Free)</a> or simply <a href="#" onclick="online_chat();">chat with us</a>.</p>
      </div>

      <div class="col-md-4 col-sm-4 clearfix">
        <h3>Partner With Us</h3>
        <p>If you are a manufacturer, retailer or an importer and would like to Sell with Us register <a href="/sell-with-us.php">here</a> or mail us at <a href="mailto:support@kobster.com">support@kobster.com</a> or call us at <a href="tel:18001210405">1800-121-0405 (Toll Free)</a> or simply <a href="#" onclick="online_chat();">chat with us</a>.</p>
      </div>
    </div>

    <div class="row">

      <div class="flip-container">

          <div class="flip-cards">
              <div class="front-card">
                <img src="static/img/city/chennai.png" alt="Kobster Chennai Headquarters">
              </div>
              <div class="reverse-card">
                <p class="address">
                  Kobster E Shop Pvt Ltd (Kobster.com)<br>
                  51-B, Mount Poonamallee Main Road,<br>
                  St. Thomas Mount, Chennai – 600016.<br>
                  <span>(End of Kathipara Flyover - Towards Porur)</span>
                </p>
              </div>
          </div>

          <div class="flip-cards">
              <div class="front-card">
                  <img src="static/img/city/bengaluru.png" alt="Kobster at Bengaluru">
              </div>
              <div class="reverse-card">
                <p class="address">
                  Kobster E Shop Pvt Ltd (Kobster.com)<br>
                  64/2, 6th cross, 3rd main road,<br>
                  Near Idgah Maidan, Chamrajpet,<br>
                  Bengaluru-560018.
                </p>
              </div>
          </div>

          <div class="flip-cards">
              <div class="front-card">
                <img src="static/img/city/mumbai.png" alt="Kobster at Mumbai">
              </div>
              <div class="reverse-card">
                <p class="address">
                  Kobster E Shop Pvt Ltd (Kobster.com)<br>
                  48/52, Parshwa kutir CHS, <br>
                  Perin Nariman Street, <br>
                  Opp. to ICICI ATM, Bazar Gate, Fort,<br>                  
                  Mumbai-400059.
                </p>
              </div>
          </div>

      </div>

    </div>
    <!-- End Row -->
    <div class="row">

      <div class="flip-container small">

        <div class="flip-cards">
            <div class="front-card">
              <img src="static/img/city/ncr-gurgoan.png" alt="Kobster at NCR, Gurgoan">
            </div>
            <div class="reverse-card">
              <p class="address">
                Kobster E Shop Pvt Ltd (Kobster.com)<br>
                No:202, Second Floor,<br>
                Municipal No:4832/24, Ansari Road,Darya Ganj<br>
                Delhi-110034.
              </p>
            </div>
        </div>

        <div class="flip-cards">
          <div class="front-card">
            <img src="static/img/city/hyderabad.png" alt="Kobster at Hyderabad">
          </div>
          <div class="reverse-card">
            <p class="address">
              Kobster E Shop Pvt Ltd (Kobster.com)<br>
              No:5-2-434, Ground Floor,<br>
              Risala Abdullah, Mouzzam Jahi Market,<br>
              Hyderabad, Telangana - 500 012
            </p>
          </div>
        </div>

      </div>

    </div>
    <!-- End Row -->
  </div>
  <!-- End Container -->
	<!-- Footer container -->
	<?php include ("static/inc/static_footer.html"); ?>
    <!-- End of Footer container -->

  <script src="static/js/jquery-min.js"></script>
  <script>
  <!-- Zoho Chat Plugin -->
  $(document).ready(function(){var $zoho=$zoho||{livedesk:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/support.kobstereshoppvtltd/float.ls?embedname=kobstereshoppvtltd";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);});
  function online_chat()
  {
    $("#zls_ctn_wrap").click();
  }
  </script>
  <script src="static/js/footer-interaction.js"></script>
  <script>
    $.fn.OneClickSelect = function () {
      return $(this).on('click', function () {
        var range, selection;
        if (window.getSelection) {
          selection = window.getSelection();
          range = document.createRange();
          range.selectNodeContents(this);
          selection.removeAllRanges();
          selection.addRange(range);
        } else if (document.body.createTextRange) {
          range = document.body.createTextRange();
          range.moveToElementText(this);
          range.select();
        }
      });
    };
    // Apply to these elements
    $('p.address').OneClickSelect();
  </script>
</body>
</html>