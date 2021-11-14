<?php /* Smarty version Smarty-3.1.19, created on 2018-04-01 16:16:33
         compiled from "C:\wamp64\www\kobsterEshop\themes\default-bootstrap\modules\loyalty\views\templates\hook\my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:149135ac0b889543522-68024648%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f6a0ad44ee570c28cfd6f91c7aececa720263aa' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\themes\\default-bootstrap\\modules\\loyalty\\views\\templates\\hook\\my-account.tpl',
      1 => 1478085912,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149135ac0b889543522-68024648',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ac0b889574c91_54518661',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ac0b889574c91_54518661')) {function content_5ac0b889574c91_54518661($_smarty_tpl) {?>

<!-- MODULE Loyalty -->
<li class="loyalty col-md-4 col-sm-6">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('loyalty','default',array('process'=>'summary'),true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'My loyalty points','mod'=>'loyalty'),$_smarty_tpl);?>
" rel="nofollow"><i class="icon-flag"></i><span><?php echo smartyTranslate(array('s'=>'My loyalty points','mod'=>'loyalty'),$_smarty_tpl);?>
</span></a>
</li>
<!-- END : MODULE Loyalty --><?php }} ?>
