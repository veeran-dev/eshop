<?php /* Smarty version Smarty-3.1.19, created on 2018-02-09 15:09:00
         compiled from "C:\wamp\www\kobsterEshop\kobster_admin\themes\default\template\helpers\list\list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:37115a7d6c340f3d16-98970778%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58260588986e9995aabfbd68fb6a02ee95c0a831' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\kobster_admin\\themes\\default\\template\\helpers\\list\\list_action_edit.tpl',
      1 => 1478085951,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '37115a7d6c340f3d16-98970778',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7d6c341a6ef2_51772714',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7d6c341a6ef2_51772714')) {function content_5a7d6c341a6ef2_51772714($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
