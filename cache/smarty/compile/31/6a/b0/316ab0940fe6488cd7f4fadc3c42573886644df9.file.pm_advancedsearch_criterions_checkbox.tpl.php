<?php /* Smarty version Smarty-3.1.19, created on 2017-11-29 11:41:01
         compiled from "C:\wamp\www\kobsterEshop\modules\pm_advancedsearch4\views\templates\hook\pm_advancedsearch_criterions_checkbox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27905a1e4f75e26d65-68155141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '316ab0940fe6488cd7f4fadc3c42573886644df9' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\modules\\pm_advancedsearch4\\views\\templates\\hook\\pm_advancedsearch_criterions_checkbox.tpl',
      1 => 1478085999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27905a1e4f75e26d65-68155141',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'criterions_group' => 0,
    'as_search' => 0,
    'criterion' => 0,
    'criterion_can_hide' => 0,
    'hide_next_criterion' => 0,
    'criterion_key' => 0,
    'as_criterion_is_selected' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a1e4f7627e604_54591417',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1e4f7627e604_54591417')) {function content_5a1e4f7627e604_54591417($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['display_type']==4) {?>
	<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?>
		<div class="PM_ASCriterionStepEnable">
		<?php if (sizeof($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?>
			<ul id="PM_ASCriterionGroupCheckbox_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" class="PM_ASCriterionGroupCheckbox">
			<?php if (!$_smarty_tpl->tpl_vars['criterions_group']->value['is_multicriteria']) {?>
				<li>
					<?php if (version_compare(@constant('_PS_VERSION_'),'1.6.0.0','>=')) {?><div class="radio"><?php }?>
					<input type="radio" value="" id="as4c_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
_0" name="as4c[<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
][]" <?php if (!isset($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?>checked="checked"<?php }?> class="PM_ASCriterionCheckbox" /> <label for="as4c_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
_0" class="PM_ASLabelCheckbox"><?php echo smartyTranslate(array('s'=>'All','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</label>
					<?php if (version_compare(@constant('_PS_VERSION_'),'1.6.0.0','>=')) {?></div><?php }?>
				</li>
			<?php }?>
			<?php  $_smarty_tpl->tpl_vars['criterion'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['criterion']->_loop = false;
 $_smarty_tpl->tpl_vars['criterion_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['criterions']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['criterion']->key => $_smarty_tpl->tpl_vars['criterion']->value) {
$_smarty_tpl->tpl_vars['criterion']->_loop = true;
 $_smarty_tpl->tpl_vars['criterion_key']->value = $_smarty_tpl->tpl_vars['criterion']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['criterions']['index']++;
?>
				<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])&&in_array($_smarty_tpl->tpl_vars['criterion']->value['id_criterion'],$_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?>
						<?php $_smarty_tpl->tpl_vars['as_criterion_is_selected'] = new Smarty_variable('1', null, 0);?>
					<?php } else { ?>
						<?php $_smarty_tpl->tpl_vars['as_criterion_is_selected'] = new Smarty_variable('0', null, 0);?>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['criterion_can_hide']->value&&$_smarty_tpl->tpl_vars['criterions_group']->value['max_display']>0&&($_smarty_tpl->getVariable('smarty')->value['foreach']['criterions']['index']+1)>$_smarty_tpl->tpl_vars['criterions_group']->value['max_display']) {?>
						<?php $_smarty_tpl->tpl_vars['hide_next_criterion'] = new Smarty_variable('1', null, 0);?>
					<?php } else { ?>
						<?php $_smarty_tpl->tpl_vars['hide_next_criterion'] = new Smarty_variable('0', null, 0);?>
				<?php }?>

				<li<?php if ($_smarty_tpl->tpl_vars['hide_next_criterion']->value||!$_smarty_tpl->tpl_vars['criterion']->value['nb_product']) {?> data-id-criterion-group="<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" class="<?php if ($_smarty_tpl->tpl_vars['hide_next_criterion']->value) {?>PM_ASCriterionHide<?php }?><?php if (!$_smarty_tpl->tpl_vars['criterion']->value['nb_product']) {?><?php if ($_smarty_tpl->tpl_vars['hide_next_criterion']->value) {?> <?php }?>PM_ASCriterionDisable<?php }?>"<?php }?>>
					<?php if (version_compare(@constant('_PS_VERSION_'),'1.6.0.0','>=')) {?>
						<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['is_multicriteria']) {?><p class="checkbox"><?php } else { ?><div class="radio"><?php }?>
					<?php }?>
					<input type="<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['is_multicriteria']) {?>checkbox<?php } else { ?>radio<?php }?>" value="<?php echo $_smarty_tpl->tpl_vars['criterion']->value['id_criterion'];?>
" data-id-criterion-group="<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" id="as4c_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterion_key']->value);?>
" name="as4c[<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
][]" <?php if ($_smarty_tpl->tpl_vars['as_criterion_is_selected']->value) {?>checked="checked"<?php }?> class="PM_ASCriterionCheckbox noUniform"<?php if (!$_smarty_tpl->tpl_vars['criterion']->value['nb_product']) {?> disabled="disabled"<?php }?> /> 
					<label for="as4c_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterion_key']->value);?>
" class="PM_ASLabelCheckbox<?php if ($_smarty_tpl->tpl_vars['as_criterion_is_selected']->value) {?> PM_ASLabelCheckboxSelected<?php }?><?php if (!$_smarty_tpl->tpl_vars['criterions_group']->value['is_multicriteria']) {?> PM_ASNotMulticriteria<?php }?>">
						<a class="PM_ASLabelLink" href="<?php if (isset($_smarty_tpl->tpl_vars['criterion']->value['id_seo'])&&$_smarty_tpl->tpl_vars['criterion']->value['id_seo']!=false&&isset($_smarty_tpl->tpl_vars['criterion']->value['seo_page_url'])&&$_smarty_tpl->tpl_vars['criterion']->value['seo_page_url']!=false) {?><?php echo $_smarty_tpl->tpl_vars['criterion']->value['seo_page_url'];?>
<?php } else { ?>javascript:void(0)<?php }?>">
							<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['criterion']->value['value'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php if ($_smarty_tpl->tpl_vars['as_search']->value['display_nb_result_criterion']) {?> (<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['criterion']->value['nb_product'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
)<?php }?>
						</a>
					</label>
					<?php if (version_compare(@constant('_PS_VERSION_'),'1.6.0.0','>=')) {?>
						<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['is_multicriteria']) {?></p><?php } else { ?></div><?php }?>
					<?php }?>
				</li>
			<?php } ?>
			</ul>
			<?php if ($_smarty_tpl->tpl_vars['hide_next_criterion']->value) {?>
			<p class="PM_ASCriterionHideToogle<?php if ($_smarty_tpl->tpl_vars['as_search']->value['show_hide_crit_method']==2) {?>Click<?php }?><?php if ($_smarty_tpl->tpl_vars['as_search']->value['show_hide_crit_method']==1) {?>Hover<?php }?> PM_ASCriterionHideToogle_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
"><a href="javascript:void(0);" class="PM_ASCriterionHideToogleLink" ><span class="PM_ASShow"><?php echo smartyTranslate(array('s'=>'Show all','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</span><?php if ($_smarty_tpl->tpl_vars['as_search']->value['show_hide_crit_method']==2) {?><span class="PM_ASHide"><?php echo smartyTranslate(array('s'=>'Hide','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</span><?php }?></a></p>
			<?php }?>
		<?php } else { ?>
			<p class="PM_ASCriterionNoChoice"><?php echo smartyTranslate(array('s'=>'No choice available on this group','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</p>
		<?php }?>
		</div>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['as_search']->value['step_search']) {?>
		<div data-id-criterion-group="<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" class="PM_ASCriterionStepDisable" <?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?> style="display:none;"<?php }?>>
			<p><?php echo smartyTranslate(array('s'=>'Select above criteria','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</p>
		</div>
	<?php }?>
<?php }?><?php }} ?>
