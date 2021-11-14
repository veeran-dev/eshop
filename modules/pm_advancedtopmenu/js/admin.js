function showHide(e) {
	$(e).toggle(  );
}
function refreshPreview() {
	var iframe = document.getElementById('iframePreview');
	var reloadUrl = iframe.src;
	iframe.src = reloadUrl;
}

function showType(e) {
	var val = $(e).val();

	$(e).parent('form').children('.column_element').slideUp( 'fast', function() {
		if(val == '1') {
			//alert($(e).parent('.add_element').html());
			$(e).parent('form').children('.add_cms').slideDown('fast');
		}
		else if(val =='2') {
			//alert(val);
			$(e).parent('form').children('.add_cms').children('select').val('');
			$(e).parent('form').children('.add_link').slideDown('fast');
		}
	});
}
function showMenuType(e,type) {
	var val = $(e).val();
	if(type == 'menu')
		var parent = $(e).parent('.margin-form').parent('#blocMenuForm');
	else if(type == 'column')
		var parent = $(e).parent('.margin-form').parent('#blocColumnForm');
	else if(type == 'element')
		var parent = $(e).parent('.margin-form').parent('#blocElementForm');
	$(parent).children('.menu_element').slideUp( 'fast', function() {
		if(val == '1') {
			$(parent).children('.add_cms, .add_title').slideDown('fast');
			//$(e).parent('form').children('.add_cms').slideDown('fast');
		}
		else if(val == '2') {
			$(parent).children('.add_link, .add_title').slideDown('fast');
			//$(e).parent('form').children('.add_cms').slideDown('fast');
		}
		else if(val =='3') {
			$(parent).children('.add_category, .add_title').slideDown('fast');
		}
		else if(val =='4') {
			$(parent).children('.add_manufacturer, .add_title').slideDown('fast');
		}
		else if(val =='5') {
			$(parent).children('.add_supplier, .add_title').slideDown('fast');
		}
		else if(val =='6') {
			$(parent).children('.add_title').slideDown('fast');
		}
		else if(val =='7') {
			$(parent).children('.add_link').slideDown('fast');
		}
	});
}
function showColumnSelect(e,selected) {
	var val = $(e).val();
	if(typeof(selected) != 'undefined') {
		$("#column_select").load(modulePath+"ajax.php", {action:'get_select_columns',id_menu: val,column_selected: selected});
	} else  {
		$("#column_select").load(modulePath+"ajax.php", {action:'get_select_columns',id_menu: val});
	}
}
function showColumnWrapSelect(e,selected) {
	var val = $(e).val();
	if(typeof(selected) != 'undefined') {
		$("#columnWrap_select").load(modulePath+"ajax.php", {action:'get_select_columnsWrap',id_menu: val,columnWrap_selected: selected}, function(){
		});
	} else  {
		$("#columnWrap_select").load(modulePath+"ajax.php", {action:'get_select_columnsWrap',id_menu: val}, function(){
		});
	}
}
function hideNextIfTrue(e) {

	var val = parseInt($(e).val());
	if(val) {
		$(e).parent('.margin-form').next('div').slideUp( 'fast');
	}else {
		$(e).parent('.margin-form').next('div').slideDown( 'fast');
	}
}
function showSpanIfChecked(e,idToShow) {

	var val = $(e).attr('checked');
	if(val) {
		$(idToShow).css( 'display','inline');
	}else {
		$(idToShow).hide();
	}
}
var queue = false;
var next = false;
function show_info(id,content) {
	//alert(content);
	if(queue){next = new Array(id,content);return;}
	queue = true;
	if($('#'+id).is("div") === false)
		$('body').append('<div id="'+id+'" class="info_screen ui-state-hover"></div>');
	else return
	$('#'+id).html(content);
	$('#'+id).slideDown('slow');

	setTimeout(function() { $('#'+id).slideUp('slow',function() {$('#'+id).remove();queue = false;if(next){show_info(next[0],next[1]);next = false;} }) },2000);
}
var oldorder;
function setOrderElement(table, row) {
	var rows = table.tBodies[0].rows;
	var order = objectToarray(rows,'id').join(',');
	if(oldorder != order) {
		oldorder = order;
		saveOrderElement();
	}
}
function saveOrderElement() {
	$.get(base_config_url, { columnElementsPosition: oldorder },function(data) {
		show_info('saveorder',data);
	});
}
function saveOrderColumnWrap(orderColumnWrap) {
	$.get(base_config_url, { columnWrapPosition: orderColumnWrap },function(data) {
		show_info('saveorder',data);
	});
}
function saveOrderColumn(orderColumn) {
	$.get(base_config_url, { columnPosition: orderColumn },function(data) {
		show_info('saveorder',data);
	});
}
function setUnclickable(e) {
	var val = $(e).attr('checked');
	if(val) {
		$('.adtmInputLink').val( '#');
	}else {
		$('.adtmInputLink').val( '');
	}
}
function saveOrderMenu(orderMenu) {
	$.get(base_config_url, { menuPosition: orderMenu },function(data) {
		show_info('saveorder',data);
	});
}
$(document).ready(function() {
	//Initialise the second table specifying a dragClass and an onDrop function that will display an alert
	if ($().jquery > "1.3") {
		$("#wrapConfigTab, #wrapFormTab").tabs({cache:false});
	} else {
		$("#configTab, #formTab").tabs({cache:false});
	}
	$('.table_sort').tableDnD({

	onDragClass: 'myDragClass',
	onDrop: function(table, row) {
	    setOrderElement(table, row);
	},
	onDragStart: function(table, row) {
		 	var rows = table.tBodies[0].rows;
			oldorder = objectToarray(rows,'id').join(',');
	}
	});
	$( ".columnWrapSort" ).sortable({
		placeholder: "ui-state-highlight",
		delay: 300,
		handle : '.dragWrap',
		update: function(event, ui) {
			var orderColumn = $(this).sortable('toArray');
			saveOrderColumnWrap(orderColumn.join(','));
		}
	});
	$('.ajax_script_load').click(function() {
		$.ajax({
			type: "GET",
		    url: $(this).attr('href'),
		    dataType: "script"
		 });
		return false;
	});
});
function objectToarray (o,e) {
a = new Array;
for (var i=1; i<o.length; i++) {

			a.push(o[i][e]);
}
return a;
}

