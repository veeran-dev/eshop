// JavaScript Document
window.newproductotlist=0;
window.special_price=0.00;
var idProduct = 0, productName, productReference, productLink, idratecontract,productPrice;

$(document).ready(function(){
	autoCompSearch("#type_product","pur_list_add");
});
function addProductsToList()// to add products to ratecontract and purchaselist
{
 	

	//var selected_list=$('#list_title_select').val();
	var specific_price=parseFloat($('#specific_price').val());
	var name=$('#list_title_select option:selected').text();
	if(specific_price == "" || specific_price < 0 )
	{
		var alertmsg = "Please Enter Rate Contract Price";
			$("#idGlobalAlert").html(alertmsg);
			$('#globalAlert').modal('show');
			return false;
	}
	/*if(selected_list==0)
	{
		
			var alertmsg = "Please Select the Purchase List";
			$("#idGlobalAlert").html(alertmsg);
			$('#globalAlert').modal('show');
			return false;
	}*/
	
	var input_text_entered=$("#type_product").val();
		if(input_text_entered=="")
		{
			alert("Please select the product.");
			return false;
		}	
	var type = 1;
	var dataparam = '&id_product='+idProduct+'&id_customer='+id_customer+'&specific_price='+specific_price+'&productPrice='+productPrice+'&id_employee='+id_employee+'&type='+type;
 	window.special_price=specific_price;
	$('#type_product').attr("value","");
	$('#specific_price').attr("value","");
	 
	
	$.ajax
	({
		type: 'POST',
		async: true,
		url: 'rm-addtorate.php',
		//dataType: 'json',
		data: dataparam,
		success: function(data)
		{
		  if(data==101)
			{
				var check=confirm("This product is listed under deals.\n If you want to Deactivate the deal press 'OK' else press 'CANCEL'to just add the product to the Purchase List");
				if(check)
				{
					savePrice(idProduct,2);
					displayProduct(1);
				}
				else
				{
					displayProduct(1);
				}
			}
			else if(data==2 || data==3)//1
			{
				window.special_price=0.00;
				$('#product_heading').removeClass('successSearch');
				$('#products_display').removeClass('successSearch');
				$('#product_heading').html('');
				$('#product_heading').append("PRODUCTS IN "+name);
				if(data==2)
					toast("Product Added Successfully!","success");
				if(data==3)
					 toast("Product Added Successfully!","success");

					if(specific_price!='')
					{	
						//$("<tr id='tr_pur_id_" + idProduct + "' class='listProdcuts'><td><span id='product_code" +idProduct + "' >" +productReference + "</span></td><td><span><a target='#' href=" + productLink + " id='product_name_" + idProduct + "' >" + productName + "</a></span></td><td><span id='product_price" +idProduct+ "' >" +specific_price+ "</span></td><td><span id='delete_"+idProduct+"' class='fa fa-trash-o cur-poi ' onclick='deleteProduct("+data+","+selected_list+"," + idProduct + ")'></span></td></tr>").prependTo('table > #products_in_list');
						$("<tr id='tr_pur_id_" + idProduct + "' class='listProdcuts'><td><span id='product_code" +idProduct + "' >" +productReference + "</span></td><td><span><a target='#' href=" + productLink + " id='product_name_" + idProduct + "' >" + productName + "</a></span></td><td><input value='"+specific_price+"' class='noBorder specPrice' id='product_price"+idProduct + "' name='product_price"+idProduct + "'/></td><td ><span id='save_"+idProduct+"' class='fa fa-save cur-poi savePart_"+idProduct+"' style='display:none' onclick='savePrice("+idProduct+",1)'></span><span id='edit_"+idProduct+"' class='fa fa-edit cur-poi editPart_"+idProduct+"' onclick='editPrice("+idProduct+");'></span>&nbsp;&nbsp;<span id='cancel_"+idProduct+"' style='display:none' class='fa fa-reply cur-poi savePart_"+idProduct+"' onclick='cancelEdit("+idProduct+")'></span><span id='delete_"+idProduct+"' class='fa fa-trash-o cur-poi editPart_"+idProduct+"' onclick='deleteProduct("+data+"," + idProduct + "," + id_customer + ")'></span></td></tr>").prependTo('table > #products_in_list');
					}
					
					else
					{
						//$("<tr id='tr_pur_id_" + idProduct + "' class='listProdcuts'><td><span id='product_code" +idProduct + "' >" +productReference + "</span></td><td><span><a target='#' href=" + productLink + " id='product_name_" + idProduct + "' >" + productName + "</a></span></td><td><span id='product_price" +idProduct+ "' >" +productPrice+ "</span></td><td><span id='delete_"+idProduct+"' class='fa fa-trash-o cur-poi ' onclick='deleteProduct("+data+","+selected_list+"," + idProduct + ")'></span></td></tr>").prependTo('table > #products_in_list');
						$("<tr id='tr_pur_id_" + idProduct + "' class='listProdcuts'><td><span id='product_code" +idProduct + "' >" +productReference + "</span></td><td><span><a target='#' href=" + productLink + " id='product_name_" + idProduct + "' >" + productName + "</a></span></td><td><input value='"+productPrice+"' class='noBorder specPrice' id='product_price"+idProduct + "' name='product_price"+idProduct + "'/></td> <td ><span id='save_"+idProduct+"' class='fa fa-save cur-poi savePart_"+idProduct+"' style='display:none' onclick='savePrice("+idProduct+",1)'></span><span id='edit_"+idProduct+"' class='fa fa-edit cur-poi editPart_"+idProduct+"' onclick='editPrice("+idProduct+");'></span>&nbsp;&nbsp;<span id='cancel_"+idProduct+"' style='display:none' class='fa fa-reply cur-poi savePart_"+idProduct+"' onclick='cancelEdit("+idProduct+")'></span><span id='delete_"+idProduct+"' class='fa fa-trash-o cur-poi editPart_"+idProduct+"' onclick='deleteProduct("+data+"," + idProduct + "," + id_customer + ")'></span></td></tr>").prependTo('table > #products_in_list');
					}
					
					
			}
			else if(data==4)//0 and specific_price!=''
			{
				window.special_price=0.00;			
				$('#product_price'+idProduct).html('');
				$('#product_price'+idProduct).val(specific_price);
				toast("product already in list! and Specific price updated","warning");
				$('#specific_price').val('');
				displayProduct(1);
			}
				
			else if(data==1)//0
			{
				window.special_price=0.00;				
				toast("product already in list!","warning");
							
			}
			//$("#ratecontract_products").prependTo("<tr>Reload<td>"+productReference+"</td><td>"+productName+"</td><td>"+specific_price+"</td><td>Reload</td><td>Reload</td></tr>");
 		selectCustomer(id_customer,3 ,0);
		
		}
		});	

}
function displayProduct(functiontype)// to display produts in a purchase list
{
$('.add_products_input').attr('disabled',false);

var specific_price=$('#specific_price').val();
var type=1;
if(functiontype == 2)
{
		var selected_list_express =$('#purlist').val(); 
		var dataparam='&id_customer='+id_customer+'&list_id='+selected_list_express+'&type='+type+'&setcookie='+setcookie;
		alert(dataparam);
 
}
else
{
		//var selected_list=$('#list_title_select').val();
		//var listStatus=1;
		//var selected_list_name=$('selected_list').html(name.innerHTML);
		var setcookie=1;
		var dataparam='&id_customer='+id_customer+'&type='+type+'&setcookie='+setcookie;
}
$(function() {
        $("#product_table").slimScroll({
            height: '245px',
            wheelStep: 1,
            railVisible: true,
            alwaysVisible: true,
            start: 'top'
        });
 });
$.ajax
	({
		
		type: 'POST',
		async: true,
		async: true,
		url: 'dash-PurchaseList.php',
		dataType: 'json',
		data: dataparam,
		success: function(data)
		{
			$('#type_product').focus();
			$('#product_heading').removeClass('successSearch');
			$('#products_display').removeClass('successSearch');
			$("#products_in_list").html('');	
			for (var i = 0; i < data.length; i++) 
			{
				$('#product_heading').html('');
				$('#product_heading').append("PRODUCTS IN " +data[i].list_name);
				
				 $("<tr id='tr_pur_id_" + data[i].id_product + "' class='listProdcuts'><td><span id='product_code" +data[i].id_product + "' >" +data[i].reference + "</span></td><td><span><a target='#' href=" + data[i].link + " id='product_name_" + data[i].id_product + "' >" + data[i].name + "</a></span></td><td class='col-lg-2 col-md-2'><input value='"+(data[i]['price_tax_exc']).toFixed(2)+"' class='noBorder specPrice' id='product_price"+data[i].id_product + "' name='product_price"+data[i].id_product + "'/></td>  <td ><span id='save_"+data[i].id_product+"' class='fa fa-save cur-poi savePart_"+data[i].id_product+"' style='display:none' onclick='savePrice("+data[i].id_product+",1)'></span><span id='edit_"+data[i].id_product+"' class='fa fa-edit cur-poi editPart_"+data[i].id_product+"' onclick='editPrice("+data[i].id_product+");'></span>&nbsp;&nbsp;<span id='cancel_"+data[i].id_product+"' style='display:none' class='fa fa-reply cur-poi savePart_"+data[i].id_product+"' onclick='cancelEdit("+data[i].id_product+")'></span><span id='delete_"+data[i].id_product+"' class='fa fa-trash-o cur-poi editPart_"+data[i].id_product+"' onclick='deleteProduct("+data[i].id_rate_contract+","+data[i].id_pur_list+"," + data[i].id_product + "," + id_customer + ")'></span></td> </tr>").prependTo('table > #products_in_list');
				/*$("<tr id='tr_pur_id_" + data[i].id_product + "' class='listProdcuts'><td><span id='product_code" +data[i].id_product + "' >" +data[i].reference + "</span></td><td><span><a target='#' href=" + data[i].link + " id='product_name_" + data[i].id_product + "' >" + data[i].name + "</a></span></td><td><span id='product_price" +data[i].id_product + "' >" +(data[i][1]).toFixed(2)+ "</span></td><td><span id='delete_"+data[i].id_product+"' class='fa fa-trash-o cur-poi'  onclick='deleteProduct("+data[i].id_rate_contract+","+data[i].id_pur_list+"," + data[i].id_product + ")'></span></td></tr>").prependTo('table > #products_in_list');*/
				
				
				
		    }
			if (data == "") 
			{
				var alertmsg = "No Products In Selected List";
				$("#idGlobalAlert").html(alertmsg);
				$('#globalAlert').modal('show');
				$('#products_display').addClass('successSearch');
				$('#product_heading').addClass('successSearch');
 			}
				 			
			
          	
		}
		});

}
$("#specific_price").keypress(function (e) {
 		if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
	return false;
	}
});

  
function editPrice(id_product)
{
	$('.specPrice').keypress(function (e) {
 		if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
		return false;
		}
	});
