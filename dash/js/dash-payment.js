
$(function()
{
 	window.paymentdata="";
	
  $('#cart-products').slimScroll({
		height: '410px',
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
				
				for(var i=0;i<jsonData.length;i++)
				{
					if(jsonData[i].id_payment==1)
					{
						
						/*$("#payment_options").append("<div  class='col-md-12 payment-option-margin' onclick='cashOnDelivery();'><a  class='btn check btn-primary kob_button payment-option-width'>CASH ON DELIVERY</a></div>");*/
						$("#payment_options").append("<div  class='payment-option-margin' onclick='paymentMode(1);'><a  class='btn check btn-primary kob_button payment-option-width'>COD</a></div>");
					}
					if(jsonData[i].id_payment==2)
					{	
						
						/*$("#payment_options").append("<div  class='col-md-12 payment-option-margin' onclick='Cheque(2);'><a  class='btn btn-primary kob_button payment-option-width'>CHEQUE</a></div>");*/
						$("#payment_options").append("<div  class='payment-option-margin' onclick='paymentMode(2);'><a  class='btn btn-primary kob_button payment-option-width'>CHEQUE</a></div>");
					
					}
						
					if(jsonData[i].id_payment==3)
					{	/*$("#payment_options").append("<div  class='col-md-12 payment-option-margin' onclick='Bankwire(3);'><a  class='btn btn-primary kob_button payment-option-width'>NEFT/RTGS</a></div>");*/
						$("#payment_options").append("<div  class='payment-option-margin' onclick='paymentMode(3);'><a  class='btn btn-primary kob_button payment-option-width'>ONLINE</a></div>");
					}	
					if(jsonData[i].id_payment==4)
					{
							$("#payment_options").append("<div  class='payment-option-margin' onclick='EBS();'><a  class='btn btn-primary kob_button payment-option-width'>EBS</a></div>");
					}	
				
				}
				 	    
			}	
			});						
			$.ajax({
			type: 'POST',
			url: 'dash-getcartproduct.php',
			async: true,
			cache: false,
			dataType : "json",
			//data:{id_customer:id_customer},
			success: function(jsonData)
			{
		for(var i=0;i<jsonData.length;i++)
				{
				$("<tr id='"+jsonData[i].id_product+"' class='odd'><td class='col-md-2' ><img src='"+jsonData[i][0]+"'></td><td class='col-md-5 cart-product-name'>"+jsonData[i].name+"</td><td class='col-md-2 tex-ali-cen' ><input id='qty_"+jsonData[i].id_product+"' onchange='forChangeInQuantity("+jsonData[i].id_product+","+jsonData[i].price.toFixed(2)+");' class='productquantity tex-ali-cen' size='4' type='text' max-length='4'  value='"+jsonData[i].quantity+"'  /></td><td id='price_"+jsonData[i].id_product+"'class='col-md-3' >Rs. "+jsonData[i].total+"</td><td class='sorting_1 '><a onClick='toRemoveCartProduct("+jsonData[i].id_product+","+null+","+jsonData[i].id_customization+","+jsonData[i].id_product+");' class='fa fa-trash-o delete-option' ></a></td></tr>").prependTo('table > tbody');
			}
			window.payment = jsonData[0][3];
			$("#cart-product-price").html("<div class='priceincart'><span id='cart-shipping-cost'><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'> "+jsonData[0][2]+" </span></div><br/><div class='priceincart'><span ><i class='fa fa-money total-money'></i>Tax :</span><span class='price-font'> "+jsonData[0][4]+"</span></div><br/><div class='priceincart'><span><i class='fa fa-money total-money'></i>Total :</span><span class='price-font'> "+jsonData[0][3]+" </span></div>");
			}
				
			});
			$('#confirmed-address').append("<div class='col-md-12 font-size'><div id='corporate-customer-name' class='col-md-12 address-field-margin'>"+firstname+"</div><div id='corporate-customer-company' class='col-md-12 address-field-margin'>"+companyname+"</div><div id='corporate-customer-address' class='col-md-12 address-field-margin'>"+address+"</div><div id='corporate-customer-postcode' class='col-md-12 address-field-margin'>"+postcode+"</div><div id='corporate-customer-city' class='col-md-12 address-field-margin'>"+city+"</div><div id='corporate-customer-state' class='col-md-12 address-field-margin' >"+state+"</div><div id='corporate-customer-country' class='col-md-12 address-field-margin' >"+country+"</div><div id='corporate-customer-mobile'  class='col-md-12 address-field-margin'>"+mobile+"</div></div>");
			
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
			
});
	/*********************************Srini part******************************************************/
			$.ajax({
			type: 'POST',
			url: 'dashpaymentoption.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{type:6},
			success: function(payment)
			{
 				window.paymentdata=payment;
 			}
	});
