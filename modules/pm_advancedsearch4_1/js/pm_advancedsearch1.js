var as_location_name = false;
var hashChangeBusy = false;

/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license.
 * Copyright 2007, 2013 Brian Cherne
 */
(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})($jqPm);

/*
http://kevin.vanzonneveld.net
+      original by: Philippe Jausions (http://pear.php.net/user/jausions)
+      original by: Aidan Lister (http://aidanlister.com/)
+ reimplemented by: Kankrelune (http://www.webfaktory.info/)
+      improved by: Brett Zamir (http://brett-zamir.me)
+      improved by: Scott Baker
+      improved by: Theriault
*/
function pm_version_compare(v1,v2,operator){this.php_js=this.php_js||{};this.php_js.ENV=this.php_js.ENV||{};var i=0,x=0,compare=0,vm={'dev':-6,'alpha':-5,'a':-5,'beta':-4,'b':-4,'RC':-3,'rc':-3,'#':-2,'p':1,'pl':1},prepVersion=function(v){v=(''+v).replace(/[_\-+]/g,'.');v=v.replace(/([^.\d]+)/g,'.$1.').replace(/\.{2,}/g,'.');return(!v.length?[-8]:v.split('.'));},numVersion=function(v){return!v?0:(isNaN(v)?vm[v]||-7:parseInt(v,10));};v1=prepVersion(v1);v2=prepVersion(v2);x=Math.max(v1.length,v2.length);for(i=0;i<x;i++){if(v1[i]==v2[i]){continue;}
v1[i]=numVersion(v1[i]);v2[i]=numVersion(v2[i]);if(v1[i]<v2[i]){compare=-1;break;}else if(v1[i]>v2[i]){compare=1;break;}}
if(!operator){return compare;}
switch(operator){case'>':case'gt':return(compare>0);case'>=':case'ge':return(compare>=0);case'<=':case'le':return(compare<=0);case'==':case'=':case'eq':return(compare===0);case'<>':case'!=':case'ne':return(compare!==0);case'':case'<':case'lt':return(compare<0);default:return null;}}

/**
 * Ajax Queue Plugin
 */
(function ($) {
	var ajax = $.ajax;
	var pendingRequests = {};

	$.ajax = function (settings) {
		settings = jQuery.extend(
				settings,
				jQuery.extend({},
					jQuery.ajaxSettings,
					settings));
		var port = settings.port;

		switch (settings.mode) {
		case "abort":
			if (pendingRequests[port]) {
				pendingRequests[port].abort();
			}
			return pendingRequests[port] = ajax.apply(this, arguments);

		case "queue":
			var _old = settings.complete;
			settings.complete = function () {
				if (_old)
					_old.apply(this, arguments);
				jQuery([ajax]).dequeue("ajax" + port);
			};

			jQuery([ajax]).queue("ajax" + port, function () {
				ajax(settings);
			});
			return;

		case "dequeue":
			jQuery([ajax]).dequeue("ajax" + port);

			if (jQuery.isFunction(settings.complete))
				settings.complete(settings);

			return;
		}

		return ajax.apply(this, arguments);
	};
})($jqPm);

// Get ASParams var
function as4_getASParamsValue(idSearch, varName) {
	if (typeof(ASParams[idSearch][varName]) != 'undefined')
		return ASParams[idSearch][varName];
	return false;
}

// Get Ajax dynamic parameters
function as4_getASFormOptions(id_search) {
	var ASFormOptions = {
		beforeSubmit : showAsRequest,
		success : showAsResponse,
		dataType : 'json',
		mode : 'abort',
		port : 'asSearch',
		data : {
			ajaxMode : 1,
			productFilterListData : as4_getASParamsValue(id_search, 'as4_productFilterListData'),
			productFilterListSource : as4_getASParamsValue(id_search, 'as4_productFilterListSource')
		},
		type : "GET"
	};
	return ASFormOptions;
}

// Get Ajax dynamic parameters
function as4_getASFormDynamicCriterionOptions(id_search) {
	var ASFormDynamicCriterionOptions = {
		beforeSubmit : showAsRequest,
		success : showAsResponse,
		dataType : 'json',
		mode : 'abort',
		port : 'asSearch',
		data : {
			with_product : 0,
			ajaxMode : 1,
			productFilterListData : as4_getASParamsValue(id_search, 'as4_productFilterListData'),
			productFilterListSource : as4_getASParamsValue(id_search, 'as4_productFilterListSource')
		},
		type : "GET"
	};
	return ASFormDynamicCriterionOptions;
}

function as4_getASFormOptionsReset(id_search) {
	var ASFormOptionsReset = {
		beforeSubmit : showAsRequest,
		success : showAsResponse,
		dataType : 'json',
		mode : 'abort',
		port : 'asSearch',
		data : {
			reset : 1,
			ajaxMode : 1,
			productFilterListData : as4_getASParamsValue(id_search, 'as4_productFilterListData'),
			productFilterListSource : as4_getASParamsValue(id_search, 'as4_productFilterListSource')
		},
		type : "GET"
	};
	return ASFormOptionsReset;
}

function as4_getASFormDynamicCriterionOptionsReset(id_search) {
	var ASFormDynamicCriterionOptionsReset = {
		beforeSubmit : showAsRequest,
		success : showAsResponse,
		dataType : 'json',
		mode : 'abort',
		port : 'asSearch',
		data : {
			with_product : 0,
			reset : 1,
			ajaxMode : 1,
			productFilterListData : as4_getASParamsValue(id_search, 'as4_productFilterListData'),
			productFilterListSource : as4_getASParamsValue(id_search, 'as4_productFilterListSource')
		},
		type : "GET"
	};
	return ASFormDynamicCriterionOptionsReset;
}

// Pre-submit callback
function showAsRequest(formData, jqForm, options) {
	var queryString = $.param(formData);
	var id_search = $jqPm(jqForm).find('input[name=id_search]').val();
	setlayer('body', '#PM_ASBlockOutput_' + id_search, 'PM_ASearchLayerBlock', 'PM_ASearchLayerBlock');
	return true;
}

