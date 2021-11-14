window.date_purchase="";
window.date_sales="";
window.requestor_name="";
window.vendor_name="";
window.fro_date="";
window.to_date="";
window.id_fc="";
window.request_status="";
window.cop_from="";
window.cop_to="";
window.group_name_selected="";
window.group_id_Selected="";
window.vpb_fpp_from="";
window.vpb_fpp_to="";
window.vpb_fpp_from="";
window.vpb_vendor_name="";
window.vpb_vendor_id="";

$(document).ready(function()
{
	var date='';
	$('.finance-slider1').bxSlider({
        slideWidth: 350,
		slideMargin: 0,
		minSlides: 3,
        maxSlides: 3,        
        moveSlides: 1,
        startSlide:count1-3,
        //height:auto,
        pager: false,
        nextText: '',
        prevText: '',
    });
    $('.finance-slider2').bxSlider({
        slideWidth: 350,
		slideMargin: 0,
		minSlides: 3,
        maxSlides: 3,        
        moveSlides: 1,
        startSlide:count2-3,
        //height:auto,
        pager: false,
        nextText: '',
        prevText: '',
    });
    
    $(".finance-sale-slider").click(function(){
    	ExcelReports();
    	date_sales = $(this).children('.month').html();    	
    });
    $(".finance-purchase-slider").click(function(){
    	ExcelReports();
    	date_purchase = $(this).children('.month').html();
    });
	var orderids=[];
	var c_inv_fc_id='';

	$(document).on('click', '#genereteMasterSalesReport',function(){
		var salesReport_from = $('#sale_from').val();
		var salesReport_to = $('#sale_to').val(); 
		if(!salesReport_to || !salesReport_from){
			toast('Enter Valid Date','warning');
			return false;
		}
		$('#master-sales-hidden-data').empty();
		$('#master-sales-hidden-data').append('<input id="from" type="text" name="from" value="' + salesReport_from + '"><input id="to" type="text" name="to" value='+salesReport_to+'>');
		$('#master_sales_report_excel').submit();
	});

	$(document).on('click', '#genereteRateContractReport',function(){
		$status = $('#group_selection_rc_status').val();
		$id_group = $('#group_selection_rc').val();
		$('#rate-contract-hidden-data').empty();
		$('#rate-contract-hidden-data').append('<input id="from" type="text" name="status" value="' + $status + '">\
			<input id="to" type="text" name="id_group" value=' + $id_group + '>');
		$('#rate_contract_report_excel').submit();
	});


	$(document).on('click', '#searchVatButton', function() {
		var order_id=$("#order_id").val();
		if(!order_id)
		{
			toast("Enter Valid Order ID","warning");
			return false;
		}
		$('#index_viewport').html('');
    	$('#index_viewport').load('finance-vat.php?order_id='+order_id);
	});
	$(document).on('click', '.checkbox', function() {
		if($(this).is(':checked'))
		{
			$(this).closest("tr").find(".item_rate_select").show();
			$(this).closest("tr").find(".item_rate").hide();
		}
		else
		{
			$(this).closest("tr").find(".item_rate_select").hide();
			$(this).closest("tr").find(".item_rate").show();
		}
	});
	$(document).on('click', '#vat_save_changes', function() {
		var values = [];
		var order_id=$("#order_id").val();
		$.each($("input[name='check[]']:checked").closest("tr").find(".vat_rate_td"),
		       function () {
		       		var tax_id=$(this).find('option:selected').val();
		            values.push(tax_id);
		       });
		if(values.length === 0)
		{
			toast("Please select options","warning");
		}
		var dataparam = 'values='+values+'&id_order='+order_id;
		$(".ajaxLoaderModal").show();
		$.ajax
		({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'finance-vat.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
				if(data==1)
				{
					toast("TAX Updated successfuly","success");
					$("#searchVatButton").click();
				}
				else if(data==2)
				{
					toast("Error in updating TAX","warning");
				}
			}
		});
		$(".ajaxLoaderModal").hide();
	});
	$(document).on('click', '#searchInvoiceButton', function() {
		orderids=[];
		c_inv_fc_id='';
		var type =4;
		var id_group=$("#group_selection option:selected").val();
		var id_state=$("#address_selection option:selected").val();
		var dataparam = '&type=' + type+'&id_group='+id_group+'&id_state='+id_state;
		$(".ajaxLoaderModal").show();
		$.ajax
		({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'finance-invoice-controller.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
				$("#consolidate_invoice_table").removeClass("successSearch");
				var code='';
				for(var i=0;i<data.length;i++)
				{
					code +="<tr id="+data[i].id_fc+">";
					code +="<td><input type='checkbox' class='orderid_checkbox' id="+data[i].id_order+"></td>";
                    code +="<td>"+data[i].id_order+"</td>";
                    code +="<td>"+data[i].city_name+"</td>";
					code +="<td>"+data[i].name+"</td>";
                    code +="<td>"+data[i].payment+"</td>";
                    code +="<td>"+data[i].date_add+"</td>";
                    code +="</tr>";
				}
				$("#finance_invoice_table").html(code);
				easySearchOrg('consolidate_invoice_table');
				$("#gen_cons_inv").removeClass("successSearch");
			}
		});
		$(".ajaxLoaderModal").hide();

	});
	$(document).on('change', '.orderid_checkbox', function() {
		if(this.checked)
		{
			if(!c_inv_fc_id)
			{
				c_inv_fc_id=$(this).parent().parent()[0].id;
			}
			else
			{
				if(orderids.length==0)
				{
					c_inv_fc_id=$(this).parent().parent()[0].id;
				}
				else if(c_inv_fc_id!=$(this).parent().parent()[0].id)
				{
					toast("Orders from different fulfillment centre are not valid","warning");
					$(this).attr('checked', false);
					return false;
				}
			}

			orderids.push(this.id);
		}
		else
		{
			var index = orderids.indexOf(this.id);
			if (index >= 0) {
			  orderids.splice( index, 1 );
			}
		}		
	});

	$("#gen_cons_inv").live("click", function() {
		$("#gen_cons_inv").prop('disabled', 'true');
		if(orderids.length==0)
		{
			toast("Please select orders","warning");
			$("#gen_cons_inv").removeAttr('disabled');
			return false;
		}
		var dataparam = '&type=5&orderids='+orderids;
		$(".ajaxLoaderModal").show();
		$.ajax
		({
			type: 'POST',
			//dataType:'json',
			async: true,
			url: 'finance-invoice-controller.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
							
				if(!isNaN(data.substr(0,1)))
				{
					toast("Orders not delivered completely ","warning");
					$("#gen_cons_inv").removeAttr('disabled');
				}
				else
				{
					orderids=[];
					$("#gen_cons_inv").removeAttr('disabled');	
					generate_invoice();
					$("#gen_cons_inv").addClass("successSearch");
					window.open(baseDir+data);	
				}
				

			}
		});
		$(".ajaxLoaderModal").hide();
	});
});

