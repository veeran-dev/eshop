 $(function() {
	$('#order-date-from,#order-date-to').datepicker({
		prevText:"",
		nextText:"",
		dateFormat:"yy-mm-dd"
	});
 	if(emp_profile !=5)
	{
		$('#estimated_delivery_time').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss',
			locale: 'en',
			keepOpen: true
		});
	}

	var msg_body = $('.message-body-order');
    msg_body.animate({ scrollTop: (msg_body.height() * msg_body.height()) }, 1000);

	$('.scn-fc-grid, .scn-address-grid').slimScroll({
		height:"190px",
		wheelStep: 3,
		railVisible: false,
		alwaysVisible: false
	});

	$('.scn-customer-detail').slimScroll({
		height:"300px",
		wheelStep: 3,
		railVisible: false,
		alwaysVisible: false
	});

	$('.scn-invoice-grid').slimScroll({
		height:"70px",
		wheelStep: 3,
		railVisible: false,
		alwaysVisible: false
	});

});

$('.scn-order-jump-page,#idOrder,#customerName,#orderTotal,#paymentType,#idBuyer,#idState,#idOrderState,#idFc').keypress(function(e){
	if(e.which == 13)
		openOrders(0,0,'',0,'id_order','DESC',1);
});

function orderDetail(id_order,type,orderBy, orderWay, tab, page)
{
	var id_order_field = "",dataparam = "",jump_page = "", per_page = "", cus_name = "", id_buyer = "", order_state = "", order_total = "", payment_type = "", order_status = "", fc = "", orderDateFrom = "", orderDateTo = "", companyName = "";

	jump_page = $('.scn-order-jump-page').val();
	per_page = $('.scn-order-per-page').val();
	id_order_field = $('#idOrder').val();
	cus_name = $('#customerName').val();
	id_buyer = $('#idBuyer').val();
	order_state = $('#idState').val();
	order_total = $('#orderTotal').val();
	payment_type = $('#paymentType').val();
	order_status = $('#idOrderState').val();
	fc = $('#idFc').val();
	orderDateFrom = $('#order-date-from').val();
	orderDateTo = $('#order-date-to').val();
	companyName = $('#companyName').val();

	id_order_field = $('#idOrder').val();
	
	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("scn-orders.php", {
		smarty: 1,
		type: type,
		id_order_single: id_order,
		page: page,
		order_by: orderBy,
		order_way: orderWay,
		tab: tab,
		order_per_page: per_page,
		jump_page: jump_page,
		id_order: id_order_field,
		cus_name: cus_name,
		id_buyer: id_buyer,
		state: order_state,
		status: order_status,
		total: order_total,
		payment: payment_type,
		fc: fc,
		from_date: orderDateFrom,
		to_date: orderDateTo,
		grp_name: companyName

	} ,function( response, status, xhr ) 
	{
	  if(tab == 1)
	  {
	  	$('#tab_1').click()
	  }
	  else if(tab == 2)
	  {
	  	$('#tab_2').click()
	  }
	  else
	  {
	  	$('#tab_0').click()
	  }

	  $(".ajaxLoaderModal").hide();
	});
}

function changeStatus(type, id_order, orderBy, orderWay, tab, page)
{
	var status = $('#order_state_change').val();
	if(status == null)
	{
		toast('Invalid order status','error');
	}
	else
	{
		var dataparam = "smarty=0&type="+type+"&id_order_single="+id_order+"&status="+status+"&tab="+tab;
		$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'scn-orders.php',
			data: dataparam,
			cache: true,
			beforeSend: function() {$(".ajaxLoaderModal").show();},
	        success:function(data){
	        	if(data == 0){
	        		toast("The new order status is invalid.","error");
	        	}
	        	else if(data == 1){
	        		toast("All products are not delivered yet.","error");
	        	}
	        	else if(data == 2){
	        		toast("Status Changed Successfully.","success");
	        		orderDetail(id_order,0, orderBy, orderWay, 1, page);
	        	}
	        	else if(data == 3){
	        		toast("The order has already been assigned this status.", "error");
	        	}
				else if(data == 4){
	        		toast("DR Upload Pending.", "error");
	        	}
	        	else if(data == 5){
	        		toast("Invoice not submitted yet.", "error");
	        	}
	        	else if(data == 6){
	        		toast("Invoice not generated yet.", "error");
	        	}

	        	if(data == 0 || data == 1 || data == 3 || data == 4 || data == 5)
	        		$(".ajaxLoaderModal").hide();
	        }   
	    });
	}
}

