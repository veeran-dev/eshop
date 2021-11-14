function searchOrder()
{
	$("#home_icons").html("<input id='orderid' type='text' placeholder='Delivery Id ex: DE000228' class='col-sm-6 col-xs-6 form-control'><br><br><input id='dr_order_id' type='button' class='col-sm-6 col-xs-6 btn btn-success btn-block' value='Search' onclick='getOrder();' >");
}
function getOrder()
{
	var delivery_number=$("#orderid").val();
	var dr_number=delivery_number;
	var delivery_number = delivery_number.substring(2);
	delivery_number=parseInt(delivery_number);

	if(isNaN(delivery_number))
	{
		$("#idScnGlobalAlert").html('Enter valid order id');
		$('#scnGlobalAlert').modal('show');
		return false;		
	}
	var type=3;
 	var dataparam = '&type='+type+'&delivery_number='+delivery_number;
 	$.ajax({
				type: 'GET',
				dataType:'json',
				async: true,
				url: 'scn-orderstatus.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
					if(data==0)
					{
						$("#idScnGlobalAlert").html('Enter valid order id');
						$('#scnGlobalAlert').modal('show');
						return false;		
					}
					else if(data==2)
					{
						$("#idScnGlobalAlert").html('DR already delivered');
						$('#scnGlobalAlert').modal('show');
					}
					else
					{
						var len=(data.length)-1;
						paymentoption=data[len];
						$("#index_viewport").html('');
						var dr_header="<div class='col-sm-12 col-xs-12 drreceiptheader'>Delivery Receipt</div><div class='col-sm-4 col-xs-4 drreceiptspan'><span class='col-sm-12 col-xs-12 dr_head_span'><span>ORDER ID:</span>"+data[0].id_order+"</span><span class='col-sm-12 col-xs-12 dr_head_span'><span>SHIPPED ON:</span>"+data[0].date_generated+"</span></div><div class='col-sm-4 col-xs-4 drreceiptspan'><span class='col-sm-12 col-xs-12 dr_head_span'><span>PAYMENT OPTION:</span>"+paymentoption+"</span></div><div class='col-sm-4 col-xs-4 drreceiptspan'><span class='col-sm-12 col-xs-12 dr_head_span'><span>DELIVERED BY:</span>"+firstname+"</span><span class='col-sm-12 col-xs-12 dr_head_span'><span>DELIVERY SLIP:</span>"+dr_number+"</span></div>";
						var leftdr="<div class='col-sm-12 col-xs-12 dr_head_row' align='center'><div class='col-sm-1 col-xs-1 dr_left_head'>S.no</div><div class='col-sm-1 col-xs-1 dr_left_head'>Code</div><div class='col-sm-7 col-xs-7 dr_left_head'>Description</div><div class='col-sm-1 col-xs-1 dr_left_head'>Qty</div><div class='col-sm-2 col-xs-2 dr_left_head'>Delivered</div></div><div class='col-sm-12 col-xs-12 dr_head_row'><div class='col-sm-10 col-xs-10 dr_left_head dr_no'></div><div class='col-sm-1 col-xs-1 dr_left_head ' align='center'> Yes</div><div class='col-sm-1 col-xs-1 dr_left_head' align='center'>No</div></div> ";
						for(var i=0;i<(data.length-2);i++)
						{
							var prod_name=data[i].Product_name;
                            var prod_name = jQuery.trim(data[i]['Product_name']).substring(0, 60).trim(this);
                            var prod_name = prod_name.replace(/(<([^>]+)>)/ig,"");
							leftdr+="<div class='col-sm-12 col-xs-12 dr_row' align='center'><div class='col-sm-1 col-xs-1'>"+(i+1)+"</div><div class='col-sm-1 col-xs-1'>"+data[i].reference+"</div><div id='desc_"+i+"'class='col-sm-7 col-xs-7' value='1' align='left'>"+prod_name+"</div><div class='col-sm-1 col-xs-1' id='drqty_"+i+"'>"+data[i].quantity+"</div><div class='col-sm-1 col-xs-1'><input id='dr_hdn_qty_"+i+"' type='hidden' value="+data[i].quantity+"><input id='dr_hdn_cancel_"+i+"' class='dr_cancel' type='hidden' value='0' title="+data[i].id_order_detail+"><input id='dr_hdn_replace_"+i+"' class='dr_replace' type='hidden' value='0' title="+data[i].id_order_detail+"><img src='img/green-box.png' id='gb_"+i+"' onclick='changeDr(this,1,"+i+","+data[i].id_order_detail+","+data[i].id_order+");'></div><div class='col-sm-1 col-xs-1'><img src='img/red-box.png' id='rb_"+i+"' onclick='changeDr(this,2,"+i+","+data[i].id_order_detail+","+data[i].id_order+");'><input id='hv_"+i+"' type='hidden' value='0'></div></div> ";
						}
						len--;
						var rightdr="<div class='col-sm-12 col-xs-12'>Delivery Address</div><div class='col-sm-12 col-xs-12'>"+data[len][0].firstname+"</div><div class='col-sm-12 col-xs-12'>"+data[len][0].address1+"</div><div class='col-sm-12 col-xs-12'>"+data[len][0].city+"</div><div class='col-sm-12 col-xs-12'>"+data[len][0].state+"</div><div class='col-sm-12 col-xs-12'>"+data[len][0].country+"</div><div class='col-sm-12 col-xs-12'>"+data[len][0].postcode+"</div><div class='col-sm-12 col-xs-12'>"+data[len][0].phone_mobile+"</div><div id='drjSignature' class='col-sm-12 col-xs-12 dr-signature' onclick='drjSignature();'>Tap Here To Sign</div> ";
						$("#index_viewport").html("<div class='col-sm-12 col-xs-12'>"+dr_header+"</div><div class='col-sm-12 col-xs-12' ><div class='col-sm-8 col-xs-8 dr_left' >"+leftdr+"</div><div class='col-sm-4 col-xs-4' id='right_dr_addres' >"+rightdr+"</div></div>");
					}
				}
			});	
}
function changeDr(all,color,id2,idorderdetail,orderid)
{
	$("#hv_"+id2).val("1");
	$id=all.id;
	if(color==1)
	{
		$("#"+$id).attr("src","img/green-tick.png");
		$("#rb_"+id2).attr("src","img/red-box.png");
	}
	else if(color==2)
	{
		$qty=$("#dr_hdn_qty_"+id2).val();
		$("#"+$id).attr("src","img/red-tick.png");
		$("#gb_"+id2).attr("src","img/green-box.png");
		$("#idScnDRAlert").html("<div class='col-sm-12 col-xs-12'><span id='dr_cqty_"+id2+"' class='col-sm-12 col-xs-12 crntqty'>Current Quantity :"+$qty+"</span><div class='input-group m-bot15'><input type='text' id='dr-qty' onkeyDown='numbersOnly(event);' placeholder='Enter Quantity' class='form-control'><span class='input-group-btn'><button type='button' onclick='resetDrVal("+id2+");' class='btn btn-success'>Undo Changes</button></span></div></div><br><div><input type='submit' class='Dr-Return col-sm-3 col-xs-3 btn btn-primary' value='Replace' onclick='drReplace("+idorderdetail+","+orderid+","+id2+");'><input type='submit' class='Dr-Replace col-sm-3 col-xs-3 btn btn-primary' value='Remove' onclick='drRemove("+idorderdetail+","+orderid+","+id2+");'></div><p class='col-sm-12 col-xs-12' id='errormsg'></p></div>");
		$("#scnDRAlert").modal('show');
	}
}
function drRemove(idorderdetail,orderid,id)
{
	var quantity=$("#dr_hdn_qty_"+id).val();
	var qty=$("#dr-qty").val();
	var qty_change=qty;
	if((quantity-qty)<0 || qty==0)
	{
		$("#errormsg").html("Enter Valid quantity");
		return false;
	}
	$("#dr_hdn_qty_"+id).val(quantity-qty);
	$("#drqty_"+id).text(quantity-qty);
	$("#dr_cqty_"+id).text("Current Quantity:"+(quantity-qty));
	var Cancel=parseInt($("#dr_hdn_cancel_"+id).val())+parseInt(qty);
	$("#dr_hdn_cancel_"+id).val(Cancel);
	$("#errormsg").html(qty_change+" items Removed successfully");
	$("#dr-qty").val('');
}

