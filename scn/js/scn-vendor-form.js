$(document).ready(function(e) {

 	$.ajax({
		type: 'GET',
		dataType:'json',
		async: true,
		url: 'scn-vendor-form-fc.php',
		//data: dataparam,
		cache: true,
		success: function(data)
		{
			var select;
			if(data.length>0)
			{
				for(var i=0;i<data.length;i++)
				{
					select +="<option value="+data[i].id_fulfillment_centre+">"+data[i].city_name+"</option>";
				}
			}
			$("#fulfillmentCentre").html("<select id='vendorfc' class='col-md-12 form-control color'><option>Select FC</option>"+select+"</select>");
		}
	});
	$('#vendor-details-main-div').hide();
	$('#vendor-address-main-div').hide();
	$('#vendor-poc-main-div').hide();
	$('#vendor-details-complete').hide();
	$('#vendor-details-Cancel').click(function()
	{
		$('#vendor-details-main-div').hide();
		$('#vendor-address-main-div').hide();
		$('#vendor-poc-main-div').hide();
		$('#vendor-details-add').show();	
	});
	$('#vendor-details-add').click(function()
	{
		$('#vendor-details-main-div').show();
		$('#vendor-details-add').hide();
		$('#vendor-details-Cancel').show();
			
	});
	$('#vendor-details-complete').click(function()
	{
	$('#vendor-details-main-div').hide();
	$('#vendor-address-main-div').hide();
	$('#vendor-poc-main-div').hide();
	$('#vendor-details-complete').hide();
	$('#vendor-details-add').show();
	

	});
	
	
	
			window.vendorAddressCount=0;
window.vendorPocCount=0;
	$('#vendor-address-add').click(
	function()
	{
		$('.vendorName').hide();
		$('.vendor-address-delete-button').hide();
		$('#vendor-address-add').hide();
		$.ajax({
			type: 'POST',
			url: 'dash-address.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{type:1},
			success: function(jsonData)
			{
				$("#vendor-address").append("<form  id='Vendor-Address"+vendorAddressCount+"' method='post' class='std'><div class='required col-md-12 vendor-form-margin-top'><input id='vendor-address-name"+vendorAddressCount+"' class='col-md-12 form-control' type='text' placeholder='Name of the Address' name='addressName'/></div><div class='col-md-12 vendor-form-margin-top'><textarea rows='3' placeholder='Address'  id='vendor-address"+vendorAddressCount+"'class=' col-md-12 form-control' type='text' name='address'></textarea></div><div  class='col-md-12 vendor-form-margin-top'><input id='vendor-address-city"+vendorAddressCount+"' class='col-md-12 form-control' type='text' onkeydown='alphabetsOnly(event)' placeholder='City' name=''  /></div><div  class=' col-md-12 vendor-form-margin-top'> <select id='vendor-address-country"+vendorAddressCount+"'  class=' col-md-12 country form-control color' type='text'   placeholder='State' onchange='selectCountry("+vendorAddressCount+");'><option value=''>Country</option></select></div><div  class=' col-md-12 vendor-form-margin-top' ><select id='vendor-address-state"+vendorAddressCount+"'  class=' col-md-12 form-control color' type='text' placeholder='State'><option value=''>State</option></select></div><div  class=' col-md-12 vendor-form-margin-top' ><input id='vendor-address-pincode"+vendorAddressCount+"' class='col-md-12 form-control' type='text' onkeydown='numbersOnly(event)' placeholder='Pincode' name='Pincode' maxlength='6'/></div><div  class=' col-md-12 vendor-form-margin-top' ><input id='vendor-address-landmark"+vendorAddressCount+"' class='col-md-12 form-control' type='text'   placeholder='Landmark' name='Landmark'/></div><div  class=' col-md-12 vendor-form-margin-top' ><input  id='vendor-address-phone"+vendorAddressCount+"' class='col-md-12 form-control' type='text' onkeydown='numbersOnly(event)'  placeholder='Phone' name='Phone' /></div><div  class=' col-md-12 vendor-form-margin-top' ><input  id='vendor-address-fax"+vendorAddressCount+"' class='col-md-12 form-control' type='text' onkeydown='numbersOnly(event)'  placeholder='Fax' name='Fax' /></div><div  class=' col-md-12 vendor-form-margin-top' ><input  id='vendor-address-working-days"+vendorAddressCount+"'class='col-md-12 form-control' type='text'   placeholder='Working Days' name='Working Days' /></div><div  class=' col-md-12 vendor-form-margin-top' ><input  id='vendor-address-working-hours"+vendorAddressCount+"' class='col-md-12 form-control' type='text' placeholder='Working Hours' name='Working Hours' /></div><div  class='col-md-12 vendor-form-margin-top'>Delivery Available:&nbsp;&nbsp;<input type='radio' name='AddressDelivery' value='1'>&nbsp;Yes&nbsp;<input type='radio' name='AddressDelivery' value='0'>&nbsp;No</div><div  class='col-md-12 vendor-form-margin-top'>Default Address:&nbsp;&nbsp;<input type='radio' name='defaultAddress' value='1'>&nbsp;Yes&nbsp;<input type='radio' name='defaultAddress' value='0'>&nbsp;No</div><div  class=' col-md-12 vendor-form-margin-top'>Comments:<br><textarea rows='3'  id='vendor-address-comments"+vendorAddressCount+"' class=' col-md-12  form-control' type='text' ></textarea></div><a onClick='getAddress("+vendorAddressCount+",3,"+vendorId+");' id='vendor-address-save"+vendorAddressCount+"' class='col-md-5 vendor-address-button btn btn-primary vendor-form-margin-top'>Save</a><a onClick='cancelAddress("+vendorAddressCount+");' id='vendor-address-cancel"+vendorAddressCount+"' class='col-md-5 vendor-address-button btn btn-primary vendor-form-margin-top'>Cancel</a></form>");
				if(jsonData=="null" || jsonData=="")
				{
					return false;
				}
				else
				{
				for(var j=0;j<jsonData.length;j++)
				{	//alert(jsonData[0][i].id_address);
					//$('#vendor-address-state'+vendorAddressCount).append("<option  class='col-md-12' value='"+jsonData[j].id_state+"'>"+jsonData[j].name+"</option>");
					if(jsonData[j].id==110)
				{
					$('#vendor-address-country'+vendorAddressCount).append("<option selected='selected' class='col-md-12' value='"+jsonData[j].id+"'>"+jsonData[j].name+"</option>");
					selectCountry(vendorAddressCount);
				}
				else
				{
					$('#vendor-address-country'+vendorAddressCount).append("<option  class='col-md-12' value='"+jsonData[j].id+"'>"+jsonData[j].name+"</option>");

				}
				}
				}
				 			vendorAddressCount++;

			}
	});
 
/*$("#vendor-address").append("<form  id='Vendor-Address"+vendorAddressCount+"' method='post' class='std'><div class='required col-md-12 vendor-form-margin-top'><input id='vendor-address-name"+vendorAddressCount+"' class='col-md-12' type='text'  placeholder='Name of the Address' name='addressName'/></div><div class='col-md-12 vendor-form-margin-top'>Address:<br><textarea rows='3'  class=' col-md-12' type='text'  placeholder='Address' name='address'></textarea></div><div  class='col-md-12 vendor-form-margin-top'><input  class='col-md-12' type='text'   placeholder='City' name=''  /></div><div  class=' col-md-12 vendor-form-margin-top' ><select  class=' col-md-12' type='text'   placeholder='State'><option value=''>State</option></select></div><div  class=' col-md-12 vendor-form-margin-top'> <select  class=' col-md-12' type='text'   placeholder='State'><option value=''>Country</option></select></div><div  class=' col-md-12 vendor-form-margin-top' ><input  class='col-md-12' type='text'   placeholder='Pincode' name='Pincode' maxlength='6'/></div><div  class=' col-md-12 vendor-form-margin-top' ><input  class='col-md-12' type='text'   placeholder='Fax' name='Fax' /></div><div  class=' col-md-12 vendor-form-margin-top' ><input  class='col-md-12' type='text'   placeholder='Working Days' name='Working Days' /></div><div  class=' col-md-12 vendor-form-margin-top' ><input  class='col-md-12' type='text'   placeholder='Working Hours' name='Working Hours' /></div><div  class='col-md-12 vendor-form-margin-top'>Default Address:&nbsp;&nbsp;<input type='radio' name='defaultAddress' value=''>&nbsp;Yes&nbsp;<input type='radio' name='defaultAddress' value=''>&nbsp;No</div><div  class=' col-md-12 vendor-form-margin-top'>Comments:<br><textarea rows='3'  class=' col-md-12' type='text' ></textarea></div><a onClick='getAddress("+vendorAddressCount+");' id='vendor-address-save"+vendorAddressCount+"' class='col-md-3 vendor-address-button btn btn-primary vendor-form-margin-top'>Save</a><a onClick='cancelAddress("+vendorAddressCount+");' id='vendor-address-cancel"+vendorAddressCount+"' class='col-md-3 vendor-address-button btn btn-primary vendor-form-margin-top'>Cancel</a></form>");
*/
});
   
   $('#vendor-poc-add').click(
	function()
	{
		$('.vendorPoc').hide();
	$('.vendor-poc-delete-button').hide();
		$('#vendor-poc-add').hide();
		$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{vendorId:vendorId,type:11},
			success: function(jsonData)
			{
				$("#vendor-poc").append("<form id='Vendor-Poc"+vendorPocCount+"'  method='post' class='std'><div class='required col-md-12 vendor-form-margin-top'><input  id='vendor-poc-name"+vendorPocCount+"' class='col-md-12 form-control' type='text'  placeholder='Name' name='pocName'/></div><div class='required col-md-12 vendor-form-margin-top'><input  id='vendor-poc-designation"+vendorPocCount+"' class='col-md-12 form-control' type='text'  placeholder='Designation' name='designation'/></div><div  class=' col-md-12 vendor-form-margin-top' ><div  class=' col-md-12 padding-align-left  padding-align-right' ><select id='vendor-poc-address"+vendorPocCount+"' class='vendor-poc-address col-md-12 padding-align-left  padding-align-right vendor-poc-address form-control' placeholder='address' name='address'><option value=''>Select POC Address</option></select></div></div><div class='col-md-12 vendor-form-margin-top'><input  id='vendor-poc-phone"+vendorPocCount+"' class='col-md-12 form-control' type='text' onkeydown='numbersOnly(event)' placeholder='Phone' name='vendorPhone' /></div><div  class='col-md-12 vendor-form-margin-top'><input  id='vendor-poc-mobile"+vendorPocCount+"' class='col-md-12 form-control' type='text'  onkeydown='numbersOnly(event)' placeholder='Mobile' name='vendorMobile' /></div><div  class=' col-md-12 vendor-form-margin-top' ><div  class=' col-md-8 padding-align-left  padding-align-right' ><select name='poclang' id='vendor-poc-lang"+vendorPocCount+"' class=' col-md-12 padding-align-left  padding-align-right form-control color' type='text'  ><option value=''>Languages</option></select></div><a id='vendor-lang-add"+vendorPocCount+"'onClick='addLang("+vendorPocCount+");' class='col-md-3 btn btn-primary padding-align-left vendor-lang-add padding-align-right lang' ><i class='fa fa fa-plus'>ADD</i></a></div><div  class=' col-md-12 vendor-form-margin-top' ><input  id='vendor-poc-email"+vendorPocCount+"' class='col-md-12 form-control' type='text'   placeholder='Email' name='Email' /></div><div  class='col-md-12 vendor-form-margin-top'>Smart Phone User:&nbsp;&nbsp;<input type='radio' name='Smart' value='1'>&nbsp;Yes&nbsp;<input type='radio' name='Smart' value='0'>&nbsp;No</div><div  class='col-md-12 vendor-form-margin-top'>Default POC:&nbsp;&nbsp;<input type='radio' name='defaultPoc' value='1'>&nbsp;Yes&nbsp;<input type='radio' name='defaultPoc' value='0'>&nbsp;No</div><div  class=' col-md-12 vendor-form-margin-top'>Comments:<br><textarea id='vendor-poc-comments"+vendorPocCount+"' rows='3'  class=' col-md-12 form-control' type='text' ></textarea></div><a onClick='getPoc("+vendorPocCount+",6,"+vendorId+");' id='vendor-poc-save"+vendorPocCount+"' class='col-md-5 btn btn-primary vendor-address-button vendor-form-margin-top'>Save</a><a id='vendor-address-edit' class='col-md-5 btn btn-primary vendor-address-button  vendor-form-margin-top'>Edit</a><a onClick='cancelPoc("+vendorPocCount+");' id='vendor-poc-cancel"+vendorPocCount+"' class='col-md-5 vendor-address-button btn btn-primary vendor-form-margin-top'>Cancel</a></form> ");
				$('.vendor-poc-address').each(function(index, element) {
					$('#'+this.id).html('');
                });
				$('.vendor-poc-address').each(function(index, element) {
                  for(var j=0;j<jsonData.length;j++)
				{	
					
					$('#'+this.id).append("<option  class='col-md-12' value='"+jsonData[j].id_address+"'>"+jsonData[j].alise+"</option>");
				}  
                });

                $.ajax({
				type: 'POST',
				url: 'dash-address.php',
				async: true,
				cache: false,
				dataType : "json",
			
				data:{type:5},
				success: function(jsonData)
				{
					if(jsonData=="null" || jsonData=="")
					{
						return false;
					}
					else
					{
					for(var j=0;j<jsonData.length;j++)
					{	
						$('#vendor-poc-lang'+vendorPocCount).append("<option  class='col-md-12' value='"+jsonData[j].id_lang+"'>"+jsonData[j].name+"</option>");
					}
					}
					vendorPocCount++;

				}
			});
				

			}
			});

			
	

});
    
});
function getAddress(i,type,idVendor,addressId)
{
		var Script = function () {
	$().ready(function() {

			// validate signup form on keyup and submit
			$("#Vendor-Address"+i).validate({
				 
				rules: {
					 addressName: {
						required: true,
					},
					 Pincode: {
						required: true,
						number: true,
						maxlength:6
					},
					Fax: {
						number: true
					},
					/*Phone:{
						number: true,
						maxlength:12
					},*/
				
					
				},
				messages: {
					 addressName: {
						required: "Please provide a address Name",
					//	minlength: "Your password must be at least 5 characters long"
					},
					Pincode: {
						required: "Please enter a pincode",
						number: "Please enter only number",
						maxlength:"Maximum value is 6",
					},
					 Fax: {
						number: "Please enter only number",
					},
					/*Phone:{
						number: "Please enter only number",
						maxlength:"Maximum allowed number is 12",
					},*/
					 
				}
			});
	
		});
 }();
	if($("#Vendor-Address"+i).validate().form())
		{
		var vendorName=$('#vendor-address-name'+i).val();
	$('#vendor-address-add').show();
	$('#Vendor-Address'+i).hide();
	$('#vendor-address-save'+i).hide();
	$('#vendor-address-cancel'+i).hide();
	$('.vendorName').show();
	$('.vendor-address-delete-button').show();
		addVendorAddressToDatabase(i,type,idVendor,addressId);
		}

}
function getPoc(j,type,idVendor,pocId)
{
	var Script = function () {
	$().ready(function() {

			// validate signup form on keyup and submit
			$("#Vendor-Poc"+j).validate({
				 
				rules: {
					 pocName: {
						required: true,
					},
					 /*vendorMobile: {
						number: true,
						maxlength:10
					},
					vendorPhone: {
						number: true
					},*/
					Email:{
						email:true,
					},
					poclang: {
						required: true,
					}
					
				},
				messages: {
					 pocName: {
						required: "Please provide a POC name",
					//	minlength: "Your password must be at least 5 characters long"
					},
					 poclang: {
						required: "Please add a Language",
					//	minlength: "Your password must be at least 5 characters long"
					},
					 /*vendorMobile: {

						number: "Please enter only number",
					//	minlength: "Your password must be at least 5 characters long"
					},
					 vendorPhone: {
						number: "Please enter only number",
					//	minlength: "Your password must be at least 5 characters long"
					},*/
					 Email: {
						email: "Please enter valid email",
					//	minlength: "Your password must be at least 5 characters long"
					},
				}
			});	
		
		});
 }();
	if($("#Vendor-Poc"+j).validate().form())
		{
		var vendorPoc=$('#vendor-poc-name'+j).val();
	$('#vendor-poc-add').show();
	$('#Vendor-Poc'+j).hide();
	$('#vendor-poc-save'+j).hide();
	$('#vendor-poc-cancel'+j).hide();
	$(".vendorPoc").show();
	$('.vendor-poc-delete-button').show();
	addVendorPocToDatabase(j,type,idVendor,pocId);
		}
	
}
function openAddress(i,addressId,idVendor)
{
	window.addressValue=addressId;
	$('#Vendor-Address'+i).show();
	$('#vendor-address-save'+i).show();
	$('#vendor-address-cancel'+i).show();
	$('#vendor-address-add').hide();
	$('.vendorName').hide();
	$('.vendor-address-delete-button').hide();
	$('#vendorName'+i).remove();
	$("#deletevendorAddress"+i).remove();
	$('#vendorname-delete'+i).remove();

}
function openPoc(i,pocId,idVendor)
{
		window.pocValue=pocId;

	$('#Vendor-Poc'+i).show();
	// $('#vendor-poc-save'+i).show();
	// $('#vendor-poc-cancel'+i).show();
	$('#vendor-poc-add').hide();
	$('.vendorPoc').hide();
	$('.vendor-poc-delete-button').hide();
	$('#vendorPocName'+i).remove();
	$("#deletevendorpoc"+i).remove();
	$('#vendorpoccname-delete'+i).remove();
	$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{vendorId:vendorId,type:11},
			success: function(jsonData)
			{
				$('.vendor-poc-address').each(function(index, element) {
					$('#'+this.id).html('');
                });
				$('.vendor-poc-address').each(function(index, element) {
					if(jsonData=="null" || jsonData=="")
				{
					return false;
				}
				else
				{
                  for(var j=0;j<jsonData.length;j++)
				{	
					
					$('#'+this.id).append("<option  class='col-md-12' value='"+jsonData[j].id_address+"'>"+jsonData[j].alise+"</option>");
				} 
				}
                });
				

			}
			});
}
function cancelAddress(i)
{
	
	var vendorName=$('#vendor-address-name'+i).val();
	if($('#vendor-address-name'+i).val()=="")
	{
		$('#Vendor-Address'+i).remove();
		$('#vendorname-delete'+i).remove();
	}
	else
	{
		$('#Vendor-Address'+i).hide();
		// $("#vendor-address").append("<div id='vendorname-delete"+i+"' class='vendorname-button-delete'><a id='vendorName"+i+"'onClick='openAddress("+i+");'  class='col-md-6 vendor-address-button btn btn-primary vendorName vendor-form-margin-top'>"+vendorName+"</a><a id='deletevendorAddress"+i+"' class='vendor-address-delete col-md-4 vendor-address-delete-button cur-poi' onClick='deletevendorAddress("+i+","+addressValue+");'><i class='fa fa-trash-o'></i>Delete</a></div>");
		
	}
	$('#vendor-address-add').show();
	$('#vendor-address-save'+i).hide();
	$('#vendor-address-cancel'+i).hide();
	$('.vendorName').show();
	$('.vendor-address-delete-button').show();

}
function cancelPoc(i)
{
	
	var pocName=$('#vendor-poc-name'+i).val();
	if($('#vendor-poc-name'+i).val()=="")
	{
		$('#Vendor-Poc'+i).remove();
		$('#vendorpocname-delete'+i).remove();
	}
	else
	{
		$('#Vendor-Poc'+i).hide();
	// $("#vendor-poc").append("<div id='vendorpoccname-delete"+i+"' class='vendorpoccname-button-delete'><a id='vendorPocName"+i+"'onClick='openPoc("+i+",);'  class='col-md-6 vendor-address-button btn btn-primary vendorPoc vendor-form-margin-top'>"+pocName+"</a><a id='deletevendorpoc"+i+"' class='vendor-address-delete col-md-4 vendor-poc-delete-button' onClick='deletevendorPoc("+i+","+pocValue+");'<i class='fa fa-trash-o'></i>Delete</a></div>");
		
	}
	$('#vendor-poc-add').show();
	$('#vendor-poc-save'+i).hide();
	$('#vendor-poc-cancel'+i).hide();
	$('.vendorPoc').show();
	$('.vendor-poc-delete-button').show();
}
function deletevendorAddress(i,addressId)
{
	$('#Vendor-Address'+i).remove();
	//	$('#vendorName'+i).remove();
		
		$("#vendorname-delete"+i).remove();
		$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{addressId:addressId,type:5},
			success: function(jsonData)
			{
				
			}
			});
	
}
function deletevendorPoc(i,pocId)
{
	$('#Vendor-Poc'+i).remove();
		
		$("#vendorpoccname-delete"+i).remove();
		$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{pocId:pocId,type:8},
			success: function(jsonData)
			{
				
			}
			});
}	

