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
{capture name=path}
	{if !isset($email_create)}{l s='Authentication'}{else}
		<a href="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Authentication'}">{l s='Authentication'}</a>
		<span class="navigation-pipe">{$navigationPipe}</span>{l s='Create your account'}
	{/if}
{/capture}
<!--<h1 class="page-heading">{if !isset($email_create)}{l s='Authentication'}{else}{l s='Create an account'}{/if}</h1>-->
{if isset($back) && preg_match("/^http/", $back)}{assign var='current_step' value='login'}{include file="$tpl_dir./order-steps.tpl"}{/if}
{include file="$tpl_dir./errors.tpl"}
{assign var='stateExist' value=false}
{assign var="postCodeExist" value=false}
{assign var="dniExist" value=false}
{if !isset($email_create)}
	<!--{if isset($authentification_error)}
	<div class="alert alert-danger">
		{if {$authentification_error|@count} == 1}
			<p>{l s='There\'s at least one error'} :</p>
			{else}
			<p>{l s='There are %s errors' sprintf=[$account_error|@count]} :</p>
		{/if}
		<ol>
			{foreach from=$authentification_error item=v}
				<li>{$v}</li>
			{/foreach}
		</ol>
	</div>
	{/if}-->
	<div class="row">	 
        <div class="login-section">
            <form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="login_form" >
                <h3 class="page-subheading">{l s='Already have an account?'}</h3>
                <div class="subheading-hints">{l s='If you are already registered, Log in'} <span class="mobile-only-link">or <a class="mobile-register-link" href="#mobile-register-link">Register here</a></span></div>
                <div class="form_content clearfix">
                    <div class="form-group">
                        <label for="email">{l s='Email address'}</label>
                        <input class="is_required validate account_input form-control" data-validate="isEmail" type="email" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes}{/if}" />
                    </div>
                    <div class="form-group">
                        <label for="passwd">{l s='Password'}</label>
                        <span id="mobile-register-link"></span>
                        <input class="is_required validate account_input form-control" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="" />
                    </div>
                    <p class="lost_password form-group"><a href="{$link->getPageLink('password')|escape:'html':'UTF-8'}" title="{l s='Recover your forgotten password'}" rel="nofollow">{l s='Forgot password?'}</a></p>
                    <p class="submit">
                        {if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
                        <button type="submit" id="SubmitLogin" name="SubmitLogin" class="button-black">
                                {l s='Login'}
                        </button>
                    </p>
                    
                </div>
            </form>
        </div>
        <div class="register-section">
            <form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="create-account_form">
                <h3 class="page-subheading">{l s='New user?'}</h3>
                <div class="form_content clearfix">
                 	
                    <div class="b2b-alert-container">
                    	<img src="{$img_dir}high-importance-16.png" class="importantance-icon" /> 
                        <ul class="b2b-text b2b-text-registration"> 
                         	<li>We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</li>
                        </ul>
                    </div>
                 
                    <div class="alert alert-danger" id="create_account_error" style="display:none"></div>
                    <div class="form-group">
                        <label class="font-gray" for="email_create">{l s='Email'}</label>
                        <input type="email" class="is_required validate account_input form-control" data-validate="isEmail" id="email_create" name="email_create" value="{if isset($smarty.post.email_create)}{$smarty.post.email_create|stripslashes}{/if}" onkeyup="$('#create_account_error').html('').hide();" />
                    </div>
                    <div class="submit">
                        {if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
                        <button class="button-black" type="submit" id="SubmitCreate" name="SubmitCreate">
                                {l s='Create an account'}
                        </button>
                        <input type="hidden" class="hidden" name="SubmitCreate" value="{l s='Create an account'}" />
                    </div>
                    
                    
                    
                </div>
            </form>
        </div>
	</div>
	{if isset($inOrderProcess) && $inOrderProcess && $PS_GUEST_CHECKOUT_ENABLED}
		<form action="{$link->getPageLink('authentication', true, NULL, "back=$back")|escape:'html':'UTF-8'}" method="post" id="new_account_form" class="std clearfix">
			<div class="box">
				<div id="opc_account_form" style="display: block; ">
					<h3 class="page-heading bottom-indent">{l s='Instant checkout'}</h3>
					<p class="required"><sup>*</sup>{l s='Required field'}</p>
					<!-- Account -->
					<div class="required form-group">
						<label for="guest_email">{l s='Email address'} <sup>*</sup></label>
						<input type="text" class="is_required validate form-control" data-validate="isEmail" id="guest_email" name="guest_email" value="{if isset($smarty.post.guest_email)}{$smarty.post.guest_email}{/if}" />
					</div>
					<div class="cleafix gender-line">
						<label>{l s='Title'}</label>
						{foreach from=$genders key=k item=gender}
							<div class="radio-inline">
								<label for="id_gender{$gender->id}" class="top">
									<input type="radio" name="id_gender" id="id_gender{$gender->id}" value="{$gender->id}"{if isset($smarty.post.id_gender) && $smarty.post.id_gender == $gender->id} checked="checked"{/if} />
									{$gender->name}
								</label>
							</div>
						{/foreach}
					</div>
					<div class="required form-group">
						<label for="firstname">{l s='First name'} <sup>*</sup></label>
						<input type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}" />
					</div>
					<div class="required form-group">
						<label for="lastname">{l s='Last name'} <sup>*</sup></label>
						<input type="text" class="is_required validate form-control" data-validate="isName" id="lastname" name="lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}" />
					</div>
					<div class="form-group date-select">
						<label>{l s='Date of Birth'}</label>
						<div class="row">
							<div class="col-xs-4">
								<select id="days" name="days" class="form-control">
									<option value="">-</option>
									{foreach from=$days item=day}
										<option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
									{/foreach}
								</select>
								{*
									{l s='January'}
									{l s='February'}
									{l s='March'}
									{l s='April'}
									{l s='May'}
									{l s='June'}
									{l s='July'}
									{l s='August'}
									{l s='September'}
									{l s='October'}
									{l s='November'}
									{l s='December'}
								*}
							</div>
							<div class="col-xs-4">
								<select id="months" name="months" class="form-control">
									<option value="">-</option>
									{foreach from=$months key=k item=month}
										<option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month}&nbsp;</option>
									{/foreach}
								</select>
							</div>
							<div class="col-xs-4">
								<select id="years" name="years" class="form-control">
									<option value="">-</option>
									{foreach from=$years item=year}
										<option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}&nbsp;&nbsp;</option>
									{/foreach}
								</select>
							</div>
						</div>
					</div>
					{if isset($newsletter) && $newsletter}
						<div class="checkbox">
							<label for="newsletter">
							<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) && $smarty.post.newsletter == '1'}checked="checked"{/if} />
							{l s='Sign up for our newsletter!'}</label>
						</div>
					{/if}
					{if isset($optin) && $optin}
						<div class="checkbox">
							<label for="optin">
							<input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) && $smarty.post.optin == '1'}checked="checked"{/if} />
							{l s='Receive special offers from our partners!'}</label>
						</div>
					{/if}
					<h3 class="page-heading bottom-indent top-indent">{l s='Delivery address'}</h3>
					{foreach from=$dlv_all_fields item=field_name}
						{if $field_name eq "company"}
							<div class="form-group">
								<label for="company">{l s='Company'}{if in_array($field_name, $required_fields)} <sup>*</sup>{/if}</label>
								<input type="text" class="form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
							</div>
						{elseif $field_name eq "vat_number"}
							<div id="vat_number" style="display:none;">
								<div class="form-group">
									<label for="vat-number">{l s='GST number'}{if in_array($field_name, $required_fields)} <sup>*</sup>{/if}</label>
									<input id="vat-number" type="text" class="form-control" name="vat_number" value="{if isset($smarty.post.vat_number)}{$smarty.post.vat_number}{/if}" />
								</div>
							</div>
							{elseif $field_name eq "dni"}
							{assign var='dniExist' value=true}
							<div class="required dni form-group">
								<label for="dni">{l s='Identification number'} <sup>*</sup></label>
								<input type="text" name="dni" id="dni" value="{if isset($smarty.post.dni)}{$smarty.post.dni}{/if}" />
								<span class="form_info">{l s='DNI / NIF / NIE'}</span>
							</div>
						{elseif $field_name eq "address1"}
							<div class="required form-group">
								<label for="address1">{l s='Address'} <sup>*</sup></label>
								<input type="text" class="form-control" name="address1" id="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}" />
							</div>
						{elseif $field_name eq "address2"}
							<div class="form-group is_customer_param">
								<label for="address2">{l s='Address (Line 2)'}{if in_array($field_name, $required_fields)} <sup>*</sup>{/if}</label>
								<input type="text" class="form-control" name="address2" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{/if}" />
							</div>
						{elseif $field_name eq "postcode"}
							{assign var='postCodeExist' value=true}
							<div class="required postcode form-group">
								<label for="postcode">{l s='Zip/Postal Code'} <sup>*</sup></label>
								<input type="text" class="validate form-control" name="postcode" id="postcode" data-validate="isPostCode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" maxlength="6"/>
							</div>
						{elseif $field_name eq "city"}
							<div class="required form-group">
								<label for="city">{l s='City'} <sup>*</sup></label>
								<input type="text" class="form-control" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" />
							</div>
							<!-- if customer hasn't update his layout address, country has to be verified but it's deprecated -->
						{elseif $field_name eq "Country:name" || $field_name eq "country"}
							<div class="required select form-group">
								<label for="id_country">{l s='Country'} <sup>*</sup></label>
								<select name="id_country" id="id_country" class="form-control">
									{foreach from=$countries item=v}
										<option value="{$v.id_country}"{if (isset($smarty.post.id_country) AND  $smarty.post.id_country == $v.id_country) OR (!isset($smarty.post.id_country) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name}</option>
									{/foreach}
								</select>
							</div>
						{elseif $field_name eq "State:name"}
							{assign var='stateExist' value=true}
							<div class="required id_state select form-group">
								<label for="id_state">{l s='State'} <sup>*</sup></label>
								<select name="id_state" id="id_state" class="form-control">
									<option value="">-</option>
								</select>
							</div>
						{/if}
					{/foreach}
					{if $stateExist eq false}
						<div class="required id_state select unvisible form-group">
							<label for="id_state">{l s='State'} <sup>*</sup></label>
							<select name="id_state" id="id_state" class="form-control">
								<option value="">-</option>
							</select>
						</div>
					{/if}
					{if $postCodeExist eq false}
						<div class="required postcode unvisible form-group">
							<label for="postcode">{l s='Zip/Postal Code'} <sup>*</sup></label>
							<input type="text" class="validate form-control" name="postcode" id="postcode" data-validate="isPostCode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" maxlength="6"/>
						</div>
					{/if}
					{if $dniExist eq false}
						<div class="required form-group dni">
							<label for="dni">{l s='Identification number'} <sup>*</sup></label>
							<input type="text" class="text form-control" name="dni" id="dni" value="{if isset($smarty.post.dni) && $smarty.post.dni}{$smarty.post.dni}{/if}" />
							<span class="form_info">{l s='DNI / NIF / NIE'}</span>
						</div>
					{/if}
					<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group">
						<label for="phone_mobile">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
						<input type="text" class="form-control" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
					</div>
					<input type="hidden" name="alias" id="alias" value="{l s='My address'}" />
					<input type="hidden" name="is_new_customer" id="is_new_customer" value="0" />
					<div class="checkbox">
						<label for="invoice_address">
						<input type="checkbox" name="invoice_address" id="invoice_address"{if (isset($smarty.post.invoice_address) && $smarty.post.invoice_address) || (isset($smarty.post.invoice_address) && $smarty.post.invoice_address)} checked="checked"{/if} autocomplete="off"/>
						{l s='Please use another address for invoice'}</label>
					</div>
					<div id="opc_invoice_address"  class="unvisible">
						{assign var=stateExist value=false}
						{assign var=postCodeExist value=false}
						{assign var=dniExist value=false}
						<h3 class="page-subheading top-indent">{l s='Invoice address'}</h3>
						{foreach from=$inv_all_fields item=field_name}
						{if $field_name eq "company"}
						<div class="form-group">
							<label for="company_invoice">{l s='Company'}{if in_array($field_name, $required_fields)} <sup>*</sup>{/if}</label>
							<input type="text" class="text form-control" id="company_invoice" name="company_invoice" value="{if isset($smarty.post.company_invoice) && $smarty.post.company_invoice}{$smarty.post.company_invoice}{/if}" />
						</div>
						{elseif $field_name eq "vat_number"}
						<div id="vat_number_block_invoice" style="display:none;">
							<div class="form-group">
								<label for="vat_number_invoice">{l s='GST number'}{if in_array($field_name, $required_fields)} <sup>*</sup>{/if}</label>
								<input type="text" class="form-control" id="vat_number_invoice" name="vat_number_invoice" value="{if isset($smarty.post.vat_number_invoice) && $smarty.post.vat_number_invoice}{$smarty.post.vat_number_invoice}{/if}" />
							</div>
						</div>
						{elseif $field_name eq "dni"}
						{assign var=dniExist value=true}
						<div class="required form-group dni_invoice">
							<label for="dni_invoice">{l s='Identification number'} <sup>*</sup></label>
							<input type="text" class="text form-control" name="dni_invoice" id="dni_invoice" value="{if isset($smarty.post.dni_invoice) && $smarty.post.dni_invoice}{$smarty.post.dni_invoice}{/if}" />
							<span class="form_info">{l s='DNI / NIF / NIE'}</span>
						</div>
						{elseif $field_name eq "firstname"}
						<div class="required form-group">
							<label for="firstname_invoice">{l s='First name'} <sup>*</sup></label>
							<input type="text" class="form-control" id="firstname_invoice" name="firstname_invoice" value="{if isset($smarty.post.firstname_invoice) && $smarty.post.firstname_invoice}{$smarty.post.firstname_invoice}{/if}" />
						</div>
						{elseif $field_name eq "lastname"}
						<div class="required form-group">
							<label for="lastname_invoice">{l s='Last name'} <sup>*</sup></label>
							<input type="text" class="form-control" id="lastname_invoice" name="lastname_invoice" value="{if isset($smarty.post.lastname_invoice) && $smarty.post.lastname_invoice}{$smarty.post.lastname_invoice}{/if}" />
						</div>
						{elseif $field_name eq "address1"}
						<div class="required form-group">
							<label for="address1_invoice">{l s='Address'} <sup>*</sup></label>
							<input type="text" class="form-control" name="address1_invoice" id="address1_invoice" value="{if isset($smarty.post.address1_invoice) && $smarty.post.address1_invoice}{$smarty.post.address1_invoice}{/if}" />
						</div>
						{elseif $field_name eq "address2"}
						<div class="form-group is_customer_param">
							<label for="address2_invoice">{l s='Address (Line 2)'}{if in_array($field_name, $required_fields)} <sup>*</sup>{/if}</label>
							<input type="text" class="form-control" name="address2_invoice" id="address2_invoice" value="{if isset($smarty.post.address2_invoice) && $smarty.post.address2_invoice}{$smarty.post.address2_invoice}{/if}" />
						</div>
						{elseif $field_name eq "postcode"}
						{$postCodeExist = true}
						<div class="required postcode_invoice form-group">
							<label for="postcode_invoice">{l s='Zip/Postal Code'} <sup>*</sup></label>
							<input type="text" class="validate form-control" name="postcode_invoice" id="postcode_invoice" data-validate="isPostCode" value="{if isset($smarty.post.postcode_invoice) && $smarty.post.postcode_invoice}{$smarty.post.postcode_invoice}{/if}"/>
						</div>
						{elseif $field_name eq "city"}
						<div class="required form-group">
							<label for="city_invoice">{l s='City'} <sup>*</sup></label>
							<input type="text" class="form-control" name="city_invoice" id="city_invoice" value="{if isset($smarty.post.city_invoice) && $smarty.post.city_invoice}{$smarty.post.city_invoice}{/if}" />
						</div>
						{elseif $field_name eq "country" || $field_name eq "Country:name"}
						<div class="required form-group">
							<label for="id_country_invoice">{l s='Country'} <sup>*</sup></label>
							<select name="id_country_invoice" id="id_country_invoice" class="form-control">
								<option value="">-</option>
								{foreach from=$countries item=v}
								<option value="{$v.id_country}"{if (isset($smarty.post.id_country_invoice) && $smarty.post.id_country_invoice == $v.id_country) OR (!isset($smarty.post.id_country_invoice) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name|escape:'html':'UTF-8'}</option>
								{/foreach}
							</select>
						</div>
						{elseif $field_name eq "state" || $field_name eq 'State:name'}
						{$stateExist = true}
						<div class="required id_state_invoice form-group" style="display:none;">
							<label for="id_state_invoice">{l s='State'} <sup>*</sup></label>
							<select name="id_state_invoice" id="id_state_invoice" class="form-control">
								<option value="">-</option>
							</select>
						</div>
						{/if}
						{/foreach}
						{if !$postCodeExist}
						<div class="required postcode_invoice form-group unvisible">
							<label for="postcode_invoice">{l s='Zip/Postal Code'} <sup>*</sup></label>
							<input type="text" class="form-control" name="postcode_invoice" id="postcode_invoice" value="{if isset($smarty.post.postcode_invoice) && $smarty.post.postcode_invoice}{$smarty.post.postcode_invoice}{/if}"/>
						</div>
						{/if}
						{if !$stateExist}
						<div class="required id_state_invoice form-group unvisible">
							<label for="id_state_invoice">{l s='State'} <sup>*</sup></label>
							<select name="id_state_invoice" id="id_state_invoice" class="form-control">
								<option value="">-</option>
							</select>
						</div>
						{/if}
						{if $dniExist eq false}
							<div class="required form-group dni_invoice">
								<label for="dni">{l s='Identification number'} <sup>*</sup></label>
								<input type="text" class="text form-control" name="dni_invoice" id="dni_invoice" value="{if isset($smarty.post.dni_invoice) && $smarty.post.dni_invoice}{$smarty.post.dni_invoice}{/if}" />
								<span class="form_info">{l s='DNI / NIF / NIE'}</span>
							</div>
						{/if}
						<div class="form-group is_customer_param">
							<label for="other_invoice">{l s='Additional information'}</label>
							<textarea class="form-control" name="other_invoice" id="other_invoice" cols="26" rows="3"></textarea>
						</div>
						{if isset($one_phone_at_least) && $one_phone_at_least}
							<p class="inline-infos required is_customer_param">{l s='You must register at least one phone number.'}</p>
						{/if}
						<div class="form-group is_customer_param">
							<label for="phone_invoice">{l s='Home phone'}</label>
							<input type="text" class="form-control" name="phone_invoice" id="phone_invoice" value="{if isset($smarty.post.phone_invoice) && $smarty.post.phone_invoice}{$smarty.post.phone_invoice}{/if}" />
						</div>
						<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group">
							<label for="phone_mobile_invoice">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
							<input type="text" class="form-control" name="phone_mobile_invoice" id="phone_mobile_invoice" value="{if isset($smarty.post.phone_mobile_invoice) && $smarty.post.phone_mobile_invoice}{$smarty.post.phone_mobile_invoice}{/if}" />
						</div>
						<input type="hidden" name="alias_invoice" id="alias_invoice" value="{l s='My Invoice address'}" />
					</div>
					<!-- END Account -->
				</div>
				{$HOOK_CREATE_ACCOUNT_FORM}
			</div>
			<p class="cart_navigation required submit clearfix">
				<span><sup>*</sup>{l s='Required field'}</span>
				<input type="hidden" name="display_guest_checkout" value="1" />
				<button type="submit" class="button btn btn-default button-medium" name="submitGuestAccount" id="submitGuestAccount">
					<span>
						{l s='Proceed to checkout'}
					</span>
				</button>
			</p>
		</form>
	{/if}
{else}
	
<div class="row"> 
    <div class="register-form-section">
        <form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="account-creation_form" enctype="multipart/form-data">
        <!--Acc creation part 1 staerts here -->
        
            	<h3 class="page-subheading">{l s='Create an account'}</h3>
                {*{$HOOK_CREATE_ACCOUNT_TOP}*}
                <div class="account_creation">
                    <!--Company & firstname-->
                    <div class="row">       
                        <div class="required form-group">
                            <input placeholder="Company" type="text" class="is_required  form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
                        </div>   
                        <div class="required form-group">
                            <input placeholder="Your Name" onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" value="{if isset($smarty.post.customer_firstname)}{$smarty.post.customer_firstname}{/if}" />
                        </div>   
                    </div>
                    
                    <!--Email & password-->
                    <div class="row">
                        <div class="required form-group">
                            <input placeholder="Email" type="email" class="is_required validate form-control" data-validate="isEmail" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" />
                        </div>
                        <div class="required password form-group">
                            <input placeholder="Password" type="password" class="is_required validate form-control" data-validate="isPasswd" name="passwd" id="passwd" />
                        </div>  
                    </div>
                    
                    <!--Address line 1&2-->
                    <div class="row">
                        <div class="required form-group">
                            <input placeholder="Address Line 1" type="text" class="is_required form-control" name="address1" id="address1" 
                            data-validate="isAddress" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}" />
                            <!--<span class="inline-infos">{l s='Street address, P.O. Box, Company name, etc.'}</span>-->
                        </div>
                        <div class="required form-group">
                            <input type="text" placeholder="Address Line 2" class=" form-control" name="address2" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{/if}" />
                        </div>  
                    </div>
                    
                    <!--City & pincode-->
                    <div class="row">
                        <div class="required form-group">
                            <input placeholder="City" type="text" class="is_required form-control" name="city" id="city" 
                            data-validate="isCityName" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" />
                        </div> 
                        <div class="required form-group">
                            <input placeholder="Pin code" type="text" class="is_required form-control noUniform" name="postcode" id="postcode" data-validate="isPostCode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" maxlength="6"/>
                        </div>  
                    </div>
                    
                    <!--State and country-->
                    <div class="row">
                        <div class="required select form-group">
                            {foreach from=$dlv_all_fields item=field_name}
                                {if $field_name eq "Country:name" || $field_name eq "country"}
                                    <select name="id_country" id="id_country" class="form-control noUniform">
                                        <option value="">Country</option>
                                        {foreach from=$countries item=v}
                                            <option value="{$v.id_country}"{if (isset($smarty.post.id_country) AND $smarty.post.id_country == $v.id_country) OR (!isset($smarty.post.id_country) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name}</option>
                                        {/foreach}
                                    </select>
                                {/if}
                            {/foreach}
                        </div>
                        <div class="required id_state form-group">
                            <select name="id_state" id="id_state" class="form-control noUniform">
                                <option value="">State</option>
                                {foreach from=$states item=s }
                                    <option value="">{$s.name}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    
                    <!--Mobile and User type-->
                    <div class="row">
                        <div class="required form-group">
                        	<input type="text" class="form-control" placeholder="Mobile Number" data-validate="isPhoneNumber" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
                        </div>
                    </div>
                    
                    <!--Document & customer Type section-->
                    <div class="row">
                        <div class="form-group hidden">
                            <span class="radio-label">Verification Document   </span>
                            <div class="radio-inline">
                                <div class="radio-vertical doc">
                                    <input  type="radio" value="1" checked="" id="upload_now" name="upload_document" class="form-control noUniform" > <label for="upload_now">Upload now</label>
                                </div>
                                <div class="radio-vertical doc">
                                    <input type="radio" checked="checked" value="2" id="upload_later" name="upload_document" class="form-control noUniform" > <label for="upload_later">Upload later</label>
                                </div>
                            </div>
                        </div>
                        <div class="required form-group">
                            <span class="radio-label">Choose type</span>
                            <div class="radio-inline">
                                <div class="radio-vertical">
                                    <input type="radio" value="9" class="form-control" checked="checked" id="Corporate" name="id_buyer"> <label for="Corporate">Corporate</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="5" class="form-control retailer" id="SMEs"  name="id_buyer"> <label for="SMEs">SMEs</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="6" class="form-control retailer" id="Retailer"  name="id_buyer"> <label for="Retailer">Retailer</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="8" class="form-control retailer" id="Individual"  name="id_buyer"> <label for="Individual">Individual</label>
                                </div>
                                <div class="radio-vertical">
                                    <input type="radio" value="7" class="form-control retailer" id="Others"  name="id_buyer"> <label for="Others">Others</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="upload">
                            <input type="file" name="uploadBuyerDocument" id="uploadBuyerDocument">
                            <p>Maximum file size: <span>5 MB</span></p>
                            <p>Acceptable formats: <span>gif, png, jpg, docx, doc, pdf, rtf & zip</span></p>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="g-recaptcha" data-sitekey="6LcA3CsUAAAAANCf2BK4omFwMaklT85kRNHjiD56"></div>
                    </div>
                    <!-- Submit Registeration -->
                    <div class="row">
                        <div class="submit ">
                            <input type="hidden" name="email_create" value="1" />
                            <input type="hidden" name="is_new_customer" value="1" />
                            {if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
                            <button type="submit" name="submitAccount" id="submit_registration" class="button-black">{l s='Register'} </button>
                        </div>  
                    </div>
                    <br />
                    <div class="b2b-alert-container col-md-6">
                    	<img src="{$img_dir}high-importance-16.png" class="importantance-icon" /> 
                        <ul class="b2b-text b2b-text-registration"> 
                         	<li>We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</li>
                        </ul>
                    </div>
                </div>
        </form>
    </div>
<!--End of Part 1-->
<!--Start of part 2-->         

<!--User Benefits Section -->
	<div class="user-benefits-section">
		
        <div class="b2b-alert-container">
            <img src="{$img_dir}high-importance-16.png" class="importantance-icon" /> 
            <ul class="b2b-text b2b-alert-auth-side"> 
                <li>We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.</li>
            </ul>
        </div>
 
		<!-- Start Benefits for Company -->
		<!--<div class="benefits-container company" data-user-type="company">
            <h3>Benefits for Company</h3>
            <div class="benefit">
                <div class="title">
                    <div class="icon flexible-payment-icon"></div>
                    <p>Centralize Sourcing</p>
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
                    <p>Huge Catalog. Best Prices</p>
                </div>
                <ul class="key-benefits dash">
                    <li>Lakhs of Genuine Products</li>
					<li>Thousands of Brands</li>
					<li>Best Prices for Bulk Purchase</li>
                </ul>
            </div>
            
            <div class="benefit">
                <div class="title">
                    <div class="icon direct-shipment-icon"></div><p>Online Procurement Tool - Kobster Elite</p>
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
                    <li>No Questions asked Return Policy</li>
                </ul>
            </div>
        </div>-->
        <!-- End Benefits for Company -->

        <!-- Start Benefits for Retailer -->
		<!--<div class="benefits-container retailer" data-user-type="retailer">
        	<h3>Benefits for Retailer</h3>
			<div class="benefit">
            	<div class="title">
                	<div class="icon flexible-payment-icon"></div>
                    <p>Flexible Payment Terms & MOQ</p>
                </div>
                <ul class="key-benefits dash">
                	<li>Buy Now, Pay Latter. Long Credit Periods</li>
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
		</div>-->
		<!-- End Benefits for Retailer -->
    </div>
</div>
{/if}
{strip}
{if isset($smarty.post.id_state) && $smarty.post.id_state}
	{addJsDef idSelectedState=$smarty.post.id_state|intval}
{elseif isset($address->id_state) && $address->id_state}
	{addJsDef idSelectedState=$address->id_state|intval}
{else}
	{addJsDef idSelectedState=false}
{/if}
{if isset($smarty.post.id_state_invoice) && isset($smarty.post.id_state_invoice) && $smarty.post.id_state_invoice}
	{addJsDef idSelectedStateInvoice=$smarty.post.id_state_invoice|intval}
{else}
	{addJsDef idSelectedStateInvoice=false}
{/if}
{if isset($smarty.post.id_country) && $smarty.post.id_country}
	{addJsDef idSelectedCountry=$smarty.post.id_country|intval}
{elseif isset($address->id_country) && $address->id_country}
	{addJsDef idSelectedCountry=$address->id_country|intval}
{else}
	{addJsDef idSelectedCountry=false}
{/if}
{if isset($smarty.post.id_country_invoice) && isset($smarty.post.id_country_invoice) && $smarty.post.id_country_invoice}
	{addJsDef idSelectedCountryInvoice=$smarty.post.id_country_invoice|intval}
{else}
	{addJsDef idSelectedCountryInvoice=false}
{/if}
{if isset($countries)}
	{addJsDef countries=$countries}
{/if}
{if isset($vatnumber_ajax_call) && $vatnumber_ajax_call}
	{addJsDef vatnumber_ajax_call=$vatnumber_ajax_call}
{/if}
{if isset($email_create) && $email_create}
	{addJsDef email_create=$email_create|boolval}
{else}
	{addJsDef email_create=false}
{/if}
{/strip}
<script>
$(document).ready(function(){
	showUploadDocument();
});

$(document).ready(function(){
	
	// Authentication page b2b validation 
	$('.radio-inline input[name=id_buyer]').change(function() {
        if (this.value == '8') {
			$("#submit_registration").attr("disabled",true);
			$(".b2b-text-registration").css("color", "red");
        }
        else  {
			$("#submit_registration").attr("disabled",false);
			$(".b2b-text-registration").css("color", "grey");
        }
    });
	
	// Reseller and Company Switch Content for Registration
	/*$('#doc1').click(function(){
		$('.user-benefits-section [data-user-type="company"]').removeClass('hidden');
		$('.user-benefits-section [data-user-type="retailer"]').addClass('hidden');
	});
	$('#doc2').click(function(){
		$('.user-benefits-section [data-user-type="retailer"]').removeClass('hidden');
		$('.user-benefits-section [data-user-type="company"]').addClass('hidden');
	});
	$('.user-benefits-section [data-user-type="retailer"]').addClass('hidden');*/
});
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>