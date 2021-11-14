<?php /* Smarty version Smarty-3.1.19, created on 2017-11-29 11:41:02
         compiled from "C:\wamp\www\kobsterEshop\modules\pm_advancedsearch4\views\templates\hook\pm_advancedsearch_footer_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:266635a1e4f762a0894-21679532%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1834954f6aa5bcac3ff06fdf1cc2ea4df06ed02' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\modules\\pm_advancedsearch4\\views\\templates\\hook\\pm_advancedsearch_footer_block.tpl',
      1 => 1478085999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '266635a1e4f762a0894-21679532',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hookName' => 0,
    'ajaxMode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a1e4f76304d55_87424978',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1e4f76304d55_87424978')) {function content_5a1e4f76304d55_87424978($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['hookName']->value=='leftColumn'||$_smarty_tpl->tpl_vars['hookName']->value=='rightColumn') {?>
		</div>
	</div>
<?php if (!isset($_REQUEST['ajaxMode'])) {?>
</div>
<?php }?>
<?php } else { ?>
		</div>
	</div>
<?php if (!isset($_REQUEST['ajaxMode'])) {?>
</div>
<?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['ajaxMode']->value)&&$_smarty_tpl->tpl_vars['hookName']->value=='top') {?>
	<div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['hookName']->value=='home'&&!isset($_REQUEST['ajaxMode'])) {?>
	<div class="clear"></div>
	<div id="as_home_content_results">
	</div>
<?php }?>
<?php }?><?php }} ?>
