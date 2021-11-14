<?php /* Smarty version Smarty-3.1.19, created on 2018-01-06 14:40:50
         compiled from "C:\wamp\www\kobsterEshop\themes\default-bootstrap\shop.tpl" */ ?>
<?php /*%%SmartyHeaderCode:109245a50929a565584-29939610%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fbf7fc8e27276c00c9ee8c99e7385cd12ba6a4a4' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\themes\\default-bootstrap\\shop.tpl',
      1 => 1490263758,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109245a50929a565584-29939610',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_SHOP' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a50929a677c86_55292944',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a50929a677c86_55292944')) {function content_5a50929a677c86_55292944($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('displayNav', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayShop'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
					<?php echo Smarty::$_smarty_vars['capture']['displayShop'];?>

<?php echo $_smarty_tpl->tpl_vars['HOOK_SHOP']->value;?>
<?php }} ?>
