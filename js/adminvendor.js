/*type1=>Add and update vendor address
type2=>autocomplete for vendor address
type3=>auto complete for vendor product mapping
type4=>add the product vendor mapping
type5=>to check exist email
type6=>to get product code and productid
type7=>to get reference code of productid
type8=>get all value for edit product vendor mapping
type9=>delete the vendor product mapping
type10=>get all the vendors who are in active
type11=>delete the vendor
*/
function fn_addvendor()
{
	$("#vendor").show();
   	$('#close_vendor').show();
	$('#add_vendor').hide();
}
function fn_close_add()
{
	$('#vendor').hide();
	$('#close_vendor').hide();
	$('#add_vendor').show();
}
function fn_addproduct()
{
	$("#product_vendor_form").show();
	$("#edit_vendor_form").hide();
	$("#vendor_form").hide();
	$("#vendor").hide();
}
function fn_cancel_add()
{	
	alert("cancel");
	$('#hid_ven_id').val("");
	$('#vendorname').val("");
	$('#ven_address').val("");
	$('#ven_email').val("");
	$('#mobile_no').val("");
	$('#tin_no').val("");
	$('#cst_no').val("");
	$('#ven_rating').val("");
	$("#credit").attr('checked',false);
	$("#delivery").attr('checked',false);
	$('.error_list').html("");
}

