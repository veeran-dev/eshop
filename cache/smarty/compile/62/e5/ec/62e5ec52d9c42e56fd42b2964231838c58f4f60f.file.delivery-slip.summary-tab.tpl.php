<?php /* Smarty version Smarty-3.1.19, created on 2019-12-03 22:37:46
         compiled from "C:\wamp64\www\kobsterEshop\pdf\\delivery-slip.summary-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:277705de69662c358b0-17429869%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62e5ec52d9c42e56fd42b2964231838c58f4f60f' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\pdf\\\\delivery-slip.summary-tab.tpl',
      1 => 1573654499,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '277705de69662c358b0-17429869',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5de69662dba635_42389171',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5de69662dba635_42389171')) {function content_5de69662dba635_42389171($_smarty_tpl) {?>
<table id="summary-tab" width="100%">
	<tr>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Order','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'PO Number','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Order Date','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<?php if (isset($_smarty_tpl->tpl_vars['order']->value->payment)) {?>
			<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Payment Mode','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<?php }?>
	</tr>
	<tr>
		<td class="center small white">#<?php echo $_smarty_tpl->tpl_vars['order']->value->id;?>
</td>
		<td class="center small white"><?php if (isset($_smarty_tpl->tpl_vars['order']->value->po_number)&&$_smarty_tpl->tpl_vars['order']->value->po_number) {?>#<?php echo $_smarty_tpl->tpl_vars['order']->value->po_number;?>
<?php } else { ?>--<?php }?></td>
		<td class="center small white"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['order']->value->date_add,'full'=>0),$_smarty_tpl);?>
</td>
		<?php if (isset($_smarty_tpl->tpl_vars['order']->value->payment)) {?>
			<td class="center small white"><?php echo $_smarty_tpl->tpl_vars['order']->value->payment;?>
</td>
		<?php }?>
	</tr>
</table>

<?php }} ?>
