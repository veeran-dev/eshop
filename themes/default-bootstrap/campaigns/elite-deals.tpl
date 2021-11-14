<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Online Office Pantry Supplies & Equipment at Best Price | Kobster</title>
    <meta name="description" content="Get instant access to healthy snacks and beverages for your office pantry at competitive prices in Chennai, Bangalore, Mumbai, Hyderabad and Delhi.">
    <meta name="author" content="Kobster">
    <link href="https://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet">
    <link rel="stylesheet" href="{$tpl_uri}css/campaigns/elite-deals.min.css" type="text/css" media="{$media|escape:'html':'UTF-8'}" /> 
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
    <div class="categories-section">
        <div class="container">
            <h2 class="section-title">Upto 25 - 50% Discount</h2>
            <p class="section-lead">ON ALL AVAILABLE PRODUCTS</p>
            <div class="filter-section" id="product-section">
                <div class="filter-container">
                    <div class="wrapper">
                        {foreach $fc as $centre}
                            <a href="/elite-deals?id_fc={$centre['id_fulfillment_centre']}#product-section" class={($centre['id_fulfillment_centre']==$id_fc) ? 'active':''}>{$centre['city_name']}</a>
                        {/foreach}
                    </div>
                </div>
                <div class="cart-container">
                    <div class="cart">
                        <div class="icon"><img src="{$tpl_uri}img/campaigns/elite-deals/cart.svg"><span class="count">0</span></div>
                    </div>
                    <div class="cart-box">
                        <div class="header">
                            <h3>Your Products</h3>
                            <p>You have selected <span class="count">0</span> items</p>
                        </div>
                        <div class="items-list">
                            
                        </div>
                        <div class="button-wrapper">
                            <button href="#" onclick="submitForm();">Get Quote</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="brand-slider owl-carousel owl-theme">
            {assign var=k value=0}
            {assign var=l value=0}
            {assign var=j value=$products|@count}
            {while $j>0}
                <div class="brand-slider-item item">
                    <div class="wrapper" >
                    {while $k<20 && $j>0}
                        <div class="product">
                            <div class="topSection">
                                <div class="select-product">
                                    <input type="checkbox" class="selectProduct" id="selectProduct{$products[$l]['id_product']}" name="selectProduct" value="{$products[$l]['id_product']}" disabled>
                                    <label for="selectProduct{$products[$l]['id_product']}"></label>
                                </div>
                                <div class="stock">
                                    <div class="number">{if $products[$l]['total']>9999}9999{else}{$products[$l]['total']}{/if}</div>
                                    <div class="text">Available</div>
                                </div>
                            </div>
                            <div class="image">
                                <img src={$products[$l]['imageLink2']} />
                            </div>
                            <div class="product-details">
                                <p class="product-name" id="{$products[$l]['id_product']}_name">{$products[$l]['name']}</p>
                                <p class="price">Rs. {$products[$l]['price']|string_format:"%.2f"}</p>
                                <button id="{$products[$l]['id_product']}_add" class="addProduct">Get Quote</button>
                            </div>
                        </div>                        
                    {assign var=j value=$j-1}
                    {assign var=k value=$k+1}
                    {assign var=l value=$l+1}
                    {/while}
                    {assign var=k value=0}
                    </div>
                </div>
                {/while}
            </div>
        </div>
        <ul id="snackbar-wrapper"></ul>
    </div>
    <footer>
        <div class="container">
            <div class="footer-pattern">
                <img src="{$tpl_uri}img/campaigns/pantry/city-pattern.png" />
            </div>
            <div class="footer-links-container flex">
                <div class="footer-link-column">
                    <div class="wrapper">
                        <img src="{$tpl_uri}img/campaigns/pantry/free-shipping.png" />
                        <img src="{$tpl_uri}img/campaigns/pantry/credit.png" />
                    </div>
                </div>
                <div class="footer-link-column">
                    <ul>
                        <li><a href="https://www.kobster.com/about.php">About</a></li>
                        <li><a href="https://www.kobster.com/careers.php">Careers</a></li>
                        <li><a href="https://www.kobster.com/contact.php">Contact</a></li>
                        <li>
                            <div class="social-links" itemscope="" itemtype="http://schema.org/Organization"><link itemprop="url" href="https://www.kobster.com"> <a itemprop="sameAs" class="facebook" href="http://www.facebook.com/kobsterIndia" target="_blank">&nbsp;</a> <a itemprop="sameAs" class="twitter" href="http://www.twitter.com/kobsterOfficial" target="_blank">&nbsp;</a> <a itemprop="sameAs" class="google-plus" href="https://plus.google.com/+KobsterIndia" target="_blank">&nbsp;</a> <a itemprop="sameAs" class="linkedin" href="https://www.linkedin.com/company/kobster" target="_blank">&nbsp;</a> <a class="rss" href="https://www.kobster.com/blogs/" target="_blank">&nbsp;</a></div>
                        </li>
                    </ul>
                </div>
                <div class="footer-link-column">
                    <ul>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=6">Privacy Policy</a></li>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=3">Terms and Conditions</a></li>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=9">Cancellation and Return</a></li>
                        <li><a href="https://www.kobster.com/index.php?controller=cms?id_cms=10">Shipping Policy</a></li>
                    </ul>
                </div>
            </div>
            <p class="copyright">&copy; <a href="https://www.kobster.com" target="_blank">Kobster.com</a> 2018. All rights reserved.</p>
        </div>
    </footer>
    <script src="{$tpl_uri}js/campaigns/elite-deals.min.js"></script>
    <script src='//cdn.zarget.com/184811/503705.js'></script>
</body>
</html>