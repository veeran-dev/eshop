var loadtablevalue = 0;
window.incl_tax_total=0;
window.excl_tax_total=0;
 $(function()
{
	$('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });
});

$(document).ready(function ()
{
	
	loadPurchaseBill();

});

function loadPurchaseBill()
{
 	var type=1;
	var dataparam = '&type=' + type;
	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'scn-viewpurchasebilldata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
  			for(var i=0; i<data.length; i++)
			{
				if(data[i].id_payment==1)
				{
					payment_type="Cash On Delivery";
				}
				else if(data[i].id_payment==2)
				{
					payment_type="Cheque";
				}
				else if(data[i].id_payment==3)
				{
					payment_type="NEFT";
				}
				else
				{
					payment_type="Credit";
				}
				var sno=i+1;
				$("#bill_view").append("<tr class='cur-poi' id='purchase_bill_"+data[i].billno+"'><td id='"+data[i].billno+"' class='purchase-bill-row-no' >"+sno+"</td><td><input class='noBorder' readonly type=text id='bill_no_"+data[i].billno+"' value="+data[i].billno+"></td><td><input class='noBorder disabled' readonly id='bill_date_"+data[i].billno+"' value='"+data[i].bill_date+"'/></td><td id='vendor_"+data[i].billno+"' >"+data[i].name+"</td><td id='payment_"+data[i].billno+"' >"+payment_type+"</td><td id='total_"+data[i].billno+"'  class='fa fa-inr col-lg-2 totalPayment_"+data[i].billno+"' id='total_"+data[i].billno+"'> "+parseFloat(data[i].total).toFixed(2)+"</td><td class='purcahseBillListTd '><input type='hidden' id='delete_row_"+i+"'  value='"+i+"' /><span class='fa fa-save col-lg-1 savePart_"+data[i].billno+"' style='display:none' onclick='updateBillDetails(\""+data[i].billno+"\");' ></span><span class='fa fa-reply col-lg-1 savePart_"+data[i].billno+"' style='display:none' onclick='cancelBillDetails(\""+data[i].billno+"\");' ></span><span class='fa fa-eye col-lg-1 editPart_"+data[i].billno+"' onclick='openBillDetails("+data[i].id_vendor+",\""+data[i].billno+"\");' ></span><span id='edit_"+data[i].billno+"' class='fa fa-pencil-square-o col-lg-1 editPart_"+data[i].billno+"' onclick='editDateBill(\""+data[i].billno+"\");'></span><span id="+data[i].billno+" class='fa fa-trash-o col-lg-1 editPart_"+data[i].billno+"' onclick='deleteBill("+data[i].id_vendor+",0,0,0,0,"+i+",this);'></span></td></tr>");
			}
			setTimeout(function(){	
				 EditableTable.init();					  
			}, 500);
		}
	});
}
function openBillDetails(id_vendor,billno)
{
			
 	$("#head_bill_no").html(billno);
	var type=2;
	$("#bill_details").html('');
	var dataparam = '&type=' + type+'&billno=' + billno+'&id_vendor=' + id_vendor;
 	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'scn-viewpurchasebilldata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
 			var total_excl=0;
			var total_incl=0;
 			for(var i=0; i<data.length; i++)
			{
				var sno=i+1;
				
				if(data[i].tax == 1)
					taxvalue="0";
				else if(data[i].tax == 2)
					taxvalue="5";	
				else
					taxvalue="14.5";
					
				var total_excl_price=data[i].product_qty*data[i].unit_price;
				var total_incl_tax_value=data[i].product_qty*data[i].unit_price*taxvalue/100;
				
				total_excl +=total_excl_price;
				total_incl +=total_excl_price+total_incl_tax_value;
				
 				$("#bill_details").append("<tr id='bill_product_"+data[i].id_vendor_purchase+"'><td>"+sno+"</td><td><input  type='text' id='bill_no_"+sno+"' size='10' class='noBorder' value="+billno+" readonly></td><td><input size='12' placeholder='dd-mm-yyyy'  type='text' id='bill_date_"+sno+"' class='noBorder numbersOnly' value="+data[i].bill_date+" readonly></td><td>"+data[i].name+"</td><td><input size='5' onkeydown='numbersOnly(event);' type='text' id='qty_"+sno+"' class='noBorder numbersOnly' value="+data[i].product_qty+" readonly></td><td><input size='10' type='text' id='unit_price_"+sno+"' onkeydown='numbersOnly(event);' class='noBorder numbersOnly' value="+parseFloat(data[i].unit_price).toFixed(2)+" readonly></td><td>Rs. "+total_excl_price+"</td><td><span id='tax1_"+sno+"' >"+taxvalue+"%</span><select id='tax2_"+sno+"' style='display:none;'><option value='1'>0%</option><option value='2'>5%</option><option value='3'>14.5%</option></select></td><td><span id='"+billno+"' class='fa fa-trash-o cur-poi "+sno+"_delete' onclick='deleteBill("+data[i].id_vendor+","+data[i].id_vendor_purchase+","+data[i].product_qty+","+data[i].unit_price+","+taxvalue+","+i+",this);'></span>  <span id="+billno+" class='fa fa-save cur-poi "+sno+"_save' style='display:none' onclick='saveBill("+data[i].id_vendor+","+data[i].id_vendor_purchase+","+sno+",this);''></span>  <span id="+billno+" class='fa fa-reply cur-poi "+sno+"_cancel' style='display:none' onclick='editViewBill("+sno+",1,"+id_vendor+",this);'></span>  <span class='fa fa-edit cur-poi "+sno+"_edit' onclick='editViewBill("+sno+",2);'></span></td></tr>");
				
 			}
 			$('#tax2_'+sno+' select').val(data.tax);
			excl_tax_total = total_excl;
			incl_tax_total = total_incl;
			$("#total_exc").html("Rs. "+parseFloat(total_excl).toFixed(2));
			$("#total_inc").html("Rs. "+parseFloat(total_incl).toFixed(2));
			$('#purchase_bill_details').modal('show');
			
			
		}
	});
 }
