<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>PaperOne | Kobster offers PaperOne sheets at Best Prices</title>
        <meta name="description" content="Kobster offers PaperOne sheets with huge discounts (A4 1 RIM) Rs.140/-">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="static/css/simple-landing-page.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,700">
    </head>
    <body>

        <div class="container">
            <header>
                <a href="https://www.kobster.com"><img class="logo" src="static/img/elite/elite-logo-white.png" alt="Kobster Elite" /></a>
            </header>
            <div class="row">
                <div class="col-md-7">
                    <h1>Ever heard of PaperOne?</h1>
                    <ul>
                        <li>An initiative towards a Greener Environment</li>
                        <li>Green standards are maintained in your organization</li>
                        <li>PaperOne’s 70 GSM ≈ 80 GSM of other brands</li>
                        <li>Superior Opacity</li>
                        <li>PaperOne™ features both multi-directional & dual-sided printability</li>
                    </ul>
                    <p>Forget about going to the local market that sells paper for a much <span class="bold-text">EXPENSIVE PRICE + FUEL SURCHARGE</span> and Believe in Kobster for the PaperOne bulk paper rims to be delivered to your office doorsteps in just 24-48 hours. We are always obliged to keep you at an advantage and we are here to provide you with the market’s lowest price.</p>
                </div>
                <div class="col-md-5">
                    <div class="hero-sign-up">
                        <p class="center-text">Fill in your details and we will provide you with</p>
                        <h2 class="center-text">FREE SAMPLES for you to decide!</h2>
                        <form id="requestForm" method="POST" class="request-form">
                            <div class="form-group">
                                <input type="text" id="cust_name" name="cust_name" placeholder="Name"/>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="email" placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <input type="text" id="company_name" name="company_name" placeholder="Organization that you procure for?"/>
                                <input type="hidden" name="festival"  id="festival" value="3" />
                            </div>
                            <div class="form-group">
                                <input type="number" id="mobile" name="mobile" placeholder="Phone" maxlength="10"/>
                            </div>
                            <button type="submit"><span class="button-text">ORDER YOUR SAMPLE</span></button>
                        </form>
                    </div>
                    <div class="success_report pt-page-moveFromTop">
                        <div class="success_quote">
                            <p class="bold-text">Thank you for your interest with Kobster's PaperOne!</p>
                            <p>Our Executive will be in touch with you shortly.</p>
                            <p>Are you looking to make your Procurement process smarter with a great Technology added to it? Check out - <a href="https://www.kobster.com/elite" target="_blank">KOBSTER ELITE</a> NOW!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 foot-note">
                    <p class="center-text">In the mean time, you can read our blogs at <a href="https://www.kobster.com/blogs" target="_blank" style="color: #f1f122">www.kobster.com/blogs</a> or check us out on social media with the links below.</p>
                    <div class="social-links">
                        <link itemprop="url" href="https://www.kobster.com">
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
                        url: baseUrl+'/get_festivalResponse.php',
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
                $('.button-text').html("&#8987; Ordering...")
            });
            $(document).ajaxComplete(function(){
                $('.button-text').html("Order Your Sample")
            });
            $.validator.addMethod("textonly", function(value, element) {
                return this.optional(element) || /^[a-z," ","."]+$/i.test(value);
            }, "Only alphabets allowed!");
        });            
        </script>
    </body>
</html>