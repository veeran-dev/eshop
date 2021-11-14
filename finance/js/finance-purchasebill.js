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
	var auto = 2;

	$("#vendor_name").autocomplete("scn-vendor-search.php?auto="+auto+"&type="+2, {
		minChars:3,
		max: 20,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			$(".pro").removeClass('productSearch');
			return value;
		},
		parse: function(data){
			if(data == "")
			{
				$('.purchaseBill').hide();
				$("#quickbuy-vendor-not-found").show();	
				return data;
			}
			else {
				$("#quickbuy-vendor-not-found").hide();
	 			var mytab = new Array();
				for(var i = 0; i < data.length; i++)
					mytab[mytab.length] = { data:data[i], value:"<div class='ul-font-size col-xs-6 col-md-10' id='vendor_search_details'>"+data[i].name+"</div>"};
				return mytab;
			}
		}
	}).result(function(event, data ) {
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
	$(".ajaxLoaderModal").show();
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
			$('.tax_rules_group').append('<option>Select tax</option>');
			for(var i = 0; i< result.length; i++){
				$('.tax_rules_group').append('<option value='+result[i].id_tax+'>'+result[i].rate+'</option>');
			}
		}
	});
	$(".ajaxLoaderModal").hide();
 });
 
 function savePurchaseBill()
 {
	 var bill_no = $("#billno").val();
	 var bill_date = $("#bill_date").val();
	 var id_vendor = $("#vendor_id").val();
	 var payment_type = $("#vendor_bill_payment_mode").val();

	 if(bill_no == "")
	 {
		 toast("Please Enter a Bill No.", "error");
 	 }
	 else if(bill_date == "")
	 {
		 toast("Please Enter a Bill Date.", "error");
 	 }
	 else if(id_vendor == "")
	 {
		 toast("Please Select the Vendor.", "error");
 	 }
	 else if(payment_type == 0 )
	 {
		 toast("Please Select the payment mode.", "error");
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
	 var bill_no = $("#billno").val();
	 var bill_date = $("#bill_date").val();
	 var id_vendor = $("#vendor_id").val();
	 var id_product = $("#id_product").val();
	 var payment_type = $("#vendor_bill_payment_mode").val();
	 var product_qty = $("#vendor_bill_product_qty").val();
	 var unit_price = $("#vendor_bill_product_unit_price").val();
	 var tax = $(".tax_rules_group option:selected").html();
	 var type = 1;
	 var status = 0;

	 if(id_product == "")
	 {
		toast("Please Select the Product.", 'error');
 	 }
	 else if(product_qty == "")
	 {
		toast("Please Enter the Product Quantity.", 'error');
 	 }
	 else if(unit_price == "")
	 {
		toast("Please Enter the Product price.", 'error');
 	 }
	 else if(tax == "Select tax")
	 {
		toast("Please Select the product tax.", 'error');
	 }
	 else
	 {
		 $.ajax({
			type: 'POST',
			async: true,
			url: 'finance-purchasebilldata.php',
			data: {
				bill_no,
				bill_date,
				id_vendor,
				id_product,
				product_qty,
				unit_price,
				tax,
				type,
				payment_type
			},
			cache: false,
			beforeSend: function() {
				$(".ajaxLoaderModal").show();
			},
			success: function(data)
			{
 				if(data == 1) {
					$("#success_add").show();
					setTimeout(function(){
					  $("#success_add").hide();
					}, 3000);
					$("#vendor_bill_product").focus();
					clearfields(1);
				}
				else {
					toast("Can't add purchase bill. Please try again.", "error");
				}
			},
			error: function() {
				toast("Can't add purchase bill. Please try again.", "error");
			},
			complete: function() {
				$(".ajaxLoaderModal").hide();
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

var loadtablevalue = 0;
window.incl_tax_total=0;
window.excl_tax_total=0;
 $(function()
{
	$('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });
});

$(document).ready(function () {
	$('#searchPurchaseBill').click(function() {
		var type = 1;
		var from = $("#fpp_from").val();
		var to = $("#fpp_to").val();
		var id_vendor = $("#vendor_id").val();
		var vendor_name = $("#vendor_name").val();
		var dataparam = '?type=' + type +'&id_vendor='+id_vendor+'&from='+from+'&to='+to;

		if(from > to) {
			alert("Please enter valid date");
			return;
		}

		window.vpb_fpp_to=to;
		window.vpb_fpp_from=from;
		window.vpb_vendor_name=vendor_name;
		window.vpb_vendor_id=id_vendor;

		$('#index_viewport').html('');
	    $('#index_viewport').load('finance-viewpurchasebilldata.php'+dataparam);
	});
});

function resetPurchaseBill()
{
	$("#vendor_name").val('');
	$("#vendor_id").val('');
	$("#fpp_from").val('');
	$("#fpp_to").val('');
}

function openBillDetails(id_vendor,billno)
{
	$("#head_bill_no").html(billno);
	var type=2;
	$("#bill_details").html('');
	var dataparam = '&type=' + type+'&billno=' + billno+'&id_vendor=' + id_vendor;
	$(".ajaxLoaderModal").show();
		$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'finance-viewpurchasebilldata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
				var total_excl = 0;
			var total_incl = 0;

				for(var i = 0; i < data.length; i++)
			{
				var sno = i+1;

				var total_excl_price = data[i].product_qty * data[i].unit_price;
				var total_incl_tax_value = data[i].product_qty * data[i].unit_price * data[i].tax / 100;
				
				total_excl += total_excl_price;
				total_incl += total_excl_price + total_incl_tax_value;
				
					$("#bill_details").append("<tr id='bill_product_"+data[i].id_vendor_purchase+"'>\
												<td>"+sno+"</td>\
												<td><input  type='text' id='bill_no_"+sno+"' size='10' class='noBorder' value="+billno+" readonly></td>\
												<td><input size='12' placeholder='dd-mm-yyyy'  type='text' id='bill_date_"+sno+"' class='noBorder numbersOnly' value="+data[i].bill_date+" readonly></td>\
												<td>"+data[i].name+"</td>\
												<td><input size='5' onkeydown='numbersOnly(event);' type='text' id='qty_"+sno+"' class='noBorder numbersOnly' value="+parseInt(data[i].product_qty)+" readonly></td>\
												<td><input size='10' type='text' id='unit_price_"+sno+"' onkeydown='numbersOnly(event);' class='noBorder numbersOnly' value="+parseFloat(data[i].unit_price).toFixed(2)+" readonly></td>\
												<td>Rs. "+total_excl_price+"</td>\
												<td><span id='tax_rules_group_view"+sno+"'>"+data[i].tax+"</span><select id='tax_rules_group_edit"+sno+"' style='display:none;'></select></td>\
												<td>\
													<span id='"+billno+"' class='fa fa-trash-o cur-poi "+sno+"_delete' onclick='deleteBill("+data[i].id_vendor+","+data[i].id_vendor_purchase+","+data[i].product_qty+","+data[i].unit_price+",0,"+i+",this);'></span>\
													<span id="+billno+" class='fa fa-save cur-poi "+sno+"_save' style='display:none' onclick='saveBill("+data[i].id_vendor+","+data[i].id_vendor_purchase+","+sno+",this);''></span>\
													<span id="+billno+" class='fa fa-reply cur-poi "+sno+"_cancel' style='display:none' onclick='closepurchaseBill();'></span>\
													<span class='fa fa-edit cur-poi "+sno+"_edit' onclick='editViewBill("+sno+",2);'></span>\
												</td>\
											</tr>");
				}

			excl_tax_total = total_excl;
			incl_tax_total = total_incl;
			$("#total_exc").html("Rs. "+parseFloat(total_excl).toFixed(2));
			$('#purchase_bill_details').modal('show');
		}
	});
	$(".ajaxLoaderModal").hide();
}

function closepurchaseBill()
{
	$('#purchase_bill_details').modal('hide');
}

function editViewBill(sno,id,id_vendor,properties)
{
	if(id == 2)
	{
		var type = 29;
		var dataparam = 'type='+type+'';
		$(".ajaxLoaderModal").show();
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
				$('#tax_rules_group_edit'+sno).html('');
				for(var i = 0; i< result.length; i++)
				{
					$('#tax_rules_group_edit'+sno).append('<option value='+result[i].id_tax+'>'+result[i].rate+'</option>');
				}
			}
		});
		$(".ajaxLoaderModal").hide();

		$('.'+sno+'_save').show();
		$('.'+sno+'_cancel').show();
		$('.'+sno+'_delete').hide();
		$('.'+sno+'_edit').hide();
		$("#tax_rules_group_view"+sno+"").hide();
		$('#tax_rules_group_edit'+sno).show();
		$('#qty_'+sno).removeClass("noBorder");
		$('#qty_'+sno).attr('readonly',false);
		$('#unit_price_'+sno).removeClass("noBorder");
		$('#unit_price_'+sno).attr('readonly',false);
		$('#tax_'+sno).removeClass("noBorder");
		$('#tax_'+sno).attr('readonly',false);
		
		$('#bill_no_'+sno).removeClass("noBorder");
		$('#bill_date_'+sno).removeClass("noBorder");
		$('#bill_date_'+sno).attr('readonly',false);
		$('#bill_no_'+sno).attr('readonly',false);

	}
	else if(id==1)
	{
		openBillDetails(id_vendor,properties);
	}

}

function deleteBill(id_vendor, id_vendor_purchase, product_qty, unit_price, taxvalue, i, properties)
{
	taxvalue = $('#tax_rules_group_edit'+i+' option:selected').val();
	var row = $('#delete_row_'+i).val();
	var billno = properties.id;
 	var type = 3;

	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'finance-viewpurchasebilldata.php',
		data: {
			type,
			billno,
			id_vendor,
			id_vendor_purchase
		},
		cache: false,
		beforeSend: function() {
			$(".ajaxLoaderModal").show();
		},
		success: function(data)
		{
			if(data == 1) {
				if(id_vendor_purchase != 0)
					toast("Product deleted successfully.", "success");
				else
					toast("Purchase bill deleted successfully.", "success");
			}

			if(id_vendor_purchase == "0")
			{
				$('#purchase_bill_'+billno+'').remove();
				var i = 1;

				$('.purchase-bill-row-no').each(function(){
					$(this).html(i);
					i++;
				});
			}				
 			else
			{
 				var temp_total_excl = product_qty * unit_price;
				var total_excl = excl_tax_total - temp_total_excl;
  				var temp_total_incl_tax = product_qty * unit_price * taxvalue / 100;
  				var temp_total_incl = temp_total_excl + temp_total_incl_tax;
 				var total_incl = incl_tax_total - temp_total_incl;
 				$("#total_exc").html("Rs. " + total_excl);
 				$(".totalPayment_" + billno).html(parseFloat(total_excl));
 				$("#total_inc").html("Rs. " + total_incl);
				$('#bill_product_' + id_vendor_purchase).remove();
				incl_tax_total = total_incl;
				excl_tax_total = total_excl;
			}

			if(taxvalue == 0)
			{
				var i = 0;
				$('.purcahseBillListTd input').each(function(){
					$(this).val(i);
					i++;
				});
				$("#purchasebils").dataTable().fnDeleteRow( row );
			}
 		},
 		error: function() {
 			toast('Error while deleting purchase bill. Please try again.', 'error');
 		},
 		complete: function() {
			$(".ajaxLoaderModal").hide();
 		}
	});
}

