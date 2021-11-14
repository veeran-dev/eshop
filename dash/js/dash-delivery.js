// JavaScript Document

$(document).ready(function()
{	
	var dataparam = '&id_customer=' + id_customer;
   	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-deliverydata.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
				var dr_download;
				if(data)
				{
					for(var i=0; i<data.length; i++)
					{

						if(data[i].dr_file_name == "" || data[i].dr_file_name == null)
						{
								data[i].dr_file_name = "Not Available";	
						}
						else
						{
							data[i].dr_file_name = "<a href='"+baseDir+"scanedDRs/"+data[i].dr_file_name+"' download>"+data[i].dr_file_name+"(<span class='fa fa-download acknowledge' style='color:#28c732;'></span>)</a>";
						}

						if(data[i].id_delivery == "" || data[i].id_delivery == null)
						{
							data[i].delivery_number = "Not Available";
							data[i].delivery_date = "Not Available";
							data[i].delivery_number = "Not Available";
							dr_download = "Not Available";				
						}
						else
						{
							dr_download = "<a href='"+baseDir+"index.php?controller=pdf-invoice&id_par_delivery="+data[i].id_delivery+"'>"+data[i].delivery_number+"(<span class='fa fa-download' style='color:#28c732;'></span>)</a>";
						}

						$('#DeliveryTable').append("<tr>\
													<td>"+data[i].added_date+"</td>\
													<td>"+data[i].delivery_number+"</td>\
													<td>"+data[i].delivery_date+"</td>\
													<td>"+data[i].id_order+"</td>\
													<td>"+data[i].status+"</td>\
													<td>"+dr_download+"</td>\
													<td>"+data[i].dr_file_name+"</td>\
													</tr>");				
					}
				}
				easySearch('customer_delivery_receipt');
			}
	});
});


