
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
<table id="total-tab" width="100%">

	<tr>
		<td class="grey" width="50%">
			{l s='Total Products:' pdf='true'}
		</td>
		<td class="white" width="50%">
			{displayPrice currency=$order->id_currency price=$footer.products_before_discounts_tax_excl}
		</td>
	</tr>


	{if $footer.wrapping_tax_excl > 0}
		<tr>
			<td class="grey">
				{l s='Wrapping Cost:' pdf='true'}
			</td>
			<td class="white">{displayPrice currency=$order->id_currency price=$footer.wrapping_tax_excl}</td>
		</tr>
	{/if}

<!-- Ref #685 -->
<!-- 	<tr class="">
		<td class="grey">
			{l s='Total (Tax excl.):' pdf='true'}
		</td>
		<td class="white">
			{displayPrice currency=$order->id_currency price=$footer.total_paid_tax_excl}
		</td>
	</tr> -->
	{if $footer.sez == 1 || $footer.isez == 1}
		<tr class="">
			<td class="grey">
				{l s='Total IGST:' pdf='true'}
			</td>
			<td class="white">
				{displayPrice currency=$order->id_currency price=$footer.total_taxes}
			</td>
		</tr>
	{/if}
	{if $footer.sez !=1 && $footer.isez !=1}
		{if $footer.gst == 0}
			{if $footer.total_taxes > 0}
			<tr class="">
				<td class="grey">
					{l s='Total Tax:' pdf='true'}
				</td>
				<td class="white">
					{displayPrice currency=$order->id_currency price=$footer.total_taxes}
				</td>
			</tr>
			{/if}
		{else}
			{if $footer.igst > 0}
			<tr class="">
				<td class="grey">
					{l s='Total IGST:' pdf='true'}
				</td>
				<td class="white">
					{displayPrice currency=$order->id_currency price=$footer.total_taxes}
				</td>
			</tr>
			{else $footer.cgst > 0}
			<tr class="">
				<td class="grey">
					{l s='Total CGST:' pdf='true'}
				</td>
				<td class="white">
					{displayPrice currency=$order->id_currency price=$footer.cgst}
				</td>
			</tr>
			<tr class="">
				<td class="grey">
					{l s='Total SGST:' pdf='true'}
				</td>
				<td class="white">
					{displayPrice currency=$order->id_currency price=$footer.sgst}
				</td>
			</tr>
			{/if}
		{/if}
	{/if}

	{if !$order->isVirtual()}
	<tr>
		<td class="grey" width="50%">
			{l s='Shipping Cost:' pdf='true'}
		</td>
		<td class="white" width="50%">
			{if $footer.shipping_tax_excl > 0}
				{displayPrice currency=$order->id_currency price=$footer.shipping_tax_excl}
			{else}
				{l s='Free Shipping' pdf='true'}
			{/if}
		</td>
	</tr>
	{/if}
	{if $footer.product_discounts_tax_excl > 0}

		<tr>
			<td class="grey" width="50%">
				{l s='Total Discounts:' pdf='true'}
			</td>
			<td class="white" width="50%">
				- {displayPrice currency=$order->id_currency price=$footer.product_discounts_tax_incl}
			</td>
		</tr>

	{/if}
	{if $footer.product_discounts_tax_excl > 0}
		<tr class="">
			<td class="grey">
				{l s='Total:' pdf='true'}
			</td>
			<td class="white">
				{displayPrice currency=$order->id_currency price=$footer.total_paid_tax_incl}
			</td>
		</tr>
	{else}
		{assign var=total value=$footer.total_paid_tax_incl}
		<tr class="">
			<td class="grey">
				{l s='Total:' pdf='true'}
			</td>
			<td class="white">
				{displayPrice currency=$order->id_currency price=$total}
			</td>
		</tr>
	{/if}
	
</table>