function vendorSave()
{
	if($('#websiteLink').val())
	{
		if(!(validateUrl('#websiteLink')))
		{
			return false;
		}
	}

	var Script = function () {
		$().ready(function() {
			// validate signup form on keyup and submit
			$("#vendor-details-validate").validate({
				 
				rules: {
					 vendorName: {
						required: true,
					},
					 vendorGstNo: {
						required: true,
						minlength: 15,
						maxlength: 15
					},
					creditDays: {
						number: true
					},
					payment:{
						required:true,
					}
				},
				messages: {
					 vendorName: {
						required: "Please provide the name",
					//	minlength: "Your password must be at least 5 characters long"
					},
					 vendorGstNo:{
						 required: "Please provide the GST No",
						 minlength: "Please provide 15 characters GST No",
						 maxlength: "GST No should not be greater than 15 characters"
					 },
					creditDays: {
						number: "Please enter a number"
					},
					payment:{
						required: "Please choose a payment option",
					}
				}
			});
		});
 	}();

	if($("#vendor-details-validate").validate().form())
	{
		$('#vendor-address-main-div').show();
		$('#vendor-poc-main-div').show();
		$('#vendor-details-complete').show();
		$('#vendor-details-Cancel').hide();
		
		$('#vendor-details-validate div').removeClass("vendor-form-margin-top");
		$('#vendor-details-validate div').children().attr("readonly", true); 
		addVendorToDatabase(1);
	}
}

