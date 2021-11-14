{assign var="kob_cdn" value="https://www.kobster.co/img/"}
<div id="customer_selecetor" class="container">
	

	<!-- Start Search and Offers Block -->
	<div class="home-search-block">
        <!-- Start Searchbar for both Companies and Retailers -->
		<div class="search-block searchbar">
        	<h1>Search in India's largest B2B platform.!</h1>
            <form id="searchbox-home" method="get" action="{$link->getPageLink('search', null, null, null, false, null, true)|escape:'html':'UTF-8'}" >
                <input type="hidden" name="controller" value="search" />
                <input type="hidden" name="orderby" value="position" />
                <input type="hidden" name="orderway" value="desc" />
                <input type="hidden" name="search_category" class="search_category_id" id="search_category" value="" />
                <input class="search_query search-input ac_input" type="text" id="search_query_home" name="search_query" placeholder="{l s='Type Product name or Product Code or Manufacturer code' mod=''}" value="{$search_query|escape:'htmlall':'UTF-8'|stripslashes}" autocomplete="off"/>
                <select class="form-control category-dropdown">
                    <option value="">All Categories</option>
                    {foreach from=$category_details item=category}
						if({$category.id_category} != "41200075")
							<option value="{$category.id_category}">{$category.name}</option>
                    {/foreach}
                </select>
                
                <button type="submit" name="submit_search" class="search-button">
                    <span class="sr-only">{l s='Search' mod='blocksearch'}</span>
                </button>
            </form>	
            
            <p class="home-trending-products">Trending Products:  
            	<a href="{$link->getProductLink(949310)|escape:'html':'UTF-8'}">Sandisk 16 GB Pendrive Pack of 5</a>,
                <a href="{$link->getProductLink(262640)|escape:'html':'UTF-8'}">Instapower LEDs</a>,
                <a href="{$link->getProductLink(950354)|escape:'html':'UTF-8'}">Champs Sports Shoe</a>  
            </p>	

           
           	<div class="home_slider_container"> 
                <ul id="home_slider">
                    <li>
                        <a href="{$link->getProductLink(266031)}"><img src="themes/default-bootstrap/img/home-slider/logitech.jpg"></a>
                    </li>
                    <li>
                        <a href="{$link->getProductLink(986052)}"><img src="themes/default-bootstrap/img/home-slider/HP.jpg"></a>
                    </li>
                    <li>
                        <a href="pantry.php"><img src="themes/default-bootstrap/img/home-slider/Pantry.jpg"></a>
                    </li>
                    <!--
                    <li>
                        <a href="/deals#Plumbing-deals"><img src="themes/default-bootstrap/img/home-slider/Plumbing.jpg"></a>
                    </li>
                    <li>
                        <a href="/deals?page=2#Tool-deals"><img src="themes/default-bootstrap/img/home-slider/tools.jpg"></a>
                    </li>
                    <li>
                        <a href="/wholesale-deals"><img src="themes/default-bootstrap/img/home-slider/Wholesale.jpg"></a>
                    </li>
                    <li>
                        <a href="http://www.housejoy.in"><img src="themes/default-bootstrap/img/home-slider/housejoy.jpg"></a>
                    </li>
                    -->
                </ul>
            </div>
            
            
		</div>
        <!-- End Searchbar for Retailers -->

        <!-- Start Offers Block for Company -->
        <div class="offers-block">
            <div id="offers-slider">
                <div class="slide">
                    <a href="{$link->getProductLink(986101)|escape:'html':'UTF-8'}"><img src="themes/default-bootstrap/img/home/SB1.jpg"></a>
                </div>
                <div class="slide">
                    <a href="{$link->getProductLink(986110)|escape:'html':'UTF-8'}"><img src="themes/default-bootstrap/img/home/SB2.jpg"></a>
                </div>

            </div>
		</div>
        <!-- End Offers Block for Company -->

        

    </div>
    <!-- End Search and Offers Block-->

    <!-- Popular Deals -->
    <div class="hidden popular-category-showcase row-no-padding">
    	<h2>Corporate Diwali Offers</h2>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="{$content_dir}img/menu/header-category-images/1.jpg" alt="Weekly Deals"></a>
        </div>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="{$content_dir}img/menu/header-category-images/2.jpg" alt="lighting"></a>
        </div>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="{$content_dir}img/menu/header-category-images/3.jpg" alt="taparia-brand-launch"></a>
        </div>
        <div class="popular-category-blocks">
            <a href="diwali-gifts.php" class=""><img src="{$content_dir}img/menu/header-category-images/4.jpg" alt="Mega Wholesale deals"></a>
        </div>
    </div>
    <!-- Popular Deals -->

	
    <div class="browse-categories row-no-padding">
    	<h2>Top Categories</h2>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(41201940)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-wholesale"></span> Wholesale</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41201941)|escape:'html':'UTF-8'}">Footwear</a>
                <a href="{$link->getCategoryLink(41201942)|escape:'html':'UTF-8'}">Sunglasses</a>
                <a href="{$link->getCategoryLink(41201996)|escape:'html':'UTF-8'}">Mobile &amp; Accessories</a>
                <a href="{$link->getCategoryLink(41201997)|escape:'html':'UTF-8'}">Automobile</a>
                <a href="{$link->getCategoryLink(41201998)|escape:'html':'UTF-8'}">Electronics</a>
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41202016)|escape:'html':'UTF-8'}">Watches</a>
                <a href="{$link->getCategoryLink(41202017)|escape:'html':'UTF-8'}">Plasticware</a>
                <a href="{$link->getCategoryLink(41202019)|escape:'html':'UTF-8'}">Bags</a>
                <a href="{$link->getCategoryLink(41202018)|escape:'html':'UTF-8'}">General Supplies</a>
                <a href="{$link->getCategoryLink(41201940)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(41200073)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-electrical"></span> Electrical</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41200205)|escape:'html':'UTF-8'}">LED Bulbs</a>
                <a href="{$link->getCategoryLink(41200197)|escape:'html':'UTF-8'}">LED Ceiling Lights</a>
                <a href="{$link->getCategoryLink(41200199)|escape:'html':'UTF-8'}">Street Lights</a>
                <a href="{$link->getCategoryLink(41200198)|escape:'html':'UTF-8'}">Flood Lights</a>
                <a href="{$link->getCategoryLink(41200211)|escape:'html':'UTF-8'}">High Bay Fixtures</a>
                
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41200306)|escape:'html':'UTF-8'}">Switches</a>
                <a href="{$link->getCategoryLink(41200296)|escape:'html':'UTF-8'}">Circuit Breakers</a>
                <a href="{$link->getCategoryLink(41200256)|escape:'html':'UTF-8'}">Wire &amp; Cable</a>
                <a href="{$link->getCategoryLink(41200330)|escape:'html':'UTF-8'}">Power Supply</a>
                <a href="{$link->getCategoryLink(41200073)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(4101)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-safety"></span> Safety</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(4101003)|escape:'html':'UTF-8'}">Safety Shoes</a>
                <a href="{$link->getCategoryLink(4101004)|escape:'html':'UTF-8'}">Safety Gloves</a>
                <a href="{$link->getCategoryLink(4101005)|escape:'html':'UTF-8'}">Safety Helmets</a>
                <a href="{$link->getCategoryLink(4101007)|escape:'html':'UTF-8'}">Safety Eyewear</a>
                <a href="{$link->getCategoryLink(4101013)|escape:'html':'UTF-8'}">Fall Protection</a>
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(4101011)|escape:'html':'UTF-8'}">Workwear</a>
                <a href="{$link->getCategoryLink(4101010)|escape:'html':'UTF-8'}">Hearing Protection</a>
                <a href="{$link->getCategoryLink(4101020)|escape:'html':'UTF-8'}">Safety Kits</a>
                <a href="{$link->getCategoryLink(4101012)|escape:'html':'UTF-8'}">Safety Signage</a>
                <a href="{$link->getCategoryLink(4101)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(4104)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-tools"></span> Tools</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41040113)|escape:'html':'UTF-8'}">Hand Tool sets</a>
                <a href="{$link->getCategoryLink(41040137)|escape:'html':'UTF-8'}">Screwdriver &amp; sets</a>
                <a href="{$link->getCategoryLink(41040105)|escape:'html':'UTF-8'}">Hammers</a>
                <a href="{$link->getCategoryLink(41040114)|escape:'html':'UTF-8'}">Pliers</a>
                <a href="{$link->getCategoryLink(41200072)|escape:'html':'UTF-8'}">Wrenches</a>	
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41040020)|escape:'html':'UTF-8'}">Air Blowers</a>
                <a href="{$link->getCategoryLink(41040044)|escape:'html':'UTF-8'}">Drills</a>
                <a href="{$link->getCategoryLink(41040067)|escape:'html':'UTF-8'}">Power Tool kits</a>
                <a href="{$link->getCategoryLink(41040019)|escape:'html':'UTF-8'}">Angle Grinders</a>
                <a href="{$link->getCategoryLink(4104)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(4105)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-plumbing"></span> Plumbing</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41050001)|escape:'html':'UTF-8'}">Bathroom Faucets</a>
                <a href="{$link->getCategoryLink(41050008)|escape:'html':'UTF-8'}">Kitchen Faucets</a>
                <a href="{$link->getCategoryLink(41200160)|escape:'html':'UTF-8'}">Health Faucets</a>
                <a href="{$link->getCategoryLink(41200038)|escape:'html':'UTF-8'}">Shower</a>
                <a href="{$link->getCategoryLink(41200042)|escape:'html':'UTF-8'}">Drains</a>
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41200040)|escape:'html':'UTF-8'}">Sinks &amp; Basins</a>
                <a href="{$link->getCategoryLink(41200074)|escape:'html':'UTF-8'}">Pipes &amp; Fittings</a>
                <a href="{$link->getCategoryLink(41200041)|escape:'html':'UTF-8'}">Water closet/urinals</a>
                <a href="{$link->getCategoryLink(41200037)|escape:'html':'UTF-8'}">Water Heaters</a>
                <a href="{$link->getCategoryLink(4105)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(4002)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-electronics"></span> Electronics</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(42014)|escape:'html':'UTF-8'}">PC/Laptop Accessories</a>
                <a href="{$link->getCategoryLink(42007)|escape:'html':'UTF-8'}">Printers &amp; Scanners</a>
                <a href="{$link->getCategoryLink(42012)|escape:'html':'UTF-8'}">Storage Devices</a>
                <a href="{$link->getCategoryLink(43140)|escape:'html':'UTF-8'}">Multimedia Projectors</a>
                <a href="{$link->getCategoryLink(42010)|escape:'html':'UTF-8'}">Network Peripherals</a>
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(43123)|escape:'html':'UTF-8'}">Headphones</a>
                <a href="{$link->getCategoryLink(43071)|escape:'html':'UTF-8'}">Powerbank</a>
                <a href="{$link->getCategoryLink(42008)|escape:'html':'UTF-8'}">Computer &amp; Tablets</a>
                <a href="{$link->getCategoryLink(41200192)|escape:'html':'UTF-8'}">Monitors</a>
                <a href="{$link->getCategoryLink(4002)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(4001)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-supplies"></span> Office supplies</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(42001)|escape:'html':'UTF-8'}">Stationery Supplies</a>
                <a href="{$link->getCategoryLink(42002)|escape:'html':'UTF-8'}">Writing Collection</a>
                <a href="{$link->getCategoryLink(42003)|escape:'html':'UTF-8'}">Food &amp; Breakroom</a>
                <a href="{$link->getCategoryLink(42004)|escape:'html':'UTF-8'}">Housekeeping Supplies</a>
                <a href="{$link->getCategoryLink(43001)|escape:'html':'UTF-8'}">Files &amp; Folders</a>
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(44052)|escape:'html':'UTF-8'}">Copier Papers</a>
                <a href="{$link->getCategoryLink(42007)|escape:'html':'UTF-8'}">Printers &amp; Supplies</a>
                <a href="{$link->getCategoryLink(43019)|escape:'html':'UTF-8'}">Dispensers</a>
                <a href="{$link->getCategoryLink(42011)|escape:'html':'UTF-8'}">Office Software</a>
                <a href="{$link->getCategoryLink(4001)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a href="{$link->getCategoryLink(4114)|escape:'html':'UTF-8'}"> <span class="catagory-icon catagory-icon-measuremnt"></span> Test &amp; measurement</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41200095)|escape:'html':'UTF-8'}">Multimeter</a>
                <a href="{$link->getCategoryLink(41200102)|escape:'html':'UTF-8'}">Voltage Detectors</a>
                <a href="{$link->getCategoryLink(41200056)|escape:'html':'UTF-8'}">Calipers</a>
                <a href="{$link->getCategoryLink(41200055)|escape:'html':'UTF-8'}">Measuring Tools</a>
                <a href="{$link->getCategoryLink(41200126)|escape:'html':'UTF-8'}">Light &amp; Moisture Testers</a>
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(41200121)|escape:'html':'UTF-8'}">Humidity Testers</a>
                <a href="{$link->getCategoryLink(4114004)|escape:'html':'UTF-8'}">Temperature Testers</a>
                <a href="{$link->getCategoryLink(41200113)|escape:'html':'UTF-8'}">Clamp Meter</a>
                <a href="{$link->getCategoryLink(41200103)|escape:'html':'UTF-8'}">Testers &amp; Indicators</a>
                <a href="{$link->getCategoryLink(4114)|escape:'html':'UTF-8'}" class="view_more">View More</a>
            </div>
        </div>
        
        <div class="col-md-4 home-sub-category-container">
        	<h3><a> <span class="catagory-icon catagory-icon-other"></span> More Categories</a></h3>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(4102)|escape:'html':'UTF-8'}">Hardware</a>
                <a href="{$link->getCategoryLink(4002)|escape:'html':'UTF-8'}">Electronics</a>
                <a href="{$link->getCategoryLink(4103)|escape:'html':'UTF-8'}">Security systems</a>
                <a href="{$link->getCategoryLink(4107)|escape:'html':'UTF-8'}">Paints</a>
                <a href="{$link->getCategoryLink(4112)|escape:'html':'UTF-8'}">Medical supplies</a>
            </div>
            <div class="home-sub-category">
            	<a href="{$link->getCategoryLink(4113)|escape:'html':'UTF-8'}">Lab Supplies</a>
                <a href="{$link->getCategoryLink(4110)|escape:'html':'UTF-8'}">Packing Supplies</a>
                <a href="{$link->getCategoryLink(4116)|escape:'html':'UTF-8'}">Pumps &amp; Motors</a>
                <a href="{$link->getCategoryLink(4106)|escape:'html':'UTF-8'}">Automobile Supplies</a>
                
            </div>
        </div>
        
        
    
    </div>
    
    
    <section class="product-slider">
        <div class="page-product-box blockproductscategory">
            <div class="product-slider-title">
                <h3 class="productscategory_h3">Top Selling Products</h3>
            </div>
            <div class="clearfix" >
            
                <ul class="bxslider company-slider clearfix">		
                {foreach from=$top_selling item=product key=key}
                    <li class="ajax_block_product">
                    <!-- Product Start -->
                    <div class="product-container">
                        <div class="product">
                        	<div class="product-visual">
                                <a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
                                    {if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && (!$product.available_for_order))}
                                        <div class="out-of-stock"><span>Out of stock</span></div>
                                    {/if}
                                    
                                    <img src="{$img_dir}product-preloader.gif" data-src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
                                </a>
                                <a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
                                    <span>{l s='Quick view'}</span>
                                </a>
                            </div>
                            <div class="product-name">
                                <a href="{$product.link|escape:'html':'UTF-8'}">
                                    <h3 title="{$product.name|escape:'html':'UTF-8'}">{$product.name|truncate:50:'...'|escape:'html':'UTF-8'}</h3>
                                </a>
                            </div>
                            
                            
                                                	
                            
                            <div class="product-details">
                            
                            	
                                <div class="product-standard">
                                    <div class="star_content product-rating">
                                    {section name="i" start=0 loop=5 step=1}
                                        {if $product['ratings'].grade le $smarty.section.i.index}
                                            <div class="star"></div>
                                        {else}
                                            <div class="star star_on"></div>
                                        {/if}
                                    {/section}
                                    </div>
                                   
                                    {if $product.nbComments}
                                    <div class="comments">{$product.nbComments} Reviews</div>
                                    {else}
                                    <div class="comments">{l s='No Reviews'}</div>
                                    {/if}
                                </div>
                                <div class="product-value">
                                	{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
                                    	{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
                                            {hook h="displayProductPriceBlock" product=$product type='before_price'}
                                            <div class="product-price">
                                                <span>
                                                {if ( (!$priceDisplay)  && ($product.price > 0) )}
                                                	{convertPrice price=$product.price}
                                              	{else if ( ($priceDisplay)  && ($product.price_tax_exc > 0) )}
                                                	{convertPrice price=$product.price_tax_exc}
                                                {/if}
                                                </span>
                                            </div>
                                        {/if}
                                    
                                        {assign var="reduction_amount" value=$product.price_without_reduction-$product.price}
                            			{if ($reduction_amount > 0)}
                                        <div class="market-price">
                                            {if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
                                                {hook h="displayProductPriceBlock" product=$product type="old_price"}
                                                	<meta itemprop="priceCurrency"/>
                                                	<span class="retail-price">{convertPrice price=$product.price_without_reduction}</span>
                                                {hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
                                                {*{if $product.specific_prices.reduction_type == 'percentage'} 
                                                	<span class="offer-percentage" itemprop="offer" itemscope itemtype="https://schema.org/Offer">{($product.specific_prices.reduction * 100)|ceil}%</span>
                                                {/if}
                                                {if $product.specific_prices.reduction_type == 'amount'} 
                                                    <span class="offer-percentage" itemprop="offer" itemscope itemtype="https://schema.org/Offer">{($product.specific_prices.reduction * 100/$product.price_without_reduction)|ceil}%</span>
                                                {/if}*}
                                            {/if} 
                                        </div>
                                        {/if}
                                	{/if}
                                </div>
                                
                                
                                
                            </div>
                            <div class="product-actions">
                            
                            	{if ((!$priceDisplay) && ($product.price <= 0))}
                                	<button class="button-outline" onclick="online_chat();">Contact us for price</button>
                                {else if (($priceDisplay) && ($product.price_tax_exc <= 0))}
                                	<button class="button-outline" onclick="online_chat();">Contact us for price</button>
                                {else}
                                
                                {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
                                <div class="product-quantity">
                                    <div class="product-quantity-row">
                                        <span data-toggle="tooltip" data-placement="top" title="Minimum Order Quantity">MOQ : {$product.minimal_quantity}</span>
                                        <div class="product-quantity-selector">
                                            <a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-minus product_quantity_down">-</a><input type="number" min="1" name="qty" data-field-qtyAvailable="{$product.quantity}" data-field-quantity="{$product.minimal_quantity}"  id="quantity_wanted_{$product.id_product}" class="text numbersOnly" value="{if $product.minimal_quantity > 1}{$product.minimal_quantity}{else}1{/if}" ><a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-plus product_quantity_up">+</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-to-cart">
                                    {if (!isset($product.customization_required) || !$product.customization_required) && $product.allow_oosp}
                                        {capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
                                        <button class="ajax_add_to_cart_button" title="{l s='Add to cart'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
                                            {l s='Add to cart'}
                                        </button>
                                    {else}
                                        <button class="ajax_add_to_cart_button disabled">
                                            {l s='Add to cart'}
                                        </button>
                                    {/if}
                                </div>
                                {/if}
                                
                                {/if} {* Zero pricing content ends here *}
                                
                            </div>
                        </div>
                    </div>
                    <!-- Product End --> 
                    </li>
                {/foreach}		
                </ul>
            </div>
        </div>
    </section>
   
    
   <div class="top-brands row-no-padding">
    	<h2>Top Brands</h2>
        <a href="{$link->getmanufacturerLink(163)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="taparia" src="{$img_dir}top-brands/taparia.jpg" alt="Taparia" title="Taparia" />
        </a>
        <a href="{$link->getmanufacturerLink(588)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="fluke" src="{$img_dir}top-brands/fluke.jpg" alt="Fluke" title="Fluke" />
        </a>
        <a href="{$link->getmanufacturerLink(164)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="bosch" src="{$img_dir}top-brands/bosch.jpg" alt="Bosch" title="Bosch" />
        </a>
        <a href="{$link->getmanufacturerLink(463)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="Schneider" src="{$img_dir}top-brands/Schneider.jpg" alt="Schneider" title="Schneider" />
        </a>
        <a href="{$link->getmanufacturerLink(292)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="havells" src="{$img_dir}top-brands/havells.jpg" alt="Havells" title="Havells" />
        </a>
        <a href="{$link->getmanufacturerLink(285)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="karam" src="{$img_dir}top-brands/karam.jpg" alt="Karam" title="Karam" />
        </a>
        <a href="{$link->getmanufacturerLink(331)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="cumi" src="{$img_dir}top-brands/cumi.jpg" alt="CUMI" title="CUMI" />
        </a>
        <a href="{$link->getmanufacturerLink(464)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="jackly" src="{$img_dir}top-brands/jackly.jpg" alt="Jackly" title="Jackly" />
        </a>
        <a href="{$link->getmanufacturerLink(334)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="instapower" src="{$img_dir}top-brands/instapower.jpg" alt="Instapower" title="Instapower" />
        </a>
        <a href="{$link->getmanufacturerLink(40)|escape:'html':'UTF-8'}" class="home-brand-container">
        	<img class="JK-Paper" src="{$img_dir}top-brands/JK-Paper.jpg" alt="JK Paper Ltd" title="JK Paper Ltd" />
        </a>
    </div>
    
    <!-- End Benefits Block -->
	<div class="benefits-block row-no-padding">
        <!-- Start Benefits for Retailer -->
		<div class="benefits-container reseller" >
        	<h3>Benefits for Retailer</h3>
			<div class="benefit">
            	<div class="title">
                	<div class="icon flexible-payment-icon"></div>
                    <p>Flexible Payment Terms & MOQ</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Buy Now, Pay Later. Long Credit Periods</li>
                    <li>Flexible MOQs at same best price</li>
                </ul>
            </div>
            
            <div class="benefit">
            	<div class="title">
                	<div class="icon flexible-moq-icon"></div>
                    <p>Direct from Brand</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Get unbelievable prices</li>
					<li>Access to new Products in the market</li>
					<li>Enjoy great schemes</li>
                </ul>
            </div>
            
            <div class="benefit">
            	<div class="title">
                	<div class="icon direct-shipment-icon"></div><p>Direct Shipment to Customers</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Ship directly to your customers</li>
                    <li>Save costs on Logistics</li>
                </ul>
            </div>
            
            <div class="benefit">
            	<div class="title">
                	<div class="icon return-policy-icon"></div><p>Unbelievable Return Policy</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Return of Unsold Goods</li>
                    <li>Stock Clearance Support</li>
                    <li>Extension of Credit Days</li>
                </ul>
            </div>
		</div>
        <!-- End Benefits for Retailer -->
        
        <!-- Start Benefits for Company -->
		<div class="benefits-container company" >
            <h3>Benefits for Company</h3>
            <div class="benefit">
                <div class="title">
                    <div class="icon flexible-payment-icon"></div>
                    <p>Centralized Sourcing</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Pan India Delivery Network</li>
                    <li>Consolidate Sourcing to Save Cost</li>
					<li>Repeat your Orders</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon flexible-moq-icon"></div>
                    <p>Great Options - Great Prices</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Lakhs of Genuine Products</li>
					<li>Thousands of Brands</li>
					<li>Best Prices for Bulk Purchase</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon direct-shipment-icon"></div><p>Kobster Elite Procurement Tool</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Customized e-procurement Tool</li>
                    <li>Approval Workflows</li>
                    <li>Track expenses, Reports, Analytics and Savings</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon return-policy-icon"></div><p>On-time Delivery</p>
                </div>
                <ul class="key-benefits dash">
                    <li>100% On-Time Delivery</li>
                    <li>Pan India Coverage</li>
                    <li>Question Free Return Policy</li>
                </ul>
            </div>
        </div>
        <!-- End Benefits for Company -->

	</div>
    <!-- End Benefits Block -->
    </div>



    

    

    