function fn_email()
{
	var email=$('#ven_email').val();
	var type=5;
	var dataparam = '&email=' + email+'&type='+type;
	$.ajax({
			type: 'GET',
			async: true,
			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{
 				if(data!=0)
				{
 					$('#error_email').html('Email already exist');
					return false;
				}
				
			}
	});
}
function fn_savevendor()
{	
	$('#error_mobile').html("");
	$('#error_cst').html("");
	$('#error_tin').html("");
	$('#error_add').html("");
	$('#error_name').html("");
	$('#error_rate').html("");
	$('#error_email').html("");
	var vendor_id=$('#hid_ven_id').val();
	var vendorname=$('#vendorname').val();
	var address=$('#ven_address').val();
	var email=$('#ven_email').val();
	var mobile=$('#mobile_no').val();
	var tinno=$('#tin_no').val();
	var cstno=$('#cst_no').val();
	var rating=$('#ven_rating').val();
	var status=1;
	var emailstatus=$('#error_email').html();
 	if($("#credit").is(':checked'))
		var credit=1;
	else
		var credit=0;
	if($("#delivery").is(':checked'))
		var delivery=1;
	else
		var delivery=0;
	var type=1;
 	
	if(rating == 0)
	{
 		$('#error_rate').html('Please choose Rating');
		status=0;
  	}
	if(email=="")
	{
		$('#error_email').html('Please enter email');
		status=0;
 	}
	if(email != "")
	{
 		if(!email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/))
		{
			$('#error_email').html('Please enter valid email');
			status=0;
		}
 	}
	if(vendorname=="")
	{
		$('#error_name').html('Please enter vendor name');
		status=0;
 	}
 	if(vendorname != "")
	{
		if(!vendorname.match(/^[a-zA-Z ]*$/))
		{
			$('#error_name').html('Please enter a valid Name');
			 status=0;
 		}
	}
	 if(address=="")
	{
		$('#error_add').html('Enter vendor Address');
		status=0;
	}
	if(address != "")
	{
		if(!address.match(/^[a-zA-Z0-9-#.,()&'\/\"\s]*$/))
		{
			$('#error_add').html('Enter a valid address');
			 status=0;
		}
	}
	if(tinno=="")
	{
		$('#error_tin').html('Please enter TIN Number');
		status=0;
 	}
	if(cstno=="")
	{
		$('#error_cst').html('Please enter your CST Number');
		status=0;
 	}
	if(mobile=="")
	{
		$('#error_mobile').html('Please enter vendor Mobile Number');
		status=0;
 	}
	if(mobile != "")
	{
		if(!mobile.match(/^[0-9]+$/))
		{
			$('#error_mobile').html('Only numbers allowed');
			status=0;
 		}
	}
	if(mobile != "")
	{
		if(mobile.length<10)
		{
			$('#error_mobile').html('Mobile number should be of 10 digits');
			status=0;
 		}
	} 
	if(status==0 || emailstatus!="" )
	{
		return false;
	}
	else
	{
	var dataparam = '&vendor_id=' + vendor_id+'&vendorname=' + vendorname+'&address='+address+'&email='+email+'&mobile='+mobile+'&tinno='+tinno+'&cstno='+cstno+'&rating='+rating+'&credit='+credit+'&delivery='+delivery+'&type='+type;
	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
				if(data.result==2)
					var status='vendor added successfully';
				if(data.result==1)
 					var status='vendor updated successfully';
					
				if(data != 0 && data !="")
				{	
 					/*successfully Vendor Inserted*/
					if(data.result == 2)
					{
 						if(data[0].vendor_credit == 1)
							var credit_status='<img src="../img/admin/enabled.gif">';
						else
							var credit_status='<img src="../img/admin/disabled.gif">';
						if(data[0].vendor_delivery == 1)
							var delivery_status='<img src="../img/admin/enabled.gif">';
						else
							var delivery_status='<img src="../img/admin/disabled.gif">';
 						$("#vendor_details").append("<tr id='tr_ven_"+data[0].id_vendor+"'><td id='td_name_"+data[0].id_vendor+"'  class='pointer center'>" + data[0].vendor_name + "</td><td id='td_add_"+data[0].id_vendor+"' class='pointer center address_limit' >" + data[0].vendor_address+ "</td><td id='td_email_"+data[0].id_vendor+"' class='pointer center'>" + data[0].vendor_email + "</td><td id='td_mobile_"+data[0].id_vendor+"' class='pointer center'>" + data[0].vendor_mobile + "</td><td id='td_credit_"+data[0].id_vendor+"' class='pointer center'>" + credit_status+ "</td><td id='td_delivery_"+data[0].id_vendor+"' class='pointer center'>" + delivery_status + "</td><td id='td_tin_"+data[0].id_vendor+"' class='pointer center'>" + data[0].vendor_tin_no + "</td><td id='td_cst_"+data[0].id_vendor+"' class='pointer center'>" + data[0].vendor_cst_no + "</td><td id='td_rate_"+data[0].id_vendor+"' class='pointer center'>" + data[0].vendor_preference + "</td><td class='pointer center' ><img title='Edit' alt='Edit' onclick='fn_edit_ven("+data[0].id_vendor+")' src='../img/admin/edit.gif'>&nbsp;<img title='Delete' onclick='fn_delete_ven("+data[0].id_vendor+");' alt='Delete' src='../img/admin/delete.gif'></td></tr>");				
					}
					/*successfully Vendor updated*/
					if(data.result == 1)
					{
 						$('#td_name_'+data[0].id_vendor).html(data[0].vendor_name);
						$('#td_add_'+data[0].id_vendor).html(data[0].vendor_address);
						$('#td_email_'+data[0].id_vendor).html(data[0].vendor_email);
						$('#td_mobile_'+data[0].id_vendor).html(data[0].vendor_mobile);
						$('#td_tin_'+data[0].id_vendor).html(data[0].vendor_tin_no);
						$('#td_cst_'+data[0].id_vendor).html(data[0].vendor_cst_no);
						$('#td_rate_'+data[0].id_vendor).html(data[0].vendor_preference);
						if(data[0].vendor_credit == 1)
							var credit_status='<img src="../img/admin/enabled.gif">';
						else
							var credit_status='<img src="../img/admin/disabled.gif">';
						if(data[0].vendor_delivery == 1)
							var delivery_status='<img src="../img/admin/enabled.gif">';
						else
							var delivery_status='<img src="../img/admin/disabled.gif">';
						$('#td_credit_'+data[0].id_vendor).html(credit_status);
						$('#td_delivery_'+data[0].id_vendor).html(delivery_status);
					}
					$('#vendor_details').val("");
					$('#vendorname').val("");
					$('#ven_address').val("");
					$('#ven_email').val("");
					$('#mobile_no').val("");
					$('#tin_no').val("");
					$('#cst_no').val("");
					$('#ven_rating').val("");
					$('#hid_ven_id').val("");
					$('#credit').attr('checked',false);
					$('#delivery').attr('checked',false);
				}
				else
				{
					alert("vendor not added successfully");
				}
			}
		});
	}
}
/*to edit the particular vendor*/
function fn_edit_ven(vendorid)
{
	var type=2;
	var dataparam = '&vendor_id=' + vendorid+'&type='+type;
  	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
  			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{ 
 				$("#vendor").show();
				$('#hid_ven_id').val(data[0].id_vendor);
				$('#vendorname').val(data[0].vendor_name);
				$('#ven_address').val(data[0].vendor_address);
				$('#ven_email').val(data[0].vendor_email);
				$('#mobile_no').val(data[0].vendor_mobile);
				$('#tin_no').val(data[0].vendor_tin_no);
				$('#cst_no').val(data[0].vendor_cst_no);
				$('#ven_rating').val(data[0].vendor_preference);
				if(data[0].vendor_credit==1)
					$('#credit').attr('checked',true);
				else	
					$('#credit').attr('checked',false);
					
				if(data[0].vendor_delivery==1)
					$('#delivery').attr('checked',true);
				else	
					$('#delivery').attr('checked',false);
			}
	});
}