function drReplace(idorderdetail,orderid,id)
{
	var quantity=$("#dr_hdn_qty_"+id).val();
	var qty=$("#dr-qty").val();
	var qty_change=qty;
	if((quantity-qty)<0 || qty==0)
	{
		$("#errormsg").html("Enter Valid quantity");
		return false;
	}
	$("#dr_hdn_qty_"+id).val(quantity-qty);
	$("#drqty_"+id).text(quantity-qty);
	$("#dr_cqty_"+id).text("Current Quantity:"+(quantity-qty));
	var Replace=parseInt($("#dr_hdn_replace_"+id).val())+parseInt(qty);
	$("#dr_hdn_replace_"+id).val(Replace);
	
	$("#errormsg").html(qty_change+" items Replaced successfully");
	$("#dr-qty").val('');
}

function numbersOnly(e)
{
	var key = e.keyCode;
	if (!((key == 8) || (key == 46) || (key == 188) || (key == 9) || (key ==109) || (key == 173)  || (key == 107) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105)))
	{
		e.preventDefault();
	}
}

function drjSignature()
{
	$(".error_msg").text('');
	for(var i=0;i<$(".dr_row").length;i++)
	{
		if($("#hv_"+i).val()!=1)
		{
			$("#idScnDRAlert").html("Kindly Check all the items and Sign");
			$("#scnDRAlert").modal('show');
			return false;
		}
	}
	$("#scnDRsign").modal('show');
	var receipt="";
	receipt ="<div class='col-sm-12 col-xs-12 dr_head_row'><div class='col-sm-3 col-xs-3 dr_left_head'>S.no</div><div class='col-sm-6 col-xs-6 dr_left_head'>Product</div><div class='col-sm-3 col-xs-3 dr_left_head'>Quantity</div></div>"	
	var j=1;
	for(var i=0;i<=$(".dr_row").length;i++)
	{
		var desc=$("#desc_"+i).text();
		var qty=$("#drqty_"+i).text();
		if(qty>0)
		{
			receipt +="<div class='col-sm-12 col-xs-12 dr_row_sign'><div class='col-sm-3 col-xs-3'>"+(j)+"</div><div class='col-sm-6 col-xs-6'>"+desc+"</div><div class='col-sm-3 col-xs-3'>"+qty+"</div></div>"	
			j++;
		}		
	}
	receipt +="<br><br>";
	$("#drReceiptdiv").html(receipt);
}
 $(document).ready(function() {
 	var signature=$("#idscnDRsign");
   	signature.jSignature({lineWidth:1,"width":"450px","height":"150px","margin-left":"100px","background-color":"#f5f5f5"});
 });

