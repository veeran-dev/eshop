<!-- Start Fixed Width Section -->
<section class="container-fluid">
    <div>
       <a href=""><img class="img-responsive deals_banner" src="themes/default-bootstrap/img/deals/{$banners.hero_banner}"></a>
    </div>
	<div>
       <a href="#{$deals_hash.1}" class="deals-smooth-scroll col-md-3 col-sm-6"><img class="img-responsive center" src="themes/default-bootstrap/img/deals/{$banners.small_banner1}"></a>

       <a href="#{$deals_hash.2}" class="deals-smooth-scroll col-md-3 col-sm-6"><img class="img-responsive center" src="themes/default-bootstrap/img/deals/{$banners.small_banner2}"></a>

       <a href="#{$deals_hash.3}" class="deals-smooth-scroll col-md-3 col-sm-6"><img class="img-responsive center" src="themes/default-bootstrap/img/deals/{$banners.small_banner3}"></a>

       <a href="#{$deals_hash.4}" class="deals-smooth-scroll col-md-3 col-sm-6"><img class="img-responsive center" src="themes/default-bootstrap/img/deals/{$banners.small_banner4}"></a>
    </div>


</section>
<!-- End Fixed Width Section -->



<!--Start Product Slider -->
    
<section class="container-fluid deals_content {$deals_hash.1}">
    <span id="{$deals_hash.1}" class="dummy_url"> &nbsp; </span>
    <h1>{$deals_title.1}</h1>
    <ul id="product_list_grid" class="product_list grid">		
    {foreach from=$deals.1 item=product key=key}
        <li class="ajax_block_product">
        <!-- Product Start -->
        <div class="product-container">
            <div class="product">
                <div class="product-visual">
                    <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
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
                                    {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
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
                    {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
                    <div class="product-quantity">
                        <div class="product-quantity-row">
                            <span data-toggle="tooltip" data-placement="top" title="Minimum Order Quantity">MOQ : {$product.minimal_quantity}</span>
                            <div class="product-quantity-selector">
                                <a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-minus product_quantity_down_deals">-</a><input type="number" min="1" name="qty" data-field-qtyAvailable="{$product.quantity}" data-field-quantity="{$product.minimal_quantity}" class="text numbersOnly quantity_wanted_{$product.id_product}" value="{if $product.minimal_quantity > 1}{$product.minimal_quantity}{else}1{/if}" ><a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-plus product_quantity_up_deals">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="add-to-cart">
                        {if (!isset($product.customization_required) || !$product.customization_required) && $product.allow_oosp}
                            {capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
                            <button class="ajax_add_to_cart_button_deals ghost_button" title="{l s='Add to cart'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
                                {l s='Add to cart'}
                            </button>
                        {else}
                            <button class="ajax_add_to_cart_button_deals disabled">
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
            
</section>


<section class="container-fluid deals_content {$deals_hash.2}">
    <span id="{$deals_hash.2}" class="dummy_url"> &nbsp; </span>
    <h1>{$deals_title.2}</h1>
    <ul id="product_list_grid" class="product_list grid">		
    {foreach from=$deals.2 item=product key=key}
        <li class="ajax_block_product">
        <!-- Product Start -->
        <div class="product-container">
            <div class="product">
                <div class="product-visual">
                    <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
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
                                    {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
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
                    {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
                    <div class="product-quantity">
                        <div class="product-quantity-row">
                            <span data-toggle="tooltip" data-placement="top" title="Minimum Order Quantity">MOQ : {$product.minimal_quantity}</span>
                            <div class="product-quantity-selector">
                                <a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-minus product_quantity_down_deals">-</a><input type="number" min="1" name="qty" data-field-qtyAvailable="{$product.quantity}" data-field-quantity="{$product.minimal_quantity}" class="text numbersOnly quantity_wanted_{$product.id_product}" value="{if $product.minimal_quantity > 1}{$product.minimal_quantity}{else}1{/if}" ><a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-plus product_quantity_up_deals">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="add-to-cart">
                        {if (!isset($product.customization_required) || !$product.customization_required) && $product.allow_oosp}
                            {capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
                            <button class="ajax_add_to_cart_button_deals ghost_button" title="{l s='Add to cart'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
                                {l s='Add to cart'}
                            </button>
                        {else}
                            <button class="ajax_add_to_cart_button_deals disabled">
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

</section>

<section class="container-fluid deals_content {$deals_hash.3}">
    <span id="{$deals_hash.3}" class="dummy_url"> &nbsp; </span>
    <h1>{$deals_title.3}</h1>
    <ul id="product_list_grid" class="product_list grid">		
    {foreach from=$deals.3 item=product key=key}
        <li class="ajax_block_product">
        <!-- Product Start -->
        <div class="product-container">
            <div class="product">
                <div class="product-visual">
                    <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
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
                                    {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
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
                    {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
                    <div class="product-quantity">
                        <div class="product-quantity-row">
                            <span data-toggle="tooltip" data-placement="top" title="Minimum Order Quantity">MOQ : {$product.minimal_quantity}</span>
                            <div class="product-quantity-selector">
                                <a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-minus product_quantity_down_deals">-</a><input type="number" min="1" name="qty" data-field-qtyAvailable="{$product.quantity}" data-field-quantity="{$product.minimal_quantity}" class="text numbersOnly quantity_wanted_{$product.id_product}" value="{if $product.minimal_quantity > 1}{$product.minimal_quantity}{else}1{/if}" ><a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-plus product_quantity_up_deals">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="add-to-cart">
                        {if (!isset($product.customization_required) || !$product.customization_required) && $product.allow_oosp}
                            {capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
                            <button class="ajax_add_to_cart_button_deals ghost_button" title="{l s='Add to cart'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
                                {l s='Add to cart'}
                            </button>
                        {else}
                            <button class="ajax_add_to_cart_button_deals disabled">
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

</section>

<section class="container-fluid deals_content {$deals_hash.4}">
    <span id="{$deals_hash.4}" class="dummy_url"> &nbsp; </span>
    <h1>{$deals_title.4}</h1>
    <ul id="product_list_grid" class="product_list grid">		
    {foreach from=$deals.4 item=product key=key}
        <li class="ajax_block_product">
        <!-- Product Start -->
        <div class="product-container">
            <div class="product">
                <div class="product-visual">
                    <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
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
                                    {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
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
                    {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
                    <div class="product-quantity">
                        <div class="product-quantity-row">
                            <span data-toggle="tooltip" data-placement="top" title="Minimum Order Quantity">MOQ : {$product.minimal_quantity}</span>
                            <div class="product-quantity-selector">
                                <a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-minus product_quantity_down_deals">-</a><input type="number" min="1" name="qty" data-field-qtyAvailable="{$product.quantity}" data-field-quantity="{$product.minimal_quantity}" class="text numbersOnly quantity_wanted_{$product.id_product}" value="{if $product.minimal_quantity > 1}{$product.minimal_quantity}{else}1{/if}" ><a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-plus product_quantity_up_deals">+</a>
                            </div>
                        </div>
                    </div>
                    <div class="add-to-cart">
                        {if (!isset($product.customization_required) || !$product.customization_required) && $product.allow_oosp}
                            {capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
                            <button class="ajax_add_to_cart_button_deals ghost_button" title="{l s='Add to cart'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
                                {l s='Add to cart'}
                            </button>
                        {else}
                            <button class="ajax_add_to_cart_button_deals disabled">
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

</section>



<!--End Product Slider -->
