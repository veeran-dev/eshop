var idProduct = 0, firstname = '';
/*
	toast pop-up used here to avoid modal pop-up appearing every time on success,error,etc
	param1 - message
	param2 - message type like success,warning,error,etc
*/
$(document).ready(function()
{
	$('.date_picker').datepicker({
        format: 'yyyy-mm-dd hi:s:a'
    });

	$( document ).tooltip();
	$('.select-state').hide();
	var quote_type = $('#quote_type').val();
	var duration = 0;
	if (quote_type == 8)
	{
		searchCustomer(duration);
	}
	window.product = {};
	$("#scn-customer-list-select").autocomplete("scn-quotation-ajax.php?type=1",
	{
		minChars: 1,
		max: 10,
		dataType: "json",
		formatItem: function(data, i, max, value, term)
		{
			return value;
		},
		parse: function(data)
		{
			if (data == "")
			{
				return data;
			}
			else
			{
				var mytab = new Array();
				for (var i = 0; i < data.length; i++) mytab[mytab.length] = {
					data: data[i].name + "~" + data[i].id_group,
					value: "<div><span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>" + data[i].name + "</br>" + "Company Id:" + data[i].id_group + "</span></div>"
				};
				return mytab;
			}
		},
	}).result(function(event, data, formatted, value)
	{
		var seperate = data.split('~');
		openQuotePage(seperate[0], seperate[1]);
		company_id = seperate[1];
		firstname = seperate[0];
		selectRegion();
		$('#selectRegionBlock').show();
		$("#scn-customer-list-select").val('');
		$("#scn-customer-list-select").val(seperate[0]);
	});
	$('#add-product-revise').html($('#add-product-scn-revise').show());
	$('#add-prod-btn-revise-view').attr('disabled', 'true');
	$('#add-product-revise').show();
	$('#add-product-revise').css(
	{
		'margin-top': '-6px'
	});
});

function selectRegion()
{
	$.ajax({
        type: 'POST',
        dataType: 'json',
        async: true,
        url: 'scn-quotation-ajax.php',
        data: '&type=10',
        cache: true,
        beforeSend: function() {$(".ajaxLoaderModal").show();},
        success: function(data) {
        	if(data == '')
        	{
        		$('#regionSelection').html('');
        		$('#create-quotation').hide();
        	}
        	else
        	{
        		var regionText = "";
        		$('#regionSelection').html('');
	            regionText = "<div class='col-xs-12'>\
	            				<div class='col-xs-12'>\
	            					<label class='checkbox'>\
	            						<input type='checkbox' class='check_all' onchange='checkUncheckRegions(this)' name='locations_all' value='0'> PAN India\
	            					</label>\
	            				</div><div class='col-xs-12'>";
	            for(var k = 0; k < data.length; k++)
                    regionText += "<label class='checkbox'>\
                						<input type='checkbox' class='check' name='locations' onchange='checkParticularRegions("+data.length+")' value="+data[k].zone_id+"> "+data[k].zone_name+"\
                				   </label>";                    
	            regionText += "</div><div class='col-xs-12'><div class='marginTop12'><button type='button' onclick='changeRegion("+data.length+")' class='btn btn-primary'>Submit</button></div></div></div>";
	            $('#regionSelection').append(regionText);
	        }
        },
        complete: function(){$(".ajaxLoaderModal").hide();}
    });    
}

function checkUncheckRegions(checked) {
	var checked = $(checked).prop('checked');
	if(checked) {
		$('.check').prop('checked', true).attr('disabled', true);
	}
	else {
		$('.check').prop('checked', false).attr('disabled', false);
	}
}

function checkParticularRegions(regions_length) {
	var region_ids = $('.check:checked').map(function(){
        return $(this).val();
    }).get();

    if(region_ids.length == regions_length) {
    	$('.check_all').prop('checked', true);
    	$('.check').prop('checked', true).attr('disabled', true);
    }
}

