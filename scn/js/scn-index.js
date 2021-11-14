!function(n,r){function e(n){return!!(""===n||n&&n.charCodeAt&&n.substr)}function t(n){return p?p(n):"[object Array]"===l.call(n)}function o(n){return n&&"[object Object]"===l.call(n)}function a(n,r){var e;n=n||{},r=r||{};for(e in r)r.hasOwnProperty(e)&&null==n[e]&&(n[e]=r[e]);return n}function i(n,r,e){var t,o,a=[];if(!n)return a;if(f&&n.map===f)return n.map(r,e);for(t=0,o=n.length;o>t;t++)a[t]=r.call(e,n[t],t,n);return a}function u(n,r){return n=Math.round(Math.abs(n)),isNaN(n)?r:n}function c(n){var r=s.settings.currency.format;return"function"==typeof n&&(n=n()),e(n)&&n.match("%v")?{pos:n,neg:n.replace("-","").replace("%v","-%v"),zero:n}:n&&n.pos&&n.pos.match("%v")?n:e(r)?s.settings.currency.format={pos:r,neg:r.replace("%v","-%v"),zero:r}:r}var s={};s.version="0.4.1",s.settings={currency:{symbol:"Rs. ",format:"%s%v",decimal:".",thousand:",",precision:2,grouping:2},number:{precision:0,grouping:3,thousand:",",decimal:"."}};var f=Array.prototype.map,p=Array.isArray,l=Object.prototype.toString,m=s.unformat=s.parse=function(n,r){if(t(n))return i(n,function(n){return m(n,r)});if(n=n||0,"number"==typeof n)return n;r=r||s.settings.number.decimal;var e=new RegExp("[^0-9-"+r+"]",["g"]),o=parseFloat((""+n).replace(/\((.*)\)/,"-$1").replace(e,"").replace(r,"."));return isNaN(o)?0:o},d=s.toFixed=function(n,r){r=u(r,s.settings.number.precision);var e=Math.pow(10,r);return(Math.round(s.unformat(n)*e)/e).toFixed(r)},g=s.formatNumber=s.format=function(n,r,e,c){if(t(n))return i(n,function(n){return g(n,r,e,c)});n=m(n);var f=a(o(r)?r:{precision:r,thousand:e,decimal:c},s.settings.number),p=u(f.precision),l=0>n?"-":"",h=parseInt(d(Math.abs(n||0),p),10)+"",y=h.length>3?h.length%3:0;return l+(y?h.substr(0,y)+f.thousand:"")+h.substr(y).replace(/(\d{3})(?=\d)/g,"$1"+f.thousand)+(p?f.decimal+d(Math.abs(n),p).split(".")[1]:"")},h=s.formatMoney=function(n,r,e,f,p,l){if(t(n))return i(n,function(n){return h(n,r,e,f,p,l)});n=m(n);var d=a(o(r)?r:{symbol:r,precision:e,thousand:f,decimal:p,format:l},s.settings.currency),y=c(d.format),b=n>0?y.pos:0>n?y.neg:y.zero;return b.replace("%s",d.symbol).replace("%v",g(Math.abs(n),u(d.precision),d.thousand,d.decimal))};s.formatColumn=function(n,r,f,p,l,d){if(!n)return[];var h=a(o(r)?r:{symbol:r,precision:f,thousand:p,decimal:l,format:d},s.settings.currency),y=c(h.format),b=y.pos.indexOf("%s")<y.pos.indexOf("%v")?!0:!1,v=0,x=i(n,function(n){if(t(n))return s.formatColumn(n,h);n=m(n);var r=n>0?y.pos:0>n?y.neg:y.zero,e=r.replace("%s",h.symbol).replace("%v",g(Math.abs(n),u(h.precision),h.thousand,h.decimal));return e.length>v&&(v=e.length),e});return i(x,function(n){return e(n)&&n.length<v?b?n.replace(h.symbol,h.symbol+new Array(v-n.length+1).join(" ")):new Array(v-n.length+1).join(" ")+n:n})},"undefined"!=typeof exports?("undefined"!=typeof module&&module.exports&&(exports=module.exports=s),exports.accounting=s):"function"==typeof define&&define.amd?define([],function(){return s}):(s.noConflict=function(e){return function(){return n.accounting=e,s.noConflict=r,s}}(n.accounting),n.accounting=s)}(this);
// JavaScript Document
window.company_id = 0;
window.state_id = 0;
window.scn_quote_id = 0;
window.tax_rate = 0;
window.global_id_fc = 0;
window.fc_name = "";
window.quote_revise_attempt = true;

