<?php /* Smarty version Smarty-3.1.19, created on 2020-05-28 22:06:25
         compiled from "C:\wamp64\www\kobsterEshop\kobster_admin\themes\default\template\helpers\list\list_action_default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:288935ecfe8893ab080-72954729%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7c4215d4f86455259f57cacc95ba46c02f6d402' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\kobster_admin\\themes\\default\\template\\helpers\\list\\list_action_default.tpl',
      1 => 1478085951,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '288935ecfe8893ab080-72954729',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
    'name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ecfe889426a38_47753496',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ecfe889426a38_47753496')) {function content_5ecfe889426a38_47753496($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
"<?php if (isset($_smarty_tpl->tpl_vars['name']->value)) {?> name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> class="default">
	<i class="icon-asterisk"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>
