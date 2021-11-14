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
<!-- Block Newsletter module-->
<div id="newsletter_block_left" class="subscribe-section">
    <img src="../dash/img/kobster-elite-logo.svg">
    <!--
	<h4>Be first to save</h4>
    <form action="{$link->getPageLink('index', null, null, null, false, null, true)|escape:'html':'UTF-8'}" method="post" class="">
        <div class="form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if} newsletter-form" >
            <input class="inputNew form-control newsletter-input" id="newsletter-input" type="text" name="email" size="18" value="" placeholder="Enter your email"/>
            <button type="submit" name="submitNewsletter" class="red-button"><span>&nbsp;</span></button>
            <input type="hidden" name="action" value="0" />
            <p class="alert">{if isset($msg) && $msg}{$msg}{elseif isset($value) && $value}{$value}{else}{l s='' mod='blocknewsletter'}{/if}</p>
        </div>
        -->
    </form>
    {hook h="displayBlockNewsletterBottom" from='blocknewsletter'}
    <div class="social-links" itemscope itemtype="http://schema.org/Organization">
    	<link itemprop="url" href="https://www.kobster.com">
        <a itemprop="sameAs" class="facebook" href="https://www.facebook.com/KobzoOfficial/" target="_blank">&nbsp;</a>
        <a itemprop="sameAs" class="twitter" href="https://twitter.com/KobzoOfficial" target="_blank">&nbsp;</a>
        <a itemprop="sameAs" class="linkedin" href="https://www.linkedin.com/company/kobzo" target="_blank">&nbsp;</a>
        <a class="rss" href="https://www.kobzo.com/wfh-store/blogs.html" target="_blank">&nbsp;</a>
    </div>
    
</div>
<!-- /Block Newsletter module-->
{strip}
{if isset($msg) && $msg}
{addJsDef msg_newsl=$msg|@addcslashes:'\''}
{/if}
{if isset($nw_error)}
{addJsDef nw_error=$nw_error}
{/if}
{addJsDefL name=placeholder_blocknewsletter}{l s='Enter your e-mail' mod='blocknewsletter' js=1}{/addJsDefL}
{if isset($msg) && $msg}
	{addJsDefL name=alert_blocknewsletter}{l s='Newsletter : %1$s' sprintf=$msg js=1 mod="blocknewsletter"}{/addJsDefL}
{/if}
{/strip}