function easySearchOrg(table_id)
{		
	var oTable = $('#'+table_id).dataTable({
		"aLengthMenu": [
			/*[25, 50, 100, -1],
			[25, 50, 100, "All"]*/ // change per page values here
			[10, 50, 100, -1],
			[10, 50, 100, "All"]
		],
		"bRetrieve": true,
		"bDestroy": true,
        
		// set the initial value
		"iDisplayLength": 10,
		
		"sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page",
			"oPaginate": {
				"sPrevious": "Prev",
				"sNext": "Next"
			}
		},			

		"aoColumnDefs": [{
				'bSortable': true,
				'aTargets': []
			}
		],
		"aaSorting": []
	});
				 
}


function easySearch(table_id)
{		
	var oTable = $('#'+table_id).dataTable({
		"aLengthMenu": [
			/*[25, 50, 100, -1],
			[25, 50, 100, "All"]*/ // change per page values here
			[10, 50, 100, -1],
			[10, 50, 100, "All"]
		],
		// set the initial value
		"iDisplayLength": 10,
		
		
		"sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page ",
			"oPaginate": {
				"sPrevious": "Prev",
				"sNext": "Next"
			}
		},			

		"aoColumnDefs": [{
				'bSortable': true,
				'aTargets': [0]
			}
		],
		"fnFooterCallback": function (nRow, aasData, iStart, iEnd, aiDisplay) {

        var columnas = [5]; //the columns you wish to add            
        for (var j in columnas) {
			
            var columnaActual = columnas[j];

            var total = 0;
            for (var i = iStart; i < iEnd; i++) {
 				var str = aasData[aiDisplay[i]][columnaActual];
				str = str.replace("Rs.",""); 
				var res = str.replace(",",""); 
                total = total + parseFloat(res);
				
            }
              $($(nRow).children().get(columnaActual)).html(moneyFormat(total));

        } 
		}
		
	});
				 
}

function easySearchProcurement(table_id)
{		
	var oTable = $('#'+table_id).dataTable({
		"aLengthMenu": [
			/*[25, 50, 100, -1],
			[25, 50, 100, "All"]*/ // change per page values here
			[10, 50, 100, -1],
			[10, 50, 100, "All"]
		],
		// set the initial value
		"iDisplayLength": 100,
		
		
		"sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page ",
			"oPaginate": {
				"sPrevious": "Prev",
				"sNext": "Next"
			}
		},			

		"aoColumnDefs": [{
				'bSortable': true,
				'aTargets': [0]
			}
		],
		"fnFooterCallback": function (nRow, aasData, iStart, iEnd, aiDisplay) {

        var columnas = [4]; //the columns you wish to add            
        for (var j in columnas) {
			
            var columnaActual = columnas[j];

            var total = 0;
            for (var i = iStart; i < iEnd; i++) {
 				var str = aasData[aiDisplay[i]][columnaActual];
				str = str.replace("Rs.",""); 
				var res = str.replace(",",""); 
                total = total + parseFloat(res);
				
            }
              $($(nRow).children().get(columnaActual)).html(moneyFormat(total));

        } 
		}
		
	});
				 
}

function getCustomerList(page){
	$(".ajaxLoaderModal").show();
 	$.ajax({
			type: 'POST',
			async: true,
			url: 'rm-getCustomerList.php',
			dataType:'json',
			cache: true,
			
			success: function(data)
			{
				for(var i=0; data.length > i; i++)
				{
					if(page==1)
						$("ul#lists").append("<li><a onClick='selectCustomer(this,1,0,"+data[i].default_group+");' id=" + data[i].id_customer + ">" + data[i].name + "</a></li>");					
 				}
			}
	});
	$(".ajaxLoaderModal").hide();
}

 
 

 
/*To get all the order durations for a particular RM */
$(document).ready(function()
{

 	getCustomerOrders(0,0);
  });

/*get the orders and its details using  duration and status*/
function openCustmomerDetails(duration,order_status)
{
	var type=2;
	var id_employee = 0;
	var dataparam = '&id_employee='+ id_employee+'&type=' + type+'&order_status=' + order_status+'&duration=' + duration;
	$(".ajaxLoaderModal").show();
 	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'scn-orderstatus.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
 			if(data !="")
			{
				$("#status_orders").html('');
				$("#modal-heading").html('Order Details');
				for(var i=0; i<data[0].length; i++)
				{
				  $("#status_orders").append("<tr><td><a target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[0][i].orderid+"&vieworder&token="+data[1]+"'>"+data[0][i].orderid+"</a></td><td>"+data[0][i].firstname+"</td><td>"+data[0][i].total_paid+"</td><td>"+data[0][i].name+"</td><td>"+data[0][i].DATE_ADD+"</td></tr>");
				}
			}
			else
			{
				$("#modal-heading").html('No Orders to Show');
				$("#status_orders").html('');
			}
			$('#rm_customer_order').modal('show');
		}
		
	});
	$(".ajaxLoaderModal").hide();
}


