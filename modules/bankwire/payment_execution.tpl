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

{capture name=path}{l s='Transfer funds - NEFT/RTGS/Direct Deposit' mod='bankwire'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='bankwire'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
	<p class="warning">{l s='Your shopping cart is empty.'}</p>
{else}

<h3>{l s='Transfer funds - NEFT/RTGS/Direct Deposit' mod='bankwire'}</h3>
<form action="{$this_path_ssl}validation.php" method="post"  id="cash_deposit">
    <div style="height:30px; border:1px solid #8f8f8f; padding-left:20px;"><h4>Pay By Fund Transfer</h4></div>
    <div style=" border: 1px solid #8F8F8F;min-height: 275px;padding-left: 5%;border-top:none;">
    <br/>
    {l s='Please perform a NEFT/RGTS/Direct Deposit to the following account:' mod='bankwire'}<br /><br/>
    
    <p><span >{l s='An amount of:' mod='bankwire'} </span><span  style="margin-left:22px; font-weight:bold;">{displayPrice price=$total}
    {if $use_taxes == 1}
    	{l s='(Inclusive of all taxes)' mod='bankwire'}
    {/if}
    </span></p><br />
    <span >{l s='Account Name:' mod='bankwire'} </span><span class="bold" style="margin-left:20px;">{if $bankwireOwner}{$bankwireOwner}{else}___________{/if}</span><br /><br />
    
    <span >{l s='With these details:' mod='bankwire'}</span><p style="margin-left: 101px;margin-top: -25px;"><span class="bold" >{if $bankwireDetails}{$bankwireDetails}{else}___________{/if}</span></p><br />
    <span >Bank :</span><p style="margin-left: 102px;margin-top: -24px;"><span class="bold">{if $bankwireAddress}{$bankwireAddress}{else}___________{/if}</span></p>
    <p>{l s='Do not forget to insert your order #' mod='bankwire'} <span class="bold">{$id_order}</span> {l s='in the subject of your Online Transfer' mod='bankwire'}</p>
    <p class="cart_navigation">
    	<input type="submit" name="submit" value="{l s='MAKE PAYMENT' mod='bankwire'}" style="margin-left:22%;" class="pay_button hideOnSubmit" />
    </p>
    </div>
</form>
{/if}
<style>
.add_left{	width:100px;}
.add_right{	margin-left:10px !important; font-weight:bold !important;}
</style>