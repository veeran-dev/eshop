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

{capture name=path}{l s='Order confirmation'}{/capture}

{*<h1 class="page-heading">{l s='Order confirmation'}</h1>*}


{literal}
<!-- Google Code for Purchase Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1000055031;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "c0c0c0";
var google_conversion_label = "ANrYCJHUoAYQ98Hu3AM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1000055031/?value=0&amp;label=ANrYCJHUoAYQ98Hu3AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
{/literal}

{literal}
<script type="text/javascript">
	dataLayer.push({
				'event' : 'transactionComplete',
				'transactionId' : {/literal}{$products[0]['id_order']}{literal},
				'transactionAffiliation' : 'Kobster E-Shop Private Limited',
				'transactionTotal' : {/literal}{$order_value}{literal},
				'transactionTax' : {/literal}{$tax_rate}{literal},
				'transactionProducts' : []
			});
</script>
{/literal}
{foreach from=$products item=data}
	{literal}
		<script type="text/javascript">
			dataLayer[1]['transactionProducts'].push({
					'sku' : {/literal}{$data.reference}{literal},
					'price' : {/literal}{$data.product_price}{literal},
					'quantity' : {/literal}{$data.product_quantity}{literal},
					'name' : "{/literal}{$data.product_name}{literal}"
			});
		</script>
	{/literal}
{/foreach}

{assign var='current_step' value='review'}
{include file="$tpl_dir./order-steps.tpl"}

{include file="$tpl_dir./errors.tpl"}

{*{$HOOK_ORDER_CONFIRMATION}*}

{*{$HOOK_PAYMENT_RETURN}*}

<div class="order-confirmation"> 
	<div class="row">
		<div class="payment-response">
			<img src="{$img_dir}perks/payment-response/success.gif" alt="payment-success" class="payment-response-thumb" />
			<h2>{l s='Thank you, your order has been completed successfully!'}</h2>
			
			<p>We have sent an email confirmation for order <span class="order-id-red">{l s=$id_order}</span>.<br/>
			We are available to help you have a great shopping experience. Call us at <a class="order-id-red" href="tel:18001210405">1800-121-0405</a> or email us to <a class="order-id-red"href="mailto:support@kobster.com">support@kobster.com</a>
			</p>

			<a class="btn btn-default button button-small back-to-home" {if $isPerks} href="{$link->getPageLink('perksDeals', true)|escape:'html':'UTF-8'}" {else} href="{$link->getPageLink('shop', true)|escape:'html':'UTF-8'}" {/if} title="{l s='Go back to Home'}"><span>{l s='Go back to Home'}</span></a>

		</div>
        
        {*<div class="b2b-alert-container-all">
            <div class="b2b-alert-icon">
                <img src="{$img_dir}high-importance-16.png" class="importantance-icon" />
            </div>
            <div>
                We are only open for Corporates, SMEs, Professionals & Resellers and not for Individuals.
            </div>
        </div>*}
        
	</div>
 </div>

{if $is_guest}
	<p>{l s='Your order ID is:'} <span class="bold">{$id_order_formatted}</span> . {l s='Your order ID has been sent via email.'}</p>
    <p class="cart_navigation exclusive">
	<a class="button-exclusive btn btn-default" href="{$link->getPageLink('guest-tracking', true, NULL, "id_order={$reference_order|urlencode}&email={$email|urlencode}")|escape:'html':'UTF-8'}" title="{l s='Follow my order'}"><i class="icon-chevron-left"></i>{l s='Follow my order'}</a>
    </p>
{else}
<p class="cart_navigation exclusive hidden">
	<a class="button-black" {if $isPerks == 1}href="{$link->getPageLink('perksDeals', true)}"{else}href="{$link->getPageLink('index', true)|escape:'html':'UTF-8'}"{/if} title="{l s='Go to home page'}">{l s='Continue Shopping'}</a>
	<a class="button-gray" href="{$link->getPageLink('history', true)|escape:'html':'UTF-8'}" title="{l s='Go to your order history page'}">{l s='View Orders'}</a>
</p>
{/if}

<!-- Offer Conversion: Kobster -->
<iframe src="https://tracking.affiliatehub.co.in/SL1OR" scrolling="no" frameborder="0" width="1" height="1"></iframe>
<!-- // End Offer Conversion -->