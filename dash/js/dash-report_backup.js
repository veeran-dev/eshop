$(document).ready(function()
{ 
	var report_type = $('#report_type').val();
	var duration=0;
	if(report_type==1)
	{
 		history(duration,0,0);
		
	}
	if(report_type==2)
	{
		
		category(duration,0,0);
	}
	if(report_type==3)
	{
 		topProducts(duration,0,0);
	}
	if(report_type==4)
	{
 		locationBasedReports(duration,0,0);
	}
	if(report_type!=4)
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
								{ 
									$("#orderid").append("<option value='"+data[0][i]['orderid']+"'>"+data[0][i]['orderdate']+"|"+data[0][i]['orderid']+"|"+data[0][i]['totalvalue']+"</option>");
								}
								/*for(var i = 0; data[1].length>i; i++ )
								{ 
									$("#addressId").append("<option value='"+data[1][i]['id_address']+"'>"+data[1][i]['alias']+" </option>");
								}*/
							}
				 });
	}
});
function durationReport(duration)
{
	//alert("duration"+rep_type);
 	var report_type = $('#report_type').val();
	var address = $('#addressId').val();
   	if(report_type==1)
	{
		history(duration,address);
	}
	if(report_type==2 || report_type==5)
	{
		
		category(duration,address);
	}
	if(report_type==3)
	{
 		topProducts(duration,address);
	}
	if(report_type==4)
	{
 		locationBasedReports(duration,address);
	}
	if(duration==5)
	{
  		$('#addressId').val(0);
	}
	if(duration==0)
	{
  		$("#orderid").val(0);
	}
}
 function history(duration,address,rep_type)
{
	//alert("history"+rep_type);
	var address = $('#addressId').val();
   	$('#history_report').show();
 	$('#categories_report').hide();
	$('#topproducts_report').hide();
	$('#locationBasedReport_div').hide();
	$('#address_filter').hide();
	$('.repo_filter').hide();
	 var report_type = $('#report_type').val();
	 var type=1;
	 var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+duration+'&addressId='+address;
    	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
  				if(data !="")
				{
					if(rep_type==0)
						$("#spinContainer").html('');
					//alert("history data"+type);
 				 	lineChart(data,duration);
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
					 //$("#loading_img").hide();
					 //alert("No records has been found as per your request");
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
	$('.repo_filter').show();
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
			cache: false,
			success: function(data)
			{	
				if(data !="")
				{
					if(rep_type==0)
						$("#chartContainer").html('');
					doughnutChart(data,duration);
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
					// alert("No records has been found as per your request");
					//return false;
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
	$('.repo_filter').hide();
	$('#address_filter').hide();
	var address = $('#addressId').val();
	var type=4;
	var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+duration+'&addressId='+address/*+'&orderid='+orderid*/;
 	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
 				if(data !="")
				{
					if(rep_type==0)
						$("#barChartContainer").html('');
					barChart(data,duration);
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
					// alert("No records has been found as per your request");
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
	$('.repo_filter').hide();
	$('#address_filter').hide();
	var address = $('#addressId').val();
	var type=6;
	var dataparam= '&type='+type+'&customerid='+id_customer+'&duration='+duration+'&addressId='+address;
 	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'dash-reports.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
				//console.log(data);
 				if(data !="")
				{
					if(rep_type==0)
						$("#locationBasedReport").html('');
					locationBasedChart(data,duration);
				}
				 else
				 {
					 var alertmsg = "No records has been found as per your request";
					 $("#idGlobalAlert").html(alertmsg);
					 $('#globalAlert').modal('show');
					 //alert("No records has been found as per your request");
					 return false;
				 }
				
			}
	 });
 }
 /*function monthlyCategories()
 {
	 $('#history_report').hide();
	$('#categories_report').hide();
	$('#topproducts_report').hide();
	$('#monthlyCategory_report').show();
	var type=6;
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
			//console.log(data);
			monthlyReports(data);
 				 
				
			} 
	 });
 }*/
function lineChart(data,rep_type)
{
 	//alert("line /"+rep_type);
	for (var i=0; data.length > i ; i++)
	{
		data[i].y = parseFloat(data[i].y);
	}
	//var type =0;
	/*if(rep_type == 0)
	{*/

		if(rep_type == 0)
		{
			var divid="spinContainer";
			var heading = "Monthly Spends Report";
		}
		else
		{
			var divid="spinContainer_"+rep_type;
			var heading = "";
		}
		var chart = new CanvasJS.Chart("spinContainer",
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

	
	/*}
	else
	{
		var divid="spinContainer_"+rep_type;
		//alert(divid);
		var chart = new CanvasJS.Chart(divid,
		{
		  title:{
			/*text: "Monthly Spends Report",*/
			/*fontFamily: "Helvetica",
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

		
	}*/
	chart.render();
}
function doughnutChart(data,rep_type)
{
	//console.log(data);
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

	//alert(totalvalue);
	/*if(rep_type == 0)
	{*/
		if(rep_type == 0)
		{
			var divid="chartContainer";
			var heading = "Category Wise Split-Up";
		}
		else
		{
			var divid="chartContainer_"+rep_type;
			var heading = "";
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
	/*}
	else
	{	
		var divid="chartContainer_"+rep_type;
		var chart = new CanvasJS.Chart(divid,
		{
		  title:{
			/*text: "Category Wise Split-Up",*/
			/*fontFamily: "Helvetica",
			fontWeight: "normal"
		  },

		  legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		  },
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
	}*/
	
	chart.render();
}
function locationBasedChart(data,rep_type)
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
	//alert(totalvalue);
	if(rep_type == 0)
	{
		var divid="locationBasedReport";
		var heading = "Location Wise Split-Up";
	}
	else
	{
		var divid="locationBasedReport_"+rep_type;
		var heading = "";
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
		  data: [
		  {
			//startAngle: 45,
		   indexLabelFontSize: 13,
		   indexLabelFontFamily: "Helvetica",
		   indexLabelFontColor: "darkgrey",
		   indexLabelLineColor: "darkgrey",
		   indexLabelPlacement: "outside",
		   type: "pie",
		   showInLegend: false,
		   dataPoints: data 
		 }
		 ]
	   });
	/*}
	else
	{
		var divid="locationBasedReport_"+rep_type;
		var chart = new CanvasJS.Chart(divid,
		{
		  title:{
			/*text: "Location Wise Split-Up",*/
			/*fontFamily: "Helvetica",
			fontWeight: "normal"
		  },

		  legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		  },
		  data: [
		  {
			//startAngle: 45,
		   indexLabelFontSize: 13,
		   indexLabelFontFamily: "Helvetica",
		   indexLabelFontColor: "darkgrey",
		   indexLabelLineColor: "darkgrey",
		   indexLabelPlacement: "outside",
		   type: "pie",
		   showInLegend: false,
		   dataPoints: data 
		 }
		 ]
	   });
	}*/
	
	
	chart.render();
	
}

function barChart(data,rep_type)
{
	//console.log(data);
	var totalvalue=0;
  	for (var i=0; data.length > i ; i++)
	{
		data[i].y = parseFloat(data[i].y);
	}
	
	for (var i=0; data.length > i ; i++)
	{
		totalvalue += parseFloat(data[i].y);
		data[i].label =data[i].indexLabel;
	}
	
	for (var i=0; data.length > i ; i++)
	{
		var labelvalue= data[i].y / totalvalue * 100;
		data[i].indexLabel = ""+data[i].indexLabel+" - "+((labelvalue)).toFixed(2)+"%" ;
		data[i].label =data[i].indexLabel ;
	}
 	/* var chart = new CanvasJS.Chart("barChartContainer", {
              theme: "theme1",//theme1
			  
              title:{
                  text: "Top 10 Purchased products "              
             },
			 axisY: {
						title: "Order Value"
					},
			 axisX: {
						title: "Products"
					},
              data: [              
              {
                   type: "column",
				  indexLabelFontSize: 10,
                  dataPoints: data  
              }
              ]
          });*/
		  /*if(rep_type == 0)
		  {*/
			 if(rep_type == 0)
			{
				var divid="barChartContainer";
				var heading = "Top 10 Products";
			}
			else
			{
				var divid="barChartContainer_"+rep_type;
				var heading = "";
			}
			//var divid="barChartContainer";
		  
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
			  data: [
			  {
				//startAngle: 45,
			   indexLabelFontSize: 13,
			   indexLabelFontFamily: "Helvetica",
			   indexLabelFontColor: "darkgrey",
			   indexLabelLineColor: "darkgrey",
			   indexLabelPlacement: "outside",
			   type: "doughnut",
			    /*type: "pie",*/
			   showInLegend: false,
			   dataPoints: data 
			 }
			 ]
		   });
		  /*}
		  else
		  {
			var divid="barChartContainer_"+rep_type;
			var chart = new CanvasJS.Chart(divid,
			{
			  title:{

				/*text: "Top 10 Products",*/
				/*fontFamily: "Helvetica",
				fontWeight: "normal"
			  },
		
			  legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center"
			  },
			  data: [
			  {
				//startAngle: 45,
			   indexLabelFontSize: 13,
			   indexLabelFontFamily: "Helvetica",
			   indexLabelFontColor: "darkgrey",
			   indexLabelLineColor: "darkgrey",
			   indexLabelPlacement: "outside",
			   type: "doughnut",
			    /*type: "pie",*/
			   /*showInLegend: false,
			   dataPoints: data 
			 }
			 ]
		   });
		  }*/
          chart.render();
}
/*function monthlyReports(data)
{
	window.monthlyReport=[];
	var electronics=new Array();
	var supplies=new Array();
	monthlyReport[0],monthlyReport[1]={};
	monthlyReport[0]={  type: "stackedColumn100",
	name: "office electronics",
	showInLegend: "true",dataPoints:electronics};
	monthlyReport[1]={  type: "stackedColumn100",
	name: "office supplies",
	showInLegend: "true",dataPoints:supplies};

	for(var i=0;i<data.length-1;i++)
	{
		if(data[i].length==0)
		{
					
			electronics[i]={y:0,label:data[6][i]};
			supplies[i]={y:0,label:data[6][i]};
			console.log(i+"gfg"+data[6][i]);
		}
		else
		{
			electronics[i]={y:0,label:data[6][i]};
			supplies[i]={y:0,label:data[6][i]};
					
			for(var j=0;j<data[i].length;j++)
			{
				if(data[i][j].indexLabel == "iPods")
				{
					electronics[i]={y:parseFloat(data[i][j].y),label:data[6][i]};									
				}
				if(data[i][j].indexLabel == "Laptops")
				{
					supplies[i]={y:parseFloat(data[i][j].y),label:data[6][i]};
				}
				
			}
		}
	}	
	monthlyReport[0]={  type: "stackedColumn100",
	name: "office electronics",
	showInLegend: "true",dataPoints:electronics};
	monthlyReport[1]={  type: "stackedColumn100",
	name: "office supplies",
	showInLegend: "true",dataPoints:supplies};
	var chart = new CanvasJS.Chart("locationBasedReport",
    {
      title:{
      text: "Month Wise split up categories"   
      },
      
      axisX:{
        title: "Months"
      },
      axisY:{
        title: "percentage"
      },
      data: [
      {        
        type: "stackedColumn100",
        name: "ipods",
        showInLegend: "true",
        dataPoints:electronics/* [
        {  y: 0, label: "Jan"},
        {  y: 0, label: "Feb" },
        {  y: 72, label: "Mar" },
        {  y: 30, label: "Apr" },
        {  y: 0, label: "May"},
		{  y: 0, label: "June"}   	           
        ]*/
     /* }, {        
        type: "stackedColumn100",        
        name: "Laptops",
        showInLegend: "true",
        dataPoints:supplies/* [
        {  y: 0, label: "Jan"},
        {  y: 14, label: "Feb" },
        {  y: 0, label: "Mar" },
        {  y: 0, label: "Apr" },
        {  y: 0, label: "May"} ,
		{  y: 0, label: "June"}               
        ]*/
     /* }

      ]
    });
    chart.render();
  
}*/
function exportReport()
{
	for(var i=1; i<5; i++)
	{
		//alert("i-"+i);
		durationReport(i);
		
	}
	
	setTimeout(function(){
		pagePrint();
	},2000);
	
}
$(document).ready(function(){
 var c = document.getElementById("report_logo");
 //alert(c);
var ctx = c.getContext("2d");
var img = document.getElementById("kobster_logo");
ctx.drawImage(img, 10, 10);
var cus = document.getElementById("cus_logo");
var ctx = cus.getContext("2d");
var img_logo = document.getElementById("corporate-logo");
ctx.drawImage(img_logo, 10, 10);
});
 