function changeFc(type, id_order, orderBy, orderWay, tab, page)
{
	if($('#fc_block_'+id_order).val() != undefined)
		f_center = $('#fc_block_'+id_order).val();

	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'scn-orders.php',
		data: "smarty=0&type="+type+"&id_order_single="+id_order+"&f_center="+f_center+"&tab="+tab,
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
	    success:function(data){
	    	if(data == 1)
	    	{
	    		toast("FC Changed Successfully.","success");
	    		orderDetail(id_order,0, orderBy, orderWay, 1, page);
	    	}
	    	else{
	    		toast("Error in changing FC", "error");
	    	}

	    	if(data != 1)
	    		$(".ajaxLoaderModal").hide();
	    }   
	});
}

function changeDelTime(type, id_order, orderBy, orderWay, tab, page)
{
	if($('#estimated_delivery_time').val() != undefined)
		estimated_delivery_time = $('#estimated_delivery_time').val().split(' ').join('$');

	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'scn-orders.php',
		data: "smarty=0&type="+type+"&id_order_single="+id_order+"&estimated_delivery_time="+estimated_delivery_time+"&tab="+tab,
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
	    success:function(data){
	    	if(data == 1)
	    	{
	    		toast("Delivery time changed successfully.","success");
	    		orderDetail(id_order,0, orderBy, orderWay, 1, page);
	    	}
	    	else{
	    		toast("Error in changing delivery time", "error");
	    	}

	    	if(data != 1)
	    		$(".ajaxLoaderModal").hide();
	    }  
	});
}
/*================================================================================================================================*/

function setTrackingNumber(type, id_order, orderBy, orderWay, tab, page)
{
	var id_carrier = $('#tracking_no_'+id_order).val();
	var tracking_number = $('#tracking_number').val();

	$.ajax({
		type: 'POST',
		dataType:'json',

		async: true,
		url: 'scn-orders.php',
		data: "smarty=0&type="+type+"&id_order_single="+id_order+"&id_carrier="+id_carrier+"&tracking_number="+tracking_number,
		cache: true,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
	    success:function(data){
	    	if(data == 1)
	    	{
	    		toast("Tracking Number Set successfully.","success");
	    		orderDetail(id_order,0, orderBy, orderWay, 1, page);
	    		 
	    	}
	    	else{
	    		toast("Error in Tracking Number Setting", "error");
	    	}

	    	if(data != 1)
	    		$(".ajaxLoaderModal").hide();
	    },
		completed:function()
		{
			$(".ajaxLoaderModal").hide();
		}
	});
}