function vendorEdit(vendorId)
{
	$('#vendor-detail-save').hide();
	$('#vendor-detail-edit-save').show();
	$('#vendor-details-Cancel').show();
	$('#vendor-detail-edit').hide();
	$('#vendor-details-validate div').children().attr("readonly", false); 

	//  $('#vendor-detail-edit').after("<a  id='vendor-detail-edit-save'  class='col-md-3 btn btn-primary vendor-form-margin-top' onclick='vendorEditSave("+vendorId+");'>Save</a>");
	// $('#vendor-details-validate div').addClass("vendor-form-margin-top");
}

function vendorEditSave()
{
	if($("#vendor-details-validate").validate().form())
	{
		$('#vendor-details-validate div').children().attr("readonly", true); 
		$('#vendor-details-validate div').removeClass("vendor-form-margin-top");
		$('#vendor-details-Cancel').hide();
		$('#vendor-detail-edit-save').hide();
		addVendorToDatabase(2, vendorId);
	}
	
}

function addLang(pocId)
{
	var validate;
	var langId=$('#vendor-poc-lang'+pocId).val();
	if(langId=="")
	{
		return false;
	}
	else
	{
		$(".langDetails"+pocId).each(function() {
	       if(this.id==langId)
		   {
			   alert("This Language is already added.");
			    validate=1;
		   }
	    });
		if(validate==1)
		{
			return false;
		}
		else
		{
			var langName=$('#vendor-poc-lang'+pocId+' option:selected').text();
			$('#vendor-lang-add'+pocId).after("<div  id='langId-"+langId+"pocId-"+pocId+"' class='col-md-12'><div id='"+langId+"' class='col-md-6 langDetails"+pocId+"'>"+langName+"</div><div onClick='deleteLang("+langId+","+pocId+");' class='col-md-6 cur-poi'><i class='fa fa-trash-o'></i>Delete</div></div>");
		}
	}
}

