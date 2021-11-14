function autoCompSearch(tar_element,type)
{
	$(""+tar_element+"").autocomplete("index.php?controller=search",
	{
		minChars:3,
		max: 10,
		dataType:"json",
		cacheLength: 0,
		formatItem: function(data, i, max, value, term) 
		{
			return value;
		},
		parse: function(data)
		{
			if(data=="")
			{
				$("#quickbuy-processing,#quotation-processing,#quotation-processing-revised,.purchaseBill").hide();	
				$("#quickbuy-product-not-found").show();

				if(type == "scn_quote_create")
				{
					$(".productNotFound").show();
				}
				else if(type == "scn_quote_revise")
				{
					$(".productNotFound").show();
				}
				else if(type == "catalog_price")	
				{
					$(".productNotFound").show();
				}
				else if(type == "catalog_perks")	
				{
					$(".productNotFound").show();
				}
				else if(type == "purchase_bill")
				{
					$(".productNotFound").show();
				}
				else if(type == "deal_search")
				{
					$("#deal-processing").hide(); 
                    $("#deal-product-not-found").show(); 
				}
				else if(type == "scn_prod_history")
				{
					$('#quickbuy-processing').hide();
					$('#quickbuy-product-not-found').show();
				}

				return data;
			}
			else
			{
				$("#quickbuy-product-not-found,.productNotFound,#deal-product-not-found").hide();	

				var mytab = new Array();				
				for(var i = 0; i < data.length; i++)
				{
					mytab[mytab.length] = { data: data[i].id_product + "~" + data[i].pname + "~" + data[i].price + "~" + data[i].product_link + "~" + data[i].reference+"~"+data[i].price_without_reduction+"~"+data[i].buyingPrice, value:"<div><span  id='search_image'>"+"<img class='dummy' src="+data[i].image_link+">" +"</span>"+ "<span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>"+data[i].pname+"</br>"+"Product Code:"+data[i].reference+"</br>"+"Price: Rs. "+data[i].price+"</span></div>"};
				}

				return mytab;
			}
		},
		extraParams: {
			internalSearch: 1,
			id_lang: 1,
			limit:10
		}
	}).result( function(event, data, formatted, value) {
		var separate = data.split('~');
		product = {productLink: separate[3],productname: separate[1],idProduct: separate[0],prod_reference: separate[4],price: separate[2]};
		idProduct = separate[0];
		product_name = separate[1];
		productPrice = product.price;
		price_without_reduction=parseFloat(separate[5]).toFixed(2);

		if(type == "scn_prod_history") {
			$("#product_name").html(separate[1]);
			$("#quickbuy-product-not-found").hide();
			$('#prodHistIdProduct').val('').val(separate[0]);
			productHistoryData();
		}
		else if(type == "scn_quote_create") {
			$('#focusedInputQuotation').val(product.productname);
			$("#scn-corporate-user-quantity-value").focus();
			$('#view-cus-prices').show();
			$('#other-cus-prices').show();
			otherCusPrices(idProduct, productPrice);
			$("#quotation-processing").hide();
			$("#quickbuy-product-not-found").hide();
		}
		else if(type == "scn_quote_revise") {
			$('#focusedInputQuotationRevise').val(product.productname);
			$("#scn-corporate-user-quantity-value-revise").focus();
			$('#view-cus-prices-revise').show();
			$('#other-cus-prices-revise').show();
			otherCusPrices(idProduct, productPrice);
			$("#quotation-processing-revised").hide();
			$("#quickbuy-product-not-found").hide();
		}
		else if(type == 'catalog_price') {
			var priceList = separate[6].split('<');
			$('#searchProduct').val(product.productname);
			$('#product_id').val(idProduct).trigger('input');
			$('#type').val(12).trigger('input');
			$("#quotation-processing").hide();
			$('.input').val('').trigger('input');
			for(var i = 0; i < priceList.length; i++) {
				var detail = priceList[i].split('>');
				if(detail[0] != "") {
					$('#region_price_'+detail[0]).val(detail[1]).trigger('input');
				}
			}
		}
		else if(type == 'catalog_perks') {
			var priceList = separate[6].split('<');
			$('#searchPerks').val(product.productname);
			$('#idProduct').val(idProduct);
		}
		else if(type == "purchase_bill") {
			$('#vendor_bill_product').val(separate[1]);
			$('#id_product').val(separate[0]);
			changefocus(2);
		}
		else if(type == "prod_ven_map") {
			$('#product-name').val(product.productname);
			var pocId=$('#vendor-poc').val();
			var addressId=$('#vendor-address').val();
			var vendorType=$('#vendor-type').val();
			vendorProduct={productId:separate[0],vendorId:vendor,pocId:pocId,addressId:addressId,vendorType:vendorType,link:separate[3],name:separate[1]};
		}
		else if(type == "rm_cat_search") {
			$('#focusedInput').val(product.productname);
			$("#quickbuy-product-not-found").hide();
			toChangeFocus();
		}
		else if(type == "pur_list_add") {
			$('#type_product').val(product.productname);
		  	idProduct=separate[0];
			productName = separate[1];
			productReference=separate[4];
			productLink = separate[3];
			productPrice = separate[2];
			toChangeFocus();
			$("#quickbuy-product-not-found").hide();	
			$('#specific_price').attr('disabled',false);
			$('#specific_price').focus();
		}
		else if(type == "deal_search") {
			var price=parseFloat(separate[2]).toFixed(2);
            $('#dealInput').val(product.productname);                  
            $('#hidden_id').val(separate[0]);
            $("#mrpPrice").val("Rs. "+price_without_reduction);
			if(price_without_reduction==price) {
				$("#specialPrice").val("");	
			}
			else {
				$("#specialPrice").val("Rs. "+price);
			}	
        }
	});	
}

