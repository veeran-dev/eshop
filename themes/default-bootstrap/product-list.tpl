{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if isset($products) && $products}
	{*define number of products per line in other page for desktop*}
	{if $page_name !='index' && $page_name !='product'}
		{assign var='nbItemsPerLine' value=3}
		{assign var='nbItemsPerLineTablet' value=2}
		{assign var='nbItemsPerLineMobile' value=3}
	{else}
		{assign var='nbItemsPerLine' value=4}
		{assign var='nbItemsPerLineTablet' value=3}
		{assign var='nbItemsPerLineMobile' value=2}
	{/if}
	{*define numbers of product per line in other page for tablet*}
	{assign var='nbLi' value=$products|@count}
	{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
	{math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}
	<!-- Products list -->
	<ul id="product_list_grid" class="product_list grid{if isset($class) && $class} {$class}{/if}">
	{foreach from=$products item=product name=products}
		{math equation="(total%perLine)" total=$smarty.foreach.products.total perLine=$nbItemsPerLine assign=totModulo}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineMobile assign=totModuloMobile}
		{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
		{if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
		{if $totModuloMobile == 0}{assign var='totModuloMobile' value=$nbItemsPerLineMobile}{/if}
		<li class="ajax_block_product">
			 <!-- Product Start -->
                <div class="product-container">
                    <div class="product">
                    	<div class="product-visual">
                            <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
                                {if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && !$product.available_for_order)}
                                    <div class="out-of-stock"><span>Out of stock</span></div>
                                {/if}
                                <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}" href="{$product.link|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
                            </a>
                            
                            <a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
                                <span>{l s='Quick view'}</span>
                            </a>
                        </div>
                        <div class="product-name">
                            <a href="{$product.link|escape:'html':'UTF-8'}">
                                <h3 itemprop="name" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">{$product.name|truncate:50:'...'|escape:'html':'UTF-8'}</h3>
                            </a>
                        </div>
                        <div class="product-details">
                            <div class="product-standard">
                                <div class="star_content product-rating"  itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
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
                                            <span itemprop="price">
                                                {if $mobile_device}
                                                    {if $product.price>0}
                                                        {if !$priceDisplay}
                                                            {* ₹ {$product.price|number_format:0} *}
                                                            {convertPrice price=$product.price}
                                                            
                                                        {else}
                                                            {* ₹ {$product.price_tax_exc|number_format:0} *}
                                                            {convertPrice price=$product.price_tax_exc}
                                                        {/if}
                                                    {else}
                                                        <a onclick="online_chat();">{l s='Contact us for price'}</a>
                                                    {/if}
                                                {else}
                                                    {if $product.price>0}
                                                        {if !$priceDisplay}
                                                            {* ₹ {$product.price|number_format:0} *}
                                                            {convertPrice price=$product.price}
                                                        {else}
                                                            {* ₹ {$product.price_tax_exc|number_format:0} *}
                                                            {convertPrice price=$product.price_tax_exc}
                                                        {/if}
                                                    {/if}
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
                                            	<span class="offer-percentage" itemprop="offers" itemscope itemtype="https://schema.org/Offer">{($product.specific_prices.reduction * 100)|ceil}%</span>
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
                            {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE && $product.price>0}
                            <div class="product-quantity">
                                <div class="product-quantity-row">
                                    <span data-toggle="tooltip" data-placement="top" title="Minimum Order Quantity">MOQ : {$product.minimal_quantity}</span>
                                    <div class="product-quantity-selector">
                                        <a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-minus product_quantity_down">-</a><input  maxlength=5 size=5 type="number" min="1" name="qty" data-field-qtyAvailable="{$product.quantity}" data-field-quantity="{$product.minimal_quantity}"  id="quantity_wanted_{$product.id_product}" class="text numbersOnly" value="{if $product.minimal_quantity > 1}{$product.minimal_quantity}{else}1{/if}" ><a href="#" data-field-qty="qty" data-field-id="{$product.id_product}" class="btn btn-default button-plus product_quantity_up">+</a>
                                    </div>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                {if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
                                    {capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
                                    <button class="ajax_add_to_cart_button" href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
                                        {l s='Add to cart'}
                                    </button>
                                {else}
                                    <button class="ajax_add_to_cart_button disabled">
                                        {l s='Add to cart'}
                                    </button>
                                {/if}
                            </div>
                            {else}
                            <div class="contact_us"><button class="button-outline" onclick="online_chat();">Contact us for price</button></div>
                            {/if}
                        </div>
                        <div class="functional-buttons clearfix">
                            {hook h='displayProductListFunctionalButtons' product=$product}
                            {if isset($comparator_max_item) && $comparator_max_item}
                                <div class="compare">
                                    <a class="add_to_compare" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}">{l s='Add to Compare'}</a>
                                </div>
                            {/if}
                        </div>
                        
                    </div>
                </div>
                <!-- Product End --> 
		</li>
	{/foreach}
	</ul>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}