function numbersOnly(e)
{
	var key = e.keyCode;
	if (!((key == 8) || (key == 46) || (key == 190) || (key == 188) || (key == 9) || (key == 109) || (key == 173) || (key == 107) || (key >= 35 && key <= 40) || (key > 46 && key < 59) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}

$('#quotationHistory').slimScroll(
{
	height: "415px",
	wheelStep: 1,
	railVisible: true,
	alwaysVisible: true
});

function searchCustomer(duration)
{
	$('#quotation-block').show();
}

$(document).ready(function(){
	searchProduct("#focusedInputQuotation", "scn_quote_create");
	searchProduct("#focusedInputQuotationRevise", "scn_quote_revise");
});

var dataHideQuote = function(){
	$('#update-quote').hide();
	$('#revise-quote').hide();
	$('#search-add-prod').hide();
	$('#cusSearchBlock').show();
}

function changeRegion(regions_length)
{
	$('#regions').val("");
	var checked_all_region = $('.check_all').prop('checked');
	var checked_some_region = $('.check').prop('checked');
	if(!checked_all_region) {
		var region_ids = $('.check:checked').map(function(){
            return $(this).val();
        }).get();

        if(region_ids.length == regions_length) {
        	$('.check_all').prop('checked', true);
        	$('#regions').val(1);
        }
        else {
        	$('#regions').val(region_ids);
        }
	}
	else {
		$('#regions').val(1);
	}

    if(checked_all_region || $('#regions').val()) {
    	$('#create-quotation').show();
		dataHideQuote();
	    $('#selectRegionBlock').hide();
    }
    else {
    	toast("Please select atleast one location","error");
    }
}


function openQuotePage(name, id_company)
{

	$('.select-state').attr('disabled',false);
	$('.select-state').show();
	dataHideQuote();
	$('#create-quotation').hide();
	company_id = id_company;
}

function quotationAdd()
{
	var quote_name = $('#inputQuoteName').val();
	var exp = new RegExp('[!<>;?=+()@#"�{}_$%:]');
	if(exp.test(quote_name))
    {
        toast("invalid quote name","warning");
        return false;
    }

	$.ajax(
	{
		type: 'POST',
		async: true,
		dataType: 'json',
		url: 'scn-quotation-ajax.php',
		data: '&type=2&q=' + quote_name + '&id_company=' + company_id + '&id_employee=' + id_employee + '&id_state=' + $('#regions').val(),
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if (data == '0')
			{
				toast("Quotation already exists","error");
			}
			else
			{
				scn_quote_id = data[0];
				$('#view-cus-prices').hide();
				$('.modal-close').click();

				toast("Quote Created Successfully","success");

				$('#inputQuoteName').val('');
				$('#inputQuoteName').attr('placeholder','Enter Quotation Name');
				$('#quote-create-form').hide();
				$('#create-quotation').hide();
				$('#update-quote').hide();
				$('#cusSearchBlock').hide();
				$('#revise-quote').hide();
				$('#search-add-prod').show();
				$('#quotation-block').show();
				$('#quote_name_span').html('');
				$('#quote_name_span').html("(Quote Name: " + quote_name + ", Regions: "+data[1]+")").css({"text-transform": "lowercase"});
				$('#rm_shopping_cart_scn').html('');
				$("#focusedInputQuotation,#focusedInputQuotationRevise").val('');
				$("#focusedInputQuotation,#focusedInputQuotationRevise").attr('placeholder', 'Search for products from catalogue');
			}
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}

function updateQuote()
{
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		data: '&id_company='+ company_id +'&type=4',
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			$('#quotation_history').html('');

			for (var i = 0; i < data.length; i++)
			{
				if(data[i].published == 1)
				{
					$('#quotation_history').append("<tr>\
														<td data-title='Quote ID'>" + data[i].id_quotation + "</td>\
														<td data-title='Quote Name' id='quote_name_" + data[i].id_quotation + "'>" + data[i].quote_name + "</td>\
														<td data-title='Quote Version'>" + data[i].quote_version + "</td>\
														<td data-title='Company'>" + data[i].company + "</td>\
														<td data-title='State'>" + data[i].state + "</td>\
														<td data-title='Created By'>"+ data[i].id_employee +"</td>\
														<td data-title='Date Generated'>" + data[i].date_generated + "</td>\
														<td data-title='Actions'><span onclick='downloadQuotation(" + data[i].id_quotation + ")' class='cur-poi padding5'><i class='fa fa-download text-success' title='Download'></i></span>\
																			 <span><a href='#viewQuoteProducts' data-toggle='modal' onclick='reviseQuotation(" + data[i].id_quotation + ",1,\"" + data[i].quote_name + "\")'><span class='cur-poi padding5'><i class='fa fa-eye text-info' title='View'></i></span></a></span>\
																			 <span onclick='reviseQuotation(" + data[i].id_quotation + ",2,\"" + data[i].quote_name + "\")' class='cur-poi padding5'><i class='fa fa-edit text-primary' title='Revise'></i></span>\
																			 <span class='text-danger padding5'>Published</span></td>\
													</tr>");
				}
				else
				{
					$('#quotation_history').append("<tr>\
														<td data-title='Quote ID'>" + data[i].id_quotation + "</td>\
														<td data-title='Quote Name' id='quote_name_" + data[i].id_quotation + "'>" + data[i].quote_name + "</td>\
														<td data-title='Quote Version'>" + data[i].quote_version + "</td>\
														<td data-title='Company'>" + data[i].company + "</td>\
														<td data-title='State'>" + data[i].state + "</td>\
														<td data-title='Created By'>"+data[i].id_employee+"</td>\
														<td data-title='Date Generated'>" + data[i].date_generated + "</td>\
														<td data-title='Actions'><span onclick='downloadQuotation(" + data[i].id_quotation + ")' class='cur-poi padding5'><i class='fa fa-download text-success' title='Download'></i></span>\
																			<span><a href='#viewQuoteProducts' data-toggle='modal' onclick='reviseQuotation(" + data[i].id_quotation + ",1,\"" + data[i].quote_name + "\")'><span class='cur-poi padding5'><i class='fa fa-eye text-info' title='View'></i></span></a></span>\
																			<span onclick='reviseQuotation(" + data[i].id_quotation + ",2,\"" + data[i].quote_name + "\")' class='cur-poi padding5'><i class='fa fa-edit text-primary' title='Revise'></i></span>\
																			<span id='published'><span class='cur-poi padding5' onclick='reviseQuotation(" + data[i].id_quotation + ",3,\"" + data[i].quote_name + "\")'><i class='fa fa-upload text-warning' title='Publish'></i></span></span></td>\
													</tr>");
				}
			}

			$('#update-quote').show();
			$('#create-quotation').hide();
			$('#revise-quote').hide();
			$('#search-add-prod').hide();
			$('#cusSearchBlock').show();
			$('#quotation-block').show();
			easySearchScnQuotation('quote-list');
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}

var prodAddToCartCreate = function(){
	$("#focusedInputQuotation").val('');
	$("#focusedInputQuotation").attr('placeholder', 'Search for products from catalogue');
	$("#scn-quote-product-date").val('');
	$("#scn-revise-quote-product-date").val('');
	$('#scn-corporate-user-quantity-value').val('');
	$("#focusedInputQuotation").focus();
  	$('.productCode,.high-price-cus,.low-price-cus,#viewPriceCustomer,#viewPriceCustomerRevise,.mrp,.vat').html('');
	$('#view-cus-prices').hide();
	$('#other-cus-prices').hide();
	$('#remarksInput').val('');
}

function prodAddToCart()
{	
	var taxExclusive, mrp, product_price;
	mrp = parseFloat($('.mrp').html());
	taxExclusive = parseFloat((mrp * 100)/(100+parseFloat(tax_rate)));
	product_price = $('#scn-corporate-user-quantity-value').val();
	if(product_price > taxExclusive) {
		toast('Price should be less than MRP');
		return false;
	}
	var remarks = $('#remarksInput').val();
	var date = $("#scn-quote-product-date").val();
	if(date == '')
	{
		toast('Enter valid expiring date','warning');
		return false;
	}
	else{
		date = date +" 23:59:59";
	}

	if (Date.parse(new Date()) > Date.parse(new Date($("#scn-quote-product-date").val()))) { 
    //condition satisfied for today date too.
    	toast('Enter valid expiring date','warning');
		return false;
	}

	$.ajax({
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		data: '&type=30&id_product=' + idProduct +'&id_quotation='+scn_quote_id+'&price='+product_price+'&date='+date+'&remarks='+remarks,
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if (product.prod_reference != '' && product.prod_reference != undefined)
			{
				if ($("#rmshoppingCartRow_" + idProduct).length)
				{
					$("#rmshoppingCartRow_" + idProduct).remove();
					$("#rm_shopping_cart_scn").append("<tr class='rmshoppingCartTr' id='rmshoppingCartRow_" + idProduct + "'>\
													   <td class='col-xs-5'>" + product_name + "</td>\
													   <td id='qty_" + idProduct + "' class='col-xs-3'>" + product.prod_reference + "</td>\
													   <td id='price_" + idProduct + "' class='product_price_scn col-xs-3'>Rs. " + product_price + "</td>\
													   <td id='date_'"+idProduct+"> "+ date +"</td>\
													   <td class='fa fa-times cur-poi col-xs-1' onclick='removeProduct(" + idProduct + ")'></td>\
													   <td class='id_product_scn' style='display:none;'>" + idProduct + "</td>\
													   <td class='prod-remarks' style='display:none;'>" + remarks + "</td>\
													   <input type='hidden' name='product_array[]' value='"+scn_quote_id+"~"+idProduct+"~"+product_price+"~"+remarks+"~"+date+"'/>\
													   </tr>");
					prodAddToCartCreate();
				}
				else
				{
					$("#rm_shopping_cart_scn").append("<tr class='rmshoppingCartTr' id='rmshoppingCartRow_" + idProduct + "'>\
													   <td class='col-xs-5'>" + product_name + "</td>\
													   <td id='qty_" + idProduct + "' class='col-xs-3'>" + product.prod_reference + "</td>\
													   <td id='price_" + idProduct + "' class='product_price_scn col-xs-3'>Rs. " + product_price + "</td>\
													   <td id='date_'"+idProduct+"> "+ date +"</td>\
													   <td class='fa fa-times cur-poi col-xs-1' onclick='removeProduct(" + idProduct + ")'></td>\
													   <td class='id_product_scn' style='display:none;'>" + idProduct + "</td>\
													   <td class='prod-remarks' style='display:none;'>" + remarks + "</td>\
													   <input type='hidden' name='product_array[]' value='"+scn_quote_id+"~"+idProduct+"~"+product_price+"~"+remarks+"~"+date+"'/>\
													   </tr>");
					prodAddToCartCreate();
				}
			}
		}
	});
}

function addToQuotation()
{
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		cache: true,
		data: $('#quote-save-form').serialize() +"&type=3",
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(result)
		{ 
			$('#quote-download-btn').attr('disabled', false);
			$('#quote-download-btn').click(function() {
				downloadQuotation(scn_quote_id);
			});
		},
		complete: function(data){
			toast("Quotation Saved Successfully","success");
			$('.ajaxLoaderModal').hide();
		}
	});
}

function removeProduct(id)
{
	$('#rmshoppingCartRow_' + id).remove();
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		data: '&type=12&id_product='+id+'&id_quotation='+scn_quote_id,
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if(data == 2)
				toast('Product Removed Successfully','success');
			else
				toast('Error found.Try again later','error');
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}

function reviseQuotation(quote_id, req_type, quote_name)
{
	var type;

	$('#view-block-download-div').empty();
	$('#view-block-download-div').append('<button type="button" onclick="downloadQuotation(' + quote_id + ')" style="float:right;" class="btn btn-success" id="view-block-download"><i class="fa fa-download"></i>&nbsp;&nbsp;Download</button>');
	$("#focusedInputQuotation,#focusedInputQuotationRevise").val('');
	$("#focusedInputQuotation,#focusedInputQuotationRevise").attr('placeholder', 'Search for products from catalogue');
	
	if(req_type == 3)
	{
		type = 9;
	}
	else
	{
		if(req_type == 2 && scn_quote_id != quote_id)
			quote_revise_attempt = true;

		type = 5;
	}

	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		data: '&id_quotation=' + quote_id + '&type=' + type + '&quote_name=' + quote_name + '&id_company=' + company_id + '&id_employee=' + id_employee + '&id_state=' + $('#regions').val(),
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if (req_type == 1)
			{
				$('#quotation_history_view_scn').html('');
				for (var i = 0; i < data[0].length; i++)
				{
					if (data[0][i].product_code != null)
					{
						if(data[1][i][0].tax_rate != "NA")
							data[1][i][0].tax_rate = data[1][i][0].tax_rate+"%";

						$('#quotation_history_view_scn').append("<tr><td class='col-md-5'>" + data[0][i].product_name + "</td>\
																<td class='col-md-3'>" + data[0][i].product_code + "</td>\
																<td class='col-md-2'>" + data[1][i][0].tax_rate + "</td>\
																<td class='col-md-2'>" + parseFloat(data[0][i].price).toFixed(2) + "</td>\
																<td class='col-md-2'>" + data[0][i].to + "</td>\
																<td class='product-id-hide' style='display:none;'>" + data[0][i].product_id + "</td>\
																</tr>");
					}
				}

				scn_quote_id = quote_id;
			}
			else if (req_type == 2)
			{
				$('#quotation_history_view').html('');
				$('#view-cus-prices-revise').hide();
				$('#revise-quote-name').html('(Quote Name: ' + quote_name + ', Regions: '+data[2].regions+')');
				$('#quotation_name_revise').html('Quotation Name:' + quote_name);
				var errorClass = '';
				for (var i = 0; i < data[0].length; i++)
				{
						if (data[0][i].product_code != null)
						{
							if(data[1][i][0].tax_rate != "NA")
								data[1][i][0].tax_rate = data[1][i][0].tax_rate+"%";

							if (Date.parse(new Date()) > Date.parse(data[0][i].to)) { 
						    	errorClass = 'has-error';
							}

							$('#quotation_history_view').append("<tr id='revise-quote-row-"+data[0][i].product_id+"'>\
																	 <td class='col-md-3'>" + data[0][i].product_name + "</td>\
																	 <td class='id_product_scn clo-md-2'>" + data[0][i].product_code + "</td>\
																	 <td class='col-md-2 tex-ali-cen'>"+ data[1][i][0].tax_rate +"</td>\
																	 <td class='col-md-2'>\
																	 		<input onkeydown='numbersOnly(event)' onchange='changePrice("+data[0][i].product_price+","+scn_quote_id+","+data[0][i].product_id+",\"" + data[0][i].remarks + "\","+data[0][i].price+",\""+data[0][i].to+"\")' id='focusedInput_"+data[0][i].product_id+"'  style='height:27px;width:108px;' class='form-control tex-ali-cen dash-search-box scn-corporate-user-quantity-value-"+data[0][i].product_id+"' type='text' value=" + parseFloat(data[0][i].price).toFixed(2) + " maxlength='10' tabindex='2' style='width:110px;'>\
																	 </td>\
																	 <td class='col-md-2'>\
																	 	<input id='' readonly='true' type='text' onchange='changeDate("+data[0][i].product_price+","+scn_quote_id+","+data[0][i].product_id+",\"" + data[0][i].remarks + "\",\"" + data[0][i].price + "\",this)' class='form-control date_picker_new_"+data[0][i].product_id+" "+errorClass+"' value='" + data[0][i].to + "'/>\
																	 </td>\
																	 <td id='hover-delete-scn' onclick='removeProductQuote(" + data[0][i].product_id + ", "+scn_quote_id+")' class='col-md-1'>\
																	 	<a href='#'><i class='fa fa-trash-o'></i></a>\
																	 </td>\
																	 <td class='product-id-hide' style='display:none;'>" + data[0][i].product_id + "</td>\
																	 <td class='prod-remarks-revise' style='display:none;'>" + data[0][i].remarks + "</td>\
																 </tr>");
							$('.date_picker_new_'+data[0][i].product_id).datepicker({
					            format: 'yyyy-mm-dd hi:s:a'
					        });
						}
				}

				scn_quote_id = quote_id;
				$('#revise-quote').show();
				$('#update-quote').hide();
				$('#create-quotation').hide();
				$('#search-add-prod').hide();
				$('#cusSearchBlock').hide();
				$('#quotation-block').show();
			}
			else if(req_type == 3)
			{
				if(data == 1)
				{
					toast("Quotation Published Successfully","success");
					//updateQuote();
					$('#quote_name_'+quote_id+' ').parent('tr').find('td:last #published').html('Published');
					$('#quote_name_'+quote_id+' ').parent('tr').find('td:last #published').addClass('text-danger');
				}
				else
				{
					toast("Failed to publish quotation","error");
				}
			}
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}

function reviseQuote()
{
	var count = 0;
	$('.date_picker_new').each(function(){
		var new_date = $(this).attr('value');
		if (Date.parse(new Date()) > Date.parse(new Date(new_date))) { 
	    	//condition satisfied for today date too.
	    	count = 1;
	    	toast('Enter valid expiring date','warning');
			return false;	
		}
	});

	if(count == 1)
	{
		return false;
	}
	
	
	$.ajax({
		type: 'POST',
		async: true,
		dataType: 'json',
		url: 'scn-quotation-ajax.php',
		data: $('#quote-revise-form').serialize()+'&type=6&q=' + (($('#quotation_name_revise').html()).split(':'))[1] + '&id_company=' + company_id + '&id_employee=' + id_employee + '&id_state=' + $('#regions').val(),
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data) 
		{
			if(data == 1)
			{
				toast("Quotation Revised Successfully.","success");
				updateQuote();
			}
			else
			{
				toast("Error in revising quotation.","error");
			}
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}


function removeProductQuote(id, quote_id)
{
	if(quote_revise_attempt == true) {
		toast("You can't delete product from existing quote. Quote changes required to delete.", "error");
	}
	else {
		$('#revise-quote-row-'+id).remove();
		$.ajax({
			type: 'POST',
			async: true,
			dataType: 'json',
			url: 'scn-quotation-ajax.php',
			data: 'type=31&id_quotation='+quote_id+'&id_product='+id,
			cache: true,
			beforeSend: function() {$(".ajaxLoaderModal").show();},
			success: function(data) 
			{},
			complete: function() {$(".ajaxLoaderModal").hide();}
		});
	}
}

var reviseRepeatCode = function(){
	$("#focusedInputQuotationRevise").val('');
	$("#focusedInputQuotationRevise").focus();
	$("#focusedInputQuotationRevise").select();
	$("#focusedInputQuotationRevise").attr('placeholder', 'Search for products from catalogue');
	$('#scn-corporate-user-quantity-value-revise').val('');
  	$('.productCode,.high-price-cus,.low-price-cus,#viewPriceCustomer,#viewPriceCustomerRevise,.mrp,.vat').html('');
	$('#view-cus-prices-revise').hide();
	$('#other-cus-prices-revise').hide();
	$('#remarksInputRevise').val('');
}

function addToTableRevise()
{
	var taxExclusive, mrp, product_price;
	mrp = parseFloat($('.mrp').html());
	taxExclusive = parseFloat((mrp * 100)/(100+parseFloat(tax_rate)));
	product_price = $('#scn-corporate-user-quantity-value-revise').val();
	if(product_price > taxExclusive) {
		toast('Price should be less than MRP');
		return false;
	}

	var date = $("#scn-revise-quote-product-date").val();	

	if(date == '')
	{
		toast('Enter valid expiring date','warning');
		return false;
	}
	else{
		//date = date +' 59:59:59';
	}
	if (Date.parse(new Date()) > Date.parse(new Date($("#scn-revise-quote-product-date").val()))) { 
    //condition satisfied for today date too.
    	toast('Enter valid expiring date','warning');
		return false;
	}

	$.ajax(
	{
		type: 'POST',
		async: true,
		dataType: 'json',
		url: 'scn-quotation-ajax.php',
		data: {
			type: 7,
			id_product: idProduct,
			quote_revise_attempt: quote_revise_attempt,
			id_quotation: scn_quote_id,
			id_company: company_id,
			q: (($('#quotation_name_revise').html()).split(':'))[1],
			id_employee: id_employee,
			id_state: $('#regions').val(),
			remarks: $('#remarksInputRevise').val(),
			price: product_price,
			date: $("#scn-revise-quote-product-date").val()
		},
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if(data != "") {
				if(data == 0 || data == 1) {
					toast("Error in adding product to quote.", "error");
				}
				else {
					scn_quote_id = data[1];
					quote_revise_attempt = false;

					if(data[0].tax_value != "NA")
						data[0].tax_value = data[0].tax_value+"%";

					if ($('#revise-quote-row-'+data[0].id).length) {
						$('#revise-quote-row-'+data[0].id).remove();
						var remarks = $('#remarksInputRevise').val();
						$('#quotation_history_view').append("<tr id='revise-quote-row-"+data[0].id+"'>\
																<td class='col-md-3'>" + data[0].name[1] + "</td>\
																<td class='id_product_scn col-md-2'>" + data[0].reference + "</td>\
																<td class='col-md-2 tex-ali-cen'>" + data[0].tax_value + "</td>\
																<td class='col-md-2'>\
																	<span>\
																		<input onkeydown='numbersOnly(event)' onchange='changePrice("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+data[0].quoted_price+",\""+data[0].to+"\")' id='focusedInput_"+data[0].id+"'  style='height:27px;width:108px;' class='form-control tex-ali-cen dash-search-box' type='text' value=" + data[0].quoted_price + " maxlength='10' tabindex='2' style='width:110px;'>\
																</td>\
																<td class='col-md-2'>\
																<input type='text' readonly='true' class='form-control date_picker_"+idProduct+"'  onchange='changeDate("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+ data[0].quoted_price +",this)' value="+data[0].to+">\
																</td>\
																<td id='hover-delete-scn' onclick='removeProductQuote(" + data[0].id + ", "+scn_quote_id+")' class='col-md-1'>\
																	<a href='#'><i class='fa fa-trash-o'></i></a>\
																</td>\
																<td class='product-id-hide' style='display:none;'>" + data[0].id + "</td>\
																<td class='prod-remarks-revise' style='display:none;'>" + remarks + "</td>\
																</tr>");
						reviseRepeatCode();
					}
					else {
						var remarks = $('#remarksInputRevise').val();					
						$('#quotation_history_view').append("<tr id='revise-quote-row-"+data[0].id+"'>\
																<td class='col-md-3'>" + data[0].name[1] + "</td>\
																<td class='id_product_scn col-md-2'>" + data[0].reference + "</td>\
																<td class='col-md-2 tex-ali-cen'>" + data[0].tax_value + "</td>\
																<td class='col-md-2'>\
																<span>\
																	<input onkeydown='numbersOnly(event)' onchange='changePrice("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+data[0].quoted_price+",\""+data[0].to+"\")' id='focusedInput_"+data[0].id+"' style='height:27px;width:108px;' class='form-control tex-ali-cen dash-search-box' type='text' value=" + data[0].quoted_price + " maxlength='10' tabindex='2' style='width:110px;'>\
																</td>\
																<td class='col-md-2'><input id='' readonly='true' type='text' class='form-control date_picker_"+idProduct+"' onchange='changeDate("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+ data[0].quoted_price +",this)' id='date_"+data[0].id+"' value=" + data[0].to + "></td>\
																<td id='hover-delete-scn' class='col-md-1' onclick='removeProductQuote(" + data[0].id + ", "+scn_quote_id+")'>\
																	<a href='#'><i class='fa fa-trash-o'></i></a>\
																</td>\
																<td class='product-id-hide' style='display:none;'>" + data[0].id + "</td>\
																<td class='prod-remarks-revise' style='display:none;'>" + remarks + "</td>\
															</tr>");
						reviseRepeatCode();
					}
					$('.date_picker_'+idProduct).datepicker({
			            format: 'yyyy-mm-dd hi:s:a'
			        });
				}
			}
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}

function downloadQuotation(quote_id)
{
	if(quote_id == undefined)
		quote_id = scn_quote_id;
	
	$('#quotation-history-hidden-data').empty();
 	$('#quotation-history-hidden-data').append('<input id=quote-excel-' + quote_id + ' type="text" name="id-quotation" value=' + quote_id + '>');
	$('#form_quotation_excel').submit();
}

$('#focusedInputQuotation').keypress(function(event)
{
	var input_length = $('#focusedInputQuotation').val();
	if (input_length.length < 2)
	{
		$("#quotation-processing").hide();
	}
	else
	{
		$('#quotation-processing').show();
	}
});

$('#focusedInputQuotationRevise').keypress(function(event)
{
	var input_length = $('#focusedInputQuotationRevise').val();
	if (input_length.length < 2)
	{
		$("#quotation-processing-revised").hide();
	}
	else
	{
		$('#quotation-processing-revised').show();
	}
});

$('#scn-quote-product-date').keypress(function(event)
{
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if (keycode == '13')
	{
		$('#quotation-corporate-user-add-to-cart').click();
		return false;
	}
	if (event.which == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) return true;
	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
	{
		event.preventDefault();
	}
});

$("#scn-revise-quote-product-date").keypress(function(event)
{
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if (keycode == '13')
	{
		$('#quotation-corporate-user-add-to-cart-revise').click();
		return false;
	}
	if (event.which == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) return true;
	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
	{
		event.preventDefault();
	}
});

function otherCusPrices(idProduct, portalPrice)
{
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		data: '&id_product=' + idProduct + '&type=8',
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if(data != undefined && data != false)
			{
	  			$('.productCode, .disc_price, .high-price-cus,.low-price-cus, #viewPriceCustomer, #viewPriceCustomerRevise,.mrp,.vat').html('');
				$('.region_name, .region_price, .product-status').html('');
				$('.high-price-cus').html(data.product_details[0].cus_price_high);
				$('.low-price-cus').html(data.product_details[0].cus_price_low);
				$('.reportError').html('').append('<button type="button" class="btn btn-danger" onclick="reportError('+idProduct+')">Report Data Error</button>');
				$('#viewPriceCustomer,#viewPriceCustomerRevise').html('<button class="btn btn-warning btn-round label" onclick="showPrice('+idProduct+', 1)">View</button>');
				//tax value
				tax_rate = data.product_details[0].tax;
				$('.mrp').html(data.product_details[0].mrp);
				if(tax_rate == "NA")
					$('.vat').html(tax_rate);
				else
					$('.vat').html(tax_rate +" %");
				$('.productCode').html(data.product_details[0].reference);
				$('.disc_price').html(portalPrice);
				if(data.product_details[0].product_current_status == 1) {
					$('.product-status').html('<div class="col-xs-12 border1 text-center padding5">\
                        <span class="text-danger" >This product is currently in OUT OF STOCK</span>\
                    </div>');
				}

				for(var i in data.zone_prices) {
					if(data.zone_prices.hasOwnProperty(i)) {
						$('.region_name').append('<td class='+data.zone_prices[i].id_fulfillment_centre+'>'+data.zone_prices[i].city+'</td>');
						$('.region_price').append('<td class='+data.zone_prices[i].id_fulfillment_centre+'>'+data.zone_prices[i].price+'</td>')
					}
				}
			}
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}

function showPrice(idProduct, price_type)
{
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		data: '&id_product=' + idProduct + '&type=13&id_company=' + company_id + '&price_type='+price_type,
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			var s_no = 0;

			$('.view-exist-cus').html('');

			if(price_type == 1) { //for Existing customer price
				if(data && data[0].length > 0) {
					for(var j = 0;j < data[0].length; j++){
						s_no = j+1;
						$('.view-exist-cus').append('<tr><td class="col-xs-2">'+s_no+'</td><td class="col-xs-4">'+data[0][j].company+'</td><td class="col-xs-2">'+parseFloat(data[0][j].price).toFixed(2)+'</td><td class="col-xs-2">'+data[0][j].date_update+'</td><td class="col-xs-2">'+data[0][j].valid_till+'</td></tr>');
					}
				}
			}
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});

}

var cus_list_select_validation = function(){
	$('#scn-customer-list-select').val('');
	$('#scn-customer-list-select').attr('placeholder', 'Please select a Customer.');
	$('#create-quotation').hide();
	$('#quotation-block').show();
	dataHideQuote();
}

$('#scn-customer-list-select').keypress(function(event)
{
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if (keycode == '13')
	{
		customer_id = 0;

		var customer_list = $('#scn-customer-list-select').val();

		if (customer_list == '' || customer_id == 0)
		{
			toast("Please select company", "error");
			event.preventDefault();
		}
		else
		{
			openQuotePage(firstname, customer_id);
			return false;
		}
	}
});

var navigateRepeatCode = function(){
	$('#create-quotation').show();
	$('#update-quote').hide();
	$('#revise-quote').hide();
	$('#listTitleQuote').html('');
	$('#listTitleQuote').html(name);
	$('#search-add-prod').hide();
	$('#cusSearchBlock').show();
}

function navigateBack(page_type){
	if(page_type == 0){
		navigateRepeatCode();
	}
	if(page_type == 1){
		$('#update-quotation-btn').click();
		$('#quotation_history_view').html('');
	}
	if(page_type == 2){
		navigateRepeatCode();
	}
}

function changePrice(product_price, id_quotation, id_product, remarks, price, date){
	var quote_price = parseFloat($('#focusedInput_'+id_product).val()).toFixed(2);
	if(quote_price > product_price) {
		toast('Price should be less than MRP');
		return false;
	}

	changeInQuoteTrigger(id_product, id_quotation, remarks, quote_price, date);
}

function changeDate(product_price, id_quotation, id_product, remarks, price, date) {
	if (Date.parse(new Date()) > Date.parse(new Date(date.value))) { 
    	toast('Select valid expiring date', "error");
		return false;
	}

	changeInQuoteTrigger(id_product, id_quotation, remarks, price, date.value);
}

function reportError(id_product)
{
	var msg = "";
	var msg_add = $('#messageDescription').val();
	var msg_revise = $('#messageDescriptionRevise').val();

	if(msg_add != "" && msg_add != undefined) 
		msg = msg_add;
	else if(msg_revise != "" && msg_revise != undefined)
		msg = msg_revise;

	var dataparam = '&type=14&id_product='+id_product+'&id_employee='+id_employee+'&message='+decodeURIComponent(msg);

	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		cache: true,
		data: dataparam,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(result)
		{ 
			if(result == 1)
			{
				toast("Error Reported Successfully.","success");
				$('#messageDescription,#messageDescriptionRevise').val("");
			}
			else
				toast("Error occurred.","error");
		},
		complete: function() {$(".ajaxLoaderModal").hide();}
	});
}

function easySearchScnQuotation(table_id) {   
    var oTable = $('#'+table_id).dataTable({
        "aLengthMenu": [
            /*[25, 50, 100, -1],
            [25, 50, 100, "All"]*/ // change per page values here
            [10, 50, 100, -1],
            [10, 50, 100, "All"]
        ],
        "bRetrieve": true,
        "bDestroy": true,
        
        // set the initial value
        "iDisplayLength": 10,
        
        "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },          

        "aoColumnDefs": [{
                'bSortable': true,
                'aTargets': []
            }
        ],
        "aaSorting": [[0, "desc"]]
    });             
}

function changeInQuoteTrigger(id_product, id_quotation, remarks, product_price, date) {
	// Live update price change
	$.ajax(
	{
		type: 'POST',
		async: true,
		dataType: 'json',
		url: 'scn-quotation-ajax.php',
		data: {
			type: 7,
			id_product: id_product,
			quote_revise_attempt: quote_revise_attempt,
			id_quotation: id_quotation,
			id_company: company_id,
			q: (($('#quotation_name_revise').html()).split(':'))[1],
			id_employee: id_employee,
			id_state: $('#regions').val(),
			remarks: remarks,
			price: product_price,
			date: date
		},
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if(data != "") {
				if(data == 0 || data == 1) {
					toast("Error in adding product to quote.", "error");
				}
				else {
					
					scn_quote_id = data[1];	
					quote_revise_attempt = false;

					if(data[0].tax_value != "NA")
						data[0].tax_value = data[0].tax_value+"%";

					if ($('#revise-quote-row-'+data[0].id).length) {
						$('#revise-quote-row-'+data[0].id).remove();
						var remarks = $('#remarksInputRevise').val();
						$('#quotation_history_view').append("<tr id='revise-quote-row-"+data[0].id+"'>\
																<td class='col-md-3'>" + data[0].name[1] + "</td>\
																<td class='id_product_scn col-md-2'>" + data[0].reference + "</td>\
																<td class='col-md-2 tex-ali-cen'>" + data[0].tax_value + "</td>\
																<td class='col-md-2'>\
																	<span>\
																		<input onkeydown='numbersOnly(event)' onchange='changePrice("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+data[0].quoted_price+",\""+data[0].to+"\")' id='focusedInput_"+data[0].id+"'  style='height:27px;width:108px;' class='form-control tex-ali-cen dash-search-box' type='text' value=" + data[0].quoted_price + " maxlength='10' tabindex='2' style='width:110px;'>\
																</td>\
																<td class='col-md-2'>\
																<input type='text' readonly='true' class='form-control date_picker_"+idProduct+"'  onchange='changeDate("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+ data[0].quoted_price +",this)' value="+data[0].to+">\
																</td>\
																<td id='hover-delete-scn' onclick='removeProductQuote(" + data[0].id + ", "+scn_quote_id+")' class='col-md-1'>\
																	<a href='#'><i class='fa fa-trash-o'></i></a>\
																</td>\
																<td class='product-id-hide' style='display:none;'>" + data[0].id + "</td>\
																<td class='prod-remarks-revise' style='display:none;'>" + remarks + "</td>\
																</tr>");
						reviseRepeatCode();
					}
					else {
						var remarks = $('#remarksInputRevise').val();					
						$('#quotation_history_view').append("<tr id='revise-quote-row-"+data[0].id+"'>\
																<td class='col-md-3'>" + data[0].name[1] + "</td>\
																<td class='id_product_scn col-md-2'>" + data[0].reference + "</td>\
																<td class='col-md-2 tex-ali-cen'>" + data[0].tax_value + "</td>\
																<td class='col-md-2'>\
																<span>\
																	<input onkeydown='numbersOnly(event)' onchange='changePrice("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+data[0].quoted_price+",\""+data[0].to+"\")' id='focusedInput_"+data[0].id+"' style='height:27px;width:108px;' class='form-control tex-ali-cen dash-search-box' type='text' value=" + data[0].quoted_price + " maxlength='10' tabindex='2' style='width:110px;'>\
																</td>\
																<td class='col-md-2'><input id='' readonly='true' type='text' class='form-control date_picker_"+idProduct+"' onchange='changeDate("+data[0].price+","+scn_quote_id+","+data[0].id+",\"" + remarks + "\","+ data[0].quoted_price +",this)' id='date_"+data[0].id+"' value=" + data[0].to + "></td>\
																<td id='hover-delete-scn' class='col-md-1' onclick='removeProductQuote(" + data[0].id + ", "+scn_quote_id+")'>\
																	<a href='#'><i class='fa fa-trash-o'></i></a>\
																</td>\
																<td class='product-id-hide' style='display:none;'>" + data[0].id + "</td>\
																<td class='prod-remarks-revise' style='display:none;'>" + remarks + "</td>\
															</tr>");
						reviseRepeatCode();
					}
					$('.date_picker_'+idProduct).datepicker({
			            format: 'yyyy-mm-dd hi:s:a'
			        });
				}
			}
		},
		complete: function() { $(".ajaxLoaderModal").hide(); }
	});
}