var asLayers = new Array();
function setlayer(parent, element, elementId, elementClass) {
	if (typeof(element) == 'undefined' || $(element).size() == 0 || $(element).filter(":visible").size() == 0) return;
	
	var blockWidth = $(element).outerWidth();
	var blockHeight = $(element).outerHeight();
	if (typeof($(element).offset()) != 'undefined' && $(element).offset() != null) {
		var blockTop = $(element).offset().top;
		var blockLeft = $(element).offset().left;
	} else {
		var blockTop = 0;
		var blockLeft = 0;
	}

	if (!$('#' + elementId).length)
		$('body').append('<div id="' + elementId + '" class="' + elementClass + '"><iframe src="javascript:\'\';" marginwidth="0" marginheight="0" align="bottom" scrolling="no" frameborder="0" style="position:absolute; left:0; top:0px; display:block; filter:alpha(opacity=0);width:' + blockWidth + 'px;height:' + blockHeight + 'px" ></iframe></div>');

	$('#' + elementId).css({
		width : blockWidth + 'px',
		height : blockHeight + 'px',
		top : blockTop + 'px',
		left : blockLeft + 'px',
		position : 'absolute',
		zIndex : '1000'
	});
	$('#' + elementId).fadeTo('fast', 0.8);
	if (typeof(asLayers[elementId]) == 'undefined')
		asLayers[elementId] = setInterval(function () {
				setlayer(parent, element, elementId, elementClass)
			}, 300);
}
function removelayer(elementId) {
	clearInterval(asLayers[elementId]);
	delete asLayers[elementId];
	if ($('#' + elementId).length) {
		$('#' + elementId).fadeOut('fast', function () {
			$(this).remove();

		});
	}
}

function pm_getVisibleCriterionsGroupsHash(id_search) {
	var pm_getVisibleCriterionsGroupsHashReturn = '';
	if ($('#PM_ASForm_' + id_search +' .PM_ASCriterionsGroupTitle:visible') !='undefined' && $('#PM_ASForm_' + id_search +' .PM_ASCriterionsGroupTitle:visible').size() > 0) {
		$('#PM_ASForm_' + id_search +' .PM_ASCriterionsGroupTitle:visible').each(function() {
			pm_getVisibleCriterionsGroupsHashReturn += '-' + $(this).attr('id');
		});
		return pm_getVisibleCriterionsGroupsHashReturn;
	}
	return pm_getVisibleCriterionsGroupsHashReturn;
}

var pm_visibleCriterionsGroupsHash = '';
function pm_scrollTop(id_search, context) {
	if (as4_getASParamsValue(id_search, 'scrollTopActive') == true) {
		if (as4_getASParamsValue(id_search, 'stepSearch') == 1) {
			var pm_scrollTopSelector = $('#PM_ASForm_' + id_search +' .PM_ASCriterionsGroupTitle:visible:last');
			if (pm_visibleCriterionsGroupsHash == pm_getVisibleCriterionsGroupsHash(id_search) || typeof(pm_scrollTopSelector) == 'undefined' || context == 'pagination' || context == 'order_by')
				pm_scrollTopSelector = as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column';
		} else {
			pm_scrollTopSelector = as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column';
		}
		
		if (typeof($(pm_scrollTopSelector)) != 'undefined' && $(pm_scrollTopSelector).size() > 0) {
			$($.browser.webkit ? 'body' : 'html').animate({
				scrollTop : $(pm_scrollTopSelector).offset().top
			}, 500);
			pm_visibleCriterionsGroupsHash = pm_getVisibleCriterionsGroupsHash(id_search);
		}
	}
}

