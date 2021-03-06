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
<div id="mywishlist">
	{capture name=path}<a href="{$link->getPageLink('my-account.php', true)}">{l s='My account' mod='blockwishlist'}</a><span class="navigation-pipe">{$navigationPipe}</span>{l s='My Purchase List' mod='blockwishlist'}{/capture}
	{* {include file="$tpl_dir./breadcrumb.tpl"} *}

	<h2 class="pur_list_h"><img src="{$img_dir}icon/purchase_small.png" alt="{l s='wishlist' mod='blockwishlist'}" class="icon" />{l s='My Purchase List' mod='blockwishlist'}</h2>

	{include file="$tpl_dir./errors.tpl"}

	{if $id_customer|intval neq 0}
		<form action="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}modules/blockwishlist/mywishlist.php" method="post" class="std" style="display: none">
			<fieldset>
				<h3>{l s='New wishlist' mod='blockwishlist'}</h3>
				<input type="hidden" name="token" value="{$token|escape:'htmlall':'UTF-8'}" />
				<label class="align_right" for="name">{l s='Name' mod='blockwishlist'}</label>
				<input type="text" id="name" name="name" value="{if isset($smarty.post.name) and $errors|@count > 0}{$smarty.post.name|escape:'htmlall':'UTF-8'}{/if}" />
				<input type="submit" name="submitWishlist" id="submitWishlist" value="{l s='Save' mod='blockwishlist'}" class="exclusive" />
			</fieldset>
		</form>
		{if $wishlists}
		<div id="block-history" class="block-center">
			<table class="std">
				<thead>
					<tr>
						<th class="first_item">{l s='Purchase List Name' mod='blockwishlist'}</th>
						<th class="item mywishlist_first">{l s='Products' mod='blockwishlist'}</th>
						<!-- <th class="item mywishlist_first">{l s='Viewed' mod='blockwishlist'}</th> -->
						<!-- <th class="item mywishlist_second">{l s='Created' mod='blockwishlist'}</th> -->
						<th class="item mywishlist_second">{l s='Open Existing List' mod='blockwishlist'}</th>
						<th class="item mywishlist_second">{l s='Open New List' mod='blockwishlist'}</th>
						<!-- <th class="last_item mywishlist_first">{l s='Delete' mod='blockwishlist'}</th> -->
					</tr>
				</thead>
				<tbody>
				{section name=i loop=$wishlists}
					<tr id="wishlist_{$wishlists[i].id_wishlist|intval}">
						<td class="bold" style="width:200px;"><a href="javascript:;" onclick="javascript:WishlistManage('block-order-detail', '{$wishlists[i].id_wishlist|intval}');">{$wishlists[i].name|truncate:30:'...'|escape:'htmlall':'UTF-8'}</a></td>
						<td class="bold align_center">
						{assign var=n value=0}
						{foreach from=$nbProducts item=nb name=i}
							{if $nb.id_wishlist eq $wishlists[i].id_wishlist}
								{assign var=n value=$nb.noProducts|intval}
							{/if}
						{/foreach}
						{if $n}
							{$n|intval}
						{else}
							0
						{/if}
						</td>
						<!-- <td class="align_center">{$wishlists[i].counter|intval}</td> -->
						<!-- <td class="align_center">{$wishlists[i].date_add|date_format:"%Y-%m-%d"}</td> -->
						<td class="align_center"><a href="javascript:;" onclick="javascript:WishlistManage('block-order-detail', '{$wishlists[i].id_wishlist|intval}');">{l s='Open Existing List' mod='blockwishlist'}</a></td>
						<td class="align_center"><a href="javascript:;" onclick="javascript:WishlistRefreshManage('block-order-detail', '{$wishlists[i].id_wishlist|intval}', '1');">{l s='Open New List' mod='blockwishlist'}</a></td>
						<!-- <td class="align_center">
							<a href="javascript:;"onclick="return (WishlistDelete('wishlist_{$wishlists[i].id_wishlist|intval}', '{$wishlists[i].id_wishlist|intval}', '{l s='Do you really want to delete this wishlist ?' mod='blockwishlist'}'));"><img src="{$content_dir}modules/blockwishlist/img/icon/delete.png" alt="{l s='Delete' mod='blockwishlist'}" /></a>
						</td> -->
					</tr>
				{/section}
				</tbody>
			</table>
		</div>
		<div id="block-order-detail">&nbsp;</div>
		<div id="purListStatus">
			<span class="pLeft">
				<p>Current Purchase List: </p>
				<span>Products: <output id="total_products">0</output></span>
				<span>Total Value: Rs. <output id="total_price">0</output></span>
			</span>
			<span class="pLeft">
				<p>All Purchase List: </p>
				<span>Total Products: <output id="total_products_all">{$total_wish_qty}</output></span>
				<span>Total Order Value: Rs. <output id="total_price_all">{$total_wish_price|intval}</output></span>
				<span style="display:none"><output id="total_price_sans">0</output></span>
				<span style="display:none"><output id="total_qty_sans">0</output></span>
			</span>
			<span class="pRight">
				<a src="#" class="confirm_pur_list_all_prod" href="getProductsPurchaseList.php"><img src="{$img_dir}icon/next_2.png" alt="" class="icon" />Process Order</a>
			</span>
		</div>
		{/if}
	{/if}

	<ul class="footer_links">
		<li><a href="{$link->getPageLink('my-account.php', true)}"><img src="{$img_dir}icon/my-account.gif" alt="" class="icon" /></a><a href="{$link->getPageLink('my-account.php', true)}">{l s='Back to My Dashboard' mod='blockwishlist'}</a></li>
		<li><a href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}"><img src="{$img_dir}icon/home.gif" alt="" class="icon" /></a><a href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}">{l s='Home' mod='blockwishlist'}</a></li>
	</ul>
</div>
