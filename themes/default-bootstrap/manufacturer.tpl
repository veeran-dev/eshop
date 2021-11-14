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


{include file="$tpl_dir./errors.tpl"}

{if !isset($errors) OR !sizeof($errors)}
<div class="brand-header-wrapper">
	<div class="brand-header">
		<div class="brand-logo">
            <img class="img-responsive" src="{$img_manu_dir}{$manufacturer->image|escape:'html':'UTF-8'}-medium_default.jpg" alt="" />
		</div>
		<div class="brand-details">
			<h1 class="page-heading product-listing">{$manufacturer->name|escape:'html':'UTF-8'}</h1>
				<div class="description_box rte">
                
                	<p><strong>{$totalProducts}</strong> {l s='products to choose from'}</p>

					{if !empty($manufacturer->short_description)}
						<p>Known for: {$manufacturer->short_description}</p>
					{/if}
                    
		            {if !empty($manufacturer->description)}
						<p>{$manufacturer->description}</p>
					{/if}
		            
		            
		            
		            {if isset($manufacturer->nb_products) && $manufacturer->nb_products == 1}
		                {l s='%d product' sprintf=$manufacturer->nb_products|intval}
		            {else}
		              {if isset($manufacturer->nb_products) && $manufacturer->nb_products > 0}
		                {l s='%d products' sprintf=$manufacturer->nb_products|intval}
		              {/if}
		            {/if}
				</div>
				<!--<div class="most-searched-products">
					<span>Most Searched Products:</span> <a href="#">First Product 001</a>, <a href="#">First Product 002</a>, <a href="#">First Product 003</a>, <a href="#">First Product 003</a>
				</div>-->
		</div>
        
		<div class="col-md-4 brand_head_wrap_right pull-right">
            <div class="brand-filter">
                {include file="./catagory-sort.tpl"}
                {include file="./brand-sort.tpl"}
            </div>
        </div>
        
	</div>
</div>
<div class="brand-content-wrapper">
	<div class="brand-content">
	{if $products}
			<div class="content_sortPagiBar">
		    	<div class="sortPagiBar clearfix">
					{include file="./product-sort.tpl"}
                    {include file="./nbr-product-page.tpl"}
				</div>
		    	<div class="top-pagination-content clearfix">
		        	{include file="./product-compare.tpl"}
		            {include file="$tpl_dir./pagination.tpl" no_follow=1}
		        </div>
			</div>

			{include file="./product-list.tpl" products=$products}

			<div class="content_sortPagiBar">
		        <div class="bottom-pagination-content clearfix">
		        	{include file="./product-compare.tpl"}
					{include file="./pagination.tpl" no_follow=1 paginationId='bottom'}
		        </div>
			</div>
		{else}
			<p class="alert alert-warning">{l s='No products for this manufacturer.'}</p>
		{/if}
	{/if}
	</div>
</div>