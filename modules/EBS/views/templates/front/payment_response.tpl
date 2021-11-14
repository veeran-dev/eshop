{if $status == 'Ok'}
	<div class="payment-response">
			<img src="{$img_dir}perks/payment-response/success.gif" alt="payment-success" class="payment-response-thumb" />
			<h2>{l s='Thank you, your order has been completed successfully!'}</h2>
			
			<p>We have sent an email confirmation for order <span class="order-id-red">{l s=$id_order}</span>.<br/>
			We are available to help you have a great shopping experience. Call us at <a class="order-id-red" href="tel:18001210405">1800-121-0405</a> or email us to <a class="order-id-red"href="mailto:support@kobster.com">support@kobster.com</a>
			</p>

			<a class="btn btn-default button button-small back-to-home" {if $isPerks} href="{$link->getPageLink('perksDeals', true)|escape:'html':'UTF-8'}" {else} href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" {/if} title="{l s='Go back to Home'}"><span>{l s='Go back to Home'}</span></a>

		</div>
	{*<p class="success">
		{l s='Your order has been completed.' mod='ebs'}
		<br /><br />
		<br /><br />{l s='For any questions or for further information, please contact our' mod='ebs'} <a href="{$base_dir}contact-form.php">{l s='customer support' mod='ebs'}</a>.
		<br /><br />If you would like to view your order history please <a href="index.php?controller=history" title="{l s='Orders History' mod='ebs'}">click here!</a>
	</p>*}
{else}
	<div class="payment-response">
		<img src="{$img_dir}perks/payment-response/failure.gif" alt="payment-success" class="payment-response-thumb" />
		<h2>{l s='Sorry, your order has been failed!'}</h2>
		<p>{$responseMsg}</p>
	</div>
	{*<p class="error">
		{$responseMsg}
		<br /><br />You can contact our customer support at 1800-121-0405 or <a href="{$base_dir}contact-form.php">{l s='Click Here' mod='ebs'}</a>.
		<br /><br />If you would like to view your order history please <a href="index.php?controller=history" title="{l s='History of Orders' mod='ebs'}">click here!</a>
	<p></p>*}
{/if}