function setResultsContents(id_search, htmlResults, context) {
	var oldBreadCrump = $jqPm((as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column') + ' .breadcrumb').html();
	setlayer('body', (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column'), 'PM_ASearchLayerResult', 'PM_ASearchLayerResult');
	var addToHeight = 0;
	// Remove any previous search results (SEO pages case)
	$jqPm('#PM_ASearchResultsInner, #PM_ASearchResults').remove();
	if (as4_getASParamsValue(id_search, 'keep_category_information')) {
		var addheight = true;
		$jqPm('#productsSortForm, #pagination, .content_sortPagiBar, .pagination, ' + (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column') + ' form, ' + (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column') + ' script, #product_list, .product_list, .listorgridswitch, .listorgridcanvas').remove();
		$jqPm((as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column')).css('height', 'auto');
		addToHeight = $jqPm(as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column').outerHeight();
	}
	if (as4_getASParamsValue(id_search, 'search_results_selector') != '' && (as4_getASParamsValue(id_search, 'search_results_selector') == '#as_home_content_results' || parseInt(as4_getASParamsValue(id_search, 'insert_in_center_column')) == 1)) {
		$jqPm('#PM_ASBlockOutput_' + id_search).parent('div').find('*:not(#PM_ASBlockOutput_' + id_search + ', #PM_ASBlockOutput_' + id_search + ' *, ' + as4_getASParamsValue(id_search, 'search_results_selector') + ')').remove();
	}
	var htmlResultsHeight = $jqPm('<div style="width:' + $jqPm((as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column')).outerWidth() + 'px;">' + htmlResults + '</div>').actual('innerHeight', {
			clone : true
		}) + addToHeight + 20;
	$jqPm('body ' + (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column')).animate({
		height : htmlResultsHeight + 'px'
	}, 500, function () {
		// Animation complete.
		$jqPm('body ' + (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column')).css('height', 'auto');
		if (as4_getASParamsValue(id_search, 'keep_category_information')) {
			if ($jqPm('#PM_ASearchSeoCrossLinks').length)
				$jqPm(htmlResults).insertBefore('#PM_ASearchSeoCrossLinks');
			else
				$jqPm((as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column')).append(htmlResults);
		} else {
			$jqPm((as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column')).html(htmlResults);
		}
		pm_scrollTop(id_search, context);
		removelayer('PM_ASearchLayerResult');
	});
	// Make animation separately, because callback function is exec two time if i USE $jqPm('body #center_column, body #PM_ASearchLayerResult') selector
	$jqPm('body #PM_ASearchLayerResult').animate({
		height : htmlResultsHeight + 'px'
	}, 450);
}
function showAsResponse(responseText, statusText, xhr, $form) {
	if (typeof(responseText.redirect_to_product) != 'undefined' && responseText.redirect_to_product != '') {
		if (window.history && window.history.replaceState && !(new String(window.location).match(new RegExp("&bfr:1", "g"))))
			window.history.replaceState({}, window.document.title, window.location + '&bfr:1');
		window.location = responseText.redirect_to_product;
		return;
	}
	var id_search = $form.find('input[name=id_search]').val();
	setTimeout(function () {
		changeHash(id_search);
	}, 250);
	var step_search = $form.find('input[name=step_search]').val();
	var hookName = $form.find('input[name=hookName]').val();
	if (typeof(responseText.html_block) != 'undefined' && responseText.html_block != ''&& responseText.html_block != null) {
		var htmlBlock = responseText.html_block;
		step_search = false;
	} else if (step_search) {
		var next_id_criterion_group = $form.find('input[name="next_id_criterion_group"]').val();
		var htmlBlock = responseText.html_criteria_block;
		setNextIdCriterionGroup(id_search, responseText.next_id_criterion_group);
	}
	var htmlResults = responseText.html_products;
	if (htmlBlock) {
		if (hookName == 'top') {
			if (!step_search) {
				$jqPm('#PM_ASBlockOutput_' + id_search).html(htmlBlock);
				removelayer('PM_ASearchLayerBlock');
			} else {
				var htmlBlockSelection = responseText.html_selection_block;
				if (htmlBlockSelection) {
					$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASSelectionsBlock').html(htmlBlockSelection);
				}
				$jqPm('#PM_ASCriterionsGroup_' + id_search + '_' + next_id_criterion_group).html(htmlBlock);
				removelayer('PM_ASearchLayerBlock');
			}
		} else {
			// Animation complete.
			if (!step_search) {
				$jqPm('#PM_ASBlockOutput_' + id_search).html(htmlBlock);
				removelayer('PM_ASearchLayerBlock');
			} else {
				var htmlBlockSelection = responseText.html_selection_block;
				if (htmlBlockSelection) {
					$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASSelectionsBlock').html(htmlBlockSelection);
				}
				$jqPm('#PM_ASCriterionsGroup_' + id_search + '_' + next_id_criterion_group).html(htmlBlock);
				removelayer('PM_ASearchLayerBlock');
			}
		}
	} else {
		removelayer('PM_ASearchLayerBlock');
	}
	if (htmlResults) {
		setResultsContents(id_search, htmlResults, 'showAsResponse');
	}
}
function initNotMulticriteriaElements() {
	$jqPm('.PM_ASNotMulticriteria').unbind('mousedown.eventNotMulticriteriaElements').bind('mousedown.eventNotMulticriteriaElements', function () {
		if ($jqPm(this).parents('li').hasClass('PM_ASCriterionDisable'))
			return;
		// For checkbox
		if ($jqPm(this).attr('type') == 'checkbox') {
			if (!$jqPm(this).attr('checked')) {
				var curIndex = $jqPm(this).parent('li').index();
				$jqPm(this).parent('li').parent('ul').find('li:not(:eq(' + curIndex + ')) > input[type=checkbox]').removeAttr('checked');
			}
		} else {
			if (!$jqPm(this).hasClass('PM_ASCriterionLinkSelected')) {
				var curIndex = $jqPm(this).parent('li').index();
				$jqPm(this).parent('li').parent('ul').find('li:eq(' + curIndex + ') > input[type=hidden]').attr('disabled', '');
				$jqPm(this).parent('li').parent('ul').find('li:not(:eq(' + curIndex + ')) > input[type=hidden]').attr('disabled', 'disabled');
				$jqPm(this).parent('li').parent('ul').find('li > a').removeClass('PM_ASCriterionLinkSelected');
			}
		}
	});
}
function initToogleBloc() {
	if ($jqPm('.PM_ASBlockOutputHorizontal').find('.PM_ASCriterionHide').length) {
		$jqPm('.PM_ASBlockOutputHorizontal').find('.PM_ASCriterionsGroup').each(function () {
			$jqPm(this).css('height', $jqPm(this).height());
			$jqPm(this).find('.PM_ASCriterionsOutput').css('position', 'absolute');
		});
	}
}
function initFormSearchBlocLink(id_search) {
	$jqPm(function () {
		$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASSelections').find('.PM_ASSelectionsRemoveLink').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
			$jqPm(this).next('input').attr('disabled', 'disabled');
			$jqPm(this).parents('form').ajaxSubmit(as4_getASFormOptions(id_search));
		});
	});
	$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASLabelLink').unbind('click').bind('click.eventFormSearchLink', function () {
		$(this).parent().trigger('click');
		return false;
	});
	$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASCriterionLink').unbind('click.eventFormSearchLink').bind('click.eventFormSearchLink', function () {
		var currentEl = $jqPm(this);

		var id_criterion_group = $jqPm(this).data('id-criterion-group');
		if (typeof(id_criterion_group) != 'undefined' && as4_getASParamsValue(id_search, 'seo_criterion_groups') != '' && as4_getASParamsValue(id_search, 'seo_criterion_groups').length > 0) {
			if ($jqPm.inArray(id_criterion_group, as4_getASParamsValue(id_search, 'seo_criterion_groups').split(',')) != -1) {
				return false;
			}
		}

		if ($jqPm(this).parents('li').hasClass('PM_ASCriterionDisable'))
			return false;
		if (!$jqPm(this).hasClass('PM_ASCriterionLinkSelected')) {
			$jqPm(this).next('input').removeAttr('disabled');
			setTimeout(function () {
				$jqPm(currentEl).addClass('PM_ASCriterionLinkSelected');
			}, 100);
		} else {
			$jqPm(this).next('input').attr('disabled', 'disabled');
			setTimeout(function () {
				$jqPm(currentEl).removeClass('PM_ASCriterionLinkSelected');
			}, 100);
		}
		return false;
	});
	$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASCriterionHideToogleClick a').click(function () {
		$jqPm(this).parents('.PM_ASCriterions').find('.PM_ASCriterionHide').slideToggle('fast');
		$jqPm(this).children('.PM_ASHide, .PM_ASShow').toggle();
	});
	$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASCriterionHideToogleHover').parents('.PM_ASCriterions').hoverIntent(function () {
		$jqPm(this).addClass('PM_ASCriterionGroupToogleHover');
		$jqPm(this).find('.PM_ASCriterionHide').stop().slideDown('fast');
	}, function() {
		$jqPm(this).removeClass('PM_ASCriterionGroupToogleHover');
		$jqPm(this).find('.PM_ASCriterionHide').stop().slideUp('fast', function() {
			$jqPm(this).parents('.PM_ASCriterions').removeClass('PM_ASCriterionGroupToogleHover');
		});
	});
}
function initFormSearchLink(id_search) {
	$jqPm(function () {
		$jqPm((as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column') + ' .PM_ASSelections').find('.PM_ASSelectionsRemoveLink').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
			$jqPm(this).next('input').attr('disabled', 'disabled');
			$jqPm(this).parents('form').ajaxSubmit(as4_getASFormOptions(id_search));
		});
	});

}
function nextStep(id_search, e, submit, search_method, dynamic_criterion) {
	
	/*
	if ($jqPm(e).parents('.PM_ASCriterionsGroup').next('.PM_ASShowCriterionsGroupHidden').length)
		var current_next_id_criterion_group_input = $jqPm(e).parents('.PM_ASCriterionsGroup').next('.PM_ASShowCriterionsGroupHidden').next('.PM_ASCriterionsGroup').find('input:disabled[name=current_id_criterion_group]');
	else
		var current_next_id_criterion_group_input = $jqPm(e).parents('.PM_ASCriterionsGroup').next('.PM_ASCriterionsGroup').find('input:disabled[name=current_id_criterion_group]');
	if ($jqPm(current_next_id_criterion_group_input).length) {
		$jqPm(e).parents('.PM_ASCriterionsGroup').nextAll('.PM_ASCriterionsGroup').children('.PM_ASCriterionsOutput').children('.PM_ASCriterions').children('.PM_ASCriterionsGroupOuter').children('.PM_ASCriterionStepEnable').html('').parent('.PM_ASCriterionsGroupOuter').children('.PM_ASCriterionStepDisable').show();
		$jqPm('#PM_ASForm_' + id_search).find('input[name="next_id_criterion_group"]').val($jqPm(current_next_id_criterion_group_input).val());
	}
	*/
	
	setTimeout(function () {
		if (search_method == 2) {
			$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormDynamicCriterionOptions(id_search));
		} else {
			$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormOptions(id_search));
		}
	}, 100);
}
// Get AS URL because it may be incorrectly formatted
function getAsAjaxUrl(curUrl) {
	var destUrl = curUrl;
	var asPathReg = new RegExp("(" + ASPath + ")", "g");
	if (!destUrl.match(asPathReg)) {
		var asQuery = curUrl.substring(curUrl.indexOf("?", 0));
		if (ASSearchUrl.indexOf("?", 0) != -1 && asQuery.indexOf("?", 0) == 0) {
			destUrl = ASSearchUrl + '&' + asQuery.substring(1, asQuery.length);
		} else {
			if (typeof(asQuery[0]) != 'undefined' && asQuery[0] == '?') {
				if (asQuery.indexOf("?", 1) != -1) {
					// Second ?, fix URL
					asQuery = asQuery.substring(0, asQuery.indexOf("?", 1)) + '&' + asQuery.substring(asQuery.indexOf("?", 1)+1, asQuery.length);
				}
			
			}
			destUrl = ASSearchUrl + asQuery;
		}
	}
	return destUrl;
}
function encodeAsParams(params) {
	var reg1 = new RegExp("=", "g");
	var reg2 = new RegExp("as4c\\[", "g");
	var reg3 = new RegExp("id_search:", "g");
	var reg4 = new RegExp("hookName:", "g");
	var reg5 = new RegExp("keep_category_information:", "g");
	var reg6 = new RegExp("orderby:", "g");
	var reg7 = new RegExp("orderway:", "g");
	var reg8 = new RegExp("id_category_search:", "g");
	var reg9 = new RegExp("as_price_range:", "g");
	var reg10 = new RegExp("id_manufacturer_search:", "g");
	var reg11 = new RegExp("id_supplier_search:", "g");
	var reg12 = new RegExp("as4c_hidden\\[", "g");
	var reg13 = new RegExp("reset_group:", "g");
	var reg14 = new RegExp("step_search:", "g");
	var reg15 = new RegExp("next_id_criterion_group:", "g");
	var reg16 = new RegExp("as4_base_selection:", "g");
	var reg17 = new RegExp("old_selected_criterion:", "g");
	var reg18 = new RegExp("bfr:", "g");

	params = params.replace(reg1, ':');
	params = params.replace(reg2, 's[');
	params = params.replace(reg3, 'sid:');
	params = params.replace(reg4, 'h:');
	params = params.replace(reg5, 'k:');
	params = params.replace(reg6, 'ob:');
	params = params.replace(reg7, 'ow:');
	params = params.replace(reg8, 'ics:');
	params = params.replace(reg9, 'pr:');
	params = params.replace(reg10, 'ims:');
	params = params.replace(reg11, 'iss:');
	params = params.replace(reg12, 'ash[');
	params = params.replace(reg13, 'rg:');
	params = params.replace(reg14, 'ss:');
	params = params.replace(reg15, 'nicg:');
	params = params.replace(reg16, 'abs:');
	params = params.replace(reg17, 'osc:');
	params = params.replace(reg18, 'bfr:');
	return params;
}
function decodeAsParams(params) {
	if (typeof(decodeURI) === 'function')
		params = decodeURI(params);
	var reg1 = new RegExp(":", "g");
	var reg2 = new RegExp("s\\[", "g");
	var reg3 = new RegExp("sid=", "g");
	var reg4 = new RegExp("^#", "g");
	var reg5 = new RegExp("&h=", "g");
	var reg6 = new RegExp("&k=", "g");
	var reg7 = new RegExp("&ob=", "g");
	var reg8 = new RegExp("&ow=", "g");
	var reg9 = new RegExp("&ics=", "g");
	var reg10 = new RegExp("&pr=", "g");
	var reg11 = new RegExp("&ims=", "g");
	var reg12 = new RegExp("&iss=", "g");
	var reg13 = new RegExp("&ash\\[", "g");
	var reg14 = new RegExp("&rg=", "g");
	var reg15 = new RegExp("&ss=", "g");
	var reg16 = new RegExp("&nicg=", "g");
	var reg17 = new RegExp("&abs=", "g");
	var reg18 = new RegExp("&osc=", "g");
	var reg19 = new RegExp("&bfr=", "g");

	params = params.replace(reg1, "=");
	params = params.replace(reg2, "as4c[");
	params = params.replace(reg3, "id_search=");
	params = params.replace(reg4, "");
	params = params.replace(reg5, '&hookName=');
	params = params.replace(reg6, '&keep_category_information=');
	params = params.replace(reg7, '&orderby=');
	params = params.replace(reg8, '&orderway=');
	params = params.replace(reg9, '&id_category_search=');
	params = params.replace(reg10, '&as_price_range=');
	params = params.replace(reg11, '&id_manufacturer_search=');
	params = params.replace(reg12, '&id_supplier_search=');
	params = params.replace(reg13, '&as4c_hidden[');
	params = params.replace(reg14, '&reset_group=');
	params = params.replace(reg15, '&step_search=');
	params = params.replace(reg16, '&next_id_criterion_group=');
	params = params.replace(reg17, '&as4_base_selection=');
	params = params.replace(reg18, '&old_selected_criterion=');
	params = params.replace(reg19, '&back_from_redirect=');

	return params;
}

function getFormSerialized(id_search) {
	return $jqPm('#PM_ASForm_' + id_search).serialize();
}

function initSearchBlock(id_search, search_method, step_search, dynamic_criterion) {
	if (typeof(ASHash[id_search]) == 'undefined') {
		var currentHash = decodeURIComponent(getFormSerialized(id_search));
		currentHash = encodeAsParams(currentHash);
		ASHash[id_search] = currentHash;
	}
	if (typeof(ASParams[id_search]) != 'undefined' && as4_getASParamsValue(id_search, 'stepSearch') == '') {
		ASParams[id_search].stepSearch = step_search;
	}

	$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASResetSearch').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
		var regIdBack = new RegExp("\#.*", "g");
		var backUrl = location.href.replace(regIdBack, '');
		$.ajax({
			type : "GET",
			url : ASSearchUrl,
			cache : false,
			data : ('resetSearchSelection=1&id_search=' + id_search + '&productFilterListData=' + as4_getASParamsValue(id_search, 'as4_productFilterListData') + '&productFilterListSource=' + as4_getASParamsValue(id_search, 'as4_productFilterListSource')),
			success : function (responseText) {
				location.href = backUrl;
			}
		});

	});
	if ($jqPm('.PM_ASSelectionsBlock .PM_ASSelectionsDropDownShowLink').length) {
		$jqPm('.PM_ASSelectionsBlock .PM_ASSelectionsDropDownShowLink').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
			$jqPm(this).next('.PM_ASSelectionsDropDownMenu').slideToggle('fast');
		});
	}

	$jqPm('#PM_ASForm_' + id_search + ' .PM_ASLabelLink').unbind('click').bind('click.eventInstantSearch', function () {
		$(this).parent().trigger('click');
		return false;
	});

	$jqPm('#PM_ASForm_' + id_search + ' .PM_ASCriterionLink').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
		if ($jqPm(this).parents('li').hasClass('PM_ASCriterionDisable'))
			return;

		var id_criterion_group = $jqPm(this).data('id-criterion-group');
		if (typeof(id_criterion_group) != 'undefined' && as4_getASParamsValue(id_search, 'seo_criterion_groups') != '' && as4_getASParamsValue(id_search, 'seo_criterion_groups').length > 0) {
			if ($jqPm.inArray(id_criterion_group, as4_getASParamsValue(id_search, 'seo_criterion_groups').split(',')) != -1) {
				return;
			}
		}

		if (step_search) {
			nextStep(id_search, $jqPm(this), null, search_method);
		} else {
			if (search_method == 1) {
				setTimeout(function () {
					$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormOptions(id_search));
				}, 100);
			} else if (search_method == 2 && dynamic_criterion) {
				setTimeout(function () {
					$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormDynamicCriterionOptions(id_search));
				}, 100);
			}
		}
	});
	$jqPm('#PM_ASForm_' + id_search + ' .PM_ASCriterionGroupSelect').unbind('change.eventInstantSearch').bind('change.eventInstantSearch', function () {
		if (step_search) {
			nextStep(id_search, $jqPm(this), null, search_method);
		} else {
			if (search_method == 1) {
				setTimeout(function () {
					$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormOptions(id_search));
				}, 100);
			} else if (search_method == 2 && dynamic_criterion) {
				setTimeout(function () {
					$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormDynamicCriterionOptions(id_search));
				}, 100);
			}
		}
	});
	$jqPm('#PM_ASForm_' + id_search + ' .PM_ASCriterionCheckbox').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
		if (step_search) {
			nextStep(id_search, $jqPm(this), null, search_method);
		} else {
			// Instant search
			if (search_method == 1) {
				setTimeout(function () {
					$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormOptions(id_search));
				}, 100);
			} else if (search_method == 2 && dynamic_criterion) {
				setTimeout(function () {
					$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormDynamicCriterionOptions(id_search));
				}, 100);
			}
		}
	});
	// Reset criterions group
	// PM_ASResetGroup
	$jqPm('#PM_ASForm_' + id_search + ' .PM_ASResetGroup').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
		var id_criterion_group = $jqPm(this).attr('rel');
		$jqPm('#PM_ASForm_' + id_search + ' input[name=reset_group]').val(id_criterion_group);
		if (search_method == 1) {
			setTimeout(function () {
				$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormOptions(id_search));
			}, 100);
		} else if (search_method == 2) {
			setTimeout(function () {
				$jqPm('#PM_ASForm_' + id_search).ajaxSubmit(as4_getASFormDynamicCriterionOptions(id_search));
			}, 100);
		}
	});

	/*Collapse criteria group*/
	$jqPm('#PM_ASForm_' + id_search + ' .PM_ASCriterionsGroupCollapsable').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
		var id_criterion_group = $jqPm(this).attr('rel');

		if ($jqPm(this).parent('.PM_ASCriterions').find('.PM_ASCriterionsGroupOuter:visible').length)
			$jqPm('#PM_ASCriterionsGroupTitle_' + id_search + '_' + id_criterion_group + '.PM_ASCriterionsGroupCollapsable').removeClass('PM_ASCriterionsArrowDown').addClass('PM_ASCriterionsArrowleft');
		else
			$jqPm('#PM_ASCriterionsGroupTitle_' + id_search + '_' + id_criterion_group + '.PM_ASCriterionsGroupCollapsable').removeClass('PM_ASCriterionsArrowleft').addClass('PM_ASCriterionsArrowDown');

		$jqPm(this).parent('.PM_ASCriterions').find('.PM_ASCriterionsGroupOuter').slideToggle('fast', function () {
			// Ajax request for saving state
			$.ajax({
				type : "GET",
				url : ASSearchUrl,
				cache : false,
				data : ('setCollapseGroup=1&id_criterion_group=' + id_criterion_group + '&id_search=' + id_search + '&state=' + $jqPm(this).parent('.PM_ASCriterions').find('.PM_ASCriterionsGroupOuter:visible').length + '&productFilterListData=' + as4_getASParamsValue(id_search, 'as4_productFilterListData') + '&productFilterListSource=' + as4_getASParamsValue(id_search, 'as4_productFilterListSource'))
			});
		});
		$jqPm(this).parent('.PM_ASCriterions').find('.PM_ASResetGroup').toggle();
	});

	// Show advanced Search
	$jqPm('#PM_ASForm_' + id_search + ' .PM_ASShowCriterionsGroupHidden a').unbind('click.eventInstantSearch').bind('click.eventInstantSearch', function () {
		var e = $jqPm(this);
		$.ajax({
			type : "GET",
			url : ASSearchUrl,
			cache : false,
			data : ('setHideCriterionStatus=1&id_search=' + id_search + '&state=' + $jqPm(e).parent('.PM_ASShowCriterionsGroupHidden').next('.PM_ASCriterionsGroupHidden:hidden').length + '&productFilterListData=' + as4_getASParamsValue(id_search, 'as4_productFilterListData') + '&productFilterListSource=' + as4_getASParamsValue(id_search, 'as4_productFilterListSource')),
			success : function (responseText) {
				$jqPm(e).parent('.PM_ASShowCriterionsGroupHidden').nextAll('.PM_ASCriterionsGroupHidden').slideToggle('fast');
			}
		});
	});
	// Submit search
	if (search_method == 2) {
		$jqPm('#PM_ASForm_' + id_search).ajaxForm(as4_getASFormOptions(id_search));
	}
	initNotMulticriteriaElements();
	initToogleBloc();
	initFormSearchBlocLink(id_search);
	as4_searchResponseCallback();
}

