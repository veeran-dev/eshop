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
{if !$opc}
	{assign var='current_step' value='address'}
	{capture name=path}{l s='Addresses'}{/capture}
	{assign var="back_order_page" value="order.php"}
	{*<h1 class="page-heading">{l s='Addresses'}</h1>*}
	{include file="$tpl_dir./order-steps.tpl"}
	{include file="$tpl_dir./errors.tpl"}

<div class="row">
    <div class="col-sm-12 step-heading">
        <h2 class="step-num">{l s='Delivery'}</h2>
        <a id="order_address" title="{l s='Add'}" class="button-gray button-outline">{l s='Add a new address'} </a> 
    </div>
</div>
    

<!-- Add New Address Block -->
<div class="row">
    <div class="col-sm-12">    
        <div class="order-step-column add-new-address-wrapper unvisible" id="new_order_address"> 
            <form action="{$link->getPageLink($back_order_page, true)|escape:'html':'UTF-8'}" onSubmit="return saveAddress();" method="post" id="add_address" enctype="multipart/form-data">
                <div class="col-xs-12 col-sm-12 no-padding-left">
                    <div class="">
                        <!--Company & firstname-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">       
                                <div class="required form-group padding-bottom">
                                    <input placeholder="Company" type="text" class="is_required  form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
                                    <span id="error_company" class=" error_msg"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">   
                                <div class="required form-group padding-bottom">
                                    <input placeholder="Your Name" onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" value="{if isset($smarty.post.customer_firstname)}{$smarty.post.customer_firstname}{/if}" />
                                    <span id="error_name" class=" error_msg"></span>
                                </div>
                            </div>   
                        </div>
                        
                        <!--Address line 1&2-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="required form-group padding-bottom">
                                    <input placeholder="Address Line 1" type="text" class=" is_required  form-control" name="address1" id="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}" />
                                <span id="error_address" class=" error_msg"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6"> 
                                <div class="required form-group  padding-bottom">
                                    <input type="text" placeholder="Address Line 2" class=" form-control" name="address2" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{/if}" />
                                </div>
                            </div>   
                        </div>

                        <!--City and pincode-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="required form-group padding-bottom">
                                    {if isset($cities)}
                                        <select name="city" id="city" class="noUniform form-control">
                                            <option value="">Select City</option>
                                            {foreach $cities as $city }
                                                <option value="{$city.city_name}">{$city.city_name}</option>
                                            {/foreach}
                                        </select>
                                    {else}
                                    <input placeholder="City" type="text" class="is_required  form-control" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" />
                                    {/if}
                                    <span id="error_city" class=" error_msg"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6"> 
                                <div class="required form-group padding-bottom">
                                    <input placeholder="Pin code" maxlength="6" size="6" type="text" class="is_required form-control" name="postcode" id="postcode" data-validate="isPostCode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}"/>
                                    <span id="error_postcode" class="error_msg"></span>
                                </div>
                            </div>   
                        </div>
                        
                        
                        <!--State and country-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="required  form-group padding-bottom">
                                    <select name="id_country" id="id_country" class="noUniform form-control">
                                        <option value="110">India</option>
                                    </select>    
                                    <span id="error_country" class=" error_msg"></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6"> 
                                <div class="required  form-group padding-bottom">
                                    <select name="id_state" id="id_state" class="noUniform form-control">
                                        <option value="">Select State</option>
                                        {foreach from=$states item=s }
                                        <option value="{$s.id_state}">{$s.name}</option>
                                        {/foreach}
                                    </select>
                                    <span id="error_state" class=" error_msg"></span>
                                </div>
                            </div>  
                        </div>
                        
                        
                        <!--Mobile section-->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="required form-group padding-bottom">
                                    <input type="text" class="form-control"  maxlength="12" size="12" placeholder="Mobile Number" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
                                    <span id="error_mobile" class=" error_msg"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="submit1 ">
                                    <!--<input type="hidden" name="email_create" value="1" />
                                    <input type="hidden" name="is_new_customer" value="1" />-->
                                    {*{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}*}
                                    <button type="submit" name="submitAddress" id="submitAddress" class="button-black ">{l s='Save Address'} </button>
                                <!--<button type="button" name="" id="close_add_address" class="button-gray">{l s='Cancel'} </button>
                                    <button  onclick="saveAddress()"  class="button-black">{l s='Save '} </button>-->
                                </div> 
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">

