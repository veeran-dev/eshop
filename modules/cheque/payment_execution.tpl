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

{capture name=path}{l s='Cheque payment' mod='cheque'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='cheque'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if isset($nbProducts) && $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.'}</p>
{else}

<h3>{l s='Cheque payment' mod='cheque'}</h3>
<form action="{$this_path_ssl}validation.php" method="post" id="cheque_deposit">
	<div style="height:30px; border:1px solid #8f8f8f; padding-left:20px;"><h4>Pay By Cheque</h4></div>
    <div style=" border:1px solid #8f8f8f; height:275px; padding-left:20px;border-top:none;">
    	<br /><span style="margin-top:10px;">{l s='Please send us a cheque with:' mod='cheque'}</span>
    	<p><span>{l s='An amount of:' mod='cheque'}</span><span class="price">{displayPrice price=$total}</span></p>
    	<p><span>{l s='In favour of:' mod='cheque'} <b>{if $chequeName}{$chequeName}{else}___________{/if}</b></span></p>
    	<p><span>{l s='Payable at:' mod='cheque'}<b>{if $chequeName}Chennai{else}___________{/if}</b>
    	</span></p><br />
    	<span> {l s='Send it to the following address:' mod='cheque'}</span><br/>
    	<span class="bold">{if $chequeAddress}{$chequeAddress}{else}___________{/if}</span><br/><br/>
    	<span>*Order will be processed only on receiving amount from cheque
    
    <p class="cart_navigation">
    <input type="submit" name="submit" value="{l s='MAKE PAYMENT' mod='cheque'}" style="margin-left:25%;" class="pay_button hideOnSubmit" />
    </p>
    
    </div>
</form>

{/if}