//removeClass("noBorder");	
	$('.savePart_'+id_product).show();
	$('.editPart_'+id_product).hide();
	$('#product_price'+id_product).removeClass("noBorder");
	$('#product_price'+id_product).addClass("form-control");
}
function cancelEdit(id_product)
{
	$('.savePart_'+id_product).hide();
	$('.editPart_'+id_product).show();
	$('#product_price'+id_product).removeClass("form-control");
	$('#product_price'+id_product).addClass("noBorder");
}
function savePrice(id_product,confirmation)
{
   	var type=confirmation;
	var specific_price=$('#product_price'+id_product).val();
	if(window.special_price !="0.00")
	{
		specific_price=window.special_price;
	}
	var setcookie=1;
	var dataparam = '&type='+type+'&id_product='+id_product+'&specific_price='+specific_price+'&id_customer='+id_customer+'&setcookie='+setcookie+'&confirm='+confirmation;
	$.ajax({
				type: 'POST',
 				async: true,
 				url: 'rm-addtorate.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
					window.special_price=0.00;
					if(data==101)
					{
						if(confirm("This product is listed under deals.\n If you want to Deactivate the deal press 'OK' else press 'CANCEL'to just add the product to the Purchase List"))
						{							
							savePrice(id_product,2);
						}
						else
						{
							displayProduct(1);
						}
					}
					if(data == 4)
					{
						toast("Special Price added Successfully","success");
						cancelEdit(id_product);
					}
					if(data == 3)
					{
						toast("Special Price Updated Successfully","success");
						cancelEdit(id_product);
					}
					/*if(data == 2)
					{
						toast("Special Price Added Successfully","success");
						cancelEdit(id_product);
					}*/
				}
	});
}
function deleteProduct(id_rate_contract,id_product,id_customer)
{
	 $.ajax({
			type: 'POST',
 			async: true,
			url: 'rm-customerratecontractdata.php',
 			data: {id_rate_contract:id_rate_contract,type:2,id_customer:id_customer,id_product:id_product},
			cache: true,
 			success: function(data)
			{
 				if(data == 1)
				{
					$("#tr_pur_id_"+id_product).remove();
 					toast("Product Deleted successfully from Purchaselist","success");
				}
			}
	 });
}