<form action="{$link->getPageLink($back_order_page, true)|escape:'html':'UTF-8'}" method="post" class="select-address-form">
        
    <div class="b2b-alert-container-all">
        <div class="b2b-alert-icon">
            <img src="{$img_dir}high-importance-16.png" class="importantance-icon" />
        </div>
        <div>
            We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.
        </div>
    </div>


        
{else}
	{assign var="back_order_page" value="order-opc.php"}
	 {*<h1 class="page-heading step-num"><span>1</span> {l s='Addresses'}</h1> *}
	<div id="opc_account" class="opc-main-block">
		<div id="opc_account-overlay" class="opc-overlay" style="display: none;"></div>
{/if}
<div class="clearfix">
	<div class="row">
    	<div class="col-xs-12 col-sm-12">
            {* <span class="checkbox addressesAreEquals"{if $cart->isVirtualCart()} style="display:block;"{/if}>
                <div class="checkbox-vertical">
                  <input type="checkbox" class="noUniform" name="same" id="addressesAreEquals" value="1"{if $cart->id_address_invoice == $cart->id_address_delivery || $addresses|@count == 1} checked="checked"{/if} > <label for="addressesAreEquals">{l s='Use the delivery address as the billing address.'}</label>
                </div>
            </span>
            *}
            {*
            <span class="checkbox addressesAreEquals"{if $cart->isVirtualCart()} style="display:block;"{/if}>
                <input type="checkbox" class="noUniform" name="same" id="addressesAreEquals" value="1"{if $cart->id_address_invoice == $cart->id_address_delivery || $addresses|@count == 1} checked="checked"{/if} />
                <label for="addressesAreEquals">{l s='Use the delivery address as the billing address.'}</label>
            </span>
            *}
		</div>
    </div>
	<div class="row">
        <div class="col-xs-12 col-sm-6 delivery-address-column">
			<span class="address_delivery  form-group ">
				<label class="adderss-type-title" for="id_address_delivery">{if $cart->isVirtualCart()}{l s='Choose a Billing address:'}{else}{l s='Choose a Delivery Address:'}{/if}</label>			{foreach from=$addresses key=k item=address}<br/>
				<!--<select name="id_address_delivery" id="id_address_delivery" class="address_select form-control">-->
					<!--<ul class="address item box" id="address_delivery">
					</ul>-->
                    <div class="radio-column">
                    	<div class="radio-vertical">
						    <input type="radio" class="noUniform" name="id_address_delivery" id="id_address_delivery_{$address.id_address|intval}" {if $k==0}checked="checked"{/if} value="{$address.id_address|intval}"><label></label>
						</div>
                        <!-- 
						<input type="radio" class="noUniform" id="id_address_delivery_{$address.id_address|intval}" {if $k==0}checked="checked"{/if} value="{$address.id_address|intval}" name="id_address_delivery"   />
                        -->		
                    </div>
                    <div class="address-column">
						<ul class="bordercolor address item" id="address_delivery_{$address.id_address|intval}" {if $cart->isVirtualCart()}style="display:none;"{/if}>
						</ul>
					</div>
					{/foreach}
				<!--<span class="waitimage"></span>-->
			</span>
			
			<div class="verified"></div>
		</div>
		<div class="col-xs-12 col-sm-6 billing-address-column">
            <div class="form-group" style="overflow: hidden">
                <label class="adderss-type-title" for="id_address_delivery">{if $cart->isVirtualCart()}{l s='Choose a Billing address:'}{else}{l s='Choose a Billing Address:'}{/if}</label>
            </div>

            <div class="form-group" style="overflow: hidden">
                <span class="checkbox addressesAreEquals"{if $cart->isVirtualCart()} style="display:block;"{/if}>
                    <div class="checkbox-vertical">
                      <input type="checkbox" class="noUniform" name="same" id="addressesAreEquals" value="1"{if $cart->id_address_invoice == $cart->id_address_delivery || $addresses|@count == 1} checked="checked"{/if} > <label for="addressesAreEquals">{l s='Use the same as delivery address'}</label>
                    </div>
                </span>
            </div>
            
            <div class="form-group">
    			<span id="address_invoice_form" class=" form-group "{if $cart->id_address_invoice == $cart->id_address_delivery} style="display: none;"{/if}>
    				 
                     {if $addresses|@count > 1}   
                        {* <label for="id_address_invoice" class="adderss-type-title">{l s='Choose a Billing Address:'}</label><br/> *}
                        {foreach from=$addresses key=k item=address}
                        {*
                         <div class="col-xs-12 col-sm-1">
                            <input type="radio" {if $k==0}checked="checked"{/if}  id="id_address_invoice_{$address.id_address|intval}"  value="{$address.id_address|intval}"  name="id_address_invoice"  />
                        </div>
                        <div class="col-xs-12 col-sm-10">
                            <ul class="bordercolor address alternate_item {if $cart->isVirtualCart()}full_width{/if}" id="address_invoice_{$address.id_address|intval}">
                            </ul>
                        </div>
                        *}
                        <div class="radio-column">
                            <div class="radio-vertical">
                                <input type="radio" {if $k==0}checked="checked"{/if}  id="id_address_invoice_{$address.id_address|intval}" class="noUniform"  value="{$address.id_address|intval}"  name="id_address_invoice"  /><label></label>
                            </div>
                        </div>
                        <div class="address-column">
                            <ul class="bordercolor address alternate_item {if $cart->isVirtualCart()}full_width{/if}" id="address_invoice_{$address.id_address|intval}">
                            </ul>
                        </div>
    					{/foreach}
                        
    				{else}
    					<!--<a href="{$link->getPageLink('address', true, NULL, "back={$back_order_page}?step=1&select_address=1{if $back}&mod={$back}{/if}")|escape:'html':'UTF-8'}" title="{l s='Add'}" class="button-gray">
     							{l s='Add a new address'}
     					</a>-->
                        <a id="order_address" title="{l s='Add'}" class="button-gray">{l s='Add a new address'} </a> 
    				{/if}
    			</span>
            </div>
		</div>
	</div> <!-- end row -->
