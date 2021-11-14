<?php /* Smarty version Smarty-3.1.19, created on 2019-08-06 00:05:34
         compiled from "C:\wamp64\www\kobsterEshop\modules\pm_advancedsearch4\views\templates\hook\pm_advancedsearch.tpl" */ ?>
<?php /*%%SmartyHeaderCode:35505d4876f64ea7b3-82268987%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f37e60d5c32224b92b8bded8517c83369eeded4' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\modules\\pm_advancedsearch4\\views\\templates\\hook\\pm_advancedsearch.tpl',
      1 => 1478085999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '35505d4876f64ea7b3-82268987',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hideAS4Form' => 0,
    'as_searchs' => 0,
    'as_obj' => 0,
    'as_search' => 0,
    'as_selected_criterion' => 0,
    'ASSearchUrlForm' => 0,
    'criterions_group' => 0,
    'as_criteria_group_type_interal_name' => 0,
    'hidden_criteria_group_open' => 0,
    'next_id_criterion_group_isset' => 0,
    'selected_id_criterion' => 0,
    'hookName' => 0,
    'page_name' => 0,
    'as4_productFilterListData' => 0,
    'as4_productFilterListSource' => 0,
    'as_location_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d4876f78ed498_73082887',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d4876f78ed498_73082887')) {function content_5d4876f78ed498_73082887($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['hideAS4Form']->value)&&$_smarty_tpl->tpl_vars['hideAS4Form']->value==true) {?><div id="PM_ASFormContainerHidden" style="display: none"><?php }?>
<?php  $_smarty_tpl->tpl_vars['as_search'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['as_search']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['as_searchs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['as_search']->key => $_smarty_tpl->tpl_vars['as_search']->value) {
$_smarty_tpl->tpl_vars['as_search']->_loop = true;
?>
	<?php $_smarty_tpl->tpl_vars['next_id_criterion_group_isset'] = new Smarty_variable('0', null, 0);?>
	<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['as_obj']->value->_getTplPath("pm_advancedsearch_header_block.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php if ($_smarty_tpl->tpl_vars['as_search']->value['remind_selection']==3||$_smarty_tpl->tpl_vars['as_search']->value['remind_selection']==2) {?>
		<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['as_obj']->value->_getTplPath("pm_advancedsearch_selection_block.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php }?>
	<a <?php if (!isset($_GET['id_seo'])&&isset($_smarty_tpl->tpl_vars['as_selected_criterion']->value)&&is_array($_smarty_tpl->tpl_vars['as_selected_criterion']->value)&&!sizeof($_smarty_tpl->tpl_vars['as_selected_criterion']->value)) {?>style="display: none" <?php }?>href="javascript:void(0)" class="PM_ASResetSearch"><?php echo smartyTranslate(array('s'=>'Back','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</a>
	<div class="clear"></div>
	<form action="<?php echo $_smarty_tpl->tpl_vars['ASSearchUrlForm']->value;?>
" method="GET" id="PM_ASForm_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
" class="PM_ASForm">
	<?php  $_smarty_tpl->tpl_vars['criterions_group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['criterions_group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['as_search']->value['criterions_groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['criterions_group']->key => $_smarty_tpl->tpl_vars['criterions_group']->value) {
$_smarty_tpl->tpl_vars['criterions_group']->_loop = true;
?>
		<?php if (!(isset($_smarty_tpl->tpl_vars['as_criteria_group_type_interal_name']->value[$_smarty_tpl->tpl_vars['criterions_group']->value['display_type']])&&$_smarty_tpl->tpl_vars['as_criteria_group_type_interal_name']->value[$_smarty_tpl->tpl_vars['criterions_group']->value['display_type']]=='slider'&&isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])&&isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0])&&((isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['cur_min'])&&isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['cur_max'])&&$_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['cur_min']==0&&$_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['cur_max']==0)||(isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['min'])&&isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['max'])&&$_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['min']==0&&$_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']][0]['max']==0)))&&($_smarty_tpl->tpl_vars['criterions_group']->value['visible']&&$_smarty_tpl->tpl_vars['as_search']->value['hide_empty_crit_group']&&isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])&&sizeof($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']]))||($_smarty_tpl->tpl_vars['criterions_group']->value['visible']&&!$_smarty_tpl->tpl_vars['as_search']->value['hide_empty_crit_group'])||($_smarty_tpl->tpl_vars['criterions_group']->value['visible']&&$_smarty_tpl->tpl_vars['as_search']->value['step_search'])) {?>
			<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['hidden']=='1'&&!isset($_smarty_tpl->tpl_vars['hidden_criteria_group_open']->value)) {?>
				<?php $_smarty_tpl->tpl_vars['hidden_criteria_group_open'] = new Smarty_variable('1', null, 0);?>
				<p class="PM_ASShowCriterionsGroupHidden"><a href="javascript:void(0)"><?php echo smartyTranslate(array('s'=>'Advanced search','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</a></p>
			<?php }?>
			<div id="PM_ASCriterionsGroup_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['seo_criterion_groups'])&&is_array($_smarty_tpl->tpl_vars['as_search']->value['seo_criterion_groups'])&&in_array($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group'],$_smarty_tpl->tpl_vars['as_search']->value['seo_criterion_groups'])) {?>PM_ASCriterionsSEOGroupDisabled <?php }?>PM_ASCriterionsGroup<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['hidden']) {?> PM_ASCriterionsGroupHidden<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['advanced_search_open'])&&$_smarty_tpl->tpl_vars['as_search']->value['advanced_search_open']) {?> style="display:block;"<?php }?>>
				<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['as_obj']->value->_getTplPath("pm_advancedsearch_criterions.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
			<?php if ($_smarty_tpl->tpl_vars['as_search']->value['step_search']&&$_smarty_tpl->tpl_vars['next_id_criterion_group_isset']->value=='0'&&!isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?>
				<?php $_smarty_tpl->tpl_vars['next_id_criterion_group_isset'] = new Smarty_variable('1', null, 0);?>
			<?php }?>
		<?php }?>
		
			<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?>
				<?php  $_smarty_tpl->tpl_vars['selected_id_criterion'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['selected_id_criterion']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['selected_id_criterion']->key => $_smarty_tpl->tpl_vars['selected_id_criterion']->value) {
$_smarty_tpl->tpl_vars['selected_id_criterion']->_loop = true;
?>
					<?php if (!$_smarty_tpl->tpl_vars['criterions_group']->value['visible']) {?>
						<input type="hidden" name="as4c[<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
][]" value="<?php echo $_smarty_tpl->tpl_vars['selected_id_criterion']->value;?>
" />
						<input type="hidden" name="as4c_hidden[<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
][]" value="<?php echo $_smarty_tpl->tpl_vars['selected_id_criterion']->value;?>
" />
					<?php }?>
				<?php } ?>
			<?php }?>
		
	<?php } ?>
	<?php if ($_smarty_tpl->tpl_vars['as_search']->value['dynamic_criterion']&&$_smarty_tpl->tpl_vars['as_search']->value['search_method']==='2') {?>
	<input type="hidden" name="old_selected_criterion" value="<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['old_selected_criterion'])) {?><?php echo base64_encode(serialize($_smarty_tpl->tpl_vars['as_search']->value['old_selected_criterion']));?>
<?php } else { ?><?php echo base64_encode(serialize($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion']));?>
<?php }?>" />
	<?php }?>
	<?php if (intval($_smarty_tpl->tpl_vars['as_search']->value['reset_group'])) {?>
	<input type="hidden" name="reset_group" value="" />
	<?php }?>

	<input type="hidden" name="id_search" value="<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
" />
	<input type="hidden" name="hookName" value="<?php echo $_smarty_tpl->tpl_vars['hookName']->value;?>
" />
	<?php if ((isset($_REQUEST['keep_category_information'])&&$_REQUEST['keep_category_information'])||($_smarty_tpl->tpl_vars['as_search']->value['keep_category_information']&&((isset($_GET['id_category'])&&$_GET['id_category']&&$_smarty_tpl->tpl_vars['page_name']->value=='category')||(isset($_GET['id_manufacturer'])&&$_GET['id_manufacturer']&&$_smarty_tpl->tpl_vars['page_name']->value=='manufacturer')||(isset($_GET['id_supplier'])&&$_GET['id_supplier']&&$_smarty_tpl->tpl_vars['page_name']->value=='supplier')||(isset($_GET['seo_url'])&&$_GET['seo_url'])))) {?>
		<input type="hidden" name="keep_category_information" value="1" />
	<?php }?>
	<?php if (isset($_GET['id_category'])||isset($_GET['id_category_search'])) {?>
		<input type="hidden" name="id_category_search" value="<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['id_category_root'])&&$_smarty_tpl->tpl_vars['as_search']->value['id_category_root']>0) {?><?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_category_root']);?>
<?php } elseif (isset($_GET['id_category'])) {?><?php echo intval($_GET['id_category']);?>
<?php } else { ?><?php echo intval($_GET['id_category_search']);?>
<?php }?>" />
	<?php }?>
	<?php if (isset($_GET['id_manufacturer'])||isset($_GET['id_manufacturer_search'])) {?>
		<input type="hidden" name="id_manufacturer_search" value="<?php if (isset($_GET['id_manufacturer'])) {?><?php echo intval($_GET['id_manufacturer']);?>
<?php } else { ?><?php echo intval($_GET['id_manufacturer_search']);?>
<?php }?>" />
	<?php }?>
	<?php if (isset($_GET['id_supplier'])||isset($_GET['id_supplier_search'])) {?>
		<input type="hidden" name="id_supplier_search" value="<?php if (isset($_GET['id_supplier'])) {?><?php echo intval($_GET['id_supplier']);?>
<?php } else { ?><?php echo intval($_GET['id_supplier_search']);?>
<?php }?>" />
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['as_search']->value['step_search']) {?>
	<input type="hidden" name="step_search" value="<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['step_search']);?>
" />
	<input type="hidden" name="next_id_criterion_group" value="" />
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['base_selection'])&&$_smarty_tpl->tpl_vars['as_search']->value['base_selection']) {?>
	<input type="hidden" name="as4_base_selection" value="<?php echo base64_encode(serialize($_smarty_tpl->tpl_vars['as_search']->value['base_selection']));?>
" />
	<?php }?>
	<input type="hidden" name="orderby"<?php if (isset($_GET['orderby'])&&$_GET['orderby']) {?> value="<?php echo $_GET['orderby'];?>
"<?php } else { ?> disabled="disabled"<?php }?> />
	<input type="hidden" name="orderway"<?php if (isset($_GET['orderway'])&&$_GET['orderway']) {?> value="<?php echo $_GET['orderway'];?>
"<?php } else { ?> disabled="disabled"<?php }?> />
	<input type="hidden" name="n"<?php if (isset($_GET['n'])&&$_GET['n']) {?> value="<?php echo $_GET['n'];?>
"<?php } else { ?> disabled="disabled"<?php }?> />
	<?php if ($_smarty_tpl->tpl_vars['as_search']->value['search_method']==='2') {?>
		<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Search','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
" name="submitAsearch" class="button PM_ASSubmitSearch" />
	<?php }?>
	
	<?php if (isset($_GET['id_seo'])) {?>
	<input type="hidden" name="id_seo" value="<?php echo intval($_GET['id_seo']);?>
" />
	<?php }?>

	<script type="text/javascript">
	if(typeof(ASParams[<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
]) == 'undefined') {
		ASParams[<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
] = {
			'keep_category_information' 	: <?php if ((isset($_GET['id_category'])&&$_GET['id_category']&&$_smarty_tpl->tpl_vars['page_name']->value=='category')||(isset($_GET['id_manufacturer'])&&$_GET['id_manufacturer']&&$_smarty_tpl->tpl_vars['page_name']->value=='manufacturer')||(isset($_GET['id_supplier'])&&$_GET['id_supplier']&&$_smarty_tpl->tpl_vars['page_name']->value=='supplier')||(isset($_GET['seo_url'])&&$_GET['seo_url'])) {?><?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['keep_category_information']);?>
<?php } else { ?>0<?php }?>,
			'search_results_selector'		: '<?php echo $_smarty_tpl->tpl_vars['as_search']->value['search_results_selector'];?>
',
			'insert_in_center_column'		: '<?php echo $_smarty_tpl->tpl_vars['as_search']->value['insert_in_center_column'];?>
',
			'seo_criterion_groups'			: '<?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['seo_criterion_groups'])&&is_array($_smarty_tpl->tpl_vars['as_search']->value['seo_criterion_groups'])) {?><?php echo implode(",",$_smarty_tpl->tpl_vars['as_search']->value['seo_criterion_groups']);?>
<?php }?>',
			'as4_productFilterListData'		: '<?php if (isset($_smarty_tpl->tpl_vars['as4_productFilterListData']->value)&&!empty($_smarty_tpl->tpl_vars['as4_productFilterListData']->value)) {?><?php echo $_smarty_tpl->tpl_vars['as4_productFilterListData']->value;?>
<?php }?>',
			'as4_productFilterListSource'	: '<?php if (isset($_smarty_tpl->tpl_vars['as4_productFilterListSource']->value)&&!empty($_smarty_tpl->tpl_vars['as4_productFilterListSource']->value)) {?><?php echo $_smarty_tpl->tpl_vars['as4_productFilterListSource']->value;?>
<?php }?>',
			'scrollTopActive'				: <?php if (isset($_smarty_tpl->tpl_vars['as_search']->value['scrolltop_active'])&&$_smarty_tpl->tpl_vars['as_search']->value['scrolltop_active']) {?>true<?php } else { ?>false<?php }?>
		};
	}
	<?php if (isset($_smarty_tpl->tpl_vars['as_location_name']->value)&&$_smarty_tpl->tpl_vars['as_location_name']->value) {?>
		var as_location_name = '<?php echo addcslashes($_smarty_tpl->tpl_vars['as_location_name']->value,"'");?>
';
		if(typeof(as_location_name) != 'undefined' && as_location_name) {
			$(document).ready(function() {
				$('#PM_ASBlock_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
 .PM_ASResetSearch').html("<?php echo smartyTranslate(array('s'=>'Back to','mod'=>'pm_advancedsearch4','js'=>1),$_smarty_tpl);?>
 "+as_location_name);
			});
		}
	<?php }?>
	<?php if (is_array($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'])&&sizeof($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'])&&isset($_REQUEST['ajaxMode'])) {?>
		$('#PM_ASBlock_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
 .PM_ASResetSearch').css('display','block');
	<?php }?>
	
		initSearchBlock(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['search_method']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['step_search']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['dynamic_criterion']);?>
);
		
	<?php if ($_smarty_tpl->tpl_vars['as_search']->value['save_selection']&&!isset($_REQUEST['ajaxMode'])&&((isset($_GET['id_category'])&&$_GET['id_category']&&$_smarty_tpl->tpl_vars['page_name']->value=='category')||(isset($_GET['id_manufacturer'])&&$_GET['id_manufacturer']&&$_smarty_tpl->tpl_vars['page_name']->value=='manufacturer')||(isset($_GET['id_supplier'])&&$_GET['id_supplier']&&$_smarty_tpl->tpl_vars['page_name']->value=='supplier'))&&$_smarty_tpl->tpl_vars['as_search']->value['save_selection_active']&&is_array($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'])&&sizeof($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'])) {?>
		changeHash(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
);
		asLaunchHash("ASHash[<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
]");
	<?php }?>
	</script>
	<div class="clear"></div>
	</form>
	<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['as_obj']->value->_getTplPath("pm_advancedsearch_footer_block.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } ?>
<?php if (isset($_smarty_tpl->tpl_vars['hideAS4Form']->value)&&$_smarty_tpl->tpl_vars['hideAS4Form']->value==true) {?></div><script type="text/javascript">$(document).ready(function() { as4_moveFormContainerForSEOPages(); });</script><?php }?><?php }} ?>
