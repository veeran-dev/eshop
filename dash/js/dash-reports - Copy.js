var rm_portal,id_employee,cus_default_group=0;
$(document).ready(function()
{ 
 	if(rm_portal != 1)
	{
		defaultExecution();
		/*drawLogo(cus_default_group);*/
	}
	else
	{
		$('#pick-customer').show();
		$('.staticButtons').hide();
 		$.getScript( "rm/js/rm-index.js", function(textStatus)
		{
		 //console.log( textStatus );
		});
		getCustomerList(6);
 	}
	
});

function defaultExecution()
{
	
	/*var source = 'http://www.kobster.com/img/logo/'+cus_default_group+'.png';
	$("#customer_logo").attr("src", source);
	drawLogo(cus_default_group);//for report pdf generation  */
 	var report_type = $('#report_type').val();
	var duration=0;
	if(report_type==1)
  		history(duration,0,0);
 	else if(report_type==2)
 		category(duration,0,0);
 	else if(report_type==3)
  		topProducts(duration,0,0);
 	else if(report_type==4)
  		locationBasedReports(duration,0,0);
	else if(report_type==5)
	{
		var orderid = $("#orderid").val();
		var address = $('#addressId').val();
 		$('.repoCategoryFilter').show();
		var type=2;
		var dataparam = '&type='+type+'&customerid='+id_customer+'&orderid='+orderid+'&duration='+duration+'&addressId='+address;
  		$.ajax({
				type: 'POST',
				async: false,
				dataType:'json',
				url: 'dash-reports.php',
				data: dataparam,
				cache: true,
				success: function(data)
				{	
					$("#category_id").html("");
 					if(data.length !=0)
					{
						for(var i = 0; data.length>i; i++ )
						{ 
							$("#category_id").append("<option value='"+data[i]['id_category']+"'>"+data[i]['indexLabel']+"</option>");
						} 
						topCategoryProducts(duration,0,0);
					}
					else
					 {
						 
 						 $("#idGlobalAlert").html('No records has been found as per your request');
						 $('#globalAlert').modal('show');
					 }
					
				}
		 });
		 
  		
	}
 	if(report_type!=4 || report_type!=5 )
	{
		var type=3;
		 var dataparam= '&type='+type+'&customerid='+id_customer;
			 $.ajax({
					type: 'POST',
					async: false,
					dataType:'json',
					url: 'dash-reports.php',
					data: dataparam,
					cache: false,
					success: function(data)
					{
						for(var i = 0; data[0].length>i; i++ )
 							$("#orderid").append("<option value='"+data[0][i]['orderid']+"'>"+data[0][i]['orderdate']+"|"+data[0][i]['orderid']+"|"+data[0][i]['totalvalue']+"</option>");
 						for(var i = 0; data[1].length>i; i++ )
 							$("#addressId").append("<option value='"+data[1][i]['id_address']+"'>"+data[1][i]['alias']+" </option>");
 					}
		 });
	}
}
function durationReport(duration,rep_type)
{
  	var report_type = $('#report_type').val();
	var address = $('#addressId').val();
   	if(report_type==1)
 		history(duration,address,rep_type);
 	else if(report_type==2)
	{
		if(duration!=0)
			$("#orderid").val(0);
  		category(duration,address,rep_type);
	}
 	else if(report_type==3)
  		topProducts(duration,address,rep_type);
 	else if(report_type==4)
  		locationBasedReports(duration,address,rep_type);
	else if(report_type==5)
	{
		/*if(duration!=0)
			$("#category_id").val(1);*/
   		topCategoryProducts(duration,address,rep_type);
	}
 	if(duration==5)
   		$('#addressId').val(0);
 	 
 }
 function history(duration,address,rep_type)
{
 	var address = $('#addressId').val();
   	$('#history_report').show();
 	$('#categories_report').hide();
	$('#topproducts_report').hide();
	$('#locationBasedReport_div').hide();
	$('#top_10_product_in_cate_div').hide();
	$('#address_filter').hide();
	$('.repo_filter').hide();
	$('.repoCategoryFilter').hide();
	$('.staticButtons').show();
	 var report_type = $('#report_type').val();
	 var type=1;
	 var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+duration+'&addressId='+address;
    	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{	
  				if(data !="")
				{
					if(rep_type==0)
						$("#spinContainer").html('');
 				 	lineChart(data,duration,rep_type);//data->contains all chart data,duration->all,3,6,1year,rep_type=general or save report
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
					 return false;
				 }
			}
		});	
 }
