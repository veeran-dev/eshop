<?php /* Smarty version Smarty-3.1.19, created on 2018-01-24 16:12:29
         compiled from "C:\wamp\www\kobsterEshop\pdf\\invoice.summary-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:180175a686315971f95-40327715%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6f3c6fb6ca7eaecfce32499124d7bc5df3ceb7a' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\pdf\\\\invoice.summary-tab.tpl',
      1 => 1516790544,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '180175a686315971f95-40327715',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'addresses' => 0,
    'title' => 0,
    'order' => 0,
    'order_id' => 0,
    'dr' => 0,
    'state_of_supply' => 0,
    'footer' => 0,
    'lut_number' => 0,
    'lut_expiry' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a686315a5ef73_73205977',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a686315a5ef73_73205977')) {function content_5a686315a5ef73_73205977($_smarty_tpl) {?>

<table id="summary-tab" width="100%">
<!--
	<tr style="line-height:6px;">
	
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Invoice Number','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Invoice Date','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Order Reference','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Order date','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<?php if ($_smarty_tpl->tpl_vars['addresses']->value['invoice']->vat_number) {?>
			<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'GST Number','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<?php }?>
	</tr>
	<tr style="line-height:6px;">
		<td class="center small white"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true);?>
</td>
		<td class="center small white"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['order']->value->invoice_date,'full'=>0),$_smarty_tpl);?>
</td>
		<td class="center small white"><?php echo $_smarty_tpl->tpl_vars['order']->value->getUniqReference();?>
</td>
		<td class="center small white"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['order']->value->date_add,'full'=>0),$_smarty_tpl);?>
</td>
		<?php if ($_smarty_tpl->tpl_vars['addresses']->value['invoice']->vat_number) {?>
			<td class="center small white">
				<?php echo $_smarty_tpl->tpl_vars['addresses']->value['invoice']->vat_number;?>

			</td>
		<?php }?>
	</tr>
-->
	<tr style="line-height:6px; padding: 8px;">
		<td class="bold" cellspacing="10" style="font-weight: bold;">Order Number:</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['order_id']->value;?>
</td>
		<td class="bold" cellspacing="10">DR Number:</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['dr']->value;?>
</td>
		<td class="bold" cellspacing="10">PO Number:</td><td class="left"><?php if ($_smarty_tpl->tpl_vars['order']->value->po_number!='') {?><?php echo $_smarty_tpl->tpl_vars['order']->value->po_number;?>
<?php } else { ?>--<?php }?></td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">Invoice Number:</td><td class="left"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true);?>
</td>
		<td class="bold" cellspacing="10">Invoice Date:</td><td class="left"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['order']->value->invoice_date,'full'=>0),$_smarty_tpl);?>
</td>
		<td class="bold" cellspacing="10">Payment Mode:</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['order']->value->payment;?>
</td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">Place of supply:</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['state_of_supply']->value;?>
</td>
		<td class="bold" cellspacing="10">E Way Bill no:</td><td class="left">--</td>
		<td class="bold" cellspacing="10">Payment Terms</td><td class="left"><?php echo $_smarty_tpl->tpl_vars['order']->value->credit_days;?>
 days</td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">Sales to SEZ:</td><td class="left" colspan="2"><?php if ($_smarty_tpl->tpl_vars['footer']->value['sez']==1||$_smarty_tpl->tpl_vars['footer']->value['isez']==1) {?>Yes<?php } else { ?>No<?php }?></td>
		<td class="bold" cellspacing="10">Reverse Charge:</td><td class="left" colspan="2">No</td>
	</tr>
	<tr style="line-height:6px;">
		<td class="bold" cellspacing="10">LUT Number:</td><td class="left" colspan="3"><?php echo $_smarty_tpl->tpl_vars['lut_number']->value;?>
</td>
		<td class="bold" cellspacing="10">LUT Expiry:</td><td class="left" colspan="2"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['lut_expiry']->value,'full'=>0),$_smarty_tpl);?>
</td>
	</tr>
</table>
<br><?php }} ?>