function getCustomerOrders(page,status)
{
	/*var current_time = new Date();
  	var hours = new Date().getHours();
    var hours = (hours+24)%24; 
    var mid='am';
    if(hours==0) //At 00 hours we need to show 12 am
    	hours=12;
    else if(hours>12)
	{
		hours=hours%12;
		mid='pm';
    }
 	$('#refreshtiming').html(hours + ":" + current_time.getMinutes() + ":" + current_time.getSeconds()+ "  "  + mid);
	
 	
	
	if(page==1)
	{
		$.ajaxSetup({
 			global: false,
 		});
	}
	else
	{
		$.ajaxSetup({
 			global: true,
 		});
	}*/
	var type=1;
	var dataparam = '&type=' + type+'&page=' + page;
 	$(".ajaxLoaderModal").show();
	$.ajax
	({
			type: 'GET',
			dataType:'json', 
			async: true,
			url: 'finance-indexdata.php',
 			data: dataparam,
			cache: true,
 			success: function(data)
			{
   				if(page != 1)
				{
					for(var i=0; data[0].length> i; i++ )
					{
						if(data[0][i] == data[0][0])
							$("#payment_pending").html(moneyFormat(data[0][0].total));
						else if(data[0][i] == data[0][1])
							$("#invoice_gen_pending").html(moneyFormat(data[0][1].total));
						else if(data[0][i] == data[0][2])
							$("#invoice_sub_pending").html(moneyFormat(data[0][2].total));
					}
 					for(var j=0; data[1].length> j; j++ )
					{
 						if(data[1][j] ==  data[1][0])
						 $("#net_sales").html(moneyFormat(data[1][0].total_value));
					 
						else if(data[1][j] == data[1][1] )
						 $("#last_mon_sales").html(moneyFormat(data[1][1].total_value));
					}
					
 				  
					 if(data[2].length >0)
					 {
						$("#finance_procurement_details").html('');
						 for(var i = 0; i<data[2].length; i++)
						 {
							$("#finance_procurement_details").append("<tr><td><a class='cur_poi' target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[2][i].id_order+"&vieworder&token='>"+data[2][i].id_order+"</a></td><td>"+data[2][i].firstname+"</td><td>"+data[2][i].city_name+"</td><td>"+moneyFormat(data[2][i].total_paid)+"</td></tr>");
						 }
						 $("#finance_procurement_details").append("<tr><td colspan=4  style='text-align:right'><button class='btn btn-info btn-xs' onclick='fianance_procurement();' type='button'>View More...</button></td></tr>");
					 }
				}
				else//view all the pending order in finance-orders.tpl
				{
					 if(data.length >0)
					 {
						$("#finance_order").html('');
						var sno = 0,name;
						
						if(status==1)
					 	{
					 		for(var i = 0; i<data.length; i++)
							 {
							 	if(data[i].state == 37)
							 	{
								 	sno++;
									if(data[i].state == 35)
										name = "Pending_payment";
									else if(data[i].state == 39)
										name = "Invoice_Submission_Pending";
									else if(data[i].state == 37)
										name = "Pending_Invoice";
									
									if(data[i].state!=35 )
										data[i].bill_age="NOT GENERATED";
									else if(data[i].state==35 && data[i].credit_days!=0)
									{
										if(data[i].bill_age>0)
											data[i].bill_age ="<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-primary' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
										else if(data[i].bill_age<=0)
											data[i].bill_age = "<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-danger' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
									}
									else if(data[i].credit_days==0)
										data[i].bill_age="credit days not available";

									$("#finance_order").append("<tr><td>"+sno+"</td><td><a class='cur_poi' target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[i].id_order+"&vieworder&token='>"+data[i].id_order+"</a></td><td>"+data[i].firstname+"</td><td>"+name+"</td><td>"+data[i].bill_age
										+"</td><td>"+moneyFormat(data[i].total)+"</td></tr>");
							 	}
							}
						 
					 	}
					 	else if(status==2)
					 	{
					 		
					 		for(var i = 0; i<data.length; i++)
							 {
							 	if(data[i].state == 39)
							 	{
								 	sno++;
									if(data[i].state == 35)
										name = "Pending_payment";
									else if(data[i].state == 39)
										name = "Invoice_Submission_Pending";
									else if(data[i].state == 37)
										name = "Pending_Invoice";
									
									if(data[i].state!=35 )
										data[i].bill_age="NOT GENERATED";
									else if(data[i].state==35 && data[i].credit_days!=0)
									{
										if(data[i].bill_age>0)
											data[i].bill_age ="<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-primary' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
										else if(data[i].bill_age<=0)
											data[i].bill_age = "<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-danger' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
									}
									else if(data[i].credit_days==0)
										data[i].bill_age="credit days not available";

									$("#finance_order").append("<tr><td>"+sno+"</td><td><a class='cur_poi' target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[i].id_order+"&vieworder&token='>"+data[i].id_order+"</a></td><td>"+data[i].firstname+"</td><td>"+name+"</td><td>"+data[i].bill_age
										+"</td><td>"+moneyFormat(data[i].total)+"</td></tr>");
							 	}
							}
						 
					 	}
					 	else if(status==3)
					 	{
					 		
					 		for(var i = 0; i<data.length; i++)
							 {
							 	if(data[i].state == 35)
							 	{
								 	sno =sno+1;
									if(data[i].state == 35)
										name = "Pending_payment";
									else if(data[i].state == 39)
										name = "Invoice_Submission_Pending";
									else if(data[i].state == 37)
										name = "Pending_Invoice";
									
									if(data[i].state!=35 )
										data[i].bill_age="NOT GENERATED";
									else if(data[i].state==35 && data[i].credit_days!=0)
									{
										if(data[i].bill_age>0)
											data[i].bill_age ="<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-primary' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
										else if(data[i].bill_age<=0)
											data[i].bill_age = "<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-danger' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
									}
									else if(data[i].credit_days==0)
										data[i].bill_age="credit days not available";

									$("#finance_order").append("<tr><td>"+sno+"</td><td><a class='cur_poi' target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[i].id_order+"&vieworder&token='>"+data[i].id_order+"</a></td><td>"+data[i].firstname+"</td><td>"+name+"</td><td>"+data[i].bill_age
										+"</td><td>"+moneyFormat(data[i].total)+"</td></tr>");
							 	}
							}
						 
					 	}
					 	else
					 	{
					 		
					 		for(var i = 0; i<data.length; i++)
							 {
								 	sno =sno+1;
									if(data[i].state == 35)
										name = "Pending_payment";
									else if(data[i].state == 39)
										name = "Invoice_Submission_Pending";
									else if(data[i].state == 37)
										name = "Pending_Invoice";
									
									if(data[i].state!=35 )
										data[i].bill_age="NOT GENERATED";
									else if(data[i].state==35 && data[i].credit_days!=0)
									{
										if(data[i].bill_age>0)
											data[i].bill_age ="<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-primary' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
										else if(data[i].bill_age<=0)
											data[i].bill_age = "<span id='creditDays_"+data[i].id_order+"'>"+data[i].bill_age+"</span>&nbsp&nbsp&nbsp&nbsp<span class='fa fa-hand-o-left cur-poi btn btn-danger' onclick='orderCredit("+data[i].id_order+","+data[i].credit_days+")'></span>";
									}
									else if(data[i].credit_days==0)
										data[i].bill_age="credit days not available";

									$("#finance_order").append("<tr><td>"+sno+"</td><td><a class='cur_poi' target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[i].id_order+"&vieworder&token='>"+data[i].id_order+"</a></td><td>"+data[i].firstname+"</td><td>"+name+"</td><td>"+data[i].bill_age
										+"</td><td>"+moneyFormat(data[i].total)+"</td></tr>");
							 
							}
						 
					 	}
						easySearch('finance_order_list');
						 
					 }
				}
				 
						
				
			}
	});
	$(".ajaxLoaderModal").hide();
}

function orderCredit(order_id,credit_day)
{
	$('#orderCredit').modal('show');
	$("#hiddenOrderId").val(order_id);	
	$("#creditDaysNumber").val(credit_day);
	$("#creditAvailable").html(credit_day);
	$("#externId").html(order_id);
	$("#creditRemaining").html($("#creditDays_"+order_id).text());	

	if($('#order_id_'+order_id).val()> '0000-00-00 00:00:00')
	{
		$("#lastCreditAlert").show();
		$("#alertDate").html($('#order_id_'+order_id).val());
	}
	else
	{
		$("#lastCreditAlert").hide();
	}
}

function numbersOnly(e)
{
	var key = e.keyCode;
	if (!((key == 8) || (key == 46) || (key == 190) || (key == 110) || (key == 9) || (key == 110) || (key ==109) || (key == 173)  || (key == 107) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}

function fianance_procurement()
{
	$('#index_viewport').html('');
    $('#index_viewport').load('finance-indexdata.php?type=2');
}

function ExcelReports()
{
	$('#index_viewport').html('');
    $('#index_viewport').load('finance/finance-excelreport.tpl');
}

function salesReports()
{
	$('#index_viewport').html('');
    $('#index_viewport').load('finance/finance-master-sale-reports.tpl');
}

function rateContractReport() {
	$('#index_viewport').html();
	$('#index_viewport').load('finance-rate-contract.php');
}

function getFCs()
{
	var type = 3;
	var dataparam = '&type=' + type;
	$(".ajaxLoaderModal").show();
	$.ajax
	({
			type: 'GET',
			dataType:'json',
			async: true,
			url: 'finance-indexdata.php',
 			data: dataparam,
			cache: true,
 			success: function(data)
			{
				$('.selectFC').append("<option value=0>Select All</option>");
				for(var i = 0 ; data.length > i; i++)
					$('.selectFC').append("<option value="+data[i].id_fulfillment_centre+">"+data[i].city_name+"</option>");
			}
	});
	$(".ajaxLoaderModal").hide();
}

function exportExcelReport(report_type)
{
	var type,id_fc,month,report_type;
	if(report_type == 1)// export purchase bill
	{
		type = 2;
		id_fc = $("#purchase_FC").val();
		month = $("#purchase_month").val();
		if(!month)
		{
			toast("Enter valid month","warning");
			return false;
		}
 		report_type=1;
		 
	}
	else// export sales bill
	{
		type = 3;
		id_fc = $("#sales_FC").val();
 		month = $("#sales_month").val();
 		if(!month)
		{
			toast("Enter valid month","warning");
			return false;
		}
		report_type=2;
	}
		$('#purchase-hidden-data').empty();
		$('#purchase-hidden-data').append('<input id="id_fc" type="text" name="id_fc" value=' + id_fc + '><input id="selected_month" type="text" name="selected_month" value="01-' + month + '"><input id="report_type" type="text" name="report_type" value='+report_type+'>');
		$('#purchase_sales_bill_excel').submit();
	
	
}
function addPurchaseBill()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('finance-vendorbill.php' );
}
function viewPurchaseBill()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('finance-viewpurchasebill.php' );
}
/*Get values as parameter and from cookie value=>"currency_format_value" it convert it accordingly */
function moneyFormat(price_value)
{
 	
	//var formatMoney = lib.formatMoney = function(number, symbol, precision, thousand, decimal, format)
	if(currency_format_value == 1)
		return accounting.formatMoney(price_value,"Rs. ","2",",",".","%s%v");
	else if(currency_format_value == 2)
		return accounting.formatMoney(price_value,"Rs. ","2"," ",",","%v%s");	
	else if(currency_format_value == 3)
		return accounting.formatMoney(price_value,"Rs. ","2",".",",","%s%v");
	else if(currency_format_value == 4)
		return accounting.formatMoney(price_value,"Rs. ","2",",",".","%v%s");
}
function bankDetails()
{
	$('#index_viewport').html('');
 	$('#index_viewport').load('scn-vendorProductMapping.php', { data: 'scn/scn-vendorBankDetails.tpl' } );
}

function openVendorForm()
{
  	$('#index_viewport').html('');
	$('#index_viewport').load('scn-vendor-form.php' );
}

function vendorList()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('scn-vendorlist.php' );
}

