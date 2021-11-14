<?php /* Smarty version Smarty-3.1.19, created on 2019-08-06 00:05:38
         compiled from "C:\wamp64\www\kobsterEshop\modules\pm_advancedsearch4\views\templates\hook\pm_advancedsearch_footer_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:217235d4876fa7eff42-61411407%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd50b3e7118507f9d3c78f483e3be221c33586adb' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\modules\\pm_advancedsearch4\\views\\templates\\hook\\pm_advancedsearch_footer_block.tpl',
      1 => 1478085999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '217235d4876fa7eff42-61411407',
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
  'unifunc' => 'content_5d4876fa925216_29060770',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d4876fa925216_29060770')) {function content_5d4876fa925216_29060770($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['hookName']->value=='leftColumn'||$_smarty_tpl->tpl_vars['hookName']->value=='rightColumn') {?>
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
