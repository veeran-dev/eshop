<script>
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
{if $as_search.show_hide_crit_method eq 1 || $as_search.show_hide_crit_method eq 2}
	{assign var='criterion_can_hide' value='1'}
{else}
	{assign var='criterion_can_hide' value='0'}
{/if}
<div id="PM_ASCriterionsOutput_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionsOutput">
<div id="PM_ASCriterions_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterions">
{if $as_search.hide_empty_crit_group && $as_search.step_search && (!isset($as_search.criterions[$criterions_group.id_criterion_group]) || !sizeof($as_search.criterions[$criterions_group.id_criterion_group]))}
{else}
<p class="PM_ASCriterionsGroupTitle{if $as_search.collapsable_criterias} PM_ASCriterionsGroupCollapsable{if $criterions_group.is_collapsed} PM_ASCriterionsArrowleft{else} PM_ASCriterionsArrowDown{/if}{/if}" id="PM_ASCriterionsGroupTitle_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" rel="{$criterions_group.id_criterion_group|intval}">{if $criterions_group.icon}<img src="{$as_path}search_files/criterions_group/{$criterions_group.icon|escape:'htmlall':'UTF-8'}" alt="{$criterions_group.name|escape:'htmlall':'UTF-8'}" title="{$criterions_group.name|escape:'htmlall':'UTF-8'}" id="PM_ASCriterionsGroupIcon_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionsGroupIcon" />{/if}<b>{$criterions_group.name|escape:'htmlall':'UTF-8'}</b></p>

<div class="PM_ASCriterionsGroupOuter{if $criterions_group.is_collapsed} PM_ASCriterionsGroupCollapsed {/if}">

{assign var='tpl_name' value='pm_advancedsearch_criterions_'|cat:$as_criteria_group_type_interal_name[$criterions_group.display_type]|cat:'.tpl'}
{include file=$as_obj->_getTplPath($tpl_name)}
</div>
{if $as_search.reset_group|intval && isset($as_search.selected_criterion[$criterions_group.id_criterion_group]) && sizeof($as_search.selected_criterion[$criterions_group.id_criterion_group])}<div class="clear"></div><a href="javascript:void(0)" class="PM_ASResetGroup{if $criterions_group.is_collapsed} PM_ASCriterionsGroupCollapsed{/if}" rel="{$criterions_group.id_criterion_group|intval}">{l s='Reset this group' mod='pm_advancedsearch4'}</a>{/if}
{/if}
</div>
<div class="clear"></div>
</div>
{if $as_search.step_search}
	<input type="hidden" name="current_id_criterion_group" value="{$criterions_group.id_criterion_group}" disabled="disabled" />
{/if}

{if isset($next_id_criterion_group)}
<script type="text/javascript">
	{if is_array($as_search.selected_criterion) && sizeof($as_search.selected_criterion) && isset($smarty.request.ajaxMode)}
	if(typeof(as_location_name) != 'undefined' && as_location_name) $('#PM_ASBlock_{$as_search.id_search|intval} .PM_ASResetSearch').html("{l s='Back to' mod='pm_advancedsearch4' js=1} "+as_location_name);
		$('#PM_ASBlock_{$as_search.id_search|intval} .PM_ASResetSearch').css('display','block');
	{/if}
	//Reset Group Function
	{if $as_search.reset_group|intval}
		$('.PM_ASCriterionsGroupOuter')
	{/if}
	//Update nb product display
	$('#PM_ASBlock_{$as_search.id_search|intval} .PM_ASBlockNbProductValue').html("({$as_search.total_products|intval} {if $as_search.total_products > 1}{l s='products' mod='pm_advancedsearch4'}{else}{l s='product' mod='pm_advancedsearch4'}{/if})");
	{if $next_id_criterion_group && (!isset($as_search.criterions[$criterions_group.id_criterion_group]) || ! sizeof($as_search.criterions[$criterions_group.id_criterion_group]))}

		nextStep({$as_search.id_search|intval},$('#PM_ASCriterions_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}'),true,{$as_search.search_method|intval},{$as_search.dynamic_criterion|intval});
	{/if}
	{if $as_search.search_method|intval === 2}
		$jqPm('#PM_ASForm_{$as_search.id_search|intval}').ajaxForm(as4_getASFormOptions({$as_search.id_search|intval}));
	{/if}
	initSearchBlock({$as_search.id_search|intval},{$as_search.search_method|intval},{$as_search.step_search|intval},{$as_search.dynamic_criterion|intval});
</script>
{/if}