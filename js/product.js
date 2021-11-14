
//**************************************************************
// jQZoom allows you to realize a small magnifier window,close
// to the image or images on your web page easily.
//
// jqZoom version 1.2
// Author Doc. Ing. Renzi Marco(www.mind-projects.it)
// Released on Dec 05 2007
// i'm searching for a job,pick me up!!!
// mail: renzi.mrc@gmail.com
//**************************************************************

	function addToRateContract(idList)
{
	var name=$("#"+idList).val();
$.ajax({
         type: "post",
         url: baseDir+"addtorate.php",
         data:{id_product:id_product,id_customer:id_customer,purchaseListId:idList},
		 success: function(data) //this function to be called if the request succeeds
		 {
  			 if(data==1)
			 {
				 $('#fancybox-content').html("");
				  $('#fancybox-content').css({'color':'green','font-size':'18px'});
				 $('#fancybox-content').html("Item added to the "+name+" list");
				// $("#fancybox-message").html("");
			//	 $("#fancybox-message").html(" Item added to the "+name+" list");
		//	 alert(" Item added to the list");
//		$("#fancybox-close").click();
		$("#corporate-user-add-to-list"+id_product).remove();
//		alert(" Item added to the "+name+" list");
			 }
		 	if(data=="false")
			{
				$("#fancybox-message").html("");
				 $("#fancybox-message").html("Item already exist in  the "+name+" list");
		//	alert(" Item already exist in this list");
			}
		 }
		});
		}
function showList(listNames)
{
		for(var j=0;j<listNames.length;j++)
		{
		
		$('#fancybox-content').append(listNames[j]);
		}
		$('#fancybox-content').append("<div id='fancybox-message'></div>");

}
$(document).ready(function() {
	var type=6;
	var dataparam = '&customer_email=' + customer_email+'&type='+type;
  	$.ajax({
			type: 'POST',
				/*dataType:'json',*/
				async: true,
				url: baseDir+'dash-PurchaseList.php',
				data: dataparam,
				cache: true,
				success: function(data)
				{
					if(data == 3)
					{
						var type=3;
						var dataparam = '&id_customer=' + id_customer+'&type='+type;
						$.ajax({
								type: 'GET',
									dataType:'json',
									async: true,
									url: baseDir+'dash-PurchaseList.php',
									data: dataparam,
									cache: true,
									success: function(data)
									{
										window.listNames=Array();
										for(var i=0;i<data.length;i++)
										{
										var list= '<div class="add-to-list-options"><img class="add-to-list-options-img" src='+baseDir+'img/checklist.png style=" float:left;" ><input style=" float:left;" class="add-to-list-input" type="button" onClick="addToRateContract('+data[i].id_list+');" id='+data[i].id_list+' value="'+data[i].listname+'"></div>';
										listNames.push(list)
										}
									}
							  });
					}
				}
			
	});
			
			
	$("a.corporate-user-add-to-list").fancybox({
		
	onComplete: function(){
		$("#fancybox-error").html("");
		$("#fancybox-error").addClass("fancybox-error-override");
		$("#fancybox-error").html("Choose Your List");
			showList(listNames);
	}
	});
	$("a.stock-availability-view-more").click(function(){
		var x=$("#"+(this.id)).offset();
		var y=$("#"+(this.id)).width();
		
	 	$("#stock-display").css({top: x.top, left: x.left-170});
		$("#stock-display").show();
	 });
	 $('#stock-display-close').click(function(){$('#stock-display').hide();});
	 
	$("a#but_bulk_enq").fancybox({
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'onClosed'   : function() {
				if($('#bq_complete').css('display') == 'block')
				{
					$('#bq_complete').hide();
					$('#bg-get-details').show();
					$('#bq_product_form').trigger("reset");
					var current_width = 500;
					parent.$('#fancybox-outer').width(current_width + 25);
					parent.$('#fancybox-wrap').width(current_width + 25);
					parent.$('#fancybox-content').width(current_width + 25);
					parent.$('.fancybox-inner').width(current_width + 25);
					
					$.fancybox.resize();
				}
			}
	});	
});
(function($) {
		$.fn.jqueryzoom = function(options) {
			var settings = {
				xzoom: 200,			//zoomed width default width
				yzoom: 200,			//zoomed div default width
				offset: 10,			//zoomed div default offset
				position: "right"	//zoomed div default position,offset position is to the right of the image
			};

			if(options)
				$.extend(settings, options);

			var noalt ='';

			$(this).hover(function() {
				var imageRelativeLeft = $(this).get(0).offsetLeft;
				var imageLeft = $($(this).get(0)).offset().left;
				var imageRelativeTop =  $(this).get(0).offsetTop;
				var imageTop = $($(this).get(0)).offset().top;
				var imageWidth = $(this).get(0).offsetWidth;
				var imageHeight = $(this).get(0).offsetHeight;

				noalt = $(this).attr("alt");
				var bigimage = noalt;
				$(this).attr("alt", '');

				if($("div.zoomdiv").get().length == 0)
					$(this).after("<div class='zoomdiv'><img class='bigimg' src='"+bigimage+"'/></div>");

				if(settings.position == "right")
					leftpos = imageRelativeLeft + imageWidth + settings.offset;
				else
					leftpos = imageRelativeLeft - settings.xzoom - settings.offset;

				$("div.zoomdiv").css({top: imageRelativeTop,left: leftpos});
				$("div.zoomdiv").width(settings.xzoom);
				$("div.zoomdiv").height(settings.yzoom);
				$("div.zoomdiv").show();

				$(document.body).mousemove(function(e) {
					var bigwidth = $(".bigimg").get(0).offsetWidth;
					var bigheight = $(".bigimg").get(0).offsetHeight;
					var scaley ='x';
					var scalex= 'y';

					if(isNaN(scalex)|isNaN(scaley)) {
						var scalex = Math.round(bigwidth/imageWidth) ;
						var scaley = Math.round(bigheight/imageHeight);
					}

					mouse = new MouseEvent(e);

					scrolly = mouse.y - imageTop - ($("div.zoomdiv").height()*1/scaley)/2 ;
					$("div.zoomdiv").get(0).scrollTop = scrolly * scaley  ;
					scrollx = mouse.x - imageLeft - ($("div.zoomdiv").width()*1/scalex)/2 ;
					$("div.zoomdiv").get(0).scrollLeft = (scrollx) * scalex ;
				});
			}, function() {
				$(this).attr("alt", noalt);
				$("div.zoomdiv").hide();
				$(document.body).unbind("mousemove");
				$(".lenszoom").remove();
				$("div.zoomdiv").remove();
			});
		}
})(jQuery);

function MouseEvent(e) {
	this.x = e.pageX
	this.y = e.pageY
}
//kobstereshop/modules/productcomments/js/jquery.rating.pack.js
/*
 ### jQuery Star Rating Plugin v2.0 - 2008-03-12 ###
 By Diego A, http://www.fyneworks.com, diego@fyneworks.com
 - v2 by Keith Wood, kbwood@virginbroadband.com.au
 
 Project: http://plugins.jquery.com/project/MultipleFriendlyStarRating
 Website: http://www.fyneworks.com/jquery/star-rating/
	
	This is a modified version of the star rating plugin from:
 http://www.phpletter.com/Demo/Jquery-Star-Rating-Plugin/
*/
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}(';4(w)(3($){$.Y.T=3(c){c=$.15({m:\'X U\',E:\'\',B:z,8:z},c||{});o d={};o e={t:3(n,a,b){2.6(n);$(a).D(\'.j\').A().l(b||\'x\')},6:3(n){$(d[n].7).O(\'.j\').u(\'9\').u(\'x\')},h:3(n){4(!$(d[n].5).Z(\'.m\')){$(d[n].5).D(\'.j\').A().l(\'9\')}},g:3(n,a){d[n].5=a;o b=$(a).L(\'a\').K();$(d[n].7).J(b);e.6(n);e.h(n);4(c.I)c.I.W(d[n].7,[b,a])}};2.V(3(i){o n=2.G;4(!d[n])d[n]={r:0};i=d[n].r;d[n].r++;4(i==0){c.8=$(2).S(\'p\')||c.8;d[n].7=$(\'<R Q="P" G="\'+n+\'" q=""\'+(c.8?\' p="p"\':\'\')+\'>\');$(2).C(d[n].7);4(c.8||c.B){}F{$(2).C($(\'<k y="m"><a s="\'+c.m+\'">\'+c.E+\'</a></k>\').H(3(){e.6(n);$(2).l(\'9\')}).v(3(){e.h(n);$(2).u(\'9\')}).g(3(){e.g(n,2)}))}};f=$(\'<k y="j"><a s="\'+(2.s||2.q)+\'">\'+2.q+\'</a></k>\');$(2).N(f);4(c.8){$(f).l(\'M\')}F{$(f).H(3(){e.6(n);e.t(n,2)}).v(3(){e.6(n);e.h(n)}).g(3(){e.g(n,2)})};4(2.14)d[n].5=f;$(2).13();4(i+1==2.12)e.h(n)});11(n 10 d)4(d[n].5){e.t(n,d[n].5,\'9\');$(d[n].7).J($(d[n].5).L(\'a\').K())}16 2}})(w);',62,69,'||this|function|if|currentElem|drain|valueElem|readOnly|star_on||||||eStar|click|reset||star|div|addClass|cancel||var|disabled|value|count|title|fill|removeClass|mouseout|jQuery|star_hover|class|false|andSelf|required|before|prevAll|cancelValue|else|name|mouseover|callback|val|text|children|star_readonly|after|siblings|hidden|type|input|attr|rating|Rating|each|apply|Cancel|fn|is|in|for|length|remove|checked|extend|return'.split('|'),0,{}))