function pagePrint()
{
	var can = document.getElementsByTagName("canvas");
     var logo = document.getElementById("report_logo");
	 var customer_logo = document.getElementById("cus_logo");
	 
	var img7    = can[6].toDataURL("image/png");
 	var img9   = can[8].toDataURL("image/png");
 	var img11   = can[10].toDataURL("image/png");
 	var img13   = can[12].toDataURL("image/png");
	var kobster_logo = logo.toDataURL("image/png");
	var cusotmer_logo = customer_logo.toDataURL("image/png");
	
	 
	
 	var doc = new jsPDF();
 		 
	var report_type = $('#report_type').val();
	if(report_type == 1)
	{
		var name="History";
		 
	}
	else if(report_type == 2)
	{
		var name="Category";
	}
	else if(report_type == 3)
	{
		var name="Top 10 Products";
	}
	else if(report_type == 4)
	{
		var name="Location Based";
	
	}
	//var logo = ('http://localhost/kobstereshop/img/logo.jpeg').toDataURL("image/png");
	//doc.setFillColor='#fff';
	/*Page 1*/
	doc.addImage(kobster_logo,'PNG',3, 1,50,30);
	doc.addImage(cusotmer_logo,'PNG',185, 1,55,30);
	//var html_icontents=$('#header').html();
	
	doc.setTextColor('#0086dc');
	//doc.fromHTML(html_icontents,55,1);
	doc.setDrawColor(176,176,176);
	doc.line(5, 20, 200, 20);
	doc.setLineWidth(1);
	doc.setFontSize(16);
 	doc.text(70, 35, ''+name+' Report Last 3 Months');
	doc.addImage(img7, 'PNG', 10, 40,180,110);
 	doc.text(70, 165, ''+name+' Report Last 6 Months');
	doc.addImage(img9, 'PNG', 10, 170,180,110);
	/*doc.addPage();
	doc.text(75, 10, ''+name+' report Last 1 Year');
	doc.addImage(img11, 'PNG', 10, 15,190,90);
	
	doc.text(75, 140, ''+name+' report till date');
	doc.addImage(img13, 'PNG', 10, 145,190,90);*/
	//doc.setDrawColor(176,176,176);
	
	
	doc.line(5, 285, 200, 285);
	doc.setLineWidth(1);
	doc.setTextColor(176,176,176);
	doc.setFontSize(12);
	doc.text(90, 290, 'kobster.com');
	doc.addPage();a
	/*page 2*/
	
	doc.addImage(kobster_logo,'PNG',3, 1,50,30);
	doc.addImage(cusotmer_logo,'PNG',185, 1,55,30);
	//var html_icontents=$('#header').html();
	
	doc.setTextColor('#0086dc');
	//doc.fromHTML(html_icontents,55,1);
	doc.setDrawColor(176,176,176);
	doc.line(5, 20, 200, 20);
	doc.setLineWidth(1);
 	/*doc.text(75, 10, ''+name+' report Last 3 Months');
	doc.addImage(img7, 'PNG', 10, 15,190,90);
 	doc.text(75, 140, ''+name+' report Last 6 Months');
	doc.addImage(img9, 'PNG', 10, 145,190,90);*/
	doc.setFontSize(16);
	doc.text(70, 35, ''+name+' Report Last 1 Year');
	doc.addImage(img11, 'PNG', 10, 40,180,110);
	
	doc.text(70, 165, ''+name+' Report Till date');
	doc.addImage(img13, 'PNG', 10, 170,180,110);
	doc.setDrawColor(176,176,176);
	
	
	doc.line(5, 285, 200, 285);
	doc.setLineWidth(1);
	doc.setTextColor(176,176,176);
	doc.setFontSize(12);
	doc.text(90, 290, 'kobster.com');
	//setTimeout(function(){doc.save(""+name+" Report.pdf");},2000);
    doc.save(""+name+" Report.pdf");
	//doc.output("dataurls");
	
} 


 