function addlangtoDiv()
{
	
}

function addVendorToDatabase(type, vendorId)
{
	var vendorName = $('#vendorName').val();
	var vendorName = $('#vendorName').val();
	var gstNo = $('#vendorGstNo').val();
	var url = $('#websiteLink').val();
	var website = "http://"+url;
	var creditDays = $('#creditDays').val();
	var fc = $('#vendorfc :selected').val();
	var paymentMode = $('#PaymentMode').val();
	var replacement = $('input[name=Replacement]:checked', '#vendor-details-validate').val();
	var delivery = $('input[name=Delivery]:checked', '#vendor-details-validate').val();
	var vendorComment = $('#Comments').val();
	var panNo = $('#vendorPanNo').val();
	var phoneNo = $('#vendorPhoneNo').val();

	$.ajax({
		type: 'POST',
		url: 'scn-vendor.php',
		async: true,
		cache: false,
		dataType : "json",		
		data:{
			vendorName,
			type,
			gstNo,
			website,
			creditDays,
			fc,
			paymentMode,
			replacement,
			delivery,
			vendorComment,
			vendorId,
			panNo,
			phoneNo
		},
		success: function(jsonData)
		{
			if(type == 1){
				window.vendorId = jsonData;
			    $('#vendor-detail-save').after("<a  id='vendor-detail-edit'  class='col-md-6 btn btn-primary vendor-form-margin-top' onClick='vendorEdit("+jsonData+");'>Edit</a>");
			}

			$('#vendor-detail-save').hide();
			$('#vendor-detail-cancel').hide();
			$('#vendor-detail-edit').show();
		}
	});
}

