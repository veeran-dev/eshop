window.loyalty_points;
$(function()
{	
	if (ordering_type == 1) {
		$("#wizard-t-0").parent().addClass('disabled');
	}

	$('#dash-customer-address').slimScroll({
		height: '400px',
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
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
			$("#dash-customer-address").html('');
			if(rm_portal==1){
				$("#dash-customer-address").append("<div id='cop_user_profile'><div id='cop_user' class='col-md-12 tex-ali-cen'><b>Add / Choose Customer Delivery Address</b>");
			}
			else{
				//$("#dash-customer-address").append("<div id='cop_user_profile'><div id='cop_user' class='col-md-12 tex-ali-cen'><b>Choose Your Delivery Address</b>");
			}
			if(jsonData[0]=="" && rm_portal !=1)
			{
				$('#cop_user').remove();
				//$("#dash-customer-address").append("<a data-toggle='modal' id='clickaddress'  href='#myaddress' onclick='addHiddenValue();' class='btn btn-primary'>Add Address<i class=' fa fa-newaddress'></i></a>");
				$("#dash-customer-address").append("<div class='col-md-4 ' ><a data-toggle='modal' id='clickaddress'  href='#myaddress' onclick='addHiddenValue();'><section class='panel address-div-height'><div class='panel-body' ><div class='top-stats-panel' style='margin-left: 33%; margin-top: 33%;'><form action='' method='post' class='std'><img src='"+baseDir+"dash/images/add_address.png'/><div class='select-add-div col-md-12'><button type='button'  class='select-add-button btn btn-info'>Add Address</button></div></form></div></div></section></a></div>");
			}

			for(i=0;i<jsonData[0].length;i++)
			{
				if(deliverRegionRm == jsonData[0][i].id_state) {
					if(rm_portal == 1) {
						//var edit_button = "<span class='cop_profile_edit col-lg-3' id='profile_edit"+jsonData[0][i].id_address+"' onclick='toEdit("+jsonData[0][i].id_address+","+i+");'>Edit</span><span class='cop_profile_delete col-lg-3' id='profile_delete"+jsonData[0][i].id_address+"' onclick='toDelete("+jsonData[0][i].id_address+","+i+");'>Delete</span><span class='cop_profile_cancel col-lg-3' id='cancel_profile_edit"+jsonData[0][i].id_address+"' style='display:none' onclick='toCancel("+jsonData[0][i].id_address+","+i+");'>Cancel</span>"
						var edit_button= '';
					}
					else {
						var edit_button= '';
					}
			
					$("#dash-customer-address").append("<div class='col-md-4 '  id='address-div"+jsonData[0][i].id_address+"'>\
														<section class='panel address-div-height'>\
															<div class='panel-body' >\
																<div class='top-stats-panel'>\
																	<form action='' method='post' class='std' id='dash-user-"+jsonData[0][i].id_address+"'>\
																		<span class='col-lg-6 col-md-5 col-sm-9 col-xs-9'></span>"+edit_button+"\
																			<div id='address-clickable' onClick='getAddress("+jsonData[0][i].id_address+");'>\
																			<div id='corporate-customer-alias"+i+"' class='required col-md-12'>\
																				<input  class='cop_profile_value"+jsonData[0][i].id_address+" cur-poi border-address-element col-md-12' type='text' id='alias"+jsonData[0][i].id_address+"' readonly='readonly' placeholder='Address Alias' name='alias' value='"+jsonData[0][i].alias+"' />\
																				<span id='error_alias"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																			</div>\
																			<div id='corporate-customer-name"+i+"' class='required col-md-12'>\
																				<input  class='cop_profile_value"+jsonData[0][i].id_address+" cur-poi border-address-element col-md-12' type='text' id='firstname"+jsonData[0][i].id_address+"' readonly='readonly' placeholder='Name' name='firstname' value='"+jsonData[0][i].firstname+jsonData[0][i].lastname+"' />\
																				<span id='error_name"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																			</div>\
																			<div id='corporate-customer-company"+i+"' class='required col-md-12'>\
																				<textarea rows='1' id='dash-user-company-name"+jsonData[0][i].id_address+"' class='cop_profile_value"+jsonData[0][i].id_address+" border-address-element col-md-12 cur-poi dash-user-add'  type='text'  readonly='readonly'   placeholder='Company Name' name='company-name'>'"+jsonData[0][i].company+"'</textarea>\
																				<span id='error_company-name"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																			</div>\
																			<div id='corporate-customer-address"+i+"' class='required col-md-12'>\
																				<textarea rows='2' id='address"+jsonData[0][i].id_address+"' class='cop_profile_value"+jsonData[0][i].id_address+" border-address-element col-md-12 cur-poi dash-user-add'  type='text'  readonly='readonly'  placeholder='Address' name='address'>"+jsonData[0][i].address1+"</textarea>\
																			</div>\
																			<div id='corporate-customer-postcode"+i+"' class='required col-md-12'>\
																				<input  class='cop_profile_value"+jsonData[0][i].id_address+" border-address-element cur-poi col-md-12' type='text' id='dash-user-postcode"+jsonData[0][i].id_address+"' readonly='readonly' placeholder='Postcode' name='postcode' maxlength='6' value='"+jsonData[0][i].postcode+"' />\
																				<span id='error_postcode"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																			</div>\
																			<div id='corporate-customer-country"+i+"' class='required col-md-12'>\
																				<input  class='cop_profile_value"+jsonData[0][i].id_address+"  cur-poi border-address-element col-md-12' type='text' id='dash-user-country"+jsonData[0][i].id_address+"' readonly='true'  placeholder='Country' name='country' value='"+jsonData[0][i].country+"' />\
																				<span id='error_country"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																			</div>\
																			<div id='corporate-customer-state"+i+"' class='required col-md-12 select-box-div-width'>\
																				<label class='cop_profile_value"+jsonData[0][i].id_address+" cur-poi border-address-element col-md-12 select-box-width ' id='dash-user-state-label"+jsonData[0][i].id_address+"' readonly='readonly' placeholder='State' name='state' >"+jsonData[0][i].state+"</label>\
																				<select id='dash-user-state"+jsonData[0][i].id_address+"'  class='cop_profile_value"+jsonData[0][i].id_address+" cur-poi border-address-element col-md-12 select-box-width successSearch' readonly='readonly' placeholder='State' name='state'/></select>\
																				<span id='error_state"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																			</div>\
																			<div id='corporate-customer-city"+i+"' class='required col-md-12'>\
																				<input  class='cop_profile_value"+jsonData[0][i].id_address+" cur-poi border-address-element col-md-12' type='text' id='dash-user-city"+jsonData[0][i].id_address+"' readonly='readonly' placeholder='City' name='city' value='"+jsonData[0][i].city+"'/>\
																				<span id='error_city"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																			</div>\
																			<div id='corporate-customer-mobile"+i+"' class='required col-md-12'>\
																				<input  class='cop_profile_value"+jsonData[0][i].id_address+" cur-poi border-address-element col-md-12' type='text' id='dash-user-mobile"+jsonData[0][i].id_address+"' readonly='readonly' placeholder='Mobile' size='10' maxlength='10' name='mobile' value='"+jsonData[0][i].phone_mobile+"' />\
																				<span id='error_mobile"+jsonData[0][i].id_address+"' class='add_error col-md-4' ></span>\
																				<a  style='display:none;' id='dash-user-add-save"+jsonData[0][i].id_address+"' class='btn btn-primary border-address-element'  onClick='toSaveChanges("+jsonData[0][i].id_address+");'>Save<i style='margin-left:2px;'class='fa fa-save'></i></a>\
																			</div>\
																			<div class='select-add-div col-md-12'>\
																				<button type='button' id='select-this-address-"+ jsonData[0][i].id_address +"' class='select-add-button btn btn-info'>Select this Address</button>\
																			</div>\
																		</form></div></div></div></section></div>")
					
					if(jsonData[0][i].firstname=="" ||jsonData[0][i].firstname==null)
					{
							$("#corporate-customer-name"+i).hide();
					}
					if(jsonData[0][i].company=="" || jsonData[0][i].company==null )
					{
							$("#corporate-customer-company"+i).hide();
					}
					if(jsonData[0][i].address1=="" || jsonData[0][i].address1==null)
					{
							$("#corporate-customer-address"+i).hide();
					}
					if(jsonData[0][i].city=="" || jsonData[0][i].city==null)
					{
							$("#corporate-customer-city"+i).hide();
					}
					if(jsonData[0][i].state=="" || jsonData[0][i].state==null)
					{
							$("#corporate-customer-state"+i).hide();
					}
					if(jsonData[0][i].postcode=="" || jsonData[0][i].postcode==null)
					{
							$("#corporate-customer-postcode"+i).hide();
					}
					if(jsonData[0][i].phone_mobile=="" || jsonData[0][i].phone_mobile==null)
					{
							$("#corporate-customer-mobile"+i).hide();
					}
					if(jsonData[0][i].country=="" || jsonData[0][i].country==null)
					{
							$("#corporate-customer-country"+i).hide();
					}
					if(jsonData[0][i].state==null)
					{
						$('#dash-user-state'+jsonData[0][i].id_address).val("");
					}
				
					for(var j=0;j<jsonData[1].length;j++)
					{	 
						if(jsonData[0][i].id_state==jsonData[1][j].id_state)
						{
							$('#dash-user-state'+jsonData[0][i].id_address).append("<option selected='selected' class='col-md-12' value='"+jsonData[1][j].id_state+"'>"+jsonData[1][j].name+"</option>");
						}
						else
						{
							$('#dash-user-state'+jsonData[0][i].id_address).append("<option class='col-md-12' value='"+jsonData[1][j].id_state+"'>"+jsonData[1][j].name+"</option>"); 
						}
					}
				}
			}
		}	
	});

});


