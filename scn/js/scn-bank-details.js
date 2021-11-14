$(document).ready(function()
{
	var type=1;
	var dataparam = '&type='+type;	 
	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				//url: 'dash-customer-report.php',
				url: 'scn-vendorlistdata.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
				if(data[0]=="null" || data[0]=="")
				{
					return false;
				}
				else
				{
					$('#selectVendor').html("");
					     $('#selectVendor').append('<option value="" >Select Vendor</option>');

				for(var j=0;j<data[0].length;j++)
				{	
					$('#selectVendor').append("<option  class='col-md-12' value='"+data[0][j].id_vendor+"'>"+data[0][j].name+"</option>");
				}
				}
				}
	});

});
function selectAddress()
{
		var type=3;
	var vendorId=$('#selectVendor').val();
	var dataparam = '&type='+type+'&vendorId='+vendorId;
 	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
				if(data=="null" || data=="")
				{
					return false;
				}
				else
				{
				$('#vendorAddress').html("");
				for(var j=0;j<data.length;j++)
				{	
					$('#vendorAddress').append("<option  class='col-md-12' value='"+data[j].id_address+"'>"+data[j].alise+"</option>");
				}
				}

			}
			
	});	
}
function saveBankDetails()
{
	var Script = function () {
		$().ready(function() {

			// validate signup form on keyup and submit
			$("#bank-details-validate").validate({
				 
				rules: {
					 bankName: {
						required: true,
					},
					 bankBranch: {
						required: true,
						
					},
					bankAddress: {
						required: true,
					},
					accountName: {
						required: true,
					},
					accountType: {
						required: true
					},
					accountNumber:{
						required:true,
						number: true
					},
					ifsccode:{
						required:true,
					},
					vendorAddress:{
						required:true,
					},
					selectVendor:{
						required:true,
					}
				},
				messages: {
					 bankName: {
						required: "Please provide the bank name",
					//	minlength: "Your password must be at least 5 characters long"
					},
					 accountNumber:{
						 required: "Please provide the Account No",
						number: "Please enter a valid Account No",
					 },
					 bankBranch: {
						required: "Please provide the bank branch",
					},
					bankAddress: {
						required: "Please provide the bank address",
					},
					accountName: {
						required: "Please enter a account name"
					},
					ifsccode: {
						required: "Please enter a IFSC code",
					},
					accountType:{
						required: "Please select a account type",
					},
						vendorAddress:{
						required: "Please select a vendor address",
					},
						selectVendor:{
						required: "Please select a vendor",
					}
				}
			});
		});
 }();
if($("#bank-details-validate").validate().form())
		{
	addBankDetailsToDatabase();
		}
}
function addBankDetailsToDatabase()
{
	var selectVendor=$('#selectVendor').val();
		var vendorAddress=$('#vendorAddress').val();
	var bankName=$('#bankName').val();
	var bankBranch=$('#bankBranch').val();
	var bankAddress=$('#bankAddress').val();
	var accountName=$('#accountName').val();
	var accountType=$('#accountType').val();
	var accountNumber=$('#accountNumber').val();
	var ifsccode=$('#ifsccode').val();
			$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{selectVendor:selectVendor,type:13,vendorAddress:vendorAddress,bankName:bankName,bankBranch:bankBranch,bankAddress:bankAddress,accountName:accountName,accountType:accountType,accountNumber:accountNumber,ifsccode:ifsccode},
			success: function(jsonData)
			{
			toast("Bank details is saved for Vendor","success");
			$("#bank-details-validate input").val("");
			$("#bank-details-validate textarea").val("");
					}
			});
}
function cancelBankDetails()
{
	$("#bank-details-validate input").val("");
			$("#bank-details-validate textarea").val("");
}