</div> <!-- end addresses -->
{if !$opc}
    <div class="row">
        <p class="cart_navigation1 clearfix submitButton order-step-column">
            <input type="hidden" class="hidden" name="step" value="2" />
            <input type="hidden" name="back" value="{$back}" />
            <!--<a href="{$link->getPageLink($back_order_page, true, NULL, "{if $back}back={$back}{/if}")|escape:'html':'UTF-8'}" title="{l s='Previous'}" class="button-exclusive btn btn-default">
                <i class="icon-chevron-left"></i>
                {l s='Continue Shopping'}
            </a>-->
            <button type="submit" id="processAddress" name="processAddress" class="button-black unvisible">{l s='Proceed to checkout'}</button>
        </p>
    </div>
</form>
</div>

<div class="row">
    <div class="col-sm-12">
        <p class="cart_navigation1 clearfix submitButton">
            <input type="hidden" class="hidden" name="step" value="2" />
            <input type="hidden" name="back" value="{$back}" />
            <!--<a href="{$link->getPageLink($back_order_page, true, NULL, "{if $back}back={$back}{/if}")|escape:'html':'UTF-8'}" title="{l s='Previous'}" class="button-exclusive btn btn-default">
                <i class="icon-chevron-left"></i>
                {l s='Continue Shopping'}
            </a>-->
            <button onclick="submitProcessAddress()" class="button-black pull-right">{l s='Proceed to checkout'}</button>
        </p>
    </div>
</div>
       
{else}
	</div> <!--  end opc_account -->
{/if}
<script>

	$(document).ready(function()
	{
		documentVerification();
		$(".cart_quantity_button, .cart_product_remove, #voucher").hide();
		$(".cart_quantity input").attr('readonly', true);
		
	});
	
</script>
{strip}
{if !$opc}
	{addJsDef orderProcess='order'}
	{addJsDefL name=txtProduct}{l s='product' js=1}{/addJsDefL}
	{addJsDefL name=txtProducts}{l s='products' js=1}{/addJsDefL}
	{addJsDefL name=CloseTxt}{l s='Submit' js=1}{/addJsDefL}
{/if}
{capture}{if $back}&mod={$back|urlencode}{/if}{/capture}
{capture name=addressUrl}{$link->getPageLink('address', true, NULL, 'back='|cat:$back_order_page|cat:'?step=1'|cat:$smarty.capture.default)|escape:'quotes':'UTF-8'}{/capture}
{addJsDef addressUrl=$smarty.capture.addressUrl}
{capture}{'&multi-shipping=1'|urlencode}{/capture}
{addJsDef addressMultishippingUrl=$smarty.capture.addressUrl|cat:$smarty.capture.default}
{capture name=addressUrlAdd}{$smarty.capture.addressUrl|cat:'&id_address='}{/capture}
{addJsDef addressUrlAdd=$smarty.capture.addressUrlAdd}
{addJsDef formatedAddressFieldsValuesList=$formatedAddressFieldsValuesList}
{addJsDef opc=$opc|boolval}
{*{capture}<h3 class="page-subheading">{l s=$this->context->cart->id_address_delivery js=1}</h3>{/capture}
{addJsDefL name=titleInvoice}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
{capture}<h3 class="page-subheading">{$this->context->cart->id_address_invoice}</h3>{/capture}*}
{addJsDefL name=titleDelivery}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
{capture}<a class="button-outline small" href="{$smarty.capture.addressUrlAdd}" title="{l s='EDIT' js=1}"><span>{l s='EDIT' js=1}</span></a>{/capture}
{addJsDefL name=liUpdate}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
{/strip}