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

<!--  TAX DETAILS -->
{if $tax_exempt}

	{l s='Exempt of GST according to section 259B of the General Tax Code.' pdf='true'}

{elseif (isset($tax_breakdowns) && $tax_breakdowns)}
	
	<table id="tax-tab" width="100%">
	<!--
		<thead>
			<tr>
				<th class="header small">{l s='Tax Detail' pdf='true'}</th>
				<th class="header small">{l s='Tax Rate' pdf='true'}</th>
				{if $display_tax_bases_in_breakdowns}
					<th class="header small">{l s='Base price' pdf='true'}</th>
				{/if}
				<th class="header-right small">{l s='Total Tax' pdf='true'}</th>
			</tr>
		</thead>
		<tbody>
		{assign var=has_line value=false}

		{foreach $tax_breakdowns as $label => $bd}
			{assign var=label_printed value=false}

			{foreach $bd as $line}
				{if $line.rate == 0}
					{continue}
				{/if}
				{assign var=has_line value=true}
				<tr>
					<td class="white">
						{if !$label_printed}
							{if $label == 'product_tax'}
								{l s='Products' pdf='true'}
							{elseif $label == 'shipping_tax'}
								{l s='Shipping' pdf='true'}
							{elseif $label == 'ecotax_tax'}
								{l s='Ecotax' pdf='true'}
							{elseif $label == 'wrapping_tax'}
								{l s='Wrapping' pdf='true'}
							{/if}
							{assign var=label_printed value=true}
						{/if}
					</td>

					<td class="center white">
						{$line.rate} %
					</td>

					{if $display_tax_bases_in_breakdowns}
						<td class="right white">
							{if isset($is_order_slip) && $is_order_slip}- {/if}
							{displayPrice currency=$order->id_currency price=$line.total_tax_excl}
						</td>
					{/if}

					<td class="right white">
						{if isset($is_order_slip) && $is_order_slip}- {/if}
						{displayPrice currency=$order->id_currency price=$line.total_amount}
					</td>
				</tr>
			{/foreach}
		{/foreach}
	-->
		{if $footer.gst == 1}
			<tr>
				<th class="header small">Tax</th>
				<th class="header small">5%</th>
				<th class="header small">12%</th>
				<th class="header small">18%</th>
				<th class="header small">28%</th>
			</tr>
			{if $footer.cgst > 0 && $footer.sez != 1 && $footer.isez != 1}
			<tr>
				<td style="font-size: 8pt;" class="center white">SGST</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['5.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['5.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['12.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['12.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
				{if isset($tax_breakdowns['product_tax']['18.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['18.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['28.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['28.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
			</tr>
			<tr>
				<td style="font-size: 8pt;" class="center white">CGST</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['5.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['5.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['12.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['12.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
				{if isset($tax_breakdowns['product_tax']['18.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['18.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['28.000'].total_amount)}
						{math equation="x / y" x=$tax_breakdowns['product_tax']['28.000'].total_amount y=2 format="%.2f"}
					{else}
						0.00
					{/if}
				</td>
			</tr>
			{else if $footer.igst > 0 || $footer.sez == 1 || $footer.isez == 1}
			<tr>
				<td style="font-size: 8pt;" class="center white">IGST</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['5.000'].total_amount)}
						{$tax_breakdowns['product_tax']['5.000'].total_amount}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
					<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['12.000'].total_amount)}
						{$tax_breakdowns['product_tax']['12.000'].total_amount}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
					<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['18.000'].total_amount)}
						{$tax_breakdowns['product_tax']['18.000'].total_amount}
					{else}
						0.00
					{/if}
				</td>
				<td style="font-size: 8pt;" class="center white">
					<span>&#8377;</span>
					{if isset($tax_breakdowns['product_tax']['28.000'].total_amount)}
						{$tax_breakdowns['product_tax']['28.000'].total_amount}
					{else}
						0.00
					{/if}
				</td>
			</tr>
			{/if}
		{/if}
		{if !$has_line}
		<tr>
			{if $footer.sez == 1}
			{else}
			<td class="white center" colspan="{if $display_tax_bases_in_breakdowns}4{else}3{/if}">
				{l s='No taxes' pdf='true'}
			</td>
			{/if}
		</tr>
		{/if}

		</tbody>
	</table>
	{if $footer.sez == 1 || $footer.isez == 1}
	<table width="100%" height="">
		{if $footer.isez == 1}
			<tr></tr>
			<tr>
				<td style="font-size: 8pt;text-align:left;">a) Supply meant for export on payment of IGST.</td>
			</tr>
			<tr>
				<td style="font-size: 8pt;text-align:left;">b) IGST will be paid and claimed by Kobster.</td>
			</tr>
		{else}
			<tr></tr>
			<tr>
				<td style="font-size: 8pt;text-align:left;">a)  Supply meant for export under letter of undertaking without payment of IGST.</td>
			</tr>
		{/if}
	</table>
	{/if}
	{elseif $footer.sez == 1 || $footer.isez == 1}
	<tr>
	{if $footer.isez == 1}
		<tr></tr>
		<tr>
			<td style="font-size: 8pt;text-align:left;" class="white">a. Supply meant for export on payment of IGST.</td>
		</tr>
		<tr>
			<td style="font-size: 8pt;text-align:left;" class="white">b. IGST will be paid and claimed by Kobster.</td>
		</tr>
	{else}
		<tr></tr>
		<tr>
			<td style="font-size: 8pt;text-align:left;">a)  Supply meant for export under letter of undertaking without payment of IGST.</td>
		</tr>
	{/if}
	</tr>
{/if}
<br/>
<br/>
<tr style="font-size: 9pt;text-align:left;">{$footer.total_in_words}</tr>
<!--  / TAX DETAILS -->
