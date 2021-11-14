<?php /* Smarty version Smarty-3.1.19, created on 2019-11-14 11:47:53
         compiled from "C:\wamp64\www\kobsterEshop\pdf\\invoice.tax-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:176535dccf1918d2fd9-21349391%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0cd328b7215c74bb1ceb7cf297f1e7af0a64ec5' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\pdf\\\\invoice.tax-tab.tpl',
      1 => 1554795440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '176535dccf1918d2fd9-21349391',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tax_exempt' => 0,
    'tax_breakdowns' => 0,
    'display_tax_bases_in_breakdowns' => 0,
    'bd' => 0,
    'line' => 0,
    'label_printed' => 0,
    'label' => 0,
    'is_order_slip' => 0,
    'order' => 0,
    'footer' => 0,
    'has_line' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5dccf191d2f264_42717392',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dccf191d2f264_42717392')) {function content_5dccf191d2f264_42717392($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include 'C:\\wamp64\\www\\kobsterEshop\\tools\\smarty\\plugins\\function.math.php';
?>

<!--  TAX DETAILS -->
<?php if ($_smarty_tpl->tpl_vars['tax_exempt']->value) {?>

	<?php echo smartyTranslate(array('s'=>'Exempt of GST according to section 259B of the General Tax Code.','pdf'=>'true'),$_smarty_tpl);?>


<?php } elseif ((isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value)&&$_smarty_tpl->tpl_vars['tax_breakdowns']->value)) {?>
	
	<table id="tax-tab" width="100%">
	<!--
		<thead>
			<tr>
				<th class="header small"><?php echo smartyTranslate(array('s'=>'Tax Detail','pdf'=>'true'),$_smarty_tpl);?>
</th>
				<th class="header small"><?php echo smartyTranslate(array('s'=>'Tax Rate','pdf'=>'true'),$_smarty_tpl);?>
</th>
				<?php if ($_smarty_tpl->tpl_vars['display_tax_bases_in_breakdowns']->value) {?>
					<th class="header small"><?php echo smartyTranslate(array('s'=>'Base price','pdf'=>'true'),$_smarty_tpl);?>
</th>
				<?php }?>
				<th class="header-right small"><?php echo smartyTranslate(array('s'=>'Total Tax','pdf'=>'true'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
		<?php $_smarty_tpl->tpl_vars['has_line'] = new Smarty_variable(false, null, 0);?>

		<?php  $_smarty_tpl->tpl_vars['bd'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['bd']->_loop = false;
 $_smarty_tpl->tpl_vars['label'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tax_breakdowns']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['bd']->key => $_smarty_tpl->tpl_vars['bd']->value) {
$_smarty_tpl->tpl_vars['bd']->_loop = true;
 $_smarty_tpl->tpl_vars['label']->value = $_smarty_tpl->tpl_vars['bd']->key;
?>
			<?php $_smarty_tpl->tpl_vars['label_printed'] = new Smarty_variable(false, null, 0);?>

			<?php  $_smarty_tpl->tpl_vars['line'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['line']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['bd']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['line']->key => $_smarty_tpl->tpl_vars['line']->value) {
$_smarty_tpl->tpl_vars['line']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['line']->value['rate']==0) {?>
					<?php continue 1?>
				<?php }?>
				<?php $_smarty_tpl->tpl_vars['has_line'] = new Smarty_variable(true, null, 0);?>
				<tr>
					<td class="white">
						<?php if (!$_smarty_tpl->tpl_vars['label_printed']->value) {?>
							<?php if ($_smarty_tpl->tpl_vars['label']->value=='product_tax') {?>
								<?php echo smartyTranslate(array('s'=>'Products','pdf'=>'true'),$_smarty_tpl);?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value=='shipping_tax') {?>
								<?php echo smartyTranslate(array('s'=>'Shipping','pdf'=>'true'),$_smarty_tpl);?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value=='ecotax_tax') {?>
								<?php echo smartyTranslate(array('s'=>'Ecotax','pdf'=>'true'),$_smarty_tpl);?>

							<?php } elseif ($_smarty_tpl->tpl_vars['label']->value=='wrapping_tax') {?>
								<?php echo smartyTranslate(array('s'=>'Wrapping','pdf'=>'true'),$_smarty_tpl);?>

							<?php }?>
							<?php $_smarty_tpl->tpl_vars['label_printed'] = new Smarty_variable(true, null, 0);?>
						<?php }?>
					</td>

					<td class="center white">
						<?php echo $_smarty_tpl->tpl_vars['line']->value['rate'];?>
 %
					</td>

					<?php if ($_smarty_tpl->tpl_vars['display_tax_bases_in_breakdowns']->value) {?>
						<td class="right white">
							<?php if (isset($_smarty_tpl->tpl_vars['is_order_slip']->value)&&$_smarty_tpl->tpl_vars['is_order_slip']->value) {?>- <?php }?>
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['line']->value['total_tax_excl']),$_smarty_tpl);?>

						</td>
					<?php }?>

					<td class="right white">
						<?php if (isset($_smarty_tpl->tpl_vars['is_order_slip']->value)&&$_smarty_tpl->tpl_vars['is_order_slip']->value) {?>- <?php }?>
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['order']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['line']->value['total_amount']),$_smarty_tpl);?>

					</td>
				</tr>
			<?php } ?>
		<?php } ?>
	-->
		<?php if ($_smarty_tpl->tpl_vars['footer']->value['gst']==1) {?>
			<tr>
				<th class="header small">Tax</th>
				<th class="header small">5%</th>
				<th class="header small">12%</th>
				<th class="header small">18%</th>
				<th class="header small">28%</th>
			</tr>
			<?php if ($_smarty_tpl->tpl_vars['footer']->value['cgst']>0&&$_smarty_tpl->tpl_vars['footer']->value['sez']!=1&&$_smarty_tpl->tpl_vars['footer']->value['isez']!=1) {?>
			<tr>
				<td style="font-size: 8pt;" class="center white">SGST</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['5.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['5.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['12.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['12.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
				<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['18.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['18.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['28.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['28.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
			</tr>
			<tr>
				<td style="font-size: 8pt;" class="center white">CGST</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['5.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['5.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['12.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['12.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
				<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['18.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['18.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['28.000']['total_amount'])) {?>
						<?php echo smarty_function_math(array('equation'=>"x / y",'x'=>$_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['28.000']['total_amount'],'y'=>2,'format'=>"%.2f"),$_smarty_tpl);?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
			</tr>
			<?php } elseif ($_smarty_tpl->tpl_vars['footer']->value['igst']>0||$_smarty_tpl->tpl_vars['footer']->value['sez']==1||$_smarty_tpl->tpl_vars['footer']->value['isez']==1) {?>
			<tr>
				<td style="font-size: 8pt;" class="center white">IGST</td>
				<td style="font-size: 8pt;" class="center white">
				<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['5.000']['total_amount'])) {?>
						<?php echo $_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['5.000']['total_amount'];?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
					<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['12.000']['total_amount'])) {?>
						<?php echo $_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['12.000']['total_amount'];?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
					<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['18.000']['total_amount'])) {?>
						<?php echo $_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['18.000']['total_amount'];?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
				<td style="font-size: 8pt;" class="center white">
					<span>&#8377;</span>
					<?php if (isset($_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['28.000']['total_amount'])) {?>
						<?php echo $_smarty_tpl->tpl_vars['tax_breakdowns']->value['product_tax']['28.000']['total_amount'];?>

					<?php } else { ?>
						0.00
					<?php }?>
				</td>
			</tr>
			<?php }?>
		<?php }?>
		<?php if (!$_smarty_tpl->tpl_vars['has_line']->value) {?>
		<tr>
			<?php if ($_smarty_tpl->tpl_vars['footer']->value['sez']==1) {?>
			<?php } else { ?>
			<td class="white center" colspan="<?php if ($_smarty_tpl->tpl_vars['display_tax_bases_in_breakdowns']->value) {?>4<?php } else { ?>3<?php }?>">
				<?php echo smartyTranslate(array('s'=>'No taxes','pdf'=>'true'),$_smarty_tpl);?>

			</td>
			<?php }?>
		</tr>
		<?php }?>

		</tbody>
	</table>
	<?php if ($_smarty_tpl->tpl_vars['footer']->value['sez']==1||$_smarty_tpl->tpl_vars['footer']->value['isez']==1) {?>
	<table width="100%" height="">
		<?php if ($_smarty_tpl->tpl_vars['footer']->value['isez']==1) {?>
			<tr></tr>
			<tr>
				<td style="font-size: 8pt;text-align:left;">a) Supply meant for export on payment of IGST.</td>
			</tr>
			<tr>
				<td style="font-size: 8pt;text-align:left;">b) IGST will be paid and claimed by Kobster.</td>
			</tr>
		<?php } else { ?>
			<tr></tr>
			<tr>
				<td style="font-size: 8pt;text-align:left;">a)  Supply meant for export under letter of undertaking without payment of IGST.</td>
			</tr>
		<?php }?>
	</table>
	<?php }?>
	<?php } elseif ($_smarty_tpl->tpl_vars['footer']->value['sez']==1||$_smarty_tpl->tpl_vars['footer']->value['isez']==1) {?>
	<tr>
	<?php if ($_smarty_tpl->tpl_vars['footer']->value['isez']==1) {?>
		<tr></tr>
		<tr>
			<td style="font-size: 8pt;text-align:left;" class="white">a. Supply meant for export on payment of IGST.</td>
		</tr>
		<tr>
			<td style="font-size: 8pt;text-align:left;" class="white">b. IGST will be paid and claimed by Kobster.</td>
		</tr>
	<?php } else { ?>
		<tr></tr>
		<tr>
			<td style="font-size: 8pt;text-align:left;">a)  Supply meant for export under letter of undertaking without payment of IGST.</td>
		</tr>
	<?php }?>
	</tr>
<?php }?>
<br/>
<br/>
<tr style="font-size: 9pt;text-align:left;"><?php echo $_smarty_tpl->tpl_vars['footer']->value['total_in_words'];?>
</tr>
<!--  / TAX DETAILS -->
<?php }} ?>