function toRemoveCartProduct(id_product,id_combination,id_customization,id)
{
	//$("#"+id).css("display","none");
	$("#"+id).remove();
 		$.ajax({
			type: 'POST',
			url: 'cart.php',
			async: true,
			cache: false,
			dataType : "json",
			data: 'delete=1&id_product=' + id_product + '&ipa=' + ((id_combination != null && parseInt(id_combination)) ? id_combination : '') + ((id_customization && id_customization != null) ? '&id_customization=' + id_customization : '') + '&token=' + static_token + '&ajax=true',
			success: function(jsonData)	{
				ajaxCart.updateCart(jsonData);
				toUpdatePrice(id_product);
				if ($('body').attr('id') == 'order' || $('body').attr('id') == 'order-opc')
					deletProductFromSummary(idProduct+'_'+idCombination);
			},
			error: function() {alert('ERROR: unable to delete the product');}
		});
	}

function forChangeInQuantity(productId,price)
{
		var type=8;

		var productarray = new Array();
			var productQty=$("#qty_"+productId).val();
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
				
 				toUpdatePrice(productId);
			}
	});
	$("#qty_"+productId).val(productQty);	
}
function toUpdatePrice(productId)
{
	alert("Point 1: "+productId);
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
						alert("Point 2: "+productId);
						$("#cart-product-price").html("<div class='priceincart'><span id='cart-shipping-cost' ><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'> Rs.0 </span></div><br/><div class='priceincart'><span ><i class='fa fa-money total-money'></i>Total :</span><span class='price-font'> Rs.0</span></div>");
					}
					else
					{
						alert("Point 3: "+productId);
					for(var i=0;i<jsonData.length;i++)
					{
						if(jsonData[i].id_product==productId)
						{	
							$("#price_"+productId).html("Rs. "+jsonData[i].total);
						}
					}
					$("#cart-product-price").html("<div class='priceincart'><span id='cart-shipping-cost' ><i class='fa fa-truck shipping-truck'></i>Shipping Cost :</span><span class='price-font'> "+jsonData[0][2]+" </span></div><br/><div class='priceincart'><span ><i class='fa fa-money total-money'></i>Tax :</span><span class='price-font'> "+jsonData[0][4]+"</span></div><br/><div class='priceincart'><span ><i class='fa fa-money total-money'></i>Total :</span><span class='price-font'> "+jsonData[0][3]+"</span></div>");
					//paymentMode(0,jsonData[0][3]);
 				}
				}
	});


}


function paymentMode(paymentmode)
{
	
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
  	$.ajax({
			type: 'POST',
			url: 'dashpaymentoption.php',
			async: true,
			cache: false,
			/*dataType : "json",*/
			data:{paymentmode:paymentmode,type:type},
			
			success: function(data)
			{
  				if(data==1)
				{
					$('#shoppingSummary').load('dash/dash-orderplaced.tpl' );
				}
				else
				{
					$('#shoppingSummary').load('dash/dash-orderalreadyplaced.tpl' );
					setTimeout(function() {location.reload(true);}, 1500);
				}
				
				
			}/*,
			complete: function(){
 				$("#loading_img").hide();
 			}*/
	});
}
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
function EBS()
{
	//$('#shoppingSummary').html('');
	$('#hidden-info').load('dash-EBS.php' );
	//return false;
	/*setTimeout(function() 
	{ 
		$("#codTotal").html("Rs. "+window.paymentdata[0]); 
		$("#bankwireOwner").html(window.paymentdata[2].bankwire_owner);
		$("#bankwireDetails").html(window.paymentdata[2].bankwire_details);
		$("#bankwireAddress").html(window.paymentdata[2].bankwire_address);
	}, 1000);*/
}