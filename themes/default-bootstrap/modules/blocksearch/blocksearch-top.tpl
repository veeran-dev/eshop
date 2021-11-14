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
{if isPerks != 1}
<div class="searchbar">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Block search module TOP -->
                <div id="search_block_top" class="">
                    <form id="searchbox" method="get" action="{$link->getPageLink('search', null, null, null, false, null, true)|escape:'html':'UTF-8'}" >
                        <input type="hidden" name="controller" value="search" />
                        <input type="hidden" name="orderby" value="position" />
                        <input type="hidden" name="orderway" value="desc" />
                        <input type="hidden" name="search_category" class="search_category_id" id="search_category" value="" />
                        <input class="search_query search-input" type="text" id="search_query_top" name="search_query" placeholder="{l s='Type Product name or Product Code or Manufacturer code' mod='blocksearch'}" value="{$search_query|escape:'htmlall':'UTF-8'|stripslashes}" />
                        
                        <!-- <div class="category-dropdown">
                            <div class="dropdown-toggle" type="button" id="custom-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">All categories</div>
                            <ul id="categorySelect" class="dropdown-menu" aria-labelledby="custom-dropdown">
                                {foreach from=$category_list item=category}
                                    <li value="{$category.id_category}">{$category.name}</li>
                                {/foreach}
                            </ul>
                        </div> -->

                        <select class="form-control noUniform category-dropdown">
                            <option value="">All Categories</option>
                            {foreach from=$category_list item=category}
								<option value="{$category.id_category}">{$category.name}</option>
                            {/foreach}
                        </select>
                        
                        <button type="submit" name="submit_search" class="search-button">
                            <span class="sr-only">{l s='Search' mod='blocksearch'}</span>
                        </button>
                    </form>
                </div>
                <!-- /Block search module TOP -->
            </div>
        </div>
    </div>
</div>
{/if}