function importData()
{
	var Replacearray = new Array();
   	$('.dr_replace').each(function() {
        if ($(this).val() > 0)
            Replacearray.push($(this).val() + "-" + $(this).attr('title'));
    });

    var Cancelarray = new Array();
   	$('.dr_cancel').each(function() {
        if ($(this).val() > 0)
            Cancelarray.push($(this).val()+ "-" + $(this).attr('title'));
    });

	var $sigdiv = $("#idscnDRsign")
	var datapair = $sigdiv.jSignature("getData","base30");
	var name=$("#customer_name").val();
	
	if( $sigdiv.jSignature('getData', 'native').length == 0 || name=="")
	{
		$(".error_msg").text("Kindly Sign and Enter your name");
		return false;
	}
	var type=6;
 	var dataparam = '&type='+type+'&sign_img='+datapair+'&name='+name+'&Replacearray='+Replacearray+'&Cancelarray='+Cancelarray;
 	$.ajax({
				type: 'GET',
				dataType:'json',
				async: true,
				url: 'scn-orderstatus.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
					if(data==1)
					{
						$(".error_msg").text("DR Unable to complete");							;
						return false;
					}
					$("#scnDRsign").modal('hide');
					$("#idScnGlobalAlert").html('Delivered successfully');
					$('#scnGlobalAlert').modal('show');
						setTimeout(function(){
							location.reload(true);
	 					}, 1500);
				}
			});	
}

function clearData()
{
	var $sigdiv = $("#idscnDRsign");
	$sigdiv.jSignature('clear');
	$('#customer_name').val('');
}
function resetDrVal(id)
{
	$qty=parseInt($("#dr_hdn_qty_"+id).val())+ parseInt($("#dr_hdn_cancel_"+id).val())+parseInt($("#dr_hdn_replace_"+id).val());
	$("#dr_hdn_qty_"+id).val($qty);
	$("#drqty_"+id).text($qty);
	$("#dr_cqty_"+id).text("Current Quantity:"+$qty);
	$("#dr_hdn_cancel_"+id).val(0);
	$("#dr_hdn_replace_"+id).val(0);
	$("#dr-qty").val('');
	$("#errormsg").html("All items Reset successfully");
	$("#dr-qty").val('');
}