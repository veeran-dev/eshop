<?php /* Smarty version Smarty-3.1.19, created on 2017-11-29 11:41:01
         compiled from "C:\wamp\www\kobsterEshop\modules\pm_advancedsearch4\views\templates\hook\pm_advancedsearch_header_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:133525a1e4f75702896-59195646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1650bd4b9d051514352648316142f3eb1c21b108' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\modules\\pm_advancedsearch4\\views\\templates\\hook\\pm_advancedsearch_header_block.tpl',
      1 => 1478085999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '133525a1e4f75702896-59195646',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hookName' => 0,
    'as_search' => 0,
    'ajaxMode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a1e4f758c30d2_02023589',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1e4f758c30d2_02023589')) {function content_5a1e4f758c30d2_02023589($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['hookName']->value=='leftColumn'||$_smarty_tpl->tpl_vars['hookName']->value=='rightColumn') {?>
<?php if (!isset($_REQUEST['ajaxMode'])) {?>
<div id="PM_ASBlockOutput_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
" class="PM_ASBlockOutput PM_ASBlockOutputVertical<?php if (version_compare(@constant('_PS_VERSION_'),'1.6.0.0','>=')) {?> block<?php }?>">
<?php }?>
	<div id="PM_ASBlock_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
"<?php if (version_compare(@constant('_PS_VERSION_'),'1.6.0.0','<')) {?> class="block"<?php }?>>
		<?php if (version_compare(@constant('_PS_VERSION_'),'1.6.0.0','>=')) {?>
			<?php if ($_smarty_tpl->tpl_vars['as_search']->value['title']) {?><p class="title_block"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['as_search']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p><?php }?>
		<?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['as_search']->value['title']) {?><h4><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['as_search']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</h4><?php }?>
		<?php }?>
		<div class="block_content">
		<?php if ($_smarty_tpl->tpl_vars['as_search']->value['display_nb_result_on_blc']) {?> <p class="PM_ASBlockNbProduct"><small class="PM_ASBlockNbProductValue">(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['total_products']);?>
 <?php if ($_smarty_tpl->tpl_vars['as_search']->value['total_products']>1) {?><?php echo smartyTranslate(array('s'=>'products','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'product','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
<?php }?>)</small></p><?php }?>
<?php } else { ?>
<?php if (!isset($_smarty_tpl->tpl_vars['ajaxMode']->value)&&$_smarty_tpl->tpl_vars['hookName']->value=='top') {?>
</div>
<div class="clear"></div>
<?php }?>
<?php if (!isset($_REQUEST['ajaxMode'])) {?>
<div id="PM_ASBlockOutput_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
" class="PM_ASBlockOutput PM_ASBlockOutputHorizontal">
<?php }?>
	<div id="PM_ASBlock_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
">
		<?php if ($_smarty_tpl->tpl_vars['as_search']->value['title']) {?><h4 class="PM_ASearchTitle"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['as_search']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php if ($_smarty_tpl->tpl_vars['as_search']->value['display_nb_result_on_blc']) {?> <small class="PM_ASBlockNbProductValue">(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['total_products']);?>
 <?php if ($_smarty_tpl->tpl_vars['as_search']->value['total_products']>1) {?><?php echo smartyTranslate(array('s'=>'products','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'product','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
<?php }?>)</small><?php }?></h4><?php }?>
		<div class="block_content">
<?php }?><?php }} ?>