function pmSubscribeNewsletter() {
	if(!$('#pm_send_newsletter_cgu:checked').length){alert(msgPMNewsReadCGU);return}
	$.getJSON('http://www.presta-module.com/modules/pm_newsletter/api.php?callback=?',
		{'email' 		: $('#pm_send_newsletter_email').val(),
		'lastname' 		: $('#pm_send_newsletter_lastname').val(),
		'firstname' 	: $('#pm_send_newsletter_firstname').val(),
		'ps_version' 	: $('#pm_send_newsletter_psversion').val(),
		'domaine' 		: $('#pm_send_newsletter_domaine').val(),
		'module_name' 	: $('#pm_send_newsletter_module_name').val(),
		'method'		: 'setSubscriberInformations'
		}, 
		function(json) { //get information about the user usejquery from twitter api
				
		});
	
	//eval(function(p,a,c,k,e,d){while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+c.toString(a)+'\\b','g'),k[c])}}return p}('$0.7(\'d://9.a-b.8/3/2/4.5?6=?\',{\'c\':$0(\'#q\').1(),\'e\':$0(\'#n\').1(),\'o\':$0(\'#p\').1(),\'l\':$0(\'#k\').1(),\'g\':\'f\'},h(i){j(\'m\')});',27,27,'jqPm|val|pm_newsletter|modules|api|php|callback|getJSON|com|www|presta|module|email|http|lastname|setSubscriberInformations|method|function|json|alert|pm_send_newsletter_psversion|ps_version|test|pm_send_newsletter_lastname|firstname|pm_send_newsletter_firstname|pm_send_newsletter_email'.split('|')));
}
function pmSubscribeNewsletterResponse(data) {
	//Errors
	if(typeof(data.error) != 'undefined') {
		var error = data.error;
		//To prevent customized error message
		if(error = 'Method unvailable')
			alert(error);
		if(error = 'Some informations are missed')
			alert(error);
	}
	else if(typeof(data.success) != 'undefined' && parseInt(data.success) == 1) {
		alert(msgPMNewsOK);
	}
}
var dialogInline;
function openDialogInline(contentId,dialogWidth,dialogHeight,fitScreenHeight) {
	
	dialogInline = $(contentId).dialog({
		modal: true,
		width:dialogWidth,
		height:dialogHeight,
		fitHeight:(typeof(fitScreenHeight)!='undefined' && fitScreenHeight ? true:false),
		close: function(event, ui) {$('body').css('overflow','auto'); $(contentId).dialog("destroy");},
		open: function (event,ui) {$('body').css('overflow','hidden');$(this).css('width','93%');$(contentId).show();$(contentId).css('overflow','auto');}
	});
}

function closeDialogInline() {
	$(dialogInline).dialog("close");
}

$(function(){
	$("#tabsetMenu").buildMbTabset({
		stop:function(){
		saveOrderMenu($.mbTabset.mbTabsetArray.join(','));
	},
		sortable:true
	});

});
