<?php /* Smarty version Smarty-3.1.19, created on 2017-02-28 18:05:50
         compiled from "perks-index.php" */ ?>
<?php /*%%SmartyHeaderCode:23358b56ea6094248-32752607%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4917d062002c7b9bb088c595a693d6598efb847' => 
    array (
      0 => 'perks-index.php',
      1 => 1487849984,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23358b56ea6094248-32752607',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58b56ea60d61e0_53193716',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b56ea60d61e0_53193716')) {function content_58b56ea60d61e0_53193716($_smarty_tpl) {?><<?php ?>?php
require(dirname(__FILE__).'/config/config.inc.php');
ControllerFactory::getController('PerksIndexController')->run();
?<?php ?>><?php }} ?>