/*================================================================================================================================*/
function updateDeliverySlip(file_id,id_delivery,tab,id_order,orderBy, orderWay, page){
	var fileInput = document.getElementById(file_id);
	if(fileInput.value != "")
	{
		var file = fileInput.files[0];

		if(file.size > 2097152){
			toast("Maximum Upload Size is 2 MB","warning");
		}
		else
		{
			var formData = new FormData();

			formData.append('file', file);
			formData.append('id_delivery', id_delivery);
			formData.append('id_order_single', id_order);
			formData.append('type',1);
			formData.append('tab', tab);

			$.ajax({
		        url: 'scn-orders.php',
		        type: "POST",
				data: formData,
		        processData: false,
		        contentType: false,
		        beforeSend: function() {$(".ajaxLoaderModal").show();},
		        success:function(data){

		        	if(data == 0)
		        		toast("Please Upload Valid File","error");
		        	else if(data == 1)
		        		toast("File format cannot be accepted","error");
		        	else if(data == 2)
		        		toast("Maximum Upload Size is 2 MB","warning");
		        	else if(data == 3)
		        	{
		        		toast("Scan copy Uploaded Successfully","success");
		        		orderDetail(id_order,0, orderBy, orderWay, 2, page);
		        	}
			       	else if(data == 4)
		        		toast("Problem with file upload.Try again after sometimes.","error");

		        	if(data == 0 || data == 1 || data == 2 || data == 4)
		        		$(".ajaxLoaderModal").hide();
		        }   
		    });
		}
	}
	else
		toast("Please select a file to proceed","error");
}

function updateLabels(file_id,id_delivery,tab,id_order,orderBy, orderWay, page)
{
	var kob_label = $('#kobsterLabel_'+id_delivery).val();
	var other_label = $('#otherLabel_'+id_delivery).val();
	var dataparam = "type=1&id_delivery="+id_delivery+"&tab="+tab+"&id_order_single="+id_order+"&smarty=0&file_upload_true=0&kob_box="+kob_label+"&other_box="+other_label;
	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'scn-orders.php',
				data: dataparam,
				cache: true,
				beforeSend: function() {$(".ajaxLoaderModal").show();},
		        success:function(data){
		        	if(data == 5){
		        		toast("Boxes Updated Successfully.","success");
		        		orderDetail(id_order,0, orderBy, orderWay, 2, page);
		        	}

		        	if(data != 5)
		        		$(".ajaxLoaderModal").hide();
		        }   
		    });
}

function submitMessage(id_order,type, orderBy, orderWay, tab, page)
{	
	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'scn-orders.php',
			data: $('#submitMessage').serialize(),
			cache: true,
			beforeSend: function() {$(".ajaxLoaderModal").show();},
	        success:function(data)
	        {
	        		toast("Comment added Successfully.","success");
	        		$('#text_message').val('');
	        		orderDetail(id_order,0, orderBy, orderWay, 1, page);
	        }
	    });
}

function setCancelQuantity(itself, id_order_detail, quantity)
{
	$('#quantity_box_' + id_order_detail).val($(itself).attr('checked') ? $('#updateQuantity_'+id_order_detail).val() : '');
}

$(function(){
   $('#select-all-product').click(function(event) {   
        if(this.checked) 
        {
                $('.quantity-checkbox:checkbox').click();                     
        }
        if(!this.checked)
        {
                $('.quantity-checkbox:checkbox').click();                         
        }
    });
});

//Function to generate partial DR
function generateDR(type, id_order, orderBy, orderWay, tab, page)
{
	var kob_box = $('#kobsterLabel').val();
	var other_box = $('#otherLabel').val();

	if(kob_box == "")
		toast('Please enter number of kobster boxes', 'error');
	else if(other_box == '')
		toast('Please enter number of other boxes', 'error');
	else if(kob_box != '' && other_box != '')
	{
		$.ajax({
			type: 'POST',
			async: true,
			datatype: 'json',
			url:'scn-orders.php',
			data: $('#productListOrder').serialize()+"&type=3",
			cache: false,
			beforeSend: function() {$(".ajaxLoaderModal").show();},
			success: function(data)
			{
				if(data == 2) {
					toast("No products selected", "error");
				}
				else if(data == 1) {
					toast("No quantity selected or Invalid quantity selected for product.", "error");
				}
				else if(data == 0) {
					toast("DR Generated Successfully", "success");
					orderDetail(id_order,0, orderBy, orderWay, 1, page);
				}
				else if(data == 3) {
					toast("Please select all products to generate DR.", "error");
				}
				else if(data == 4) {
					toast("DR already generated", "error");
				}
				else {
					toast(data, "error");
				}

				if(data == 2 || data == 1)
					$(".ajaxLoaderModal").hide();
			}
		});
	}
}

