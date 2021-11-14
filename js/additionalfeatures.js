/*Created By Sreeni on 23-DEC-2015
Created this file for upgrade the prestashop version 1.4.8.1->1.6.1.3
This file contains all additional feature's JS functions  which the prestashop dosen't have.
This is the only file we need to write the aditional features codes.
*/
$( document ).ajaxStart(function() {
  $( ".preloader" ).show();
});
$( document ).ajaxStop(function() {
  $( ".preloader" ).hide();
});
/*Picode Code Feature for Product.tpl*/
$("#pincode").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});
			
function fn_remove()
{
 	$('#pincode').attr('placeholder','');
  	$('#pincode').focusout(function(){
	$(this).attr('placeholder',"Pincode");
	});
}

 /*******this is for to check the pincode avialiable or not *******/
  function locationcheck()
{
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
					 $('#add_to_cart').addClass('disabled');
					 $('#hiddenpincode').val(0);
				}
				else{
					 $('#pin_check').hide();
					 
					 $('#hiddenpincode').val(1);
				}
			}
		});
		
}

	function showpincode(obj){
	var pincode=obj.value;
	if(pincode.length != 6){
		$('#pin_notavailable, #pin_available').addClass('unvisible');		 
		$('#valid_pincode').removeClass('unvisible');
		return false;
 	}
	var pincodelength=obj.value.length;
 	var dataparam = "pincode="+pincode+"&id_product="+id_product;
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
 								 $('#pin_available').removeClass('unvisible');
 								 $('#add_to_cart').removeClass('disabled');
								 
								 $('#valid_pincode, #pin_notavailable').addClass('unvisible');
 								 
								 $('#hiddenpincode').val(1);
							}
							else if(jsonData.status == 0)
							{ 		
								
 								 $('#pin_available, #valid_pincode').addClass('unvisible');
								 $('#add_to_cart').addClass('disabled');
 								 $('#pin_notavailable').removeClass('unvisible');
								 $('#hiddenpincode').val(0);
							}
							else
							{
 								 $('#pin_available, #pin_notavailable').addClass('unvisible');
								 $('#valid_pincode').removeClass('unvisible');
								 $('#add_to_cart').addClass('disabled');
 								$('#hiddenpincode').val(2);
							}
					}
				}
			});
}
function checkPinCode()
{
  	if($('#hiddenpincode').val() == 0)
	{
 		$('#add_to_cart').unbind('click');
		return false;
	}
	else if($('#hiddenpincode').val() == 1)
	{
 		$('#add_to_cart').bind('click');
		return false;
	}
}

/*End of Pincode Function in product.tpl*/


/* Verify-documentation for customer */

function documentVerification()
{
 	$.ajax({
	       type: 'GET',
	       url: baseDir + 'buyer-verify.php',
	       /*async: false,*/
	       cache: false,
	       dataType: 'json',
	       data: 'ajax=true&id_customer='+id_customer+'',
	       success: function(jsonData)
	       {
 	       		$('.verified').html("");
	       		if(jsonData == 0)
	       		{
 	       			$('.verified').append('<div class="verification-pending">\
	       								   <span><i class="fa fa-exclamation-triangle"></i></span>\
	       								   <span>Verification Pending. In Order to verify that you are a business customer, You will have to upload a document. You can upload it now by</span>\
	       								   <a href="#"  onclick="openNewPop();">clicking here</a>\
	       								   <span>or you can upload it later.</span></div>');
	       		}
	       		else
	       		{
	       			$('.verified').html("");
					if(window.opener)
					{
 						window.opener.location.reload(); // or opener.location.href = opener.location.href;
						window.close(); // or self.close();
						//open.location.href = open.location.href;
						//self.close();
					}
	       		}
	       }
	});
}

function openNewPop()
{
	window.open("verify-document.php", "newwindow", "width=1100, height=650, left=125"); 
	return false;
}
 
/**/ 
/**/