// Set Next Id Criterion Group when step_search is on
function setNextIdCriterionGroup(id_search, next_id_criterion_group) {
	var input_next_id_criterion_group = $jqPm('#PM_ASBlock_' + id_search).find('input[name="next_id_criterion_group"]');
	$jqPm(input_next_id_criterion_group).val(next_id_criterion_group);
}

// Clean duplicate parameters
function cleanAjaxDuplicateParams(destUrl, params) {
	var hasDuplicateValues = true;
	var paramsSplit = params.split('&');
	var destUrlSplit = destUrl.split('&');
	var i = 0;
	while (hasDuplicateValues) {
		hasDuplicateValues = false;
		var paramsListDestUrl = new Array();
		$jqPm.each(destUrlSplit, function (index, value) {
			if (typeof(value) != 'undefined') {
				if ($jqPm.inArray(value, paramsSplit) != -1 || $jqPm.inArray(value, paramsListDestUrl) != -1) {
					destUrlSplit.splice(index, 1);
					hasDuplicateValues = true;
				} else {
					paramsListDestUrl.push(value);
				}
			}
		});
		i++;
		if (i == 10) break;
	}
	return destUrlSplit.join('&');
}

function as4_getFormVariableValue(id_search, field_name) {
	return $jqPm('#PM_ASForm_' + id_search + ' [name="' + field_name + '"]').val();
}