function getAddress(id)
{
	var stateName = $("#dash-user-state"+id+" :selected").text();
	
	if($('#address-clickable div input').hasClass("border"))
	{
		return false;
	}

	if(!$('.cop_profile_value'+id).hasClass("border"))
	{
		if(window.rm_portal==0 && stateName!=name_state_vat)
		{
			var alertmsg = '<p class="address_note">The selected address is not in <b>'+name_state_vat+'</b><br>Tax may vary for each product based on state selected<br>To change state click <a class="cur-poi address_anchor" onclick="showState();">here</a></p>';
	        $("#idGlobalAlert").html(alertmsg);
			$('#globalAlert').modal('show');
			return;
		}

		$.ajax({
			type: 'POST',
			url: 'dashpaymentoption.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{id_customer:id_customer,type:5,deliveryAddressId:id},
			success: function(jsonData)
			{}
		});

		alias=$('#alias'+id).val();
		firstname=$('#firstname'+id).val();
		companyname=$('#dash-user-company-name'+id).val();
		address=$('#address'+id).val();
		postcode=$('#dash-user-postcode'+id).val();
		city=$('#dash-user-city'+id).val();
		state=$("#dash-user-state"+id+" :selected").text();
		country=$('#dash-user-country'+id).val();
		mobile=$('#dash-user-mobile'+id).val();
		if ($('#wizard-p-1').length > 0) 
		{ 
			// it exists 
			$('.toggle-right-box').show();
			//loadViewContent(0);
				$("a[href$='#next']").click();	
		}
		else
		{
			$('#index_viewport').html('');
			$('#index_viewport').load('dash-shoppingsummary.php',function()
			{
				loadViewContent();
			});

		}
	}	
}

