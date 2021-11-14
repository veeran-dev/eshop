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
function durationReport(duration,rep_type)
{
	//alert("duration"+rep_type);
 	var report_type = $('#report_type').val();
	var address = $('#addressId').val();
  	if(report_type==1)
	{
		history(duration,address,rep_type);
	}
	if(report_type==2 || report_type==5)
	{
		
		category(duration,address,rep_type);
	}
	if(report_type==3)
	{
 		topProducts(duration,address,rep_type);
	}
	if(report_type==4)
	{
 		locationBasedReports(duration,address,rep_type);
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
	$('#locationBasedReport').hide();
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
 				 	lineChart(data,rep_type);
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
	$('#locationBasedReport').hide();
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
					doughnutChart(data,rep_type);
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
	$('#locationBasedReport').hide();
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
					$("#barChartContainer").html('');
					barChart(data,rep_type);
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
	$('#locationBasedReport').show();
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
					$("#locationBasedReport").html('');
					locationBasedChart(data,rep_type);
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
	if(rep_type == 0)
	{
		var chart = new CanvasJS.Chart("spinContainer",
		{
		  title:{
			text: "Monthly Spends Report",
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

	
	}
	else
	{
		var divid="spinContainer_"+rep_type;
		//alert(divid);
		var chart = new CanvasJS.Chart(divid,
		{
		  title:{
			text: "Monthly Spends Report",
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

		
	}
	chart.render();
	//chart.exportAsPDF();
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
	if(rep_type == 0)
	{
		var chart = new CanvasJS.Chart("chartContainer",
		{
		  title:{
			text: "Category Wise Split-Up",
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
	}
	else
	{	
		var divid="chartContainer_"+rep_type;
		var chart = new CanvasJS.Chart(divid,
		{
		  title:{
			text: "Category Wise Split-Up",
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
	}
	
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
	var chart = new CanvasJS.Chart("locationBasedReport",
	{
	  title:{
		text: "Location Wise Split-Up",
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
			var chart = new CanvasJS.Chart("barChartContainer",
			{
			  title:{

				text: "Top 10 Products",
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
          chart.render();
}
function monthlyReports(data)
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
		//var arraycount=data.length;
		if(data[i].length==0)
		{
					
			electronics[i]={y:0,label:data[6][i]};
			supplies[i]={y:0,label:data[6][i]};
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
				//if(data[count][j])
//				var object = {};
//				//alert(data[j].length+""+data[i].length);
//				//alert(data[i][j].y);
//				if(data[count][j].length ==0 )
//				{
//					
// 					object={y:0};
//					monthlyReport[i][j]=object;
//					
//				}	
//				else
//				{
//					object={y:data[i][j]};
//					monthlyReport[i][j]=object;
//					//var y = data[i][j].y;
//					//alert("else"+y);
//					//data[i][j].indexLabel 
//					//console.log(data[i][j].y +data[i][j].indexLabel +data[i][j].label);
//				}
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
      }, {        
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
      }

      ]
    });
    chart.render();
  
}
function exportReport()
{
	for(var i=1; i<5; i++)
	{
		//alert("i-"+i);
		durationReport(i,i);
		
	}
	pagePrint();
}

function pagePrint()
{
	var can = document.getElementsByTagName("canvas");
    
	var img1    = can[0].toDataURL("image/png");
	var img2    = can[1].toDataURL("image/png");
	var img3    = can[2].toDataURL("image/png");
	var img4    = can[3].toDataURL("image/png");
	var img5    = can[4].toDataURL("image/png");
	var img6   = can[5].toDataURL("image/png");
	var img7    = can[6].toDataURL("image/jpeg");
	var img8   = can[7].toDataURL("image/png");
	var img9   = can[8].toDataURL("image/jpeg");
	var img10   = can[9].toDataURL("image/png");
	var img11   = can[10].toDataURL("image/jpeg");
	var img12   = can[11].toDataURL("image/png");
	var img13   = can[12].toDataURL("image/jpeg");
	var img14   = can[13].toDataURL("image/png");
	
	
	
/*	var type=99;
 var dataparam= '&img='+img7;
 //alert(dataparam);
 	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'report-pdf.php',
			data: dataparam,
			cache: false,
			success: function()
			{	
				
				
			}
	 });*/
	//var imgdata=img7;
	//alert(imgdata);
	//return false;
 
	
	/* var popupWin = window.open('', '_blank', 'width=500,height=800');
       popupWin.document.open();
	   
	  $('#print_button').show();
	  var testing='<html><body><div style="overflow:scroll;"><div class="printReportHeading">History report Last 3 Months</div></br><img src="'+img7+'"/></br><div class="printReportHeading">History report Last 6 Months</div></br><img src="'+img9+'"/></br><div class="printReportHeading">History report Last 1 Year</div></br><img src="'+img11+'"/></br><div class="printReportHeading">History report till date</div></br><img src="'+img13+'"/></br><input type="button" id="print_button" onclick="print();" value="Print Report"><input type="button" id="print_pdf_button" onclick="generatePDF();" value="Print PDF Report"></div></body></html>';
	    popupWin.document.write(testing);
	   //popupWin.document.write('<html><body>History report from begining<img src="'+img5+'"/></br>History report Last 3 Months<img src="'+img5+'"/></br>History report Last 6 Months<img src="'+img5+'"/></br>History report Last 1 Year<img src="'+img5+'"/></br><input type="button" onclick="print();"></body></html>');
	   var dataparam= '&testing='+testing;
// alert(dataparam);
 //return false;
 	 $.ajax({
			type: 'POST',
			async: false,
			dataType:'json',
			url: 'report-pdf.php',
			data: dataparam,
			cache: false,
			success: function()
			{	
				
				
			}
	 });
	/*document.close();*/
	var doc = new jsPDF();
	/*doc.setDrawColor(0);
	doc.setFillColor(238, 238, 238);*/
	//var test = img7;
	doc.text(75, 10, 'History report Last 3 Months');
	doc.addImage(img7, 'JPEG', 10, 15,190,70);
	//doc.addPage();
	doc.text(75, 95, 'History report Last 6 Months');
	doc.addImage(img9, 'JPEG', 10, 100,190,70);
	doc.text(75, 180, 'History report Last 1 Year');
	doc.addImage(img11, 'JPEG', 10, 185,190,70);
	doc.addPage();
	doc.text(75, 10, 'History report till date');
	doc.addImage(img13, 'JPEG', 10, 15,190,70);
      doc.save("Reports.pdf");
	/*doc.text(20, 20, 'Hello world!');
	doc.addImage(test,'PNG', 15, 40, 200, 114);
	doc.text(20, 30, 'This is client-side Javascript, pumping out a PDF.21321');*/
	//doc.addImage("http://localhost/kobstereshop/img/scn_logo.PNG", 'PNG', 15, 40, 180, 180);
	
	//doc.addPage();
	// Output as Data URI0
	//doc.output('datauri');
} 


 
