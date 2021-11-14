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
    <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
        {l s='My account'}
    </a>
    <span class="navigation-pipe">
        {$navigationPipe}
    </span>
    <span class="navigation_page">
        {l s='Your personal information'}
    </span>
{/capture}
<div class="row">
<div class="col-md-6">
<div class="box">
    <h1 class="page-subheading">
        {l s='Your personal information'}
    </h1>
    {include file="$tpl_dir./errors.tpl"}

    {if isset($confirmation) && $confirmation}
        <p class="alert alert-success">
            {l s='Your personal information has been successfully updated.'}
            {if isset($pwd_changed)}<br />{l s='Your password has been sent to your email:'} {$email}{/if}
        </p>
    {else}
        <p class="info-title">
            {l s='Please be sure to update your personal information if it has changed.'}
        </p>
        <p class="required">
            <sup>*</sup>{l s='Required field'}
        </p>
        <form action="{$link->getPageLink('identity', true)|escape:'html':'UTF-8'}" method="post" class="std">
            <fieldset>                
                <div class="clearfix hidden">
                    <label>{l s='Social title'}</label>
                    <br />
                    {foreach from=$genders key=k item=gender}
                        <div class="radio-inline">
                            <label for="id_gender{$gender->id}" class="top">
                            <input type="radio" name="id_gender" id="id_gender{$gender->id}" value="{$gender->id|intval}" {if isset($smarty.post.id_gender) && $smarty.post.id_gender == $gender->id}checked="checked"{/if} />
                            {$gender->name}</label>
                        </div>
                    {/foreach}
                </div>
                <div class="required form-group">
                    <label for="firstname" class="required">
                        {l s='First name'}
                    </label>
                    <input class="is_required validate form-control" data-validate="isName" type="text" id="firstname" name="firstname" value="{$smarty.post.firstname}" />
                </div>
                <div class="form-group">
                    <label for="lastname" class="">
                        {l s='Last name'}
                    </label>
                    <input class=" validate form-control" data-validate="isName" type="text" name="lastname" id="lastname" value="{$smarty.post.lastname}" />
                </div>
                <div class="required form-group">
                    <label for="email" class="required">
                        {l s='E-mail address'}
                    </label>
                    {if $isPerks}
                    <input class="hidden" type="email" name="email" id="email" value="{$smarty.post.email}"/>
                    {/if}
                    <input class="is_required validate form-control " data-validate="isEmail" type="email" name="email" id="email" value="{$smarty.post.email}" {if $isPerks}disabled {/if} />
                </div>
                <div class="form-group hidden">
                    <label>
                        {l s='Date of Birth'}
                    </label>
                    <div class="row">
                        <div class="col-xs-4">
                            <select name="days" id="days" class="form-control">
                                <option value="">-</option>
                                {foreach from=$days item=v}
                                    <option value="{$v}" {if ($sl_day == $v)}selected="selected"{/if}>{$v}&nbsp;&nbsp;</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-xs-4">
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
                            <select id="months" name="months" class="form-control">
                                <option value="">-</option>
                                {foreach from=$months key=k item=v}
                                    <option value="{$k}" {if ($sl_month == $k)}selected="selected"{/if}>{l s=$v}&nbsp;</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <select id="years" name="years" class="form-control">
                                <option value="">-</option>
                                {foreach from=$years item=v}
                                    <option value="{$v}" {if ($sl_year == $v)}selected="selected"{/if}>{$v}&nbsp;&nbsp;</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="required form-group">
                    <label for="old_passwd" class="required">
                        {l s='Current Password'}
                    </label>
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="old_passwd" id="old_passwd" />
                </div>
                <div class="password form-group">
                    <label for="passwd">
                        {l s='New Password'}
                    </label>
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="passwd" id="passwd" />
                </div>
                <div class="password form-group">
                    <label for="confirmation">
                        {l s='Confirmation'}
                    </label>
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="confirmation" id="confirmation" />
                </div>
                {if isset($newsletter) && $newsletter}
                    <div class="checkbox">
                        <label for="newsletter">
                            <input type="checkbox" id="newsletter" name="newsletter" value="1" {if isset($smarty.post.newsletter) && $smarty.post.newsletter == 1} checked="checked"{/if}/>
                            {l s='Sign up for our newsletter!'}
                            {if isset($required_fields) && array_key_exists('newsletter', $field_required)}
                              <sup> *</sup>
                            {/if}
                        </label>
                    </div>
                {/if}
                {if isset($optin) && $optin}
                    <div class="checkbox hidden">
                        <label for="optin">
                            <input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) && $smarty.post.optin == 1} checked="checked"{/if}/>
                            {l s='Receive special offers from our partners!'}
                            {if isset($required_fields) && array_key_exists('optin', $field_required)}
                              <sup> *</sup>
                            {/if}
                        </label>
                    </div>
                {/if}
			{if $b2b_enable}
				<h1 class="page-subheading">
					{l s='Your company information'}
				</h1>
				<div class="form-group">
					<label for="">{l s='Company'}</label>
					<input type="text" class="form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
				</div>
				<div class="form-group">
					<label for="siret">{l s='SIRET'}</label>
					<input type="text" class="form-control" id="siret" name="siret" value="{if isset($smarty.post.siret)}{$smarty.post.siret}{/if}" />
				</div>
				<div class="form-group">
					<label for="ape">{l s='APE'}</label>
					<input type="text" class="form-control" id="ape" name="ape" value="{if isset($smarty.post.ape)}{$smarty.post.ape}{/if}" />
				</div>
				<div class="form-group">
					<label for="website">{l s='Website'}</label>
					<input type="text" class="form-control" id="website" name="website" value="{if isset($smarty.post.website)}{$smarty.post.website}{/if}" />
				</div>
			{/if}
            {if isset($HOOK_CUSTOMER_IDENTITY_FORM)}
                {$HOOK_CUSTOMER_IDENTITY_FORM}
            {/if}
                <div class="form-group">
                    <button type="submit" name="submitIdentity" class="btn btn-default button button-medium">
                        <span>{l s='Save'}</span>
                    </button>
                </div>
            </fieldset>
        </form> <!-- .std -->
        </div>
        </div>

        {if !$hasProof && $isPerks == 1 && $success != 1}
        <div class="col-md-6 professional-id" id="scrollToIDProof">
            <div class="box">
                <h1 class="page-subheading">
                    {l s='Professional ID Proof'}
                </h1>
                <form method="post" enctype="multipart/form-data" action="{$link->getPageLink('identity', true)|escape:'html':'UTF-8'}">
                    <div class="upload-proof-wrapper">
                        <input type="file" name="upload-proof" id="upload-proof" class="hidden">
                        <label class="upload-proof-label" for="upload-proof"><i class="icon-file-image-o"></i>Choose File...</label>
                        <button type="submit" name="submitProof" class="submit-proof">Upload ID Proof</button>
                    </div>
                </form>
                <p>Allowed formats: <span>PDF</span>, <span>PNG</span>, <span>JPG</span> or <span>JPEG</span></p>
                <p>Maximum File Size: <span>2 MB</span></p>
            </div>
        </div>
        {/if}
        {if $success == 1}
        <div class="col-md-6">
            <div class="professional-id-success">
                <p class="title">ID uploaded successfully!</p>
                <p class="description">Grab your voucher code worth of Rs.100 below:</p>
                <span class="voucher-code">{$voucher_num}</span>
            </div>
        </div>
        {/if}
    {/if}
</div>
</div>
<ul class="footer_links clearfix">
	<li>
        <a class="button button-small" href="{$link->getPageLink('my-account', true)}">
            <span>
                {l s='Back to your account'}
            </span>
        </a>
    </li>
	<li>
        {if $isPerks}
        <a class="button button-small" href="{$link->getPageLink('perksDeals', true)}">
            <span>
                {l s='Home'}
            </span>
        </a>
        {else}
        <a class="button button-small" href="{$link->getPageLink('shop', true)|escape:'html':'UTF-8'}">
            <span>
                {l s='Home'}
            </span>
        </a>
        {/if}
    </li>
</ul>