function editViewBill(sno,id,id_vendor,properties)
{
	if(id==2)
	{
		$('.'+sno+'_save').show();
		$('.'+sno+'_cancel').show();
		$('.'+sno+'_delete').hide();
		$('.'+sno+'_edit').hide();
		$('#tax1_'+sno).hide();
		$('#tax2_'+sno).show();
		$('#qty_'+sno).removeClass("noBorder");
		$('#qty_'+sno).attr('readonly',false);
		$('#unit_price_'+sno).removeClass("noBorder");
		$('#unit_price_'+sno).attr('readonly',false);
		$('#tax_'+sno).removeClass("noBorder");
		$('#tax_'+sno).attr('readonly',false);
		
		$('#bill_no_'+sno).removeClass("noBorder");
		$('#bill_date_'+sno).removeClass("noBorder");
		$('#bill_date_'+sno).attr('readonly',false);
		$('#bill_no_'+sno).attr('readonly',false);

	}
	else if(id==1)
	{
		openBillDetails(id_vendor,properties);
	}

}
function deleteBill(id_vendor,id_vendor_purchase,product_qty,unit_price,taxvalue,i,properties)
{
	var row = $('#delete_row_'+i).val();
	var billno= properties.id;
 	var type=3;
	var dataparam = '&type=' + type+'&billno=' + billno+'&id_vendor=' + id_vendor+'&id_vendor_purchase=' + id_vendor_purchase;
	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'scn-viewpurchasebilldata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			if(id_vendor_purchase=="0")
			{
				$('#purchase_bill_'+billno+'').remove();
				var i=1;
				$('.purchase-bill-row-no').each(function(){
					$(this).html(i);
					i++;
				});
			}				
 			else
			{
 				
 				var temp_total_excl= product_qty*unit_price;
				var total_excl=excl_tax_total-temp_total_excl;
  				var temp_total_incl_tax= product_qty*unit_price*taxvalue/100;
  				var temp_total_incl=temp_total_excl+temp_total_incl_tax;
 				var total_incl=incl_tax_total-temp_total_incl;
 				$("#total_exc").html("Rs. "+total_excl);
 				$(".totalPayment_"+billno).html(parseFloat(total_excl));
 				$("#total_inc").html("Rs. "+total_incl);
				$('#bill_product_'+id_vendor_purchase).remove();
				incl_tax_total=total_incl;
				excl_tax_total=total_excl;
			}
			if(taxvalue==0)
			{
				
				var i=0;
				$('.purcahseBillListTd input').each(function(){
					$(this).val(i);
					i++;
				});
				$("#purchasebils").dataTable().fnDeleteRow( row );
			}
 		}
	});
}
function saveBill(id_vendor,id_vendor_purchase,sno,properties)
{
	product_qty=$('#qty_'+sno).val();
	billno = $('#bill_no_'+sno).val();
	billdate = $('#bill_date_'+sno).val();
	unit_price=$('#unit_price_'+sno).val();
	taxvalue=$('#tax2_'+sno+' option:selected').val();
	
	if(product_qty=="")
	{
		$('#qty_'+sno).css({"border":"2px solid #cc0000"});
		return false;
	}
	if(unit_price=="")
	{
		$('#unit_price_'+sno).css({"border":"2px solid #cc0000"});
		return false;
	}
 	var type=7;
	var dataparam = '&type=' + type+'&id_vendor_purchase=' + id_vendor_purchase+'&product_qty='+product_qty+'&unit_price='+unit_price+'&tax='+taxvalue+'&billno='+billno+'&billdate='+billdate;
	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'scn-viewpurchasebilldata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
 			openBillDetails(id_vendor,properties);			
 		}
	});
}
 
 
var EditableTable = function () {

    return {

        //main function to initiate the module
        init: function () {
			
			var oTable = $('#purchasebils').dataTable({
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
                "aoColumnDefs": [{
                        'bSortable': true,
                        'aTargets': [0]
                    }
                ]
            });
			 }

    }; 
}();

