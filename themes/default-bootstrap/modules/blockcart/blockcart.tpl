{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!-- MODULE Block cart -->
{if isset($blockcart_top) && $blockcart_top}
<div class="hidden col-sm-4 clearfix{if $PS_CATALOG_MODE} header_user_catalog{/if}">
{/if}
	<div class="shopping_cart">
		<div class="{if isset($colapseExpandStatus) && $colapseExpandStatus eq 'collapsed'}block_cart_expand{/if}{if !isset($colapseExpandStatus) || (isset($colapseExpandStatus) && $colapseExpandStatus eq 'expanded')}block_cart_collapse{/if}">
        
			<b>{l s='My Cart' mod='blockcart'}</b> &nbsp;
			<span class="ajax_cart_quantity{if $cart_qties == 0} unvisible{/if}">{$cart_qties}</span>
			<span class="ajax_cart_product_txt{if $cart_qties != 1} unvisible{/if}">{l s='Product' mod='blockcart'}</span>
			<span class="ajax_cart_product_txt_s{if $cart_qties < 2} unvisible{/if}">{l s='Products' mod='blockcart'}</span>
			<span class="ajax_cart_total{if $cart_qties == 0} unvisible{/if}">
				{if $cart_qties > 0}
					{if $priceDisplay == 1}
						{assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
						{convertPrice price=$cart->getOrderTotal(false, $blockcart_cart_flag)}
					{else}
						{assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
						{convertPrice price=$cart->getOrderTotal(true, $blockcart_cart_flag)}
					{/if}
				{/if}
			</span>
			<span class="ajax_cart_no_product{if $cart_qties > 0} unvisible{/if}">{l s='(empty)' mod='blockcart'}</span>
		</div>
		{if !$PS_CATALOG_MODE}
			<div class="cart_block block exclusive">
				<div class="block_content">
					<!-- block list of products -->
					<div class="cart_block_list{if isset($blockcart_top) && !$blockcart_top}{if isset($colapseExpandStatus) && $colapseExpandStatus eq 'expanded' || !$ajax_allowed || !isset($colapseExpandStatus)} expanded{else} collapsed unvisible{/if}{/if}">
						{if $products}
							<dl class="products">
							<table class="table table-broder" id="cart_product_table">
								<th>Product</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>&nbsp;</th>
								{foreach from=$products item='product' name='myLoop'}
									{assign var='productId' value=$product.id_product}
									{assign var='productAttributeId' value=$product.id_product_attribute}
									<tr id="cart_block_product_{$product.id_product|intval}_{if $product.id_product_attribute}{$product.id_product_attribute|intval}{else}0{/if}_{if $product.id_address_delivery}{$product.id_address_delivery|intval}{else}0{/if}" class="form-group {if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
										<td>
											<div>
											<strong><a class="cart_block_product_name" href="{$link->getProductLink($product, $product.link_rewrite, $product.category, null, null, $product.id_shop, $product.id_product_attribute)|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">{$product.name|truncate:20:'...'|escape:'html':'UTF-8'}</a></strong>
											</div>
											{if isset($product.attributes_small)}
												<div class="product-atributes">
													<a href="{$link->getProductLink($product, $product.link_rewrite, $product.category, null, null, $product.id_shop, $product.id_product_attribute)|escape:'html':'UTF-8'}" title="{l s='Product detail' mod='blockcart'}">{$product.attributes_small}</a>
												</div>
											{/if}
											<div>
											 
												{if $priceDisplay == $smarty.const.PS_TAX_EXC}{l s={convertPrice price=$product.price|string_format:"%.2f"} }{else}{l s={convertPrice price=$product.price_wt|string_format:"%.2f"}}{/if}
											</div>
										</td>
 										<!--<td>
											<input size="5" maxlength="5" type="text" class="form-control cart_quantity_input" id="cart_qty_{$product.id_product}_{$product.id_product_attribute}" name ="cart_qty_{$product.id_product}_{$product.id_product_attribute}" value="{$product.cart_quantity}" /><button onclick="cartUpdateQuantity({$product.id_product},{$product.id_product_attribute},{$product.id_address_delivery|intval},{if $quantityDisplayed > 0}nocustom{else}0{/if})"; ><i class="icon-repeat"></i></button>
										</td>-->										
										<td class="cart_quantity text-center quantity" data-title="{l s='Quantity'}">
											<input type="hidden" value="{if isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity}{/if}" name="quantity_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}_hidden" />
											<input size="2" type="text" autocomplete="off" class="cart_quantity_input form-control grey quantity_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}" value="{if isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity}{/if}"  name="quantity_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}" id="quantity_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}" />
											<div class="cart_quantity_button clearfix">
											{if $product.minimal_quantity < ($product.cart_quantity) OR $product.minimal_quantity <= 1}
											{*onclick="decreaseQty({$product.id_product},{$product.id_product_attribute},{$product.id_address_delivery|intval},0)"*}
												<a  rel="nofollow" class="cart_quantity_down btn btn-default button-minus" id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}"  title="{l s='Subtract'}">
											<span></span>
											</a>
											{else}
											{*onclick="decreaseQty({$product.id_product},{$product.id_product_attribute},{$product.id_address_delivery|intval},0)"*}
												<a  class="cart_quantity_down btn btn-default button-minus disabled"  id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}" title="{l s='You must purchase a minimum of %d of this product.' sprintf=$product.minimal_quantity}">
												<span></span>
											</a>
											{/if}
											{*onclick="increaseQty({$product.id_product},{$product.id_product_attribute},{$product.id_address_delivery|intval},0)"*}
												<a rel="nofollow"  class="cart_quantity_up btn btn-default button-plus" id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}_0_{$product.id_address_delivery|intval}"  title="{l s='Add'}"><span></span></a>
											</div>
										</td>										
										<td>
											<span class="price">
												{if !isset($product.is_gift) || !$product.is_gift}
													{if $priceDisplay == $smarty.const.PS_TAX_EXC}{displayWtPrice p="`$product.total`"}{else}{displayWtPrice p="`$product.total_wt`"}{/if}
                                                    <div class="hookDisplayProductPriceBlock-price">
                                                        {hook h="displayProductPriceBlock" product=$product type="price" from="blockcart"}
                                                    </div>
												{else}
													{l s='Free!' mod='blockcart'}
												{/if}
											</span>
										</td>
										<td>
											<span class="cart_product_remove">
												{if !isset($customizedDatas.$productId.$productAttributeId) && (!isset($product.is_gift) || !$product.is_gift)}
													<a class="ajax_cart_block_remove_link" href="{$link->getPageLink('cart', true, NULL, "delete=1&id_product={$product.id_product|intval}&ipa={$product.id_product_attribute|intval}&id_address_delivery={$product.id_address_delivery|intval}&token={$static_token}")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='remove this product from my cart' mod='blockcart'}"><span>&nbsp;</span></a>
												{/if}
											</span>
										</td>
									</tr>				
									
								{/foreach}
								</tr>
								<!--<td   id="cart_voucher" class="cart_voucher">-->
								
								
								</table>
								
									
								
								
							</dl>
						{/if}
						<p class="cart_block_no_products{if $products} unvisible{/if}"></p>
                        
                        <div class="apply-voucher {if $page_name =='order'}hidden{/if}">
                            <form action="{if $opc}{$link->getPageLink('order-opc', true)}{else}{$link->getPageLink('order', true)}{/if}" method="post" id="voucher">
                                <span class="voucher-label">{l s='COUPON CODE'}</span>
                                <fieldset>
                                    <input type="text" class="discount_name noUniform" id="discount_name" name="discount_name" value="{if isset($discount_name) && $discount_name}{$discount_name}{/if}" />									 
                                    <input type="hidden" name="submitDiscount" />
                                    <button type="submit" name="submitAddDiscount">{l s='APPLY'}</button>
                                </fieldset>
                                <input type="hidden" name="back" id="back" value="{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}">
                            </form>
                        </div>
                        
                        
						
						{assign var='free_ship' value=count($cart->getDeliveryAddressesWithoutCarriers(true, $errors))}
						<div class="cart-prices">
							<div class="cart-prices-line first-line">
								<span class="price cart_block_shipping_cost ajax_cart_shipping_cost{if !($page_name == 'order-opc') && $shipping_cost_float == 0 && (!$cart_qties || $cart->isVirtualCart() || !isset($cart->id_address_delivery) || !$cart->id_address_delivery || $free_ship)} unvisible{/if}">
									{if $shipping_cost_float == 0}
										 {if !($page_name == 'order-opc') && (!isset($cart->id_address_delivery) || !$cart->id_address_delivery)}{l s='To be determined' mod='blockcart'}{else}{l s='Free shipping!' mod='blockcart'}{/if}
									{else}
										{$shipping_cost}
									{/if}
								</span>
								<span{if !($page_name == 'order-opc') && $shipping_cost_float == 0 && (!$cart_qties || $cart->isVirtualCart() || !isset($cart->id_address_delivery) || !$cart->id_address_delivery || $free_ship)} class="unvisible"{/if}>
									{l s='Shipping' mod='blockcart'}
								</span>
							</div>
							{if $show_wrapping}
								<div class="cart-prices-line">
									{assign var='cart_flag' value='Cart::ONLY_WRAPPING'|constant}
									<span class="price cart_block_wrapping_cost">
										{if $priceDisplay == 1}
											{convertPrice price=$cart->getOrderTotal(false, $cart_flag)}{else}{convertPrice price=$cart->getOrderTotal(true, $cart_flag)}
										{/if}
									</span>
									<span>
										{l s='Wrapping' mod='blockcart'}
									</span>
							   </div>
							{/if}
							
							 
							
							
							{if $discounts}
								<div class="cart-prices-line">
									<span class="price cart_block_tax_cost">Rs. {$discounts}</span>
									<span>{l s='Discounts' mod='blockcart'}</span>
								</div>
							{/if}
							
							
							
							{if $show_tax && isset($tax_cost)}
								<div class="cart-prices-line">
									<span class="price cart_block_tax_cost ajax_cart_tax_cost">{$tax_cost}</span>
									<span>{l s='Tax' mod='blockcart'}</span>
								</div>
							{/if}
							<div class="cart-prices-line last-line">
								<span class="price cart_block_total ajax_block_cart_total">{$total}</span>
								<span>{l s='Order total' mod='blockcart'}</span>
							</div>
							{*{if $use_taxes && $display_tax_label && $show_tax}
								<p>
								{if $priceDisplay == 0}
									{l s='Prices are tax included' mod='blockcart'}
								{elseif $priceDisplay == 1}
									{l s='Prices are tax excluded' mod='blockcart'}
								{/if}
								</p>
							{/if}*}
						</div>
                        
                        <br />
                        
						<p class="deal-info">
							Cash on Delivery is available only for orders above <em>₹ 1,500</em><br>
							

                            <div class="b2b-alert-container-all">
                                <div class="b2b-alert-icon">
                                    <img src="{$img_dir}high-importance-16.png" class="importantance-icon" />
                                </div>
                                <div>
                                    We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.
                                </div>
                            </div>
                            
						</p>
                        
                        <br />

						<p class="cart-buttons">
							{if $page_name!='order'}
							<a id="button_order_cart" class="button-red" href="{$link->getPageLink("$order_process", true)|escape:"html":"UTF-8"}" title="{l s='Check out' mod='blockcart'}" rel="nofollow">
								{l s='Check out' mod='blockcart'}
							</a>
							{/if}
						</p>
					</div>
				</div>
			</div><!-- .cart_block -->
		{/if}
	</div>
{if isset($blockcart_top) && $blockcart_top}
</div>
{/if}
{counter name=active_overlay assign=active_overlay}
{if !$PS_CATALOG_MODE && $active_overlay == 1}
<div class="container">
	<div id="layer_cart">
		<div class="clearfix">
			<div class="layer_cart_product col-xs-12 col-md-6">
				<span class="cross" title="{l s='Close window' mod='blockcart'}"></span>
				<span class="title">
					<i class="icon-check"></i>{l s='Product successfully added to your cart' mod='blockcart'}
				</span>
				<div class="product-image-container layer_cart_img">
				</div>
				<div class="layer_cart_product_info">
					<span id="layer_cart_product_title" class="product-name"></span>
					<span id="layer_cart_product_attributes"></span>
					<div>
						<strong class="dark">{l s='Quantity' mod='blockcart'}</strong>
						<span id="layer_cart_product_quantity"></span>
					</div>
					<div>
						<strong class="dark">{l s='Total' mod='blockcart'}</strong>
						<span id="layer_cart_product_price"></span>
					</div>
				</div>
			</div>
			<div class="layer_cart_cart col-xs-12 col-md-6">
				<span class="title">
					<!-- Plural Case [both cases are needed because page may be updated in Javascript] -->
					<span class="ajax_cart_product_txt_s {if $cart_qties < 2} unvisible{/if}">
						{l s='There are [1]%d[/1] items in your cart.' mod='blockcart' sprintf=[$cart_qties] tags=['<span class="ajax_cart_quantity">']}
					</span>
					<!-- Singular Case [both cases are needed because page may be updated in Javascript] -->
					<span class="ajax_cart_product_txt {if $cart_qties > 1} unvisible{/if}">
						{l s='There is 1 item in your cart.' mod='blockcart'}
					</span>
				</span>
				<div class="layer_cart_row">
					<strong class="dark">
						{l s='Total products' mod='blockcart'}
						{if $use_taxes && $display_tax_label && $show_tax}
							{if $priceDisplay == 1}
								{l s='(tax excl.)' mod='blockcart'}
							{else}
								{l s='(tax incl.)' mod='blockcart'}
							{/if}
						{/if}
					</strong>
					<span class="ajax_block_products_total">
						{if $cart_qties > 0}
							{convertPrice price=$cart->getOrderTotal(false, Cart::ONLY_PRODUCTS)}
						{/if}
					</span>
				</div>

				{if $show_wrapping}
					<div class="layer_cart_row">
						<strong class="dark">
							{l s='Wrapping' mod='blockcart'}
							{if $use_taxes && $display_tax_label && $show_tax}
								{if $priceDisplay == 1}
									{l s='(tax excl.)' mod='blockcart'}
								{else}
									{l s='(tax incl.)' mod='blockcart'}
								{/if}
							{/if}
						</strong>
						<span class="price cart_block_wrapping_cost">
							{if $priceDisplay == 1}
								{convertPrice price=$cart->getOrderTotal(false, Cart::ONLY_WRAPPING)}
							{else}
								{convertPrice price=$cart->getOrderTotal(true, Cart::ONLY_WRAPPING)}
							{/if}
						</span>
					</div>
				{/if}
				<div class="layer_cart_row">
					<strong class="dark{if $shipping_cost_float == 0 && (!$cart_qties || $cart->isVirtualCart() || !isset($cart->id_address_delivery) || !$cart->id_address_delivery)} unvisible{/if}">
						{l s='Total shipping' mod='blockcart'}&nbsp;{if $use_taxes && $display_tax_label && $show_tax}{if $priceDisplay == 1}{l s='(tax excl.)' mod='blockcart'}{else}{l s='(tax incl.)' mod='blockcart'}{/if}{/if}
					</strong>
					<span class="ajax_cart_shipping_cost{if $shipping_cost_float == 0 && (!$cart_qties || $cart->isVirtualCart() || !isset($cart->id_address_delivery) || !$cart->id_address_delivery)} unvisible{/if}">
						{if $shipping_cost_float == 0}
							 {if (!isset($cart->id_address_delivery) || !$cart->id_address_delivery)}{l s='To be determined' mod='blockcart'}{else}{l s='Free shipping!' mod='blockcart'}{/if}
						{else}
							{$shipping_cost}
						{/if}
					</span>
				</div>
				{if $show_tax && isset($tax_cost)}
					<div class="layer_cart_row hidden">
						<strong class="dark">{l s='Tax' mod='blockcart'}</strong>
						<span class="price cart_block_tax_cost ajax_cart_tax_cost">{$tax_cost}</span>
					</div>
				{/if}
				<div class="layer_cart_row">
					<strong class="dark">
						{l s='Total' mod='blockcart'}
						{if $use_taxes && $display_tax_label && $show_tax}
							{if $priceDisplay == 1}
								{l s='(tax excl.)' mod='blockcart'}
							{else}
								{l s='(tax incl.)' mod='blockcart'}
							{/if}
						{/if}
					</strong>
					<span class="ajax_block_cart_total">
						{if $cart_qties > 0}
							{if $priceDisplay == 1}
								{convertPrice price=$cart->getOrderTotal(false)}
							{else}
								{convertPrice price=$cart->getOrderTotal(true)}
							{/if}
						{/if}
					</span>
				</div>
				<div class="perks-available-cities" style="margin-top: 24px;">
					<p>Perks is exclusively available only on five major cities: <strong>Bengaluru</strong>, <strong>Mumbai</strong>, <strong>New Delhi</strong>, <strong>Chennai</strong> and <strong>Hyderabad</strong>.</p>
				</div>
				<div class="button-container">
					<span class="continue btn btn-default button exclusive-medium" title="{l s='Continue shopping' mod='blockcart'}">
						<span>
							{l s='Continue shopping' mod='blockcart'}
						</span>
					</span>
					<a class="btn btn-default button button-medium"	href="{$link->getPageLink("$order_process", true)|escape:"html":"UTF-8"}" title="{l s='Proceed to checkout' mod='blockcart'}" rel="nofollow">
						<span>
							{l s='Proceed to checkout' mod='blockcart'}
						</span>
					</a>
				</div>
			</div>
		</div>
		<div class="crossseling"></div>
	</div> <!-- #layer_cart -->
