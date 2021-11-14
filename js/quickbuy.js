
function loadnewpage()
{
	var productarray = new Array();
	 	var type=2;

$('td.quickbuyprodetails').each(function () {
	
//	ajaxCart.add(this.id, null, false, this,$(this).html(), null);
productarray.push(this.id+"-"+$(this).html());
});
if(productarray=="")
	{	
	$('#noproduct').modal('show');
 		return false;
	}
	var dataparam = '&productarray='+productarray+'&type='+type;
		$.ajax({
			type: 'GET',
			dataType:'json',
			async: true,
			url:'PurchaseList.php',
			data: dataparam,
			cache: false,
 			success: function(data)
			{
 				if(data==1)
				{
					
				//	alert("Products added to the cart successfully");
 					//window.location.replace("http://localhost/kobstereshop/order.php");
					
				}
			}
	});





	$.ajax({
			type: 'POST',
			url: 'dash-address.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{id_customer:id_customer,type:3},
			success: function(jsonData)
			{ 
				for(i=0;i<jsonData.length;i++)
				{
			    $("#dash-customer-address").append("<div class='col-md-3'  id='address-div'><section class='panel'><div class='panel-body' ><div class='top-stats-panel'><form action='' method='post' class='std' id='dash-user-"+jsonData[i].id_address+"'><span class='cop_profile_title col-md-8'>Basic Information</span><span class='cop_profile_edit col-md-4' id='profile_edit"+jsonData[i].id_address+"' onclick='fn_edit("+jsonData[i].id_address+");'>Edit <i class='fa fa-edit'></i></span><span class='cop_profile_cancel' id='cancel_profile_edit"+jsonData[i].id_address+"' style='display:none' onclick='fn_cancel("+jsonData[i].id_address+");'>Cancel</span><div id='address-clickable' onClick='takeaddress("+jsonData[i].id_address+");'><div class='required col-md-12'><input  class='cop_profile_value"+jsonData[i].id_address+" border-address-element col-md-12' type='text' id='firstname"+jsonData[i].id_address+"' readonly='readonly' placeholder='Name' name='firstname' value='"+jsonData[i].firstname+jsonData[i].lastname+"' /><span id='error_name"+jsonData[i].id_address+"' class='add_error col-md-4' ></span></div><div class='required col-md-12'><textarea rows='3' id='address"+jsonData[i].id_address+"' class='cop_profile_value"+jsonData[i].id_address+" border-address-element col-md-12 dash-user-add'  type='text'  readonly='readonly'  placeholder='Address' name='address'>"+jsonData[i].address1+"</textarea></div><div class='required col-md-12'><input  class='cop_profile_value"+jsonData[i].id_address+" border-address-element col-md-12' type='text' id='dash-user-postcode"+jsonData[i].id_address+"' readonly='readonly' placeholder='Postcode' name='postcode' maxlength='6' value='"+jsonData[i].postcode+"' /><span id='error_postcode"+jsonData[i].id_address+"' class='add_error col-md-4' ></span></div><div class='required col-md-12'><input  class='cop_profile_value"+jsonData[i].id_address+" border-address-element col-md-12' type='text' id='dash-user-city"+jsonData[i].id_address+"' readonly='readonly' placeholder='City' name='city' value='"+jsonData[i].city+"' /><span id='error_city"+jsonData[i].id_address+"' class='add_error col-md-4' ></span></div><div class='required col-md-12'><input  class='cop_profile_value"+jsonData[i].id_address+"  border-address-element col-md-12' type='text' id='dash-user-state"+jsonData[i].id_address+"' readonly='readonly' placeholder='State' name='state' value='"+jsonData[i].state+"' /><span id='error_state"+jsonData[i].id_address+"' class='add_error col-md-4' ></span></div><div class='required col-md-12'><input  class='cop_profile_value"+jsonData[i].id_address+" border-address-element col-md-12' type='text' id='dash-user-mobile"+jsonData[i].id_address+"' readonly='readonly' placeholder='Mobile' size='10' maxlength='10' name='mobile' value='"+jsonData[i].phone_mobile+"' /><span id='error_mobile"+jsonData[i].id_address+"' class='add_error col-md-4' ></span><a  id='dash-user-add-save"+jsonData[i].id_address+"' class='btn btn-primary border-address-element'  onClick='dashusersave("+jsonData[i].id_address+");'>Save<i style='margin-left:2px;'class='fa fa-save'></i></a></div></form></div></div></div></section></div>");
			}
			}
			
	});
	
				$('#index_viewport').html('');
	$('#index_viewport').load(""+baseDir+"dash/dash-address.tpl");

}

