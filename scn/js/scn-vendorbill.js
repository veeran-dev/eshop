// JavaScript Document
$(function()
{
	$('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });
});
$(document).ready(function() 
{		
	/*Vendor name auto complete*/
	var auto=2;
	$("#vendor_name").autocomplete("scn-vendor-search.php?auto="+auto+"&type="+2,
	{
		minChars:3,
		max: 10,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			$(".pro").removeClass('productSearch');
 			/*$(".pro").addClass('vendorSearch');*/
			return value;
	},
	parse: function(data){
		if(data=="")
		{
			//$("#vendor-processing").hide();	
			$('.purchaseBill').hide();
			// $(".vendorNotFound").show();
			$("#quickbuy-vendor-not-found").show();	
			return data;
		}
		else{
			$("#quickbuy-vendor-not-found").hide();
 			var mytab = new Array();
			for(var i = 0; i < data.length; i++)
				mytab[mytab.length] = { data:data[i], value:"<div class='ul-font-size col-xs-6 col-md-10' id='vendor_search_details'>"+data[i].name+"</div>"};
			return mytab;
		}
	}
	}).result(
	function(event, data ) 
	{
		
		$('#vendor_name').val(data.name);
		$('#vendor_id').val(data.id_vendor);
		changefocus(1);
	}
	);
	
	/*Product auto complet*/
	autoCompSearch("#vendor_bill_product","purchase_bill");
	
	$(".billProductPart").attr('disabled',true);
	  
 });

 $(document).ready(function(){
 	var type = 29;
	var dataparam = 'type='+type+'';
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'scn-quotation-ajax.php',
		cache: true,
		data: dataparam,
		success: function(result)
		{ 
			var result = result.reverse();
			$('.tax_rules_group').html('');
			for(var i = 0; i< result.length; i++){
				$('.tax_rules_group').append('<option value='+result[i].id_tax_rules_group+'>'+result[i].name+'</option>');
			}
		}
	});
 });
 
 function saveBill()
 {
	 var bill_no =$("#billno").val();
	 var bill_date =$("#bill_date").val();
	 var id_vendor =$("#vendor_id").val();
	 var payment_type =$("#vendor_bill_payment_mode").val();
	 var status=0;
	 if(bill_no=="")
	 {
		 alert("Please Enter a Bill No.");
		 status=1;
		 return false;
 	 }
	 if(bill_date=="")
	 {
		 alert("Please Enter a Bill Date.");
		 status=1;
		 return false;
 	 }
	 if(id_vendor=="")
	 {
		 alert("Please Select the Vendor.");
		 status=1;
		 return false;
 	 }
	  if(payment_type == 0 )
	 {
		 alert("Please Select the payment mode.");
		 status=1;
		 return false;
 	 }
	 if(status==1)
	 {
		 return false;
	 }
	 else
	 {
		$(".billPart").attr('disabled',true);
		$(".billProductPart").attr('disabled',false);
		$("#billdetails").addClass('disabled');
		$("#save_purchase_bill_details").removeClass('disabled');
	 }
 }
function clearfields(data)
 {
   	 if(data==1)
	 {
		$('#vendor_bill_product').val('');
		$("#id_product").val('');
		$("#vendor_bill_product_qty").val('');
		$("#vendor_bill_product_unit_price").val('');
		$("#vendor_bill_product_tax").val(0);
	 }
	 else
	 {
		 $("#billdetails").removeClass('disabled');
		 $(".billPart").attr('disabled',false);
		 $(".billProductPart").attr('disabled',true);
		 $("#save_purchase_bill_details").addClass('disabled');
		 $("#billno").val('');
		 $("#bill_date").val('');
		 $("#vendor_id").val('');
		 $('#vendor_name').val('');
		 $("#vendor_bill_payment_mode").val(0);
		 
	 }
 }
 function savePurcahseBillDetails()
 {
	 
	 var bill_no =$("#billno").val();
	 var bill_date =$("#bill_date").val();
	 var id_vendor =$("#vendor_id").val();
	 var id_product =$("#id_product").val();
	 var payment_type =$("#vendor_bill_payment_mode").val();
	 var product_qty =$("#vendor_bill_product_qty").val();
	 var unit_price =$("#vendor_bill_product_unit_price").val();
	 var tax =$(".tax_rules_group").val();
	 var type=1;
	 var status=0;
	 
	 if(id_product=="")
	 {
		 alert("Please Select the Product.");
		 status=1;
		 return false;
 	 }
	 if(product_qty=="")
	 {
		 alert("Please Enter the Product Quantity.");
		 status=1;
		 return false;
 	 }
	 if(unit_price=="")
	 {
		 alert("Please Enter the Product price.");
		 status=1;
		 return false;
 	 }
	 if(tax==0)
	 {
		 alert("Please Select the product tax.");
		 status=1;
		 return false;
		 
	 }
	 if(status==1)
	 {
		 return false;
	 }
	 else
	 {
	 
		 var dataparam = '&bill_no=' + bill_no+'&bill_date=' + bill_date+'&id_vendor=' + id_vendor+'&id_product=' + id_product+'&product_qty=' + product_qty+'&unit_price=' + unit_price+'&tax='+ tax+'&type='+ type+'&payment_type='+ payment_type;
		 $.ajax({
			type: 'POST',
			async: true,
			url: 'scn-purchasebilldata.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
 				if(data==1)
				{
					$("#success_add").show();
					setTimeout(function(){
					  $("#success_add").hide();
					}, 3000);
					$("#vendor_bill_product").focus();
					clearfields(1);
				}
			}
		});
	 }
 }
 function changefocus(tab)
 {
	 if(tab==1)
	 {
	 	$("#billno").focus();
	 	$("#billno").select();
	 }
	 else
	 {
		 $("#vendor_bill_product_qty").focus();
		 $("#vendor_bill_product_qty").select();
	 }
 }
function loadingprocess(id)
{
  	if(id==1)
	{
		if($("#vendor_name").val().length > 2)
		{
			$('.purchase').removeClass('vendorSearch');
  		}
	}
	if(id==2)
	{
		$('.purchase').addClass('vendorSearch');
		if($("#vendor_bill_product").val().length > 2)
		{
			
 			$('.bill').removeClass('vendorSearch');
		}
	}
}	

$("#vendor_bill_product_qty").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	return false;
	}
});
$("#vendor_bill_product_unit_price").keypress(function (e) {
		if ((e.which < 48 || e.which > 57)&&(e.which != 46)&&(e.which !=8 && e.which !=0)) {
	return false;
	}
});

