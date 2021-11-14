function openPendingPayment()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('finance-pending-payment.php' );
}

function openAgingSheet()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('finance-aging-sheet.php' );	
}


function releaseOrders()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('finance-release-orders.php' );	
}

$(document).on('click', '#resetFppButton', function() {
	window.cop_to="";
	window.cop_from="";
	window.cop_company="";
	window.group_name_selected="";
	window.group_id_Selected="";
	$("#fpp_from").val("");
    $("#fpp_to").val("");
    $('#group_selection [value=0]').attr('selected',true);
	 openPendingPayment();
});

function sendCreditAlert()
{
	var order_id=$("#hiddenOrderId").val();	
	$('#orderCredit').modal('hide');
	var dataparam="&order_id="+order_id+"&type=2";
	$(".ajaxLoaderModal").show();
	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'rm-credit.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{					
					//openOrders(0);
					openPendingPayment();				
				}
			});
	$(".ajaxLoaderModal").hide();
}

function changeCreditDays()
{
	var days=$("#creditDaysNumber").val();
	var order_id=$("#hiddenOrderId").val();	
	var dataparam="&days="+days+"&order_id="+order_id+"&type=1";
	$('#orderCredit').modal('hide');
	$(".ajaxLoaderModal").show();
	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'rm-credit.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{
					//openPendingPayment();
					$('#orderCredit').modal('hide');
					$("#searchFppButton").click();
					//openOrders(0);			
				}
			});
	$(".ajaxLoaderModal").hide();
}

	$(document).on('click', '#searchFppButton', function() {
		var type=1;
		var from_date=$("#fpp_from").val();
		var to_date=$("#fpp_to").val();
		if(from_date>to_date){
			toast("kindly check date","warning");
			return;
		}

		var id_group=$("#group_selection option:selected").val();
		var dataparam = '&type='+type+'&id_group='+id_group+'&from='+from_date+'&to='+to_date;		
		var group_name=$("#group_selection option:selected").text();
		
		if(group_name){
			window.group_name_selected=group_name;
			window.group_id_Selected=id_group;
		}
		if(from_date && to_date)
		{
			window.cop_to=to_date;
			window.cop_from=from_date;
		}
		$('#index_viewport').load('finance-pending-payment.php?id_group='+id_group+'&from='+from_date+'&to='+to_date);
		/*$.ajax
		({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'finance-pending-payment-data.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
				
				$("#finance_pending_payment_list").removeClass("successSearch");
				$("#generateExcel").removeClass("successSearch");
				var td='';
				for(var i=0;i<data.length;i++)
				{
					td +="<tr>";
					td +="<td>"+(i+1)+"</td>"
					td +="<td>"+data[i].name+"</td>"
					td +="<td>"+data[i].id_order+"</td>"
					td +="<td>"+data[i].date_add+"</td>"
					td +="<td>"+data[i].invoice_number+"</td>"
					td +="<td>"+data[i].invoice_date+"</td>"
					td +="<td>"+data[i].total_paid+"</td>"
					td +="<td>"+data[i].bill_age+"</td>"
					td +="<td>"+data[i].credit_days+"</td>"
					td +="</tr>";
				}
				$("#finance_pending_payment").html(td);
				
			}
		});*/
	});

function moneyFormat(price_value)
{
 	
	//var formatMoney = lib.formatMoney = function(number, symbol, precision, thousand, decimal, format)
	if(currency_format_value == 1)
		return accounting.formatMoney(price_value,"Rs. ","2",",",".","%s%v");
	else if(currency_format_value == 2)
		return accounting.formatMoney(price_value,"Rs. ","2"," ",",","%v%s");	
	else if(currency_format_value == 3)
		return accounting.formatMoney(price_value,"Rs. ","2",".",",","%s%v");
	else if(currency_format_value == 4)
		return accounting.formatMoney(price_value,"Rs. ","2",",",".","%v%s");
}

$(document).on('click', '#generateExcel', function() {
	$('#form_fpp_excel').submit();
});

function paymentReceived(id_order,element)
{

	$("#order_id_confirm").html(id_order);
	//var answer = confirm("Do you want to change the status for order #"+id_order+"?");
	$('#confirm').modal("show");

    $("#delete").off().on('click',function(){
    	var dataparam='&id_order='+id_order+'&type=2';
    	$(".ajaxLoaderModal").show();
		$.ajax({
			type: 'GET',
			dataType:'json',
			async: true,
			url: 'finance-pending-payment-data.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
				if(data==1)
				{
					$(element).parents('tr').remove();				
					toast("Payment received status changed successfully");
					$("#searchFppButton").click();
				}
				else
				{
					toast("Error in payment request process","warning");	
				}
			}
		});
		$(".ajaxLoaderModal").hide();
    });

}