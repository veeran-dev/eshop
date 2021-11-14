{*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14011 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
	
{if $autoplay}
	<script type="text/javascript">
		var carousel_autoplay = 0;
		var carousel_items_visible = {$itemsvisible};
		var carousel_scroll = {$itemsscroll};
	</script>
{else}
	<script type="text/javascript">
		var carousel_autoplay = 0;
		var carousel_items_visible = {$itemsvisible};
		var carousel_scroll = {$itemsscroll};
	</script>
{/if}

<div class="backgroundQuickView"></div>
<!-- MODULE Home Featured Products -->
<div id="homefeatured">
<!--	<script type="text/javascript" src="{$js_dir}popup.js"></script>-->
	<h4>{l s='Featured products' mod='homefeatured'}</h4>
	{if isset($products) AND $products}
			{assign var='liHeight' value=342}
			{assign var='nbItemsPerLine' value=4}
			{assign var='nbLi' value=$products|@count}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
			<ul id="featuredcarousel">
			{foreach from=$products item=product name=homeFeaturedProducts}
				<li class="{if $smarty.foreach.homeFeaturedProducts.last}last_item{/if}" 
					onmouseover="document.getElementById('button_hf_{$product.id_product}').style.visibility = 'visible';"
					onmouseout="document.getElementById('button_hf_{$product.id_product}').style.visibility = 'hidden';">
				
				{if $product.specific_prices.reduction_type == 'percentage'}
					<strong class="discount_container"> 
						<strong class="discount_st">
							{$product.specific_prices.reduction*100}%
						</strong>
					</strong>
				{elseif  $product.specific_prices.reduction_type == 'amount'}
					<strong class="discount_container"> 
						<strong class="discount_st">
							{math equation="round((reductionAmount/productPriceWithoutRedution) * 100)" productPriceWithoutRedution=$product.price_without_reduction reductionAmount=$product.specific_prices.reduction assign=reductionPercentage}						
							{$reductionPercentage}%
						</strong>
					</strong>
				{/if}
					<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product.name|escape:html:'UTF-8'}" /></a>
					<a onClick="return false;" href="#hf_qvb_{$product.id_product}" class="quickViewButton" id="button_hf_{$product.id_product}"><img src="https://www.kobster.com/images/quickView.jpg"/></a>
					<h5><a href="{$product.link}" title="{$product.name|truncate:45:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:27:'...'|escape:'htmlall':'UTF-8'}</a></h5>
					<div id="pl_rating">
						{if $product.averageRating|round eq 0}
							<div class="zero" title="4 Stars"></div>
						{elseif $product.averageRating|round eq 1}
							<div class="one" title="1 Star"></div>
						{elseif $product.averageRating|round eq 2}
							<div class="two" title="2 Stars"></div>
						{elseif $product.averageRating|round eq 3}
							<div class="three" title="3 Stars"></div>
						{elseif $product.averageRating|round eq 4}
							<div class="four" title="4 Stars"></div>
						{elseif $product.averageRating|round eq 5}
							<div class="five" title="5 Stars"></div>
						{/if}
					</div>
					<p class="product_desc">{$product.description_short|strip_tags|truncate:90:'...'}</p>
					<div class="home_price"><span class="price_beg"></span><span class="price">{convertPrice price=$product.price}</span><span class="price_end"></span></div>
					{if isset($product.reduction) && $product.reduction}<div class="product_mrp">{convertPrice price=$product.price_without_reduction}</div>{/if}
						
						{if ($product.id_product_attribute == 0 OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product.available_for_order AND !isset($restricted_country_mode) AND $product.minimal_quantity == 1 AND $product.customizable != 2 AND !$PS_CATALOG_MODE}
							{if ($product.quantity > 0 OR $product.allow_oosp)}
							<div class="carousel_buttons">
							<a class="button" href="{$product.link}" title="{l s='View' mod='homefeatured'}">{l s='View' mod='homefeatured'}</a>
							<input type="text" name="qty" id="{$product.id_product}_quantity_wanted" class="hf_quantity_wanted" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} />
							<a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product}" href="{$link->getPageLink('cart.php')}?qty=1&amp;id_product={$product.id_product}&amp;token={$static_token}&amp;add" title="{l s='Add to cart' mod='homefeatured'}">{l s='Add to cart' mod='homefeatured'}</a>
							{else}
							<span class="exclusive">{l s='Add to cart' mod='homefeatured'}</span>
							{/if}
						{/if}
						</div>
					
				</li>
			{/foreach}
			</ul>
		</div>
	{else}
		<p>{l s='No featured products' mod='homefeatured'}</p>
	{/if}