function vendorProductMapping()
{
	$('#index_viewport').html('');
 	$('#index_viewport').load('scn-vendorProductMapping.php', { data: 'scn/scn-vendorProductMapping.tpl' } );
}

function vendorCategoryMapping()
{
	$('#index_viewport').html('');
 	$('#index_viewport').load('scn-vendorProductMapping.php', { data: 'scn/scn-vendorCategoryMapping.tpl' } );
}

function vendorBrandMapping()
{
	$('#index_viewport').html('');
 	$('#index_viewport').load('scn-vendorProductMapping.php', { data: 'scn/scn-vendorBrandMapping.tpl' } );
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

function addPurchaseBill()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('scn-vendorbill.php' );
}

function viewPurchaseBill()
{
	$('#index_viewport').html('');
	$('#index_viewport').load('scn-viewpurchasebill.php' );
}
/*scn dashbord Functionalities starts here */

function scnOpenCustmomerDetails(duration,order_status,buyer_type)
{
 	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'scn-orderstatus.php',
		data: '&type=2&order_status=' + order_status+'&duration=' + duration+'&buyer_type=' + buyer_type +'&id_fc='+$('#id-fc-scn').val(),
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
			$('#scn_customer_order').modal('show');
		}
		
	});
 	
	
}

$(document).ready(function()
{
 	$.ajax({
				type: 'GET',
				dataType:'json',
				async: true,
				url: 'scn-orderstatus.php',
				data: '&type=7',
				cache: true,
				success: function(data)
				{
					$('#id-fc-scn').html('');
					$('#id-fc-scn').append('<option value="">Select Fulfillment Center</option>');
					for(var i = 0; i < data.length; i++){
						$('#id-fc-scn').append('<option value="'+data[i].id_fulfillment_centre+'">'+data[i].city_name+'</option>');
					}
				}
			});
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

 	$.ajax({
				type: 'GET',
				dataType:'json',
				async: true,
				url: 'scn-orderstatus.php',
				data: '&type=1&id_fc='+$('#id-fc-scn').val(),
				cache: true,
				success: function(data)
				{
 					var order_status_var = '';
					$('#order-statuses-rm,#order-statuses-scn,#order-statuses-finance,#order-statuses-tech,#order-statuses-other').html('');

					for(var i = 0; i < data[1].length; i++)
					{
						$('.state_in_'+data[1][i].id_order_state+'_24').html('');
						$('.state_in_'+data[1][i].id_order_state+'_48').html('');
						$('.state_in_'+data[1][i].id_order_state+'_72').html('');

						if(data[1][i].id_profile == 5)
							order_status_var = "order-statuses-rm";
						else if(data[1][i].id_profile == 6)
							order_status_var = "order-statuses-scn";
						else if(data[1][i].id_profile == 11)
							order_status_var = "order-statuses-finance";
						else if(data[1][i].id_profile == 13)
							order_status_var = "order-statuses-tech";
						else if(data[1][i].id_profile == 14)
							order_status_var = "order-statuses-other";

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
								$('.state_in_'+data[0][i].id_order_state+'_24').append('<div class="cur-poi tex-ali-cen" onclick="scnOpenCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+',0)"><span>'+data[0][i].totalorder+'</span></div>');
							}
								else if(data[0][i].hours == 48){
									$('.state_in_'+data[0][i].id_order_state+'_48').html('');
									$('.state_in_'+data[0][i].id_order_state+'_48').append('<div class="cur-poi tex-ali-cen" onclick="scnOpenCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+',0)"><span>'+data[0][i].totalorder+'</span></div>');
								}
									else if(data[0][i].hours == 72){
										$('.state_in_'+data[0][i].id_order_state+'_72').html('');
										$('.state_in_'+data[0][i].id_order_state+'_72').append('<div class="cur-poi tex-ali-cen" onclick="scnOpenCustmomerDetails('+data[0][i].hours+','+data[0][i].id_order_state+',0)"><span>'+data[0][i].totalorder+'</span></div>');
									}
						}
					}
				}
	});
}

