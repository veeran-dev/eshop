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

{include file="$tpl_dir./errors.tpl"}
{if $errors|@count == 0}
	{if !isset($priceDisplayPrecision)}
		{assign var='priceDisplayPrecision' value=2}
	{/if}
	{if !$priceDisplay || $priceDisplay == 2}
		{assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, 6)}
		{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
	{elseif $priceDisplay == 1}
		{assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, 6)}
		{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
	{/if}
<div itemscope itemtype="https://schema.org/Product">
	<meta itemprop="url" content="{$link->getProductLink($product)}">
	<div class="primary_block">
		{if isset($adminActionDisplay) && $adminActionDisplay}
			<div id="admin-action" class="container">
				<p class="alert alert-info">{l s='This product is not visible to your customers.'}
					<input type="hidden" id="admin-action-product-id" value="{$product->id}" />
					<a id="publish_button" class="btn btn-default button button-small" href="#">
						<span>{l s='Publish'}</span>
					</a>
					<a id="lnk_view" class="btn btn-default button button-small" href="#">
						<span>{l s='Back'}</span>
					</a>
				</p>
				<p id="admin-action-result"></p>
			</div>
		{/if}
		{if isset($confirmation) && $confirmation}
			<p class="confirmation">
				{$confirmation}
			</p>
		{/if}
		<div class="row first-row">
			<!-- left infos-->
			<div class="pb-left-column col-xs-12 col-sm-4 col-md-5">
				<!-- product img-->
				<div id="image-block" class="clearfix">
					{if $product->new}
						<span class="new-box">
							<span class="new-label">{l s='New'}</span>
						</span>
					{/if}
					{if $product->on_sale}
						<span class="sale-box no-print">
							<span class="sale-label">{l s='Sale!'}</span>
						</span>
					{elseif $product->specificPrice && $product->specificPrice.reduction && $productPriceWithoutReduction > $productPrice}
						<span class="discount">{l s='Reduced price!'}</span>
					{/if}
					{if $have_image}
						<span id="view_full_size">
							{if $jqZoomEnabled && $have_image && !$content_only}
								<a class="jqzoom" title="{if !empty($cover.legend)}{$cover.legend|escape:'html':'UTF-8'}{else}{$product->name|escape:'html':'UTF-8'}{/if}" rel="gal1" href="{$link->getImageLink($product->link_rewrite, $cover.id_image, 'thickbox_default')|escape:'html':'UTF-8'}">
									<img itemprop="image" src="{$link->getImageLink($product->link_rewrite, $cover.id_image, 'large_default')|escape:'html':'UTF-8'}" title="{if !empty($cover.legend)}{$cover.legend|escape:'html':'UTF-8'}{else}{$product->name|escape:'html':'UTF-8'}{/if}" alt="{if !empty($cover.legend)}{$cover.legend|escape:'html':'UTF-8'}{else}{$product->name|escape:'html':'UTF-8'}{/if}"/>
								</a>
							{else}
								<img id="bigpic" itemprop="image" src="{$link->getImageLink($product->link_rewrite, $cover.id_image, 'large_default')|escape:'html':'UTF-8'}" title="{if !empty($cover.legend)}{$cover.legend|escape:'html':'UTF-8'}{else}{$product->name|escape:'html':'UTF-8'}{/if}" alt="{if !empty($cover.legend)}{$cover.legend|escape:'html':'UTF-8'}{else}{$product->name|escape:'html':'UTF-8'}{/if}" width="{$largeSize.width}" height="{$largeSize.height}"/>
								{if !$content_only}
									<span class="span_link no-print">{l s='View larger'}</span>
								{/if}
							{/if}
						</span>
					{else}
						<span id="view_full_size">
							<img itemprop="image" src="{$img_prod_dir}{$lang_iso}-default-large_default.jpg" id="bigpic" alt="" title="{$product->name|escape:'html':'UTF-8'}" width="{$largeSize.width}" height="{$largeSize.height}"/>
							{if !$content_only}
								<span class="span_link">
									{l s='View larger'}
								</span>
							{/if}
						</span>
					{/if}
				</div> <!-- end image-block -->
				{if isset($images) && count($images) > 0}
					<!-- thumbnails -->
					<div id="views_block" class="clearfix {if isset($images) && count($images) < 2}hidden{/if}">
						{if isset($images) && count($images) > 2}
							<span class="view_scroll_spacer">
								<a id="view_scroll_left" class="" title="{l s='Other views'}" href="javascript:{ldelim}{rdelim}">
									{l s='Previous'}
								</a>
							</span>
						{/if}
						<div id="thumbs_list">
							<ul id="thumbs_list_frame">
							{if isset($images)}
								{foreach from=$images item=image name=thumbnails}
									{assign var=imageIds value="`$product->id`-`$image.id_image`"}
									{if !empty($image.legend)}
										{assign var=imageTitle value=$image.legend|escape:'html':'UTF-8'}
									{else}
										{assign var=imageTitle value=$product->name|escape:'html':'UTF-8'}
									{/if}
									<li id="thumbnail_{$image.id_image}"{if $smarty.foreach.thumbnails.last} class="last"{/if}>
										<a{if $jqZoomEnabled && $have_image && !$content_only} href="javascript:void(0);" rel="{literal}{{/literal}gallery: 'gal1', smallimage: '{$link->getImageLink($product->link_rewrite, $imageIds, 'large_default')|escape:'html':'UTF-8'}',largeimage: '{$link->getImageLink($product->link_rewrite, $imageIds, 'thickbox_default')|escape:'html':'UTF-8'}'{literal}}{/literal}"{else} href="{$link->getImageLink($product->link_rewrite, $imageIds, 'thickbox_default')|escape:'html':'UTF-8'}"	data-fancybox-group="other-views" class="fancybox{if $image.id_image == $cover.id_image} shown{/if}"{/if} title="{$imageTitle}">
											<img class="img-responsive" id="thumb_{$image.id_image}" src="{$link->getImageLink($product->link_rewrite, $imageIds, 'cart_default')|escape:'html':'UTF-8'}" alt="{$imageTitle}" title="{$imageTitle}"{if isset($cartSize)} height="{$cartSize.height}" width="{$cartSize.width}"{/if} itemprop="image" />
										</a>
									</li>
								{/foreach}
							{/if}
							</ul>
						</div> <!-- end thumbs_list -->
						{if isset($images) && count($images) > 2}
							<a id="view_scroll_right" title="{l s='Other views'}" href="javascript:{ldelim}{rdelim}">
								{l s='Next'}
							</a>
						{/if}
					</div> <!-- end views-block -->
					<!-- end thumbnails -->
				{/if}
				{if isset($images) && count($images) > 1}
					<p class="resetimg clear no-print">
						<span id="wrapResetImages" style="display: none;">
							<a href="{$link->getProductLink($product)|escape:'html':'UTF-8'}" data-id="resetImages">
								<i class="icon-repeat"></i>
								{l s='Display all pictures'}
							</a>
						</span>
					</p>
				{/if}

				<!-- usefull links-->
                <div id="usefull_link_block">
                    {if $HOOK_EXTRA_LEFT}{$HOOK_EXTRA_LEFT}{/if}
                    {if $have_image && !$jqZoomEnabled}
                    <li><span id="view_full_size" class="span_link">{l s='Maximize'}</span></li>
                    {/if}
                </div>
			</div> <!-- end pb-left-column -->
			<!-- end left infos-->
			<!-- center infos -->
			<div class="pb-center-column col-xs-12 col-sm-7">
				<h1 itemprop="name">{$product->name|escape:'html':'UTF-8'}</h1>

				
				<div class="product-standard">
                    <div id="star_rating" class="star_content ratingTab clearfix" href=""  itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                    {section name="i" start=0 loop=5 step=1}
                        {if $ratings le $smarty.section.i.index}
                            <div class="star"></div>
                        {else}
                            <div class="star star_on"></div>
                        {/if}
                    {/section}
                    <span>{if $nbComments>0} {$nbComments} Reviews{else}Be the first to rate{/if}</span>
                    </div>
	                {if $attachments}
	                	<a class="download-catalog" href="{$link->getPageLink('attachment', true, NULL, "id_attachment={$attachments[0].id_attachment}")|escape:'html':'UTF-8'}">{l s="Download Catalog"}</a>
					{/if}
                </div>

                <div class="product-key-info">
					<ul>
						<li>
							<p id="product_reference"{if empty($product->reference) || !$product->reference} style="display: none;"{/if}>
								{l s="Reference : "}<span class="editable" itemprop="sku"{if !empty($product->reference) && $product->reference} content="{$product->reference}"{/if}>{if !isset($groups)}{$product->reference|escape:'html':'UTF-8'}{/if}</span>
							</p>
						</li>
						{if isset($product) && isset($features) && !empty($features)}
                        	{assign var=i value=1}
                            {foreach from=$features item=feature}
                                {if isset($feature.value)}
                                <li><p>{$feature.name|escape:'html':'UTF-8'} : <span>{$feature.value|escape:'html':'UTF-8'}</span></p></li>
                                {assign var=i value=$i+1}
                                {/if}
                                {if $i > 4} {break} {/if}
                            {/foreach}
                            <li><a class="smooth-scroll featuresTab">View All</a></li>
                        {/if}
					</ul>

                </div>
				
                {*
                <div class="coupon-container">
                    {if $cookie->voucherCode!=""}                                  
                        <p class="coupon">COUPON CODE:<span>{$cookie->voucherCode}</span></p>                     
                    {elseif $is_logged}               
                        <p class="coupon">Get Flat <span>₹ 100 Off</span> on First Purchase</p> 
                    {else}               
                        <p class="coupon">Get Flat <span>₹ 100 Off</span> on First Purchase <a class="view-all-coupon voucher-popup-trigger">Claim Now!</a></p> 
                    {/if}
                </div>
                *}

                
				

				<!-- availability or doesntExist -->
				<!--<p id="availability_statut"{if !$PS_STOCK_MANAGEMENT || ($product->quantity <= 0 && !$product->available_later && $allow_oosp) || ($product->quantity > 0 && !$product->available_now) || !$product->available_for_order || $PS_CATALOG_MODE} style="display: none;"{/if}>
					{*<span id="availability_label">{l s='Availability:'}</span>*}
					<span id="availability_value" class="label{if $product->quantity <= 0 && !$allow_oosp} label-danger{elseif $product->quantity <= 0} label-warning{else} label-success{/if}">{if $product->quantity <= 0}{if $PS_STOCK_MANAGEMENT && $allow_oosp}{$product->available_later}{else}{l s='This product is no longer in stock'}{/if}{elseif $PS_STOCK_MANAGEMENT}{$product->available_now}{/if}</span>
				</p>
				<!-- Out of stock hook -->
				<div id="oosHook"{if $product->quantity > 0} style="display: none;"{/if}>
					{$HOOK_PRODUCT_OOS}
				</div>

				<div class="price-container">
					<!-- Start of Price Column -->
					<div class="content_prices clearfix">
					{if $product->show_price && !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
						<!-- prices -->
						<div>
							<p class="our_price_display" itemprop="offer" itemscope itemtype="https://schema.org/Offer">
							{if $productPrice>0}
							{strip}
								{if $product->quantity > 0}<link itemprop="availability" href="https://schema.org/InStock"/>{/if}
								{if $priceDisplay >= 0 && $priceDisplay <= 2}
									<p id="our_price_display" class="price" itemprop="price" content="{$productPrice}">{convertPrice price=$productPrice}</p>
									<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
									{hook h="displayProductPriceBlock" product=$product type="price"}
								{/if}
							{/strip}
							{*{else}
								<button class="button-outline contact-for-price" onclick="online_chat();">Contact us for price</button>*}
							{/if}
							</p>

							{assign var="reduction_amount" value=$productPriceWithoutReduction-$productPrice}
                            {if ($reduction_amount > 0)}
							<div>
                                <span id="old_price">
                                {strip}
                                    {if $priceDisplay >= 0 && $priceDisplay <= 2}
                                        {hook h="displayProductPriceBlock" product=$product type="old_price"}
                                        <span id="old_price_display"><span class="price">{if $productPriceWithoutReduction > $productPrice} {convertPrice price=$productPriceWithoutReduction}{/if}</span></span>
                                    {/if}
                                {/strip}
                                </span>
                                
                                {if $product->specificPrice.reduction_type == 'percentage'}
                                <span id="reduction_percent">
                                {strip}
                                    <span id="reduction_percent_display">
                                        {if $product->specificPrice && $product->specificPrice.reduction_type == 'percentage'}{$product->specificPrice.reduction*100}% OFF{/if}
                                    </span>
                                {/strip}
                                </span>
                                {/if}
                                
                                {if $product->specificPrice.reduction_type == 'amount'}
                                <span id="reduction_amount">
                                {strip}
                                    <span id="reduction_amount_display">
                                    {if $product->specificPrice && $product->specificPrice.reduction_type == 'amount' && $product->specificPrice.reduction|floatval !=0}
                                        
                                        &nbsp; {convertPrice price=$product->specificPrice.reduction} off
                                        
                                    {/if}
                                    </span>
                                {/strip}
                                </span>
                                {/if}
							</div>
                            {/if}
							
                            {* {$product|@print_r} *}
                            
							{if $product->reduction_tax == 1}
								<p class="tax-include">{l s="Excl. of Tax"}</p>
                          	{else}
								<p class="tax-include">{l s="Incl. of Tax"}</p>
							{/if}
						</div> <!-- end prices -->
						<div>
							<!-- availability or doesntExist -->
							<div class="delivery-info">
			                	<p id="availability_statut"{if !$PS_STOCK_MANAGEMENT || ($product->quantity <= 0 && !$product->available_later && $allow_oosp) || ($product->quantity > 0 && !$product->available_now) || !$product->available_for_order || $PS_CATALOG_MODE} style="display: none;"{/if}>
									{*<span id="availability_label">{l s='Availability:'}</span>*}
									<span id="availability_value" class="label{if $product->quantity <= 0 && !$allow_oosp} label-danger{elseif $product->quantity <= 0} label-warning{else} hidden{/if}">{if $product->quantity <= 0}{if $PS_STOCK_MANAGEMENT && $allow_oosp}{$product->available_later}{else}{l s='This product is no longer in stock'}{/if}{elseif $PS_STOCK_MANAGEMENT}{/if}</span>
								</p>
			                </div>
							
						</div>
						{if $packItems|@count && $productPrice < $product->getNoPackPrice()}
							<p class="pack_price">{l s='Instead of'} <span style="text-decoration: line-through;">{convertPrice price=$product->getNoPackPrice()}</span></p>
						{/if}
						{if $product->ecotax != 0}
							<p class="price-ecotax">{l s='Including'} <span id="ecotax_price_display">{if $priceDisplay == 2}{$ecotax_tax_exc|convertAndFormatPrice}{else}{$ecotax_tax_inc|convertAndFormatPrice}{/if}</span> {l s='for ecotax'}
								{if $product->specificPrice && $product->specificPrice.reduction}
								<br />{l s='(not impacted by the discount)'}
								{/if}
							</p>
						{/if}
						{if !empty($product->unity) && $product->unit_price_ratio > 0.000000}
							{math equation="pprice / punit_price" pprice=$productPrice  punit_price=$product->unit_price_ratio assign=unit_price}
							<p class="unit-price"><span id="unit_price_display">{convertPrice price=$unit_price}</span> {l s='per'} {$product->unity|escape:'html':'UTF-8'}</p>
							{hook h="displayProductPriceBlock" product=$product type="unit_price"}
						{/if}
					{/if} {*close if for show price*}
					{hook h="displayProductPriceBlock" product=$product type="weight" hook_origin='product_sheet'}
		            {hook h="displayProductPriceBlock" product=$product type="after_price"}
				</div>
				<!-- End of Price Column -->


				<!-- Start of Slab Price Column -->
				<div>
					
				{if (isset($quantity_discounts) && count($quantity_discounts) > 0)}
	                <!-- quantity discount -->
	                <div class="clearfix" id="quantityDiscount">  						
	                    <div class="price-slab-container">
	                    	<div class="price-slab-header">
	                    		<div class="discountSlab">Units</div>
	                    		<div class="discountQuantity">Price</div>
	                    		<!-- <div class="reduction_val">Offer</div> -->
	                    	</div>
	                        {foreach from=$quantity_discounts item='quantity_discount' name='quantity_discounts'}
	                            <div class="price-slab">
	                                <div class="discountSlab">{$quantity_discount.quantity|intval}+</div>
	                                <div class="discountQuantity">
	                                    {if $quantity_discount.price >= 0 || $quantity_discount.reduction_type == 'amount'}
	                                            {if $display_discount_price}
	                                                {if $quantity_discount.reduction_tax == 0 && !$quantity_discount.price}
	                                                    {convertPrice price =$productPrice-$productPriceWithoutReduction|floatval-($productPriceWithoutReduction*$quantity_discount.reduction_with_tax)|floatval}
	                                                {else}
	                                                    {convertPrice price=$productPrice-$productPriceWithoutReduction|floatval-$quantity_discount.real_value|floatval}
	                                                {/if}
	                                            {else}
	                                                {convertPrice price=$productPrice-$quantity_discount.real_value|floatval}
	                                            {/if}
	                                        {else}
	                                            {if $display_discount_price}
	                                                {if $quantity_discount.reduction_tax == 0}
	                                                    {convertPrice price = $productPrice-$productPriceWithoutReduction|floatval-($productPriceWithoutReduction*$quantity_discount.reduction_with_tax)|floatval}
	                                                {else}
	                                                    {convertPrice price = $productPrice-$productPriceWithoutReduction|floatval-($productPriceWithoutReduction*$quantity_discount.reduction)|floatval}
	                                                {/if}
	                                            {else}
	                                                {$productPrice-$quantity_discount.real_value|floatval}%
	                                            {/if}
	                                        {/if}
	                                </div>
	                                <!-- Start  of Hiding Offer Percentage -->
	                                {*
	                                <div class="reduction_val">
	                                {if $quantity_discount.reduction_type=='amount'}
	                                    {convertPrice price = $quantity_discount.price}
	                                {/if}
	                                {if $quantity_discount.reduction_type=='percentage'}
	                                    {$quantity_discount.reduction*100|floatval}% OFF
	                                {/if}
	                                </div>
	                                *}
	                                <!-- End of Hiding Offer Percentage -->
	                            </div>
	                        {/foreach}
	                    </div>
	                </div>
	                {/if}
					</div>

				<!-- End of Slab Price Column  -->

			</div>
			
            <div class="quantity-container">
                {if !$PS_CATALOG_MODE}
                <div id="quantity_wanted_p"{if (!$allow_oosp && $product->quantity <= 0) || !$product->available_for_order || $PS_CATALOG_MODE} style="display: none;"{/if} class="clearfix">
                    <div class="quantity-selector">
                        <p class="quantity_moq">QTY <!-- : <span>{$product->minimal_quantity}</span> --></p>
                        <span class="product-quantity-selector">
                            <a href="#" data-field-qty="qty" class="product_qty_down"><span></span></a><input type="text" min="1" name="qty" id="quantity_wanted_{$product->id|intval}" maxlength=5 size=5 class="text numbersOnly" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" /><a href="#" data-field-qty="qty" class="product_qty_up"><span></span></a>
                        </span>
                    </div>
                </div>
                {/if}

	            {if $product->quantity > 0 && $cookie->is_perks != 1}
                    <div id="pin_check" >
                        <div id="checkpincode">
                            <!-- <p id="pincode_p">This product is available only in selected locations</p> -->
                            <div id="pincode_check" >
                                <input class="form-control" type="text" id="pincode" value="" name="pincode" placeholder="Pincode"  min="6" maxlength="6" onclick="fn_remove();" onkeydown="if (event.keyCode == 13) document.getElementById('pincode_search').click();" />
                                <input class="button-gray" id="pincode_search" type="button" value="CHECK" onClick="showpincode();" />
                                <input type="hidden" id="hiddenpincode" name="hiddenpincode" value="0" />
                                <div id="pin_available" class="alert alert-success unvisible" ><b>{if $product->getAvailableNow() !==''}{$product->getAvailableNow()}{else}Delivered in 3-5 days{/if}</b></div>
                                <div id="pin_notavailable" class="alert alert-danger unvisible" ><b>Not Available</b> </div>
                                <div id="valid_pincode" class="alert alert-warning unvisible" ><b>Enter Valid Pincode</b> </div>
                                <div id="pincode_add2cart_alert" class="alert alert-danger unvisible"><b>Please check pincode!</b></div>
                             </div>
                        </div>
                    </div>            
                {/if}

            </div>
			{if isset($groups)}
			<div class="product_attributes clearfix">
					<!-- quantity wanted -->
						<!-- attributes -->
						<div id="attributes">
							<div class="clearfix"></div>
							{foreach from=$groups key=id_attribute_group item=group}
								{if $group.p_attributes|@count}
							    <div>
    								{foreach from=$group.p_attributes key=id_attribute item=group_attribute}
    								    <input type="text" id="hidden_ipa_{$id_attribute}" value="{$group_attribute}" style="visibility:hidden">
    								{/foreach}
								</div>
								{/if}
								{if $group.attributes|@count}
									<fieldset class="attribute_fieldset">
										<label class="attribute_label" {if $group.group_type != 'color' && $group.group_type != 'radio'}for="group_{$id_attribute_group|intval}"{/if}>{$group.name|escape:'html':'UTF-8'}&nbsp;</label>
										{assign var="groupName" value="group_$id_attribute_group"}
										<div class="attribute_list">
											{if ($group.group_type == 'select')}
												<select name="{$groupName}" id="group_{$id_attribute_group|intval}" class="form-control noUniform attribute_select no-print">
													{foreach from=$group.attributes key=id_attribute item=group_attribute}
														<option value="{$id_attribute|intval}"{if (isset($smarty.get.$groupName) && $smarty.get.$groupName|intval == $id_attribute) || $group.default == $id_attribute} selected="selected"{/if} title="{$group_attribute|escape:'html':'UTF-8'}">{$group_attribute|escape:'html':'UTF-8'}</option>
													{/foreach}
												</select>
											{elseif ($group.group_type == 'color')}
												<ul id="color_to_pick_list" class="clearfix">
													{assign var="default_colorpicker" value=""}
													{foreach from=$group.attributes key=id_attribute item=group_attribute}
														{assign var='img_color_exists' value=file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
														<li{if $group.default == $id_attribute} class="selected"{/if}>
															<a href="{$link->getProductLink($product)|escape:'html':'UTF-8'}" id="color_{$id_attribute|intval}" name="{$colors.$id_attribute.name|escape:'html':'UTF-8'}" class="color_pick{if ($group.default == $id_attribute)} selected{/if}"{if !$img_color_exists && isset($colors.$id_attribute.value) && $colors.$id_attribute.value} style="background:{$colors.$id_attribute.value|escape:'html':'UTF-8'};"{/if} title="{$colors.$id_attribute.name|escape:'html':'UTF-8'}">
																{if $img_color_exists}
																	<img src="{$img_col_dir}{$id_attribute|intval}.jpg" alt="{$colors.$id_attribute.name|escape:'html':'UTF-8'}" title="{$colors.$id_attribute.name|escape:'html':'UTF-8'}" width="20" height="20" />
																{/if}
															</a>
														</li>
														{if ($group.default == $id_attribute)}
															{$default_colorpicker = $id_attribute}
														{/if}
													{/foreach}
												</ul>
												<input type="hidden" class="color_pick_hidden" name="{$groupName|escape:'html':'UTF-8'}" value="{$default_colorpicker|intval}" />
											{elseif ($group.group_type == 'radio')}
												<ul>
													{foreach from=$group.attributes key=id_attribute item=group_attribute}
														<li>
															<input type="radio" class="attribute_radio" name="{$groupName|escape:'html':'UTF-8'}" value="{$id_attribute}" {if ($group.default == $id_attribute)} checked="checked"{/if} />
															<span>{$group_attribute|escape:'html':'UTF-8'}</span>
														</li>
													{/foreach}
												</ul>
											{/if}
										</div> <!-- end attribute_list -->
									</fieldset>
								{/if}
							{/foreach}
						</div> <!-- end attributes -->
					
			</div>
			{/if}
			<div class="button-block" {if (!$allow_oosp && $product->quantity <= 0) || $product->discontinued == 1 || !$product->available_for_order || (isset($restricted_country_mode) && $restricted_country_mode) || $PS_CATALOG_MODE} style="display:none;"{/if}>
				
				{if $productPrice>0}

					<button id="buy_now" class="button-black ajax_add_to_cart_button" data-id-product="{$product->id|intval}">Buy Now</button>													
					<button id="add_to_cart" class="ajax_add_to_cart_button exclusive button-outline" data-id-product="{$product->id|intval}">
						<span>{if $content_only && (isset($product->customization_required) && $product->customization_required)}{l s='Customize'}{else}{l s='Add to cart'}{/if}</span>
					</button>
				{else}
					<button class="button-outline contact-for-price" onclick="online_chat();">Contact us for price</button>
				{/if}
				<p class="hidden">
					<input type="hidden" name="token" value="{$static_token}" />
					<input type="hidden" name="id_product" value="{$product->id|intval}" id="product_page_product_id" />
					<input type="hidden" name="add" value="1" />
					<input type="hidden" name="id_product_attribute" id="idCombination" value="" />
				</p>
			</div>

			<!-- other site prices -->
			{if $competitorsPrice.amazon || $competitorsPrice.flipkart || $competitorsPrice.snapdeal }
			<div class="other-site-prices-container inline-prices">
				<div class="other-site-prices">
				{if $competitorsPrice.amazon}
					<div class="other-site">
						<div class="media-object">
							<div class="media-figure">
								<img src="{$tpl_uri}img/perks/others-logo/amazon.png" alt="amazon" height="48px" width="48px" />
								<span>Amazon</span>
							</div>
							<div class="media-body">
								<h4>{convertPrice price = $competitorsPrice.amazon}</h4>
							</div>
						</div>
					</div>
				{/if}
				{if $competitorsPrice.flipkart}
					<div class="other-site">
						<div class="media-object">
							<div class="media-figure">
								<img src="{$tpl_uri}img/perks/others-logo/flipkart.png" alt="flipkart" height="48px" width="48px" />
								<span>Flipkart</span>
							</div>
							<div class="media-body">
								<h4>{convertPrice price = $competitorsPrice.flipkart}</h4>
							</div>
						</div>
					</div>
				{/if}
				{if $competitorsPrice.snapdeal}
					<div class="other-site">
						<div class="media-object">
							<div class="media-figure">
								<img src="{$tpl_uri}img/perks/others-logo/snapdeal.png" alt="Snapdeal" height="48px" width="48px" />
								<span>Snapdeal</span>
							</div>
							<div class="media-body">
								<h4>{convertPrice price = $competitorsPrice.snapdeal}</h4>
							</div>
						</div>
					</div>
				{/if}
				</div>
			</div>
			{/if}
			<!-- end -->
			<!-- Displaying available cities for Perks -->
			{* {if $cookie->is_perks = 1} *}
			<div class="perks-available-cities">
				<p>Perks is exclusively available only on five major cities: <strong>Bengaluru</strong>, <strong>Mumbai</strong>, <strong>New Delhi</strong>, <strong>Chennai</strong> and <strong>Hyderabad</strong>.</p>
			</div>
			{* {/if} *}
			<!-- end -->
			<div class="help-block">
				<a href="tel:18001210405"><span class="help-icon phone">&nbsp;</span>1800-121-0405 (Toll Free)</a> <a onclick="online_chat();"><span class="help-icon chat">&nbsp;</span> Chat</a> <a id="open-blk-enquiry-form" href="#fancybox-bulk-enq"><span class="help-icon bulk">&nbsp;</span> Bulk Enquiry</a>
			</div>
			</div>
		</div>
		<!-- end center infos-->
 	
 	<div class="badge-section">
 		<div class="badge-item">
 			<div class="badge-icon genuine">&nbsp;</div>
 			<div class="badge-label">Genuine <br> Product</div>
 		</div>
 		<div class="badge-item">
 			<div class="badge-icon free-shipping">&nbsp;</div>
 			<div class="badge-label">Free Shipping!<br><span>for business customers</span></div>
 		</div>
 		<div class="badge-item">
 			<div class="badge-icon secure">&nbsp;</div>
 			<div class="badge-label">Secure <br> Payment</div>
 		</div>
 		<div class="badge-item">
 			<div class="badge-icon return">&nbsp;</div>
 			<div class="badge-label">Easy <br> Returns</div>
 		</div>
 		<div class="badge-item">
 			<div class="badge-icon protection">&nbsp;</div>
 			<div class="badge-label">Buyer <br> Protection</div>
 		</div>
 	</div>

 	<div class="jump-links">
 		<ul>
 			{if isset($product) && isset($product->description) && $product->description != ''}
 				<li><a class="smooth-scroll descriptionTab">Description</a></li>
 			{/if}
 			{if isset($product) && isset($features) && !empty($features)}
 				<li><a class="smooth-scroll featuresTab">Features</a></li>
 			{/if}
 			{if isset($product_manufacturer)}
 			<li><a class="smooth-scroll brandTab">Brand</a></li>
 			{/if}
 			<li><a class="smooth-scroll ratingTab">Ratings and Reviews</a></li>
 		</ul>
 	</div>

	{if isset($product) && isset($product->description) && $product->description != ''}
		<div class="panel-body" id="description-tab">
			<h4>Description</h4>
			<p>{$product->description}</p>
		</div>
	{/if}

	<div class="dual-column">
		<!-- Features -->
		{if isset($product) && isset($features) && !empty($features)}
			<div class="panel-body" id="features-tab" name="features-tab">
				<h4>Features</h4>
				<table class="table-data-sheet">
	                 {foreach from=$features item=feature}
	                <tr class="{cycle values="odd,even"}">
	                    {if isset($feature.value)}
	                    <td>{$feature.name|escape:'html':'UTF-8'}</td>
	                    <td>{$feature.value|escape:'html':'UTF-8'}</td>
	                    {/if}
	                </tr>
	                {/foreach}
	            </table>
			</div>
		{/if}
		<!-- Brand -->
		{if isset($product_manufacturer)}
			<div class="panel-body" id="brand-tab" name="brand-tab">
				<h4>Brand</h4>
				<div class="brand-details">
                    <a class="brand_image" href="{$link->getmanufacturerLink($product_manufacturer->id_manufacturer, $product_manufacturer->link_rewrite)|escape:'html':'UTF-8'}">
                    <img class="img-responsive" src="{$img_manu_dir}{$product_manufacturer->image|escape:'html':'UTF-8'}-medium_default.jpg" alt="Brand logo {$product_manufacturer->name}" />
					</a>
					
                    <h4>
                    {if isset($isPerks)}
                	<a >{$product_manufacturer->name}</a>
                    {else}
                    <a href="{$link->getmanufacturerLink($product_manufacturer->id_manufacturer, $product_manufacturer->link_rewrite)|escape:'html':'UTF-8'}">{$product_manufacturer->name}</a>
                    </h4>
                    {/if}
                    

                    {if ($product_manufacturer->short_description)}
					<p>{$product_manufacturer->short_description}</p>
                    {/if}
                    
                    {if !isset($isPerks)}
                    {if ($product_manufacturer->description)}
					<p>{$product_manufacturer->description|truncate:100:'..'|escape:'html':'UTF-8'}

                    <a class="blue_link"
                    href="{$link->getmanufacturerLink($product_manufacturer->id_manufacturer, $product_manufacturer->link_rewrite)|escape:'html':'UTF-8'}"
                    title="{$manufacturer.name|escape:'html':'UTF-8'}" >
                    More 
                    </a>
                    </p>
                    {/if}
                    {/if}
                    
				</div>
			</div>
		{/if}
	</div>
	

	<div class="panel-body" id="rating-tab" name="rating-tab">
		<!-- <span id="rating_product_tab"> &nbsp; </span> -->
		<h4>Ratings and Reviews</h4>
        {$HOOK_PRODUCT_TAB}
	    {if isset($HOOK_PRODUCT_TAB_CONTENT) && $HOOK_PRODUCT_TAB_CONTENT}{$HOOK_PRODUCT_TAB_CONTENT}{/if}
	</div>
		
	</div> <!-- end primary_block -->
	{if !$content_only}
		
		{if isset($packItems) && $packItems|@count > 0}
		<section id="blockpack">
			<h3 class="page-product-heading">{l s='Pack content'}</h3>
			{include file="$tpl_dir./product-list.tpl" products=$packItems}
		</section>
		{/if}
		
		{if isset($accessories) && $accessories}
			<!--Accessories -->
			<section class="page-product-box">
				<h3 class="page-product-heading">{l s='Accessories'}</h3>
				<div class="block products_block accessories-block clearfix">
					<div class="block_content">
						<ul id="bxslider" class="bxslider clearfix">
							{foreach from=$accessories item=accessory name=accessories_list}
								{if ($accessory.allow_oosp || $accessory.quantity_all_versions > 0 || $accessory.quantity > 0) && $accessory.available_for_order && !isset($restricted_country_mode)}
									{assign var='accessoryLink' value=$link->getProductLink($accessory.id_product, $accessory.link_rewrite, $accessory.category)}
									<li class="item product-box ajax_block_product{if $smarty.foreach.accessories_list.first} first_item{elseif $smarty.foreach.accessories_list.last} last_item{else} item{/if} product_accessories_description">
										<div class="product_desc">
											<a href="{$accessoryLink|escape:'html':'UTF-8'}" title="{$accessory.legend|escape:'html':'UTF-8'}" class="product-image product_image">
												<img class="lazyOwl" src="{$link->getImageLink($accessory.link_rewrite, $accessory.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{$accessory.legend|escape:'html':'UTF-8'}" width="{$homeSize.width}" height="{$homeSize.height}"/>
											</a>
											<div class="block_description">
												<a href="{$accessoryLink|escape:'html':'UTF-8'}" title="{l s='More'}" class="product_description">
													{$accessory.description_short|strip_tags|truncate:25:'...'}
												</a>
											</div>
										</div>
										<div class="s_title_block">
											<h5 itemprop="name" class="product-name">
												<a href="{$accessoryLink|escape:'html':'UTF-8'}">
													{$accessory.name|truncate:20:'...':true|escape:'html':'UTF-8'}
												</a>
											</h5>
											{if $accessory.show_price && !isset($restricted_country_mode) && !$PS_CATALOG_MODE}
											<span class="price">
												{if $priceDisplay != 1}
													{displayWtPrice p=$accessory.price}
												{else}
													{displayWtPrice p=$accessory.price_tax_exc}
												{/if}
												{hook h="displayProductPriceBlock" product=$accessory type="price"}
											</span>
											{/if}
											{hook h="displayProductPriceBlock" product=$accessory type="after_price"}
										</div>
										{if $productPrice>0}
 											<div class="clearfix" style="margin-top:5px">
												{if !$PS_CATALOG_MODE && ($accessory.allow_oosp || $accessory.quantity > 0) && isset($add_prod_display) && $add_prod_display == 1}
													<div class="no-print">
														<a class="exclusive button ajax_add_to_cart_button" href="{$link->getPageLink('cart', true, NULL, "qty=1&amp;id_product={$accessory.id_product|intval}&amp;token={$static_token}&amp;add")|escape:'html':'UTF-8'}" data-id-product="{$accessory.id_product|intval}" title="{l s='Add to cart'}">
															<span>{l s='Add to cart'}</span>
														</a>
													</div>
												{/if}
											</div>
										{else}
											<button class="button-outline contact-for-price" onclick="online_chat();">Contact us for price</button>
										{/if}
														
										
										
										
									</li>
								{/if}
							{/foreach}
						</ul>
					</div>
				</div>
			</section>
			<!--end Accessories -->
		{/if}
		{if isset($HOOK_PRODUCT_FOOTER) && $HOOK_PRODUCT_FOOTER}{$HOOK_PRODUCT_FOOTER}{/if}
		<!-- description & features -->
		{if (isset($product) && $product->description) || (isset($features) && $features) || (isset($accessories) && $accessories) || (isset($HOOK_PRODUCT_TAB) && $HOOK_PRODUCT_TAB) || (isset($attachments) && $attachments) || isset($product) && $product->customizable}
			{if isset($attachments) && $attachments}
			<!--Download -->
			{*
			<section class="page-product-box">
				<h3 class="page-product-heading">{l s='Download'}</h3>
				{foreach from=$attachments item=attachment name=attachements}
					{if $smarty.foreach.attachements.iteration %3 == 1}<div class="row">{/if}
						<div class="col-lg-4">
							<h4><a href="{$link->getPageLink('attachment', true, NULL, "id_attachment={$attachment.id_attachment}")|escape:'html':'UTF-8'}">{$attachment.name|escape:'html':'UTF-8'}</a></h4>
							<p class="text-muted">{$attachment.description|escape:'html':'UTF-8'}</p>
							<a class="btn btn-default btn-block" href="{$link->getPageLink('attachment', true, NULL, "id_attachment={$attachment.id_attachment}")|escape:'html':'UTF-8'}">
								<i class="icon-download"></i>
								{l s="Download"} ({Tools::formatBytes($attachment.file_size, 2)})
							</a>
							<hr />
						</div>
					{if $smarty.foreach.attachements.iteration %3 == 0 || $smarty.foreach.attachements.last}</div>{/if}
				{/foreach}
			</section>
			*}
			<!--end Download -->
			{/if}
			{if isset($product) && $product->customizable}
			<!--Customization -->
			<section class="page-product-box">
				<h3 class="page-product-heading">{l s='Product customization'}</h3>
				<!-- Customizable products -->
				<form method="post" action="{$customizationFormTarget}" enctype="multipart/form-data" id="customizationForm" class="clearfix">
					<p class="infoCustomizable">
						{l s='After saving your customized product, remember to add it to your cart.'}
						{if $product->uploadable_files}
						<br />
						{l s='Allowed file formats are: GIF, JPG, PNG'}{/if}
					</p>
					{if $product->uploadable_files|intval}
						<div class="customizableProductsFile">
							<h5 class="product-heading-h5">{l s='Pictures'}</h5>
							<ul id="uploadable_files" class="clearfix">
								{counter start=0 assign='customizationField'}
								{foreach from=$customizationFields item='field' name='customizationFields'}
									{if $field.type == 0}
										<li class="customizationUploadLine{if $field.required} required{/if}">{assign var='key' value='pictures_'|cat:$product->id|cat:'_'|cat:$field.id_customization_field}
											{if isset($pictures.$key)}
												<div class="customizationUploadBrowse">
													<img src="{$pic_dir}{$pictures.$key}_small" alt="" />
														<a href="{$link->getProductDeletePictureLink($product, $field.id_customization_field)|escape:'html':'UTF-8'}" title="{l s='Delete'}" >
															<img src="{$img_dir}icon/delete.gif" alt="{l s='Delete'}" class="customization_delete_icon" width="11" height="13" />
														</a>
												</div>
											{/if}
											<div class="customizationUploadBrowse form-group">
												<label class="customizationUploadBrowseDescription">
													{if !empty($field.name)}
														{$field.name}
													{else}
														{l s='Please select an image file from your computer'}
													{/if}
													{if $field.required}<sup>*</sup>{/if}
												</label>
												<input type="file" name="file{$field.id_customization_field}" id="img{$customizationField}" class="form-control customization_block_input {if isset($pictures.$key)}filled{/if}" />
											</div>
										</li>
										{counter}
									{/if}
								{/foreach}
							</ul>
						</div>
					{/if}
					{if $product->text_fields|intval}
						<div class="customizableProductsText">
							<h5 class="product-heading-h5">{l s='Text'}</h5>
							<ul id="text_fields">
							{counter start=0 assign='customizationField'}
							{foreach from=$customizationFields item='field' name='customizationFields'}
								{if $field.type == 1}
									<li class="customizationUploadLine{if $field.required} required{/if}">
										<label for ="textField{$customizationField}">
											{assign var='key' value='textFields_'|cat:$product->id|cat:'_'|cat:$field.id_customization_field}
											{if !empty($field.name)}
												{$field.name}
											{/if}
											{if $field.required}<sup>*</sup>{/if}
										</label>
										<textarea name="textField{$field.id_customization_field}" class="form-control customization_block_input" id="textField{$customizationField}" rows="3" cols="20">{strip}
											{if isset($textFields.$key)}
												{$textFields.$key|stripslashes}
											{/if}
										{/strip}</textarea>
									</li>
									{counter}
								{/if}
							{/foreach}
							</ul>
						</div>
					{/if}
					<p id="customizedDatas">
						<input type="hidden" name="quantityBackup" id="quantityBackup" value="" />
						<input type="hidden" name="submitCustomizedDatas" value="1" />
						<button class="button btn btn-default button button-small" name="saveCustomization">
							<span>{l s='Save'}</span>
						</button>
						<span id="ajax-loader" class="unvisible">
							<img src="{$img_ps_dir}loader.gif" alt="loader" />
						</span>
					</p>
				</form>
				<p class="clear required"><sup>*</sup> {l s='required fields'}</p>
			</section>
			<!--end Customization -->
			{/if}
		{/if}
	{/if}
</div> <!-- itemscope product wrapper -->
<!-- Fancybox -->
<div style="display:none">
	<div id="fancybox-bulk-enq">
		<div id="bq-edge-small">
		KOBSTER<span> EDGE</span>
		</div>
		<form method="post" enctype="multipart/form-data" id="bq_product_form">
			<div id="bg-get-details">
				<div>
					 <h3>{$product->name|escape:'htmlall':'UTF-8'}</h3> 
					 <input type="hidden" id="product_name" name="product_name" value="{$product->name}" />
					 <input type="hidden" id="id_product" name="id_product" value="{$product->id|intval}" />
				</div>
				<div class="question-row">
					<p>1. What is the estimated quantity of your requirement?</p>
					<input type="text" class="form-control" placeholder="Estimated Quantity" id="bq_quantity" name="bq_quantity"/>
					<select id="bq_qty_unit" class="form-control" name="bq_qty_unit" data-no-uniform="true">
						<option value="unit">Units</option>
						<option value="box">Boxes</option>
						<option value="con">Containers</option>
					</select>
					<p class="bq_error alert alert-error" id="bq-qty-error">Please enter a valid quantity.</p>
				</div>
				<div class="question-row">
					<p>2. Do you have a target price?</p>
                    
					<select id="bq_select_price" name="bq_select_price" class="noUniform form-control hidden">
						<option value="inr">INR</option>
						<option value="usd">USD</option>
					</select>
                    
					<input type="text" placeholder="Target Price" id="bq_target_price" name="bq_target_price" class="form-control"/>
					<select id="bq-select-unit" class="noUniform form-control">
						<option value="unit">Per Unit</option>
					</select>
					<p class="bq_hint" id="bq_hint_price">Target price is your expected price for this product. If not sure, leave it blank. The market price for this product is {convertPrice price=$productPrice}.</p>
					<p class="bq_error alert alert-error" id="bq-price-error">Please enter a valid Price.</p>
				</div>
				<div class="question-row">
					<p>3. Where do you want these products delivered?</p>
					<input type="text" placeholder="Pin-Code" id="bq_pincode" class="form-control" name="bq_pincode" maxlength="6"/>
					<p class="bq_hint" id="bq_hint_pin_code">Please enter the Pin-Code of the location where you need these products to be delivered.</p>
					<p class="bq_error alert alert-error" id="bq-pin-code-error">Please enter a valid Pin Code.</p>
				</div>
				<div class="question-row">
					<p>4. Do you need Credit Payment Facility?</p> 
                    <div class="radio-vertical">
						<input class="noUniform" type="radio" name="bq_credit" id="bq_credit" value="1"> <label for="bq_credit">Yes</label>
					</div>
                    <div class="radio-vertical">
						<input class="noUniform" type="radio" name="bq_credit" value="0" checked> <label for="bq_credit">No</label>
					</div> 
					<!-- <label><input type="radio" class="form-control" name="bq_credit" id="bq_credit" value="1">Yes</input></label><label><input type="radio" class="form-control" name="bq_credit" value="0" checked>No</input></label> -->
					<p class="bq_hint" id="bq_hint_credit">Available Only for verified buyers.</p>
				</div>
				<div class="question-row">
					<p>5. Please provide any other details about your requirement.</p>  
					<textarea rows="3" class="form-control" id="bq_other_details" name="bq_other_details" placeholder="Other Details"></textarea> 
				</div>
				<div class="action">
					<input type="button" class="button-red" value="Get Quote" id="bq_get_quote" />
				</div>
			</div>

			<div id="bq_auth" style="display:none">
				<div>
					 <h3>Sign Up or Sign In to Continue</h3> 
				</div>
 				<div class="bq_new_acc">
						<input type="text" class="form-control" placeholder="Name" id="bq_name" />
						<p class="bq_error alert-error" id="bq-name-error">Please enter a valid Name</p>
				</div>
 				<div>
					<input type="text" class="form-control" placeholder="Email" id="bq_email" name="bq_email" {if $cookie->isLogged()} value={$cookie->email} {/if} />
					<p class="bq_error alert-error" id="bq-email-error">Please enter a valid Email.</p>
					<input type="hidden" id="bq_id_customer" name="bq_id_customer" {if $cookie->isLogged()}value="{$cookie->id_customer|intval}"{/if} />
				</div>
				<div>
					<input type="password" class="form-control" placeholder="Password" id="bq_password" name="bq_password" />
					<p class="bq_error alert-error" id="bq-password-error">Please enter a valid Password. Minimum 5 characters.</p>
				</div>
				<div class="bq_new_acc">
					<input type="text" class="form-control" placeholder="Phone" id="bq_phone"/>
					<p class="bq_error alert-error" id="bq-phone-error">Please enter a valid Phone Number.</p>
				</div>
				<div>
					{* <label><input type="checkbox" id="bq-kob-account">I have a Kobster Account</label> *}
					<input type="checkbox" id="bq-kob-account">
      				<label for="bq-kob-account">I have a Kobster Account</label>
				</div>
				<div>
					<input type="button" value="Sign In" id="bq_sign_in" />
					<p class="bq_error alert-error" id="bq-login-error">Login Failed. Please check your email & password</p>
					<p class="bq_error alert-error" id="bq-acc-exists">An account is already registered with this e-mail, please login with your existing password.</p>
				</div>
				
				<div >
					<!--<div class="bq_new_acc">
						<input type="text" placeholder="Name" id="bq_name" onFocus="bqShowHint(8);" onBlur="bqHideHint(8);" />
						<p class="bq_error" id="bq-name-error">Please enter a valid Name</p>
					</div>-->
					<!--<div class="bq_new_acc">
						<input type="text" placeholder="Phone" id="bq_phone" onFocus="bqShowHint(9);" onBlur="bqHideHint(9);" />
						<p class="bq_error" id="bq-phone-error">Please enter a valid Phone Number.</p>
					</div>-->
					<div class="bq_new_acc">
						<input type="button" value="Create Account & Proceed" id="bq_create_acc" />
						<p class="bq_error alert-error" id="bq-create-acc-error">Account Creation Failed. Please try again. If the problem persists Call Us at +91 44 6457 3222.</p>
					</div>
				</div>
			</div>
			
			<div id="bq_complete" style="display:none">
				<div>
					<div>
						 <h3>Thank you! Your request is being processed.</h3> 
					</div>
					<div id="bq_result_head">
						<p>This is what happens now</p>
					</div>
					<div>
						{*
						<ul id="bq_ul">
							<li>
								<div class="bq_icon" id="bq_broadcast"></div>
								<div class="bq_caption">Request is Broadcast</div>
							</li>
							<li>
								<div class="bq_arrow"></div>
							</li>
							<li>
								<div class="bq_icon" id="bq_supplier"></div>
								<div class="bq_caption">Supplier Submits Quote</div>
							</li>
							<li>
								<div class="bq_arrow"></div>
							</li>
							<li>
								<div class="bq_icon" id="bq_screen"></div>
								<div class="bq_caption">Kobster.com Screens Quotes</div>
							</li>
							<li>
								<div class="bq_arrow"></div>
							</li>
							<li>
								<div class="bq_icon" id="bq_best_quote"></div>
								<div class="bq_caption">You Select Best Deal</div>
							</li>
							<li>
								<div class="bq_arrow"></div>
							</li>
							<li>
								<div class="bq_icon" id="bq_delivery"></div>
								<div class="bq_caption">Kobster.com Fulfils Order</div>
							</li>
						</ul>
						*}
						<img class="bq_result_image" src="{$img_dir}Bulk-Request-Success.jpg" alt="">
					</div>
					<div class="clear"></div>
					<br />
					<div>
						<p>If you have questions, please contact us at <a href="#">1800 121 0405</a> or email us at <a href="mailto:support@kobster.com">support@kobster.com</a></p>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End fancybox -->

<script>
 locationcheck();
</script>


{strip}
{if isset($smarty.get.ad) && $smarty.get.ad}
	{addJsDefL name=ad}{$base_dir|cat:$smarty.get.ad|escape:'html':'UTF-8'}{/addJsDefL}
{/if}
{if isset($smarty.get.adtoken) && $smarty.get.adtoken}
	{addJsDefL name=adtoken}{$smarty.get.adtoken|escape:'html':'UTF-8'}{/addJsDefL}
{/if}
{addJsDef allowBuyWhenOutOfStock=$allow_oosp|boolval}
{addJsDef availableNowValue=$product->available_now|escape:'quotes':'UTF-8'}
{addJsDef availableLaterValue=$product->available_later|escape:'quotes':'UTF-8'}
{addJsDef attribute_anchor_separator=$attribute_anchor_separator|escape:'quotes':'UTF-8'}
{addJsDef attributesCombinations=$attributesCombinations}
{addJsDef currentDate=$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}
{if isset($combinations) && $combinations}
	{addJsDef combinations=$combinations}
	{addJsDef combinationsFromController=$combinations}
	{addJsDef displayDiscountPrice=$display_discount_price}
	{addJsDefL name='upToTxt'}{l s='Up to' js=1}{/addJsDefL}
{/if}
{if isset($combinationImages) && $combinationImages}
	{addJsDef combinationImages=$combinationImages}
{/if}
{addJsDef customizationId=$id_customization}
{addJsDef customizationFields=$customizationFields}
{addJsDef default_eco_tax=$product->ecotax|floatval}
{addJsDef displayPrice=$priceDisplay|intval}
{addJsDef ecotaxTax_rate=$ecotaxTax_rate|floatval}
{if isset($cover.id_image_only)}
	{addJsDef idDefaultImage=$cover.id_image_only|intval}
{else}
	{addJsDef idDefaultImage=0}
{/if}
{addJsDef img_ps_dir=$img_ps_dir}
{addJsDef img_prod_dir=$img_prod_dir}
{addJsDef id_product=$product->id|intval}
{addJsDef jqZoomEnabled=$jqZoomEnabled|boolval}
{addJsDef maxQuantityToAllowDisplayOfLastQuantityMessage=$last_qties|intval}
{addJsDef minimalQuantity=$product->minimal_quantity|intval}
{addJsDef noTaxForThisProduct=$no_tax|boolval}
{if isset($customer_group_without_tax)}
	{addJsDef customerGroupWithoutTax=$customer_group_without_tax|boolval}
{else}
	{addJsDef customerGroupWithoutTax=false}
{/if}
{if isset($group_reduction)}
	{addJsDef groupReduction=$group_reduction|floatval}
{else}
	{addJsDef groupReduction=false}
{/if}
{addJsDef oosHookJsCodeFunctions=Array()}
{addJsDef productHasAttributes=isset($groups)|boolval}
{addJsDef productPriceTaxExcluded=($product->getPriceWithoutReduct(true)|default:'null' - $product->ecotax)|floatval}
{addJsDef productPriceTaxIncluded=($product->getPriceWithoutReduct(false)|default:'null' - $product->ecotax * (1 + $ecotaxTax_rate / 100))|floatval}
{addJsDef productBasePriceTaxExcluded=($product->getPrice(false, null, 6, null, false, false) - $product->ecotax)|floatval}
{addJsDef productBasePriceTaxExcl=($product->getPrice(false, null, 6, null, false, false)|floatval)}
{addJsDef productBasePriceTaxIncl=($product->getPrice(true, null, 6, null, false, false)|floatval)}
{addJsDef productReference=$product->reference|escape:'html':'UTF-8'}
{addJsDef productAvailableForOrder=$product->available_for_order|boolval}
{addJsDef productPriceWithoutReduction=$productPriceWithoutReduction|floatval}
{addJsDef productPrice=$productPrice|floatval}
{addJsDef productUnitPriceRatio=$product->unit_price_ratio|floatval}
{addJsDef productShowPrice=(!$PS_CATALOG_MODE && $product->show_price)|boolval}
{addJsDef PS_CATALOG_MODE=$PS_CATALOG_MODE}
{if $product->specificPrice && $product->specificPrice|@count}
	{addJsDef product_specific_price=$product->specificPrice}
{else}
	{addJsDef product_specific_price=array()}
{/if}
{if $display_qties == 1 && $product->quantity}
	{addJsDef quantityAvailable=$product->quantity}
{else}
	{addJsDef quantityAvailable=0}
{/if}
{addJsDef quantitiesDisplayAllowed=$display_qties|boolval}
{if $product->specificPrice && $product->specificPrice.reduction && $product->specificPrice.reduction_type == 'percentage'}
	{addJsDef reduction_percent=$product->specificPrice.reduction*100|floatval}
{else}
	{addJsDef reduction_percent=0}
{/if}
{if $product->specificPrice && $product->specificPrice.reduction && $product->specificPrice.reduction_type == 'amount'}
	{addJsDef reduction_price=$product->specificPrice.reduction|floatval}
{else}
	{addJsDef reduction_price=0}
{/if}
{if $product->specificPrice && $product->specificPrice.price}
	{addJsDef specific_price=$product->specificPrice.price|floatval}
{else}
	{addJsDef specific_price=0}
{/if}
{addJsDef specific_currency=($product->specificPrice && $product->specificPrice.id_currency)|boolval} {* TODO: remove if always false *}
{addJsDef stock_management=$PS_STOCK_MANAGEMENT|intval}
{addJsDef taxRate=$tax_rate|floatval}
{addJsDefL name=doesntExist}{l s='This combination does not exist for this product. Please select another combination.' js=1}{/addJsDefL}
{addJsDefL name=doesntExistNoMore}{l s='This product is no longer in stock' js=1}{/addJsDefL}
{addJsDefL name=doesntExistNoMoreBut}{l s='with those attributes but is available with others.' js=1}{/addJsDefL}
{addJsDefL name=fieldRequired}{l s='Please fill in all the required fields before saving your customization.' js=1}{/addJsDefL}
{addJsDefL name=uploading_in_progress}{l s='Uploading in progress, please be patient.' js=1}{/addJsDefL}
{addJsDefL name='product_fileDefaultHtml'}{l s='No file selected' js=1}{/addJsDefL}
{addJsDefL name='product_fileButtonHtml'}{l s='Choose File' js=1}{/addJsDefL}
{/strip}
{/if}
