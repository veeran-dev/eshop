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

<div class="brand-wrapper">
{capture name=path}{l s='Brands'}{/capture}

<div class="col-md-2">
    {*<!--  dummy container for Brand title center alignment -->*}
</div>
<div class="col-md-8 brand_head_wrap_left">
    <h1 class="brand_title">{l s='Brands at Kobster'}</h1>
    <p>	
        {strip}
            <span class="heading-counter">
                {if $nbManufacturers == 0}{l s='There are no Brands.'}
                {else}
                    {if $nbManufacturers == 1}
                        {l s='There is 1 brand'}
                    {else}
                        {l s='%d Genuine Brands to Choose From' sprintf=$nbManufacturers}
                    {/if}
                {/if}
            </span>
        {/strip}
    </p>
</div>

<div class="col-md-2 brand_head_wrap_right pull-right">
    <div class="brand-filter">
        {* {include file="./catagory-sort.tpl"} *}
        {include file="./brand-sort.tpl"}
    </div>
</div>

{if isset($errors) AND $errors}
	{include file="$tpl_dir./errors.tpl"}
{else}
	{if $nbManufacturers > 0}
    	<div class="content_sortPagiBar">
        	<div class="sortPagiBar clearfix">
				{if isset($manufacturer) && isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
					<ul class="display hidden-xs">
						<li class="display-title">
							{l s='View:'}
						</li>
						<li id="grid">
							<a rel="nofollow" href="#" title="{l s='Grid'}">
								<i class="icon-th-large"></i>{l s='Grid'}
							</a>
						</li>
						<li id="list">
							<a rel="nofollow" href="#" title="{l s='List'}">
								<i class="icon-th-list"></i>{l s='List'}
							</a>
						</li>
					</ul>
				{/if}
                {include file="./nbr-product-page.tpl"}
            </div>
        	<div class="top-pagination-content clearfix bottom-line">
				{include file="$tpl_dir./pagination.tpl" no_follow=1}
            </div>
        </div> <!-- .content_sortPagiBar -->

        {assign var='nbItemsPerLine' value=3}
        {assign var='nbItemsPerLineTablet' value=2}
        {assign var='nbLi' value=$manufacturers|@count}
        {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
        {math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}

		<div id="manufacturers_list" class="list row">
        
			{foreach from=$manufacturers item=manufacturer name=manufacturers}

               	<div class="col-md-4">
                    <div class="col-md-12 mansup-container">
						
                        {*
                        <div class="col-md-6 left-side">
                        	
                            {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                                <a class="lnk_img"
                                href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}"
                                title="{$manufacturer.name|escape:'html':'UTF-8'}" >
                            {/if}
                            	{if isset($manufacturer.product_image) && $manufacturer.product_image > 0}
                                <img class="img-responsive" src="{$img_manu_dir}product/{$manufacturer.id_manufacturer}.jpg" alt="" />
                                {else}
                                <img class="img-responsive" src="{$img_manu_dir}en-default-large.jpg" alt="No Image" />
                                {/if}

                            {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                          </a>
                            {/if}
                        
            			</div>
                        *}
                        
                        <div class="col-md-12 right-side">
                        
                        	<table>
                            	<tr>
                                	
                                    <td>
                                    	{if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                                            <a class="lnk_img"
                                            href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}"
                                            title="{$manufacturer.name|escape:'html':'UTF-8'}" >
                                        {/if}
                                            <img class="img-responsive" src="{$img_manu_dir}{$manufacturer.image|escape:'html':'UTF-8'}-medium_default.jpg" alt="" />
                                        {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
                                            </a>
                                        {/if}
                                    </td>
                                </tr>
                                {if isset($manufacturer.short_description)}
                                <tr>
                                    <td>{$manufacturer.short_description|escape:'html':'UTF-8'}</td>
                                </tr>
                                {/if}
                                <tr>
                                	
                                    <td>
                                    	{if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
			                            	<a class="blue_link" href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
			                            {/if}
			                            {if isset($manufacturer.nb_products) && $manufacturer.nb_products == 1}
			                            	{l s='%d product' sprintf=$manufacturer.nb_products|intval}
			                            {else}
			                              {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
			                            	{l s='%d products' sprintf=$manufacturer.nb_products|intval}
			                              {/if}
			                            {/if}
			                            {if isset($manufacturer.nb_products) && $manufacturer.nb_products > 0}
			                        		</a>
			                        	{/if}
                                    </td>
                                </tr>

                            </table>

                        </div>
                        
                        <div class="col-md-12 bottom-side">
                        	<h2>
                                <a
                                href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}"
                                title="{$manufacturer.name|escape:'html':'UTF-8'}" >
                                {$manufacturer.name|truncate:60:'..'|escape:'html':'UTF-8'}
                                </a>
                            </h2>
                            
                            {if isset($manufacturer.description)}          
                            <p>{$manufacturer.description|truncate:70:'..'|escape:'html':'UTF-8'}
                            <a class="blue_link pull-right"
                            href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}"
                            title="{$manufacturer.name|escape:'html':'UTF-8'}" >
                            Show More
                            </a>
                            </p>
                            {/if}

                        </div>
			            
			        </div>
             	</div>
			{/foreach}
		</div>
        
        
        <div class="content_sortPagiBar">
        	<div class="bottom-pagination-content clearfix">
				{include file="$tpl_dir./pagination.tpl" no_follow=1 paginationId='bottom'}
            </div>
        </div>
	{/if}
{/if}
</div>
