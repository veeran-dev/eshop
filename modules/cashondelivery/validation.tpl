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

{capture name=path}{l s='Shipping' mod='cashondelivery'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order Summary' mod='cashondelivery'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

<h3>{l s='Cash on delivery (COD) payment' mod='cashondelivery'}</h3>

<form action="{$this_path_ssl}validation.php" method="post" id="cod">
	<input type="hidden" name="confirm" value="1" />
    <div style="height:30px; border:1px solid #8f8f8f; padding-left:20px;"><h4>Pay By Cash On Delivery</h4></div>
    <div style=" border: 1px solid #8F8F8F;height: 210px;padding-left: 15%;padding-top: 15%; border-top:none;">
        <span>Amount Payable on Delivery : <b>{convertPrice price=$total}</b></span>
        <span>
        {if $use_taxes == 1}
        {l s='(tax incl.)' mod='cashondelivery'}
        {/if}
        </span>    
        <p class="cart_navigation">
        <input type="submit" name="submit" value="{l s='MAKE PAYMENT' mod='cashondelivery'}" class="pay_button" style="margin-left:15%" />
        </p>
    </div>
</form>
