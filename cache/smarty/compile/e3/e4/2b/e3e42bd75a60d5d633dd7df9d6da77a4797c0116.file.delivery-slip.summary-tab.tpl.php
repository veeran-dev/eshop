<?php /* Smarty version Smarty-3.1.19, created on 2018-02-08 16:51:16
         compiled from "C:\wamp\www\kobsterEshop\pdf\\delivery-slip.summary-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:157545a7c32acd8e762-76211613%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3e42bd75a60d5d633dd7df9d6da77a4797c0116' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\pdf\\\\delivery-slip.summary-tab.tpl',
      1 => 1478085942,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157545a7c32acd8e762-76211613',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7c32ace0dc89_92252197',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7c32ace0dc89_92252197')) {function content_5a7c32ace0dc89_92252197($_smarty_tpl) {?>
<table id="summary-tab" width="100%">
	<tr>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Order','pdf'=>'true'),$_smarty_tpl);?>
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
		<td class="center small white"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['order']->value->date_add,'full'=>0),$_smarty_tpl);?>
</td>
		<?php if (isset($_smarty_tpl->tpl_vars['order']->value->payment)) {?>
			<td class="center small white"><?php echo $_smarty_tpl->tpl_vars['order']->value->payment;?>
</td>
		<?php }?>
	</tr>
</table>

<?php }} ?>
