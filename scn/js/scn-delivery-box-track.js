$(document).ready(function()
{
	$('#dr-from-date,#dr-to-date').datepicker({
	    prevText:"",
		nextText:"",
		dateFormat:"yy-mm-dd"
	});

	easySearch('box-sent-received');
	getCustomers("customer-select-boxfeature",1);
});

function filterRequests(type)
{
	var from_date = $('#dr-from-date').val();
	var to_date = $('#dr-to-date').val();
	var id_order = $('#id_order_box').val();
	var fc = $('#box-fc').val();
	var company = $('#company').val();

    $('#index_viewport').html('');
    $("#index_viewport").load("track-delivery-box.php?ajax=true&type="+type+"&from_date="+from_date+"&to_date="+to_date+"&id_fc="+fc+"&id_order="+id_order+"&company="+company+"", function(response, status, xhr) {
    	$('#dr-from-date').val(from_date);
		$('#dr-to-date').val(to_date);
		$('#id_order_box').val(id_order);
		$('#box-fc').val(fc);
    });
}

function getCustomerBoxDetails(id_customer)
{
	$('#index_viewport').html('');
    $("#index_viewport").load("track-delivery-box.php?ajax=true&type=2&id_customer="+id_customer+"", function(response, status, xhr) {});
}

function saveBoxNumber(total_box,returned_box,id_customer)
{
	var remaining_box, box_to_return;
	remaining_box = parseInt(total_box) - parseInt(returned_box);
	box_to_return = $('#box-return-count').val();

	if(box_to_return > remaining_box){
		toast('Entered number is more than remaining boxes','error');
	}
	else if(box_to_return == ''){
		toast('Please enter the valid number','error');
	}
	else
	{
		$('#index_viewport').html('');
    	$("#index_viewport").load("track-delivery-box.php?ajax=true&type=3&id_customer="+id_customer+"&box_to_return="+box_to_return+"", function(response, status, xhr) {
    		toast('Data saved successfully.','success');
    	});
	}
}