function addVendorAddressToDatabase(vendorAddressCount,type,vendorId,addressId)
{
	var addressAlise=$('#vendor-address-name'+vendorAddressCount).val();
	var address=$('#vendor-address'+vendorAddressCount).val();
	var city=$('#vendor-address-city'+vendorAddressCount).val();
	var state=$('#vendor-address-state'+vendorAddressCount).val();
	var country=$('#vendor-address-country'+vendorAddressCount).val();
	var pincode=$('#vendor-address-pincode'+vendorAddressCount).val();
	var landmark=$('#vendor-address-landmark'+vendorAddressCount).val();
	var phone=$('#vendor-address-phone'+vendorAddressCount).val();
	var fax=$('#vendor-address-fax'+vendorAddressCount).val();
	var workingHours=$('#vendor-address-working-hours'+vendorAddressCount).val();
	var workingDays=$('#vendor-address-working-days'+vendorAddressCount).val();
	var addressComment=$('#vendor-address-comments'+vendorAddressCount).val();
	var addressDelivery=$('input[name=AddressDelivery]:checked', '#Vendor-Address'+vendorAddressCount).val();
	var defaultAddress=$('input[name=defaultAddress]:checked', '#Vendor-Address'+vendorAddressCount).val();
	if(vendorAddressCount==0)
	{
		defaultAddress=1;
	}
		$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{addressAlise:addressAlise,type:type,address:address,city:city,state:state,country:country,pincode:pincode,landmark:landmark,phone:phone,fax:fax,workingHours:workingHours,workingDays:workingDays,addressComment:addressComment,vendorId:vendorId,addressDelivery:addressDelivery,defaultAddress:defaultAddress,addressId:addressId},
			success: function(jsonData)
			{
					var addressId=jsonData;
				$("#vendor-address").append("<div id='vendorname-delete"+vendorAddressCount+"' class='vendorname-button-delete'><a id='vendorName"+vendorAddressCount+"'onClick='openAddress("+vendorAddressCount+","+addressId+","+vendorId+");'  class='col-md-6 vendor-address-button btn btn-primary vendorName vendor-form-margin-top'>"+addressAlise+"</a><a id='deletevendorAddress"+vendorAddressCount+"' class='vendor-address-delete col-md-4 vendor-address-delete-button cur-poi' onClick='deletevendorAddress("+vendorAddressCount+","+addressId+");'><i class='fa fa-trash-o'></i>Delete</a></div>");
				$('#vendor-address-save'+vendorAddressCount).remove();
				$('#vendor-address-comments'+vendorAddressCount).after("<a onClick='getAddress("+vendorAddressCount+",4,"+vendorId+","+addressId+");' id='vendor-address-save"+vendorAddressCount+"' class='col-md-5 vendor-address-button btn btn-primary vendor-form-margin-top'>Save</a><a onClick='cancelAddress("+vendorAddressCount+");' id='vendor-address-cancel"+vendorAddressCount+"' class='col-md-5 vendor-address-button btn btn-primary vendor-form-margin-top'>Cancel</a>");		
			}
			});
		}