function reports(id) 
{ 
    $('#report_type').val(id);
    $('#index_viewport').load('scn/scn-reports.tpl');
}

function vendorSearchView(id) 
{
	$('#search_type').val(id);
    $('#index_viewport').html('');
    $("#index_viewport").load("scn/scn-searchVendor.tpl");
}

function numbersOnly(e)
{
	var key = e.keyCode;
	if (!((key == 8) || (key == 46) || (key == 188) || (key == 9) || (key ==109) || (key == 173)  || (key == 107) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}

function customerSearchView(id) 
{
	$('.sidebar-toggle-box .fa-bars').click();
	$('#quote_type').val(id);
    $('#index_viewport').html('');
    $("#index_viewport").load("scn/scn-quotation.tpl");
}

function productHistory()
{
	$('#index_viewport').html('');
    $("#index_viewport").load("scn/scn-producthistory.tpl");
}

function purchasePlan()
{
	$(".ajaxLoaderModal").show();
	$('#index_viewport').html('');
    $("#index_viewport").load("scn/scn-purchaseplan.tpl");
    $(".ajaxLoaderModal").hide();
}

/* dataTable() is from dash/js/data-tables/jquery.dataTables.js
AND dash/js/data-tables/DT_bootstrap.js */
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
			"sLengthMenu": "_MENU_ records per page",
			"oPaginate": {
				"sPrevious": "Prev",
				"sNext": "Next"
			}
		},			
		"order": [[ 1, "desc" ]],
		"aoColumnDefs": [{
				'bSortable': true,
				'aTargets': [0]
			}
		],
		
		"aaSorting": []
	});
	 
				 
}

function bqRequest()
{
		$('#index_viewport').html('');
		$("#index_viewport").load("bq-request-ajax.php?type=1");
}


