<?php /* Smarty version Smarty-3.1.19, created on 2019-11-14 11:47:55
         compiled from "C:\wamp64\www\kobsterEshop\pdf\\invoice.total-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:291435dccf1933e8b19-08642795%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3cd713865e087794a29a1d0369f8698cfe5fcb04' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\pdf\\\\invoice.total-tab.tpl',
      1 => 1554795440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '291435dccf1933e8b19-08642795',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
    'footer' => 0,
    'total' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5dccf1936034c4_89669474',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dccf1936034c4_89669474')) {function content_5dccf1936034c4_89669474($_smarty_tpl) {?>

<table id="total-tab" width="100%">

	<tr>
		<td class="grey" width="50%">
			<?php echo smartyTranslate(array('s'=>'Total Products:','pdf'=>'true'),$_smarty_tpl);?>

		</td>
		<td class="white" width="50%">
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['products_before_discounts_tax_excl']),$_smarty_tpl);?>

		</td>
	</tr>


	<?php if ($_smarty_tpl->tpl_vars['footer']->value['wrapping_tax_excl']>0) {?>
		<tr>
			<td class="grey">
				<?php echo smartyTranslate(array('s'=>'Wrapping Cost:','pdf'=>'true'),$_smarty_tpl);?>

			</td>
			<td class="white"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['wrapping_tax_excl']),$_smarty_tpl);?>
</td>
		</tr>
	<?php }?>

<!-- Ref #685 -->
<!-- 	<tr class="">
		<td class="grey">
			<?php echo smartyTranslate(array('s'=>'Total (Tax excl.):','pdf'=>'true'),$_smarty_tpl);?>

		</td>
		<td class="white">
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_paid_tax_excl']),$_smarty_tpl);?>

		</td>
	</tr> -->
	<?php if ($_smarty_tpl->tpl_vars['footer']->value['sez']==1||$_smarty_tpl->tpl_vars['footer']->value['isez']==1) {?>
		<tr class="">
			<td class="grey">
				<?php echo smartyTranslate(array('s'=>'Total IGST:','pdf'=>'true'),$_smarty_tpl);?>

			</td>
			<td class="white">
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_taxes']),$_smarty_tpl);?>

			</td>
		</tr>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['footer']->value['sez']!=1&&$_smarty_tpl->tpl_vars['footer']->value['isez']!=1) {?>
		<?php if ($_smarty_tpl->tpl_vars['footer']->value['gst']==0) {?>
			<?php if ($_smarty_tpl->tpl_vars['footer']->value['total_taxes']>0) {?>
			<tr class="">
				<td class="grey">
					<?php echo smartyTranslate(array('s'=>'Total Tax:','pdf'=>'true'),$_smarty_tpl);?>

				</td>
				<td class="white">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_taxes']),$_smarty_tpl);?>

				</td>
			</tr>
			<?php }?>
		<?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['footer']->value['igst']>0) {?>
			<tr class="">
				<td class="grey">
					<?php echo smartyTranslate(array('s'=>'Total IGST:','pdf'=>'true'),$_smarty_tpl);?>

				</td>
				<td class="white">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_taxes']),$_smarty_tpl);?>

				</td>
			</tr>
			<?php } else { ?>
			<tr class="">
				<td class="grey">
					<?php echo smartyTranslate(array('s'=>'Total CGST:','pdf'=>'true'),$_smarty_tpl);?>

				</td>
				<td class="white">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['cgst']),$_smarty_tpl);?>

				</td>
			</tr>
			<tr class="">
				<td class="grey">
					<?php echo smartyTranslate(array('s'=>'Total SGST:','pdf'=>'true'),$_smarty_tpl);?>

				</td>
				<td class="white">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['sgst']),$_smarty_tpl);?>

				</td>
			</tr>
			<?php }?>
		<?php }?>
	<?php }?>

	<?php if (!$_smarty_tpl->tpl_vars['order']->value->isVirtual()) {?>
	<tr>
		<td class="grey" width="50%">
			<?php echo smartyTranslate(array('s'=>'Shipping Cost:','pdf'=>'true'),$_smarty_tpl);?>

		</td>
		<td class="white" width="50%">
			<?php if ($_smarty_tpl->tpl_vars['footer']->value['shipping_tax_excl']>0) {?>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['shipping_tax_excl']),$_smarty_tpl);?>

			<?php } else { ?>
				<?php echo smartyTranslate(array('s'=>'Free Shipping','pdf'=>'true'),$_smarty_tpl);?>

			<?php }?>
		</td>
	</tr>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['footer']->value['product_discounts_tax_excl']>0) {?>

		<tr>
			<td class="grey" width="50%">
				<?php echo smartyTranslate(array('s'=>'Total Discounts:','pdf'=>'true'),$_smarty_tpl);?>

			</td>
			<td class="white" width="50%">
				- <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['product_discounts_tax_incl']),$_smarty_tpl);?>

			</td>
		</tr>

	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['footer']->value['product_discounts_tax_excl']>0) {?>
		<tr class="">
			<td class="grey">
				<?php echo smartyTranslate(array('s'=>'Total:','pdf'=>'true'),$_smarty_tpl);?>

			</td>
			<td class="white">
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['footer']->value['total_paid_tax_incl']),$_smarty_tpl);?>

			</td>
		</tr>
	<?php } else { ?>
		<?php $_smarty_tpl->tpl_vars['total'] = new Smarty_variable($_smarty_tpl->tpl_vars['footer']->value['total_paid_tax_incl'], null, 0);?>
		<tr class="">
			<td class="grey">
				<?php echo smartyTranslate(array('s'=>'Total:','pdf'=>'true'),$_smarty_tpl);?>

			</td>
			<td class="white">
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl);?>

			</td>
		</tr>
	<?php }?>
	
</table>
<?php }} ?>
