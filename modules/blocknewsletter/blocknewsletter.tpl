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

<!-- Block Newsletter module-->

<div id="newsletter_block_left">
	<div id="newsletter_wrapper">
	<span id="text" style="color:#7e7d7d">{l s='Subscribe to our Newsletter for all the latest products, discount vouchers & best deals on Office Supplies:' mod='blocknewsletter'}</span>
	<div>
		<form action="{$link->getPageLink('index.php')}" method="post">
			<input style="padding-left:5px" type="text" name="email" size="18" value="{if isset($value) && $value}{$value}{else}{l s='your e-mail' mod='blocknewsletter'}{/if}" onfocus="javascript:if(this.value=='{l s='your e-mail' mod='blocknewsletter'}')this.value='';" onblur="javascript:if(this.value=='')this.value='{l s='your e-mail' mod='blocknewsletter'}';" />
				<select name="action">
					<option value="0"{if isset($action) && $action == 0} selected="selected"{/if}>{l s='Subscribe' mod='blocknewsletter'}</option>
					<option value="1"{if isset($action) && $action == 1} selected="selected"{/if}>{l s='Unsubscribe' mod='blocknewsletter'}</option>
				</select>
				<input type="submit" value="OK!" class="button_mini_subs" name="submitNewsletter" />
			
		</form>
		{if isset($msg) && $msg}
			<p class="{if $nw_error}warning_inline{else}success_inline{/if}">{$msg}</p>
			<script type="text/javascript">
				$(document).ready(function() {ldelim}
					$.jGrowl('{$msg}');
				{rdelim});
			</script>
		{/if}
	</div>
	</div>
</div>
<div class="footer_separator"></div>

<!-- /Block Newsletter module-->