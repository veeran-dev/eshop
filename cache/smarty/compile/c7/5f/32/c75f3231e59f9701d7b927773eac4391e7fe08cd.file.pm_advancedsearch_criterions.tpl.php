<?php /* Smarty version Smarty-3.1.19, created on 2019-08-06 00:05:36
         compiled from "C:\wamp64\www\kobsterEshop\modules\pm_advancedsearch4\views\templates\hook\pm_advancedsearch_criterions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:211325d4876f841f063-51186093%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c75f3231e59f9701d7b927773eac4391e7fe08cd' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\modules\\pm_advancedsearch4\\views\\templates\\hook\\pm_advancedsearch_criterions.tpl',
      1 => 1478085999,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211325d4876f841f063-51186093',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'as_search' => 0,
    'criterions_group' => 0,
    'as_path' => 0,
    'as_criteria_group_type_interal_name' => 0,
    'tpl_name' => 0,
    'as_obj' => 0,
    'next_id_criterion_group' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d4876f8b1e569_34240887',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d4876f8b1e569_34240887')) {function content_5d4876f8b1e569_34240887($_smarty_tpl) {?><script>
$(document).ready(function(){
 	//Open the popup and center
	$(".quickViewButton").click(function(){
		var id = $(this).attr('href');
		centerPopup(id);
		loadPopup(id);
	});
	//Close popup by clicking the x
	$(".quickViewClose").click(function(){ 		var id = $(this).attr('href'); disablePopup(id); });
	//Close popup by clicking outside the box
	$(".backgroundQuickView").click(function(){ disablePopup(0); });
	
	//Close popup by clicking escape
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup(0);
		}
	});
	/////////////////////////
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}
	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

	$('ul.product_view').each(function(i) {
		var cookie = readCookie('tabCookie'+i);
		if (cookie) $(this).find('li').eq(cookie).addClass('current').siblings().removeClass('current')
			.parents('#new_center_column').find('.box').hide().eq(cookie).show();
	})

	$('ul.product_view').delegate('li:not(.current)', 'click', function() {
		$(this).addClass('current').siblings().removeClass('current')
			.parents('#new_center_column').find('.box').hide().eq($(this).index()).show();

		//img_lazyload();
		var ulIndex = $('ul.product_view').index($(this).parents('ul.product_view'));
		eraseCookie('tabCookie'+ulIndex);
		createCookie('tabCookie'+ulIndex, $(this).index(), 365);
	})
	$(".quickViewButton").click(function(){
		var id = $(this).attr('href');
		//img_lazyload();
		centerPopup(id);
		loadPopup(id);
	});
	//img_lazyload();
	//////////////
	
});
	/*function img_lazyload()
	{
		$('#product_list_grid img.lazyImage').jail({
			effect: 'fadeIn',
			speed : 500
		});
		$('#product_list_list img.lazyImage').jail({
			effect: 'fadeIn',
			speed : 500
		});
		$('.quickView img.lazyImage').jail({
			effect: 'fadeIn',
			speed : 500
		});
	}*/
