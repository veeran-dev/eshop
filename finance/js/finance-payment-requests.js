$(document).ready(function() {

	$('#payment-request-from-date,#payment-request-to-date').datepicker({
	        format: 'dd-mm-yyyy'
	});

	easySearch('payment-requests');

	if(window.requestor_name)
	{
		$("#payment-requestor").val(requestor_name);
	}
	if(window.vendor_name)
	{
		$("#payment-vendor").val(vendor_name);
	}
	if(window.fro_date)
	{
		$("#payment-request-from-date").val(fro_date);
	}
	if(window.to_date)
	{
		$("#payment-request-to-date").val(to_date);
	}
	if(window.id_fc)
	{
		$('#payment-fc [value='+id_fc+']').attr('selected',true);
	}
	if(window.request_status)
	{
		$('#payment-status [value='+request_status+']').attr('selected',true);
	}

    $('.check-all').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.check-bank-detail').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.check-bank-detail').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
});

$("#payment-requestor,#payment-city").keypress(function(e) {
    if(e.which == 13) {
    	 e.preventDefault();
        $('#filter-submit').submit();
    }
});

function filterRequests(type){
	var from_date = $('#payment-request-from-date').val();
	var to_date = $('#payment-request-to-date').val();

	var dateFrom = from_date.split('-');
	var req_from_date = dateFrom[2]+'-'+dateFrom[1] + '-' + dateFrom[0].slice(-2);
	var dateTo = to_date.split('-');
	var req_to_date = dateTo[2]+'-'+dateTo[1] + '-' + dateTo[0].slice(-2);

	var req_made_by = $('#payment-requestor').val();
	var req_by_vendor = $('#payment-vendor').val();
	var fc = $('#payment-fc').val();
	var payment_status = $('#payment-status').val();

	var fromDate = new Date(req_from_date);
	var toDate = new Date(req_to_date);
	var todayDate=new Date();
	if(!req_made_by && !req_by_vendor && !from_date && !to_date && !fc && !payment_status)
	{
		toast("Invalid Search","warning");
		return false;
	}
	if((from_date && !to_date) || (!from_date && to_date))
	{
		toast("Invalid Date","warning");
		return false;
	}
	if(from_date && to_date)
	{
		if((fromDate>=todayDate)||(toDate>=todayDate))
		{
			toast("Invalid Date","warning");
			return false;
		}
		else
		{
			window.fro_date=from_date;
			window.to_date=to_date;
		}
	}
	var date="";
	if(from_date && to_date)
		date="&req_from_date="+req_from_date+"&req_to_date="+req_to_date+"";
	window.requestor_name=req_made_by;
	window.vendor_name=req_by_vendor;
	
	window.id_fc=fc;
	window.request_status=payment_status;

    $('#index_viewport').html('');
    $("#index_viewport").load("payment-request.php?ajax=true&type="+type+"&req_made_by="+req_made_by+"&id_fc="+fc+"&status="+payment_status+"&vendorName="+req_by_vendor+""+date+"", function(response, status, xhr) {});
}

function openDetail(id_request)
{
	var type = 7;
	var dataparam= '&type='+type+'&id_request='+id_request;
	$(".ajaxLoaderModal").show();
	 $.ajax({
		type: 'GET',
		async: false,
		dataType:'json',
		url: 'payment-request.php',
		data: dataparam,
		cache: false,
		global: false,
		success: function(data)
		{
			$('.payment-request-data').html("");
			$(".coin_loading").show();
			for(var i = 0; i < data.length; i++)
			{
				if(data[i].account_type == 1)
					data[i].account_type = "Savings A/c";
				else if(data[i].account_type == 2)
					data[i].account_type = "Current A/c";
				else if(data[i].account_type == 3)
					data[i].account_type = "Credit A/c";

				$('.payment-request-data').append('<tr><td><b>Requested By</b></td><td>'+data[i].emp_first_name+'</td></tr>\
												   <tr><td><b>Date</b></td><td>'+data[i].req_date_add+'</td></tr>\
												   <tr><td><b>Order Id(s)</b></td><td>'+data[i].order_numbers+'</td></tr>\
												   <tr><td><b>Amount</b></td><td>'+data[i].request_amount+'</td></tr>\
												   <tr><td><b>City</b></td><td>'+data[i].vendor_city+'</td></tr>\
												   <tr><td><b>FC</b></td><td>'+data[i].fc_city+'</td></tr>\
												   <tr><td><b>Comment</b></td><td>'+data[i].comments+'</td></tr>\
												   <tr><td><b>Vendor Name</b></td><td>'+data[i].vendor_name+'</td></tr>\
												   <tr>\
												   	<td><b>Bank Details</b></td>\
												   	<td>\
												   		<table class="table table-bordered">\
												   			<tbody>\
														   		<tr><td>Bank Name : '+data[i].bank_name+'</td></tr>\
														   		<tr><td>Branch : '+data[i].branch+'</td></tr>\
														   		<tr><td>Account Number : '+data[i].account_no+'</td></tr>\
														   		<tr><td>IFSC Code : '+data[i].ifsc_code+'</td></tr>\
														   		<tr><td>Account Type : '+data[i].account_type+'</td></tr>\
														   	</tbody>\
														<table>\
												   	</td>\
												   </tr>');
			}
			$('#payment-request-pop').modal('show').css({'overflow' : 'hidden'});
		},
		complete:function(){
			$(".coin_loading").hide();
		}
	});
}

function changeStatus(id_request,reject,payment_trigger)
{
	if(payment_trigger == 0)
	{
		$('#id_request').val(id_request);
		$('#payment-bank-pop').modal('show').css({'overflow' : 'hidden'});
	}
	else
	{
		if(id_request != "")
			id_request = id_request;
		else
			id_request = $('#id_request').val();

		var reference = $('#payment-reference').val();
		var corporate_bank = $('#select-corporate-bank').val();

		if(reference == "" && reject == 0)
		{
			toast("Please enter payment reference to proceed","error");
		}
		else if(corporate_bank == "" && reject == 0){
			toast("Please select bank to proceed","error");
		}
		else
		{
			var type = 8;
			var dataparam= '&type='+type+'&id_request='+id_request+'&reference='+reference+'&reject='+reject+'&corporate_bank='+corporate_bank;
			$(".ajaxLoaderModal").show();
	    	 $.ajax({
				type: 'GET',
				async: false,
				dataType:'json',
				url: 'payment-request.php',
				data: dataparam,
				cache: false,
				success: function(data)
				{
					if(data == 1)
					{
						$('#payment-bank-pop').appendTo('body').modal('hide');
						toast("Payment completed successfully","success");
					}
					else if(data == 2)
					{
						toast("Payment Rejected successfully","success");
					}

					openPaymentRequests(6);
				}
			});
			$(".ajaxLoaderModal").hide();
		}
	}
}