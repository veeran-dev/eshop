<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Pantry Supplies | Huge Discounts at Kobster</title>
        <meta name="description" content="Kobster's Pantry Sale of branded food products at Best Prices">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="static/css/simple-landing-page.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,700">
    </head>
    <body class="yellow-gradient">

        <div class="container">
            <header>
                <a href="http://www.kobster.com"><img class="logo" src="static/img/elite/elite-logo-white.png" alt="Kobster Elite" /></a>
            </header>
            <div class="row">
                <div class="col-md-7">
                    <h1>YOUR PANTRY NEEDS US!</h1>
                    <p>Who else can keep your pantry full with only branded food products from Water to Pritzels without losing much on your Procurement Budget?</p>
                </div>
                <div class="col-md-5">
                    <div class="hero-sign-up">
                        <h2 class="center-text">Buy Pantry in a Simple Way!</h2>
                        <form id="requestForm" method="POST" class="request-form">
                            <div class="form-group">
                                <input type="text" id="cust_name" name="cust_name" placeholder="Name"/>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="email" placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <input type="text" id="company_name" name="company_name" placeholder="Organization that you procure for?"/>
                                <input type="hidden" name="festival"  id="festival" value="4" />
                            </div>
                            <div class="form-group">
                                <input type="number" id="mobile" name="mobile" placeholder="Phone" maxlength="10"/>
                            </div>
                            <button type="submit" class="purple-gradient"><span class="button-text">ORDER NOW</span></button>
                        </form>
                    </div>
                    <div class="success_report pt-page-moveFromTop">
                        <div class="success_quote">
                            <p class="bold-text">Thank you for your interest with Kobster's Pantry Campaign!</p>
                            <p>Our Executive will be in touch with you shortly.</p>
                            <p>Are you looking to make your Procurement process smarter with a great Technology added to it? Check out - <a href="http://kobster.com/elite" target="_blank">KOBSTER ELITE</a> NOW!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 foot-note">
                    <p class="center-text">In the mean time, you can read our blogs at <a href="http://www.kobster.com/blogs" target="_blank">www.kobster.com/blogs</a> or check us out on social media with the links below.</p>
                    <div class="social-links">
                        <link itemprop="url" href="http://www.kobster.com">
                        <a class="facebook" href="http://www.facebook.com/kobsterIndia" target="_blank">&nbsp;</a>
                        <a class="twitter" href="http://www.twitter.com/kobsterOfficial" target="_blank">&nbsp;</a>
                        <a class="google-plus" href="https://plus.google.com/+KobsterIndia" target="_blank">&nbsp;</a>
                        <a class="linkedin" href="https://www.linkedin.com/company/kobster" target="_blank">&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js'></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {

            var baseUrl = window.location.origin;
            $('.container').fadeIn(600);
            $('#requestForm').validate({
                rules: {                   
                    cust_name: "required",
                    email: "required",
                    company_name: {
                        required: true,
                        textonly: true
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    city2: "required"
                },
                errorElement: "span" ,                              
                messages: {
                    cust_name: "Please enter your good name",
                    email: "Please enter valid email address",
                    company_name: "Please enter your company name, no special characters!",
                    mobile: "Please enter valid 10 digit mobile number",
                    city2: "Please select any one city"
                },
                submitHandler: function(form) {
                    var dataparam = $(form).serialize();

                    $.ajax({
                        type: 'POST',
                        //dataType: 'json',
                        async: true,
                        url: 'get_festivalResponse.php',
                        data: dataparam,
                        cache: true,
                        success: function(data) 
                        {
                            $('.success_report').show();
                            $('.hero-sign-up').hide();
                            $.ajax({
                                url: "googleAnalytics.js",
                                dataType: "script",
                                cache: true
                            }).done(function() {
                                    console.log("ga added");
                            });
                        }
                    });
                    return false;
                }                
            });
            $(document).ajaxStart(function(){
                $('.button-text').html("&#8987; Ordering...");
            });
            $(document).ajaxComplete(function(){
                $('.button-text').html("ORDER NOW");
            });
            $.validator.addMethod("textonly", function(value, element) {
                return this.optional(element) || /^[a-z," ","."]+$/i.test(value);
            }, "Only alphabets allowed!");
        });            
        </script>
    </body>
</html>