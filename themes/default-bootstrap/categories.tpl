<!-- Start Fixed Width Section -->
<section id="category_head">
    <div class="showcase-row">
        <!-- Start Primary Image Slider -->
        <div class="primary-slider">
            <ul id="allCategory_slider" class="card">
                {foreach $category_slider as $key => $slider}
                <li>
                    <a href=""><img src="themes/default-bootstrap/img/all-category/slider/{$slider}"></a>
                </li>
                {/foreach}
            </ul>
        </div>
        <!--End Primary Image Slider -->

        <!--Start Display First -->
        <div class="fixed-display">
            <h3>Lorem Ipsum</h3>
        </div>
        <!--End Display First -->
        
        <!--Start Display First -->
        <div class="fixed-display">
            <h3>Lorem Ipsum</h3>
        </div>
        <!--End Display First -->
        
        <!--Start Most Searched Products -->
        <!-- <div class="col-md-3">
            <div class="category_msp card">
            <h3 class="small_title">Most Searched Products</h3>
            <ol class="ml10">
            {foreach $most_searched as $key => $msp}
            <li><a href="index.php?id_product={$msp.id_product}&controller=product&id_lang=1">{$msp.product_name}</a></li>
            {/foreach}
            </ol>
            </div> 
        </div> -->
        <!--End Most Searched Products -->
    </div>

    <div class="showcase-row">
        {foreach $subCategory_list as $key => $subCategory}
            <div class="category-showcase">
                <div class="main-category">
                    <h2 class="big_title">
                        Category Title
                    </h2>
                    <a href="index.php?id_category={$subCategory.subCategory_id}&controller=category&id_lang=1"><img class="img-responsive" src="themes/default-bootstrap/img/all-category/{$subCategory.subCategory_image}" /></a>
                    <h3 class="small_title"><a href="index.php?id_category={$subCategory.subCategory_id}&controller=category&id_lang=1">{$subCategory.name}</a></h3>
                    <p>{$subCategory.description} <a class="blue_link" href="index.php?id_category={$subCategory.subCategory_id}&controller=category&id_lang=1">See more</a></p>
                </div>

                <div class="secondary-category">
                    {foreach $subCategory.associated_products as $key => $associated_products}
                        <a href="index.php?id_product={$key}&controller=product&id_lang=1">
                            <img class="img-responsive" src="themes/default-bootstrap/img/all-category/products/{$associated_products}" />
                        </a>
                    {/foreach}
                </div>
            </div>

            <div class="brand-showcase">
                <ul class="brand_carousel">
                    {foreach $subCategory.associated_brands as $key => $associated_brands}
                        <li>
                            <a href="index.php?id_manufacturer={$associated_brands}&controller=manufacturer&id_lang=1">
                                <img class="img-responsive" src="img/m/{$associated_brands}-medium_default.jpg" />
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </div>
        {/foreach}
    </div>
    <!-- End Secondary Section -->

<!-- 
<div class="showcase-row">
    <div class="category-showcase-wrapper">
        {foreach $subCategory_list_nb as $key => $subCategory_nb}
            <div class="category-showcase-half card">
                <div class="main-category">
                    <a href="index.php?id_category={$subCategory_nb.subCategory_id}&controller=category&id_lang=1"><img class="img-responsive" src="themes/default-bootstrap/img/all-category/{$subCategory_nb.subCategory_image}" /></a>
                    <h2 class="small_title"><a href="index.php?id_category={$subCategory_nb.subCategory_id}&controller=category&id_lang=1">{$subCategory_nb.name}</a></h2>
                    <p>{$subCategory_nb.description} <a href="index.php?id_category={$subCategory_nb.subCategory_id}&controller=category&id_lang=1" class="blue_link pull-right" >See more</a></p>
                </div>

                <div class="secondary-category">
                    {foreach $subCategory_nb.associated_products as $key => $associated_products_nb}
                        <a href="index.php?id_product={$key}&controller=product&id_lang=1">
                            <img class="img-responsive" src="themes/default-bootstrap/img/all-category/products/{$associated_products_nb}" />
                        </a>
                    {/foreach}
                </div>
            </div>
        {/foreach}
    </div>

    <div class="offer-showcase-wrapper ">
        <div class="card">
            <h3>Lorem Ipsum</h3>
        </div>
        <div class="card">
            <h3>Lorem Ipsum</h3>
        </div>
    </div>
</div>
-->

</section>
<!-- End Fixed Width Section -->

 <!-- Start Product Slider -->   