function getFC()
{
 	$.ajax({
			type: 'POST',
			dataType:'json',
			async: true,
			url: 'scn-purchaseplan.php',
			data:'&type=1',
			cache: true,
			success: function(data)
			{
				for(var i=0; data.length > i; i++)
				{					
					$("ul#lists").append("<li><a onClick='selectFc(this);' id=" + data[i].id_fulfillment_centre+ ">" + data[i].city_name + "</a></li>");					
					}
			}
	});

}

 
function selectFc(fc_details)
{
	$('.hideProcurementPlan').show();
	$("#download_table").removeClass('disabled');
 	$('span#listTitle').html(fc_details.innerHTML);
	global_id_fc = fc_details.id;
	$("#purchase_plan").html('');
	//$(".ajaxLoaderModal").show();
 // 	$.ajax({
	// 			type: 'POST',
	// 			dataType:'json',
	// 			async: true,
	// 			url: 'scn-purchaseplan.php',
	// 			data:'&type=2&id_fc='+fc_details.id,
	// 			cache: true,
	// 			success: function(data)
	// 			{
 //    				var table_contant,data_reversed = [];
 //    				data_reversed = data.reverse();
 // 					for(var i=0; i < data_reversed.length; i++)
	// 				{
	// 					if($.isEmptyObject(data[i]['details'][0]['vendor']) == false)
	// 					{
	// 						if($.isEmptyObject(data[i]['details'][0]['vendor'][0]) == true)
	// 						{
	// 								var address ="---";
	// 								var phone ="---";
	// 								var Payment_Name ="---";
	// 								var comments ="---";
	// 						}
	// 						else
	// 						{
	// 								var address = data[i]['details'][0]['vendor'][0].address1 != null ? data[i]['details'][0]['vendor'][0].address1 : "---";
	// 								var phone = data[i]['details'][0]['vendor'][0].phone;
	// 								var Payment_Name = data[i]['details'][0]['vendor'][0].Payment_Name;
	// 								var comments = data[i]['details'][0]['vendor'][0].comments !="" ? data[i]['details'][0]['vendor'][0].comments : "---";
	// 						}	
	// 					}
	// 					table_contant="<table class='table table-hover table-bordered'><th class='text-muted'>Product Name</th><th class='text-muted'>Reference</th><th class='text-muted'>Order Id's</th><th class='text-muted'>QTY</th><th class='text-muted'>Buying Price</th><th class='text-muted'>Selling Price</th><th class='text-muted'>Alternate Vendor</th><tbody>";
	// 					var product_details="";
	// 					var total_buying_price =0;
	// 					var total_selling_price =0;
						
	// 					for(var k=0; k < data[i]['details'].length; k++ )
	// 					{
 // 							if(data[i]['details'][k].product_quantity > 0)
 // 							{
	//  							if( data[i]['details'][k].buying_vendor1_price == null)
	// 								var buyingprice = 0;
	// 							else
	// 								var buyingprice = data[i]['details'][k].buying_vendor1_price;
								
	// 							if( data[i]['details'][k].buying_vendor2_price == null)
	// 								var buyingprice2 = 0;
	// 							else
	// 								var buyingprice2 = data[i]['details'][k].buying_vendor2_price;
								
	//  							var buying_price = parseFloat(buyingprice).toFixed(2);
	//  							var buying_price2 = parseFloat(buyingprice2).toFixed(2);
								
	// 							var selling_price = parseFloat(data[i]['details'][k].selling_price).toFixed(2);
	// 							var order_id = data[i]['details'][k].id_order;
	// 							var productname = data[i]['details'][k].product_name;
								
	// 							order_id = order_id.match(/.{1,25}/g).join("<br/>");
	// 							productname = productname.match(/.{1,25}/g).join("<br/>-");
	 							
	// 							total_buying_price += parseFloat(buying_price);
	// 							total_selling_price += parseFloat(selling_price);
								
	//  							product_details +="<tr><td class='text-primary'>"+productname+"</td><td class='text-primary'>"+data[i]['details'][k].reference+"</td><td class='text-primary'>"+order_id+"</td><td class='text-primary'>"+data[i]['details'][k].product_quantity+"</td><td class='text-primary'>"+parseFloat(buying_price).toFixed(2)+"</td><td class='text-primary'>"+parseFloat(selling_price).toFixed(2)+"</td><td class='text-primary'>"+data[i]['details'][k].buying_vendor2_name+"/"+buying_price2+"</td></tr>";
	// 						}
	// 					}
	// 					product_details += "<tr><td class='text-muted'><strong>Total Buying & Selling</strong></td><td></td><td></td><td></td></td><td class='text-success'><strong class='buyingPrice_"+i+"'>"+parseFloat(total_buying_price).toFixed(2)+"</strong></td><td class='text-success'><strong class='sellingPrice_"+i+"'>"+parseFloat(total_selling_price).toFixed(2)+"</strong></td><td> </td></tr>";
						
 // 						var end_table= "</tr></tbody></table></div><!--ADD_PAGE-->";
						
 // 						table_contant += product_details;
 // 						table_contant += end_table;

 // 						if(i==0)
	// 						$("#purchase_plan").append('<header class="panel-heading">Procurement Plan</header>');
						
 // 						$("#purchase_plan").append('<div class="row panel-body"><table class="table table-hover table-bordered"><tr><td  class="text-info"><strong>Vendor Name</strong></td><td class="vendor_name_'+i+' text-primary"><strong>'+(data[i].name_vendor != "" ? data[i].name_vendor : "Other")+'</strong></td></tr><tr><td class="text-info"><strong>Address</strong></td><td class="text-primary"><strong>'+address+'</strong></td></tr><tr><td class="text-info"><strong>Phone No</strong></td><td class="text-primary"><strong>'+phone+'</strong></td></tr><tr><td class="text-info"><strong>Payment Mode</strong></td><td class="text-primary"><strong>'+Payment_Name+'</strong></td></tr><tr><td class="text-info"><strong>Comments</strong></td><td class="text-primary"><strong>'+comments+'</strong></td></tr>'+table_contant+'');
  						
 // 					}
	// 				var total_table_summary ="";
	// 				var vendor_name,vendor_buying_value, vendor_selling_value, total_buying_value=0, total_selling_value=0;
	// 				for(j=0; j<data.length; j++)
	// 				{
	// 					vendor_name = $('.vendor_name_'+j).html();
	// 					vendor_buying_value =  $('.buyingPrice_'+j).html();
	// 					vendor_selling_value =  $('.sellingPrice_'+j).html();
						
	// 					total_table_summary += "<tr><td class='text-info'>"+vendor_name+"</td><td class='text-primary'>"+vendor_buying_value+"</td><td class='text-primary'>"+vendor_selling_value+"</td></tr>";
	// 					total_buying_value += parseFloat(vendor_buying_value);
	// 					total_selling_value += parseFloat(vendor_selling_value);
 // 					}
					
	// 				total_table_summary += "<tr><td  class='text-muted'><strong>Total :</strong></td><td class='text-success'><strong>"+parseFloat(total_buying_value).toFixed(2)+"</strong></td><td class='text-success'><strong>"+parseFloat(total_selling_value).toFixed(2)+"</strong></td></tr>";
					
	// 				$("#purchase_plan").append('<div class="row panel-body"><header class="panel-heading">Summary Page</header><table class="table table-striped table-hover table-bordered"><tr><td  class="text-muted"><strong>Vendor Name</strong></td><td class="text-muted" ><strong>Total Buying Price</strong></td><td class="text-muted"><strong>Total Selling Price</strong></td></tr>'+total_table_summary+'</table></div>');
 // 					$(".ajaxLoaderModal").hide();
 // 				},
 // 				timeout: 50000
				
	// });
}

