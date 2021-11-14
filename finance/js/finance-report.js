$(document).ready(function ()
{
	
		$('.dpd1').datepicker({
			format: 'dd-mm-yyyy'
		});
	
		$('.dpd2').datepicker({
			format: 'dd-mm-yyyy'
		});
		financeDuractionReport(4);
	
});

function financeDuractionReport(duration)
{
	var from_date = 0,to_date = 0;
	if(duration == 5)
	{
		from_date = $('#from_date').val();
		to_date = $('#to_date').val();
	}
	 
	$('#history_report').show();
	 var type=1;
	 var dataparam= '&type='+type+'&duration='+duration+'&from_date='+from_date+'&to_date='+to_date;
	 $(".ajaxLoaderModal").show();
	 $.ajax({
		type: 'POST',
		async: false,
		dataType:'json',
		url: 'finance-report.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{	
				if(data !="")
			{
				 
				$("#spinContainer").html('');
				 	lineChart(data,duration);//data->contains all chart data,duration->all,3,6,1year,rep_type=general or save report
			}
			 else
			 {
				 $("#idGlobalAlert").html("No records has been found as per your request");
				 $('#globalAlert').modal('show');
				 return false;
			 }
		}
	});
	$(".ajaxLoaderModal").hide();	
}
function lineChart(data,duration)//Report based on customer purchased history
{
   	for (var i=0; data.length > i ; i++)
 		data[i].y = parseFloat(data[i].y);
	
	var divid="spinContainer";
	
 	if(duration==1)
		var heading = "Last Months Report";
	else if(duration==2)
		var heading = "Last Quarter Report";
	else if(duration==3)
		var heading = "Last 1 Year Report";
	else if(duration==4)
		var heading = "Finance Report";
 	var chart = new CanvasJS.Chart(divid,
	{
		animationEnabled: true,
		axisX: {
		valueFormatString: "MMM",
		interval:1,
 		
		},
		theme: "theme3",
		title:{text: heading,fontFamily: "Helvetica",fontWeight: "normal"},
		axisY:{title: "Spends in INR"},
		axisX:{title: "Order Ids"},
		zoomEnabled: true,
		data: [{ type: "line",dataPoints: data, indexLabelPlacement: "outside",
        indexLabel: "{y}",
        indexLabelOrientation: "vertical", }]
	});
	chart.render();
}