/*to delete the vendor*/
function fn_delete_ven(vendorid)
{
	if (confirm("Are you sure wnt to delete the vendor?")) {
      var type=11;
	  var dataparam = '&vendor_id=' + vendorid+'&type='+type;
	  
   	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
  			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{ 
  				if(data == 1)
				{
					alert("Vendor deleted successfully");
 					$('#tr_ven_'+vendorid).remove();
  				}
				 else
				 {
				 	alert("Not deleted successfully");
 				 }
			}
	  });
    }
    return false;
}

/*************Vendor Product Mapping form js***********************/
function fn_savepro_ven()
{	
	var vendor_id=$('#hid_pro_ven_id').val();
	var prod_code=$('#pro_code').val();
	var prod_price=$('#pro_price').val();
	var prod_edit=$('#hid_product_edit').val();
	if(prod_edit !="")
		prod_edit = 1;
	else 
		prod_edit =0
  	var type=4;
	var dataparam = '&vendor_id=' + vendor_id+'&prod_code=' + prod_code+'&prod_price='+prod_price+'&type='+type+'&prod_edit='+prod_edit;
    	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
   				if(data != 0)
				{
					alert("product mapped successfully");
					$('#td_'+vendor_id).html(data);
					$('#pro_vendor_details').val("");
					$('#pro_price').val("");
					$('#hid_product_edit').val("");
 					$("#vendor_table").append("<tr id='tr_"+data[0].id_vendor+"'><td class='pointer center'>" + data[0].vendor_name + "</td><td class='pointer center' id='td_"+data[0].id_vendor+"'>" + data[0].product_price+ "</td><td class='pointer center'>"+ data[0].vendor_preference + "</td><td class='pointer center'><img title='Edit' alt='Edit' onclick='fn_edit("+data[0].id_vendor+","+data[0].id_product_reference+")' id='edit_"+data[0].id_vendor+"' src='../img/admin/edit.gif'>&nbsp;<img title='Delete' onclick='fn_delete("+data[0].id_vendor+","+data[0].id_product_reference+")' id='delete_"+data[0].id_vendor+"' alt='Delete' src='../img/admin/delete.gif'></td></tr>");
					
					
					
 					$('#product_vendor_form').reset();
				}
				else if (data == 0)
				{
					alert("product not mapped");
					$('#product_vendor_form').reset();
				}
				 
			}
		});
}