function toogleShippingCost(obj)
{
	generateDiscount = $('#generateDiscount').attr("checked");
	generateCreditSlip = $('#generateCreditSlip').attr("checked");
	if (generateDiscount != "checked" && generateCreditSlip != "checked")
	{
		$('#spanShippingBack input[type=checkbox]').attr("checked", false);
		$('#spanShippingBack').hide();
	}
	else
		$('#spanShippingBack').show();
}

function cancelProduct(type, id_order, orderBy, orderWay, tab, page)
{
	var ret = true, totalCancel, totalQty, totalQtyReturn, totalAvailable;
	$('.cancelCheck').each(function(){
			totalCancel = parseInt($(this).find('.cancelQuantity').val());
			totalQty = parseInt($(this).find('.totalQty').val());
			totalQtyReturn = parseInt($(this).find('.totalQtyReturn').val());
			totalAvailable = totalQty - totalQtyReturn;
			if (totalCancel > totalAvailable)
			{
				ret = false;
			}
		}
	);
	
	if(ret == true)
	{
		$.ajax({
			type: 'POST',
			async: true,
			datatype: 'json',
			url:'scn-orders.php',
			data: $('#productListOrder').serialize()+"&type=4",
			cache: false,
			beforeSend: function() {$(".ajaxLoaderModal").show();},
			success: function(data)
			{
				if(data == 5)
				{
					toast("Products Cancelled Successfully", "success");
					orderDetail(id_order,0, orderBy, orderWay, 1, page);
				}
				else if(data == 0)
				{
					toast("All products cancelled in this order", "warning");
					orderDetail(id_order,0, orderBy, orderWay, 1, page);
				}
				else
				{
					toast(data, "error");
				}

				if(data != 5)
					$(".ajaxLoaderModal").hide();
			}	
		});
	}
	else
	{
		toast("Quantity to cancel is greater than quantity available in selected list", "error");
	}
}

function returnProduct(type, id_order, orderBy, orderWay, tab, page)
{
	$.ajax({
		type: 'POST',
		async: true,
		datatype: 'json',
		url:'scn-orders.php',
		data: $('#productListOrder').serialize()+"&type=5",
		cache: false,
		beforeSend: function() {$(".ajaxLoaderModal").show();},
		success: function(data)
		{
			if(data == 1) {
				toast("Product replaced successfully", "success");
				orderDetail(id_order,0, orderBy, orderWay, 1, page);
			}
			else {
				toast(data, "error", 5000);
				orderDetail(id_order,0, orderBy, orderWay, 1, page);
			}
		}
	});
}

function getFullConversation(id_order, id_employee)
{
	window.open('scn-orders.php?type=6&id_order='+id_order+'&conversation=1','mywindow','width=400,height=200,left=0,top=100,screenX=0,screenY=100');
	return false;
}

function confirmSplit(type,id_order,orderBy, orderWay, tab, page)
{
	var ret = true, totalCancel, totalQty, totalQtyReturn, totalAvailable;
	var count = 0;
	$('.quantity-checkbox').each(function(){
			if($(this).is(":checked"))
			{
				count = count + 1;
				id = $(this).val();
				quantity = $('#updateQuantity_'+id).val();
				selected_qty = $('#quantity_box_'+id).val();
				delivered_qty = $('#delivered_qty_'+id).val();
				if(delivered_qty == '')
				{
					delivered_qty = 0;
				}
				if(selected_qty == '')
				{
					selected_qty = 0;
				}

				if(quantity < selected_qty - delivered_qty)
				{
					count = 0;
					return false;
				}
			}
		}
	);
	if(count != 0){
		$('#splitcnfrm').show();
		$('#splitcnfrmId').html('#'+id_order);
	}
	else
	{
		toast('Please check the quantity selected',"warning");
	}
}