function saveBill(id_vendor, id_vendor_purchase, sno, properties)
{
	product_qty = $('#qty_'+sno).val();
	billno = $('#bill_no_'+sno).val();
	billdate = $('#bill_date_'+sno).val();
	unit_price = $('#unit_price_'+sno).val();
	var tax = $('#tax_rules_group_edit'+sno+' option:selected').html();

	if(product_qty == "")
	{
		$('#qty_'+sno).css({"border":"2px solid #cc0000"});
	}
	else if(unit_price == "")
	{
		$('#unit_price_'+sno).css({"border":"2px solid #cc0000"});
	}
	else 
	{
		var type = 7;

		$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'finance-viewpurchasebilldata.php',
			data: {
				type,
				id_vendor_purchase,
				product_qty,
				unit_price,
				tax,
				billno,
				billdate
			},
			cache: true,
			beforeSend: function() {
				$(".ajaxLoaderModal").show();
			},
			success: function(data)
			{
				if(data == 1) {
					toast("Bill updated successfully", "success");
				}
				openBillDetails(id_vendor,billno);
	 		},
	 		error: function() {
	 			$(".ajaxLoaderModal").hide();
	 			toast("Error occurred while saving bill. Please try again.", "error");
	 		},
	 		complete: function() {
	 			$(".ajaxLoaderModal").hide();
	 		}
		});
	}
}
 