</div>
	<div class="layer_cart_overlay"></div>
{/if}

{strip}
{addJsDef CUSTOMIZE_TEXTFIELD=$CUSTOMIZE_TEXTFIELD}
{addJsDef img_dir=$img_dir|escape:'quotes':'UTF-8'}
{addJsDef generated_date=$smarty.now|intval}
{addJsDef ajax_allowed=$ajax_allowed|boolval}
{addJsDef hasDeliveryAddress=(isset($cart->id_address_delivery) && $cart->id_address_delivery)}
{addJsDef delete_url={$link->getPageLink('cart', true, NULL)}}

{addJsDefL name=customizationIdMessage}{l s='Customization #' mod='blockcart' js=1}{/addJsDefL}
{addJsDefL name=removingLinkText}{l s='remove this product from my cart' mod='blockcart' js=1}{/addJsDefL}
{addJsDefL name=freeShippingTranslation}{l s='Free shipping!' mod='blockcart' js=1}{/addJsDefL}
{addJsDefL name=freeProductTranslation}{l s='Free!' mod='blockcart' js=1}{/addJsDefL}
{addJsDefL name=delete_txt}{l s='Delete' mod='blockcart' js=1}{/addJsDefL}
{addJsDefL name=toBeDetermined}{l s='To be determined' mod='blockcart' js=1}{/addJsDefL}
{/strip}
<!-- /MODULE Block cart -->