function addVendorPocToDatabase(vendorPocCount,type,vendorId,pocId)
{
	var pocName=$('#vendor-poc-name'+vendorPocCount).val();
	var designation=$('#vendor-poc-designation'+vendorPocCount).val();
	var pocMobile1=$('#vendor-poc-phone'+vendorPocCount).val();
	var pocMobile2=$('#vendor-poc-mobile'+vendorPocCount).val();
	//var pocLang=$('#vendor-poc-state'+vendorPocCount).val();
	var pocEmail=$('#vendor-poc-email'+vendorPocCount).val();
	var pocComment=$('#vendor-poc-comments'+vendorPocCount).val();
	var pocSmartPhone=$('input[name=Smart]:checked', '#Vendor-Poc'+vendorPocCount).val();
	var defaultPoc=$('input[name=defaultPoc]:checked', '#Vendor-Poc'+vendorPocCount).val();
	var pocAddress=$('#vendor-poc-address'+vendorPocCount).val();

	var languages=[];	
	$('.langDetails'+vendorPocCount).each(function() {
		languages.push(this.id);
    });
	if(vendorPocCount==0)
	{
		defaultPoc=1;
	}
	//alert(designation);
		$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{pocName:pocName,designation:designation,type:type,pocMobile1:pocMobile1,pocMobile2:pocMobile2,pocEmail:pocEmail,pocComment:pocComment,pocSmartPhone:pocSmartPhone,defaultPoc:defaultPoc,pocId:pocId,vendorId:vendorId,languages:languages,pocAddress:pocAddress},
			success: function(jsonData)
			{
				var pocId=jsonData;
				$("#vendor-poc").append("<div id='vendorpoccname-delete"+vendorPocCount+"' class='vendorpoccname-button-delete'><a id='vendorPocName"+vendorPocCount+"' onClick='openPoc("+vendorPocCount+","+pocId+","+vendorId+");'  class='col-md-6 vendor-address-button btn btn-primary vendorPoc vendor-form-margin-top'>"+pocName+"</a><a id='deletevendorpoc"+vendorPocCount+"' class='vendor-address-delete col-md-4 vendor-poc-delete-button cur-poi' onClick='deletevendorPoc("+vendorPocCount+","+pocId+");'><i class='fa fa-trash-o'></i>Delete</a></div>");
				$('#vendor-poc-save'+vendorPocCount).remove();
				$('#vendor-poc-comments'+vendorPocCount).after("<a onClick='getPoc("+vendorPocCount+",7,"+vendorId+","+pocId+");' id='vendor-poc-save"+vendorPocCount+"' class='col-md-5 btn btn-primary vendor-address-button vendor-form-margin-top'>Save</a><a onClick='cancelPoc("+vendorPocCount+");' id='vendor-poc-cancel"+vendorPocCount+"' class='col-md-5 btn btn-primary vendor-address-button vendor-form-margin-top'>Cancel</a>");		
			}
			});
		}
