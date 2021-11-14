<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>The Bottomline | Business Procurement Talkshow</title>
    <meta name="description" content="Learn all about procurement from the top leaders in the industry. Free business talkshow registration.">
    <meta name="author" content="Kobster">
    <link href="https://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet">
    {literal}
    <style type="text/css">
    </style>
    {/literal}
    <link rel="stylesheet" href="{$tpl_uri}css/campaigns/bottomline.min.css" type="text/css" media="{$media|escape:'html':'UTF-8'}" /> 
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
    </script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
</head>
<body>
    <header class="header">
        <div class="container">
            <nav class="flex flex-etoe flex-vc">
                <a href="https://www.kobster.com" class="logo">
                    <img class="kobster-logo" src="{$tpl_uri}img/kobster-logo-tm.png" />
                </a>
                <div class="wrapper">
                    <a href="tel:18001210405" class="call">
                        <img src="{$tpl_uri}img/campaigns/pantry/call.svg" alt="Call"/> 1800-121-0405 
                    </a>
                    <a href="mailto:support@kobster.com" class="call">
                        <img src="{$tpl_uri}img/campaigns/pantry/mail.svg" alt="Email"/> support@kobster.com 
                    </a>
                </div>
            </nav>
        </div>
    </header>
    <div class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <img src="{$tpl_uri}img/campaigns/bottomline/bottom-line-logo.png" />
                    <div class="section-lead section-content">
                        The Bottomline Talk Show is where we discuss the past, present and future of procurement and supply chain industry. The show features prominent leaders of the industry who can deliver actionable insights which can be exercised to more value to any scale of organisation.
                    </div>
                </div>
                <div class="col-4 flex-asc">
                    <div class="form-container">
                        <form id="requestForm" method="POST" class="request-form wow bounceInTop" novalidate="novalidate">
                            <div class="form-title">Register for the Talk Show</div>
                            <div class="double-column">
                                <div class="form-group firstname">
                                    <input class="form-control" type="text" id="firstname" name="firstname" placeholder="First Name">
                                </div>
                                <div class="form-group lastname">
                                    <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="designation" name="designation" placeholder="Job Title*">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" id="email" name="email" placeholder="Business E-mail*">
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="country" name="id_country">
                                    <option value="" disabled selected>Country</option>
                                    {foreach from=$countries item=data}
                                        <option value="{$data.id_country}">{$data.name}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <input type="hidden" name="bottomline" value="1" />
                            <button id="submitContact" type="submit"><span class="button-text" id="submitContactLabel">Here we go!</span></button>
                        </form>
                        <div class="contact-form-success" style="display: none">
                            <h1>Thank you for registering</h1>
                            <p>You will receive a mail with information to watch the interview when we air the show online.</p>
                            <div class="success-border"></div>
                            <div class="row">
                                <div class="col-12">
                                    <h2>Share the TalkShow</h2>
                                    <div class="social-links success-social-share" itemscope="" itemtype="http://schema.org/Organization">
                                        <link itemprop="url" href="https://www.kobster.com">
                                        <a itemprop="sameAs" 
                                            class="facebook" 
                                            href="http://www.facebook.com/sharer.php?u={$link->getPageLink('webinar')}" 
                                            target="_blank">&nbsp;</a>
                                        <a itemprop="sameAs" 
                                        class="twitter" 
                                        href="http://www.twitter.com/share?text=Kobster Webinar&url={$link->getPageLink('webinar')}" 
                                        target="_blank">&nbsp;</a>
                                        <a itemprop="sameAs" 
                                        class="linkedin" 
                                        href="https://www.linkedin.com/shareArticle?mini=true&url={$link->getPageLink('webinar')}" 
                                        target="_blank">&nbsp;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="categories-section">
        <div class="container">
            <h2 class="section-title">Upcoming Show</h2>
            <p class="section-lead">What the future of procurement demands to be successful?</p>
            <div class="card-container">
                <div class="card double-column guest">
                    <div>
                        <img src="{$tpl_uri}img/campaigns/bottomline/guest.png">
                    </div>
                    <div class="guest-info">
                        <h3>Vivek Dasasathyan</h3>
                        <h5>Head - Procurement and Labour Compliance</h5>
                        <h4>Randstad India</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="double-column air-time">
                        <img src="{$tpl_uri}img/campaigns/bottomline/calendar-icon.png">
                        <p>Tuesday, May 8th, 2018</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="brand-section">
        <div class="container">
            <h2 class="section-title">Overview</h2>
            <p class="section-lead">Uncertainty has become the only certainty common in procurement, and we expect the level of uncertainty only to increase. A new vision and capabilities are needed as we go through the transformations happening right now that separate procurement today from procurement in 2025. In this adventure, the leaders of this industry feel the responsibility to create the awareness of what the organisations have to do for procurement to be successful in the future.</p>
        </div>
    </div>

    <footer class="About">
        <div class="container">
            <div class="footer-links-container flex">
                <div class="footer-link-column">
                    <h4>Information <span class="toggle-icon">&nbsp;</span></h4>
                    <ul class="toggle-footer" style="">
                        <li><a href="{$base_dir}about.php">About Us</a></li>
                        <li><a href="{$base_dir}sell-with-us.php">Sell with Us</a></li>
                        <li><a href="{$base_dir}careers.php">Careers</a></li>
                        <li><a href="{$base_dir}blogs/" target="_blank">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-link-column">
                    <h4>Policy <span class="toggle-icon">&nbsp;</span></h4>
                    <ul class="toggle-footer" style="">
                        <li><a href="{$base_dir}index.php?controller=cms?id_cms=3">Terms and Conditions</a></li>
                        <li><a href="{$base_dir}index.php?controller=cms?id_cms=6">Privacy Policy</a></li>
                        <li><a href="{$base_dir}index.php?controller=cms?id_cms=9">Cancellation &amp; Return</a></li>
                        <li><a href="{$base_dir}index.php?controller=cms?id_cms=10">Shipping Policy</a></li>
                    </ul>
                </div>
                <div class="footer-link-column">
                    <h4>Help <span class="toggle-icon">&nbsp;</span></h4>
                    <ul class="toggle-footer" style="">
                        <li><a href="{$base_dir}contact.php">Contact Us</a></li>
                        <li><a href="{$base_dir}my-account">Your Account</a></li>
                        <li><a href="{$base_dir}index.php?controller=sitemap">Sitemap</a></li>
                    </ul>
                </div>
                <div class="footer-link-column">
                    <h4>Others <span class="toggle-icon">&nbsp;</span></h4>
                    <ul class="toggle-footer" style="">
                        <!-- <li><a href="{$base_dir}new-products">New Products</a></li> -->
                        <li><a href="{$base_dir}best-sales">Top Sellers</a></li>
                        <!-- <li><a href="{$base_dir}brands">Brands</a></li> -->
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="social-links" itemscope="" itemtype="http://schema.org/Organization">
                        <link itemprop="url" href="https://www.kobster.com">
                        <a itemprop="sameAs" class="facebook" href="http://www.facebook.com/kobsterIndia" target="_blank">&nbsp;</a>
                        <a itemprop="sameAs" class="twitter" href="http://www.twitter.com/kobsterOfficial" target="_blank">&nbsp;</a>
                        <a itemprop="sameAs" class="google-plus" href="https://plus.google.com/+KobsterIndia" target="_blank">&nbsp;</a> <a itemprop="sameAs" class="linkedin" href="https://www.linkedin.com/company/kobster" target="_blank">&nbsp;</a>
                        <a class="rss" href="https://www.kobster.com/blogs/" target="_blank">&nbsp;</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="copyright">© 2012 - 2018, Kobster.com, All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="{$tpl_uri}js/campaigns/bottomline.min.js"></script>
    <script src='//cdn.zarget.com/184811/503705.js'></script>
</body>
</html>