function getCustomers(tar_element,type)
{
	$("#"+tar_element+"").autocomplete("rm-customer-configure.php?type=5",
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
					data: data[i].firstname + "~" + data[i].lastname + "~" + data[i].id_customer + "~" + data[i].email,
					value: "<div><span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>" + data[i].firstname + "</br>" + "Customer Id:" + data[i].id_customer + "</br>" + "Email: " + data[i].email + "</span></div>"
				};
				return mytab;
			}
		}
	}).result(function(event, data, formatted, value)
	{
		var separate = data.split('~');
		if(type == 0)
		{
			customerSearch(separate[2]);
		}
		else if(type == 1){
			getCustomerBoxDetails(separate[2]);
		}
	});
}

function getAllFc(target){
	//get All Fulfillment centers
 	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'scn-orderstatus.php',
		data: '&type=7',
		cache: true,
		success: function(data)
		{
			$(target).html('');
			$(target).append('<option value="0">Select Fulfillment Center</option>');
			for(var i = 0; i < data.length; i++){
				$(target).append('<option value="'+data[i].id_fulfillment_centre+'">'+data[i].city_name+'</option>');
			}
		}
	});
}

function searchProduct(tar_element, type) {
	$(""+tar_element+"").autocomplete("index.php?controller=search", {
		minChars:3,
		max: 10,
		dataType:"json",
		cacheLength: 0,
		formatItem: function(data, i, max, value, term) {
			return value;
		},
		parse: function(data) {
			if(data=="") {
				if(type == "scn_quote_create") {
					$(".productNotFound").show();
					$("#quotation-processing").hide();
				}
				else if(type == "scn_quote_revise") {
					$(".productNotFound").show();
					$("#quotation-processing-revised").hide();
				}

				return data;
			}
			else {
				$(".productNotFound").hide();	
				var mytab = new Array();				
				for(var i = 0; i < data.length; i++) {
					mytab[mytab.length] = { data: data[i].id_product + "~" + data[i].pname + "~" + data[i].price + "~" + data[i].product_link + "~" + data[i].reference+"~"+data[i].price_without_reduction+"~"+data[i].buyingPrice, value:"<div><span  id='search_image'>"+"<img class='dummy' src="+data[i].image_link+">" +"</span>"+ "<span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>"+data[i].pname+"</br>"+"Product Code:"+data[i].reference+"</br>"+"Price: Rs. "+data[i].price+"</span></div>"};
				}

				return mytab;
			}
		},
		extraParams: {
			scnInternalSearch: 1,
			id_lang: 1,
			limit:10,
			regions: function() { 
				if(type == "scn_quote_create") {
					return $('.regions-block-add').val(); 
				}
				else {
					return $('.regions-block-revise').val(); 
				}
			}
		}
	}).result( function(event, data, formatted, value) {
		if(data && data != "") {
			var separate = data.split('~');
			product = {productLink: separate[3],productname: separate[1],idProduct: separate[0],prod_reference: separate[4],price: separate[2]};
			idProduct = separate[0];
			product_name = separate[1];
			productPrice = product.price;
			price_without_reduction=parseFloat(separate[5]).toFixed(2);

			if(type == "scn_quote_create") {
				$('#focusedInputQuotation').val(product.productname);
				$("#scn-corporate-user-quantity-value").focus();
				$('#view-cus-prices').show();
				$('#other-cus-prices').show();
				otherCusPrices(idProduct, productPrice);
				$("#quotation-processing").hide();
				$("#quickbuy-product-not-found").hide();
			}
			else if(type == "scn_quote_revise") {
				$('#focusedInputQuotationRevise').val(product.productname);
				$("#scn-corporate-user-quantity-value-revise").focus();
				$('#view-cus-prices-revise').show();
				$('#other-cus-prices-revise').show();
				otherCusPrices(idProduct, productPrice);
				$("#quotation-processing-revised").hide();
				$("#quickbuy-product-not-found").hide();
			}
		}
	});	
}