$(document).ready(function(){
	$('#po_upload').live('click',function(){
		if($("#name_po").val()=='')
		{
			var alertmsg = "Please enter PO number";
	        $("#idGlobalAlert").html(alertmsg);
	        $('#globalAlert').modal('show');
		}
		else
		{
			$('#uploadFile').click();
		}
	});

	$('#uploadFile').live('change',function(){
		//var po_number = $('#name_po').val();
		po_file_elite = this.files[0];
		if(po_file_elite.size > 2097152){
			var alertmsg = "Please upload your PO less than 2MB of size";
	        $("#idGlobalAlert").html(alertmsg);
	        $('#globalAlert').modal('show');
		}
		else{
			po_file_value_elite = $('#name_upload_po').val(po_file_elite.name);
		}
	});

	$.ajax({
		type: 'GET',
		url: 'dash-get-group-info.php',
		async: true,
		cache: false,
		dataType : "json",
		data:{id_customer:id_customer,type:12},
		success: function(jsonData)
		{	
			$('#po_mandatory').val(jsonData.po_mandatory);
		}
	});
});

function loadViewContent(id)
{

	$('#main-content').removeClass('panel-open');
 	$(function(){
	 	window.paymentdata="";
		$('#cart-products').slimScroll({
			height: '310px',
			wheelStep: 1,
			railVisible: true,
			alwaysVisible: true
		});
		
		var type=1;
		$.ajax({
			type: 'POST',
			url: 'dashpaymentoption.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{id_customer:id_customer,type:type},
			success: function(jsonData)
			{	
				$('#payment_options').html('');
				var cus_role='{$cookie->role}';
				if(cus_role !=1)					
					$('#payment_options').html('<h5 class="font-weight col-md-12">COMPLETE YOUR PURCHASE</h5>');
				else
					$('#payment_options').html('<h5 class="font-weight col-md-12">PLACE YOUR ORDER HERE</h5>');
				for(var i=0;i<jsonData.length;i++)
				{
					if(jsonData[i].id_payment==1)
							$("#payment_options").append("<div id='payment_options"+i+"' class='payment-option-margin' ><a  class='' onclick='paymentMode(1);'><img src='dash/images/cod2.png'/><br/><span>Cash on <br/> Delivery</span></a></div>");
						
						if(jsonData[i].id_payment==2)
							$("#payment_options").append("<div id='payment_options"+i+"' class='payment-option-margin' ><a  class='' onclick='paymentMode(2);'><img src='dash/images/cheque_icon.png'/><br/><span>Cheque</span></a></div>");
						
						if(jsonData[i].id_payment==3)
							$("#payment_options").append("<div id='payment_options"+i+"' class='payment-option-margin' ><a  class='' onclick='paymentMode(3);'><img src='dash/images/neft2.png'/><br/><span>NEFT/RETG</span></a></div>");
					if(rm_portal !=1)
					{
						if(jsonData[i].id_payment==4)
								$("#payment_options").append("<div id='payment_options"+i+"' class='payment-option-margin' ><a  class='' onclick='EBS();'><img src='dash/images/net_pay.png'/><br/><span>Card Payment</span></a></div>");
					}
					if(jsonData[i].id_payment==5)//user=>creater, id_role =>1
								$("#payment_options").append("<div id='payment_options"+i+"' class='payment-option-margin' ><a  class='' onclick='paymentMode(5);'><span class='btn btn-primary'>Send Order for Approval</span></a></div>");
						if(jsonData[i].id_payment==6)
								$("#payment_options").append("<div id='payment_options"+i+"' class='payment-option-margin' ><a  class='' onclick='paymentMode(6);'><img src='dash/images/credit-payment.png'/><br/><span>Credit</span></a></div>");
					}
			}	
		});

		$.ajax({
			type: 'POST',
			url: 'dash-getcartproduct.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{type:0},
			success: function(jsonData)
			{
					if(jsonData=="")
				{
					$("#globalAlert").show('show');
					$("#idGlobalAlert").html("No Products In Your Shoping Cart");
						return false;
				}
				$('#cart-products-list-body').html('');
			for(var i=0;i<jsonData.length;i++)
				{
					prod_price="Rs."+jsonData[i].total;
					$("<tr id='cart-products-row-id"+jsonData[i].id_product+"' class='odd'><td class='col-md-1 cart-products-row-no' id='cart-products-row-sno_"+(jsonData.length-i)+"'>"+(jsonData.length-i)+"</td><td class='col-md-2' ><img src='"+jsonData[i][0]+"'></td><td class='col-md-5 cur-poi' onClick='quickView("+jsonData[i].id_product+",2);'>"+jsonData[i].name+"</td><td class='col-md-2 tex-ali-cen' ><input id='qty_"+jsonData[i].id_product+"' onkeydown='numbersOnly(event)' onchange='forChangeInQuantity("+jsonData[i].id_product+","+jsonData[i].price.toFixed(2)+","+jsonData[i].minimal_quantity+");' class='productquantity tex-ali-cen qv_quantity_wanted' size='4' type='text' maxlength='5' value='"+jsonData[i].quantity+"'  /></td><td id='price_"+jsonData[i].id_product+"'class='col-md-3' >Rs. "+jsonData[i].total+"</td><td class='sorting_1 '><a onClick='toRemoveCartProduct("+jsonData[i].id_product+","+null+","+jsonData[i].id_customization+","+jsonData[i].id_product+");' class='fa fa-trash-o delete-option' ></a></td></tr>").prependTo('table > #cart-products-list-body');
				}
				var discountids= [];
				if(jsonData[0][5] !="")
			{
					var discountValue =0;
					for (var j=0; j<jsonData[0][5].length; j++)
				{
					var discount_value = jsonData[0][5][j].reduction_amount;
				discountValue += parseFloat(discount_value);
				discountids.push(jsonData[0][5][j].id_cart_rule);
					}
			}
			else
			{
				var discountValue=0;
			}
			if(id!=1)
				loadVoucherCode(discountids);

				//$("#cart-product-price").html("<div class='pull-left '><span><input type='text' value='' id='name_vouchercode' placeholder='Enter Voucher Code' name='name_vouchercode' /></span><span id='voucher_apply' class='btn btn-info btn-xs' onclick='addDiscount(0,1);'>Apply</span>&nbsp;/&nbsp;<span class='btn btn-info btn-xs'id='voucherCount' onclick=openVoucher();>View Vouchers</span><div class='upload_block_po'><span><input type='file' name='uploadFile' id='uploadFile'><span><input type='text' value='' id='name_upload_po' placeholder='Upload Your PO' name='name_upload_po'/>&nbsp;&nbsp;<span><input type='submit' id='po_upload' class='btn btn-info btn-xs' name='send_qutoes_detail' value='Upload'/></span></div> </div><div class='priceincart'><span  class='price-margin-right'><i class=''></i>Discount :</span><span class='price-font'> "+discountValue.toFixed(2)+" </span></div><br/><div class='priceincart'><span  class='price-margin-right'><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'> "+jsonData[0][2]+" </span></div><br/><div class='priceincart'><span  class='price-margin-right' ><i class='fa fa-money total-money'></i>Tax :</span><span class='price-font'>Rs. "+jsonData[0][4]+"</span></div><br/><div class='priceincart'><span  class='price-margin-right'><i class='fa fa-money total-money'></i>Total :</span><div class='price-font'> "+jsonData[0][3]+" </div></div>");
			loyalty_points = jsonData[0][6];
			var currency = (jsonData[0][4]).split(' '); 
			
				$('#discount').html(parseFloat(discountValue).toFixed(2));
			//$('#shopping-cost').html(currency[0]+" "+'0.00');
			$('#tax').html(jsonData[0][4]);
			$('#loyalty_points').html(jsonData[0][6]);
			$('#loyalty_points_summary').html(jsonData[0][6]);
			//$('#loyalty_points_thankyou').html(jsonData[0][6]);
			$('#total-shopping-cost').html(jsonData[0][3]);
			$('#uploadFile').hide();
			}	
		});

		$('#confirmed-address').html('');
		$('#confirmed-address').append("<h5 class='font-weight col-md-12'>YOUR DELIVERY ADDRESS</h5><div class='font-size padding-align-left padding-align-right'><div id='corporate-customer-alias' class='address-field-margin col-md-12'>"+alias+"</div><div id='corporate-customer-name' class='address-field-margin col-md-12'>"+firstname+"</div> <div id='corporate-customer-company' class='address-field-margin col-md-12'>"+companyname+"</div><div id='corporate-customer-address' class='address-field-margin col-md-12'>"+address+"</div><div id='corporate-customer-postcode' class='address-field-margin col-md-12'>"+postcode+"</div><div id='corporate-customer-country'class='address-field-margin col-md-12' >"+country+"</div><div id='corporate-customer-state' class='address-field-margin col-md-12' >"+state+"</div><div id='corporate-customer-city' class='address-field-margin col-md-12'>"+city+"</div> <div id='corporate-customer-mobile'  class='address-field-margin col-md-12'>"+mobile+"</div></div>");
		
		if(firstname=="" ||firstname=="null")
				{
					$("#corporate-customer-name").hide();
			}
			if(companyname=="" || companyname=="null" )
				{
					$("#corporate-customer-company").hide();
			}
			if(address=="" || address=="null")
				{
					$("#corporate-customer-address").hide();
			}
			if(city=="" || city=="null")
				{
					$("#corporate-customer-city").hide();
			}
			if(state=="" || state=="null")
				{
					$("#corporate-customer-state").hide();

			}
			if(postcode=="" || postcode=="null")
				{
					$("#corporate-customer-postcode").hide();
			}
			if(mobile=="" || mobile=="null")
				{
					$("#corporate-customer-mobile").hide();
			}
			if(country=="" || country=="null")
				{
					$("#corporate-customer-country").hide();
			}		
	});
	/*********************************Srini part******************************************************/
			/*$.ajax({
			type: 'POST',
			url: 'dashpaymentoption.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{type:6,id_customer:id_customer},
			success: function(payment)
			{
				
 				window.paymentdata=payment;
 			}
	});*/
}

