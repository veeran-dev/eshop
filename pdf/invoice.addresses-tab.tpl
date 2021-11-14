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
<table width="100%" id="addresses-tab"  style="margin-bottom: 4px;">
	<tr style="line-height:4px;">
	<!--
		<td style="width: 33%;">
			<!-- CUSTOMER INFORMATIONS -->
			<!--
			<span class="bold" style="line-height:1px;">{l s='Order Summary' pdf='true'}</span><br />
			<br />
			{l s='ORDER:' pdf='true'}
			#{$order_id}<br />
			
			{l s='SHIPPING DATE:' pdf='true'}
			{dateFormat date=$shipping_date full=0}<br />

			{l s='PAYMENT:' pdf='true'}
			{$order->payment}<br />
			
			{l s='PO:' pdf='true'}
			{$order->po_number}<br />

			{if $footer.gst != 1}
				{l s='TIN:' pdf='true'}
				{$tin}<br />
			{else}
				{l s='GSTIN:' pdf='true'}
				{$gst}<br />
			{/if}

			{l s='PAN :' pdf='true'}
			AAECK8223C<br />
			
			{l s='DR:' pdf='true'}
			{$dr}<br />

			{l s='LUT / BOND:' pdf='true'}
			{$lut_number}<br />
			
			<br />
			<!-- / CUSTOMER INFORMATIONS -->
			<!--
		</td>
		-->
		<td width="33%">
			<span class="bold">{l s='Ship From:' pdf='true'}</span><br>
			{$supplier_address}
		</td>
		<td width="33%">
			{if $delivery_address}
				<span class="bold">{l s='Ship To:' pdf='true'}</span><br>
				{$delivery_address}
			{/if}
		</td>
		<td width="33%"><span class="bold">{l s='Bill To:' pdf='true'}</span><br>
			{$invoice_address}
		</td>
	</tr>
</table>