function tohideemptyresult()
{
	$("#quickbuy-product-not-found").hide();	
}

$(function()
{
	$('#noproduct').modal({ show: false});
	$('#minimumquantity').modal({ show: false});
	$("#focusedInput").val("");
	$("#dash-corporate-user-quantity-value").val(1);
	$('#quick-buy-list').slimScroll({
wheelStep: 15
});

});

$(document).ready(function()
{
	$("#dash-corporate-user-quantity-value").keypress(function (e) {
if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
return false;
}
});
		$(".productquantity").keypress(function (e) {
if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
return false;
}
		});

	var productname,idProduct,id_product_attribute,quickbuycount=1,todelete,objectlength,i;
	var auto=2;
	$("#focusedInput").autocomplete("quickbuysearch.php?auto="+auto+"&id_customer="+id_customer,{
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
		$("quickbuy-product-not-found").hide();	
var mytab = new Array();
		for(var i = 0; i < data.length; i++)
				mytab[mytab.length] = { data: data[i].id_product+"~" +data[i].name+"~" +data[i][1].toFixed(2), value:"<div><span  id='search_image'>"+"<img class='dummy' src="+data[i][0]+">" +"</span>"+ "<span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>"+data[i].name+"</br>"+"Product Code:"+data[i].reference+"</br>"+"Price: Rs."+(data[i][1]).toFixed(2)+"</span></div>"};
			return mytab;
}},
	}).result(
	function(event, data, formatted, value) {
		        var separate=data.split("~");
				productname=separate[1];
				$('#focusedInput').val(productname);
		 idProduct=separate[0];
	id_product_attribute=separate[2];
	
	changefocus();
	});
 	$("#dash-corporate-user-add-to-cart").click(function(){
	var quantity=$("#dash-corporate-user-quantity-value").val();
	if(quantity<1)
	{
			$('#minimumquantity').modal('show');

		
			}
	else
	{
	var price;
	price=quantity*id_product_attribute;
	if(!idProduct=="")
	{	
	$("<tr id='tr_id"+quickbuycount+"' class='odd'><td class='quickbuylist-product-name'>"+productname+"</td><td id="+idProduct+"  class='center tex-ali-cen quickbuyprodetails'>"+quantity+"</td><td class='center '>"+price.toFixed(2)+"</td><td class='sorting_1 '><a class='fa fa-trash-o delete-option' onClick='adddeleteproduct("+quickbuycount+");'></a></td></tr>").prependTo('table > tbody');
	/*ajaxCart.add(idProduct, null, false, this, quantity, null);*/
	$("#focusedInput").val("");
	$("#dash-corporate-user-quantity-value").val(1);
	$("#focusedInput").focus();
	quickbuycount++;
	idProduct="";
	}
	}
	});
	
function changefocus()
	{
		$("#dash-corporate-user-quantity-value").select();
	}
$("#quickbuy-add-to-cart").click(function(){
	});
});


function adddeleteproduct(todelete)
{
	$("#tr_id"+todelete).html("");
}	
$(document).ajaxStart(function() {
$("#quickbuy-processing").show();
});
$(document).ajaxStop(function() {
$("#quickbuy-processing").hide();
 });
$(document).keypress(function(event){
	var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
		$('#dash-corporate-user-add-to-cart').click();   
    }
});	