//pincode.js
  /*******this is for to check the zone avialiable or not *******/
 $( document ).ready(function() {
 var dataparam = "productid=" + id_product;
	
	$.ajax(
		{
			type: 'POST',
			url: baseDir + 'location-check.php',
			dataType: 'json',
			cache: false,
			data: dataparam,
			success: function(result)
			{
				if(result.status == 1){
					
					 $('#pin_check').show();
					 $('#hiddenpincode').val(0);
				}
				else{
					 $('#pin_check').hide();
					 $('#hiddenpincode').val(1);
				}
			}
		});
		
});
 
$('.pack_prod_con_id').click(function(){ 
	$.scrollTo(this.hash, 1500, { easing:'swing' });
	return false;
});
 
function adjustWidth(obj) {
 	 var quantity=obj.value;
		 if(quantity ==" " || quantity == 0)
		 {
			 alert("Please add a quantity greater than 0");
			 return false;
		 }
		 
		/* if(obj.value.length == 4)
		{
			$('#quantity_wanted').css("font-size","15px");
		}
		if (obj.value.length == 5)
		{
			$('#quantity_wanted').css("font-size","13px");
		}
		if (obj.value.length <= 3)
		{
			$('#quantity_wanted').css("font-size","13px");
		}*/
 }
 $("#quantity_wanted,#pincode").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
			
/*These lines are commented because there is some error in this four lines
$('#color_to_pick_list').on('click', 'li', function () {
	  $('#color_to_pick_list li').removeClass('color_pick');
	  $(this).parentsUntil('#color_to_pick_list', 'li').add(this).addClass('color_pick');
	  return false;
});*/
function fn_remove()
{
 	$('#pincode').attr('placeholder','');
  	$('#pincode').focusout(function(){
	$(this).attr('placeholder',"PINCODE");
	});
}
function fn_removeqty()
{
	$('#quantity_wanted').attr('placeholder','');
 	$('#quantity_wanted').focusout(function(){
		$(this).attr('placeholder',"000");
	});
}

 /*******this is for to check the pincode avialiable or not *******/
 $(document).ready(function(){
 	$('#pincode_search').on('click',function(){
 	var pincheck = $('#pincode').val();
 	if(pincheck.length != 6){
 		alert("please enter valid pincode.");
 	}
 });
 });
	function showpincode(obj){
	$('#pin_available').hide();
	$('#pin_notavailable').hide();
	var pincode=obj.value;
	var pincodelength=obj.value.length;
	
	var productid = id_product;
	var dataparam = "pincode="+pincode+"&productid="+productid;
	
	$.ajax({
				type: 'POST',
				url: baseDir + 'pincode-ajax.php',
				async: true,
				cache: false,
				dataType: 'json',
				data: dataparam,						
				success: function (jsonData) {
					if(pincodelength == 6){
						if(jsonData.status == 1)
							{
								 $('#pin_available').show();
								 $('#pin_notavailable').hide();
								 $('#hiddenpincode').val(1);
							}
							else
							{ 						
								$('#pin_notavailable').show();
								$('#pin_available').hide();
								$('#hiddenpincode').val(0);
							}
					}
				}
			});
}
function checkPinCode()
{
 	if($('#hiddenpincode').val() == 0)
	{
		alert("Check Pin Code");
		$('#add2cartbtn').unbind('click');
		return false;
	}
	else if($('#hiddenpincode').val() == 1)
	{
		alert("Check Pin Code 2");
		$('#add2cartbtn').bind('click');
		return false;
	}
}


