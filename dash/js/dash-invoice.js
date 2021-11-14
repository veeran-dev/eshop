// JavaScript Document
$(document).ready(function()
{
	var dataparam = '&id_customer=' + id_customer;
   	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'dash-invoicedata.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{	
				if(data)
				{
 					for(var i=0; i<data.length; i++ )
					{
						if(data[i].invoice_date!=null)
						{
						var date = data[i].added_date;
						var newdate = new Array();
						newdate = date.split("-");						
						var monthname = newdate[1];
						$('#InvoiceTable').append("<tr><td>"+monthname+"</td><td>"+data[i].invoice_number+"</td><td>"+data[i].invoice_date+"</td><td>"+data[i].id_order+"</td><td>"+data[i].total_paid+"</td><td><a href='"+baseDir+"index.php?controller=pdf-invoice&id_order="+data[i].id_order+"'>"+data[i].invoice_number+"(<span class='fa fa-download' style='color:#28c732;'></span>)</a></td></tr>");
						}
					}
				}
				easySearch('customer_invoice');
			}
	});
	$('#Invoice').slimScroll({
		height:"450px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});
});