function demoFromHTML() 
{
	
    var doc = new jsPDF('l','pt','a4');
    var source = $('#purchase_plan')[0];
    specialElementHandlers = {
        '#editor': function(element, renderer) {
            return true
        }
    };
    margins = {
        top: 40,
        bottom: 10,
        left:15,
		width:522
         
       };
	var c = document.getElementById("plan_logo");//kobster logo
	var ctx = c.getContext("2d");
	var img = document.getElementById("kobster_logo");
	ctx.drawImage(img, 10, 10);
	var logo = document.getElementById("plan_logo");
	var kobster_logo = logo.toDataURL("image/png");
	doc.addImage(kobster_logo,'PNG',85, 1,125,75);
	
	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	
		var procurement_date =((''+day).length<2 ? '0' : '') + day + '/' +((''+month).length<2 ? '0' : '') + month  + '/' + d.getFullYear();
	
	var fc_name = $("#listTitle").html();
	doc.text(355,30,  fc_name+' - Procurement plan  - '+procurement_date);
    doc.fromHTML(
            source, // HTML string or DOM elem ref.
            margins.left, // x coord
            margins.top, {// y coord
                'width': margins.width, // max width of content on PDF
                'elementHandlers': specialElementHandlers
            },
    function(dispose) {
        doc.save(''+fc_name+' - Procurement plan  - '+procurement_date+'.pdf');
    }
    , margins);		
			
}
	

