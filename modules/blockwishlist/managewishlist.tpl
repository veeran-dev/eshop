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
 

{if $products}
{if !$refresh}
	<!-- <br />
	<a href="#" id="hideBoughtProducts" class="button_account"  onclick="WishlistVisibility('wlp_bought', 'BoughtProducts'); return false;">{l s='Hide products' mod='blockwishlist'}</a>
	<a href="#" id="showBoughtProducts" class="button_account"  onclick="WishlistVisibility('wlp_bought', 'BoughtProducts'); return false;">{l s='Show products' mod='blockwishlist'}</a>
	{if count($productsBoughts)}
	<a href="#" id="hideBoughtProductsInfos" class="button_account" onclick="WishlistVisibility('wlp_bought_infos', 'BoughtProductsInfos'); return false;">{l s='Hide bought product\'s info' mod='blockwishlist'}</a>
	<a href="#" id="showBoughtProductsInfos" class="button_account"  onclick="WishlistVisibility('wlp_bought_infos', 'BoughtProductsInfos'); return false;">{l s='Show bought product\'s info' mod='blockwishlist'}</a>
	{/if}
	<a href="#" id="showSendWishlist" class="button_account" onclick="WishlistVisibility('wl_send', 'SendWishlist'); return false;">{l s='Send this wishlist' mod='blockwishlist'}</a>
	<a href="#" id="hideSendWishlist" class="button_account" onclick="WishlistVisibility('wl_send', 'SendWishlist'); return false;">{l s='Close send this wishlist' mod='blockwishlist'}</a>
	<span class="clear"></span>
	<br /> -->
	<!-- Permalink :<br/><input type="text" value="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}modules/blockwishlist/view.php?token={$token_wish|escape:'htmlall':'UTF-8'}" style="width:540px;" readonly/> -->
{/if}

	<div class="backgroundQuickView"></div>
	
	<div id="order_confirm_box">
		<a onClick="return false;" id="orderConfirmClose" class="quickViewClose" href="#qvb_{$product.id_product}"><img src="https://www.kobster.com/images/Close.png" /></a>
		<h2>All the products in your Purchase List have been added</h2>
		<h2>Add more products</h2>
		<h2>Proceed to Order Finalization</h2>
	</div>
	
	<div class="wlp_bought">
    
	<div class="purchase_list_div">
	{foreach from=$products item=product name=i}
		<div class="purchase_list_item_div" onmouseover="document.getElementById('button_{$product.id_product}').style.visibility = 'visible';"
		onmouseout="document.getElementById('button_{$product.id_product}').style.visibility = 'hidden';" >
			<span class="pur_list_left_img">
				<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)}" target="_blank" title="{l s='Product detail' mod='blockwishlist'}">
					<img src="{$link->getImageLink($product.link_rewrite, $product.cover, 'medium')}" />
				</a>
				<a onClick="return false;" href="#qvb_{$product.id_product}" class="quickViewButton" id="button_{$product.id_product}"><img src="https://www.kobster.com/images/quickView.jpg"/></a>
			</span>
			<span class="pur_list_left_name">
				<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)}" target="_blank" title="{l s='Product detail' mod='blockwishlist'}">
					{$product.name|truncate:60:'...'|escape:'htmlall':'UTF-8'}
				</a>
				<div>
					<p>{$product.description_short|truncate:100:'...'|strip_tags}</p>
					{if $product.reference}<p>Product Code: <b>{$product.reference}</b></p>{/if}
				</div>
			</span>
			<span class="pur_list_right_price">{convertPrice price=$product.price_tax_exc}</span>
			
			
			<span class="pur_list_right_quantity">
				<input tabindex="{$smarty.foreach.i.index}" type="text" name="qty"  onfocus="fun_position_up();" id="{$smarty.foreach.i.index}_pur_quantity_wanted" class="qv_quantity_wanted"  size="2" maxlength="3" {if $product->minimal_quantity > 1}{/if} onchange="updateTotalPrice({$product.id_product}, {$product.price_tax_exc}, this, {sizeof($products)}, {$id_wishlist}, {$product.id_product_attribute});" value="{if isset($product.wishlist_quantity)}{$product.wishlist_quantity|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}0{/if}{/if}" {if $smarty.foreach.i.index==0}{/if} />
			</span>
			
			<span class="pur_list_right_final_price">
				Rs. <output id="{$product.id_product}_final_price" class="final_price">0</output>
			</span>
		</div>
		
		<!--
		<ul class="address {if $smarty.foreach.i.index % 2}alternate_{/if}item" style="margin:5px 0 0 5px;border-bottom:1px solid #ccc;" id="wlp_{$product.id_product}_{$product.id_product_attribute}">
			<li class="address_title">{$product.name|truncate:30:'...'|escape:'htmlall':'UTF-8'}</li>
			<li class="address_name">
				<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)}" title="{l s='Product detail' mod='blockwishlist'}">
					<img src="{$link->getImageLink($product.link_rewrite, $product.cover, 'medium')}" alt="{$product.name|escape:'htmlall':'UTF-8'}" />
				</a>
			<span class="wishlist_product_detail">
			{if isset($product.attributes_small)}
				<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)}" title="{l s='Product detail' mod='blockwishlist'}">{$product.attributes_small|escape:'htmlall':'UTF-8'}</a>
			{/if}
				<br />{l s='Quantity' mod='blockwishlist'}:<input type="text" id="quantity_{$product.id_product}_{$product.id_product_attribute}" value="{$product.quantity|intval}" size="3"  />
				<br /><br />{l s='Priority' mod='blockwishlist'}: <select id="priority_{$product.id_product}_{$product.id_product_attribute}">
					<option value="0"{if $product.priority eq 0} selected="selected"{/if}>{l s='High' mod='blockwishlist'}</option>
					<option value="1"{if $product.priority eq 1} selected="selected"{/if}>{l s='Medium' mod='blockwishlist'}</option>
					<option value="2"{if $product.priority eq 2} selected="selected"{/if}>{l s='Low' mod='blockwishlist'}</option>
				</select>
			</span>
				<a href="javascript:;" class="clear button" onclick="WishlistProductManage('wlp_bought', 'delete', '{$id_wishlist}', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Delete' mod='blockwishlist'}">{l s='Delete' mod='blockwishlist'}</a>
				<a href="javascript:;" class="exclusive" onclick="WishlistProductManage('wlp_bought_{$product.id_product_attribute}', 'update', '{$id_wishlist}', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Save' mod='blockwishlist'}">{l s='Save' mod='blockwishlist'}</a>
				<br />
			</li>
		</ul>
		-->		
		<div class="clear">&nbsp;</div>
	{/foreach}	
	</div>
	
	<!-- <div class="purchase_list_totals">
		<!-- <span>Total Products: <output id="total_products">0</output></span>
		<span>Total Order Value: Rs. <output id="total_price">0</output></span>
	</div>
	
	<div class="purchase_list_final">
		<span><a src="#"><img src="{$img_dir}icon/estimate.png" alt="" class="icon" />Generate Estimate</a></span>
		<span><a src="#"><img src="{$img_dir}icon/approved.png" alt="" class="icon" />Submit For Approval</a></span>
		<span><a src="#" class="confirm_pur_list_all_prod" href="#"><img src="{$img_dir}icon/order.png" alt="" class="icon" />Confirm Order</a></span>
	</div> -->
	