function category(duration,address,rep_type)
{
	$('#history_report').hide();
	$('#categories_report').show();
	$('#topproducts_report').hide();
	$('#locationBasedReport_div').hide();
	$('#top_10_product_in_cate_div').hide();
	$('.repo_filter').show();
	$('.repoCategoryFilter').hide();
	$('.staticButtons').show();
	$('#address_filter').hide();
	var orderid = $("#orderid").val();
	var address = $('#addressId').val();
	
	var type=2;
	var dataparam = '&type='+type+'&customerid='+id_customer+'&orderid='+orderid+'&duration='+duration+'&addressId='+address;
	
    	$.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{	
 				if(data !="")
				{
					if(rep_type==0)
						$("#chartContainer").html('');
 					doughnutChart(data,duration,rep_type);//data->contains all chart data,duration->all,3,6,1year,rep_type=general or save report
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
 				 }
				
			}
	 });
 }
function topProducts(duration,address,rep_type)
{
 	$('#history_report').hide();
	$('#categories_report').hide();
	$('#topproducts_report').show();
	$('#locationBasedReport_div').hide();
	$('#top_10_product_in_cate_div').hide();
	$('.repo_filter').hide();
	$('.repoCategoryFilter').hide();
	$('#address_filter').hide();
	$('.staticButtons').show();
	var address = $('#addressId').val();
	var type=4;
	var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+duration+'&addressId='+address/*+'&orderid='+orderid*/;
 	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{	
 				if(data !="")
				{
					if(rep_type==0)
						$("#barChartContainer").html('');
					barChart(data,duration,rep_type);//data->contains all chart data,duration->all,3,6,1year,rep_type=general or save report
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
 					 return false;
				 }
				
			}
	 });
 }
 function locationBasedReports(duration,address,rep_type)
 {
	$('#history_report').hide();
	$('#categories_report').hide();
	$('#topproducts_report').hide();
	$('#locationBasedReport_div').show();
	$('#top_10_product_in_cate_div').hide();
	$('.repo_filter').hide();
	$('.repoCategoryFilter').hide();
	$('#address_filter').hide();
	$('.staticButtons').show();
	var address = $('#addressId').val();
	
	var type=6;
	var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+duration+'&addressId='+address;
 	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{	
  				if(data !="")
				{
					if(rep_type==0)
						$("#locationBasedReport").html('');
					locationBasedChart(data,duration,rep_type);//data->contains all chart data,duration->all,3,6,1year, rep_type=general or save report
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
 					 return false;
				 }
				
			}
	 });
 }
 function topCategoryProducts(duration,address,rep_type)
 {
	$('#history_report').hide();
	$('#categories_report').hide();
	$('#topproducts_report').hide();
	$('#locationBasedReport_div').hide();
	$('#top_10_product_in_cate_div').show();
	
	$('.repo_filter').hide();
	$('.repoCategoryFilter').show();
	$('#address_filter').hide();
	$('.staticButtons').show();
	var address = $('#addressId').val();
	var selected_category_id = $('#category_id').val();
	var category_name = $('#category_id option:selected').text();
	var type=8;
	var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+duration+'&selected_category_id='+selected_category_id;
  	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{	
  				if(data !="")
				{
					if(rep_type==0)
						$("#top_10_product_in_cate").html('');
					columnChart(data,duration,rep_type,category_name);//data->contains all chart data,duration->all,3,6,1year, rep_type=general or save report
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
 					 return false;
				 }
				
			}
	 });
 }
 
 
 function lineChart(data,duration,rep_type)
{
	//alert(data+"~~"+duration+"~~"+rep_type);
  	for (var i=0; data.length > i ; i++)
 		data[i].y = parseFloat(data[i].y);
 	if(rep_type==0)
	{
 		var divid="spinContainer";
 		var heading = "Monthly Spends Report";
	}
	else
	{
		var divid="spinContainer_"+duration;
		var heading = "";
	}
 	var chart = new CanvasJS.Chart(divid,
	{
	  title:{
		text: heading,
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
		dataPoints: data  
	  }       
		
	  ]
	});
	chart.render();
}
function doughnutChart(data,duration,rep_type)
{
 	 
		var totalvalue=0;
		for (var i=0; data.length > i ; i++)
		{
			totalvalue += parseFloat(data[i].y);
			data[i].label =data[i].indexLabel;
		}
		for (var i=0; data.length > i ; i++)
		{
			var labelvalue= data[i].y / totalvalue * 100;
			data[i].indexLabel = ""+data[i].indexLabel+" - "+Math.round(labelvalue)+"%" ;
			data[i].label =data[i].indexLabel ;
		}

		if(rep_type == 0 )
		{
			var divid="chartContainer";
			var heading = "Category Wise Split-Up";
			var animation=true;
		}
		else
		{
			var divid="chartContainer_"+duration;
			var heading = "";
			var animation=false;
		}
 	
	
  
 	var chart = new CanvasJS.Chart(divid,
	{
	  title:{
		text: heading,
		fontFamily: "Helvetica",
		fontWeight: "normal"
	  },

	  legend:{
		verticalAlign: "bottom",
		horizontalAlign: "center"
	  },
	  animationEnabled: animation,
	  data: [
	  {
		//startAngle: 45,
	   indexLabelFontSize: 13,
	   indexLabelFontFamily: "Helvetica",
	   indexLabelFontColor: "darkgrey",
	   indexLabelLineColor: "darkgrey",
	   indexLabelPlacement: "outside",
	   type: "doughnut",
	   showInLegend: false,
	   dataPoints: data 
	 }
	 ]
   });
 	chart.render();
}
function locationBasedChart(data,duration,rep_type)
{
 	var totalvalue=0;
 	for (var i=0; data.length > i ; i++)
	{
		totalvalue += parseFloat(data[i].y);
		data[i].label =data[i].indexLabel;
	}
	for (var i=0; data.length > i ; i++)
	{
		var labelvalue= data[i].y / totalvalue * 100;
		data[i].indexLabel = ""+data[i].indexLabel+" - "+Math.round(labelvalue)+"%" ;
		data[i].label =data[i].indexLabel ;
	}
 	if(rep_type == 0)
	{
		var divid="locationBasedReport";
		var heading = "Location Wise Split-Up";
		var animation=true;
	}
	else
	{
		var divid="locationBasedReport_"+duration;
		var heading = "";
		var animation=false;
	}
	
		var chart = new CanvasJS.Chart(divid,
		{
		  title:{
			text: heading,
			fontFamily: "Helvetica",
			fontWeight: "normal"
		  },

		  legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		  },
		  animationEnabled: animation,
		  data: [
		  {
			//startAngle: 45,
		   indexLabelFontSize: 13,
		   indexLabelFontFamily: "Helvetica",
		   indexLabelFontColor: "darkgrey",
		   indexLabelLineColor: "darkgrey",
		   indexLabelPlacement: "outside",
		   type: "doughnut",
		   showInLegend: false,
		   dataPoints: data 
		 }
		 ]
	   });
 	chart.render();
	
}