function selectCountry(addressId)
{
	var countryId=$('#vendor-address-country'+addressId).val();	
	$.ajax({
			type: 'POST',
			url: 'dash-address.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{type:4,id_country:countryId},
			success: function(jsonData)
			{
				$('#vendor-address-state'+addressId).html("");
				if(jsonData=="null" || jsonData=="")
				{
					return false;
				}
				else
				{
				for(var j=0;j<jsonData.length;j++)
				{	
				if(jsonData[j].id_state==336)
				{
					$('#vendor-address-state'+addressId).append("<option selected='selected' class='col-md-12' value='"+jsonData[j].id_state+"'>"+jsonData[j].name+"</option>");
				}
				else
				{
					$('#vendor-address-state'+addressId).append("<option  class='col-md-12' value='"+jsonData[j].id_state+"'>"+jsonData[j].name+"</option>");
				}
				}
				}
			}
	});
}

function deleteLang(langId,pocId)
{
	$("#langId-"+langId+"pocId-"+pocId).remove();
}

function clearForm()
{
	openVendorForm();
	vendorAddressCount=0;vendorPocCount=0;	
}

function alphabetsOnly(e)
{
	var key = e.keyCode;
	if (!((key==51)||(key==50)||(key==55)||(key==56)||(key==57)||(key==58)||(key==48)||(key==173)||(key == 8) || (key == 32) || (key == 46) || (key == 9) || (key == 190) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		e.preventDefault();
	}
}

function numbersOnly(e)
{
	var key = e.keyCode;
	if (!((key == 8) || (key == 46) || (key == 188) || (key == 9) || (key ==109) || (key == 173)  || (key == 107) ||(key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
		e.preventDefault();
	}
}
function validateUrl(id)
{
	var txt = $(id).val();
	var re_exp = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
	if (re_exp.test(txt)) {
		return true;
	}
	else
	{
		$(id).val("");
		$(id).attr("placeholder","enter valid URL");
		return false;
	}
}