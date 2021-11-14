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

<table id="summary-tab" width="100%">
<!--
	<tr style="line-height:6px;">
	
		<th class="header small" valign="middle">{l s='Invoice Number' pdf='true'}</th>
		<th class="header small" valign="middle">{l s='Invoice Date' pdf='true'}</th>
		<th class="header small" valign="middle">{l s='Order Reference' pdf='true'}</th>
		<th class="header small" valign="middle">{l s='Order date' pdf='true'}</th>
		{if $addresses.invoice->vat_number}
			<th class="header small" valign="middle">{l s='GST Number' pdf='true'}</th>
		{/if}
	</tr>
	<tr style="line-height:6px;">
		<td class="center small white">{$title|escape:'html':'UTF-8'}</td>
		<td class="center small white">{dateFormat date=$order->invoice_date full=0}</td>
		<td class="center small white">{$order->getUniqReference()}</td>
		<td class="center small white">{dateFormat date=$order->date_add full=0}</td>
		{if $addresses.invoice->vat_number}
			<td class="center small white">
				{$addresses.invoice->vat_number}
			</td>
		{/if}
	</tr>
-->
	<tr style="line-height:6px; padding: 8px;">
		<td class="bold" cellspacing="10" style="font-weight: bold;">Order Reference:</td><td class="left">{$order->getParentOrder()}</td>
		<td class="bold" cellspacing="10">DR Number:</td><td class="left">{$dr}</td>
		<td class="bold" cellspacing="10">PO Number:</td><td class="left">{if $order->po_number !=''}{$order->po_number}{else}--{/if}</td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">Invoice Number:</td><td class="left">{$prefix|escape:'html':'UTF-8'}</td>
		<td class="bold" cellspacing="10">Invoice Date:</td><td class="left">{dateFormat date=$order->invoice_date full=0}</td>
		<td class="bold" cellspacing="10">Payment Mode:</td><td class="left">{$order->payment}</td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">Place of supply:</td><td class="left">{$state_of_supply}</td>
		<td class="bold" cellspacing="10">E Way Bill no:</td><td class="left">--</td>
		<td class="bold" cellspacing="10">Payment Terms</td><td class="left">{$order->credit_days} days</td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">Sales to SEZ:</td><td class="left" colspan="3">{if $footer.sez==1 or $footer.isez==1}Yes{else}No{/if}</td>
		<td class="bold" cellspacing="10">Reverse Charge:</td><td class="left" colspan="2">No</td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">LUT Number:</td><td class="left" colspan="3">{$lut_number}</td>
		<td class="bold" cellspacing="10">LUT Expiry:</td><td class="left" colspan="2">{dateFormat date=$lut_expiry full=0}</td>
	</tr>
</table>
<br>