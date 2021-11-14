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
{if count($categoryProducts) > 0 && $categoryProducts !== false}
<section class="product-slider">
<div class="page-product-box blockproductscategory">
    <div class="product-slider-title">
        <h3 class="productscategory_h3">
            {if $categoryProducts|@count == 1}
                {l s='Related Products' sprintf=[$categoryProducts|@count] mod='productscategory'}
            {else}
                {l s='Related Products' sprintf=[$categoryProducts|@count] mod='productscategory'}
            {/if}
        </h3>
    </div>
	<div id="productscategory_list" class="clearfix">
		<ul class="bxslider clearfix">
		{foreach from=$categoryProducts item='product' name=product}
			<li class="product-box item">
				<div class="product-container">
                    <div class="product">
                        <div class="product-visual">
                            <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
                                <img class="" src="{$img_dir}product-preloader.gif" data-src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')|escape:'html':'UTF-8'}" href="{$product.link|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
                            </a>
                            {if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && (!$product.available_for_order || $product.quantity <= 0))}
                                <div class="out-of-stock"><span>Out of stock</span></div>
                            {/if}
                            <a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
                                <span>{l s='Quick view'}</span>
                            </a>
                        </div>
                        <div class="product-name">
                        	<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
                            <h3 itemprop="name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">{$product.name|truncate:50:'...'|escape:'html':'UTF-8'}</h3>
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
                                                <span class="offer-percentage" itemprop="offers" itemscope itemtype="https://schema.org/Offers">{$product.specific_prices.reduction * 100}%</span>
                                            {/if}
                                        {/if} 
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
			</li>
		{/foreach}
		</ul>
	</div>
</div>
</section>
{/if}