function fn_cancel()
{
 	$('#pro_vendor_details').val("");
	$('#pro_price').val("");
	$('#pro_vendor_details').attr('readonly', false);
}

 
$(document).ready(function()
{	
	
	/*Auto complet for vendorname in vendor and productmapping*/
    $("#pro_vendor_details").autocomplete(
		"vendor.php?&type=3", {
		selectFirst: false,
		dataType: "json",
		minChars: 3,
		max: 10,
		formatItem: function(data, i, max, value, term) {
			return value;
		},
		parse: function(data) {
			var mytab = new Array();
			for (var i = 0; i < data.length; i++)
				mytab[mytab.length] = { data: data[i].id_vendor, value: data[i].vendor_name };
			return mytab;
 		}
	}
  ).result(function(event, data, formatted, value) {
				$('#pro_vendor_details').val(formatted);
				$('#hid_pro_ven_id').val(data);
 				
				
	})
	/*to get the product code and vendor details*/
	var product_id=$("#hid_product_id").val();
 	var type=6;
	var dataparam = '&product_id=' + product_id+'&type='+type;
 	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
  			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
 				for (var i = 0; i< data.length; i ++) {
 					$("#vendor_table").append("<tr id='tr_"+data[i].id_vendor+"'><td  class='pointer center'>" + data[i].vendor_name + "</td><td class='pointer center' id='td_"+data[i].id_vendor+"' >" + data[i].product_price+ "</td><td class='pointer center'>" + data[i].vendor_preference + "</td><td class='pointer center'><img title='Edit' alt='Edit' onclick='fn_edit("+data[i].id_vendor+","+data[i].id_product_reference+")' id='edit_"+data[i].id_vendor+"' src='../img/admin/edit.gif'>&nbsp;<img title='Delete' onclick='fn_delete("+data[i].id_vendor+","+data[i].id_product_reference+")' id='delete_"+data[i].id_vendor+"' alt='Delete' src='../img/admin/delete.gif'></td></tr>");
				}
			}
		});
	/*to get only the product code */
	var product_id=$("#hid_product_id").val();
 	var type=7;
	var dataparam = '&product_id=' + product_id+'&type='+type;
 	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
  			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
 				$('#pro_code').val(data[0].reference);
				
			}
		});
		
		/*To get all the vendors details*/
		var type=10;
		var dataparam = '&type='+type;
 		$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
  			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{	
				
 				for (var i = 0; i< data.length; i ++) {
					if(data[i].vendor_credit == 1)
 						var credit_status='<img src="../img/admin/enabled.gif">';
 					else
  						var credit_status='<img src="../img/admin/disabled.gif">';
 					if(data[i].vendor_delivery == 1)
						var delivery_status='<img src="../img/admin/enabled.gif">';
					else
						var delivery_status='<img src="../img/admin/disabled.gif">';
 					$("#vendor_details").append("<tr id='tr_ven_"+data[i].id_vendor+"'><td id='td_name_"+data[i].id_vendor+"'  class='pointer center'>" + data[i].vendor_name + "</td><td id='td_add_"+data[i].id_vendor+"' class='pointer center address_limit' >" + data[i].vendor_address+ "</td><td id='td_email_"+data[i].id_vendor+"' class='pointer center'>" + data[i].vendor_email + "</td><td id='td_mobile_"+data[i].id_vendor+"' class='pointer center'>" + data[i].vendor_mobile + "</td><td id='td_credit_"+data[i].id_vendor+"' class='pointer center'>" + credit_status+ "</td><td id='td_delivery_"+data[i].id_vendor+"' class='pointer center'>" + delivery_status + "</td><td id='td_tin_"+data[i].id_vendor+"' class='pointer center'>" + data[i].vendor_tin_no + "</td><td id='td_cst_"+data[i].id_vendor+"' class='pointer center'>" + data[i].vendor_cst_no + "</td><td id='td_rate_"+data[i].id_vendor+"' class='pointer center'>" + data[i].vendor_preference + "</td><td class='pointer center' ><img title='Edit' alt='Edit' onclick='fn_edit_ven("+data[i].id_vendor+")' src='../img/admin/edit.gif'>&nbsp;<img title='Delete' onclick='fn_delete_ven("+data[i].id_vendor+");' alt='Delete' src='../img/admin/delete.gif'></td></tr>");

				}
			}
		});
		
 });
 
/*to edit the vendor product mapping*/
function fn_edit(vendorid,productcode)
{	
	var type=8;
	var dataparam = '&vendor_id=' + vendorid+'&type='+type+'&prod_code=' + productcode;
  	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
  			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{ 
				$('#pro_vendor_details').val(data[0].vendor_name);
				$('#pro_code').val(data[0].id_product_reference);
				$('#pro_price').val(data[0].product_price);
				$('#hid_product_edit').val(1);
				$('#hid_pro_ven_id').val(data[0].id_vendor);
				$('#pro_vendor_details').attr('readonly', true);
			}
	});
}
	
/*to delete the vendor product mapping*/
function fn_delete(vendorid,productcode)
{
	if (confirm("Are you sure?")) {
      var type=9;
	  var dataparam = '&vendor_id=' + vendorid+'&type='+type+'&prod_code=' + productcode;
	  
   	$.ajax({
			type: 'GET',
			async: true,
			dataType: "json",
  			url: 'vendor.php',
			data: dataparam,
			cache: false,
			success: function(data)
			{ 
			
				if(data == 1)
				{
 				 $('#tr_'+vendorid).remove();
  				}
				 else
				 {
				 	alert("Vendor Not deleted successfully");
 				 }
			}
	  });
    }
    return false;
}

 