var EditableTable = function () {
    return {
        //main function to initiate the module
        init: function () {
			
			var oTable = $('#purchasebils').dataTable({
                "aLengthMenu": [
                    /*[25, 50, 100, -1],
                    [25, 50, 100, "All"]*/ // change per page values here
					[10, 50, 100, -1],
                    [10, 50, 100, "All"]
                ],
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
                        'aTargets': [0]
                    }
                ]
            });
			 }

    }; 
}();

function numbersOnly(e)
{
	var key = e.keyCode;if (!((key == 8) || (key == 46) || (key == 188) || (key == 9) || (key ==109) || (key == 173)  || (key == 107) || (key == 190) || (key == 110) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}

function editDateBill(billno)
{
 	$("#bill_no_"+billno ).removeClass('noBorder');
 	$("#bill_no_"+billno ).attr('readonly',false);
	$("#bill_date_"+billno ).removeClass('noBorder disabled');
	$("#bill_date_"+billno ).attr('readonly',false);
	$("#bill_date_"+billno ).addClass('picker');
	$('.picker').datepicker({
        format: 'dd-mm-yyyy'
    });
	$('.savePart_'+billno).show();
	$('.editPart_'+billno).hide();	
}

function cancelBillDetails(billno)
{
	$("#bill_no_"+billno ).addClass('noBorder');
	$("#bill_no_"+billno ).attr('readonly',true);
	$("#bill_date_"+billno ).addClass('noBorder disabled');
	$("#bill_date_"+billno ).attr('readonly',true);
	$("#bill_date_"+billno ).removeClass('picker');
	$('.savePart_'+billno).hide();
	$('.editPart_'+billno).show();
}

function updateBillDetails(old_billno)
{	
	var billno = $("#bill_no_"+old_billno ).val();
	var billdate = $("#bill_date_"+old_billno ).val();
	var type = 8;

 	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'finance-viewpurchasebilldata.php',
		data: {
			type,
			billdate,
			billno,
			old_billno
		},
		cache: false,
		beforeSend: function() {
			$(".ajaxLoaderModal").show();
		},
		success: function(data)
		{
			if(data == 1) {
				toast("Bill updated successfully", "success");
			}

 			$("#searchPurchaseBill").click();	
  		},
  		complete: function() {
  			$(".ajaxLoaderModal").hide();
  		}
	});
}