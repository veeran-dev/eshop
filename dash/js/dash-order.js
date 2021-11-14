// JavaScript Document
$('.toggle-right-box, #total_cart_products').show();
$(document).ready(function()
{
	ordering_type=3//represent the page type for the back purpose of steps
 	var type=1;//(to get all orders for particular customer)
	var dataparam = '&id_customer=' + id_customer+'&type=' + type;
  	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-history.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
 				var pdf;
				
 				for(var i=0; i<data.length; i++)
				{
					var remaining_credit_days = credit_days - data[i].bill_age;

					if(data[i].invoice_number == "0" ){
						pdf="<span style='margin-left:25px;'>&mdash;</span>";
					}
					else{
						pdf='<a href= '+baseDir+'index.php?controller=pdf-invoice&id_order='+data[i].id_order+'><span class="fa fa-download download"></span></a>';
					}
							
					var fields = data[i].id_order+","+data[i].id_address_delivery+","+data[i].id_address_invoice;
					var date = data[i].added_date;
					
					var newdate = new Array();
					newdate = date.split("-");
				
					var monthname = newdate[1];
						
					$("#order_history").append("<tr><td>"+monthname+"</td><td><a data-toggle='modal' onclick='getStatusDetails("+fields+");' href='#status_history'>"+data[i].id_order+"</a></td><td><a onclick='getStatusDetails("+fields+");' data-toggle='modal' href='#status_history'>"+data[i].added_date+"</a></td><td><a  onclick='getStatusDetails("+fields+");' data-toggle='modal' href='#status_history'>"+parseFloat(data[i].total_paid).toFixed(2)+"</a></td><td>"+data[i].bill_age+"</td><td><a  onclick='getStatusDetails("+fields+");' data-toggle='modal' href='#status_history'>"+data[i].payment+"</a></td><td>"+data[i].order_state+"</td><td>"+pdf+"</td><td><span onclick='reOrder("+data[i].id_order+")' class='label label-primary cur-poi label-mini'>Re-Order </span></td></tr>");
						/*This is for track order */
						if(i<10)
						$('#listOfOrders').append("<tr id='order-detail-"+data[i].id_order+"'class='cur-poi' onclick='getTrackOrderDetails("+fields+")'><td>"+monthname+"</td><td>"+data[i].id_order+"</td><td>"+data[i].added_date+"</td></tr>");
				}
				easySearch('customer_orders');//calling index.js easysearch();			
			}
	});
	$('#orderHistory').slimScroll({
		height:"450px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});
	$('#history_popup').slimScroll({
		height:"600px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});
	$('#timelinediv').slimScroll({
		height:"450px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});
		$("#next_buton").show();
		
});

 
function reOrderCart(orderid)
{
	
  	var type=3;
 	var dataparam = '&id_order=' + orderid+'&type=' + type+'&submitReorder=true';
 $.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-history.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
  					 //$('#error_alert').html('');
					 $('#listoferrors').html('');
					 var success=0;
					 if(data !="")
					 {
						 for(var i =0 ; data.length >i; i++)
						 {
							 if(data[i].msg != "success")
							 {
								var sno=i+1;
								//$('#error_alert').append("<div><span>"+sno+")</span><span>"+data[i].name+"</span></div>");
								$('#listoferrors').append("<tr><td>"+data[i].name+"</td><td>"+data[i].msg+"</td></tr>");
								$('#error_cart').modal('show');
							 }
							 else
							 {
								success++; 
							 }
						 }
 					 }
  				 
 					
					/*load shopping cart by default*/
					if(success >0)
				 	{
						loadShopingCart();
						if ($('#container').hasClass('open-right-panel')) {
						}
						else
						{	
							$('.toggle-right-box .fa-shopping-cart').click();
						}
					}
					$("#index_viewport").load("dash-place-order-steps.php", function() {
	                    $("a[href$='#next']").click();
	                    if (ordering_type == 3) {
	                        $('#wizard-t-0').click(function() {
	                            orderHistory();
	                        });
	                    }
						if(ordering_type==4)
						{	
							$('#wizard-t-0').click(function(){
								trackOrder();
							});
						}
						$('.actions').hide();
					});
				}
			 
});
}
function getTrackOrderDetails(orderId,delivery_add, invoice_add )
{
	ordering_type=4//represent the tracking order page
  	$('#trackOrder').show();
	$('#step3').hide();
	$('#step4').hide();
	$('.timeline').html('');
	var type=4;
	var dataparam = '&id_order=' + orderId+'&type=' + type;
	 $.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'dash-history.php',
				data: dataparam,
				cache: true,
				success: function(data)
				{

 					var cla=0;
					
					$('.timeline').append('<article class="timeline-item "><div class="text-right"><div class="time-show last"><a data-toggle="modal" onClick="getStatusDetails('+orderId+','+delivery_add+','+invoice_add+');" href="#timeline_history" class="btn btn-primary" >'+orderId+'</a></div></div></article><article class="timeline-item  "><div class="timeline-desk"><div class="panel"></article>');
					
 					for (var i=data.length; i>0; i-- )
					{
						
						
							var altCla=cla % 2;
 							if(altCla  == 0)
							{
 								altClass="alt";
								spanClass="-alt";
							}
							else
							{
 								altClass="";
								spanClass="";
							}
							
							if(data[i-1].ostate_name == 'Generate Invoice') 
							{
								data[i-1].ostate_name = 'Invoice Generated';
							}
							if(data[i-1].ostate_name == 'Offline invoice generated')
							{
								data[i-1].ostate_name = 'Invoice generated';
							}
							iconSelection(data[i-1].id_order_state,data[i-1].date_add,data[i-1].ostate_name,type=1)
						cla++;
						
					}
					
  				}
	});
}
 