<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kobster Edge - The best quote. Super Fast.">
    <meta name="author" content="Kobster.com">

    <link rel="icon" type="image/vnd.microsoft.icon" href="{$img_ps_dir}favicon.ico?{$img_update_time}" />
    <link rel="shortcut icon" type="image/x-icon" href="{$img_ps_dir}favicon.ico?{$img_update_time}" />

    <title>Kobster Edge - The Best Quote. Super Fast.</title>

    <!-- CSS -->
    <link href="edge/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="edge/assets/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="edge/assets/css/simple-line-icons.css" rel="stylesheet" media="screen">
    <link href="edge/assets/css/animate.css" rel="stylesheet">

    <!-- Custom styles CSS -->
    <link href="edge/assets/css/style.css" rel="stylesheet" media="screen">

    <script src="edge/assets/js/modernizr.custom.js"></script>

</head>

<body>

    <!-- Preloader -->

    <div id="preloader">
        <div id="status"></div>
    </div>

    <!-- Home panel-body -->

    <section id="home" class="pfblock-image screen-height">
        <header class="header" style="position: fixed; top: 0px;">

            <nav class="navbar navbar-custom" role="navigation">

                <div class="container">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="edge-index.php"><img src="edge/assets/images/edge-med-trans.png"></a>
                    </div>

                </div>
                <!-- .container -->

            </nav>

        </header>
        <div class="home-overlay">
        </div>
        <div class="intro">
			<div id="get-started" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-12">
                <div class="col-md-12 tab-style">
                    <h2>Massive Savings on Copier Papers!</h2><p></p>
					<h3>Save up to</h3><h2 class="opensans-style">20<span style="font-size:46px">%</h2><h3>on your Copier Paper Spends.</h3>
					<p>In 4 easy steps, you will be able to get an unbelievable quote for the copier paper of your choice.</p>
					<input type="button" name="get-started-button" id="get-started-button" onClick="getStartedButton()" class="button" value="Get Started!" />
                    <div class="future-plan-text">More Products, Categories, Deals coming soon. Watch this space for more.</div>
                </div>
            </div>
            <div id="product-content" style="display:none;">
                <div class="tab-style col-md-5 col-md-offset-7 col-sm-5 col-sm-offset-7 col-xs-6 col-xs-offset-4">
                    <p>Select Your Product</p>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-5 col-sm-5"></div>
                <div class="product-select-step panel-body col-md-5 col-md-offset-2 col-sm-5 col-sm-offset-2 col-xs-6 col-xs-offset-4">
                {foreach from=$products item=product name=officeSta} {assign var='productLink' value=$link->getProductLink($product.id_product, $product.link_rewrite)}
                <div class="tab-style">
                    <a href="#" onclick="getQuote('{$product.name|escape:'htmlall':'UTF-8'}','{$product.id_product}')">
                        <div class="panel-body col-md-4 col-sm-6 col-xs-12">
                            <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, $imagetype)}" alt="{$product.legend}">
                            <div class="prod-name">{$product.name|escape:htmlall:'UTF-8'|truncate:35}</div>
                        </div>
                    </a>
                </div>
                {/foreach}
                <a href="#contact"><button class="btn btn-primary add-more-products-edge">For more products click here.</button></a>
                </div>
                </div>
            </div>
            <form id="msform" class="col-md-4 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-12" style="display:none;">
            <span class="edge-loader" style="display:none;">
               <img src="img/gif-load.gif" alt="loader" />
            </span>
                <!-- progressbar -->
                <input type="hidden" id="product_name" name="product_name" value="" />
                <input type="hidden" id="id_product" name="id_product" value="" />
                <ul id="progressbar">
                    <li class="active">Your Need</li>
                    <li>Other details</li>
                    <li>Sign In / Sign Up</li>
                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <header><img src="edge/assets/images/edge-med.jpg">
                    </header>
                    <div class="form-group">
						<div class="col-sm-12">
                            <label id="product_name_h3"></label>
                        </div>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="est_qty" placeholder="Your Estimated quantity" id="est_qty">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select class="form-control" id="qty_type"  name="qty_type">
                                    <option>Units</option>
                                    <option>Boxes</option>
                                    <option>Containers</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="tar_price" placeholder="Your Target Price in INR" id="tar_price">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select class="form-control" id="price_type" name="price_type">
                                    <option>Per unit</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input class="form-control" maxlength="6" type="text" name="pin_code" placeholder="Your Pincode" id="pin_code" />
                        </div>
                    </div>
                    <input type="button" name="previous" class="action-button" onclick="goToProduct()" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <header><img src="edge/assets/images/edge-med.jpg">
                    </header>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label style="font-size:12px;color:#656565;margin-top:3%;">1. Do you need Credit Payment Facility?</label>
                            <div class="btn-group" id="radio-btn-edge" data-toggle="buttons">
                                <label class="btn-style default-payment-yes btn btn-default">
                                    <input type="radio" name="credit_yes" id="credit_yes" data-value="1" autocomplete="off">Yes
                                </label>
                                <label class="btn-style default-payment-no btn btn-default active">
                                    <input type="radio" name="credit_no" id="credit_no" data-value="0" autocomplete="off" checked> No
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label style="font-size:12px;color:#656565;margin-top:3%;">2. Please provide any other details about your requirement.</label>
                                <textarea class="form-control" id="message-text" rows="4" name="message-text" placeholder="Other Details"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset id="final-set">
                    <header><img src="edge/assets/images/edge-med.jpg">
                    </header>
                    <div id="acc-hint">
                        <h4>Sign In to Continue</h4></div>
                    <div class="bq_new_acc">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="acc_name" placeholder="Name" id="acc_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0px;">
                        <div class="col-sm-12">
                            <input type="email" class="form-control" name="acc_email" placeholder="Email" id="acc_email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input class="form-control" type="password" name="acc_pass" placeholder="Password" id="acc_pass" />
                        </div>
                    </div>
                    <div class="btn-group" id="acc-create-link" data-toggle="buttons">
                    	<p class="error" id="bq-acc-error" style="color:red;font-size:10px;display:none;">Authentication failed. Please check your email or password.</p>
                        <a href="#">
                            <label id="sign-up-link" style="font-size:12px;color:#427fed;cursor:pointer;" onclick="edgeBqAccCheck(0)">I don't have a kobster Account</label>
                        </a>
                    </div>
                    <input type="button" name="previous" id="sign-in-previous" class="previous action-button" value="Previous" />
                    <input type="button" id="sign-in-edge" name="submit" class="submit_sign_in action-button" onclick="bqSignIn()" value="Submit" />
                    <div class="bq_new_acc">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" type="text" maxlength="12" name="acc_phone" placeholder="Phone" id="acc_phone" />
                                <p class="error" id="bq-acc-exists" style="color:red;font-size:10px;display:none;">An account is already registered with this e-mail, please login with your existing password.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bq_new_acc">
                        <div class="btn-group" data-toggle="buttons">
                            <a href="#">
                                <label id="sign-in-link" style="font-size:12px;color:#427fed;cursor:pointer;" onclick="edgeBqAccCheck(1)">I have a kobster Account</label>
                            </a>
                        </div>
                    </div>
                    <input type="button" name="previous" id="sign-up-previous" class="previous action-button" value="Previous" />
                    <input type="button" id="sign-up-edge" name="submit" class="submit_sign_up action-button" onclick="createNewAccount()" value="Submit" />
                    <input type="hidden" id="bq_id_customer" name="bq_id_customer" value=""/>
                </fieldset>
            </form>

        </div>

        <a href="#services">
            <div class="scroll-down">
                <span>
                <i class="fa fa-angle-down fa-2x"></i>
            </span>
            </div>
        </a>

    </section>

    <!-- Home end -->

    <!-- Navigation panel-body -->

    <header class="header">

        <nav class="navbar navbar-custom" role="navigation">

            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="edge-index.php"><img src="edge/assets/images/edge-med.jpg"></img>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="custom-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#portfolio">Categories</a></li>
                        <li><a href="#skills">Active Requests</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

            </div>
            <!-- .container -->

        </nav>

    </header>

    <!-- Navigation end -->

    <!-- Services panel-body -->

    <section id="services" class="pfblock pfblock-gray">
        <div class="container">
            <div class="row">

                <div class="col-sm-6 col-sm-offset-3">

                    <div class="pfblock-header wow fadeInUp">
                        <h2 class="pfblock-title">This is what We do</h2>
                        <div class="pfblock-line"></div>
                        <div class="pfblock-subtitle">
                            We help you find best quotes, super fast. You tell us what you need & our system will help you find the right supplier.
                        </div>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-sm-3">

                    <div class="iconbox wow slideInLeft">
                        <div class="iconbox-icon">
                            <span class="icon-list"></span>
                        </div>
                        <div class="iconbox-text">
                            <h3 class="iconbox-title">Post Request</h3>
                            <div class="iconbox-desc">
                                Give us details about your requirement with proper specifications & payment terms.
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-3">

                    <div class="iconbox wow slideInLeft">
                        <div class="iconbox-icon">
                            <span class="icon-loop"></span>
                        </div>
                        <div class="iconbox-text">
                            <h3 class="iconbox-title">Quote Screening</h3>
                            <div class="iconbox-desc">
                                Our huge Supplier Network Quotes for your requirement. We screen & validate them for you.
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-3">

                    <div class="iconbox wow slideInRight">
                        <div class="iconbox-icon">
                            <span class="icon-shuffle"></span>
                        </div>
                        <div class="iconbox-text">
                            <h3 class="iconbox-title">Compare Quote</h3>
                            <div class="iconbox-desc">
                                You get to compare the top quotes alone & select the most suited one.<br>&nbsp;
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-sm-3">

                    <div class="iconbox wow slideInRight">
                        <div class="iconbox-icon">
                            <span class="icon-basket-loaded"></span>
                        </div>
                        <div class="iconbox-text">
                            <h3 class="iconbox-title">Place Order</h3>
                            <div class="iconbox-desc">
                                You can conveniently place your Order online & Kobster.com would fulfil it.
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </section>

    <!-- Services end -->

    <!-- Portfolio panel-body -->

    <section id="portfolio" class="pfblock">
        <div class="container">
            <div class="row">

                <div class="col-sm-6 col-sm-offset-3">

                    <div class="pfblock-header wow fadeInUp">
                        <h2 class="pfblock-title">Product Categories</h2>
                        <div class="pfblock-line"></div>
                        <div class="pfblock-subtitle">
                            These are the Categories which we are serving today & what we would be serving soon.
                        </div>
                    </div>

                </div>

            </div>
            <!-- .row -->


            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">

                    <div class="grid wow zoomIn">
                        <figure class="effect-bubba">
                            <img src="edge/assets/images/item-1.jpg" alt="Copier Papers" />
                            <figcaption>
                                <h2>Copier <span>Papers</span></h2>
                                <p>JK, TNPL & Bilt brands. All Sizes. Delivery in Chennai & Bangalore.</p>
                            </figcaption>
                        </figure>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-4 col-md-4">

                    <div class="grid wow zoomIn">
                        <figure class="effect-bubba">
                            <img src="edge/assets/images/item-2.jpg" alt="Office Chairs" />
                            <figcaption>
                                <h2>Office <span>Chairs</span></h2>
                                <p>Executive Chairs. Cafeteria Chairs. Visitor Chairs.</p>
                            </figcaption>
                        </figure>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-4 col-md-4">

                    <div class="grid wow zoomIn">
                        <figure class="effect-bubba">
                            <img src="edge/assets/images/item-3.jpg" alt="Tissue Papers" />
                            <figcaption>
                                <h2>Tissue <span>Papers</span></h2>
                                <p>Hand Tissues. Face Tissues. C-Folds. M-Folds. Toilet Papers.</p>
                            </figcaption>
                        </figure>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4">

                    <div class="grid wow zoomIn">
                        <figure class="effect-bubba">
                            <img src="edge/assets/images/item-4.jpg" alt="Cartridges Toners Inks" />
                            <figcaption>
                                <h2>Cartridges & <span>Toners</span></h2>
                                <p>HP. Canon. Samsung. Xerox. Epson.</p>
                            </figcaption>
                        </figure>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-4 col-md-4">

                    <div class="grid wow zoomIn">
                        <figure class="effect-bubba">
                            <img src="edge/assets/images/item-5.jpg" alt="Corporate Gifts" />
                            <figcaption>
                                <h2>Corporate <span>Gifts</span></h2>
                                <p>Chocolates. Sweets. Mementos. Coffee Mugs & More</p>
                            </figcaption>
                        </figure>
                    </div>

                </div>

                <div class="col-xs-12 col-sm-4 col-md-4">

                    <div class="grid wow zoomIn">
                        <figure class="effect-bubba">
                            <img src="edge/assets/images/item-6.jpg" alt="Customized T-Shirts" />
                            <figcaption>
                                <h2>Customized <span>T-Shirts & Caps</span></h2>
                                <p>Printed T-Shirts & Caps with your Company Logo.</p>
                            </figcaption>
                        </figure>
                    </div>

                </div>

            </div>

        </div>
        <!-- .contaier -->

    </section>

    <!-- Portfolio end -->

    <!-- Skills panel-body -->

    <section class="pfblock pfblock-gray" id="skills">

        <div class="container">

            <div class="row skills">

                <div class="row">

                    <div class="col-sm-6 col-sm-offset-3">

                        <div class="pfblock-header wow fadeInUp">
                            <h2 class="pfblock-title">Active Requests</h2>
                            <div class="pfblock-line"></div>
                            <div class="pfblock-subtitle">
                                Several Buyers are discovering Cost Saving Quotes by using our Service.
                            </div>
                        </div>

                    </div>

                </div>
                <!-- .row -->

                <div class="col-sm-6 col-md-3 text-center">
                    <span data-percent="80" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">1345</span>
                    </span>
                    <h3 class="text-center">Buyer Requests</h3>
                </div>
                <div class="col-sm-6 col-md-3 text-center">
                    <span data-percent="90" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">345</span>
                    </span>
                    <h3 class="text-center">Active Suppliers</h3>
                </div>
                <div class="col-sm-6 col-md-3 text-center">
                    <span data-percent="85" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">5645</span>
                    </span>
                    <h3 class="text-center">Quotes</h3>
                </div>
                <div class="col-sm-6 col-md-3 text-center">
                    <span data-percent="95" class="chart easyPieChart" style="width: 140px; height: 140px; line-height: 140px;">
                            <span class="percent">765</span>
                    </span>
                    <h3 class="text-center">Closed Deals</h3>
                </div>

            </div>
            <!--End row -->

        </div>

    </section>

    <!-- Skills end -->

    <!-- CallToAction panel-body -->

    <section class="calltoaction">
        <div class="container">

            <div class="row">

                <div class="col-md-12 col-lg-12">
                    <h2 class="wow slideInRight" data-wow-delay=".1s">DO YOU HAVE ANY QUESTIONS?</h2>
                    <div class="calltoaction-decription wow slideInRight" data-wow-delay=".2s">
                        Do you want to be a seller on Kobster Edge?
                    </div>
                </div>

                <div class="col-md-12 col-lg-12 calltoaction-btn wow slideInRight" data-wow-delay=".3s">
                    <a href="#contact" class="btn btn-lg">Get in Touch</a>
                </div>

            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </section>

    <!-- CallToAction end -->

    <!-- Testimonials panel-body -->

    <section id="testimonials" class="pfblock pfblock-gray">

        <div class="container">

            <div class="row">

                <div class="col-sm-6 col-sm-offset-3">

                    <div class="pfblock-header wow fadeInUp">
                        <h2 class="pfblock-title">What do Our Customers say?</h2>
                        <div class="pfblock-line"></div>
                        <div class="pfblock-subtitle">
                            This is what some of our Customers say about using our service.
                        </div>
                    </div>

                </div>

            </div>
            <!-- .row -->

            <div class="row">

                <div id="cbp-qtrotator" class="cbp-qtrotator">
                    <div class="cbp-qtcontent">
                        <img src="edge/assets/images/client-1.jpg" alt="client-1" />
                        <blockquote>
                            <p>A truly wonderful service. I got super low quotations in a very quick time. Satisfied & happy with this amazing way to get quotes.</p>
                            <footer>Suryakanta Pani, Bhadra International</footer>
                        </blockquote>
                    </div>
                    <div class="cbp-qtcontent">
                        <img src="edge/assets/images/client-2.jpg" alt="client-2" />
                        <blockquote>
                            <p>KobsterEdge is the most easy & efficient way to buy products at such low cost. Makes life so much easier. Awesome service.</p>
                            <footer>Anil, BGR Energy</footer>
                        </blockquote>
                    </div>

                </div>

            </div>
            <!-- .row -->


        </div>
        <!-- .row -->
    </section>

    <!-- Testimonial end -->


    <!-- Contact panel-body -->

    <section id="contact" class="pfblock">
        <div class="container">
            <div class="row">

                <div class="col-sm-6 col-sm-offset-3">

                    <div class="pfblock-header">
                        <h2 class="pfblock-title">Talk to us</h2>
                        <div class="pfblock-line"></div>
                        <div class="pfblock-subtitle">
                            Do you have any questions? Are you interested in selling on our platform? Just drop a line & we shall get back to you.
                        </div>
                    </div>

                </div>

            </div>
            <!-- .row -->

            <div class="row">

                <div class="col-sm-6 col-sm-offset-3">

                    <form id="contact-form" role="form">
                        <div class="ajax-hidden">
                            <div class="form-group wow fadeInUp">
                                <input type="text" id="c_name" class="form-control" name="c_name" placeholder="Name*">
                            </div>

                            <div class="form-group wow fadeInUp">
                                <input type="text" id="c_company" class="form-control" name="c_company" placeholder="Company Name(optional)">
                            </div>

                            <div class="form-group wow fadeInUp" data-wow-delay=".1s">
                                <input type="email" id="c_email" class="form-control" name="c_email" placeholder="E-mail*">
                            </div>

                            <div class="form-group wow fadeInUp" data-wow-delay=".2s">
                                <textarea class="form-control" id="c_message" name="c_message" rows="7" placeholder="Message / Product details*"></textarea>
                            </div>

                            <button type="submit" class="btn btn-lg btn-block wow fadeInUp" data-wow-delay=".3s">Send Message</button>
                        </div>
                        <div class="ajax-response"></div>
                    </form>

                </div>

            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </section>

    <!-- Contact end -->
    <!--panel-body ajax response for feedback-->
    <div class="modal modal-response" id="success-response" tabindex="-1" role="dialog" aria-labelledby="success-response" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-success">Message sent</h3>
                </div>
                <div class="modal-body">
                    <p>
                        Thank you for contacting us. We have recieved your feedback. We will contact you as soon as possible.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- end: contact response success modal. -->

    <!-- panel-body: contact response failure modal
     This modal will be opened if the form is failed to submit at the server. -->
    <div class="modal modal-response" id="failure-response" tabindex="-1" role="dialog" aria-labelledby="failure-response" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-danger">Message not sent</h3>
                </div>
                <div class="modal-body text-indent-container">
                    <p>
                        There were problem in sending your message.Try again later or write mail directly to <kbd>contact@you.com</kbd>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-response" id="complete-response" tabindex="-1" role="dialog" aria-labelledby="complete-response" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <center><img src="edge/assets/images/edge-med.jpg">
                </div>
                <div class="modal-body text-indent-container">
                    <div>
                        <center>
                            <h3>Thank you! Your request is being processed.</h3>
                        </center>
                    </div>
                    <div id="bq_result_edge">
                        <center>
                            <p>This is what happens now</p>
                        </center>
                    </div>
                    <div>
                        <ul id="bq_ul_edge">
                            <li>
                                <div class="bq_icon" id="bq_broadcast_edge"></div>
                                <div class="bq_caption">Request is Broadcast</div>
                            </li>
                            <li>
                                <div class="bq_arrow"></div>
                            </li>
                            <li>
                                <div class="bq_icon" id="bq_supplier_edge"></div>
                                <div class="bq_caption">Supplier Submits Quote</div>
                            </li>
                            <li>
                                <div class="bq_arrow"></div>
                            </li>
                            <li>
                                <div class="bq_icon" id="bq_screen_edge"></div>
                                <div class="bq_caption">Kobster.com Screens Quotes</div>
                            </li>
                            <li>
                                <div class="bq_arrow"></div>
                            </li>
                            <li>
                                <div class="bq_icon" id="bq_best_quote_edge"></div>
                                <div class="bq_caption">You Select Best Deal</div>
                            </li>
                            <li>
                                <div class="bq_arrow"></div>
                            </li>
                            <li>
                                <div class="bq_icon" id="bq_delivery_edge"></div>
                                <div class="bq_caption">Kobster.com Fulfils Order</div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <br />
                    <div>
                        <center>
                            <p>If you have questions, please contact us at <a href="#">1800 121 0405</a> or email us at <a href="mailto:support@kobster.com">support@kobster.com</a></p>
                        </center>
                    </div>
                    <input type="button" id="complete-edge" name="complete-edge" class="complete-edge action-button" onclick="completeEdge()" value="OK" />
                </div>
            </div>
        </div>
    </div>
    <!--end ajax-response for feedback-->
    <!-- Footer panel-body -->

    <footer id="footer">
        <div class="container">
            <div class="row">

                <div class="col-sm-12">

                    <ul class="social-links">
                        <li><a href="https://www.facebook.com/kobsterIndia" target="_blank" class="wow fadeInUp"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.twitter.com/kobsterindia" class="wow fadeInUp" target="_blank" data-wow-delay=".1s"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/2701610?trk=tyah" class="wow fadeInUp" target="_blank" data-wow-delay=".2s"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="{$content_dir}blogs" class="wow fadeInUp" target="_blank" data-wow-delay=".4s"><i class="fa fa-rss"></i></a></li>
                    </ul>

                    <p class="heart">
                        An offering of Kobster.com
                    </p>
                    <p class="copyright">
                        © 2016 Kobster.com | All Rights Reserved
                    </p>

                </div>

            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </footer>

    <!-- Footer end -->

    <!-- Scroll to top -->

    <div class="scroll-up">
        <a href="#home"><i class="fa fa-angle-up"></i></a>
    </div>

    <!-- Scroll to top end-->

    <!-- Javascript files -->

    <script src="edge/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="edge/assets/js/jquery-validate.js"></script>
    <script type="text/javascript" src="dash/js/jquery.nicescroll.js"></script>
    <script src="edge/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="edge/assets/js/jquery.parallax-1.1.3.js"></script>
    <script src="edge/assets/js/imagesloaded.pkgd.js"></script>
    <script src="edge/assets/js/jquery.sticky.js"></script>
    <script src="edge/assets/js/smoothscroll.js"></script>
    <script src="edge/assets/js/wow.min.js"></script>
    <script src="edge/assets/js/jquery.easypiechart.js"></script>
    <script src="edge/assets/js/waypoints.min.js"></script>
    <script src="edge/assets/js/jquery.cbpQTRotator.js"></script>
    <script src="edge/assets/js/custom.js"></script>
</body>

</html>