function tableToJson(table) 
{
    var data = [];
     var headers = [];
      for (var i=0; i<table.rows[0].cells.length; i++) {
        headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
     }
     for (var i=0; i<table.rows.length; ++i) {

        var tableRow = table.rows[i];
        var rowData = {};
         for (var j=0; j<tableRow.cells.length; j++) {

            rowData[ headers[j] ] = tableRow.cells[j].innerHTML;

        }

        data.push(rowData);
     }       

    return data;
}
 
function paymentRequest(type)
{
	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("payment-request.php?ajax=true&type="+type+"", function( response, status, xhr ) 
	{
	  $(".ajaxLoaderModal").hide();
	});
}

function trackDelBox(type)
{
	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("track-delivery-box.php?ajax=true&type="+type+"", function( response, status, xhr ) 
	{
	  $(".ajaxLoaderModal").hide();
	});
}

function downloadProcurementExcel()
{
	$('#form-purchase-plan').empty();
  	$('#form-purchase-plan').append('<input id="id_fc" type="text" name="id_fc" value=' + global_id_fc + '>');
  	$('#form-purchase-plan').submit();
}

function downloadNewProcurementExcel()
{
	window.open("generate-new-purchase-plan.php?&id_fc=" + global_id_fc);
}

//Function to load delivery reports 
function loadDeliveryReport(type)
{
	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("get-delivery-report.php?ajax=true&type="+type+"", function( response, status, xhr ) 
	{
	  $(".ajaxLoaderModal").hide();
	});
}

//param1: type,param2: page,param3:order_per_page,param4: Tabs,param5: orderBy,param6: orderWay
function openOrders(type, page, order_per_page, tab, orderBy, orderWay, filter_type)
{

	$('#sidebar').addClass('hide-left-bar');
	$('#main-content').addClass('merge-left');
	
	var dataparam,jump_page = "", per_page = "", id_order = "", cus_name = "",grp_name = "", id_buyer = "", order_state = "", order_total = "", payment_type = "", order_status = "", fc = "", orderDateFrom = "", orderDateTo = "";

	jump_page = $('.scn-order-jump-page').val();
	per_page = $('.scn-order-per-page').val();
	id_order = $('#idOrder').val().trim();
	cus_name = encodeURIComponent($('#customerName').val());
	grp_name = encodeURIComponent($('#companyName').val());
	id_buyer = $('#idBuyer').val();
	order_state = $('#idState').val();
	order_total = $('#orderTotal').val();
	payment_type = $('#paymentType').val();
	order_status = $('#idOrderState').val();
	fc = $('#idFc').val();
	orderDateFrom = $('#order-date-from').val();
	orderDateTo = $('#order-date-to').val();

	if(filter_type == 1)
		dataparam = "smarty=1&type="+type+"&page="+page+"&order_per_page="+order_per_page+"&tab="+tab+"&order_by="+orderBy+"&order_way="+orderWay+"&order_per_page="+per_page+"&jump_page="+jump_page+"&id_order="+id_order+"&cus_name="+cus_name+"&grp_name="+grp_name+"&id_buyer="+id_buyer+"&state="+order_state+"&status="+order_status+"&total="+order_total+"&payment="+payment_type+"&fc="+fc+"&from_date="+orderDateFrom+"&to_date="+orderDateTo+"";
	else
		dataparam = "smarty=1&type="+type+"&page="+page+"&order_per_page="+order_per_page+"&tab="+tab+"&order_by="+orderBy+"&order_way="+orderWay+"";

	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("scn-orders.php?"+dataparam+"",function( response, status, xhr ) 
									{
									  $(".ajaxLoaderModal").hide();
									});
}

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