function splitOrder(id_order,type,orderBy, orderWay, tab, page)
{
	
	$('#splitcnfrm').hide();
	var ret = true;
	if(ret == true)
	{
		if($('.payment_mode strong').html() == "EBS" || $('.payment_mode strong').html() =="PENDING FOR APPROVAL")
		{
			toast("Sorry order cannot split due to invalid order status", "warning")
			return false;
		}
		var po_number = $('#po_number').val();
		$.ajax({
			type: 'POST',
			async: true,
			datatype: 'json',
			url:'scn-reorder.php',
			data: $('#productListOrder').serialize()+"&type=1&split_order=true&id_order="+id_order+"&id_employee="+id_employee,
			cache: false,
			beforeSend: function() {$(".ajaxLoaderModal").show();},
			success: function(data)
			{
				if(data.includes('~'))
				{
					var arr = data.split("~");	
					$('#orderResultModal').show();
					$('#orderResultModal .modal-title').html('Split Order - Success!');
					$('#orderResultModal .modal-body').html('<p>The Order #'+id_order+' was split into TWO different orders, successfully</p><br><p>Old Order - <span>#'+id_order+'('+arr[3]+' products)</span></p><p>New Order - <span>#'+arr[0]+'('+arr[2]+' products)</span></p>');
					$('#new_order_btn').html('View New Order #'+arr[0]);
					$('#old_order_btn').html('View Old Order #'+id_order);
					$('#new_order_btn').attr("onclick","orderDetail("+arr[0]+","+type+",'"+orderBy+"','"+orderWay+"',"+tab+","+page+")");
					$('#old_order_btn').attr("onclick","orderDetail("+id_order+","+type+",'"+orderBy+"','"+orderWay+"',"+tab+","+page+")");
				}				
				else if(data == 404)
				{
					$('#splitError').show();
					$('#splitErrorId').html('#'+id_order);
				}
				else if(data == 0)
				{
					toast("All products cancelled in this order", "warning");
				}
				else
				{
					toast(data, "error");
				}

				if(data != 5)
					$(".ajaxLoaderModal").hide();
			}	
		});
	}
	else
	{
		toast("Quantity to cancel is greater than quantity available in selected list", "error");
	}
}

$( document ).ready(function() {
    $('.splitClose').click(function(){
    	$('.split-modal').hide();
    });

    $(".splitOrderAction").click(function(e) {
        e.stopPropagation();
        var id_order= this.id.replace('i_','');
        if(!$(this).hasClass('active')){
    		$(this).addClass('active');
			$.ajax({
				type: 'POST',
				async: true,
				datatype: 'json',
				url:'scn-orders.php',
				data: "&type=10&id_order="+id_order,
				cache: false,
				beforeSend: function() {$(".ajaxLoaderModal").show();},
				success: function(response)
				{
					var data = JSON.parse(response);
					var html = "<tr id='r_"+id_order+"'><td colspan='8'><table><thead><th>Parent Order</th><th>Child Order</th><th>Date</th></thead><tbody><tr>";
					for(var i = 0; i < data.length; i++){
						html = html+"<tr>\
										<td class="+(id_order == data[i].id_parent ? "btn-primary":"")+">"+data[i].id_parent+"</td>\
										<td class="+(id_order == data[i].id_order ? "btn-primary":"")+">"+data[i].id_order+"</td>\
										<td>"+data[i].date_add+"</td>\
									</tr>";
					}
					html = html+"</tr></tbody></table></td></tr>";
					console.log(html);
					$('#scn-orders tbody #'+id_order).after(html);
				}
			});
        }
        else{
        	$(this).removeClass('active');
        	$('#r_'+id_order).remove();
        }

   });
});

function downloadBudgetPo() {
	$('#budgetPoDownload').submit();
}