/*
 * FancyBox - jQuery Plugin
 * Simple and fancy lightbox alternative
 *
 * Examples and documentation at: http://fancybox.net
 *
 * Copyright (c) 2008 - 2010 Janis Skarnelis
 * That said, it is hardly a one-person project. Many people have submitted bugs, code, and offered their advice freely. Their support is greatly appreciated.
 *
 * Version: 1.3.4 (11/11/2010)
 * Requires: jQuery v1.3+
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

;(function($) {
	var tmp, loading, overlay, wrap, outer, content, close, title, nav_left, nav_right,

		selectedIndex = 0, selectedOpts = {}, selectedArray = [], currentIndex = 0, currentOpts = {}, currentArray = [],

		ajaxLoader = null, imgPreloader = new Image(), imgRegExp = /\.(jpg|gif|png|bmp|jpeg)(.*)?$/i, swfRegExp = /[^\.]\.(swf)\s*$/i,

		loadingTimer, loadingFrame = 1,

		titleHeight = 0, titleStr = '', start_pos, final_pos, busy = false, fx = $.extend($('<div/>')[0], { prop: 0 }),

		isIE6 = $.browser.msie && $.browser.version < 7 && !window.XMLHttpRequest,

		/*
		 * Private methods 
		 */

		_abort = function() {
			loading.hide();

			imgPreloader.onerror = imgPreloader.onload = null;

			if (ajaxLoader) {
				ajaxLoader.abort();
			}

			tmp.empty();
		},

		_error = function() {
			if (false === selectedOpts.onError(selectedArray, selectedIndex, selectedOpts)) {
				loading.hide();
				busy = false;
				return;
			}

			selectedOpts.titleShow = false;

			selectedOpts.width = 'auto';
			selectedOpts.height = 'auto';

			tmp.html( '<p id="fancybox-error">The requested content cannot be loaded.<br />Please try again later.</p>' );

			_process_inline();
		},

		_start = function() {
			var obj = selectedArray[ selectedIndex ],
				href, 
				type, 
				title,
				str,
				emb,
				ret;

			_abort();

			selectedOpts = $.extend({}, $.fn.fancybox.defaults, (typeof $(obj).data('fancybox') == 'undefined' ? selectedOpts : $(obj).data('fancybox')));

			ret = selectedOpts.onStart(selectedArray, selectedIndex, selectedOpts);

			if (ret === false) {
				busy = false;
				return;
			} else if (typeof ret == 'object') {
				selectedOpts = $.extend(selectedOpts, ret);
			}

			title = selectedOpts.title || (obj.nodeName ? $(obj).attr('title') : obj.title) || '';

			if (obj.nodeName && !selectedOpts.orig) {
				selectedOpts.orig = $(obj).children("img:first").length ? $(obj).children("img:first") : $(obj);
			}

			if (title === '' && selectedOpts.orig && selectedOpts.titleFromAlt) {
				title = selectedOpts.orig.attr('alt');
			}

			href = selectedOpts.href || (obj.nodeName ? $(obj).attr('href') : obj.href) || null;

			if ((/^(?:javascript)/i).test(href) || href == '#') {
				href = null;
			}

			if (selectedOpts.type) {
				type = selectedOpts.type;

				if (!href) {
					href = selectedOpts.content;
				}

			} else if (selectedOpts.content) {
				type = 'html';

			} else if (href) {
				if (href.match(imgRegExp)) {
					type = 'image';

				} else if (href.match(swfRegExp)) {
					type = 'swf';

				} else if ($(obj).hasClass("iframe")) {
					type = 'iframe';

				} else if (href.indexOf("#") === 0) {
					type = 'inline';

				} else {
					type = 'ajax';
				}
			}

			if (!type) {
				_error();
				return;
			}

			if (type == 'inline') {
				obj	= href.substr(href.indexOf("#"));
				type = $(obj).length > 0 ? 'inline' : 'ajax';
			}

			selectedOpts.type = type;
			selectedOpts.href = href;
			selectedOpts.title = title;

			if (selectedOpts.autoDimensions) {
				if (selectedOpts.type == 'html' || selectedOpts.type == 'inline' || selectedOpts.type == 'ajax') {
					selectedOpts.width = 'auto';
					selectedOpts.height = 'auto';
				} else {
					selectedOpts.autoDimensions = false;	
				}
			}

			if (selectedOpts.modal) {
				selectedOpts.overlayShow = true;
				selectedOpts.hideOnOverlayClick = false;
				selectedOpts.hideOnContentClick = false;
				selectedOpts.enableEscapeButton = false;
				selectedOpts.showCloseButton = false;
			}

			selectedOpts.padding = parseInt(selectedOpts.padding, 10);
			selectedOpts.margin = parseInt(selectedOpts.margin, 10);

			tmp.css('padding', (selectedOpts.padding + selectedOpts.margin));

			$('.fancybox-inline-tmp').unbind('fancybox-cancel').bind('fancybox-change', function() {
				$(this).replaceWith(content.children());				
			});

			switch (type) {
				case 'html' :
					tmp.html( selectedOpts.content );
					_process_inline();
				break;

				case 'inline' :
					if ( $(obj).parent().is('#fancybox-content') === true) {
						busy = false;
						return;
					}

					$('<div class="fancybox-inline-tmp" />')
						.hide()
						.insertBefore( $(obj) )
						.bind('fancybox-cleanup', function() {
							$(this).replaceWith(content.children());
						}).bind('fancybox-cancel', function() {
							$(this).replaceWith(tmp.children());
						});

					$(obj).appendTo(tmp);

					_process_inline();
				break;

				case 'image':
					busy = false;

					$.fancybox.showActivity();

					imgPreloader = new Image();

					imgPreloader.onerror = function() {
						_error();
					};

					imgPreloader.onload = function() {
						busy = true;

						imgPreloader.onerror = imgPreloader.onload = null;

						_process_image();
					};

					imgPreloader.src = href;
				break;

				case 'swf':
					selectedOpts.scrolling = 'no';

					str = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' + selectedOpts.width + '" height="' + selectedOpts.height + '"><param name="movie" value="' + href + '"></param>';
					emb = '';

					$.each(selectedOpts.swf, function(name, val) {
						str += '<param name="' + name + '" value="' + val + '"></param>';
						emb += ' ' + name + '="' + val + '"';
					});

					str += '<embed src="' + href + '" type="application/x-shockwave-flash" width="' + selectedOpts.width + '" height="' + selectedOpts.height + '"' + emb + '></embed></object>';

					tmp.html(str);

					_process_inline();
				break;

				case 'ajax':
					busy = false;

					$.fancybox.showActivity();

					selectedOpts.ajax.win = selectedOpts.ajax.success;

					ajaxLoader = $.ajax($.extend({}, selectedOpts.ajax, {
						url	: href,
						data : selectedOpts.ajax.data || {},
						error : function(XMLHttpRequest, textStatus, errorThrown) {
							if ( XMLHttpRequest.status > 0 ) {
								_error();
							}
						},
						success : function(data, textStatus, XMLHttpRequest) {
							var o = typeof XMLHttpRequest == 'object' ? XMLHttpRequest : ajaxLoader;
							if (o.status == 200) {
								if ( typeof selectedOpts.ajax.win == 'function' ) {
									ret = selectedOpts.ajax.win(href, data, textStatus, XMLHttpRequest);

									if (ret === false) {
										loading.hide();
										return;
									} else if (typeof ret == 'string' || typeof ret == 'object') {
										data = ret;
									}
								}

								tmp.html( data );
								_process_inline();
							}
						}
					}));

				break;

				case 'iframe':
					_show();
				break;
			}
		},

		_process_inline = function() {
			var
				w = selectedOpts.width,
				h = selectedOpts.height;

			if (w.toString().indexOf('%') > -1) {
				w = parseInt( ($(window).width() - (selectedOpts.margin * 2)) * parseFloat(w) / 100, 10) + 'px';

			} else {
				w = w == 'auto' ? 'auto' : w + 'px';	
			}

			if (h.toString().indexOf('%') > -1) {
				h = parseInt( ($(window).height() - (selectedOpts.margin * 2)) * parseFloat(h) / 100, 10) + 'px';

			} else {
				h = h == 'auto' ? 'auto' : h + 'px';	
			}

			tmp.wrapInner('<div style="width:' + w + ';height:' + h + ';overflow: ' + (selectedOpts.scrolling == 'auto' ? 'auto' : (selectedOpts.scrolling == 'yes' ? 'scroll' : 'hidden')) + ';position:relative;"></div>');

			selectedOpts.width = tmp.width();
			selectedOpts.height = tmp.height();

			_show();
		},

		_process_image = function() {
			selectedOpts.width = imgPreloader.width;
			selectedOpts.height = imgPreloader.height;

			$("<img />").attr({
				'id' : 'fancybox-img',
				'src' : imgPreloader.src,
				'alt' : selectedOpts.title
			}).appendTo( tmp );

			_show();
		},

		_show = function() {
			var pos, equal;

			loading.hide();

			if (wrap.is(":visible") && false === currentOpts.onCleanup(currentArray, currentIndex, currentOpts)) {
				$.event.trigger('fancybox-cancel');

				busy = false;
				return;
			}

			busy = true;

			$(content.add( overlay )).unbind();

			$(window).unbind("resize.fb scroll.fb");
			$(document).unbind('keydown.fb');

			if (wrap.is(":visible") && currentOpts.titlePosition !== 'outside') {
				wrap.css('height', wrap.height());
			}

			currentArray = selectedArray;
			currentIndex = selectedIndex;
			currentOpts = selectedOpts;

			if (currentOpts.overlayShow) {
				overlay.css({
					'background-color' : currentOpts.overlayColor,
					'opacity' : currentOpts.overlayOpacity,
					'cursor' : currentOpts.hideOnOverlayClick ? 'pointer' : 'auto',
					'height' : $(document).height()
				});

				if (!overlay.is(':visible')) {
					if (isIE6) {
						$('select:not(#fancybox-tmp select)').filter(function() {
							return this.style.visibility !== 'hidden';
						}).css({'visibility' : 'hidden'}).one('fancybox-cleanup', function() {
							this.style.visibility = 'inherit';
						});
					}

					overlay.show();
				}
			} else {
				overlay.hide();
			}

			final_pos = _get_zoom_to();

			_process_title();

			if (wrap.is(":visible")) {
				$( close.add( nav_left ).add( nav_right ) ).hide();

				pos = wrap.position(),

				start_pos = {
					top	 : pos.top,
					left : pos.left,
					width : wrap.width(),
					height : wrap.height()
				};

				equal = (start_pos.width == final_pos.width && start_pos.height == final_pos.height);

				content.fadeTo(currentOpts.changeFade, 0.3, function() {
					var finish_resizing = function() {
						content.html( tmp.contents() ).fadeTo(currentOpts.changeFade, 1, _finish);
					};

					$.event.trigger('fancybox-change');

					content
						.empty()
						.removeAttr('filter')
						.css({
							'border-width' : currentOpts.padding,
							'width'	: final_pos.width - currentOpts.padding * 2,
							'height' : selectedOpts.autoDimensions ? 'auto' : final_pos.height - titleHeight - currentOpts.padding * 2
						});

					if (equal) {
						finish_resizing();

					} else {
						fx.prop = 0;

						$(fx).animate({prop: 1}, {
							 duration : currentOpts.changeSpeed,
							 easing : currentOpts.easingChange,
							 step : _draw,
							 complete : finish_resizing
						});
					}
				});

				return;
			}

			wrap.removeAttr("style");

			content.css('border-width', currentOpts.padding);

			if (currentOpts.transitionIn == 'elastic') {
				start_pos = _get_zoom_from();

				content.html( tmp.contents() );

				wrap.show();

				if (currentOpts.opacity) {
					final_pos.opacity = 0;
				}

				fx.prop = 0;

				$(fx).animate({prop: 1}, {
					 duration : currentOpts.speedIn,
					 easing : currentOpts.easingIn,
					 step : _draw,
					 complete : _finish
				});

				return;
			}

			if (currentOpts.titlePosition == 'inside' && titleHeight > 0) {	
				title.show();	
			}

			content
				.css({
					'width' : final_pos.width - currentOpts.padding * 2,
					'height' : selectedOpts.autoDimensions ? 'auto' : final_pos.height - titleHeight - currentOpts.padding * 2
				})
				.html( tmp.contents() );

			wrap
				.css(final_pos)
				.fadeIn( currentOpts.transitionIn == 'none' ? 0 : currentOpts.speedIn, _finish );
		},

		_format_title = function(title) {
			if (title && title.length) {
				if (currentOpts.titlePosition == 'float') {
					return '<table id="fancybox-title-float-wrap" cellpadding="0" cellspacing="0"><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">' + title + '</td><td id="fancybox-title-float-right"></td></tr></table>';
				}

				return '<div id="fancybox-title-' + currentOpts.titlePosition + '">' + title + '</div>';
			}

			return false;
		},

		_process_title = function() {
			titleStr = currentOpts.title || '';
			titleHeight = 0;

			title
				.empty()
				.removeAttr('style')
				.removeClass();

			if (currentOpts.titleShow === false) {
				title.hide();
				return;
			}

			titleStr = $.isFunction(currentOpts.titleFormat) ? currentOpts.titleFormat(titleStr, currentArray, currentIndex, currentOpts) : _format_title(titleStr);

			if (!titleStr || titleStr === '') {
				title.hide();
				return;
			}

			title
				.addClass('fancybox-title-' + currentOpts.titlePosition)
				.html( titleStr )
				.appendTo( 'body' )
				.show();

			switch (currentOpts.titlePosition) {
				case 'inside':
					title
						.css({
							'width' : final_pos.width - (currentOpts.padding * 2),
							'marginLeft' : currentOpts.padding,
							'marginRight' : currentOpts.padding
						});

					titleHeight = title.outerHeight(true);

					title.appendTo( outer );

					final_pos.height += titleHeight;
				break;

				case 'over':
					title
						.css({
							'marginLeft' : currentOpts.padding,
							'width'	: final_pos.width - (currentOpts.padding * 2),
							'bottom' : currentOpts.padding
						})
						.appendTo( outer );
				break;

				case 'float':
					title
						.css('left', parseInt((title.width() - final_pos.width - 40)/ 2, 10) * -1)
						.appendTo( wrap );
				break;

				default:
					title
						.css({
							'width' : final_pos.width - (currentOpts.padding * 2),
							'paddingLeft' : currentOpts.padding,
							'paddingRight' : currentOpts.padding
						})
						.appendTo( wrap );
				break;
			}

			title.hide();
		},

		_set_navigation = function() {
			if (currentOpts.enableEscapeButton || currentOpts.enableKeyboardNav) {
				$(document).bind('keydown.fb', function(e) {
					if (e.keyCode == 27 && currentOpts.enableEscapeButton) {
						e.preventDefault();
						$.fancybox.close();

					} else if ((e.keyCode == 37 || e.keyCode == 39) && currentOpts.enableKeyboardNav && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'SELECT') {
						e.preventDefault();
						$.fancybox[ e.keyCode == 37 ? 'prev' : 'next']();
					}
				});
			}

			if (!currentOpts.showNavArrows) { 
				nav_left.hide();
				nav_right.hide();
				return;
			}

			if ((currentOpts.cyclic && currentArray.length > 1) || currentIndex !== 0) {
				nav_left.show();
			}

			if ((currentOpts.cyclic && currentArray.length > 1) || currentIndex != (currentArray.length -1)) {
				nav_right.show();
			}
		},

		_finish = function () {
			if (!$.support.opacity) {
				content.get(0).style.removeAttribute('filter');
				wrap.get(0).style.removeAttribute('filter');
			}

			if (selectedOpts.autoDimensions) {
				content.css('height', 'auto');
			}

			wrap.css('height', 'auto');

			if (titleStr && titleStr.length) {
				title.show();
			}

			if (currentOpts.showCloseButton) {
				close.show();
			}

			_set_navigation();
	
			if (currentOpts.hideOnContentClick)	{
				content.bind('click', $.fancybox.close);
			}

			if (currentOpts.hideOnOverlayClick)	{
				overlay.bind('click', $.fancybox.close);
			}

			$(window).bind("resize.fb", $.fancybox.resize);

			if (currentOpts.centerOnScroll) {
				$(window).bind("scroll.fb", $.fancybox.center);
			}

			if (currentOpts.type == 'iframe') {
				$('<iframe id="fancybox-frame" name="fancybox-frame' + new Date().getTime() + '" frameborder="0" hspace="0" ' + ($.browser.msie ? 'allowtransparency="true""' : '') + ' scrolling="' + selectedOpts.scrolling + '" src="' + currentOpts.href + '"></iframe>').appendTo(content);
			}

			wrap.show();

			busy = false;

			$.fancybox.center();

			currentOpts.onComplete(currentArray, currentIndex, currentOpts);

			_preload_images();
		},

		_preload_images = function() {
			var href, 
				objNext;

			if ((currentArray.length -1) > currentIndex) {
				href = currentArray[ currentIndex + 1 ].href;

				if (typeof href !== 'undefined' && href.match(imgRegExp)) {
					objNext = new Image();
					objNext.src = href;
				}
			}

			if (currentIndex > 0) {
				href = currentArray[ currentIndex - 1 ].href;

				if (typeof href !== 'undefined' && href.match(imgRegExp)) {
					objNext = new Image();
					objNext.src = href;
				}
			}
		},

		_draw = function(pos) {
			var dim = {
				width : parseInt(start_pos.width + (final_pos.width - start_pos.width) * pos, 10),
				height : parseInt(start_pos.height + (final_pos.height - start_pos.height) * pos, 10),

				top : parseInt(start_pos.top + (final_pos.top - start_pos.top) * pos, 10),
				left : parseInt(start_pos.left + (final_pos.left - start_pos.left) * pos, 10)
			};

			if (typeof final_pos.opacity !== 'undefined') {
				dim.opacity = pos < 0.5 ? 0.5 : pos;
			}

			wrap.css(dim);

			content.css({
				'width' : dim.width - currentOpts.padding * 2,
				'height' : dim.height - (titleHeight * pos) - currentOpts.padding * 2
			});
		},

		_get_viewport = function() {
			return [
				$(window).width() - (currentOpts.margin * 2),
				$(window).height() - (currentOpts.margin * 2),
				$(document).scrollLeft() + currentOpts.margin,
				$(document).scrollTop() + currentOpts.margin
			];
		},

		_get_zoom_to = function () {
			var view = _get_viewport(),
				to = {},
				resize = currentOpts.autoScale,
				double_padding = currentOpts.padding * 2,
				ratio;

			if (currentOpts.width.toString().indexOf('%') > -1) {
				to.width = parseInt((view[0] * parseFloat(currentOpts.width)) / 100, 10);
			} else {
				to.width = currentOpts.width + double_padding;
			}

			if (currentOpts.height.toString().indexOf('%') > -1) {
				to.height = parseInt((view[1] * parseFloat(currentOpts.height)) / 100, 10);
			} else {
				to.height = currentOpts.height + double_padding;
			}

			if (resize && (to.width > view[0] || to.height > view[1])) {
				if (selectedOpts.type == 'image' || selectedOpts.type == 'swf') {
					ratio = (currentOpts.width ) / (currentOpts.height );

					if ((to.width ) > view[0]) {
						to.width = view[0];
						to.height = parseInt(((to.width - double_padding) / ratio) + double_padding, 10);
					}

					if ((to.height) > view[1]) {
						to.height = view[1];
						to.width = parseInt(((to.height - double_padding) * ratio) + double_padding, 10);
					}

				} else {
					to.width = Math.min(to.width, view[0]);
					to.height = Math.min(to.height, view[1]);
				}
			}

			to.top = parseInt(Math.max(view[3] - 20, view[3] + ((view[1] - to.height - 40) * 0.5)), 10);
			to.left = parseInt(Math.max(view[2] - 20, view[2] + ((view[0] - to.width - 40) * 0.5)), 10);

			return to;
		},

		_get_obj_pos = function(obj) {
			var pos = obj.offset();

			pos.top += parseInt( obj.css('paddingTop'), 10 ) || 0;
			pos.left += parseInt( obj.css('paddingLeft'), 10 ) || 0;

			pos.top += parseInt( obj.css('border-top-width'), 10 ) || 0;
			pos.left += parseInt( obj.css('border-left-width'), 10 ) || 0;

			pos.width = obj.width();
			pos.height = obj.height();

			return pos;
		},

		_get_zoom_from = function() {
			var orig = selectedOpts.orig ? $(selectedOpts.orig) : false,
				from = {},
				pos,
				view;

			if (orig && orig.length) {
				pos = _get_obj_pos(orig);

				from = {
					width : pos.width + (currentOpts.padding * 2),
					height : pos.height + (currentOpts.padding * 2),
					top	: pos.top - currentOpts.padding - 20,
					left : pos.left - currentOpts.padding - 20
				};

			} else {
				view = _get_viewport();

				from = {
					width : currentOpts.padding * 2,
					height : currentOpts.padding * 2,
					top	: parseInt(view[3] + view[1] * 0.5, 10),
					left : parseInt(view[2] + view[0] * 0.5, 10)
				};
			}

			return from;
		},

		_animate_loading = function() {
			if (!loading.is(':visible')){
				clearInterval(loadingTimer);
				return;
			}

			$('div', loading).css('top', (loadingFrame * -40) + 'px');

			loadingFrame = (loadingFrame + 1) % 12;
		};

	/*
	 * Public methods 
	 */

	$.fn.fancybox = function(options) {
		if (!$(this).length) {
			return this;
		}

		$(this)
			.data('fancybox', $.extend({}, options, ($.metadata ? $(this).metadata() : {})))
			.unbind('click.fb')
			.bind('click.fb', function(e) {
				e.preventDefault();

				if (busy) {
					return;
				}

				busy = true;

				$(this).blur();

				selectedArray = [];
				selectedIndex = 0;

				var rel = $(this).attr('rel') || '';

				if (!rel || rel == '' || rel === 'nofollow') {
					selectedArray.push(this);

				} else {
					selectedArray = $("a[rel=" + rel + "], area[rel=" + rel + "]");
					selectedIndex = selectedArray.index( this );
				}

				_start();

				return;
			});

		return this;
	};

	$.fancybox = function(obj) {
		var opts;

		if (busy) {
			return;
		}

		busy = true;
		opts = typeof arguments[1] !== 'undefined' ? arguments[1] : {};

		selectedArray = [];
		selectedIndex = parseInt(opts.index, 10) || 0;

		if ($.isArray(obj)) {
			for (var i = 0, j = obj.length; i < j; i++) {
				if (typeof obj[i] == 'object') {
					$(obj[i]).data('fancybox', $.extend({}, opts, obj[i]));
				} else {
					obj[i] = $({}).data('fancybox', $.extend({content : obj[i]}, opts));
				}
			}

			selectedArray = jQuery.merge(selectedArray, obj);

		} else {
			if (typeof obj == 'object') {
				$(obj).data('fancybox', $.extend({}, opts, obj));
			} else {
				obj = $({}).data('fancybox', $.extend({content : obj}, opts));
			}

			selectedArray.push(obj);
		}

		if (selectedIndex > selectedArray.length || selectedIndex < 0) {
			selectedIndex = 0;
		}

		_start();
	};

	$.fancybox.showActivity = function() {
		clearInterval(loadingTimer);

		loading.show();
		loadingTimer = setInterval(_animate_loading, 66);
	};

	$.fancybox.hideActivity = function() {
		loading.hide();
	};

	$.fancybox.next = function() {
		return $.fancybox.pos( currentIndex + 1);
	};

	$.fancybox.prev = function() {
		return $.fancybox.pos( currentIndex - 1);
	};

	$.fancybox.pos = function(pos) {
		if (busy) {
			return;
		}

		pos = parseInt(pos);

		selectedArray = currentArray;

		if (pos > -1 && pos < currentArray.length) {
			selectedIndex = pos;
			_start();

		} else if (currentOpts.cyclic && currentArray.length > 1) {
			selectedIndex = pos >= currentArray.length ? 0 : currentArray.length - 1;
			_start();
		}

		return;
	};

	$.fancybox.cancel = function() {
		if (busy) {
			return;
		}

		busy = true;

		$.event.trigger('fancybox-cancel');

		_abort();

		selectedOpts.onCancel(selectedArray, selectedIndex, selectedOpts);

		busy = false;
	};

	// Note: within an iframe use - parent.$.fancybox.close();
	$.fancybox.close = function() {
		if (busy || wrap.is(':hidden')) {
			return;
		}

		busy = true;

		if (currentOpts && false === currentOpts.onCleanup(currentArray, currentIndex, currentOpts)) {
			busy = false;
			return;
		}

		_abort();

		$(close.add( nav_left ).add( nav_right )).hide();

		$(content.add( overlay )).unbind();

		$(window).unbind("resize.fb scroll.fb");
		$(document).unbind('keydown.fb');

		content.find('iframe').attr('src', isIE6 && /^https/i.test(window.location.href || '') ? 'javascript:void(false)' : 'about:blank');

		if (currentOpts.titlePosition !== 'inside') {
			title.empty();
		}

		wrap.stop();

		function _cleanup() {
			overlay.fadeOut('fast');

			title.empty().hide();
			wrap.hide();

			$.event.trigger('fancybox-cleanup');

			content.empty();

			currentOpts.onClosed(currentArray, currentIndex, currentOpts);

			currentArray = selectedOpts	= [];
			currentIndex = selectedIndex = 0;
			currentOpts = selectedOpts	= {};

			busy = false;
		}

		if (currentOpts.transitionOut == 'elastic') {
			start_pos = _get_zoom_from();

			var pos = wrap.position();

			final_pos = {
				top	 : pos.top ,
				left : pos.left,
				width :	wrap.width(),
				height : wrap.height()
			};

			if (currentOpts.opacity) {
				final_pos.opacity = 1;
			}

			title.empty().hide();

			fx.prop = 1;

			$(fx).animate({ prop: 0 }, {
				 duration : currentOpts.speedOut,
				 easing : currentOpts.easingOut,
				 step : _draw,
				 complete : _cleanup
			});

		} else {
			wrap.fadeOut( currentOpts.transitionOut == 'none' ? 0 : currentOpts.speedOut, _cleanup);
		}
	};

	$.fancybox.resize = function() {
		if (overlay.is(':visible')) {
			overlay.css('height', $(document).height());
		}

		$.fancybox.center(true);
	};

	$.fancybox.center = function() {
		var view, align;

		if (busy) {
			return;	
		}

		align = arguments[0] === true ? 1 : 0;
		view = _get_viewport();

		if (!align && (wrap.width() > view[0] || wrap.height() > view[1])) {
			return;	
		}

		wrap
			.stop()
			.animate({
				'top' : parseInt(Math.max(view[3] - 20, view[3] + ((view[1] - content.height() - 40) * 0.5) - currentOpts.padding)),
				'left' : parseInt(Math.max(view[2] - 20, view[2] + ((view[0] - content.width() - 40) * 0.5) - currentOpts.padding))
			}, typeof arguments[0] == 'number' ? arguments[0] : 200);
	};

	$.fancybox.init = function() {
		if ($("#fancybox-wrap").length) {
			return;
		}

		$('body').append(
			tmp	= $('<div id="fancybox-tmp"></div>'),
			loading	= $('<div id="fancybox-loading"><div></div></div>'),
			overlay	= $('<div id="fancybox-overlay"></div>'),
			wrap = $('<div id="fancybox-wrap"></div>')
		);

		outer = $('<div id="fancybox-outer"></div>')
			.append('<div class="fancybox-bg" id="fancybox-bg-n"></div><div class="fancybox-bg" id="fancybox-bg-ne"></div><div class="fancybox-bg" id="fancybox-bg-e"></div><div class="fancybox-bg" id="fancybox-bg-se"></div><div class="fancybox-bg" id="fancybox-bg-s"></div><div class="fancybox-bg" id="fancybox-bg-sw"></div><div class="fancybox-bg" id="fancybox-bg-w"></div><div class="fancybox-bg" id="fancybox-bg-nw"></div>')
			.appendTo( wrap );

		outer.append(
			content = $('<div id="fancybox-content"></div>'),
			close = $('<a id="fancybox-close"></a>'),
			title = $('<div id="fancybox-title"></div>'),

			nav_left = $('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),
			nav_right = $('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>')
		);

		close.click($.fancybox.close);
		loading.click($.fancybox.cancel);

		nav_left.click(function(e) {
			e.preventDefault();
			$.fancybox.prev();
		});

		nav_right.click(function(e) {
			e.preventDefault();
			$.fancybox.next();
		});

		if ($.fn.mousewheel) {
			wrap.bind('mousewheel.fb', function(e, delta) {
				if (busy) {
					e.preventDefault();

				} else if ($(e.target).get(0).clientHeight == 0 || $(e.target).get(0).scrollHeight === $(e.target).get(0).clientHeight) {
					e.preventDefault();
					$.fancybox[ delta > 0 ? 'prev' : 'next']();
				}
			});
		}

		if (!$.support.opacity) {
			wrap.addClass('fancybox-ie');
		}

		if (isIE6) {
			loading.addClass('fancybox-ie6');
			wrap.addClass('fancybox-ie6');

			$('<iframe id="fancybox-hide-sel-frame" src="' + (/^https/i.test(window.location.href || '') ? 'javascript:void(false)' : 'about:blank' ) + '" scrolling="no" border="0" frameborder="0" tabindex="-1"></iframe>').prependTo(outer);
		}
	};

	$.fn.fancybox.defaults = {
		padding : 10,
		margin : 40,
		opacity : false,
		modal : false,
		cyclic : false,
		scrolling : 'auto',	// 'auto', 'yes' or 'no'

		width : 560,
		height : 340,

		autoScale : true,
		autoDimensions : true,
		centerOnScroll : false,

		ajax : {},
		swf : { wmode: 'transparent' },

		hideOnOverlayClick : true,
		hideOnContentClick : false,

		overlayShow : true,
		overlayOpacity : 0.7,
		overlayColor : '#777',

		titleShow : true,
		titlePosition : 'float', // 'float', 'outside', 'inside' or 'over'
		titleFormat : null,
		titleFromAlt : false,

		transitionIn : 'fade', // 'elastic', 'fade' or 'none'
		transitionOut : 'fade', // 'elastic', 'fade' or 'none'

		speedIn : 300,
		speedOut : 300,

		changeSpeed : 300,
		changeFade : 'fast',

		easingIn : 'swing',
		easingOut : 'swing',

		showCloseButton	 : true,
		showNavArrows : true,
		enableEscapeButton : true,
		enableKeyboardNav : true,

		onStart : function(){},
		onCancel : function(){},
		onComplete : function(){},
		onCleanup : function(){},
		onClosed : function(){},
		onError : function(){}
	};

	$(document).ready(function() {
		$.fancybox.init();
	});

})(jQuery);
// /js/jquery/jquery.idTabs.modified.js
/* idTabs ~ Sean Catchpole - Version 1.0 */ 
 
