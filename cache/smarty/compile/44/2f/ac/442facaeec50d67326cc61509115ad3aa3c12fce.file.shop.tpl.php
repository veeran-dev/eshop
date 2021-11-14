<?php /* Smarty version Smarty-3.1.19, created on 2018-03-09 19:00:06
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\shop.tpl" */ ?>
<?php /*%%SmartyHeaderCode:246085aa28c5ec9d154-91733499%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '442facaeec50d67326cc61509115ad3aa3c12fce' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\shop.tpl',
      1 => 1490263758,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '246085aa28c5ec9d154-91733499',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_SHOP' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5aa28c5ecdcc43_57546919',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5aa28c5ecdcc43_57546919')) {function content_5aa28c5ecdcc43_57546919($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('displayNav', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayShop'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
					<?php echo Smarty::$_smarty_vars['capture']['displayShop'];?>

<?php echo $_smarty_tpl->tpl_vars['HOOK_SHOP']->value;?>
<?php }} ?>
