{*{include file="$tpl_dir./breadcrumb.tpl"}*}

{if $responseCode == 0}
	<h2>{l s='Thank You for Your Order at Kobster.com.'}</h2> <br />
	<h3>Your online payment was accepted successfully.</h3><br />
	<p>All the details of your order has been emailed to you. Your product(s) will be shipped soon.</p>
	<br /><p>For any questions or for further information, please contact our <a href="{$link->getPageLink('contact-form.php', true)}">customer Support</a>.<p><br />
	<p>If you would like to view your order history please <a href="../../history.php" title="{l s='History of Orders' mod='EBS'}">click here!</a></p>
{else}
	<h2>{l s='Your online transaction failed!'}</h2>
	<p>Oops, the bank has declined your transaction. Please try an alternate payment option or contact your bank for more details.</p><br />
	<a href="{$link->getPageLink('order.php', true)}?step=3" class="button_large">{l s='Other payment methods' mod='cashondelivery'}</a>
{/if}
<!-- Offer Conversion: Kobster -->
<iframe src="https://tracking.affiliatehub.co.in/SL1OR" scrolling="no" frameborder="0" width="1" height="1"></iframe>
<!-- // End Offer Conversion -->
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