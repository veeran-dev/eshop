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
*  @author    PrestaShop SA <contact@prestashop.com> Quadra Informatique <modules@quadra-informatique.fr>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<style type="text/css">
    .soBackward_compat_tab {literal}{ text-align: center; }{/literal}
    .soBackward_compat_tab a {literal}{ margin: 0px; }{/literal}
</style>


<iframe id="soFr" xml:lang="fr" width="100%" height="800" style="border:none;display:none;"src=""></iframe>
<input id="hidden_cgv" type="hidden" value="{l s='Please accept the terms of service before the next step.' mod='socolissimo'}" />
<script type="text/javascript">
	var opc = false;
</script>

{if isset($already_select_delivery) && $already_select_delivery}
    <script type="text/javascript">
		var already_select_delivery = true;
    </script>
{else}
    <script type="text/javascript">
		var already_select_delivery = false;
    </script>
{/if}
<script type="text/javascript">
	var link_socolissimo = "{$link_socolissimo|escape:'UTF-8'}";
	var soInputs = new Object();
	var soBwdCompat = "{$SOBWD_C|escape:'htmlall'}";
	var soCarrierId = "{$id_carrier|escape:'htmlall'}";
	var soToken = "{$token|escape:'htmlall'}";
	var initialCost_label = "{$initialCost_label|escape:'htmlall'}";
	var initialCost = "{$initialCost|escape:'htmlall'}";
	var taxMention = "{$taxMention|escape:'htmlall'}";
	var baseDir = '{$content_dir|escape:'htmlall'}';
	var rewriteActive = '{$rewrite_active|escape:'htmlall'}';

	{foreach from=$inputs item=input key=name name=myLoop}
	soInputs.{$name} = "{$input|strip_tags|addslashes}";
    {/foreach}

    {literal}

		$(document).ready(function ()
		{
			$('.delivery_option').each(function ( ) {
				if ($(this).children('.delivery_option_radio').val() == '{/literal}{$id_carrier_seller}{literal},') {
					$(this).remove();
				}
			});
			$('#id_carrier{/literal}{$id_carrier_seller}{literal}').parent().parent().remove();

			if (!soBwdCompat) {
				$($('#carrierTable input#id_carrier' + soCarrierId).parent().parent()).find('.carrier_price .price').html(initialCost_label + '<br/>' + initialCost);
				$($('#carrierTable input#id_carrier' + soCarrierId).parent().parent()).find('.carrier_price').css('white-space', 'nowrap');
			} else {
				$('input.delivery_option_radio').each(function () {
					if ($(this).val() == soCarrierId + ',') {
						$(this).next().children().children().find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);
						// 1.6 themes
						if ($(this).next().children('div.delivery_option_price').length == 0)
							$(this).parents('tr').children('td.delivery_option_price').find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);

					}
				});
			}

			$('[name=processCarrier]').click(function () {
				if (($('#id_carrier' + soCarrierId).is(':checked')) || ($('.delivery_option_radio:checked').val() == soCarrierId + ','))
				{
					if (acceptCGV(($('#hidden_cgv').val()))) {

						if (soBwdCompat) { // 1.5 zone
							$('div.delivery_options_address h3').css('display', 'none');
							$('div.delivery_options').css('display', 'none');
						} else { // 1.4 zone
							$('#carrierTable td').css('display', 'none');
							$('#carrierTable th').css('display', 'none');
						}

						// common zone
						$('h3.condition_title').css('display', 'none');
						$('p.checkbox').css('display', 'none');
						$('h3.carrier_title').css('display', 'none');
						$('h3.gift_title').css('display', 'none');
						$('#gift_div').css('display', 'none');
						$('p.cart_navigation').css('display', 'none');
						$('#soFr').css('display', 'block');
						if (soBwdCompat)
								$('#soFr').attr('src', link_socolissimo + serialiseInput(soInputs));
						else
							$('#soFr').attr('src', baseDir + 'modules/socolissimo/redirect.php' + serialiseInput(soInputs));
					}
					return false;
				}
				return true;
			});
		});

		function serialiseInput(inputs) {

			if (soBwdCompat && !rewriteActive)
				var str = '&first_call=1&';
			else
				var str = '?first_call=1&';
			for (var cle in inputs)
				str += cle + '=' + inputs[cle] + '&';
			return (str + 'gift=' + $('#gift').attr('checked') + '&gift_message=' + $('#gift_message').attr('value'));
		}

    {/literal}
</script>
