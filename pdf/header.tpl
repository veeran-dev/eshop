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
<style>
    .supplier-address{
        font-size: 20px;
    }
</style>

<table class="table-header" style="width: 100%;margin-bottom:0px;">
<tr>
	<td class="supplier-address" style="width: 40%; text-align: left;">
		{$supplier_title_address}
	</td>
	<td style="width: 20%;">
		{$header}
	</td>
	<td style="width: 40%;text-align: center;">
		<span style="margin-bottom: 50px;">
			{if isset($header)}{$title|escape:'html':'UTF-8'}{" Dt. "|cat:$date}{/if}
		</span>
	</td>
</tr>
</table>