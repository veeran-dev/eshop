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

<!--<p class="payment_module" {if {$total_price} < 1500}style="cursor:default; opacity:0.6"{/if}>
	<a {if {$total_price} < 1500}onclick="return false;" style="cursor:default; opacity:0.6"{/if} href="{$this_path_ssl}validation.php" title="{l s='Pay with cash on delivery (COD)' mod='cashondelivery'}">
		<!--<img src="{$this_path}cashondelivery.gif" alt="{l s='Pay with cash on delivery (COD)' mod='cashondelivery'}" style="float:left;" />-->
		{*{l s='Pay with cash on delivery (COD) ' mod='cashondelivery'}
		<br />{l s='You pay for the product(s) upon delivery' mod='cashondelivery'}
		{if {$total_price} < 1500}<br /><b>Sorry, COD can only be used for orders above Rs 1500.</b>{/if}*}
       
		<!--<br style="clear:both;" />
	</a>
</p>-->