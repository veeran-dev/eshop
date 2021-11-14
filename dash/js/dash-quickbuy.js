$('.toggle-right-box, #total_cart_products').show();
/*function addToCart(productarray,type)
{
	var json={"productarray":productarray};
	//	var dataparam = '&productarray='+json+'&type='+type;
	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url:'dash-shopping-cart.php',
		data: {productarray:json,type:type},
		cache: false,
		success: function(data)
		{
		}
	});
	$("a[href$='#next']").click();

	
}*/
function loadAddressPage()
{
	
	var type=7;
	if(productsArray=="")
	{	
		$.ajax({
			type: 'POST',
			url: 'dash-getcartproduct.php',
			async: true,
			cache: false,
			dataType : "json",
			success: function(jsonData)
			{
				if(jsonData=="")
				{
					alert("No products to Add");
					return false;
				}
				else
				{
					$("a[href$='#next']").click();
				}
				
			}
		});
		}
	else
	{
		addToCart(productsArray,type);
	}

}

function toHideEmptyResult()
{
	$("#quickbuy-product-not-found").hide();	
}

$(function(){

	$('#noproduct').modal({ show: false});
	$('#minimumquantity').modal({ show: false});
	$("#focusedInput").val("");
	$("#dash-corporate-user-quantity-value").val(1);
	$('#quick-buy-list').slimScroll({
		height:"330px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});
	$('#quick-buy-search').slimScroll({
		height:"450px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});

});

$(document).ready(function()
{
	ordering_type=2;//represent the page type for the back purpose of steps
	$("a[href$='#next']").hide();
	$("a[href$='#previous']").hide();
	$("#wizard-p-0").addClass("padding-align-right padding-align-left padding-align-top padding-align-bottom");
	$("#wizard-p-1").addClass("padding-align-right padding-align-left padding-align-top padding-align-bottom");
	$("#wizard-p-2").addClass("padding-align-right padding-align-left padding-align-top padding-align-bottom confirmation-div");
	
	$("#wizard-p-0").css("width","100% !important");
	window.product={};
	window.productsArray=[];
	
	$('.ac_results').click(function(){		
		$("#dash-corporate-user-quantity-value").focus();
		$("#dash-corporate-user-quantity-value").select();
	});
	$("#dash-corporate-user-quantity-value").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	return false;
	}
	$("#next_buton").show();
});

var productname,idProduct,id_product_attribute,quickbuycount=1,todelete,objectlength,i;
var auto=2;
$("#focusedInput").autocomplete("dash-quickbuysearch.php?auto="+auto+"&id_customer="+id_customer+"&mode=0",
{
minChars:3,
max: 10,
dataType:"json",
formatItem: function(data, i, max, value, term) {
return value;
},
parse: function(data){
if(data=="")
{
	$("#quickbuy-processing").hide();	
	$("#quickbuy-product-not-found").show();	
	return data;
}
else{
	$("#quickbuy-product-not-found").hide();	
	var mytab = new Array();
	var img_link ="";
	for(var i = 0; i < data.length; i++)
	{
		if (data[i][0].indexOf('http') > -1) 
		{
			img_link = data[i][0];
		} 
		else 
		{
			img_link ="http://"+data[i][0];
 		}
		mytab[mytab.length] = { data: data[i].id_product+"~" +data[i].name+"~" +data[i][1].toFixed(2)+"~" +data[i].link, value:"<div><span  id='search_image'>"+"<img class='dummy' src="+img_link+">" +"</span>"+ "<span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>"+data[i].name+"</br>"+"Product Code:"+data[i].reference+"</br>"+"Price: Rs."+(data[i][1]).toFixed(2)+"</span></div>"};
	}
	return mytab;
}},
}).result(
function(event, data, formatted, value) {
 	var separate=data.split("~");
	//productname=separate[1];
	
	product={productLink:separate[3],productname:separate[1],idProduct:separate[0]/*,id_product_price:separate[2]*/,quantity:$("#dash-corporate-user-quantity-value").val(),price:separate[2]};
 	$('#focusedInput').val(product.productname);
 	idProduct=separate[0];
 	toChangeFocus();
	$("#quickbuy-product-not-found").hide();	

});

$("#dash-corporate-user-add-to-cart").click(function(){
	
	var quickbuy=$("#focusedInput").val();
 	if(quickbuy=="")
	{
		alert("Please select the product.");
		return false;
	}
	 
 	if($("#dash-corporate-user-quantity-value").val()<1)
	{
		$('#minimumquantity').modal('show');
	}
	
	else
	{
 		var rm_portal=$("#hide_rm_portal").val();
		 
 			
			var type=7;
			var quick_qty = $("#dash-corporate-user-quantity-value").val();
 			var dataparam = '&quick_idProduct='+idProduct+'&quick_qty='+quick_qty+'&type='+type;
 			$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url:'dash-PurchaseList.php',
				data: dataparam,
				cache: false,
				success: function(data)
				{
					
 					 $('#listoferrors').html('');
 					 if(data.msg != "success")
					 {
 						$('#listoferrors').append("<tr><td>"+data.name+"</td><td>"+data.msg+"</td></tr>");
 						$('#error_cart').modal('show');
					 }
					 else
					 {
 						loadShopingCart(false);//true and false represent that we need to load the loyalty points along with shopping cart or not.
						if ($('#container').hasClass('open-right-panel')) {
						}
						else
						{	
							$('.toggle-right-box .fa-shopping-cart').click();
						}
					 }
   				 
 					
					/*load shopping cart by default*/
					
					$("#focusedInput").val("");
					$("#dash-corporate-user-quantity-value").val(1);
					$("#focusedInput").focus();
					idProduct="";
 					/*if(rm_portal!=1)/*loadShopingCart() in dash-index.js*/
					/*{
						alert("2");
						loadShopingCart();
					}*/
						
				}
			});
		
	}
});
/*function updateProductValue()
{
	$("#quickbuy-list-body").html("");
	for(var i=0;i<productsArray.length;i++)
	{
		$("<tr id='quickbuyId"+productsArray[i].idProduct+"' class='odd'><td class='quickbuylist-product-name'><a href='"+productsArray[i].productLink+"' target='_blank'>"+productsArray[i].productname+"</a></td><td id='quick-buy-quantity"+productsArray[i].idProduct+" ' class='center tex-ali-cen quickbuyprodetails'>"+productsArray[i].quantity+"</td><td class='center '>Rs. "+productsArray[i].price.toFixed(2)+"</td><td class='sorting_1 '><a class='fa fa-trash-o delete-option' onClick='toDeleteProduct("+productsArray[i].idProduct+");'></a></td></tr>").prependTo('table > tbody');
	}	
	$("#focusedInput").val("");
	$("#dash-corporate-user-quantity-value").val(1);
	$("#focusedInput").focus();
	idProduct="";

}*/
function toChangeFocus()
{
	$("#dash-corporate-user-quantity-value").focus();
	$("#dash-corporate-user-quantity-value").select();
}
});


/*function toDeleteProduct(id_product)
{
	for(var j=0;j<productsArray.length;j++)
	{
		if(productsArray[j].idProduct==todelete)
		{
			productsArray.splice(j,1);
		}
	}
	$("#quickbuyId"+id_product).remove();
	toRemoveCartProduct(id_product,0,0,id_product);
}*/
$("#dash-corporate-user-quantity-value").keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		$('#dash-corporate-user-add-to-cart').click();   
	}
});	


