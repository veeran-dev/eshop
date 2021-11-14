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
{if isset($c) AND $c}
<!---Hidden by veeran.b -->
<!--
<ul class="display hidden-xs">
	<li class="display-title">{l s='View:'}</li>
    <li id="grid"><a rel="nofollow" href="#" title="{l s='Grid'}"><i class="icon-th-large"></i>{l s='Grid'}</a></li>
    <li id="list"><a rel="nofollow" href="#" title="{l s='List'}"><i class="icon-th-list"></i>{l s='List'}</a></li>
</ul>
-->
{* On 1.5 the var request is setted on the front controller. The next lines assure the retrocompatibility with some modules *}
{if !isset($request)}
	<!-- Sort products -->
	{if isset($smarty.get.id_category) && $smarty.get.id_category}
		{assign var='request' value=$link->getPaginationLink('category', $category, false, true)
}	{elseif isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer}
		{assign var='request' value=$link->getPaginationLink('manufacturer', $manufacturer, false, true)}
	{elseif isset($smarty.get.id_supplier) && $smarty.get.id_supplier}
		{assign var='request' value=$link->getPaginationLink('supplier', $supplier, false, true)}
	{else}
		{assign var='request' value=$link->getPaginationLink(false, false, false, true)}
	{/if}
{/if}

<div class="brand-sub-selector">
    <form action="{$request|escape:'html':'UTF-8'}" method="get">
        
        <!--<input  type="hidden" name="controller" value="manufacturer" />
        <input  type="hidden" name="id_manufacturer" value="{$manufacturer->id_manufacturer|escape:'html':'UTF-8'}" />-->
        {*
        {if isset($p) && $p != '1' }<input  type="hidden" name="p" value="{$p|escape:'html':'UTF-8'}" />{/if}
        {if isset($n)}<input  type="hidden" name="n" value="{$n|escape:'html':'UTF-8'}" />{/if}
        *}
        {if isset($orderby)}<input  type="hidden" name="orderby" value="{$orderby|escape:'html':'UTF-8'}" />{/if}
        {if isset($orderway)}<input  type="hidden" name="orderway" value="{$orderway|escape:'html':'UTF-8'}" />{/if}
        
        <input  type="hidden" name="b" value="{$b|escape:'html':'UTF-8'}" />
        
        <select class="form-control" name="c" id="category_filter" onchange="this.form.submit();">
            <option value="all" {if $c == 'all'}selected{/if}>All Catagory</option>
            {foreach from=$category item=category_list}
            <option value="{$category_list.id_category}" {if $c == $category_list.id_category}selected{/if}>{$category_list.name}</option>
            {/foreach}
        </select>
    </form>
</div>



<!-- /Sort products -->
	{if !isset($paginationId) || $paginationId == ''}
		{addJsDef request=$request}
	{/if}
{/if}