$(document).ready(function(){
	 


$('#pincode_select').bind('keyup', function(e) {
    if ( e.keyCode === 13 ) { // 13 is enter key
    	$("#kob_state_select_btn").click();
    }
});

	/* Check state selection on selecting address step */
	    /*$("#processAddress").click(function( event ) {
		  event.preventDefault();
		  var selected = $("#id_address_delivery").find('option:selected');
	      var state_selected = selected.data('state');
	      if(id_state_vat!=state_selected)
	      {
	      	$('#error_modal .modal-body').html("Pincode selected and address chosen are mismatching");
	      	$('#error_modal').modal('show');
	      }
	      else
	      {
	      	$("#processAddressForm").submit();
	      }
 
		});
 
		});*/
 
 
	/**/
	//Company Offers Slider
	var companyOffersSlider;
	$(function() {
	    companyOffersSlider = $('#company-offers-slider').bxSlider({
	        slideWidth: 230,
			slideMargin: 20,
			pager: false,
	    });
	    $("a.company").click(function() {
	        $('[data-user-type="company"].offers-block').removeClass('hidden');
	        $('[data-user-type="retailer"].offers-block').addClass('hidden');
	        companyOffersSlider.reloadSlider();
	    });
	});
	//Retailer Offers Slider
	var retailerOffersSlider;
	$(function() {
	    retailerOffersSlider = $('#retailer-offers-slider').bxSlider({
	        slideWidth: 230,
			slideMargin: 20,
			pager: false,
	    });
	    $("a.retailer").click(function() {
	        $('[data-user-type="retailer"].offers-block').removeClass('hidden');
	        $('[data-user-type="company"].offers-block').addClass('hidden');
	        retailerOffersSlider.reloadSlider();
	    });
	});	
	/* bx slider or home page carousel*/
	var containerDivWidth=parseInt($(".bxslider").parents("#center_column").css("width"));

    //var productPageSelector= "body#product";
    var bodySelector = $("body").attr("id");

	if(isNaN(containerDivWidth)){
		return ;
	}
    else if(bodySelector=="product"){
        if(containerDivWidth<=480){
            $('.bxslider').bxSlider({			
                minSlides: 1,
                maxSlides: 1,
                slideWidth: 240,
                moveSlides: 1,
                pager: false,
                nextText: '',
                prevText: '',
                moveSlides:1,
                infiniteLoop:false,
                hideControlOnEnd: false
            });
        }
        else if(containerDivWidth<=768){
            $('.bxslider').bxSlider({			
                minSlides: 1,
                maxSlides: 2,
                slideWidth: 240,
                moveSlides: 1,
                pager: false,
                nextText: '',
                prevText: '',
                moveSlides:1,
                infiniteLoop:false,
                hideControlOnEnd: false

            });
        }
        else{
            $('.bxslider').bxSlider({			
                minSlides: 1,
                maxSlides: 4,
                slideWidth: 240,
                moveSlides: 1,
                pager: false,
                nextText: '',
                prevText: '',
                moveSlides:1,
                infiniteLoop:false,
                hideControlOnEnd: false

                
            });
        }
    }
    else if(containerDivWidth){
	   if(containerDivWidth<=480){
		$('.bxslider').bxSlider({			
				minSlides: 1,
				maxSlides: 1,
				slideWidth: 243,
				moveSlides: 1,
				//slideMargin: 20,
				pager: false,
				nextText: '',
				prevText: '',
				moveSlides:1,
				infiniteLoop:false,
				hideControlOnEnd: false			
			});
		}
		else if(containerDivWidth<=768){
			$('.bxslider').bxSlider({			
				minSlides: 1,
				maxSlides: 3,
				slideWidth: 232,
				moveSlides: 1,
				//slideMargin: 20,
				pager: false,
				nextText: '',
				prevText: '',
				moveSlides:1,
				infiniteLoop:false,
				hideControlOnEnd: false			
			});
		}
		else{
			$('.bxslider').bxSlider({			
				minSlides: 1,
				maxSlides: 4,
				slideWidth: 240,
				moveSlides: 1,
				//slideMargin: 20,
				pager: false,
				nextText: '',
				prevText: '',
				moveSlides:1,
				infiniteLoop:false,
				hideControlOnEnd: false
			});
		}
}
	/***/

	/*category on home page right column*/
		$(".category_2").removeClass("hidden");
		$(".category-product .category:not(:first)").removeClass("arrow category-bg");
		var idCategory=$(".category-product .category:first").attr("id");
		$("#view_all_category").attr("href","index.php?id_category="+idCategory+"&controller=category&id_lang=1");
		//$(".category-section .category").gt(0).addClass("arrow category-bg");
		$('.category').click(function(){
			$(".category").removeClass("arrow category-bg");
			$(this).addClass("arrow category-bg");
			$(".category-product-col").addClass("hidden");
			$(".category_"+this.id).removeClass("hidden");
			$("#view_all_category").attr("href","index.php?id_category="+this.id+"&controller=category&id_lang=1");
		});
});
function numbersOnly(e)
{
	var key=e.keyCode;
	if(!((key==8)||(key==46)||(key==190)||(key==110)||(key==9)||(key==110)||(key==109)||(key==173)||(key==107)||(key>=35&&key<=40)||(key>=48&&key<=57)||(key>=96&&key<=105)))
	{
		e.preventDefault();
	}
}
$(document).ready(function(){
	$("#star_rating").click(function(){
		$("#rating_product_li").click();
		if ($("#rating_product_tab").is(':visible')) {
		     $("html, body").animate({scrollTop: $("#rating_product_tab").offset().top});
		  }
	});
});

	$(document).on('click', '.product_quantity_up', function(e){
			e.preventDefault();
		//fieldName = $(this).data('field-qty');
		fieldId = $(this).data('field-id');
		//var currentVal = parseInt($('input[name='+fieldName+']').val());
		var currentVal = parseInt($('#quantity_wanted_'+fieldId).val());
		var quantityAvailable=$('#quantity_wanted_'+fieldId).data('field-qtyAvailable');
		if (quantityAvailable > 0)
			quantityAvailableT = quantityAvailable;
		else
			quantityAvailableT = 100000000;
		if (!isNaN(currentVal) && currentVal < quantityAvailableT)
			$('#quantity_wanted_'+fieldId).val(currentVal + 1).trigger('keyup');
		else
			$('#quantity_wanted_'+fieldId).val(quantityAvailableT);
	});
	 // The button to decrement the product value
	$(document).on('click', '.product_quantity_down', function(e){
		e.preventDefault();
		fieldId = $(this).data('field-id');
		var currentVal = parseInt($('#quantity_wanted_'+fieldId).val());
		if (!isNaN(currentVal) && currentVal > 1)
			$('#quantity_wanted_'+fieldId).val(currentVal - 1).trigger('keyup');
		else
			$('#quantity_wanted_'+fieldId).val(1);
	});