function barChart(data,duration,rep_type)
{
	var totalvalue=0;
  	for (var i=0; data.length > i ; i++)
	{
		data[i].y = parseFloat(data[i].y);
	}
	
	for (var i=0; data.length > i ; i++)
	{
		totalvalue += parseFloat(data[i].y);
		//data[i].name =data[i].label;
	}
	
	for (var i=0; data.length > i ; i++)
	{
		var labelvalue= data[i].y / totalvalue * 100;
		//data[i].label = ""+((labelvalue)).toFixed(2)+"%" ;
		data[i].name = ""+((labelvalue)).toFixed(2)+"% - "+data[i].name+"";
	}
 			 if(rep_type == 0)
			{
				var divid="barChartContainer";
				var heading = "Top 10 Products";
				var animation=true;
			}
			else
			{
				var divid="barChartContainer_"+duration;
				var heading = "";
				var animation=false;
			}
 		  
			var chart = new CanvasJS.Chart(divid,
			{
			  title:{

				text: heading,
				fontFamily: "Helvetica",
				fontWeight: "normal"
			  },
			  
		
			  legend:{
				verticalAlign: "center",
				horizontalAlign: "right",
				fontFamily: "Helvetica",
				fontSize:13
			  },
			  animationEnabled: animation,
			  zoomEnabled: true,
			  data: [
			  {
				//startAngle: 45,
			   indexLabelFontSize: 9,
			   indexLabelFontFamily: "Helvetica",
			   indexLabelFontColor: "darkgrey",
			   indexLabelLineColor: "darkgrey",
			   //indexLabelPlacement: "inside",
			   type: "doughnut",
			   
			    /*type: "pie",*/
			   showInLegend: true,
			   dataPoints: data 
			 }
			 ]
		   });
           chart.render();
}

