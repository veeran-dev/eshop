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
{if isset($orderProducts) && count($orderProducts)}
<section class="product-slider">
	<div id="crossselling" class="page-product-box">
        <div class="product-slider-title">
            <h3 class="">
                {if $page_name == 'product'}
                    {l s='Frequently Bought Together' mod='crossselling'}
                {else}
                    {l s='We recommend' mod='crossselling'}
                {/if}
            </h3>
        </div>
		<div id="crossselling_list">
			<ul id="crossselling_list_car" class="bxslider clearfix">
				{foreach from=$orderProducts item='orderProduct' name=orderProduct}
					<li class="product-box item" itemprop="isRelatedTo" itemscope itemtype="https://schema.org/Product">
						<div class="product-container">
		                    <div class="product">
                    	<div class="product-visual">
                            <a class="product_img_link" href="{$orderProduct.link|escape:'html':'UTF-8'}" title="{$orderProduct.name|escape:'html':'UTF-8'}" itemprop="url">
                                <img class="" src="{$link->getImageLink($orderProduct.link_rewrite, $orderProduct.id_image, 'large')|escape:'html':'UTF-8'}" href="{$orderProduct.link|escape:'html':'UTF-8'}" alt="{if !empty($orderProduct.legend)}{$orderProduct.legend|escape:'html':'UTF-8'}{else}{$orderProduct.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($orderProduct.legend)}{$orderProduct.legend|escape:'html':'UTF-8'}{else}{$orderProduct.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
                            </a>
                            <a class="quick-view" href="{$orderProduct.link|escape:'html':'UTF-8'}" rel="{$orderProduct.link|escape:'html':'UTF-8'}">
                                <span>{l s='Quick view'}</span>
                            </a>
                        </div>
                        <div class="product-name">
                            <h3 itemprop="name" href="{$orderProduct.link|escape:'html':'UTF-8'}" title="{$orderProduct.name|escape:'html':'UTF-8'}" itemprop="url">{$orderProduct.name|truncate:50:'...'|escape:'html':'UTF-8'}</h3>
                        </div>
                        <div class="product-details">
                            <div class="product-standard">
                                <div class="star_content product-rating"  itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                                {section name="i" start=0 loop=5 step=1}
                                    {if $orderProduct['ratings'].grade le $smarty.section.i.index}
                                        <div class="star"></div>
                                    {else}
                                        <div class="star star_on"></div>
                                    {/if}
                                {/section}
                                </div>
                               
                                {if $orderProduct.nbComments}
                                <div class="comments">{$orderProduct.nbComments} Reviews</div>
                                {else}
                                <div class="comments">{l s='No Reviews'}</div>
                                {/if}
                            </div>
                            <div class="product-value">
                            	{convertPrice price=$orderProduct.displayed_price}
                            </div>
                        </div>
                    </div>
		                </div>
					</li>
				{/foreach}
			</ul>
		</div>
	</div>
</section>
{/if}