/*Create customer with verification doc*/
function showUploadDocument()
{
 $('.doc input').on('change', function() {
   var show_doc = $('input[name="upload_document"]:checked', '.doc').val(); 
     if(show_doc == 2)
    {
 	   $(".upload").addClass("unvisible");
	}
	else
	{
 		$(".upload").removeClass("unvisible");
	}
});
}

//Show or Hide Navbar onScroll
$(window).scroll(function(){
    if ($(window).scrollTop() >= 1) {
        $('#header').addClass('fixed-header');
        $('.searchbar').not('.search-block').addClass('unvisible');
        $(".ac_results").addClass('unvisible');
    }
    else {
        $('#header').removeClass('fixed-header');
        $('.searchbar, .ac_results').removeClass('unvisible');
    }
});

//Trader and Company Usermode Select
$(document).ready(function(){
    var $retailerButton = $('a.retailer'), 
	    $companyButton = $('a.company'),
	    $companySwitch =$('.switch-container .company'),
	    $retailerSwitch =$('.switch-container .retailer')
	    $retailerContents = $('[data-user-type="retailer"]'),
	    $companyContents = $('[data-user-type="company"]'),
	    $customerType = $('.customer-type');

	$retailerButton.click(function(){
		$retailerSwitch.addClass("switch-mode-selected");
		$companySwitch.removeClass("switch-mode-selected").addClass("switch-mode");
		$companyContents.addClass('hidden');
    	$retailerContents.removeClass('hidden');
    	$customerType.html("RETAILER");
	});
	$companyButton.click(function(){
		$companySwitch.addClass("switch-mode-selected");
		$retailerSwitch.removeClass("switch-mode-selected").addClass("switch-mode");
		$retailerContents.addClass('hidden');
    	$companyContents.removeClass('hidden');
    	$customerType.html("COMPANY");
	});
	$('[data-user-type="retailer"]').addClass('hidden');
});

// Scroll to top
$(document).ready(function(){
	var $scrollToTop = $('.scroll-to-top');
	//Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 900) {
			$scrollToTop.fadeIn();
		} else {
			$scrollToTop.fadeOut();
		}
	});
	
	//Click event to scroll to top
	$scrollToTop.click(function(){
		$('html, body').animate({scrollTop : 0},1200,'swing');
		return false;
	});
	
});

//Animation for Scrolling
$(document).ready(function(){
	$('a.smooth-scroll').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash;
	    var $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 1200, 'swing', function () {
	        window.location.hash = target;
	    });
	});
});

/*Zoho Chat Plugin*/
$(document).ready(function(){var $zoho=$zoho||{livedesk:{values:{},ready:function(){}}};var d=document;s=d.createElement("script");s.type="text/javascript";s.defer=true;s.src="https://salesiq.zoho.com/support.kobstereshoppvtltd/float.ls?embedname=kobstereshoppvtltd";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);});function online_chat()
{$("#zls_ctn_wrap").click();}

// Initializing Tooltip
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip()
});

// Reseller and Company Switch Content for Registration
$(document).ready(function(){
	$('#doc1.company').click(function(){
		$('.user-benefits-section [data-user-type="company"]').removeClass('hidden');
		$('.user-benefits-section [data-user-type="retailer"]').addClass('hidden');
	});
	$('#doc2.retailer').click(function(){
		$('.user-benefits-section [data-user-type="retailer"]').removeClass('hidden');
		$('.user-benefits-section [data-user-type="company"]').addClass('hidden');
	});
	$('.user-benefits-section [data-user-type="retailer"]').addClass('hidden');
});