<section class="product-slider">
    <div class="page-product-box blockproductscategory">
        <div class="product-slider-title">
        	<h3 class="productscategory_h3">
        		<span id="company-category-one"> &nbsp; </span>Top Selling Products
        	</h3>
        	
        </div>
        <div class="clearfix" id="productscategory_list">
            <ul id="bxslider1" class="bxslider company-slider clearfix">		
            {foreach from=$top_selling item=product key=key}
                <li class="ajax_block_product">
                <!-- Product Start -->
                <div class="product-container">
                    <div class="product">
                    	<div class="product-visual">
                            <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
                                {if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && (!$product.available_for_order))}
                                    <div class="out-of-stock"><span>Out of stock</span></div>
                                {/if}
                                <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
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
                                            {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
                                            </span>
                                        </div>
                                    {/if}
                                
                                    <div class="market-price">
                                        {if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
                                            {hook h="displayProductPriceBlock" product=$product type="old_price"}
                                            	<meta itemprop="priceCurrency"/>
                                            	<span class="retail-price">{displayWtPrice p=$product.price_without_reduction}</span>
                                            {hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
                                            {if $product.specific_prices.reduction_type == 'percentage'} 
                                            	<span class="offer-percentage" itemprop="offer" itemscope itemtype="https://schema.org/Offer">{$product.specific_prices.reduction * 100}%</span>
                                            {/if}
                                        {/if} 
                                    </div>
                            	{/if}
                            </div>
                        </div>
                        <div class="product-actions">
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
<!--End Product Slider -->

<!--Start Product Slider -->
    
<section class="product-slider container-fluid">
    <div class="page-product-box blockproductscategory">
        <div class="product-slider-title">
        	<h3 class="productscategory_h3">
        		<span id="company-category-one"> &nbsp; </span>Top Viewed Products
        	</h3>
        </div>
        <div class="clearfix" id="productscategory_list">
            <ul id="bxslider1" class="bxslider company-slider clearfix">		
            {foreach from=$top_viewed item=product key=key}
                <li class="ajax_block_product">
                <!-- Product Start -->
                <div class="product-container">
                    <div class="product">
                    	<div class="product-visual">
                            <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
                                {if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && (!$product.available_for_order))}
                                    <div class="out-of-stock"><span>Out of stock</span></div>
                                {/if}
                                <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
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
                                            {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
                                            </span>
                                        </div>
                                    {/if}
                                
                                    <div class="market-price">
                                        {if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
                                            {hook h="displayProductPriceBlock" product=$product type="old_price"}
                                            	<meta itemprop="priceCurrency"/>
                                            	<span class="retail-price">{displayWtPrice p=$product.price_without_reduction}</span>
                                            {hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
                                            {if $product.specific_prices.reduction_type == 'percentage'} 
                                            	<span class="offer-percentage" itemprop="offer" itemscope itemtype="https://schema.org/Offer">{$product.specific_prices.reduction * 100}%</span>
                                            {/if}
                                        {/if} 
                                    </div>
                            	{/if}
                            </div>
                        </div>
                        <div class="product-actions">
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
<!--End Product Slider -->

<!--Start Product Slider -->    
<section class="product-slider">
    <div class="page-product-box blockproductscategory">
        <div class="product-slider-title">
        	<h3 class="productscategory_h3">
        		<span id="company-category-one"> &nbsp; </span>Top Discounted Products
        	</h3>

        </div>
        <div class="clearfix" id="productscategory_list">
            <ul id="bxslider1" class="bxslider company-slider clearfix">		
            {foreach from=$top_discounted item=product key=key}
                <li class="ajax_block_product">
                <!-- Product Start -->
                <div class="product-container">
                    <div class="product">
                    	<div class="product-visual">
                            <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
                                {if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && (!$product.available_for_order))}
                                    <div class="out-of-stock"><span>Out of stock</span></div>
                                {/if}
                                <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
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
                                            {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
                                            </span>
                                        </div>
                                    {/if}
                                
                                    <div class="market-price">
                                        {if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
                                            {hook h="displayProductPriceBlock" product=$product type="old_price"}
                                            	<meta itemprop="priceCurrency"/>
                                            	<span class="retail-price">{displayWtPrice p=$product.price_without_reduction}</span>
                                            {hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
                                            {if $product.specific_prices.reduction_type == 'percentage'} 
                                            	<span class="offer-percentage" itemprop="offer" itemscope itemtype="https://schema.org/Offer">{$product.specific_prices.reduction * 100}%</span>
                                            {/if}
                                        {/if} 
                                    </div>
                            	{/if}
                            </div>
                        </div>
                        <div class="product-actions">
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
<!--End Product Slider -->

<!--Start Product Slider -->    
<section class="product-slider">
    <div class="page-product-box blockproductscategory">
        <div class="product-slider-title">
        	<h3 class="productscategory_h3">
        		<span id="company-category-one"> &nbsp; </span>Kobster Recommended Products
        	</h3>

        </div>
        <div class="clearfix" id="productscategory_list">
            <ul id="bxslider1" class="bxslider company-slider clearfix">		
            {foreach from=$kobster_recommented item=product key=key}
                <li class="ajax_block_product">
                <!-- Product Start -->
                <div class="product-container">
                    <div class="product">
                    	<div class="product-visual">
                            <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
                                {if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && (!$product.available_for_order))}
                                    <div class="out-of-stock"><span>Out of stock</span></div>
                                {/if}
                                <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
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
                                            {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
                                            </span>
                                        </div>
                                    {/if}
                                
                                    <div class="market-price">
                                        {if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
                                            {hook h="displayProductPriceBlock" product=$product type="old_price"}
                                            	<meta itemprop="priceCurrency"/>
                                            	<span class="retail-price">{displayWtPrice p=$product.price_without_reduction}</span>
                                            {hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
                                            {if $product.specific_prices.reduction_type == 'percentage'} 
                                            	<span class="offer-percentage" itemprop="offer" itemscope itemtype="https://schema.org/Offer">{$product.specific_prices.reduction * 100}%</span>
                                            {/if}
                                        {/if} 
                                    </div>
                            	{/if}
                            </div>
                        </div>
                        <div class="product-actions">
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
<!--End Product Slider -->

<!-- JS Script Included for Charts -->
<!-- <script type="text/javascript" src="/themes/default-bootstrap/js/all-category-chart.js"></script> -->