</script>
<?php if ($_smarty_tpl->tpl_vars['as_search']->value['show_hide_crit_method']==1||$_smarty_tpl->tpl_vars['as_search']->value['show_hide_crit_method']==2) {?>
	<?php $_smarty_tpl->tpl_vars['criterion_can_hide'] = new Smarty_variable('1', null, 0);?>
<?php } else { ?>
	<?php $_smarty_tpl->tpl_vars['criterion_can_hide'] = new Smarty_variable('0', null, 0);?>
<?php }?>
<div id="PM_ASCriterionsOutput_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" class="PM_ASCriterionsOutput">
<div id="PM_ASCriterions_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" class="PM_ASCriterions">
<?php if ($_smarty_tpl->tpl_vars['as_search']->value['hide_empty_crit_group']&&$_smarty_tpl->tpl_vars['as_search']->value['step_search']&&(!isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])||!sizeof($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']]))) {?>
<?php } else { ?>
<p class="PM_ASCriterionsGroupTitle<?php if ($_smarty_tpl->tpl_vars['as_search']->value['collapsable_criterias']) {?> PM_ASCriterionsGroupCollapsable<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['is_collapsed']) {?> PM_ASCriterionsArrowleft<?php } else { ?> PM_ASCriterionsArrowDown<?php }?><?php }?>" id="PM_ASCriterionsGroupTitle_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" rel="<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
"><?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['icon']) {?><img src="<?php echo $_smarty_tpl->tpl_vars['as_path']->value;?>
search_files/criterions_group/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['criterions_group']->value['icon'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['criterions_group']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['criterions_group']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" id="PM_ASCriterionsGroupIcon_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
" class="PM_ASCriterionsGroupIcon" /><?php }?><b><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['criterions_group']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</b></p>

<div class="PM_ASCriterionsGroupOuter<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['is_collapsed']) {?> PM_ASCriterionsGroupCollapsed <?php }?>">

<?php $_smarty_tpl->tpl_vars['tpl_name'] = new Smarty_variable((('pm_advancedsearch_criterions_').($_smarty_tpl->tpl_vars['as_criteria_group_type_interal_name']->value[$_smarty_tpl->tpl_vars['criterions_group']->value['display_type']])).('.tpl'), null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['as_obj']->value->_getTplPath($_smarty_tpl->tpl_vars['tpl_name']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
<?php if (intval($_smarty_tpl->tpl_vars['as_search']->value['reset_group'])&&isset($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])&&sizeof($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])) {?><div class="clear"></div><a href="javascript:void(0)" class="PM_ASResetGroup<?php if ($_smarty_tpl->tpl_vars['criterions_group']->value['is_collapsed']) {?> PM_ASCriterionsGroupCollapsed<?php }?>" rel="<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
"><?php echo smartyTranslate(array('s'=>'Reset this group','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
</a><?php }?>
<?php }?>
</div>
<div class="clear"></div>
</div>
<?php if ($_smarty_tpl->tpl_vars['as_search']->value['step_search']) {?>
	<input type="hidden" name="current_id_criterion_group" value="<?php echo $_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group'];?>
" disabled="disabled" />
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['next_id_criterion_group']->value)) {?>
<script type="text/javascript">
	<?php if (is_array($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'])&&sizeof($_smarty_tpl->tpl_vars['as_search']->value['selected_criterion'])&&isset($_REQUEST['ajaxMode'])) {?>
	if(typeof(as_location_name) != 'undefined' && as_location_name) $('#PM_ASBlock_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
 .PM_ASResetSearch').html("<?php echo smartyTranslate(array('s'=>'Back to','mod'=>'pm_advancedsearch4','js'=>1),$_smarty_tpl);?>
 "+as_location_name);
		$('#PM_ASBlock_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
 .PM_ASResetSearch').css('display','block');
	<?php }?>
	//Reset Group Function
	<?php if (intval($_smarty_tpl->tpl_vars['as_search']->value['reset_group'])) {?>
		$('.PM_ASCriterionsGroupOuter')
	<?php }?>
	//Update nb product display
	$('#PM_ASBlock_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
 .PM_ASBlockNbProductValue').html("(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['total_products']);?>
 <?php if ($_smarty_tpl->tpl_vars['as_search']->value['total_products']>1) {?><?php echo smartyTranslate(array('s'=>'products','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'product','mod'=>'pm_advancedsearch4'),$_smarty_tpl);?>
<?php }?>)");
	<?php if ($_smarty_tpl->tpl_vars['next_id_criterion_group']->value&&(!isset($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']])||!sizeof($_smarty_tpl->tpl_vars['as_search']->value['criterions'][$_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']]))) {?>

		nextStep(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
,$('#PM_ASCriterions_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
_<?php echo intval($_smarty_tpl->tpl_vars['criterions_group']->value['id_criterion_group']);?>
'),true,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['search_method']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['dynamic_criterion']);?>
);
	<?php }?>
	<?php if (intval($_smarty_tpl->tpl_vars['as_search']->value['search_method'])===2) {?>
		$jqPm('#PM_ASForm_<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
').ajaxForm(as4_getASFormOptions(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
));
	<?php }?>
	initSearchBlock(<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['id_search']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['search_method']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['step_search']);?>
,<?php echo intval($_smarty_tpl->tpl_vars['as_search']->value['dynamic_criterion']);?>
);
</script>
<?php }?><?php }} ?>