function openPaymentRequests(type) {
    $('#index_viewport').html('');
    $("#index_viewport").load("payment-request.php?ajax=true&type=" + type + "", function(response, status, xhr) {});
	window.requestor_name="";
	window.vendor_name="";
	window.fro_date="";
	window.to_date="";
	window.id_fc="";
	window.request_status=""
}


$(document).ready(function()
{
	var dataparam = '&type=7';
	$(".ajaxLoaderModal").show();
 	$.ajax({
				type: 'GET',
				dataType:'json',
				async: true,
				url: 'scn-orderstatus.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
					$('#id-fc-finance').html('');
					$('#id-fc-finance').append('<option value="">Select Fulfillment Center</option>');
					for(var i = 0; i < data.length; i++){
						$('#id-fc-finance').append('<option value="'+data[i].id_fulfillment_centre+'">'+data[i].city_name+'</option>');
					}
				}
			});
 	$(".ajaxLoaderModal").hide();
 	getAllOrders(0);
  	setInterval(function(){getAllOrders(1); }, 300000);
});

function getAllOrders(id)
{
 	var current_time = new Date();
  	var hours = new Date().getHours();
    var hours = (hours+24)%24; 
    var mid='am';
    if(hours==0) //At 00 hours we need to show 12 am
    	hours=12;
    else if(hours>12)
	{
		hours=hours%12;
		mid='pm';
    }
 	$('.refreshtiming').html(hours + ":" + current_time.getMinutes() + ":" + current_time.getSeconds()+ "  "  + mid);
	if(id==1)
	{
 		$.ajaxSetup({
 			global: false,
 		});
	}
	else
	{
		$.ajaxSetup({
 			global: true,
 		});
 	}

	var type=1;
	var id_fc = $('#id-fc-finance').val();  
 	var dataparam = '&type='+type+'&id_fc='+id_fc;
 	$(".ajaxLoaderModal").show();
 	$.ajax({
				type: 'GET',
				dataType:'json',
				async: true,
				url: 'scn-orderstatus.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
 					var order_status_var = '';
					$('#order-states-rm,#order-states-scn,#order-states-finance,#order-states-tech,#order-states-other').html('');

					for(var i = 0; i < data[1].length; i++)
					{
						$('.state_in_'+data[1][i].id_order_state+'_24').html('');
						$('.state_in_'+data[1][i].id_order_state+'_48').html('');
						$('.state_in_'+data[1][i].id_order_state+'_72').html('');

						if(data[1][i].id_profile == 5)
							order_status_var = "order-states-rm";
						else if(data[1][i].id_profile == 6)
							order_status_var = "order-states-scn";
						else if(data[1][i].id_profile == 11)
							order_status_var = "order-states-finance";
						else if(data[1][i].id_profile == 13)
							order_status_var = "order-states-tech";
						else if(data[1][i].id_profile == 14)
							order_status_var = "order-states-other";

						$('#'+order_status_var+'').append('<tr id="order_state_scn_'+data[1][i].id_order_state+'">\
										                    <td class="tex-ali-cen">'+data[1][i].name+'</td>\
										                    <td class="success"><div class="padding5 state_in_'+data[1][i].id_order_state+'_24"></div></td>\
										                    <td class="warning"><div class="padding5 state_in_'+data[1][i].id_order_state+'_48"></div></td>\
										                    <td class="danger"><div class="padding5 state_in_'+data[1][i].id_order_state+'_72"></div></td>\
										                  </tr>');
					}

					for(var i = 0; i < data[0].length; i++){
						if(data[0][i].id_order_state){
							if(data[0][i].hours == 24){
								$('.state_in_'+data[0][i].id_order_state+'_24').html('');
								$('.state_in_'+data[0][i].id_order_state+'_24').append('<div class="cur-poi tex-ali-cen" onclick="openCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+',0)"><span>'+data[0][i].totalorder+'</span></div>');
							}
								else if(data[0][i].hours == 48){
									$('.state_in_'+data[0][i].id_order_state+'_48').html('');
									$('.state_in_'+data[0][i].id_order_state+'_48').append('<div class="cur-poi tex-ali-cen" onclick="openCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+',0)"><span>'+data[0][i].totalorder+'</span></div>');
								}
									else if(data[0][i].hours == 72){
										$('.state_in_'+data[0][i].id_order_state+'_72').html('');
										$('.state_in_'+data[0][i].id_order_state+'_72').append('<div class="cur-poi tex-ali-cen" onclick="openCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+',0)"><span>'+data[0][i].totalorder+'</span></div>');
									}
						}
					}
				}
	});
	$(".ajaxLoaderModal").hide();
}