function initSearch(id_search, search_method, step_search, dynamic_criterion) {
	if ($jqPm('#PM_ASearchResults .pagination a').length) {
		$jqPm('#PM_ASearchResults .pagination a').unbind('click.eventSearchLink').bind('click.eventSearchLink', function () {
			// Pagination change
			var finalDestUrl = ASSearchUrl;
			setlayer('body', (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column'), 'PM_ASearchLayerResult', 'PM_ASearchLayerResult');
			var destUrl = getAsAjaxUrl($jqPm(this).attr('href'));
			var asExtraParamsReg = new RegExp("&p=[0-9]+|&orderby=[a-z]+|&orderway=[a-z]+|&n=[0-9]+", "g");
			var nextExtraParams = destUrl.match(asExtraParamsReg);
			if (nextExtraParams) {
				if (ASSearchUrl.indexOf("?", 0) != -1) {
					var finalDestUrl = ASSearchUrl + '&' + nextExtraParams.join('').substring(1);
				} else {
					var finalDestUrl = ASSearchUrl + '?' + nextExtraParams.join('').substring(1);
				}
				setTimeout(function () {
					changeHash(id_search, nextExtraParams.join('').substring(1));
				}, 250);
			}
			finalDestUrl = cleanAjaxDuplicateParams(finalDestUrl, (getFormSerialized(id_search) + '&only_products=1&ajaxMode=1'));
			$.ajax({
				type : "GET",
				url : finalDestUrl,
				cache : false,
				data : (getFormSerialized(id_search) + '&only_products=1&ajaxMode=1&productFilterListData=' + as4_getASParamsValue(id_search, 'as4_productFilterListData') + '&productFilterListSource=' + as4_getASParamsValue(id_search, 'as4_productFilterListSource')),
				mode : 'abort',
				dataType : 'json',
				port : 'asSearch',
				success : function (responseText) {
					var htmlResults = responseText.html_products;
					setNextIdCriterionGroup(id_search, responseText.next_id_criterion_group);
					setResultsContents(id_search, htmlResults, 'pagination');
				}
			});
			return false;
		});
	}
	if ($jqPm('#PM_ASearchResults form#productsSortForm select, #PM_ASearchResults form.productsSortForm select').length) {
		// Product sort
		if (pm_version_compare(ASPSVersion, '1.4.3', '>=')) {
			$(document).ready(function () {
				$('#selectPrductSort, #selectProductSort, .selectPrductSort').unbind('change');
			});
		}
		$jqPm('#PM_ASearchResults form#productsSortForm select, #PM_ASearchResults form.productsSortForm select').removeAttr('onchange').unbind('change.eventSearchLink').bind('change.eventSearchLink', function () {
			var finalDestUrl = ASSearchUrl;
			setlayer('body', (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column'), 'PM_ASearchLayerResult', 'PM_ASearchLayerResult');
			var asRegCheckSortMethod = new RegExp("name:|price:|quantity:|reference:", "g");
			var isNewSortMethod = $(this).val().match(asRegCheckSortMethod);
			if (!isNewSortMethod)
				var destUrl = getAsAjaxUrl($jqPm(this).val());
			else {
				var destBaseUrl = getAsAjaxUrl($jqPm('#PM_ASearchResults form#productsSortForm, #PM_ASearchResults form.productsSortForm').attr('action'));
				var splitData = $(this).val().split(':');
				var destUrl = destBaseUrl + ((destBaseUrl.indexOf('?') < 0) ? '?' : '&') + 'orderby=' + splitData[0] + '&orderway=' + splitData[1];
			}
			// Set order by for next search
			var regOrderBy = new RegExp("&orderby=[a-z]+", "g");
			var orderby = regOrderBy.exec(destUrl);
			if (orderby) {
				orderby = orderby.toString().substring(9);
				$jqPm('#PM_ASBlockOutput_' + id_search + ' input[name=orderby]').val(orderby).attr('disabled', '').removeAttr('disabled');
			}
			// Set order way for next search
			var regOrderWay = new RegExp("&orderway=[a-z]+", "g");
			var orderway = regOrderWay.exec(destUrl);
			if (orderway) {
				orderway = orderway.toString().substring(10);
				$jqPm('#PM_ASBlockOutput_' + id_search + ' input[name=orderway]').val(orderway).attr('disabled', '').removeAttr('disabled');
			}
			var asExtraParamsReg = new RegExp("&orderby=[a-z]+|&orderway=[a-z]+|&n=[0-9]+", "g");
			var nextExtraParams = destUrl.match(asExtraParamsReg);
			if (nextExtraParams) {
				if (ASSearchUrl.indexOf("?", 0) != -1) {
					var finalDestUrl = ASSearchUrl + '&' + nextExtraParams.join('').substring(1);
				} else {
					var finalDestUrl = ASSearchUrl + '?' + nextExtraParams.join('').substring(1);
				}
				setTimeout(function () {
					changeHash(id_search, nextExtraParams.join('').substring(1));
				}, 250);
			}
			finalDestUrl = cleanAjaxDuplicateParams(finalDestUrl, (getFormSerialized(id_search) + '&only_products=1&ajaxMode=1'));
			$.ajax({
				type : "GET",
				url : finalDestUrl,
				cache : false,
				data : (getFormSerialized(id_search) + '&only_products=1&ajaxMode=1&productFilterListData=' + as4_getASParamsValue(id_search, 'as4_productFilterListData') + '&productFilterListSource=' + as4_getASParamsValue(id_search, 'as4_productFilterListSource')),
				mode : 'abort',
				dataType : 'json',
				port : 'asSearch',
				success : function (responseText) {
					var htmlResults = responseText.html_products;
					setNextIdCriterionGroup(id_search, responseText.next_id_criterion_group);
					setResultsContents(id_search, htmlResults, 'order_by');
				}
			});
			return false;
		});
	}
	if ($('#PM_ASearchResults form.pagination, #PM_ASearchResults form.showall, #PM_ASearchResults form.nbrItemPage').length) {
		$.each(['#PM_ASearchResults form.pagination #nb_item', '#PM_ASearchResults form.nbrItemPage #nb_item'], function (i, selector) {
			if (typeof($(selector).attr('onchange')) != 'undefined' && $(selector).attr('onchange') != '') {
				$(selector).removeAttr('onchange');
				$(selector).unbind('change').unbind('change.eventSearchLink').bind('change.eventSearchLink', function () {
					if (typeof($(this).form) != 'undefined')
						$($(this).form).trigger('submit.eventSearchLink');
					else if (typeof($(this).parents('form:first')) != 'undefined')
						$(this).parents('form:first').trigger('submit.eventSearchLink');
					else if (typeof($(this).closest('form')) != 'undefined')
						$(this).closest('form').trigger('submit.eventSearchLink');
					return false;
				});
			}
		});
		$('#PM_ASearchResults form.pagination, #PM_ASearchResults form.showall, #PM_ASearchResults form.nbrItemPage').bind('submit.eventSearchLink', function () {
			setlayer('body', (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column'), 'PM_ASearchLayerResult', 'PM_ASearchLayerResult');
			var curN = $jqPm(this).find('#nb_item').val();
			var asExtraParamsReg = new RegExp("&orderby=[a-z]+|&orderway=[a-z]+", "g");
			var nextExtraParams = $jqPm('#nb_item').parents('form').serialize().match(asExtraParamsReg);

			var asSerializeDatas = getFormSerialized(id_search);

			var asMatchIdSearchReg = new RegExp("id_search|id_seo_id_search", "g");
			if (!asSerializeDatas.match(asMatchIdSearchReg)) {
				asSerializeDatas = $jqPm(this).serialize();
			}

			setTimeout(function () {
				if (nextExtraParams) {
					changeHash(id_search, 'n=' + curN + nextExtraParams.join(''));
				} else
					changeHash(id_search, 'n=' + curN);
			}, 250);

			// Set N for next search
			if (curN) {
				$jqPm('#PM_ASBlockOutput_' + id_search + ' input[name=n]').val(curN).attr('disabled', '').removeAttr('disabled');
			}
			$.ajax({
				type : "GET",
				url : ASSearchUrl,
				cache : false,
				data : (asSerializeDatas + '&only_products=1&ajaxMode=1&n=' + curN + '&productFilterListData=' + as4_getASParamsValue(id_search, 'as4_productFilterListData') + '&productFilterListSource=' + as4_getASParamsValue(id_search, 'as4_productFilterListSource')),
				mode : 'abort',
				dataType : 'json',
				port : 'asSearch',
				success : function (responseText) {
					var htmlResults = responseText.html_products;
					setNextIdCriterionGroup(id_search, responseText.next_id_criterion_group);
					setResultsContents(id_search, htmlResults, 'pagination');
				}
			});
			return false;
		});
	}

	// Display share block
	if ($jqPm('#PM_ASearchResults a#pm_share_link').length) {
		$jqPm('#PM_ASearchResults a#pm_share_link').unbind('click.eventSearchLink').bind('click.eventSearchLink', function () {
			if ($jqPm('#asShareBlock:hidden').length) {
				var share_ASSearchUrl = window.location.toString();
				var share_ASSearchTitle = $jqPm('#PM_ASearchResults input#ASSearchTitle').val();
				$jqPm('#asShareBlock').load(ASSearchUrl, {
					'ASSearchUrl' : share_ASSearchUrl,
					'getShareBlock' : 1,
					'ASSearchTitle' : share_ASSearchTitle
				}, function () {
					$jqPm(this).slideDown('fast');
				});
			}
		});
	}
	
	as4_searchResponseCallback()
	initFormSearchLink(id_search);
}
function changeHash(id_search, addParam) {
	var newAnchorUrl = decodeURIComponent(getFormSerialized(id_search));
	if (typeof(addParam) != 'undefined') {
		newAnchorUrl = newAnchorUrl + '&' + addParam;
	}
	newAnchorUrl = cleanAjaxDuplicateParams(newAnchorUrl, '');
	
	newAnchorUrl = '#' + encodeAsParams(newAnchorUrl);
	hashChangeBusy = true;
	$jqPm.bbq.pushState(newAnchorUrl);
	
	setTimeout(function () {
		hashChangeBusy = false;
	}, 250);
}
function asLaunchHash(currentHash) {
	var regIdSearch = new RegExp("sid:[0-9]+", "g");
	var id_search = currentHash.match(regIdSearch);
	var regIdSearch2 = new RegExp("sid:", "g");
	if (id_search) {
		id_search = id_search[0].replace(regIdSearch2, '');
		currentHash = decodeAsParams(currentHash);
		setlayer('body', (as4_getASParamsValue(id_search, 'search_results_selector') != '' ? as4_getASParamsValue(id_search, 'search_results_selector') : '#center_column'), 'PM_ASearchLayerResult', 'PM_ASearchLayerResult');
		setlayer('body', '#PM_ASBlockOutput_' + id_search, 'PM_ASearchLayerBlock', 'PM_ASearchLayerBlock');
		$.ajax({
			type : "GET",
			url : ASSearchUrl,
			cache : false,
			data : currentHash + '&ajaxMode=1&productFilterListData=' + as4_getASParamsValue(id_search, 'as4_productFilterListData') + '&productFilterListSource=' + as4_getASParamsValue(id_search, 'as4_productFilterListSource'),
			mode : 'abort',
			dataType : 'json',
			port : 'asSearch',
			success : function (responseText) {
				if (typeof(responseText.redirect_to_product) != 'undefined' && responseText.redirect_to_product != '') {
					if (window.history && window.history.replaceState && !currentHash.match(new RegExp("&bfr:1", "g")))
						window.history.replaceState({}, window.document.title, window.location + '&bfr:1');
					window.location = responseText.redirect_to_product;
					return;
				}
				var htmlResults = responseText.html_products;
				setNextIdCriterionGroup(id_search, responseText.next_id_criterion_group);
				setResultsContents(id_search, htmlResults, 'asLaunchHash');
				
				if (typeof(responseText.html_block) != 'undefined' && responseText.html_block != ''&& responseText.html_block != null) {
					var htmlBlock = responseText.html_block;
					var htmlBlockSelection = responseText.html_selection_block;
					if (htmlBlockSelection) {
						$jqPm('#PM_ASBlock_' + id_search + ' .PM_ASSelectionsBlock').html(htmlBlockSelection);
					} else {
						$jqPm('#PM_ASBlock_' + id_search).replaceWith(htmlBlock);
					}
				} else if (typeof(responseText.html_criteria_block) != 'undefined' && responseText.html_criteria_block != '') {
					var next_id_criterion_group = $jqPm('#PM_ASBlock_' + id_search).find('input[name=next_id_criterion_group]').val();
					var htmlBlock = responseText.html_criteria_block;
					$jqPm('#PM_ASCriterionsGroup_' + id_search + '_' + next_id_criterion_group).html(htmlBlock);
				}
				
				as4_searchResponseCallback();
				// $jqPm('#PM_ASBlockOutput_'+id_search).html(htmlBlock);
				removelayer('PM_ASearchLayerBlock');
			}
		});
	} else {
		location.href = location.href;
		return;
	}
}
function asInitAsHashChange() {
	$jqPm(window).hashchange(function () {
		if (hashChangeBusy)
			return;
		var currentHash = document.location.hash;
		asLaunchHash(currentHash);
	});
	$jqPm.observeHashChange({
		interval : 250
	});
	$(function () {
		var currentUrl = document.location.toString();
		if (currentUrl.match('#')) {
			var currentHash = currentUrl.split('#')[1];
			asLaunchHash(currentHash);
		}
	});
}

function as4_moveFormContainerForSEOPages() {
	if (typeof($jqPm('div#PM_ASFormContainerHidden')) != 'undefined' && $jqPm('div#PM_ASFormContainerHidden').size() > 0) {
		var element_parent = $jqPm('div#PM_ASFormContainerHidden').parent().parent();
		if (typeof(element_parent) != 'undefined' && $jqPm(element).size() > 0) {
			var element = $jqPm('div#PM_ASFormContainerHidden').detach();
			$jqPm(element_parent).append(element);
		}
	}
}

function as4_searchResponseCallback() {
	//Override button add to cart from results
	if ($jqPm('#PM_ASearchResults').length) {
		if (typeof initAp4CartLink == 'function') initAp4CartLink();
		if (typeof(ajaxCart) != 'undefined') ajaxCart.overrideButtonsInThePage();
		if (typeof(modalAjaxCart) != 'undefined') modalAjaxCart.overrideButtonsInThePage();
		// Init PS 1.6 theme default behaviour
		if (typeof(display) != 'undefined' && display instanceof Function) {
			var view = $.totalStorage('display');
			if (typeof(view) != 'undefined' && view)
				display(view);
			if (typeof(blockHover) != 'undefined' && blockHover instanceof Function)
				blockHover();
			$('#grid').click(function(e){
				e.preventDefault();
				display('grid');
			});
			$('#list').click(function(e){
				e.preventDefault();
				display('list');
			});
		}
		// /Init PS 1.6 theme default behaviour
	}
	$(document).ready(function () {
		if (typeof($.uniform) != 'undefined') {
			$(document).on('click', '.PM_ASBlockOutput .title_block', function(e) {
				$.uniform.update(".PM_ASBlockOutput select.form-control");
			});
			if ($('.PM_ASBlockOutput').length) {
				// Init PS 1.6 theme default behaviour
				$("select.form-control,input[type='checkbox']:not(.comparator), input[type='radio']").uniform();
				// /Init PS 1.6 theme default behaviour
			}
		}
	});
}