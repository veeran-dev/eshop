<?php /* Smarty version Smarty-3.1.19, created on 2018-02-09 15:08:34
         compiled from "C:\wamp\www\kobsterEshop\kobster_admin\themes\default\template\helpers\tree\tree_node_item_radio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:107325a7d6c1a0503d9-86304856%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06251d4a08103e044c9b56868874156a557d9e3a' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\kobster_admin\\themes\\default\\template\\helpers\\tree\\tree_node_item_radio.tpl',
      1 => 1478085952,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '107325a7d6c1a0503d9-86304856',
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
  'unifunc' => 'content_5a7d6c1a18a018_50863564',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7d6c1a18a018_50863564')) {function content_5a7d6c1a18a018_50863564($_smarty_tpl) {?>
<li class="tree-item<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled'])&&$_smarty_tpl->tpl_vars['node']->value['disabled']==true) {?> tree-item-disable<?php }?>">
	<span class="tree-item-name">
		<input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['input_name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['node']->value['id_category'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['node']->value['disabled'])&&$_smarty_tpl->tpl_vars['node']->value['disabled']==true) {?> disabled="disabled"<?php }?> />
		<i class="tree-dot"></i>
		<label class="tree-toggler"><?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
</label>
	</span>
</li><?php }} ?>