function openCustmomerDetails(duration,order_status,buyer_type)
{
	
	var type=2;
	var id_fc = $('#id-fc-finance').val();  
	var dataparam = '&type=' + type+'&order_status=' + order_status+'&duration=' + duration+'&buyer_type=' + buyer_type +'&id_fc='+id_fc;
	$(".ajaxLoaderModal").show();
 	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'scn-orderstatus.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			
 			if(data !="")
			{
				$("#status_orders").html('');

				$("#modal-heading").html('<h5>Orders in <b>'+data[0][0].name+'</b> Status</h5>');

				for(var i=0; i<data[0].length; i++)
				{
				  $("#status_orders").append("<tr><td><a target='#' href='"+baseDir+"kobster_admin/index.php?tab=AdminOrders&id_order="+data[0][i].orderid+"&vieworder&token="+data[1]+"'>"+data[0][i].orderid+"</a></td><td>"+data[0][i].firstname+"</td><td>"+data[0][i].total_paid+"</td><td>"+data[0][i].name+"</td><td>"+data[0][i].DATE_ADD+"</td></tr>");
				}
			}
			else
			{
				$("#modal-heading").html('No Orders to Show');
				$("#status_orders").html('');
			}
			$('#finance_customer_order').modal('show');
		}
		
	});
	$(".ajaxLoaderModal").hide();	
}
function getGroups()
{
	var type =1;
	var dataparam = '&type=' + type;
	$(".ajaxLoaderModal").show();
	$.ajax
	({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'finance-invoice-controller.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			$("#group_selection").html(' ');
			$("#group_selection").append('<option value="0">Select Company</option>');
			for(var i=0; data.length > i; i++)
			{
				$("#group_selection").append('<option value="'+data[i].id_group+'">' + data[i].name + '</option>');
			}
		}
	});
	$(".ajaxLoaderModal").hide();
}
function generate_invoice()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('finance-invoice-controller.php?load=6');
}
function changeVat()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('finance-vat.php');
}

function getAddress()
{
	var type =3;
	var id_group=$("#group_selection option:selected").val();
	var dataparam = '&type=' + type+'&id_group='+id_group;
	$(".ajaxLoaderModal").show();
	$.ajax
	({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'finance-invoice-controller.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			$("#address_selection").html(' ');
			$("#address_selection").append('<option value="0">Select State</option>');
			for(var i=0; data.length > i; i++)
			{
				$("#address_selection").append('<option value="'+data[i].id_state+'">'+data[i].name+'</option>');
			}
		}
	});
	$(".ajaxLoaderModal").hide();
}



/**
 * BxSlider v4.1.2 - Fully loaded, responsive content slider
 * http://bxslider.com
 *
 * Copyright 2014, Steven Wanderski - http://stevenwanderski.com - http://bxcreative.com
 * Written while drinking Belgian ales and listening to jazz
 *
 * Released under the MIT license - http://opensource.org/licenses/MIT
 */