function exportReport()
{
	var img7,img9,img11,img13 ="";
	for(var i=1; i<5; i++)
 		durationReport(i,9);
	pagePrint();
}

 
/*function drawLogo(cus_default_group)
{
	var c = document.getElementById("report_logo");//kobster logo
	var ctx = c.getContext("2d");
	var img = document.getElementById("kobster_logo");
	ctx.drawImage(img, 10, 10);
	var cus = document.getElementById("cus_logo");//customer default group logo
	var ctx = cus.getContext("2d");
	if(rm_portal ==1)
	{
		var img_logo = document.getElementById("customer_logo");
	}
	else
	{
		
		var img_logo = document.getElementById("corporate-logo");
	}
	ctx.drawImage(img_logo, 10, 10);
}*/
 
function pagePrint()
{
	var can = document.getElementsByTagName("canvas");
    var logo = document.getElementById("report_logo");
	var customer_logo = document.getElementById("cus_logo");
	if(rm_portal !=1)
	{
		var img7    = can[6].toDataURL("image/png");
		var img9   = can[8].toDataURL("image/png");
		var img11   = can[10].toDataURL("image/png");
		var img13   = can[12].toDataURL("image/png");
	}
	else
	{
		var img7    = can[2].toDataURL("image/png");
		var img9   = can[4].toDataURL("image/png");
		var img11   = can[6].toDataURL("image/png");
		var img13   = can[8].toDataURL("image/png");
	}
	/*var kobster_logo = logo.toDataURL("image/png");
	var cusotmer_logo = customer_logo.toDataURL("image/png");
	var category_name = $('#category_id option:selected').text();*/
	
	var doc = new jsPDF();
	var report_type = $('#report_type').val();
	var height=125;
	var width=180;
	if(report_type == 1)
	{
		var name="History";
		height=80;
		width=180;
	}
	else if(report_type == 2)
		var name="Category";
	else if(report_type == 3)
		var name="Top 10 Products";
	else if(report_type == 4)
		var name="Location Based";
	else if(report_type == 5)
		var name = ''+category_name+' Category';
	var no_record_found= 'No Rececord found in last 3 Months';
 	/*Page 1*/
	/*Header*/
	/*doc.addImage(kobster_logo,'PNG',3, 1,50,30);
	doc.addImage(cusotmer_logo,'PNG',185, 1,55,30);*/
	/*End Header*/
	doc.setTextColor('#0086dc');
	doc.setDrawColor(176,176,176);
	doc.line(5, 20, 200, 20);
	doc.setLineWidth(1);
	doc.setFontSize(16);
 	doc.text(70, 35, ''+name+' Report Last 3 Months');
	if(img7=="")
		doc.text(30, 60,no_record_found);
	else
		doc.addImage(img7, 'PNG', 10, 40,width,height);
	
 	doc.text(70, 165, ''+name+' Report Last 6 Months');
	if(img9=="")
		doc.text(30, 190,no_record_found);
	else
		doc.addImage(img9, 'PNG', 10, 170,width,height);
	
	
 	doc.line(5, 285, 200, 285);
	doc.setLineWidth(1);
	doc.setTextColor(176,176,176);
	/*Footer*/
	doc.setFontSize(12);
	doc.text(90, 290, 'kobster.com');
	doc.addPage();
	/*End Footer*/
	
	/*page 2*/
	/*Header*/
	/*doc.addImage(kobster_logo,'PNG',3, 1,50,30);
	doc.addImage(cusotmer_logo,'PNG',185, 1,55,30);*/
 	/*End Header*/
	doc.setTextColor('#0086dc');
	doc.setDrawColor(176,176,176);
	doc.line(5, 20, 200, 20);
	doc.setLineWidth(1);
 	doc.setFontSize(16);
	doc.text(70, 35, ''+name+' Report Last 1 Year');
	if(img11=="")
		doc.text(30, 60,no_record_found);
	else
		doc.addImage(img11, 'PNG', 10, 40,width,height);
	
 	doc.text(70, 165, ''+name+' Report Till date');
	if(img13=="")
		doc.text(30, 190,no_record_found);
	else
		doc.addImage(img13, 'PNG', 10, 170,width,height);
	
	
	/*doc.addImage(img11, 'PNG', 10, 40,width,height);
 	doc.text(70, 165, ''+name+' Report Till date');
	doc.addImage(img13, 'PNG', 10, 170,width,height);*/
	doc.setDrawColor(176,176,176);
 	doc.line(5, 285, 200, 285);
	doc.setLineWidth(1);
	doc.setTextColor(176,176,176);
	/*Footer*/
	doc.setFontSize(12);
	doc.text(90, 290, 'kobster.com');
	/*End Footer*/
    doc.save(""+name+" Report.pdf");
	
} 
function columnChart(data,duration,rep_type,category_name)
{
	var totalvalue=0;
	/*for (var i=0; data.length > i ; i++)
	{
		data[i].y = parseFloat(data[i].y);
	}*/
 	for (var i=0; data.length > i ; i++)
	{
		totalvalue += parseFloat(data[i].y);
		data[i].label =data[i].indexLabel;

	}
	for (var i=0; data.length > i ; i++)
	{
		var labelvalue= data[i].y / totalvalue * 100;
		data[i].indexLabel = ""+data[i].indexLabel+" - "+Math.round(labelvalue)+"%" ;
		data[i].label =data[i].indexLabel ;
	}
	 if(rep_type == 0)
	{
		var divid="top_10_product_in_cate";
		var heading = "Top 10 products in "+category_name+" Category";
		var animation=true;
	}
	else
	{
		var divid="top_10_product_in_cate_"+duration;
		var heading = "";
		var animation=false;
	}
	var chart = new CanvasJS.Chart(divid, {

	
	
     title:{
			text: heading,
			fontFamily: "Helvetica",
			fontWeight: "normal"
		  },
	  
	  animationEnabled: animation,
      data: [//array of dataSeries              
        { //dataSeries object

         /*** Change type "column" to "bar", "area", "line" or "pie"***/
         type: "pie",
         dataPoints: data
       }
       ]
     });

    chart.render();
}

 /*function selectCategoryReport()
 {
	 
 }*/
 