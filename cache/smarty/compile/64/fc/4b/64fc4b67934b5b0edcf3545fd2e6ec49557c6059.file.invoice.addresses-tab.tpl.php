<?php /* Smarty version Smarty-3.1.19, created on 2019-11-14 11:47:54
         compiled from "C:\wamp64\www\kobsterEshop\pdf\\invoice.addresses-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:166355dccf1925d60e5-03602150%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '64fc4b67934b5b0edcf3545fd2e6ec49557c6059' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\pdf\\\\invoice.addresses-tab.tpl',
      1 => 1561803466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '166355dccf1925d60e5-03602150',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_id' => 0,
    'shipping_date' => 0,
    'order' => 0,
    'footer' => 0,
    'tin' => 0,
    'gst' => 0,
    'dr' => 0,
    'lut_number' => 0,
    'supplier_address' => 0,
    'delivery_address' => 0,
    'invoice_address' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5dccf19269d940_27320050',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dccf19269d940_27320050')) {function content_5dccf19269d940_27320050($_smarty_tpl) {?>
<table width="100%" id="addresses-tab"  style="margin-bottom: 4px;">
	<tr style="line-height:4px;">
	<!--
		<td style="width: 33%;">
			<!-- CUSTOMER INFORMATIONS -->
			<!--
			<span class="bold" style="line-height:1px;"><?php echo smartyTranslate(array('s'=>'Order Summary','pdf'=>'true'),$_smarty_tpl);?>
</span><br />
			<br />
			<?php echo smartyTranslate(array('s'=>'ORDER:','pdf'=>'true'),$_smarty_tpl);?>

			#<?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
<br />
			
			<?php echo smartyTranslate(array('s'=>'SHIPPING DATE:','pdf'=>'true'),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['shipping_date']->value,'full'=>0),$_smarty_tpl);?>
<br />

			<?php echo smartyTranslate(array('s'=>'PAYMENT:','pdf'=>'true'),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->tpl_vars['order']->value->payment;?>
<br />
			
			<?php echo smartyTranslate(array('s'=>'PO:','pdf'=>'true'),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->tpl_vars['order']->value->po_number;?>
<br />

			<?php if ($_smarty_tpl->tpl_vars['footer']->value['gst']!=1) {?>
				<?php echo smartyTranslate(array('s'=>'TIN:','pdf'=>'true'),$_smarty_tpl);?>

				<?php echo $_smarty_tpl->tpl_vars['tin']->value;?>
<br />
			<?php } else { ?>
				<?php echo smartyTranslate(array('s'=>'GSTIN:','pdf'=>'true'),$_smarty_tpl);?>

				<?php echo $_smarty_tpl->tpl_vars['gst']->value;?>
<br />
			<?php }?>

			<?php echo smartyTranslate(array('s'=>'PAN :','pdf'=>'true'),$_smarty_tpl);?>

			AAECK8223C<br />
			
			<?php echo smartyTranslate(array('s'=>'DR:','pdf'=>'true'),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->tpl_vars['dr']->value;?>
<br />

			<?php echo smartyTranslate(array('s'=>'LUT / BOND:','pdf'=>'true'),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->tpl_vars['lut_number']->value;?>
<br />
			
			<br />
			<!-- / CUSTOMER INFORMATIONS -->
			<!--
		</td>
		-->
		<td width="33%">
			<span class="bold"><?php echo smartyTranslate(array('s'=>'Ship From:','pdf'=>'true'),$_smarty_tpl);?>
</span><br>
			<?php echo $_smarty_tpl->tpl_vars['supplier_address']->value;?>

		</td>
		<td width="33%">
			<?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?>
				<span class="bold"><?php echo smartyTranslate(array('s'=>'Ship To:','pdf'=>'true'),$_smarty_tpl);?>
</span><br>
				<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

			<?php }?>
		</td>
		<td width="33%"><span class="bold"><?php echo smartyTranslate(array('s'=>'Bill To:','pdf'=>'true'),$_smarty_tpl);?>
</span><br>
			<?php echo $_smarty_tpl->tpl_vars['invoice_address']->value;?>

		</td>
	</tr>
</table>
<?php }} ?>
