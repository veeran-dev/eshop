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

{assign var=color_header value="#F0F0F0"}
{assign var=color_border value="#000000"}
{assign var=color_border_lighter value="#CCCCCC"}
{assign var=color_line_even value="#FFFFFF"}
{assign var=color_line_odd value="#F9F9F9"}
{assign var=font_size_text value="8pt"}
{assign var=font_size_header value="8pt"}
{assign var=font_size_product value="8pt"}
{assign var=font_size_total value="9pt"}
{assign var=height_header value="20px"}
{assign var=table_padding value="4px"}

<style>

	table{
		margin-bottom: 8px; 	
	}
	table, th, td {
		padding: 0pt;
		margin: 0pt;
	}

	table.product {
		border: 1px solid {$color_border};
		border-collapse: collapse;
	}
	table#addresses-tab{
		border-collapse: collapse;
		padding: 6px;
	}
	table#addresses-tab tr{
		line-height: 4px;
	}
	table#addresses-tab tr td {
		border:1px solid #CCCCCC;
		font-size: 8pt;
	}
	table#addresses-tab span {
		font-weight: bold;
	}
	table#addresses-tab tr td .bold{
		font-weight: bold !important;
	}

	table#summary-tab {
		font-size: {$font_size_product};
		padding: 6px;
		border-collapse: collapse;
		margin-top: 8px;
	}	
	table#summary-tab tr td{
		border: 1px solid #CCCCCC;
		text-align: left;
	}
	table#total-tab {
		font-size: {$font_size_total};
		padding: {$table_padding};
		/*border: 1pt solid {$color_border};*/
	}
	table#tax-tab {
		padding: {$table_padding};
		border: 1pt solid {$color_border};
	}
	table#payment-tab {
		padding: {$table_padding};
		border: 1px solid {$color_border};
	}

	th.product {
		border-bottom: 1px solid {$color_border};
	}

	tr.discount th.header {
		border-top: 1px solid {$color_border};
	}

	tr.product td {
		border-bottom: 1px solid {$color_border_lighter};
	}

	tr.color_line_even {
		background-color: {$color_line_even};
	}

	tr.color_line_odd {
		background-color: {$color_line_odd};
	}

	tr.customization_data td {
	}

	td.product {
		vertical-align: middle;
		font-size: {$font_size_product};
	}

	th.header {
		font-size: {$font_size_header};
		height: {$height_header};
		background-color: {$color_header};
		vertical-align: middle;
		text-align: center;
		font-weight: bold;
	}

	th.header-right {
		font-size: {$font_size_header};
		height: {$height_header};
		background-color: {$color_header};
		vertical-align: middle;
		text-align: right;
		font-weight: bold;
	}

	th.payment {
		background-color: {$color_header};
		vertical-align: middle;
		font-weight: bold;
	}

	th.tva {
		background-color: {$color_header};
		vertical-align: middle;
		font-weight: bold;
	}

	tr.separator td {
		border-top: 1px solid #000000;
	}
	table#footer-note tr td{
		border: 1px solid black;
	}
	.left {
		text-align: left;
	}

	.fright {
		float: right;
	}

	.right {
		text-align: right;
	}

	.center {
		text-align: center;
	}

	.bold {
		font-weight: bold;
	}

	.border {
		border: 1px solid black;
	}

	.no_top_border {
		border-top:hidden;
		border-bottom:1px solid black;
		border-left:1px solid black;
		border-right:1px solid black;
	}

	.grey {
		text-align: left;
		/*background-color: {$color_header};*/

	}

	/* This is used for the border size */
	.white {
		text-align: left;
		background-color: #FFFFFF;
	}

	.big,
	tr.big td{
		font-size: 110%;
	}
	
	.small, table.small th, table.small td {
		font-size:small;
	}
</style>
