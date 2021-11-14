var vendor_id = 0;

$(document).ready(function()
{ 
	$('#top-ven-date-from,#top-ven-date-to,#vendor-perform-date-from,#vendor-perform-date-to').datepicker({
		prevText:"",
		nextText:"",
		dateFormat:"yy-mm-dd"
	});

	var report_type = $('#report_type').val();

	if(report_type==3){
 		topVendors();
	}

	if(report_type==5){
 		history();
	}

	$("#scn-vendor-list-select").autocomplete("scn-viewpurchasebilldata.php?type=6",
	{
		minChars:1,
		max: 10,
		dataType:"json",
		formatItem: function(data, i, max, value, term) {
			return value;},	
		parse: function(data){
			if(data=="")
			{	
				return data;
			}
			else{
				var mytab = new Array();
				for(var i = 0; i < data.length; i++)
					mytab[mytab.length] = { data: data[i].name+"~" +data[i].id_vendor+"~" +data[i].tin+"~" +data[i].cst, value:"<div><span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>"+data[i].name+"</br>"+"Vendor Id:"+data[i].id_vendor+"</br>"+"Tin No: "+data[i].tin+"</span></div>"};
				return mytab;
			}},
	}).result(
	function(event, data, formatted, value) 
	{
		var seperate = data.split('~');
		vendor_id = seperate[1];
		$('.filter-block').show();
		$('.filter-block-btns').html('').append('<button type="button" class="btn btn-primary" onclick="history_chart('+vendor_id+')">Submit</button>\
            									 <button type="button" class="btn btn-default" onclick="reports(5)">Reset</button>');
		history_chart(vendor_id);
		$("#scn-vendor-list-select").val('');
		$("#scn-vendor-list-select").val(seperate[0]);
	});	

	//get All Fulfillment centers
	var dataparam = '&type=7';
 	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'scn-orderstatus.php',
		data:dataparam,
		cache: true,
		success: function(data)
		{
			$('#fulFillmentCentre').html('');
			$('#fulFillmentCentre').append('<option value="0">Select Fulfillment Center</option>');
			for(var i = 0; i < data.length; i++){
				$('#fulFillmentCentre').append('<option value="'+data[i].id_fulfillment_centre+'">'+data[i].city_name+'</option>');
			}
		}
	});
});

function topVendors()
{
 	$('#history_report').hide();
	$("#topvendors_report").show();
	var date_from = $('#top-ven-date-from').val();
	var date_to = $('#top-ven-date-to').val();
 	$.ajax({
			type: 'GET',
			async: false,
			dataType:'json',
			url: 'scn-viewpurchasebilldata.php',
			data: '&type=4&id_fc='+$('#fulFillmentCentre').val()+'&from_date='+date_from+'&to_date='+date_to,
			cache: false,
			success: function(data)
			{	
 				if(data !="")
				{   
					$("#barChartContainer").show();
					$("#barChartContainer").html('');
					barChart(data);
				}
				else
				{
					 $("#barChartContainer").html('');
					 $("#barChartContainer").hide();
					 toast('No records has been found as per your request', 'info');
				}
				
			}
	});
 }

function lineChart(data)
{
 	var dp = [];	
	for(var i=0;i< data.length;i++){
		var split = data[i]['bill_date'];
		var month = new Date(split);
		var full_year = month.getFullYear();
		var year = full_year.toString().substr(2,2);
		var months = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
		dp.push({label:months[month.getMonth()]+"-"+year, y: parseFloat(data[i].purchase_total),indexLabel: ''+parseFloat(data[i].purchase_total).toFixed(2)+''});
	var chart = new CanvasJS.Chart("spinContainer",
	{
	  title:{
		text: "Monthly Performance Report",
		fontFamily: "Helvetica",
		fontWeight: "normal"
	  },
	   axisY: {
			title: "Spends in INR"
			},
		axisX: {
		title: "Month"
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
}

function barChart(data)
{	var dp = [];
	var total = 0,percent,fc_name;	

	if($('#fulFillmentCentre').val() == 0 || $('#fulFillmentCentre').val() == null)
		fc_name = "Overall";
	else
		fc_name = $('#fulFillmentCentre option:selected').text();

	for(var j=0;j< data.length;j++){
		total += parseFloat(data[j]['total']);
	}

	for(var i=0;i< data.length;i++){ 
		percent = (parseFloat(data[i]['total']) / total) * 100;
		dp.push({y: data[i]['total'], label: data[i]['name']+"-"+percent.toFixed(2)+"%",consumption:data[i]['consumption'],legendText:data[i]['name']});
	}
			var chart = new CanvasJS.Chart("barChartContainer",
			{
			  title:{

				text: fc_name+" - Top 10 Vendors",
				fontFamily: "Helvetica",
				fontWeight: "normal"
			  },
			  animationEnabled: true,
				legend:{
					verticalAlign: "center",
					horizontalAlign: "right",
					fontSize: 12,
					fontFamily: "Verdana"        
				},
			  data: [              
			{
			showInLegend: true,
			// Change type to "bar", "splineArea", "area", "spline", "pie",etc.
			type: "pie",
			dataPoints: dp
			}
			]
		   });
          chart.render();
}

function history()
{
   	$('#history_report').show();
 	
 }

function history_chart(id_vendor)
{
   	$('#history_report').show();
 	$('#topvendors_report').hide();

 	var date_from = $('#vendor-perform-date-from').val();
 	var date_to = $('#vendor-perform-date-to').val();

	$.ajax({
		type: 'POST',
		async: false,
		dataType:'json',
		url: 'scn-viewpurchasebilldata.php',
		data: '&type=5&id_vendor='+id_vendor+'&from_date='+date_from+'&to_date='+date_to,
		cache: false,
		success: function(data)
		{
			if(data != "" && data.length > 0)
			{	
				$("#listTitle").html(data[0].name);
				$("#spinContainer").show();
				$("#spinContainer").html('');
				 	lineChart(data);
			}
			else
			{
			 	$("#listTitle").html('Select a Vendor');
			 	$("#spinContainer").html('');
			 	$("#spinContainer").hide();
				toast("No records has been found as per your request","info");
			}
		}
	});	
 }