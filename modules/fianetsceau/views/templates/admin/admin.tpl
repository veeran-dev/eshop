{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{literal}
<script>
function ShowHideSceauLog() {
	
	var div = document.getElementById('sceau_log');
	if(div.style.display == "none") { 
		div.style.display = "block"; 
	} else { 
		div.style.display = "none";
	}
}

function loadSubCategories(elem_id){
	
	var category_id = $('#fianetsceau_'+elem_id+'_category option:selected').val();
	var token = $("#token_fianetsceau").attr('value');
	var id_shop = $("#id_shop_fianetsceau").attr('value');
	
	$.ajax({
		url: '../modules/fianetsceau/subcategory.php', 
		type:'POST', 
		data: "category_id="+category_id+"&elem_id="+elem_id+"&token="+token+"&id_shop="+id_shop,
		cache:false, 
		success:function(reponse){
			
			$("#subcategory_"+elem_id).empty();
			$("#subcategory_"+elem_id).show();
			$("#subcategory_"+elem_id).append(reponse);
		}
	})
}	
</script>
{/literal}

{$head_message|strval}
<fieldset>
	<legend><img src="{$image_path|escape:'htmlall'}" />FIA-NET - Sceau de Confiance</legend>

	<b>Le Sceau de Confiance FIA-NET, leader de la confiance sur le web, influence la d&eacute;cision de r&eacute;achat de 83 % des internautes.</b>

	<br /><br/>
	Le Sceau de Confiance FIA-NET, le plus connu en France, fait la preuve de vos performances. Il restitue les avis de vos clients gr&acirc;ce &agrave; l'envoi <b>de deux questionnaires de satisfaction</b> apr&egrave;s l'achat et apr&egrave;s la livraison.
	<br /><br />
	<b>L'extranet, un outil d'analyse de performance unique</b>, exploite les r&eacute;ponses de vos clients &agrave; ces questionnaires. Une aide inestimable qui vous permet de mieux connaitre vos clients et de piloter votre politique marketing et communication.
	<br /><br />

	<p>{l s='To sign in, check out:' mod='fianetsceau'}<u><a href="https://www.fia-net.com/marchands/devispartenaire.php?p=185" target="_blank">{l s='Fia-net Website' mod='fianetsceau'}</a></u></p>
</fieldset>
<br />

<form action="" method="post">
	<fieldset>
		<legend><img src="{$logo_account_path|escape:'htmlall'}" />{l s='Account settings' mod='fianetsceau'}</legend>
		<label>{l s='Login' mod='fianetsceau'}</label>
		<div class="margin-form">
			<input type="text" name="fianetsceau_login" value="{$fianetsceau_login|escape:'htmlall'}"/>
		</div>
		<label>{l s='Password' mod='fianetsceau'}</label>
		<div class="margin-form">
			<input type="text" name="fianetsceau_password" value="{$fianetsceau_password|escape:'htmlall'}"/>
		</div>
		<label>{l s='Site ID' mod='fianetsceau'}</label>
		<div class="margin-form">
			<input type="text" name="fianetsceau_siteid" value="{$fianetsceau_siteid|intval}"/>
		</div>
		<label>{l s='Authkey' mod='fianetsceau'}</label>
		<div class="margin-form">
			<input type="text" name="fianetsceau_authkey" value="{$fianetsceau_authkey|escape:'htmlall'}"/>
		</div>
		<label>{l s='Production mode' mod='fianetsceau'}</label>
		<div class="margin-form">
			<select name="fianetsceau_status">
				{foreach from=$fianetsceau_statuses item=fianetsceau_status_name name=fianetsceau_status}
					<option value="{$fianetsceau_status_name|escape:'htmlall'}" {if $fianetsceau_status_name eq $fianetsceau_status}Selected{/if}>{l s=$fianetsceau_status_name|escape:'htmlall' mod='fianetsceau'}</option>
				{/foreach}
			</select>
		</div>
		<label>{l s='FIA-NET status on order detail' mod='fianetsceau'}</label>
		<div class="margin-form">
			<input name="fianetsceau_showstatus" type="checkbox" value="1" {if $fianetsceaushow_status eq '1'}Checked{/if} /> 
		</div>
	</fieldset>

	<br />

	<fieldset>
		<legend><img src="{$logo_categories_path|escape:'htmlall'}"/>{l s='Category settings' mod='fianetsceau'}</legend>
		<label>{l s='Default Product Type' mod='fianetsceau'}</label>
		<div class="margin-form">
			<select id="fianetsceau_0_category" name="fianetsceau_0_category" onChange="loadSubCategories(0);">
				<option value="0">-- {l s='Choose' mod='fianetsceau'} --</option>
				{foreach from=$fianetsceau_categories item=category_name key=id_category name=categories_name}
					<option value="{$id_category|intval}" {if $fianetsceau_default_category eq $id_category}Selected{/if}>{$category_name|strval}</option>
				{/foreach}
			</select>
			<span id="subcategory_0">
				<select id="fianetsceau_0_subcategory" name="fianetsceau_0_subcategory">
					<option value="0">-- {l s='Choose' mod='fianetsceau'} --</option>
					{foreach from=$fianetsceau_subcategories item=subcategory_name key=subcategory_id name=subcategories_name}
						{if $fianetsceau_default_category eq $subcategory_name.parent_id}
							<option value="{$subcategory_id|intval}" {if $fianetsceau_default_subcategory eq $subcategory_id}Selected{/if}>{$subcategory_name.label|strval}</option>
						{/if}
					{/foreach}
				</select>
			</span>
		</div>

		<div class="margin-form">
			<table class="table">
				<thead>
					<tr><th>{l s='Shop category' mod='fianetsceau'}</th><th colspan="2">{l s='FIA-NET category' mod='fianetsceau'}</th></tr>
				</thead>
				<tbody>
					{foreach from=$shop_categories key=id item=shop_category name=shop_categories}
						<tr>
							<td>{$shop_category.name|escape:'htmlall'}</td>
							<td>
								<select id="fianetsceau_{$id|intval}_category" name="fianetsceau_{$id|intval}_category" onChange="loadSubCategories({$id|intval});">
									<option value="0">-- {l s='Choose' mod='fianetsceau'} --</option>
									{foreach from=$fianetsceau_categories item=category_name key=category_id name=categories_name}
										<option value="{$category_id|intval}" {if $shop_category.parent_id eq $category_id}Selected{/if}>{$category_name|strval}</option>
									{/foreach}
								</select>
							</td>
							<td>
								<span id="subcategory_{$id|intval}">
									<select id="fianetsceau_{$id}_subcategory" name="fianetsceau_{$id|intval}_subcategory">
										<option value="0">-- {l s='Choose' mod='fianetsceau'} --</option>
										{foreach from=$fianetsceau_subcategories item=subcategory_name key=subcategory_id name=subcategories_name}
											{if $shop_category.parent_id eq $subcategory_name.parent_id}
												<option value="{$subcategory_id|intval}" {if $shop_category.fianetsceau_type eq $subcategory_id}Selected{/if}>{$subcategory_name.label|strval}</option>
											{/if}
										{/foreach}
									</select>
								</span>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</fieldset>

	<br />

	<fieldset>
		<legend><img src="{$logo_payments_path|escape:'htmlall'}" />{l s='Payment modules settings' mod='fianetsceau'}</legend>
		<div class="margin-form">
			<table cellspacing="0" cellpadding="0" class="table">
				<thead>
					<tr>
						<th>{l s='Payment module' mod='fianetsceau'}</th>
						<th>{l s='Payment Type' mod='fianetsceau'}</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$payment_modules key=id_payment_module item=payment_module name=payment_modules}
						<tr>
							<td>{$payment_module.name|escape:'htmlall'}</td>
							<td>
								<select name="fianetsceau_{$id_payment_module|intval}_payment_type">
									{foreach from=$fianetsceau_payment_types key=id_fianetsceau_payment_type item=fianetsceau_payment_type name=fianetsceau_payment_types}
										<option value="{$id_fianetsceau_payment_type|escape:'htmlall'}" {if $payment_module.fianetsceau_type eq $id_fianetsceau_payment_type}Selected{/if}>{$fianetsceau_payment_type|escape:'htmlall'}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</fieldset>

	<br />

	<fieldset>
		<legend><img src="{$logo_account_path|escape:'htmlall'}" />{l s='Logo settings' mod='fianetsceau'}</legend>
		<label>{l s='Logo position' mod='fianetsceau'}</label>
		<div class="margin-form">
			<select name="fianetsceau_logo_position">
				{foreach from=$fianetsceau_logo_positions key=fianetsceau_logo_position_key item=fianetsceau_logo_position_name name=fianetsceau_logo_positions}
					<option value="{$fianetsceau_logo_position_key|escape:'htmlall'}" {if $fianetsceau_logo_position_key eq $fianetsceau_logo_position}Selected{/if}>{l s=$fianetsceau_logo_position_name|strval mod='fianetsceau'}</option>
				{/foreach}
			</select><br /><br />

			<table cellspacing="0" cellpadding="0" class="table">
				<tr>
					<th colspan="2">{l s='Logo size' mod='fianetsceau'}</th>
				</tr>
				{foreach from=$fianetsceau_logo_sizes key=fianetsceau_logo_size item=fianetsceau_logo_img}
					<tr>
						<td><input type="radio" name=fianetsceau_logo_sizes value="{$fianetsceau_logo_size|escape:'htmlall'}" {if $fianetsceau_logo_size eq $fianetsceau_logo}Checked{/if}></td><td><img src="{$fianetsceau_logo_img|escape:'htmlall'}" /></td>
						{/foreach}
				</tr>
			</table>
		</div>
	</fieldset>

	<br/>

	<fieldset>
		<legend><img src="{$logo_account_path|escape:'htmlall'}" />{l s='Widget settings' mod='fianetsceau'}</legend>
		<label>{l s='Widget position' mod='fianetsceau'}</label>
		<div class="margin-form">
			<select name="fianetsceau_widget_position">
				{$i = 1}
				{foreach from=$fianetsceau_widget_positions key=fianetsceau_widget_position_key item=fianetsceau_widget_position_name name=fianetsceau_widget_positions}
				{if $i % 2 eq 1}{/if}
				{$i|intval % 2}
				<option value="{$fianetsceau_widget_position_key|escape:'htmlall'}" {if $fianetsceau_widget_position_key eq $fianetsceau_widget_position}Selected{/if}>{l s=$fianetsceau_widget_position_name|strval mod='fianetsceau'}</option>
				{$i = $i + 1}
			{/foreach}
			</table>
		</select><br /><br />

		<table cellspacing="0" cellpadding="0" class="table">
			<tr>
				<th colspan="4">{l s='Widget type' mod='fianetsceau'}</th>
			</tr>
			<tr>
				<td colspan="2">{l s='White background' mod='fianetsceau'}</td>
				<td colspan="2">{l s='Transparent background' mod='fianetsceau'}</td>
			</tr>
			{$i = 1}
			{foreach from=$fianetsceau_widget_numbers item=fianetsceau_widget_number}
			{if $i mod 2 eq 1}<tr>{/if}
				<td><input type="radio" name=fianetsceau_widget_number value="{$fianetsceau_widget_number|escape:'htmlall'}" {if $fianetsceau_widget_number eq $widget_number}Checked{/if} /></td><td><p><img src="{$path_prefix|escape:'htmlall'}/{$fianetsceau_widget_number|escape:'htmlall'}.png" /></p></td>
			{if $i mod 2 eq 0}</tr>{/if}
			{$i = $i + 1}
		{/foreach}
</table>
</div>
</fieldset>
<br/>
<center><input type="submit" name="submitSettings" value="{l s='Save' mod='fianetsceau'}" class="button" /></center>
<input id="token_fianetsceau" name="token_fianetsceau" type="hidden" value="{$token|escape:'htmlall'}" />
<input id="id_shop_fianetsceau" name="id_shop_fianetsceau" type="hidden" value="{$id_shop|intval}" />
</form>
<br/>
<center><input type="button" name="submitLog" onclick="ShowHideSceauLog();" value="{l s='Show/Hide FIA-NET Sceau log file' mod='fianetsceau'}" class="button" /></center>
<br/>
<center>
	<fieldset id="sceau_log" style="display:none;">
		<textarea cols="150" rows="10" readonly="readonly">{$log_content|strval}</textarea>
		<br/>
	</fieldset>
</center>