!function(t){var e={},s={mode:"horizontal",slideSelector:"",infiniteLoop:!0,hideControlOnEnd:!1,speed:500,easing:null,slideMargin:0,startSlide:0,randomStart:!1,captions:!1,ticker:!1,tickerHover:!1,adaptiveHeight:!1,adaptiveHeightSpeed:500,video:!1,useCSS:!0,preloadImages:"visible",responsive:!0,slideZIndex:50,touchEnabled:!0,swipeThreshold:50,oneToOneTouch:!0,preventDefaultSwipeX:!0,preventDefaultSwipeY:!1,pager:!0,pagerType:"full",pagerShortSeparator:" / ",pagerSelector:null,buildPager:null,pagerCustom:null,controls:!0,nextText:"Next",prevText:"Prev",nextSelector:null,prevSelector:null,autoControls:!1,startText:"Start",stopText:"Stop",autoControlsCombine:!1,autoControlsSelector:null,auto:!1,pause:4e3,autoStart:!0,autoDirection:"next",autoHover:!1,autoDelay:0,minSlides:1,maxSlides:1,moveSlides:0,slideWidth:0,onSliderLoad:function(){},onSlideBefore:function(){},onSlideAfter:function(){},onSlideNext:function(){},onSlidePrev:function(){},onSliderResize:function(){}};t.fn.bxSlider=function(n){if(0==this.length)return this;if(this.length>1)return this.each(function(){t(this).bxSlider(n)}),this;var o={},r=this;e.el=this;var a=t(window).width(),l=t(window).height(),d=function(){o.settings=t.extend({},s,n),o.settings.slideWidth=parseInt(o.settings.slideWidth),o.children=r.children(o.settings.slideSelector),o.children.length<o.settings.minSlides&&(o.settings.minSlides=o.children.length),o.children.length<o.settings.maxSlides&&(o.settings.maxSlides=o.children.length),o.settings.randomStart&&(o.settings.startSlide=Math.floor(Math.random()*o.children.length)),o.active={index:o.settings.startSlide},o.carousel=o.settings.minSlides>1||o.settings.maxSlides>1,o.carousel&&(o.settings.preloadImages="all"),o.minThreshold=o.settings.minSlides*o.settings.slideWidth+(o.settings.minSlides-1)*o.settings.slideMargin,o.maxThreshold=o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin,o.working=!1,o.controls={},o.interval=null,o.animProp="vertical"==o.settings.mode?"top":"left",o.usingCSS=o.settings.useCSS&&"fade"!=o.settings.mode&&function(){var t=document.createElement("div"),e=["WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var i in e)if(void 0!==t.style[e[i]])return o.cssPrefix=e[i].replace("Perspective","").toLowerCase(),o.animProp="-"+o.cssPrefix+"-transform",!0;return!1}(),"vertical"==o.settings.mode&&(o.settings.maxSlides=o.settings.minSlides),r.data("origStyle",r.attr("style")),r.children(o.settings.slideSelector).each(function(){t(this).data("origStyle",t(this).attr("style"))}),c()},c=function(){r.wrap('<div class="bx-wrapper"><div class="bx-viewport"></div></div>'),o.viewport=r.parent(),o.loader=t('<div class="bx-loading" />'),o.viewport.prepend(o.loader),r.css({width:"horizontal"==o.settings.mode?100*o.children.length+215+"%":"auto",position:"relative"}),o.usingCSS&&o.settings.easing?r.css("-"+o.cssPrefix+"-transition-timing-function",o.settings.easing):o.settings.easing||(o.settings.easing="swing"),f(),o.viewport.css({width:"100%",overflow:"hidden",position:"relative"}),o.viewport.parent().css({maxWidth:p()}),o.settings.pager||o.viewport.parent().css({margin:"0 auto 0px"}),o.children.css({"float":"horizontal"==o.settings.mode?"left":"none",listStyle:"none",position:"relative"}),o.children.css("width",u()),"horizontal"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginRight",o.settings.slideMargin),"vertical"==o.settings.mode&&o.settings.slideMargin>0&&o.children.css("marginBottom",o.settings.slideMargin),"fade"==o.settings.mode&&(o.children.css({position:"absolute",zIndex:0,display:"none"}),o.children.eq(o.settings.startSlide).css({zIndex:o.settings.slideZIndex,display:"block"})),o.controls.el=t('<div class="bx-controls" />'),o.settings.captions&&P(),o.active.last=o.settings.startSlide==x()-1,o.settings.video&&r.fitVids();var e=o.children.eq(o.settings.startSlide);"all"==o.settings.preloadImages&&(e=o.children),o.settings.ticker?o.settings.pager=!1:(o.settings.pager&&T(),o.settings.controls&&C(),o.settings.auto&&o.settings.autoControls&&E(),(o.settings.controls||o.settings.autoControls||o.settings.pager)&&o.viewport.after(o.controls.el)),g(e,h)},g=function(e,i){var s=e.find("img, iframe").length;if(0==s)return i(),void 0;var n=0;e.find("img, iframe").each(function(){t(this).one("load",function(){++n==s&&i()}).each(function(){this.complete&&t(this).load()})})},h=function(){if(o.settings.infiniteLoop&&"fade"!=o.settings.mode&&!o.settings.ticker){var e="vertical"==o.settings.mode?o.settings.minSlides:o.settings.maxSlides,i=o.children.slice(0,e).clone().addClass("bx-clone"),s=o.children.slice(-e).clone().addClass("bx-clone");r.append(i).prepend(s)}o.loader.remove(),S(),"vertical"==o.settings.mode&&(o.settings.adaptiveHeight=!0),o.viewport.height(v()),r.redrawSlider(),o.settings.onSliderLoad(o.active.index),o.initialized=!0,o.settings.responsive&&t(window).bind("resize",Z),o.settings.auto&&o.settings.autoStart&&H(),o.settings.ticker&&L(),o.settings.pager&&q(o.settings.startSlide),o.settings.controls&&W(),o.settings.touchEnabled&&!o.settings.ticker&&O()},v=function(){var e=0,s=t();if("vertical"==o.settings.mode||o.settings.adaptiveHeight)if(o.carousel){var n=1==o.settings.moveSlides?o.active.index:o.active.index*m();for(s=o.children.eq(n),i=1;i<=o.settings.maxSlides-1;i++)s=n+i>=o.children.length?s.add(o.children.eq(i-1)):s.add(o.children.eq(n+i))}else s=o.children.eq(o.active.index);else s=o.children;return"vertical"==o.settings.mode?(s.each(function(){e+=t(this).outerHeight()}),o.settings.slideMargin>0&&(e+=o.settings.slideMargin*(o.settings.minSlides-1))):e=Math.max.apply(Math,s.map(function(){return t(this).outerHeight(!1)}).get()),e},p=function(){var t="100%";return o.settings.slideWidth>0&&(t="horizontal"==o.settings.mode?o.settings.maxSlides*o.settings.slideWidth+(o.settings.maxSlides-1)*o.settings.slideMargin:o.settings.slideWidth),t},u=function(){var t=o.settings.slideWidth,e=o.viewport.width();return 0==o.settings.slideWidth||o.settings.slideWidth>e&&!o.carousel||"vertical"==o.settings.mode?t=e:o.settings.maxSlides>1&&"horizontal"==o.settings.mode&&(e>o.maxThreshold||e<o.minThreshold&&(t=(e-o.settings.slideMargin*(o.settings.minSlides-1))/o.settings.minSlides)),t},f=function(){var t=1;if("horizontal"==o.settings.mode&&o.settings.slideWidth>0)if(o.viewport.width()<o.minThreshold)t=o.settings.minSlides;else if(o.viewport.width()>o.maxThreshold)t=o.settings.maxSlides;else{var e=o.children.first().width();t=Math.floor(o.viewport.width()/e)}else"vertical"==o.settings.mode&&(t=o.settings.minSlides);return t},x=function(){var t=0;if(o.settings.moveSlides>0)if(o.settings.infiniteLoop)t=o.children.length/m();else for(var e=0,i=0;e<o.children.length;)++t,e=i+f(),i+=o.settings.moveSlides<=f()?o.settings.moveSlides:f();else t=Math.ceil(o.children.length/f());return t},m=function(){return o.settings.moveSlides>0&&o.settings.moveSlides<=f()?o.settings.moveSlides:f()},S=function(){if(o.children.length>o.settings.maxSlides&&o.active.last&&!o.settings.infiniteLoop){if("horizontal"==o.settings.mode){var t=o.children.last(),e=t.position();b(-(e.left-(o.viewport.width()-t.width())),"reset",0)}else if("vertical"==o.settings.mode){var i=o.children.length-o.settings.minSlides,e=o.children.eq(i).position();b(-e.top,"reset",0)}}else{var e=o.children.eq(o.active.index*m()).position();o.active.index==x()-1&&(o.active.last=!0),void 0!=e&&("horizontal"==o.settings.mode?b(-e.left,"reset",0):"vertical"==o.settings.mode&&b(-e.top,"reset",0))}},b=function(t,e,i,s){if(o.usingCSS){var n="vertical"==o.settings.mode?"translate3d(0, "+t+"px, 0)":"translate3d("+t+"px, 0, 0)";r.css("-"+o.cssPrefix+"-transition-duration",i/1e3+"s"),"slide"==e?(r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),D()})):"reset"==e?r.css(o.animProp,n):"ticker"==e&&(r.css("-"+o.cssPrefix+"-transition-timing-function","linear"),r.css(o.animProp,n),r.bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd",function(){r.unbind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd"),b(s.resetValue,"reset",0),N()}))}else{var a={};a[o.animProp]=t,"slide"==e?r.animate(a,i,o.settings.easing,function(){D()}):"reset"==e?r.css(o.animProp,t):"ticker"==e&&r.animate(a,speed,"linear",function(){b(s.resetValue,"reset",0),N()})}},w=function(){for(var e="",i=x(),s=0;i>s;s++){var n="";o.settings.buildPager&&t.isFunction(o.settings.buildPager)?(n=o.settings.buildPager(s),o.pagerEl.addClass("bx-custom-pager")):(n=s+1,o.pagerEl.addClass("bx-default-pager")),e+='<div class="bx-pager-item"><a href="" data-slide-index="'+s+'" class="bx-pager-link">'+n+"</a></div>"}o.pagerEl.html(e)},T=function(){o.settings.pagerCustom?o.pagerEl=t(o.settings.pagerCustom):(o.pagerEl=t('<div class="bx-pager" />'),o.settings.pagerSelector?t(o.settings.pagerSelector).html(o.pagerEl):o.controls.el.addClass("bx-has-pager").append(o.pagerEl),w()),o.pagerEl.on("click","a",I)},C=function(){o.controls.next=t('<a class="bx-next" href="">'+o.settings.nextText+"</a>"),o.controls.prev=t('<a class="bx-prev" href="">'+o.settings.prevText+"</a>"),o.controls.next.bind("click",y),o.controls.prev.bind("click",z),o.settings.nextSelector&&t(o.settings.nextSelector).append(o.controls.next),o.settings.prevSelector&&t(o.settings.prevSelector).append(o.controls.prev),o.settings.nextSelector||o.settings.prevSelector||(o.controls.directionEl=t('<div class="bx-controls-direction" />'),o.controls.directionEl.append(o.controls.prev).append(o.controls.next),o.controls.el.addClass("bx-has-controls-direction").append(o.controls.directionEl))},E=function(){o.controls.start=t('<div class="bx-controls-auto-item"><a class="bx-start" href="">'+o.settings.startText+"</a></div>"),o.controls.stop=t('<div class="bx-controls-auto-item"><a class="bx-stop" href="">'+o.settings.stopText+"</a></div>"),o.controls.autoEl=t('<div class="bx-controls-auto" />'),o.controls.autoEl.on("click",".bx-start",k),o.controls.autoEl.on("click",".bx-stop",M),o.settings.autoControlsCombine?o.controls.autoEl.append(o.controls.start):o.controls.autoEl.append(o.controls.start).append(o.controls.stop),o.settings.autoControlsSelector?t(o.settings.autoControlsSelector).html(o.controls.autoEl):o.controls.el.addClass("bx-has-controls-auto").append(o.controls.autoEl),A(o.settings.autoStart?"stop":"start")},P=function(){o.children.each(function(){var e=t(this).find("img:first").attr("title");void 0!=e&&(""+e).length&&t(this).append('<div class="bx-caption"><span>'+e+"</span></div>")})},y=function(t){o.settings.auto&&r.stopAuto(),r.goToNextSlide(),t.preventDefault()},z=function(t){o.settings.auto&&r.stopAuto(),r.goToPrevSlide(),t.preventDefault()},k=function(t){r.startAuto(),t.preventDefault()},M=function(t){r.stopAuto(),t.preventDefault()},I=function(e){o.settings.auto&&r.stopAuto();var i=t(e.currentTarget),s=parseInt(i.attr("data-slide-index"));s!=o.active.index&&r.goToSlide(s),e.preventDefault()},q=function(e){var i=o.children.length;return"short"==o.settings.pagerType?(o.settings.maxSlides>1&&(i=Math.ceil(o.children.length/o.settings.maxSlides)),o.pagerEl.html(e+1+o.settings.pagerShortSeparator+i),void 0):(o.pagerEl.find("a").removeClass("active"),o.pagerEl.each(function(i,s){t(s).find("a").eq(e).addClass("active")}),void 0)},D=function(){if(o.settings.infiniteLoop){var t="";0==o.active.index?t=o.children.eq(0).position():o.active.index==x()-1&&o.carousel?t=o.children.eq((x()-1)*m()).position():o.active.index==o.children.length-1&&(t=o.children.eq(o.children.length-1).position()),t&&("horizontal"==o.settings.mode?b(-t.left,"reset",0):"vertical"==o.settings.mode&&b(-t.top,"reset",0))}o.working=!1,o.settings.onSlideAfter(o.children.eq(o.active.index),o.oldIndex,o.active.index)},A=function(t){o.settings.autoControlsCombine?o.controls.autoEl.html(o.controls[t]):(o.controls.autoEl.find("a").removeClass("active"),o.controls.autoEl.find("a:not(.bx-"+t+")").addClass("active"))},W=function(){1==x()?(o.controls.prev.addClass("disabled"),o.controls.next.addClass("disabled")):!o.settings.infiniteLoop&&o.settings.hideControlOnEnd&&(0==o.active.index?(o.controls.prev.addClass("disabled"),o.controls.next.removeClass("disabled")):o.active.index==x()-1?(o.controls.next.addClass("disabled"),o.controls.prev.removeClass("disabled")):(o.controls.prev.removeClass("disabled"),o.controls.next.removeClass("disabled")))},H=function(){o.settings.autoDelay>0?setTimeout(r.startAuto,o.settings.autoDelay):r.startAuto(),o.settings.autoHover&&r.hover(function(){o.interval&&(r.stopAuto(!0),o.autoPaused=!0)},function(){o.autoPaused&&(r.startAuto(!0),o.autoPaused=null)})},L=function(){var e=0;if("next"==o.settings.autoDirection)r.append(o.children.clone().addClass("bx-clone"));else{r.prepend(o.children.clone().addClass("bx-clone"));var i=o.children.first().position();e="horizontal"==o.settings.mode?-i.left:-i.top}b(e,"reset",0),o.settings.pager=!1,o.settings.controls=!1,o.settings.autoControls=!1,o.settings.tickerHover&&!o.usingCSS&&o.viewport.hover(function(){r.stop()},function(){var e=0;o.children.each(function(){e+="horizontal"==o.settings.mode?t(this).outerWidth(!0):t(this).outerHeight(!0)});var i=o.settings.speed/e,s="horizontal"==o.settings.mode?"left":"top",n=i*(e-Math.abs(parseInt(r.css(s))));N(n)}),N()},N=function(t){speed=t?t:o.settings.speed;var e={left:0,top:0},i={left:0,top:0};"next"==o.settings.autoDirection?e=r.find(".bx-clone").first().position():i=o.children.first().position();var s="horizontal"==o.settings.mode?-e.left:-e.top,n="horizontal"==o.settings.mode?-i.left:-i.top,a={resetValue:n};b(s,"ticker",speed,a)},O=function(){o.touch={start:{x:0,y:0},end:{x:0,y:0}},o.viewport.bind("touchstart",X)},X=function(t){if(o.working)t.preventDefault();else{o.touch.originalPos=r.position();var e=t.originalEvent;o.touch.start.x=e.changedTouches[0].pageX,o.touch.start.y=e.changedTouches[0].pageY,o.viewport.bind("touchmove",Y),o.viewport.bind("touchend",V)}},Y=function(t){var e=t.originalEvent,i=Math.abs(e.changedTouches[0].pageX-o.touch.start.x),s=Math.abs(e.changedTouches[0].pageY-o.touch.start.y);if(3*i>s&&o.settings.preventDefaultSwipeX?t.preventDefault():3*s>i&&o.settings.preventDefaultSwipeY&&t.preventDefault(),"fade"!=o.settings.mode&&o.settings.oneToOneTouch){var n=0;if("horizontal"==o.settings.mode){var r=e.changedTouches[0].pageX-o.touch.start.x;n=o.touch.originalPos.left+r}else{var r=e.changedTouches[0].pageY-o.touch.start.y;n=o.touch.originalPos.top+r}b(n,"reset",0)}},V=function(t){o.viewport.unbind("touchmove",Y);var e=t.originalEvent,i=0;if(o.touch.end.x=e.changedTouches[0].pageX,o.touch.end.y=e.changedTouches[0].pageY,"fade"==o.settings.mode){var s=Math.abs(o.touch.start.x-o.touch.end.x);s>=o.settings.swipeThreshold&&(o.touch.start.x>o.touch.end.x?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto())}else{var s=0;"horizontal"==o.settings.mode?(s=o.touch.end.x-o.touch.start.x,i=o.touch.originalPos.left):(s=o.touch.end.y-o.touch.start.y,i=o.touch.originalPos.top),!o.settings.infiniteLoop&&(0==o.active.index&&s>0||o.active.last&&0>s)?b(i,"reset",200):Math.abs(s)>=o.settings.swipeThreshold?(0>s?r.goToNextSlide():r.goToPrevSlide(),r.stopAuto()):b(i,"reset",200)}o.viewport.unbind("touchend",V)},Z=function(){var e=t(window).width(),i=t(window).height();(a!=e||l!=i)&&(a=e,l=i,r.redrawSlider(),o.settings.onSliderResize.call(r,o.active.index))};return r.goToSlide=function(e,i){if(!o.working&&o.active.index!=e)if(o.working=!0,o.oldIndex=o.active.index,o.active.index=0>e?x()-1:e>=x()?0:e,o.settings.onSlideBefore(o.children.eq(o.active.index),o.oldIndex,o.active.index),"next"==i?o.settings.onSlideNext(o.children.eq(o.active.index),o.oldIndex,o.active.index):"prev"==i&&o.settings.onSlidePrev(o.children.eq(o.active.index),o.oldIndex,o.active.index),o.active.last=o.active.index>=x()-1,o.settings.pager&&q(o.active.index),o.settings.controls&&W(),"fade"==o.settings.mode)o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed),o.children.filter(":visible").fadeOut(o.settings.speed).css({zIndex:0}),o.children.eq(o.active.index).css("zIndex",o.settings.slideZIndex+1).fadeIn(o.settings.speed,function(){t(this).css("zIndex",o.settings.slideZIndex),D()});else{o.settings.adaptiveHeight&&o.viewport.height()!=v()&&o.viewport.animate({height:v()},o.settings.adaptiveHeightSpeed);var s=0,n={left:0,top:0};if(!o.settings.infiniteLoop&&o.carousel&&o.active.last)if("horizontal"==o.settings.mode){var a=o.children.eq(o.children.length-1);n=a.position(),s=o.viewport.width()-a.outerWidth()}else{var l=o.children.length-o.settings.minSlides;n=o.children.eq(l).position()}else if(o.carousel&&o.active.last&&"prev"==i){var d=1==o.settings.moveSlides?o.settings.maxSlides-m():(x()-1)*m()-(o.children.length-o.settings.maxSlides),a=r.children(".bx-clone").eq(d);n=a.position()}else if("next"==i&&0==o.active.index)n=r.find("> .bx-clone").eq(o.settings.maxSlides).position(),o.active.last=!1;else if(e>=0){var c=e*m();n=o.children.eq(c).position()}if("undefined"!=typeof n){var g="horizontal"==o.settings.mode?-(n.left-s):-n.top;b(g,"slide",o.settings.speed)}}},r.goToNextSlide=function(){if(o.settings.infiniteLoop||!o.active.last){var t=parseInt(o.active.index)+1;r.goToSlide(t,"next")}},r.goToPrevSlide=function(){if(o.settings.infiniteLoop||0!=o.active.index){var t=parseInt(o.active.index)-1;r.goToSlide(t,"prev")}},r.startAuto=function(t){o.interval||(o.interval=setInterval(function(){"next"==o.settings.autoDirection?r.goToNextSlide():r.goToPrevSlide()},o.settings.pause),o.settings.autoControls&&1!=t&&A("stop"))},r.stopAuto=function(t){o.interval&&(clearInterval(o.interval),o.interval=null,o.settings.autoControls&&1!=t&&A("start"))},r.getCurrentSlide=function(){return o.active.index},r.getCurrentSlideElement=function(){return o.children.eq(o.active.index)},r.getSlideCount=function(){return o.children.length},r.redrawSlider=function(){o.children.add(r.find(".bx-clone")).outerWidth(u()),o.viewport.css("height",v()),o.settings.ticker||S(),o.active.last&&(o.active.index=x()-1),o.active.index>=x()&&(o.active.last=!0),o.settings.pager&&!o.settings.pagerCustom&&(w(),q(o.active.index))},r.destroySlider=function(){o.initialized&&(o.initialized=!1,t(".bx-clone",this).remove(),o.children.each(function(){void 0!=t(this).data("origStyle")?t(this).attr("style",t(this).data("origStyle")):t(this).removeAttr("style")}),void 0!=t(this).data("origStyle")?this.attr("style",t(this).data("origStyle")):t(this).removeAttr("style"),t(this).unwrap().unwrap(),o.controls.el&&o.controls.el.remove(),o.controls.next&&o.controls.next.remove(),o.controls.prev&&o.controls.prev.remove(),o.pagerEl&&o.settings.controls&&o.pagerEl.remove(),t(".bx-caption",this).remove(),o.controls.autoEl&&o.controls.autoEl.remove(),clearInterval(o.interval),o.settings.responsive&&t(window).unbind("resize",Z))},r.reloadSlider=function(t){void 0!=t&&(n=t),r.destroySlider(),d()},d(),this}}(jQuery);