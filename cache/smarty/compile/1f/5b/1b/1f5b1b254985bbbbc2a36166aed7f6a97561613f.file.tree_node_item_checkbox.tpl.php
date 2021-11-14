<?php /* Smarty version Smarty-3.1.19, created on 2020-05-30 12:30:35
         compiled from "C:\wamp64\www\kobsterEshop\kobster_admin\themes\default\template\helpers\tree\tree_node_item_checkbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:240615ed2049387abd6-98775063%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f5b1b254985bbbbc2a36166aed7f6a97561613f' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\kobster_admin\\themes\\default\\template\\helpers\\tree\\tree_node_item_checkbox.tpl',
      1 => 1515162968,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '240615ed2049387abd6-98775063',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'node' => 0,
    'input_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ed20493a42236_97997380',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ed20493a42236_97997380')) {function content_5ed20493a42236_97997380($_smarty_tpl) {?>
<li class="tree-item<?php if (isset($_smarty_tpl->tpl_vars['node']->value['active'])&&!$_smarty_tpl->tpl_vars['node']->value['active']) {?> tree-item-disable<?php }?>">
	<span class="tree-item-name<?php if (isset($_smarty_tpl->tpl_vars['node']->value['active'])&&$_smarty_tpl->tpl_vars['node']->value['active']==true) {?> tree-item-name-disable<?php }?>">
		<input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['input_name']->value;?>
[]" value="<?php echo $_smarty_tpl->tpl_vars['node']->value['id_category'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['node']->value['active'])&&!$_smarty_tpl->tpl_vars['node']->value['active']) {?> disabled="disabled"<?php }?> />
		<i class="tree-dot"></i>
		<label class="tree-toggler"><?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
</label>
	</span>
</li><?php }} ?>
