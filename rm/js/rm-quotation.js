var idProduct = 0, firstname = '';
/*
	toast pop-up used here to avoid modal pop-up appearing every time on success,error,etc
	param1 - message
	param2 - message type like success,warning,error,etc
*/
$(document).ready(function() {
	$('.date_picker').datepicker({
        changeMonth: true,
        changeYear: true,
        format: 'yyyy-mm-dd hi:s:a'
     });

	var quote_type = $('#quote_type').val();
	var duration = 0;

	if (quote_type == 8) {
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

function checkUncheckRegions(checked) {
	var checked = $(checked).prop('checked');
	if(checked) {
		$('.check').prop('checked', true).attr('disabled', true);
	}
	else {
		$('.check').prop('checked', false).attr('disabled', false);
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

function openQuotePage(name, id_company)
{
	dataHideQuote();
	$('#create-quotation').show();
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

				if(data && data[1] != "" && $('.regions-block-add').val() == undefined) {
					$('.regions-block-add').html("");
					for(var j = 0; j < data[1].length; j++) {
						$('.regions-block-add').append('<option value='+data[1][j].id_fulfillment_centre+'>'+data[1][j].city_name+'</option>');
					}
					$('.regions-block-add').select2({ placeholder: "Filter by region"}).data('select2').$container.addClass('regions-selection');
				}

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
				$('#quote_name_span').html("(Quote Name: " + quote_name + ")").css({"text-transform": "lowercase"});
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
			if ( $.fn.DataTable.isDataTable('#quote-list') ) {
			  $('#quote-list').DataTable().destroy();
			}

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
														<td data-title='Created By'>"+ data[i].id_employee +"</td>\
														<td data-title='Date Generated'>" + data[i].date_generated + "</td>\
														<td data-title='Actions'><span onclick='downloadQuotation(" + data[i].id_quotation + ")' class='cur-poi padding5'><i class='fa fa-download text-success' title='Download'></i></span>\
																			 <span><a href='#viewQuoteProducts' data-toggle='modal' onclick='reviseQuotation(" + data[i].id_quotation + ", 1, false)'><span class='cur-poi padding5'><i class='fa fa-eye text-info' title='View'></i></span></a></span>\
																			 <span onclick='reviseQuotation(" + data[i].id_quotation + ",2,true)' class='cur-poi padding5'><i class='fa fa-edit text-primary' title='Revise'></i></span>\
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
														<td data-title='Created By'>"+data[i].id_employee+"</td>\
														<td data-title='Date Generated'>" + data[i].date_generated + "</td>\
														<td data-title='Actions'><span onclick='downloadQuotation(" + data[i].id_quotation + ")' class='cur-poi padding5'><i class='fa fa-download text-success' title='Download'></i></span>\
																			<span><a href='#viewQuoteProducts' data-toggle='modal' onclick='reviseQuotation(" + data[i].id_quotation + ",1,false)'><span class='cur-poi padding5'><i class='fa fa-eye text-info' title='View'></i></span></a></span>\
																			<span onclick='reviseQuotation(" + data[i].id_quotation + ",2,true)' class='cur-poi padding5'><i class='fa fa-edit text-primary' title='Revise'></i></span>\
																			<span id='published'><a href='#publishQuoteConfirmation' data-toggle='modal'><span class='cur-poi padding5' onclick='publishQuotationProducts(0, "+data[i].id_quotation+", "+company_id+")'><i class='fa fa-upload text-warning' title='Publish'></i></span></a></span></td>\
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
			if(data == 1) {
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
			$('#quote-download-btn').click(function()
			{
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

function reviseQuotation(quote_id, req_type, revise_attempt)
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
		type = 5;
	}

	quote_revise_attempt = revise_attempt;

	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		data: '&id_quotation=' + quote_id + '&type=' + type + '&id_company=' + company_id + '&id_employee=' + id_employee + '&id_state=' + $('#regions').val(),
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if(data && data[2] != "" && $('.regions-block-revise').val() == undefined) {
				$('.regions-block-revise').html("");
				for(var j = 0; j < data[2].regions.length; j++) {
					$('.regions-block-revise').append('<option value='+data[2].regions[j].id_fulfillment_centre+'>'+data[2].regions[j].city_name+'</option>');
				}
				$('.regions-block-revise').select2({ placeholder: "Filter by region"}).data('select2').$container.addClass('regions-selection');
			}

			if (req_type == 1)
			{
				$('#quotation_history_view_scn, #quoteInfoView').html('');
				$('#quoteInfoView').html('Quote Name: <strong>' + data[3].quote_name + '</strong>, Version: <strong>'+data[4].quote_version+'</strong>');
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
				$('#revise-quote-name').html('Quote Name: <strong>' + data[3].quote_name + '</strong>, Version: <strong>'+data[4].quote_version+'</strong>');
				$('#quotation_name_revise').html('Quotation Name:' + data[3].quote_name);

				scn_quote_id = quote_id;

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
																	 	<input id='' type='text' readonly='true' onchange='changeDate("+data[0][i].product_price+","+scn_quote_id+","+data[0][i].product_id+",\"" + data[0][i].remarks + "\",\"" + data[0][i].price + "\", this)' class='form-control date_picker_new_"+data[0][i].product_id+" "+errorClass+"' value='" + data[0][i].to + "'/>\
																	 </td>\
																	 <td id='hover-delete-scn' onclick='removeProductQuote(" + data[0][i].product_id + ", "+scn_quote_id+")' class='col-md-1'>\
																	 	<a href='#'><i class='fa fa-trash-o'></i></a>\
																	 </td>\
																	 <td class='product-id-hide' style='display:none;'>" + data[0][i].product_id + "</td>\
																	 <td class='prod-remarks-revise' style='display:none;'>" + data[0][i].remarks + "</td>\
																 </tr>");
							$('.date_picker_new_'+data[0][i].product_id).datepicker({
								changeMonth: true,
						        changeYear: true,
					            format: 'yyyy-mm-dd hi:s:a'
					        });
						}
				}

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
	$('#revise-quote-row-'+id).remove();
	changeInQuoteTrigger(id, quote_id, "", "", "", true);
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
			            changeMonth: true,
				        changeYear: true,
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
				$('.region_name, .region_price, .product-status, .region_availability').html('');
				$('.high-price-cus').html(data.product_details[0].cus_price_high);
				$('.low-price-cus').html(data.product_details[0].cus_price_low);
				$('.reportError').html('').append('<button type="button" class="btn btn-danger" onclick="reportError('+idProduct+')">Report Data Error</button>');
				$('#viewPriceCustomer,#viewPriceCustomerRevise').append('<button class="btn btn-warning btn-round label" onclick="showPrice('+idProduct+', 1)">View</button>');
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

				$('.region_name').append('<td></td>');
				$('.region_price').append('<td>Buying Prices</td>');
				$('.region_availability').append('<td>Product Availability</td>');
				for(var i in data.zone_prices) {
					if(data.zone_prices.hasOwnProperty(i)) {
						$('.region_name').append('<td class='+data.zone_prices[i].id_fulfillment_centre+'>'+data.zone_prices[i].city+'</td>');
						$('.region_price').append('<td class='+data.zone_prices[i].id_fulfillment_centre+'>'+data.zone_prices[i].price+'</td>')
						$('.region_availability').append('<td class='+data.zone_prices[i].id_fulfillment_centre+'>'+data.zone_prices[i].available_at_region+'</td>');
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
		scn_quote_id = "";
		$('#update-quotation-btn').click();
		$('#quotation_history_view').html('');
	}
	if(page_type == 2){
		navigateRepeatCode();
	}
}

function changePrice(product_price, id_quotation, id_product, remarks, price, date){
	var quoted_price = parseFloat($('#focusedInput_'+id_product).val()).toFixed(2);
	if(quoted_price > product_price) {
		toast('Price should be less than MRP', "error");
		return false;
	}

	changeInQuoteTrigger(id_product, id_quotation, remarks, quoted_price, date);
}

function changeDate(product_price, id_quotation, id_product, remarks, price, date) {
	if(date.value == "") {
		toast('Please use date picker to select date.', "warning");
	}
	else if (Date.parse(new Date()) > Date.parse(new Date(date.value))) { 
    	toast('Select valid expiring date', "error");
		return false;
	}
	else {
		changeInQuoteTrigger(id_product, id_quotation, remarks, price, date.value);
	}
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

function publishQuotationProducts(action_type, id_quotation, id_group){
	if(action_type == 0){
		$('.quote-confirm-footer').html('');
		$('.quote-confirm-footer').append('<input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="Cancel"/>');
		$('.quote-confirm-footer').append('<input type="button" name="trigger" onclick="publishQuotationProducts(1,'+id_quotation+', '+id_group+')" class="btn btn-primary" value="Continue"/>');
	}
	else if(action_type == 2){
		$('.quote-confirm-footer').html('');
		$('.quote-confirm-footer').append('<input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="Cancel"/>');
		$('.quote-confirm-footer').append('<input type="button" name="trigger" onclick="publishQuotationProducts(1,'+id_quotation+', '+id_group+')" class="btn btn-primary" value="Continue"/>');
		$('#viewQuoteProductsRm').modal('hide');
		$('#publishQuoteConfirmation').modal('show');
	}
	else{
		$('.rm-quote-publish-loader').show();
		var type = 5;
		var dataparam = '&type=' + type + '&id_quotation=' + id_quotation+ '&id_group=' + id_group +'&publish_from_module=true';
		$('#globalAlert').hide();
		$.ajax(
		{
			type: 'POST',
			dataType: 'json',
			async: true,
			url: 'rm-publish-quotation.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
				if(data != "") {
					if(data == 2) {
						$('.rm-quote-publish-loader').hide();
						$('#publishQuoteConfirmation').modal('hide');
						$('#publishFailedGroup').modal('show');
					}
					else if(data == 1) {
						$('.rm-quote-publish-loader').hide();
						$('#publishQuoteConfirmation').modal('hide');
						$('#publishFailed').modal('show');
					}
					else if(data.product_errors != undefined && Object.keys(data.product_errors).length > 0) {
						$('#publish-quote-error-body').html('');

						for(var i in data.product_errors) {
							if(data.product_errors.hasOwnProperty(i)) {
								if(data.product_errors[i].errors != null) {
									var error_description = '';
									var k = 0;
									for(var j in data.product_errors[i].errors) {
										if(data.product_errors[i].errors[j].hasOwnProperty(j)) {
											error_description += (++k)+'. '+data.product_errors[i].errors[j]+' <br />';
										}
									}
									$('#publish-quote-error-body').append('<tr>\
										<td class="col-xs-1">'+data.product_errors[i].code+'</td>\
										<td class="col-xs-3">'+data.product_errors[i].name+'</td>\
										<td class="col-xs-1">'+data.product_errors[i].mrp+'</td>\
										<td class="col-xs-1">'+data.product_errors[i].quoted_price+'</td>\
										<td class="col-xs-1">'+data.product_errors[i].gst+'</td>\
										<td class="col-xs-5">\
											<a href="#"><i title="Click here to expand error in detail." class="fa fa-plus-square text-danger" data-toggle="collapse" aria-expanded="false" aria-controls="errorDesc_'+i+'" aria-hidden="true" href="#errorDesc_'+i+'"> '+data.product_errors[i].errors.length+' errors.</i></a>\
											<div class="collapse" id="errorDesc_'+i+'"><div class="card card-block">'+error_description+'</div></div>\
										</td>\
									</tr>');
								}
							}
						}

						$('.rm-quote-publish-loader').hide();
						$('#publishQuoteConfirmation').modal('hide');
						$('#publish-quote-error').modal('show');					
					}
					else {
		                updateQuote();
						
						$('.specific-update,.specific-add').html('');
						
						if(data.specific_update == 0)
							data.specific_update = "No Changes in Specific Price Updation";
						else
							data.specific_update = " Number of products<span style='font-weight:bold;color:#e8853e;'> price updated in Specific Price</span>: <span style='font-weight:bold;color:#656565;'>"+data.specific_update+"</span>";

						if(data.specific_add == 0)
							data.specific_add = "No Changes in adding Specific Price";
						else
							data.specific_add = " Number of products <span style='font-weight:bold;color:#4898e9;'> price added in Specific Price</span>: <span style='font-weight:bold;color:#656565;'>"+data.specific_add+"</span>";

						$('.specific-update').append('<div>'+data.specific_update+'</div>');
						$('.specific-add').html('<div>'+data.specific_add+'</div>');

						$('.rm-quote-publish-loader').hide();
						$('#publishQuoteConfirmation').modal('hide');
						$('#publish-quote-success').modal('show');
					}
				}
			}
		});
	}
}

function changeInQuoteTrigger(id_product, id_quotation, remarks, product_price, date, delete_product) {
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
			date: date,
			delete_product: delete_product
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
					reviseQuotation(data[1], 2, false);
				}
			}
		},
		complete: function() { $(".ajaxLoaderModal").hide(); }
	});
}