{foreach from=$products item=product name=products key=k}
<div id="hf_qvb_{$product.id_product}" class="quickView">
		<a onClick="return false;" class="quickViewClose" href="#hf_qvb_{$product.id_product}"><img src="https://www.kobster.com/images/Close.png" /></a>
		<div class="quickView_left">
			<a href="{$product.link|escape:'htmlall':'UTF-8'}" class="quickView_product_img_link" title="{$product.name|escape:'htmlall':'UTF-8'}"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'large')}" alt="{$product.legend|escape:'htmlall':'UTF-8'}" width="300px" height="300px" /></a>
			<p class="quickView_product_desc">{$product.description_short|strip_tags:'UTF-8'|truncate:300}</p>		
		</div>
		
		<div class="quickView_right">
			<h3 class="quickView_name">{$product.name|escape:'htmlall':'UTF-8'}</h3>
			<div id="p_rating">
				{if $product.averageRating|round eq 0}
					<div class="zero" title="4 Stars"></div>
				{elseif $product.averageRating|round eq 1}
					<div class="one" title="1 Star"></div>
				{elseif $product.averageRating|round eq 2}
					<div class="two" title="2 Stars"></div>
				{elseif $product.averageRating|round eq 3}
					<div class="three" title="3 Stars"></div>
				{elseif $product.averageRating|round eq 4}
					<div class="four" title="4 Stars"></div>
				{elseif $product.averageRating|round eq 5}
					<div class="five" title="5 Stars"></div>
				{/if}
			</div>
			<p class="qv_prod_desc">{$product.description|truncate:300:'...'|strip_tags:'UTF-8'}</p>
			<br />
				<a class="qv_more_details" href="{$product.link|escape:'htmlall':'UTF-8'}">Click here to know more details & customization options about this product</a>
			<br /><br />
			{if $product.manufacturer_name}
				<span class="qv_label">{l s='Manufactured By:'}</span>
				<span id="availability_value">
					{$product.manufacturer_name}
				</span>
				<br /><br />
			{/if}
			{if $product.reference}
				<span class="qv_label">{l s='Product Code:'}</span>
				<span id="availability_value">
					{$product.reference}
				</span>
				<br /><br />
			{/if}
			{if $product.available_now}
				<span class="qv_label">{l s='Delivered in:'}</span>
				<span id="availability_value">
					{$product.available_now}
				</span>
				<br /><br />
			{/if}
			{if $product.available_later && $product.available_later <> 'C0'}
				<span class="qv_label">{l s='Delivered to:'}</span>
				<span id="availability_value">
					{$product.available_later} only
				</span>
			{/if}
			
			<div class="qv_product_price">
				{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}<div class="quickView_price"><span class="qv_price_beg"></span><span class="qv_price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span><span class="qv_price_end"></span></div>{/if}
			</div>
			
			
			<strong class="quickView_discount_container"> 
			
			{if $product.specific_prices.reduction_type == 'percentage'}
				<strong class="quickView_discount_st">
					{math equation="productPriceWithoutRedution - productPrice" productPriceWithoutRedution=$product.price_without_reduction productPrice=$product.price assign=reductionAmount}
					<span class="qv_discount_price">{l s='You Save: '}{convertPrice price=$reductionAmount}</span>
					<span class="qv_discount_percent">{$product.specific_prices.reduction*100}{l s=' % Off '}</span>
				</strong>
			
			{elseif  $product.specific_prices.reduction_type == 'amount'}
				<strong class="quickView_discount_st">
					{math equation="round((reductionAmount/productPriceWithoutRedution) * 100)" productPriceWithoutRedution=$product.price_without_reduction reductionAmount=$product.specific_prices.reduction assign=reductionPercentage}
					{math equation="productPriceWithoutRedution - productPrice" productPriceWithoutRedution=$product.price_without_reduction productPrice=$product.price assign=reductionAmt}
					<span class="qv_discount_price">{l s='You Save: '}{convertPrice price=$reductionAmt}</span>
					<span class="qv_discount_percent">{$reductionPercentage}{l s=' % Off '}</span>
				</strong>
			{/if}
			
			{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode) && isset($product.reduction) && $product.reduction}<div class="quickView_mrp"><b>MRP: <strike>{convertPrice price=$product.price_without_reduction}</strike></b></div>{/if}
			</strong>
			
			<div class="quickView_carousel_buttons">
				<input type="text" name="qty" id="{$product.id_product}_qv_quantity_wanted" class="quickView_quantity_wanted" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} />
				<a class="qv_ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product|intval}" href="{$link->getPageLink('cart.php')}?add&amp;id_product={$product.id_product|intval}&amp;{if isset($static_token)}&amp;token={$static_token}{/if}" title="{l s='Add to cart'}"></a>
			</div>
		</div>
	</div>
{/foreach}
<!-- /MODULE Home Featured Products -->