function toEdit(id,divId)
{
	$('#address-clickable section').unbind('hover');
	$('.cop_profile_value'+id).attr("readonly", false);
	$('#dash-user-country'+id).attr("readonly", true);
	$('.cop_profile_value'+id).addClass("border");
	$('#dash-user-state'+id).removeClass("select-box-width");
		$('.cop_profile_value'+id).css({"border-color": "black"});
	
	$('#dash-user-state-label'+id).addClass("successSearch");
	$('#dash-user-state'+id).removeClass("successSearch");
	


	$('.cop_profile_value'+id).removeClass("cur-poi");	
		$('#cancel_profile_edit'+id).show();
	$('#profile_edit'+id).hide();
	$("#dash-user-add-save"+id).show();
	$('.cop_profile_edit').css("display","none");
	
		$('#corporate-customer-alias'+divId).show();
		$('#corporate-customer-name'+divId).show();
		$('#corporate-customer-company'+divId).show();
		$('#corporate-customer-city'+divId).show();
		$('#corporate-customer-state'+divId).show();
		
		$('#corporate-customer-postcode'+divId).show();
		$('#corporate-customer-mobile'+divId).show();
		$('#corporate-customer-address'+divId).show();
		$('#corporate-customer-country'+divId).show();
		
	alias=$('#alias'+id).val();
	companyname=$('#dash-user-company-name'+id).val();
	firstname=$('#firstname'+id).val();
	
	address=$('#address'+id).val();
	postcode=$('#dash-user-postcode'+id).val();
	city=$('#dash-user-city'+id).val();
	state=$('#dash-user-state'+id).val();
	country=$('#dash-user-country'+id).val();
	mobile=$('#dash-user-mobile'+id).val();
	
	$('#select-this-address-'+id).hide();
}
function toDelete(id)//to delete the user address
{
var type=8;
var dataparam = '&address_id='+id+'&type='+type;
$.ajax({
			type: 'POST',
			async: true,
			url: 'dash-address.php',
			cache: false,
			//dataType:"json",
			data:dataparam,
			success: function(jsonData)
				{

					
					$('#address-div'+id).remove();
					$("#idGlobalAlert").html("Address deleted successfully");
					$('#globalAlert').modal('show');
					setTimeout(function()
					{
					$('#globalAlert').modal('hide')
					},2000);
				
					/*if(jsonData==0 && rm_portal !=1)
					{
					$('#cop_user').remove();
 					//$("#dash-customer-address").append("<a data-toggle='modal' id='clickaddress' href='#myaddress' onClick='addHiddenValue();' class='btn btn-primary'>Add Address<i class=' fa fa-newaddress'></i></a>")
					$("#dash-customer-address").append("<div class='col-md-4 ' ><a data-toggle='modal' id='clickaddress'  href='#myaddress' onclick='addHiddenValue();'><section class='panel address-div-height'><div class='panel-body' ><div class='top-stats-panel' style='margin-left: 33%; margin-top: 33%;'><form action='' method='post' class='std'><img src='"+baseDir+"dash/images/add_address.png'/><div class='select-add-div col-md-12'><button type='button'  class='select-add-button btn btn-info'>Add Address</button></div></form></div></div></section></a></div>");
					}*/
				}
		});
}
function toCancel(id,divId)
{
	
	
	$('.cop_profile_edit').css("display","block");
				if(firstname=="" ||firstname=="null")
					{
						$("#corporate-customer-name"+divId).hide();
				}
				if(companyname=="" || companyname=="null" )
					{
						$("#corporate-customer-company"+divId).hide();
				}
				if(address=="" || address=="null")
					{
						$("#corporate-customer-address"+divId).hide();
				}
				if(city=="" || city=="null")
					{
						$("#corporate-customer-city"+divId).hide();
				}
				if(state=="" || state=="null")
					{
						$("#corporate-customer-state"+divId).hide();
				}
				if(postcode=="" || postcode=="null")
					{
						$("#corporate-customer-postcode"+divId).hide();
				}
				if(mobile=="" || mobile=="null")
					{
						$("#corporate-customer-mobile"+divId).hide();
				}
				if(country=="" || country=="null")
					{
						$("#corporate-customer-country"+divId).hide();
				}
		$('#alias'+id).val(alias);
		$('#firstname'+id).val(firstname);
		$('#dash-user-company-name'+id).val(companyname);
		$('#address'+id).val( address);
		$('#dash-user-postcode'+id).val(postcode);
		$('#dash-user-city'+id).val(city);
		$('#dash-user-state'+id).val(state);
		$('#dash-user-country'+id).val(country);
		$('#dash-user-mobile'+id).val(mobile);
	$('.cop_profile_value'+id).attr("readonly", true);
	$('.cop_profile_value'+id).removeClass("border");
	$('.cop_profile_value'+id).css({"border-color": "black"});
	$('.cop_profile_value'+id).addClass("cur-poi");
	$('#dash-user-state'+id).addClass("select-box-width");
	$("#dash-user-add-save"+id).hide();
	$('#cancel_profile_edit'+id).hide();
	$('#profile_edit'+id).show();
	
	$('#select-this-address-'+id).show();

}
function toSaveChanges(id)
{
	$('.cop_profile_edit').css("display","block");
	$('.cop_profile_value'+id).addClass("cur-poi");
	$('#dash-user-state'+id).addClass("successSearch");
	$('#dash-user-state-label'+id).removeClass("successSearch");
	var state_name = $("#dash-user-state"+id+" option:selected").text();
	
	$('#dash-user-state-label'+id).html(state_name);
	var alias=$('#alias'+id).val();
	var firstname=$('#firstname'+id).val();
	var companyname=$('#dash-user-company-name'+id).val();	
	var address=$('#address'+id).val();
	var postcode=$('#dash-user-postcode'+id).val();
	var city=$('#dash-user-city'+id).val();
	var state=$('#dash-user-state'+id).val();
	var country=$('#dash-user-country'+id).val();
	var mobile=$('#dash-user-mobile'+id).val();
	var type=3;
var test=1;
	if(alias=="")
	{
		$('#alias'+id).attr("placeholder","Please enter Address Alias");
 			$('#alias'+id).css({"border-color": "red"});
		test=0;
			$('.cop_profile_edit').css("display","none");
 	}
	if(firstname=="")
	{
		$('#firstname'+id).attr("placeholder","Please enter your name");
		$('#firstname'+id).attr("placeholder",'Please enter a valid Name');
			$('#firstname'+id).css({"border-color": "red"});
		test=0;
			$('.cop_profile_edit').css("display","none");
 	}
	else
	{
		$('#firstname'+id).css({"border-color": "black"});
		
	}
 	if(firstname!="")
	{
		if(!firstname.match(/^[a-zA-Z ]*$/))
		{
			$('#firstname'+id).val("");
			$('#firstname'+id).attr("placeholder",'Please enter a valid Name');
			$('#firstname'+id).css({"border-color": "red"});
			 test=0;
			 $('.cop_profile_edit').css("display","none");

 		}
		else
	{
		$('#firstname'+id).css({"border-color": "black"});
		
	}
	}
	if(address=="")
	{
		$('#address'+id).attr("placeholder",'Please enter your address');
			$('#address'+id).css({"border-color": "red"});
		test=0;
		$('.cop_profile_edit').css("display","none");
		

 	}
		else
	{
		$('#address'+id).css({"border-color": "black"});
		
	}
	if(address!="")
	{
		if(!address.match(/^[a-zA-Z0-9-#+.,()&'\/\"\s]+$/))
		{		
		test=0;
		alert('Please avoid special characters and enter a valid address');
		}
	}

	if(postcode=="")
	{
		$('#dash-user-postcode'+id).attr("postcodelaceholder",'Please enter your postcode');
		$('#dash-user-postcode'+id).css({"border-color": "red"});
	
		test=0;
		$('.cop_profile_edit').css("display","none");

 	}
	else
	{
		$('#dash-user-postcode'+id).css({"border-color": "black"});
		
	}
	if(postcode!="")
	{
		if(!postcode.match(/^[0-9]+$/))
		{
			$('#dash-user-postcode'+id).val("");
			$('#dash-user-postcode'+id).attr("placeholder",'Only numbers allowed');
					$('#dash-user-postcode'+id).css({"border-color": "red"});

			test=0;
			$('.cop_profile_edit').css("display","none");

 		}
		else
	{
		$('#dash-user-postcode'+id).css({"border-color": "black"});
		
	}
	}
	if(companyname=="")
	{
		$('#dash-user-company-name'+id).attr("placeholder",'Please enter your Company Name');
				$('#dash-user-company-name'+id).css({"border-color": "red"});

		test=0;
		$('.cop_profile_edit').css("display","none");

 	}
	else
	{
		$('#dash-user-company-name'+id).css({"border-color": "black"});
		
	}
	if(city=="")
	{
		$('#dash-user-city'+id).attr("placeholder",'Please enter your city');
		$('#dash-user-city'+id).css({"border-color": "red"});

		test=0;
		$('.cop_profile_edit').css("display","none");

 	}
	else
	{
		$('#dash-user-city'+id).css({"border-color": "black"});
		
	}
	if(state=="")
	{
		$('#dash-user-state'+id).attr("placeholder",'Please enter your state');
		$('#dash-user-state'+id).css({"border-color": "red"});
	
		test=0;
		$('.cop_profile_edit').css("display","none");

 	}
	else
	{
		$('#dash-user-state'+id).css({"border-color": "black"});
		
	}
	if(country=="")
	{
		$('#dash-user-country'+id).attr("placeholder",'Please enter your country');
		$('#dash-user-country'+id).css({"border-color": "red"});

		test=0;
		$('.cop_profile_edit').css("display","none");

 	}
	
	else
	{
		$('#dash-user-ccountry'+id).css({"border-color": "black"});
		
	}
	if(mobile=="")
	{
		$('#dash-user-mobile'+id).attr("placeholder",'Please enter your Mobile Number');
		$('#dash-user-mobile'+id).css({"border-color": "red"});

		test=0;
		$('.cop_profile_edit').css("display","none");

 	}
	else
	{
		$('#dash-user-mobile'+id).css({"border-color": "black"});
		
	}
	if(mobile!="")
	{
		if(!mobile.match(/^[0-9]+$/))
		{
			$('#dash-user-mobile'+id).val("");
			$('#dash-user-mobile'+id).attr("placeholder",'Only numbers allowed');
			$('#dash-user-mobile'+id).css({"border-color": "red"});
			test=0;
			$('.cop_profile_edit').css("display","none");

 		}
		else
	{
		$('#dash-user-mobile'+id).css({"border-color": "black"});
		
	}
	}
	if(mobile!="")
	{
		if((mobile.length)<10)
		{
			$('#dash-user-mobile'+id).val("");
			$('#dash-user-mobile'+id).attr("placeholder",'Please enter 10 digits');
			$('#dash-user-mobile'+id).css({"border-color": "red"});
			test=0;
			$('.cop_profile_edit').css("display","none");

 		}
		else
	{
		$('#dash-user-mobile'+id).css({"border-color": "black"});
		
	}
	}
	var type=2;
	
	if(test==0)
	{
		
		return false;
	}
else
{
	
		var dataparam= '&firstname='+firstname +'&postcode='+postcode +'&address1='+encodeURIComponent(address) +'&city='+city +'&state='+state +'&mobile='+mobile +'&address_id='+id+'&type='+type+'&company='+companyname+'&alias='+alias;	
 	$.ajax({
			type: 'POST',
			async: true,
			url: 'dash-address.php',
			/*data: {alias:alias,firstname:firstname,postcode:postcode,address1:address,city:city,state:state,mobile:mobile,type:type,address_id:id,company:companyname},*/
			data: dataparam,
			cache: false,
			success: function(data)
			{
				

				if(data="")
				{
						$('.cop_profile_value'+id).css({"border-color": "black"});

					alert("Address Not Updated Successfully!!!")
				}
				else
				{
				
					$('#address-valid-true').modal('show');
						$('#cancel_profile_edit'+id).hide();
						$("#profile_edit"+id).show();
						$("#dash-user-add-save"+id).hide();
						$('.cop_profile_value'+id).attr("readonly", true);
						$('.cop_profile_value'+id).removeClass("border");
							$('.cop_profile_value'+id).css({"border-color": "black"});
							$('#dash-user-state'+id).addClass("select-box-width");
							$('#select-this-address-'+id).show();   

				}
			}
		});

}
}

$(function()
{
	$('#address-valid-true').modal({ show: false});
});

 
$(function(){
	$('#payment_options').slimScroll({
		height: '150px',
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
	});
});

function toRemoveCartProduct(id_product,id_combination,id_customization,id) {
	//$("#"+id).css("display","none");
 		$.ajax({
			type: 'POST',
			url: 'cart.php',
			async: true,
			cache: false,
			dataType : "json",
			data: 'delete=1&id_product=' + id_product + '&ipa=' + ((id_combination != null && parseInt(id_combination)) ? id_combination : '') + ((id_customization && id_customization != null) ? '&id_customization=' + id_customization : '') + '&token=' + static_token + '&ajax=true',
			success: function(jsonData)	{				
				ajaxCart.updateCart(jsonData);
				if(rm_portal !=1)
					toUpdatePrice(id_product);
				else
					toUpdatePriceRM(id_product);
				if ($('body').attr('id') == 'order' || $('body').attr('id') == 'order-opc')
					deletProductFromSummary(idProduct+'_'+idCombination);
					loadShopingCart(true);				
				$('#cart-products-row-id'+id_product).remove();
				var i=1;
				$('.cart-products-row-no').each(function(){
					$(this).html(i);
					i++;
				});

 			},
			error: function() {alert('ERROR: unable to delete the product');}
		});
	}

function forChangeInQuantity(productId,price,minimal_quantity)
{
	var type=8;
	var productarray = new Array();
	var productQty=$("#qty_"+productId).val();
			
	if(productQty<minimal_quantity)
	{
		var alertmsg = "Please enter quantity of "+minimal_quantity+" or above.";
		var minimum_quantity = "(Reason : Minimum quantity limit is "+minimal_quantity+")";
		$("#idGlobalAlert").html("<center>"+alertmsg+"<br>"+minimum_quantity+"</center>");
		$('#globalAlert').modal('show');
		$('#qty_'+productId).val(minimal_quantity);
		productQty=$("#qty_"+productId).val();
		
	}
	productarray.push(productId+"-"+productQty);
	if(productarray=="")
	{	
		$('#noproduct').modal('show');
 		return false;
	}
	var dataparam = '&productarray='+productarray+'&type='+type;
 	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url:'dash-shopping-cart.php',
		data: dataparam,
		cache: false,
		success: function(data)
		{
			if(rm_portal !=1)
				toUpdatePrice(productId);
			else
				toUpdatePriceRM(productId);
		}
	});
 	$("#qty_"+productId).val(productQty);
 	/*if(rm_portal !=1)
	{
   		loadShopingCart(true);
	}*/
	 
}
//Added this function in the dash-index.js
/*function toUpdatePrice(productId)
{
	alert("test");
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
						var alertmsg = "Your cart is empty, Redirecting to home page";
						$("#id_alert").html(alertmsg);
						$('#alert_msg').modal('show');
						setTimeout(function(){
							location.reload();//when the cart is empty the page is redirected to index page
						},500);
						
						//$("#cart-product-price").html("<div class='priceincart'><span class='price-margin-right' ><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'> Rs.0 </span></div><br/><div class='priceincart'><span  class='price-margin-right' ><i class='fa fa-money total-money'></i>Total :</span><div class='price-font'> Rs.0</div></div>");
					}
					else
					{
					for(var i=0;i<jsonData.length;i++)
					{

						if(jsonData[i].id_product==productId)
						{	
							$("#price_"+productId).html("Rs. "+jsonData[i].total);
						}
					}
					var discountids= [];
					if(jsonData[0][5] !="")
					{
						var discountValue =0;
						for (var j=0; j<jsonData[0][5].length; j++)
						{
							
							discountValue += parseFloat(jsonData[0][5][j].value);
							discountids.push(jsonData[0][5][j].id_discount);
							
						}
					}
					else
					{
						var discountValue=0;
					}
					//$("#cart-product-price").html("<div class='pull-left '><span><input type='text' value='' placeholder='Enter Voucher Code' id='name_vouchercode' name='name_vouchercode' /></span><span id='voucher_apply' class='btn btn-info btn-xs' onclick='addDiscount(0,1);'>Apply</span>&nbsp;/&nbsp;<span class='btn btn-info btn-xs'id='voucherCount' onclick=openVoucher();>View Vouchers</span><div class='upload_block_po'><span><input type='file' name='uploadFile' id='uploadFile'><span><input type='text' value='' id='name_upload_po' placeholder='Upload Your PO' name='name_upload_po' />&nbsp;&nbsp;<span><input type='submit' id='po_upload' class='btn btn-info btn-xs' name='send_qutoes_detail' value='Upload'/></span></div> </div><div class='priceincart'><span  class='price-margin-right'><i class=''></i>Discount :</span><span class='price-font'> "+discountValue.toFixed(2)+" </span></div><br/><div class='priceincart'><span  class='price-margin-right'><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'>Rs 0.00</span></div><br/><div class='priceincart'><span  class='price-margin-right'><i class='fa fa-money total-money'></i>Tax :</span><span class='price-font'>Rs. "+jsonData[0][4]+"</span></div><br/><div class='priceincart'><span  class='price-margin-right' ><i class='fa fa-money total-money'></i>Total :</span><div class='price-font'> "+jsonData[0][3]+"</div></div>");
					$('#discount').html(discountValue.toFixed(2));
					loyalty_points = jsonData[0][6];
					$('#shopping-cost').html('Rs 0.00');
					$('#tax').html(jsonData[0][4]);
					$('#loyalty_points_summary').html(jsonData[0][6]);
					$('#loyalty_points').html(jsonData[0][6]);
					$('#total-shopping-cost').html(jsonData[0][3]);
					$(".shopping_Total").html(jsonData[0][3]);
					$("#shopping_loyalty_points_rm").html(jsonData[0][6]);
					$('#uploadFile').hide();
					$("#points_display").append(jsonData[0][6]);
					
 				}
				}
	});


}*/

function paymentMode(paymentmode)
{
	var po_number = $('#name_po').val();
	var po_mandatory = $('#po_mandatory').val();
	var po_file = $('#name_upload_po').val();

	if((po_number == "" || po_file == "") && po_mandatory == 1)
	{
		alert("PO number or file is missing. Please upload to complete purchase.","warning");
		return false;
	}

	var qtyarray = new Array();
	$('input.productquantity').each(function ()
	 {
		 if($(this).val()>0)
		 {
			 qtyarray.push(this.id+"-"+$(this).val());
		 }
	 } );
	if(qtyarray=="" || qtyarray==0  )
	{
		alert("Please purchase more than Rs. 0");
		return false;
	}
  	var type=paymentmode+1;	
	//return false;	
  	$.ajax({
			type: 'POST',
			url: 'dashpaymentoption.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{paymentmode:paymentmode,type:type,id_customer:id_customer, 'po-number': po_number},
			success: function(data)
			{
    			if(data && rm_portal==0)
				{
					if ($('#wizard-p-1').length > 0) 
					{ 
    				// it exists 
 						$( "#index_viewport" ).load( "dash-orderplaced.php", function() {
							$("#thankyou_points").html('you will get<span class="text-danger"> <strong> '+loyalty_points+' </strong></span> loyalty points upon the delivery of the order');
							$("a[href$='#finish']").hide();
							$("a[href$='#next']").click();
							$("a[href$='#finish']").click();
							$("a[href$='#wizard-h-2']").unbind('click');
							$("a[href$='#wizard-h-1']").unbind('click');
							$("a[href$='#wizard-h-0']").unbind('click');
						});
						if(rm_portal!=1)
 							loadShopingCart();

					}
					else
					{
						$('#index_viewport').load('dash-orderplaced.php' );
					
						if(rm_portal!=1)
 							loadShopingCart();
					
					}
				}
				else if(data && rm_portal==1)
				{
					if ($('#wizard-p-1').length > 0) 
					{ 
    				// it exists 
    				$('#main-content').removeClass('panel-open');
 						$( "#index_viewport" ).load( "dash-orderplaced.php", function() {
							$("a[href$='#finish']").hide();
							
							$("#thankyou_points").html('You Got<span class="text-danger"><strong> '+loyalty_points+' </strong></span>points from this order');
							$('.orderConfirmMarginTop').html('<a href="rm-index.php" class="btn btn-primary kob_button">Continue Placing Orders.</a>');
							$("a[href$='#next']").click();
							$("a[href$='#finish']").click();
							$("a[href$='#wizard-h-2']").unbind('click');
							$("a[href$='#wizard-h-1']").unbind('click');
							$("a[href$='#wizard-h-0']").unbind('click');
						});
						if(rm_portal!=1)
 							loadShopingCart();

					}
					else
					{
						$('#main-content').removeClass('panel-open');
						$('#index_viewport').load('dash-orderplaced.php' );
					
						$('.orderConfirmMarginTop').html('<a href="rm-index.php" class="btn btn-primary kob_button">Continue Placing Orders.</a>');
						if(rm_portal!=1)
 							loadShopingCart();
					
					}
				}
				else
				{
					$('#main-content').removeClass('panel-open');
					$('#index_viewport').load('dash/dash-orderalreadyplaced.tpl' );
				
					setTimeout(function() {location.reload(true);}, 1500);
					if(rm_portal!=1)
 							loadShopingCart();
					
				}

				if($('#name_upload_po').val() != '') {
					var file = document.getElementById('uploadFile');
					var formdata = new FormData();     
		            formdata.append("po-file", (file.value != "" ? file.files[0] : ""));
		            formdata.append("id_order_rm", data.id_order);
					$.ajax({
		                url: 'dashpaymentoption.php',
		                type: "POST",
						data: formdata,
						dataType: 'json',
		                processData: false,
		                contentType: false,
		                success:function(){}
		            });
				}
			}
	});
}
//hide right pannel 
$('#wizard-t-2').click(function(){
	$('#main-content').addClass('panel-open');
	if($("#wizard-t-2").parent().hasClass('current'))
	{
		$('.toggle-right-box').hide();
		$('#container').removeClass('open-right-panel');
		$('.header').removeClass('merge-header');
		$('.right-sidebar').removeClass('open-right-bar');
		$("#total_cart_products").hide();
		
		
		loadViewContent();
	}
	});
	//show right pannel
$('#wizard-t-1').click(function(){

	$('#main-content').addClass('panel-open');
	if($("#wizard-t-1").parent().hasClass('current'))
	{	
		//loadShopingCart();
		$('.toggle-right-box').show();
		$('#container').addClass('open-right-panel');
		$('.header').addClass('merge-header');
		$('.right-sidebar').addClass('open-right-bar');
		$("#total_cart_products").show();
		$("#next_buton").hide();
 	}
	});
$('#wizard-t-0').click(function(){
	$('#main-content').addClass('panel-open');
	if($("#wizard-t-0").parent().hasClass('current'))
	{
		//loadShopingCart();
		$('.toggle-right-box').show();
		$('#container').addClass('open-right-panel');
		$('.header').addClass('merge-header');
		$('.right-sidebar').addClass('open-right-bar');
		$("#total_cart_products").show();
		
		
 	}
	});
/*$('#wizard-t-3').click(function(){

	if($("#wizard-t-3").parent().hasClass('current'))
	{
		$('.toggle-right-box').show();
		$('#container').addClass('open-right-panel');
		$('.header').addClass('merge-header');
		$('.right-sidebar').addClass('open-right-bar');
 	}
	});*/
/*Functions for payment . this might use for future*/
/*function cashOnDelivery()
{
	$('#shoppingSummary').html('');
	$('#shoppingSummary').load('dash-cashondelivery.php' );
	setTimeout(function() { $("#codTotal").html("Rs. "+window.paymentdata[0]); }, 500);
}
function Cheque()
{
	$('#shoppingSummary').html('');
	$('#shoppingSummary').load('dash-cheque.php' );
	setTimeout(function() 
	{ 
		$("#codTotal").html("Rs. "+window.paymentdata[0]); 
		$("#chequeName").html(window.paymentdata[1].cheque_name);
		$("#chequeAddress").html(window.paymentdata[1].cheque_address);
	}, 500);
}
function Bankwire()
{
	$('#shoppingSummary').html('');
	$('#shoppingSummary').load('dash-bankwire.php' );
	setTimeout(function() 
	{ 
		if(window.paymentdata[3]==1)
 			var tax = " (Inclusive of all taxes)";
 		else
			var tax = " (Exclusive of all taxes)";
			
		$("#codTotal").html("Rs. "+window.paymentdata[0]+tax); 
		$("#bankwireOwner").html(window.paymentdata[2].bankwire_owner);
		$("#bankwireDetails").html(window.paymentdata[2].bankwire_details);
		$("#bankwireAddress").html(window.paymentdata[2].bankwire_address);
	}, 500);
}*/


$(document).ready(function()
{
	 $(".productquantity").keypress(function (e) {
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	return false;
	}
	 });
	
});


function addHiddenValue()
{
hide_address_value=1;
}
function numbersOnly(e)
{
	var key = e.keyCode;if (!((key == 8) || (key == 46) || (key == 188) || (key == 9) || (key ==109) || (key == 173)  || (key == 107) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}

