//JavaScriptDocument
function individual_points()// to get individual points every time when order placed
{	
	var type = 1;
	var dataparam = '&type='+type+'&id_customer='+id_customer; 
	$('#customer_points_display').html('');
	$.ajax
	({
			type: 'POST',
			dataType:'json',
			url: 'dash-display-points.php',
			async: true,
			cache: false,
			data:dataparam,
			success:function(jsondata)
			{
				
			
				if(jsondata[0][0] <= 0)
					var price =0;
				else
					var price = jsondata[0][0];
				
 				$("#convert_voucher_id").html('');
 				$("#convert_voucher_id").append("<span class='float-left bold-font'>Total available points : "+jsondata[0][1]+"</span> <span class='bold-font'style='margin-left:12px;'> Value of these points : Rs."+price+"</span>");

 				for(var i=0; i<jsondata[1].length; i++)
				{
					var date = jsondata[1][i].date;
					var newdate = new Array();
		
					newdate = date.split(" ");
					var display_date = newdate[0].split("-");
					var month_name = (getmonth(display_date[1]));
					var date_show = display_date[0]+"-"+month_name+"-"+display_date[2];
					$('#customer_points_display').append("<tr><td><a onclick='getStatusDetails("+jsondata[1][i].id+","+jsondata[1][i].id_address_delivery+","+jsondata[1][i].id_address_invoice+")' href='#status_history' data-toggle='modal'>"+jsondata[1][i].id+"</a></td><td>"+date_show+"</td><td>"+jsondata[1][i].points+"</td><td>"+jsondata[1][i].state+"</td></tr>");
					
					
				}
			}
	});
}

function convert_voucher_points()// to convert available points into vouchers
{
		var type = 3;
	var dataparam = '&type='+type+'&id_customer='+id_customer;
   	$.ajax({
			type: 'POST',
			//dataType:'json',
			async: true,
			url: 'dash-display-points.php',
			data: dataparam,
			cache: true,
 			success: function(data)
			{
				
				$("#customer_convert_points_popup").html('');
				$("#customer_convert_points_popup").append("<div>Your points are converted into vouchers</div>");
				$("#convert_voucher_id").html('');
			
				
				
				$("#customer_points").html('');
				$("#customer_points").append("<div class='bold-font'>Loyalty Points: 0</div>");
				loadVoucherCode(0);
			}
});
				
}
function view_available_vouchers()//to view all vouchers available for a customer
{
	var type =4;
	var dataparam = '&type='+type+'&id_customer='+id_customer;
		$('#customer_vouchers_display').html('');
		$.ajax({
			
				type:'POST',
				async:true,
				dataType:'json',
				url:'dash-display-points.php',
				data:dataparam,
				cache:true,
				success:function(data)
				{
					for(var i=0; i<data.length; i++)
					{	
				
						$('#customer_vouchers_display').append("<tr><td>"+data[i].name+"</td><td>"+data[i].value+"</td></tr>");
					}
				}
				
		
		
		});
}
$(function(){
$('#customer_loyalty_points').slimScroll({
		height:"200px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});
$('#customer_voucher').slimScroll({
		height:"250px",
		wheelStep: 1,
		railVisible: true,
		alwaysVisible: true
		});
});
function getmonth(monthnumber)
{
	var months =['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	return months[monthnumber - 1];
}