function numbersOnly(e)
{
	var key = e.keyCode;if (!((key == 8) || (key == 46) || (key == 188) || (key == 9) || (key ==109) || (key == 173)  || (key == 107) || (key == 190) || (key == 110) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}

function editDateBill(billno)
{
 	$("#bill_no_"+billno ).removeClass('noBorder');
 	$("#bill_no_"+billno ).attr('readonly',false);
	$("#bill_date_"+billno ).removeClass('noBorder disabled');
	$("#bill_date_"+billno ).attr('readonly',false);
	$("#bill_date_"+billno ).addClass('picker');
	$('.picker').datepicker({
        format: 'dd-mm-yyyy'
    });
	$('.savePart_'+billno).show();
	$('.editPart_'+billno).hide();
	
 	
}
function cancelBillDetails(billno)
{
	$("#bill_no_"+billno ).addClass('noBorder');
	$("#bill_no_"+billno ).attr('readonly',true);
	$("#bill_date_"+billno ).addClass('noBorder disabled');
	$("#bill_date_"+billno ).attr('readonly',true);
	$("#bill_date_"+billno ).removeClass('picker');
	$('.savePart_'+billno).hide();
	$('.editPart_'+billno).show();
}
function updateBillDetails(oldbillno)
{	
	var billno = $("#bill_no_"+oldbillno ).val();
	var billdate = $("#bill_date_"+oldbillno ).val();
	var type= 8;
	var dataparam = '&type=' + type+'&billdate=' + billdate+'&billno='+billno+'&old_billno='+oldbillno;
	$.ajax({
		type: 'POST',
		dataType:'json',
		async: true,
		url: 'scn-viewpurchasebilldata.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
 			viewPurchaseBill();
			
  		}
	});
}