/* Options (in any order): 
 
 start (number|string) 
    Index number of default tab. ex: idTabs(0) 
    String of id of default tab. ex: idTabs("#tab1") 
    default: class "selected" or index 0 
 
 return (boolean) 
    True - Url will change. ex: idTabs(true) 
    False - Url will not change. ex: idTabs(false) 
    default: false 
 
 click (function) 
    Function will be called when a tab is clicked. ex: idTabs(foo) 
    If the function returns true, idTabs will show/hide content (as usual). 
    If the function returns false, idTabs will not take any action. 
    The function is passed three variables: 
      The id of the element to be shown 
      an array of all id's that can be shown 
      and the element containing the tabs 
  
  MODIFIED BY PRESTASHOP
  
*/ 

(function($){$.fn.idTabs=function(){var s={"start":null,"return":false,"click":null};for(var i=0;i<arguments.length;++i){var n={},a=arguments[i];switch(typeof a){case"object":$.extend(n,a);break;case"number":case"string":n.start=a;break;case"boolean":n["return"]=a;break;case"function":n.click=a;break;};$.extend(s,n);}
var self=this;var list=$("a[href^='#']",this).click(function(){if($("a.selected",self)[0]==this)
return s["return"];var id="#"+this.href.split('#')[1];var aList=[];var idList=[];$("a",self).each(function(){if(this.href.match(/#/)){aList[aList.length]=this;idList[idList.length]="#"+this.href.split('#')[1];}});if(s.click&&!s.click(id,idList,self))return s["return"];for(i in aList)$(aList[i]).removeClass("selected");for(i in idList){$(idList[i]).addClass('block_hidden_only_for_screen');}
$(this).addClass("selected");$(id).removeClass('block_hidden_only_for_screen');return s["return"];});var test;if(typeof s.start=="number"&&(test=list.filter(":eq("+s.start+")")).length)
test.click();else if(typeof s.start=="string"&&(test=list.filter("[href='#"+s.start+"']")).length)
test.click();else if((test=list.filter(".selected")).length)
test.removeClass("selected").click();else list.filter(":first").click();return this;};$(function(){$(".idTabs").each(function(){$(this).idTabs();});});})(jQuery)



//product.js
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 14089 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/


//global variables
var combinations = new Array();
var selectedCombination = new Array();
var globalQuantity = new Number;
var colors = new Array();

//check if a function exists
function function_exists(function_name)
{
	if (typeof function_name == 'string')
		return (typeof window[function_name] == 'function');
	return (function_name instanceof Function);
}

//execute oosHook js code
function oosHookJsCode()
{
	for (var i = 0; i < oosHookJsCodeFunctions.length; i++)
	{
		if (function_exists(oosHookJsCodeFunctions[i]))
			setTimeout(oosHookJsCodeFunctions[i]+'()', 0);
	}
}

//add a combination of attributes in the global JS sytem
function addCombination(idCombination, arrayOfIdAttributes, quantity, price, ecotax, id_image, reference, unit_price, minimal_quantity)
{
	globalQuantity += quantity;

	var combination = new Array();
	combination['idCombination'] = idCombination;
	combination['quantity'] = quantity;
	combination['idsAttributes'] = arrayOfIdAttributes;
	combination['price'] = price;
	combination['ecotax'] = ecotax;
	combination['image'] = id_image;
	combination['reference'] = reference;
	combination['unit_price'] = unit_price;
	combination['minimal_quantity'] = minimal_quantity;
	combinations.push(combination);

}

// search the combinations' case of attributes and update displaying of availability, prices, ecotax, and image
function findCombination(firstTime)
{
	$('#minimal_quantity_wanted_p').fadeOut();
	$('#quantity_wanted').val(1);
	//create a temporary 'choice' array containing the choices of the customer
	var choice = new Array();
	$('div#attributes select').each(function(){
		choice.push($(this).val());
	});

	//testing every combination to find the conbination's attributes' case of the user
	for (var combination = 0; combination < combinations.length; ++combination)
	{
		//verify if this combinaison is the same that the user's choice
		var combinationMatchForm = true;
		$.each(combinations[combination]['idsAttributes'], function(key, value)
		{
			if (!in_array(value, choice))
			{
				combinationMatchForm = false;
			}
		})

		if (combinationMatchForm)
		{
			if (combinations[combination]['minimal_quantity'] > 1)
			{
				$('#minimal_quantity_label').html(combinations[combination]['minimal_quantity']);
				$('#minimal_quantity_wanted_p').fadeIn();
				$('#quantity_wanted').val(combinations[combination]['minimal_quantity']);
				$('#quantity_wanted').bind('keyup', function() {checkMinimalQuantity(combinations[combination]['minimal_quantity'])});
			}
			//combination of the user has been found in our specifications of combinations (created in back office)
			selectedCombination['unavailable'] = false;
			selectedCombination['reference'] = combinations[combination]['reference'];
			$('#idCombination').val(combinations[combination]['idCombination']);

			$('#ipa_customization').val(combinations[combination]['idCombination']);
			//get the data of product with these attributes
			quantityAvailable = combinations[combination]['quantity'];
			selectedCombination['price'] = combinations[combination]['price'];
			selectedCombination['unit_price'] = combinations[combination]['unit_price'];
			if (combinations[combination]['ecotax'])
				selectedCombination['ecotax'] = combinations[combination]['ecotax'];
			else
				selectedCombination['ecotax'] = default_eco_tax;

			//show the large image in relation to the selected combination
			if (combinations[combination]['image'] && combinations[combination]['image'] != -1)
				displayImage( $('#thumb_'+combinations[combination]['image']).parent() );

			//update the display
			updateDisplay();

			if(typeof(firstTime) != 'undefined' && firstTime && ipa_default != selectedCombination['idCombination'])
				refreshProductImages(0);
			else
				refreshProductImages(combinations[combination]['idCombination']);
			//leave the function because combination has been found
			return;
		}
	}
	//this combination doesn't exist (not created in back office)
	selectedCombination['unavailable'] = true;
	updateDisplay();
}

function updateColorSelect(id_attribute)
{
	if (id_attribute == 0)
	{
		refreshProductImages(0);
		return ;
	}
	// Visual effect
	$('#color_'+id_attribute).fadeTo('fast', 1, function(){	$(this).fadeTo('slow', 0, function(){ $(this).fadeTo('slow', 1, function(){}); }); });
	// Attribute selection
	$('#group_'+id_color_default+' option[value='+id_attribute+']').attr('selected', 'selected');
	$('#group_'+id_color_default+' option[value!='+id_attribute+']').removeAttr('selected');
	findCombination();
}

//update display of the availability of the product AND the prices of the product
function updateDisplay()
{
	if (!selectedCombination['unavailable'] && quantityAvailable > 0 && productAvailableForOrder == 1)
	{
		//show the choice of quantities
		$('#quantity_wanted_p:hidden').show('slow');

		//show the "add to cart" button ONLY if it was hidden
		$('#add_to_cart:hidden').fadeIn(600);

		//hide the hook out of stock
		$('#oosHook').hide();

		//availability value management
		if (availableNowValue != '')
		{
			//update the availability statut of the product
			$('#availability_value').removeClass('warning_inline');
			$('#availability_value').text(availableNowValue);
			$('#availability_statut:hidden').show();
		}
		else
		{
			//hide the availability value
			$('#availability_statut:visible').hide();
		}

		//'last quantities' message management
		if (!allowBuyWhenOutOfStock)
		{
			if (quantityAvailable <= maxQuantityToAllowDisplayOfLastQuantityMessage)
				$('#last_quantities').show('slow');
			else
				$('#last_quantities').hide('slow');
		}

		if (quantitiesDisplayAllowed)
		{
			$('#pQuantityAvailable:hidden').show('slow');
			$('#quantityAvailable').text(quantityAvailable);

			if (quantityAvailable < 2) // we have 1 or less product in stock and need to show "item" instead of "items"
			{
				$('#quantityAvailableTxt').show();
				$('#quantityAvailableTxtMultiple').hide();
			}
			else
			{
				$('#quantityAvailableTxt').hide();
				$('#quantityAvailableTxtMultiple').show();
			}
		}
	}
	else
	{
		//show the hook out of stock
		if (productAvailableForOrder == 1)
		{
			$('#oosHook').show();
			if ($('#oosHook').length > 0 && function_exists('oosHookJsCode'))
				oosHookJsCode();
		}

		//hide 'last quantities' message if it was previously visible
		$('#last_quantities:visible').hide('slow');

		//hide the quantity of pieces if it was previously visible
		$('#pQuantityAvailable:visible').hide('slow');

		//hide the choice of quantities
		if (!allowBuyWhenOutOfStock)
			$('#quantity_wanted_p:visible').hide('slow');

		//display that the product is unavailable with theses attributes
		if (!selectedCombination['unavailable'])
			$('#availability_value').text(doesntExistNoMore + (globalQuantity > 0 ? ' ' + doesntExistNoMoreBut : '')).addClass('warning_inline');
		else
		{
			$('#availability_value').text(doesntExist).addClass('warning_inline');
			$('#oosHook').hide();
		}
		$('#availability_statut:hidden').show();


		//show the 'add to cart' button ONLY IF it's possible to buy when out of stock AND if it was previously invisible
		if (allowBuyWhenOutOfStock && !selectedCombination['unavailable'] && productAvailableForOrder == 1)
		{
			$('#add_to_cart:hidden').fadeIn(600);

			if (availableLaterValue != '')
			{
				$('#availability_value').text(availableLaterValue);
				$('p#availability_statut:hidden').show('slow');
			}
			else
				$('p#availability_statut:visible').hide('slow');
		}
		else
		{
			$('#add_to_cart:visible').fadeOut(600);
			$('p#availability_statut:hidden').show('slow');
		}

		if (productAvailableForOrder == 0)
			$('p#availability_statut:visible').hide();
	}

	if (selectedCombination['reference'] || productReference)
	{
		if (selectedCombination['reference'])
			$('#product_reference span').text(selectedCombination['reference']);
		else if (productReference)
			$('#product_reference span').text(productReference);
		$('#product_reference:hidden').show('slow');
	}
	else
		$('#product_reference:visible').hide('slow');

	//update display of the the prices in relation to tax, discount, ecotax, and currency criteria
	if (!selectedCombination['unavailable'] && productShowPrice == 1)
	{
		// retrieve price without group_reduction in order to compute the group reduction after
		// the specific price discount (done in the JS in order to keep backward compatibility)
		if (!displayPrice && !noTaxForThisProduct)
		{
			var priceTaxExclWithoutGroupReduction = ps_round(productPriceTaxExcluded, 6) * (1 / group_reduction);
		} else {
			var priceTaxExclWithoutGroupReduction = ps_round(productPriceTaxExcluded, 6) * (1 / group_reduction);
		}
		var combination_add_price = selectedCombination['price'] * group_reduction;

		var tax = (taxRate / 100) + 1;
		var taxExclPrice = (specific_price ? (specific_currency ? specific_price : specific_price * currencyRate) : priceTaxExclWithoutGroupReduction) + selectedCombination['price'] * currencyRate;


		if (specific_price)
			var productPriceWithoutReduction = priceTaxExclWithoutGroupReduction + selectedCombination['price'] * currencyRate;

		if (!displayPrice && !noTaxForThisProduct)
		{
			var productPrice = taxExclPrice * tax;
			if (specific_price)
				productPriceWithoutReduction = ps_round(productPriceWithoutReduction * tax, 2);
		}
		else
		{
			var productPrice = ps_round(taxExclPrice, 2);
			if (specific_price)
				productPriceWithoutReduction = ps_round(productPriceWithoutReduction, 2);
		}

		var reduction = 0;
		if (reduction_price || reduction_percent)
		{
            reduction_price = (specific_currency ? reduction_price : reduction_price * currencyRate);
			reduction = productPrice * (parseFloat(reduction_percent) / 100) + reduction_price;
			if (reduction_price && (displayPrice || noTaxForThisProduct))
				reduction = ps_round(reduction / tax, 6);
		}

		if (!specific_price)
			productPriceWithoutReduction = productPrice * group_reduction;


		productPrice -= reduction;
		var tmp = productPrice * group_reduction;
		productPrice = ps_round(productPrice * group_reduction, 2);

		var ecotaxAmount = !displayPrice ? ps_round(selectedCombination['ecotax'] * (1 + ecotaxTax_rate / 100), 2) : selectedCombination['ecotax'];
		productPrice += ecotaxAmount;
		productPriceWithoutReduction += ecotaxAmount;

		//productPrice = ps_round(productPrice * currencyRate, 2);
		if (productPrice > 0)
			$('#our_price_display').text(formatCurrency(productPrice, currencyFormat, currencySign, currencyBlank));
		else
		{
			$('#our_price_display').text("Please call 044 64573222 for price details");
		}
			/*$('#our_price_display').text(formatCurrency(0, currencyFormat, currencySign, currencyBlank));*/

		$('#old_price_display').text(formatCurrency(productPriceWithoutReduction, currencyFormat, currencySign, currencyBlank));

		/* Special feature: "Display product price tax excluded on product page" */
		if (!noTaxForThisProduct)
			var productPricePretaxed = productPrice / tax;
		else
			var productPricePretaxed = productPrice;
		$('#pretaxe_price_display').text(formatCurrency(productPricePretaxed, currencyFormat, currencySign, currencyBlank));
		/* Unit price */
        productUnitPriceRatio = parseFloat(productUnitPriceRatio);
		if (productUnitPriceRatio > 0 )
		{
        	newUnitPrice = (productPrice / parseFloat(productUnitPriceRatio)) + selectedCombination['unit_price'];
			$('#unit_price_display').text(formatCurrency(newUnitPrice, currencyFormat, currencySign, currencyBlank));
		}

		/* Ecotax */
		var ecotaxAmount = !displayPrice ? ps_round(selectedCombination['ecotax'] * (1 + ecotaxTax_rate / 100), 2) : selectedCombination['ecotax'];
		$('#ecotax_price_display').text(formatCurrency(ecotaxAmount, currencyFormat, currencySign, currencyBlank));
	}
}

//update display of the large image
function displayImage(domAAroundImgThumb)
{
    if (domAAroundImgThumb.attr('href'))

    {
        var newSrc = domAAroundImgThumb.attr('href').replace('thickbox','large');
        if ($('#bigpic').attr('src') != newSrc)
        {
            $('#bigpic').fadeOut('fast', function(){
                $(this).attr('src', newSrc).show();
                if (typeof(jqZoomEnabled) != 'undefined' && jqZoomEnabled)
	                $(this).attr('alt', domAAroundImgThumb.attr('href'));
            });
        }
        $('#views_block li a').removeClass('shown');
        $(domAAroundImgThumb).addClass('shown');
    }
}

// Serialscroll exclude option bug ?
function serialScrollFixLock(event, targeted, scrolled, items, position)
{
	serialScrollNbImages = $('#thumbs_list li:visible').length;
	serialScrollNbImagesDisplayed = 3;

	var leftArrow = position == 0 ? true : false;
	var rightArrow = position + serialScrollNbImagesDisplayed >= serialScrollNbImages ? true : false;

	$('a#view_scroll_left').css('cursor', leftArrow ? 'default' : 'pointer').css('display', leftArrow ? 'none' : 'block').fadeTo(0, leftArrow ? 0 : 1);
	$('a#view_scroll_right').css('cursor', rightArrow ? 'default' : 'pointer').fadeTo(0, rightArrow ? 0 : 1).css('display', rightArrow ? 'none' : 'block');
	return true;
}

// Change the current product images regarding the combination selected
function refreshProductImages(id_product_attribute)
{
	$('#thumbs_list_frame').scrollTo('li:eq(0)', 700, {axis:'x'});
	$('#thumbs_list li').hide();
	id_product_attribute = parseInt(id_product_attribute);

	if (typeof(combinationImages) != 'undefined' && typeof(combinationImages[id_product_attribute]) != 'undefined')
	{
		for (var i = 0; i < combinationImages[id_product_attribute].length; i++)
			$('#thumbnail_' + parseInt(combinationImages[id_product_attribute][i])).show();
	}
	if (i > 0)
	{
		var thumb_width = $('#thumbs_list_frame >li').width()+parseInt($('#thumbs_list_frame >li').css('marginRight'));
		$('#thumbs_list_frame').width((parseInt((thumb_width)* i) + 3) + 'px'); //  Bug IE6, needs 3 pixels more ?
	}
	else
	{
		$('#thumbnail_' + idDefaultImage).show();
		displayImage($('#thumbnail_'+ idDefaultImage +' a'));
	}
	$('#thumbs_list').trigger('goto', 0);
	serialScrollFixLock('', '', '', '', 0);// SerialScroll Bug on goto 0 ?
}

//To do after loading HTML
$(document).ready(function()
{
	// trigger click on the product attribute combination
	getCombinationById($('#ipa_customization').val());

	//init the serialScroll for thumbs
	$('#thumbs_list').serialScroll({
		items:'li:visible',
		prev:'a#view_scroll_left',
		next:'a#view_scroll_right',
		axis:'x',
		offset:0,
		start:0,
		stop:true,
		onBefore:serialScrollFixLock,
		duration:700,
		step: 2,
		lazy: true,
		lock: false,
		force:false,
		cycle:false
	});

	$('#thumbs_list').trigger('goto', 1);// SerialScroll Bug on goto 0 ?
	$('#thumbs_list').trigger('goto', 0);

	//hover 'other views' images management
	$('#views_block li a').hover(
		function(){displayImage($(this));},
		function(){}
	);

	//set jqZoom parameters if needed
	if (typeof(jqZoomEnabled) != 'undefined' && jqZoomEnabled)
	{
		
		$('img.jqzoom').jqueryzoom({
			xzoom: 300, //zooming div default width(default width value is 200)(changed from 200 to 300 by mahesh)
			yzoom: 300, //zooming div default width(default height value is 200)(changed from 200 to 300 by mahesh)
			offset: 21 //zooming div default offset(default offset value is 10)
			//position: "right" //zooming div position(default position value is "right")
		});
	}

	//add a link on the span 'view full size' and on the big image
	$('span#view_full_size, div#image-block img').click(function(){
		$('#views_block li a.shown').click();
	});

	//catch the click on the "more infos" button at the top of the page
	$('div#short_description_block p a.button').click(function(){
		$('#more_info_tab_more_info').click();
		$.scrollTo( '#more_info_tabs', 1200 );
	});

	// Hide the customization submit button and display some message
	$('p#customizedDatas input').click(function() {
		$('p#customizedDatas input').hide();
		$('#ajax-loader').fadeIn();
		$('p#customizedDatas').append(uploading_in_progress);
	});

	//init the price in relation of the selected attributes
	if (typeof productHasAttributes != 'undefined' && productHasAttributes)
		findCombination(true);
	else if (typeof productHasAttributes != 'undefined' && !productHasAttributes)
		refreshProductImages(0);

	$('a#resetImages').click(function() {
		updateColorSelect(0);
	});

	$('.thickbox').fancybox({
		'hideOnContentClick': true,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
});

function saveCustomization()
{
	$('#quantityBackup').val($('#quantity_wanted').val());
	customAction = $('#customizationForm').attr('action');
	$('body select[id^="group_"]').each(function() {
		customAction = customAction.replace(new RegExp(this.id + '=\\d+'), this.id +'='+this.value);
	});
	$('#customizationForm').attr('action', customAction);
	$('#customizationForm').submit();
}

function submitPublishProduct(url, redirect)
{
	var id_product = $('#admin-action-product-id').val();

	$.ajaxSetup({async: false});
	$.post(url+'/ajax.php', { submitPublishProduct: '1', id_product: id_product, status: 1, redirect: redirect },
		function(data)
		{
			if (data.indexOf('error') === -1)
				document.location.href = data;
		}
	);

	return true;
}

function checkMinimalQuantity(minimal_quantity)
{
	if ($('#quantity_wanted').val() < minimal_quantity)
	{
		$('#quantity_wanted').css('border', '1px solid red');
		$('#minimal_quantity_wanted_p').css('color', 'red');
	}
	else
	{
		$('#quantity_wanted').css('border', '1px solid #BDC2C9');
		$('#minimal_quantity_wanted_p').css('color', '#374853');
	}
}

function getCombinationById(id_combination)
{
	passed = false;
	$.each(combinations, function(key, value)
	{
		if (value['idCombination'] == id_combination)
		{
			passed = true;
			selectedCombination = value;
			$.each(value['idsAttributes'], function(key, value){
				$('#attributes select option[value='+value+']').attr('selected','selected');
			})
		}
	})
	if (passed)
	{
		refreshProductImages(id_combination);
		$('#wrapResetImages').show('slow');
	}
}
/*$(document).ready(function() {
	$("#corporate-user-add-to-list").click(function()
	{	
		$.ajax({
         type: "post",
         url: "addtorate.php",
         data:{id_product:id_product,id_customer:id_customer},
		 success: function(data) //this function to be called if the request succeeds
		 {
			 if(data==true)
			 {
			 alert(" Item added to the list");
			 }
		 	else if(data==false)
			{
			alert(" Item already exist in the list");
			}
		 }
		});		 
	});    
});*/

/*Bulk Enquiry JS*/
function bqShowHint(i)
{
	if(i==2)
		$('#bq_hint_price').show();
	else if(i==3)
		$('#bq_hint_pin_code').show();
}

function bqHideHint(i)
{
	if(i==2)
	{
		$('#bq_hint_price').hide();
		bqValidatePrice();
	}
	else if(i==3)
	{
		$('#bq_hint_pin_code').hide();
		bqValidatePinCode();
	}
	else if(i==1)
		bqValidateQty();
	else if(i==6)
		bqValidateEmail();
	else if(i==7)
		bqValidatePassword();
	else if(i==8)
		bqValidateName();
	else if(i==9)
		bqValidatePhone();
}

function bqValidatePhone()
{
	if($('#bq_phone').val() && $.isNumeric($('#bq_phone').val()) && $('#bq_phone').val().length == 10)
	{
		$('#bq-phone-error').hide();
		return true;
	}
	else
	{
		$('#bq-phone-error').show();
		return false;
	}
}

function bqValidateName()
{	
	var pattern = new RegExp(/^[a-zA-Z\s]+$/);
	if($('#bq_name').val() && pattern.test($('#bq_name').val()))
	{
		$('#bq-name-error').hide();
		return true;
	}
	else
	{
		$('#bq-name-error').show();
		return false;
	}
}

function bqValidatePassword()
{	
	if($('#bq_password').val() && $('#bq_password').val().length >= 5)
	{
		$('#bq-password-error').hide();
		return true;
	}
	else
	{
		$('#bq-password-error').show();
		return false;
	}
}

function bqValidateEmail()
{
	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	
	if($('#bq_email').val() && pattern.test($('#bq_email').val()))
	{
		$('#bq-email-error').hide();
		return true;
	}
	else
	{
		$('#bq-email-error').show();
		return false;
	}
}

function bqValidateQty()
{
	if($('#bq_quantity').val() && $.isNumeric($('#bq_quantity').val()))
	{
		$('#bq-qty-error').hide();
		return true;
	}
	else
	{
		$('#bq-qty-error').show();
		return false;
	}
}

function bqValidatePrice()
{
	if($.isNumeric($('#bq_target_price').val()))
	{
		$('#bq-price-error').hide();
		return true;
	}
	else
	{
		$('#bq-price-error').show();
		return false;
	}
}

function bqValidatePinCode()
{
	if($('#bq_pincode').val() && $.isNumeric($('#bq_pincode').val()) && $('#bq_pincode').val().length == 6)
	{
		$('#bq-pin-code-error').hide();
		return true;
	}
	else
	{
		$('#bq-pin-code-error').show();
		return false;
	}
}
	
function bqGetQuote(logged)
{
	var pinCodeCheck = bqValidatePinCode();
	var priceCheck = bqValidatePrice();
	var qtyCheck = bqValidateQty();
	if(pinCodeCheck && priceCheck && qtyCheck){
		if(logged)
			//Store Data
			//alert("Loggged In");
			saveRequest(1);
		else{
			$('#bg-get-details').hide();
			$('#bq_auth').show();
		}
	}
}

function bqAccCheck()
{
	if(!$('#bq-kob-account').prop('checked'))
	{
		$("#bq_auth h3").html("Sign Up to Continue");
		$('.bq_new_acc').show();
		$('#bq_sign_in').hide();
	}
	else
	{
		$("#bq_auth h3").html("Sign In to Continue");
		$('.bq_new_acc').hide();
		$('#bq_sign_in').show();
	}
}

function bqSignIn()
{
	var dataparam = 'email=' + $('#bq_email').val() +'&password='+$('#bq_password').val();
	$("#bq_wait").show();
  	$.ajax({
			type: 'POST',
			dataType: 'json',
			async: true,
			url: baseDir + 'authenticateCheck.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
				if(data == 1)
				{
					saveRequest(0);
				}
				else
				{
					$('#bq-login-error').show();
					$("#bq_wait").hide();
				}
			}
	});
}

function saveRequest(logged)
{
	$.ajax({
			type: 'POST',
			dataType: 'json',
			async: true,
			url: baseDir + 'bqProcessRequest.php',
			data: 'ajax=true&'+'logged='+logged+'&'+$('#bq_product_form').serialize(),
			cache: true,
			success: function(data)
			{
				if(data == 1)
				{
					$('#bq_auth').hide();
					$('#bg-get-details').hide();
					$('#bq_complete').show();
					
					//$('#fancybox-content').css('width', '725px');
					var current_width = 700;
					parent.$('#fancybox-outer').width(current_width + 25);
					parent.$('#fancybox-wrap').width(current_width + 25);
					parent.$('#fancybox-content').width(current_width);
					parent.$('.fancybox-inner').width(current_width + 25);
					
					$.fancybox.resize();
					parent.$.fancybox.center();
					
					//$('#fancybox-close').hide();
				}
				$("#bq_wait").hide();
			}
			
	});
}

function createNewAccount()
{
	$("#bq_wait").show();
	var dataparam = 'email=' + $('#bq_email').val() +'&password='+$('#bq_password').val() +'&name='+$('#bq_name').val() +'&phone='+$('#bq_phone').val();
   	$.ajax({
			type: 'POST',
			dataType: 'json',
			async: true,
			url: baseDir + 'createNewAccount.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
				if(data == 1)
				{
					saveRequest(0);
				}
				else if (data == 2)
				{
					$('#bq-acc-exists').show();
					$('#bq-kob-account').prop('checked', true)
					bqAccCheck();
					$("#bq_wait").hide();
				}
				else if (data == 0)
				{
					$('#bq-create-acc-error').show();
					$("#bq_wait").hide();
				}
			}
			
	});
}

function bqComplete()
{
	parent.jQuery.fancybox.close();
}

// $(document).ready(function(){
// 	$('p,div,h1,h2,h3,h4,h5,h6,span,sub,li,ul,sup,label,input,strong')
//     .filter(function() {
//         return $.trim($(this).text()) === '' && $(this).children().length == 0
//     })
//     .remove();
// });