{foreach from=$products item=product name=products key=k}
<div id="qvb_{$product.id_product}" class="quickView">
<div>

		<a onClick="return false;" class="quickViewClose" href="#qvb_{$product.id_product}"><img src="https://www.kobster.com/images/Close.png" /></a>
		<div class="quickView_left">
			<a href="{$product.link|escape:'htmlall':'UTF-8'}" target="_blank" class="quickView_product_img_link" title="{$product.name|escape:'htmlall':'UTF-8'}">
				<img class="lazyImage" src="{$link->getImageLink($product.link_rewrite, $product.cover, 'large')}" alt="{$product.legend|escape:'htmlall':'UTF-8'}" width="300px" height="300px" />
			</a>
			<p class="quickView_product_desc">{$product.description_short|strip_tags:'UTF-8'|truncate:300}</p>		
		</div>
		
		<div class="quickView_right">
			<h3 class="quickView_name">{$product.name|escape:'htmlall':'UTF-8'}</h3>
			<!--<div id="p_rating">
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
			</div>-->
			<!--<p class="qv_prod_desc">{$product.description|truncate:300:'...'|strip_tags:'UTF-8'}</p>
			<br />
				<a class="qv_more_details" href="{$product.link|escape:'htmlall':'UTF-8'}">Click here to know more details & customization options about this product</a>
			<br /><br />-->
            
            <div id="quick_price_sec" {if ($product.reference == "")} style="display:none"{/if}>
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
           </div>
           
            <div id="price_section" >
                <div id="price_div" style="width:50%">
                    <div class="qv_product_price">
                    	<div class="quickView_price"><span class="quick_price">{convertPrice price=$product.price_tax_exc}</span></div>
                    </div>
                </div> 
             
            </div>
			 <!--end of  the discount part-->
			{if (!$product.allow_oosp && $product.quantity < 0)}
				<p class="quickView_outofstock">This product is Out of Stock.</p>
			{else}
				<div class="quickView_carousel_buttons">
                	<div id="quick_quanity">
                    	<div id="quick_quantity_div">QTY: </div>
						<input type="text" name="qty" id="{$product.id_product}_qv_quantity_wanted" class="quickView_quantity_wanted" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product.minimal_quantity > 1}{$product.minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $product.minimal_quantity > 1}onkeyup="checkMinimalQuantityListQV({$product.id_product}, {$product.minimal_quantity});"{/if} />
                    </div>
                    
                    <div id="quick_button">
						<a class="qv_ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product|intval}" href="{$link->getPageLink('cart.php')}?add&amp;id_product={$product.id_product|intval}&amp;{if isset($static_token)}&amp;token={$static_token}{/if}" title="{l s='BUY NOW'}"><label id="quick_buynow">BUY NOW</label></a>
                        <div id="quick_call2buy">Call 044 64573222 to Buy </div>
                    </div>
				</div>
			{/if}
             <p class="quickView_product_desc_right" style="display:none;">{$product.description_short|strip_tags:'UTF-8'}</p>
		</div>
       

	 </div>
     
    <div id="quick_bottom">
        <div id="quick_gen"><span id="static_100" style="color:#7f7f7f; margin-left:40px;">100% GENUINE & BRAND NEW PRODUCTS</span></div>
        <div id="quick_ship"><span id="static_ship" style="color:#7f7f7f; margin-left:100px;">FREE SHIPPING ON ORDER ABOVE <b>Rs. 1500</b></span></div>
    </div>
    </div>
{/foreach}

	<div>
		
	</div>
	</div>
	<div class="clear"></div>
	<br />
	{if !$refresh}
	<form method="post" class="wl_send std hidden" onsubmit="return (false);">
		<fieldset>
			<p class="required">
				<label for="email1">{l s='Email' mod='blockwishlist'}1</label>
				<input type="text" name="email1" id="email1" />
				<sup>*</sup>
			</p>
			{section name=i loop=11 start=2}
			<p>
				<label for="email{$smarty.section.i.index}">{l s='Email' mod='blockwishlist'}{$smarty.section.i.index}</label>
				<input type="text" name="email{$smarty.section.i.index}" id="email{$smarty.section.i.index}" />
			</p>
			{/section}
			<p class="submit">
				<input class="button" type="submit" value="{l s='Send' mod='blockwishlist'}" name="submitWishlist" onclick="WishlistSend('wl_send', '{$id_wishlist}', 'email');" />
			</p>
			<p class="required">
				<sup>*</sup>
				{l s='Required field'}
			</p>
		</fieldset>
	</form>
	{if count($productsBoughts)}
	<table class="wlp_bought_infos hidden std">
		<thead>
			<tr>
				<th class="first_item">{l s='Product' mod='blockwishlist'}</td>
				<th class="item">{l s='Quantity' mod='blockwishlist'}</td>
				<th class="item">{l s='Offered by' mod='blockwishlist'}</td>
				<th class="last_item">{l s='Date' mod='blockwishlist'}</td>
			</tr>
		</thead>
		<tbody>
		{foreach from=$productsBoughts item=product name=i}
			{foreach from=$product.bought item=bought name=j}
			{if $bought.quantity > 0}
				<tr>
					<td class="first_item">
					<span style="float:left;"><img src="{$link->getImageLink($product.link_rewrite, $product.cover, 'small')}" alt="{$product.name|escape:'htmlall':'UTF-8'}" /></span>			
					<span style="float:left;">{$product.name|truncate:40:'...'|escape:'htmlall':'UTF-8'}
					{if isset($product.attributes_small)}
						<br /><i>{$product.attributes_small|escape:'htmlall':'UTF-8'}</i>
					{/if}</span>
					</td>
					<td class="item align_center">{$bought.quantity|intval}</td>
					<td class="item align_center">{$bought.firstname} {$bought.lastname}</td>
					<td class="last_item align_center">{$bought.date_add|date_format:"%Y-%m-%d"}</td>
				</tr>
			{/if}
			{/foreach}
		{/foreach}
		</tbody>
	</table>
	{/if}
	{/if}
{else}
	{l s='No products' mod='blockwishlist'}
{/if}
