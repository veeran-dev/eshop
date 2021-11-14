$(document).ready(function(){
	autoCompSearch("#search_product_history","scn_prod_history");
	getAllFc("#fulFillmentCentreProdHistory");
});

$('#product_history_table').slimScroll(
{
	height: "350px",
	wheelStep: 15,
	railVisible: true,
	alwaysVisible: true
});

function productHistoryData()
{
		$.ajax({
			type: 'GET',
			dataType:'json',
			async: true,
			url: 'scn-producthistory.php',
			data: '&type=1&id_product='+$('#prodHistIdProduct').val()+'&id_fc='+$('#fulFillmentCentreProdHistory').val(),
			cache: true,
			success: function(data)
			{
				$("#product_history, #high_cost, #low_cost").html("");
				var length=data.length -1 ;
				var dp = [];
				
				
				var array_value = [];
					for(var i=0; i<data.length; i++)
				{
					array_value.push( data[i].unit_price);
						$("#product_history").append("<tr><td>"+data[i].id_bill_no+"</td><td>"+data[i].name+"</td><td>"+data[i].bill_date+"</td><td>"+parseInt(data[i].product_qty)+"</td><td>"+parseInt(data[i].unit_price).toFixed(2)+"</td></tr>");
						dp.push({label:''+data[i].bill_date+'', y: parseFloat(data[i].unit_price),customtooltip:''+data[i].name+'',indexLabel: ''});
				}
					$.map(array_value, function(value, key) {
				  var max = Math.max.apply(Math,array_value);
				  var min = Math.min.apply(Math,array_value);
				  if(value == max)
						$("#high_cost").html(max.toFixed(2)+" / "+data[key].name);
				  if(value == min)
					$("#low_cost").html(min.toFixed(2)+" / "+data[key].name);
					});
						
				var chart = new CanvasJS.Chart("product_history_Container",
				{
					zoomEnabled: true,
					panEnabled: true,
					height:300,
				  title:{
					text: "",
					fontFamily: "Helvetica",
					fontWeight: "normal"
				  },
				   axisY: {
						title: "INR"
						
						},
					axisX: {
					title: "",
					labelAngle: -90
					},
					
				   data: [
				  {       
					type: "line",
					dataPoints: dp
				  }       
					
				  ]
				});

				chart.render();
				
			}
	});
}