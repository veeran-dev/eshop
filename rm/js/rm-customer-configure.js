$(document).ready(function(){
	getCustomers("customerSearch",0);
	
	easySearch('group_customers');
	easySearch('roles-table');
	easySearch('parents-table');

	var type = 7;
 	var dataparam ='&type='+type;
	$.ajax({
			type: 'POST',
				async: true,
			dataType:'json',
			url: 'dash-address.php',
			data: dataparam,
			cache: true,
			success: function(data)
			{
					for(var i=0; i<data.length; i++)
					{
						$('.state').append('<option value='+data[i].id_state+'>'+data[i].name+'</option>');
					}
			}
	});
});
$( "#group_selection2" ).change(function() {
	var selectedCompany = $('#group_selection2').val();
	$('.id_group').val(selectedCompany);
});

$('#group-edit-form #company_name').bind("keypress", function(e) {

        if (e.keyCode == 13) {
        	e.preventDefault();
            editGroup();
            return false;
        }
});
function createCusAccount(add_type)
{
	//var dataparam = $('#customer-create-form').serialize();
	var exp = new RegExp('[a-zA-Z]*');
	var firstName = $('#customer-create-form #firstName').val();
	var lastName = $('#customer-create-form #lastName').val();
	var companyName = $('#customer-create-form #companyName').val();
	var group_selection2 = $('#customer-create-form #group_selection2').val();
	var emailId = $('#customer-create-form #emailId').val();
	var mobileNum = $('#customer-create-form #mobileNum').val();
	var password = $('#customer-create-form #default_password').val();
	var id_employee = $('#customer-create-form #employee_id').val();
	var id_group = $('#customer-create-form #id_group').val();
	var dataparam = '&firstName='+firstName+'&lastName='+lastName+'&companyName='+companyName+'&group_selection2='+group_selection2+'&emailId='+emailId+'&mobileNum='+mobileNum+'&password='+password+'&id_employee='+id_employee+'&id_group='+id_group;
	var email_pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	
	if(!firstName.match(/^[a-zA-Z\s]+$/)) {
        toast("Invalid first name","warning");
        return false;
    }
    
    if(!lastName.match(/^[a-zA-Z\s]+$/)) {
        toast("Invalid last name","warning");
        return false;
    }
	
	if(mobileNum.length < 10) {
		toast('Mobile number should have minimum of 10 numbers','error');
		return false;
	}

	if(!email_pattern.test(emailId)) {
		toast("Enter valid email id", "error");
		return false;
	}
	
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-create.php',
		data: dataparam,
		cache: true,
		success: function(data){
			if(data == 13){
				toast('User Company  is not yet verified. Verify it soon.','warning');
				toast('User Created Successfully','success');
				$('#customerCreate').modal('hide');
				getGroupDetails(7);
			}
			else if(data[0].status == 3 || data[0].status == 1){
				toast('User Created Successfully','success');
				$('#firstName,#lastName,#emailId,#mobileNum').val('');
				if(add_type == 0)
				{
					$("#customer-create-form #company_select").show();
					$("#customer-create-form #company_text").addClass('hidden');
					$('#customerCreate').modal('hide');
				}
				else if(add_type == 1)
				{
					$('#firstName,#lastName,#emailId,#mobileNum').val('');
				}
				else 
				{
					$('.flowCustomer').val('');
					$('#customerCreate').modal('hide');
					$('#myaddress').modal('show');
					$('#customerid').val(data[0].id_customer);
					$('#company').val(data[0].company);
				}
			}
			else if(data[0].status == 2){
				toast('User Already Exists','warning');
			}
			else if(data[0].status == 5){
				toast('Comapany name invalid','error');
			}
			else{
				toast('User Creation Failed.',"error");
			}
		}
	});
}
function putCompanyName(){
	$('#company_name').val($('#group_selection_3 option:selected').text());
	$.ajax(
	{
		type: 'GET',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: '&id_group='+$('#group_selection_3 option:selected').val()+'&type=14',
		cache: true,
		success: function(data)
		{	
			if(data.po_mandatory == 1){
				$('#po_mandatory_edit').attr("checked", true);
			}
			else{
				$('#po_mandatory_edit').attr("checked", false);
			}
			$('#group-edit-form input[name="group_credit"]').val(data.credit_days);
		}
	});
}
function customerSearch(id_customer)
{
	$('#index_viewport').html('');
	//$(".ajaxLoaderModal").show();
	/*$("#index_viewport").load("rm-customer-configure.php?ajax=true&type=4&id_customer="+id_customer+"", function( response, status, xhr ) 
	{
	  $(".ajaxLoaderModal").hide();
	});*/
	$("#index_viewport").load("rm/rm-add-address.tpl");
}

function saveAddress(type,page,event){
	event.preventDefault();
  	if(type !=2)
	{
		$("#id_customer").val(id_customer);
		$("#customer_id").val(id_customer);
	}
 	var dataparam;
	if(type == 0)
	{
		dataparam = $('#addressSubmit').serialize();
		var state = $("#addressSubmit .state option:selected").val();
		var company = $("#addressSubmit #company").val();
		var alias = $("#addressSubmit #alias").val();
		var address = $("#addressSubmit #address1").val();
		var city = $("#addressSubmit [name=city]").val();
		var pincode = ($("#addressSubmit [name=postcode]").val()).replace(/ +/g, "");
		var contact = $("#addressSubmit [name=firstname]").val();
		var mobile = $("#addressSubmit [name=mobile]").val();
		var gst = $("#addressSubmit [name=gst]").val();

		if(!state || state == 0)
		{
			toast('Select valid State','warning');
			return false;
		}
		if(!pincode || pincode.length != 6)
		{
			toast('Enter valid pincode','warning');
			return false;
		}
		if(!mobile || mobile.length < 10 || mobile.length == 11)
		{
			toast('Enter valid mobile number','warning');
			return false;
		}
		if (/[^a-zA-Z]/.test(contact)){
			toast('Enter valid contact name','warning');
			return false;	
		}
		if (/[a-zA-Z\s]/.test(name)){
			toast('Enter valid city name','warning');
			return false;	
		}
		if(gst.length != 15 && gst.length>0){
			toast('Enter valid GST number','warning');
			return false;	
		}


	}
	else if (type == 1)
	{
		dataparam = $('#addressSubmit1').serialize();
		id_address = $('#addressSubmit1 #id_address').val();
		var company = $("#addressSubmit1 #company").val();
		var alias = $("#addressSubmit1 #alias").val();
		var address = $("#addressSubmit1 #address1").val();
		var city = $("#addressSubmit1 #city").val();
		var state = $("#addressSubmit1 .state option:selected").val();
		var state_name = $("#addressSubmit1 .state option:selected").text();
		var pincode = ($("#addressSubmit1 #postcode").val()).replace(/ +/g, "");
		var contact = $("#addressSubmit1 #firstname").val();
		var mobile = $("#addressSubmit1 #mobile").val();
		var gst = $("#addressSubmit1 #gst").val();
		
		if (/[^a-zA-Z]/.test(contact)){
			toast('Enter valid contact name','warning');
			return false;	
		}

		if(!state || state == 0)
		{
			toast('Select valid State','warning');
			return false;
		}
		if(!pincode || pincode.length != 6)
		{
			toast('Enter valid pincode','warning');
			return false;
		}
		if(!mobile || mobile.length < 10 || mobile.length == 11)
		{
			toast('Enter valid mobile number','warning');
			return false;
		}
	}
	else if (type == 2){
		dataparam = $('#flowaddressSubmit').serialize();
		var state = $("#flowaddressSubmit .state option:selected").val();
		var pincode = $("#flowaddressSubmit #postcode") .val();
		var mobile = $("#flowaddressSubmit #mobile") .val();
		if(!state || state == 0)
		{
			toast('Select valid State','warning');
			return false;
		}
		if(!pincode || pincode.length != 6)
		{
			toast('Enter valid pincode','warning');
			return false;
		}
		if(!mobile || mobile.length < 10 || mobile.length == 11)
		{
			toast('Enter valid mobile number','warning');
			return false;
		}
	}
	$(".ajaxLoaderModal").show();
   	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{	
  			if(data == 0)
			{
				if(type == 0)
					toast('Error Occured when adding Address',"error");
				else
					toast("Error occured when editing address","error");
			}
			else if(data == 1)
			{
				if(type == 0)
				{
					toast('Address Added Successfully',"success");
					
				 
					var id_customer_details = $('#customer_selection').val();
					var id_group = $('#group_selection').val();
					var id_customer = id_customer_details.split('~');
					var customer_id = id_customer[0];
					
					selectCustomer(customer_id,11,0,id_group,0);
					setTimeout(function(){
						selectCustomer(customer_id,12,0,id_group,0);
					},1000);

					$('#myaddress').modal('hide');
					$('.myAddress').val('');
					$('input[type="checkbox"]').prop('checked' , false);	 
				}
				else if(type == 2)
				{
					if( page ==3)
					{
						toast('Address Added Successfully',"success");
						$('#myaddress').modal('hide');
						$('.myAddress').val('');
						
					}
					else if(page == 4)
					{
 						toast('Address Added Successfully',"success");
						//$('#myaddress').modal('hide');
 						$('.myAddress').val('');
						$('input[type="checkbox"]').prop('checked' , false);
					}
					
				}
				else
				{
					toast('Address Updated Successfully',"success");
					$('#editAddress').modal('hide');

					var id_customer_details = $('#customer_selection').val();
					var id_group = $('#group_selection').val();
					var id_customer = id_customer_details.split('~');
					var customer_id = id_customer[0];
					selectCustomer(customer_id,11,0,id_group,0);
					setTimeout(function(){
						selectCustomer(customer_id,12,0,id_group,0);
					},1000);
					
					if(type == 1)
					{
						$('#group_address tr #address_'+id_address).html('');
						$('#group_address tr #address_'+id_address).html(company+"<br>"+alias+"<br>"+address+"<br>"+city+"<br>"+state_name+"<br>"+pincode);
						$('#group_address tr #contact_'+id_address).html(contact);
						$('#group_address tr #mobile_'+id_address).html(mobile);
					}
				}
				 
			}
			else if(data == 3) {
				toast('Invalid address. Please check the address for any special characters included.', "error");
			}				
		}
	});
	$(".ajaxLoaderModal").hide();
}

function editAddress(id_address){
	$.ajax(
	{
		type: 'GET',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: '&id_address='+id_address+'&type=6',
		cache: true,
		success: function(data)
		{	
			$('#alias').val(data[0].alias);
			$('#company').val(data[0].company);
			$('#firstname').val(data[0].firstname);
			$('#lastname').val(data[0].lastname);
			$('#mobile').val(data[0].phone_mobile);
			$('#gst').val(data[0].vat_number);
			$('#address1').val(data[0].address1);
			$('#landline').val(data[0].phone);
			$('#postcode').val(data[0].postcode);
			$('#city').val(data[0].city);
			$('.state').val(data[0].id_state);
			$('#id_address').val(data[0].id_address);
			$('#id_address_hidden').val(id_address);
			$('#editAddress').modal('show');
			
			if(data[0].isez == 1)
			{
				$("#editAddress input[name=sez]").prop("checked", true);
			}
			else{
				$("#editAddress input[name=sez]").prop("checked", false);	
			}
		}
	});
}

function deleteAddress(address_id,id_customer)
{
	var type=8;
	var dataparam = '&address_id='+address_id+'&type='+type+'&id_customer='+id_customer;
	$.ajax({
			type: 'POST',
			async: true,
			url: 'dash-address.php',
			cache: false,
			data:dataparam,
			success: function(jsonData)
			{
				toast('Address Deleted Successfully',"success");
				//customerSearch(id_customer);
				var last_cell = $('#group_address #tr_'+address_id+' td:last');				
				var previous1 = last_cell.prev('td');
				var previous2 = previous1.prev('td');
				last_cell.html('');
				previous1.html('<span class="deleted">Deleted</span>');
				previous2.html('');
			}
	});
}

function getGroupDetails(type)
{
	dataparam = $('#group_select').val();
	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("rm-customer-configure.php?ajax=true&type="+type+"&id_group="+dataparam+"", function( response, status, xhr ) 
	{
	  $(".ajaxLoaderModal").hide();
	});
}

function addCustomersToGroup(group_id,type)
{
	if(type == 1)
	{
		if($('#group_select_1').val() == "" || $('#hidden_id_user').val() == "") 
		{
			toast("Please select all fields", "error");
		}
		else 
		{
			if(group_id == 0){
				group_id = $('#group_select_1').val();
			}

			var req_type=2;
			var dataparam = '&id_group='+group_id+'&type='+req_type+'&id_customer='+$('#hidden_id_user').val()+'&group_default='+group_id;
			$.ajax({
				type: 'POST',
				async: true,
				url: 'rm-customer-configure.php',
				cache: false,
				data:dataparam,
				success: function(jsonData)
				{
					toast('User Added to Company Successfully',"success");
					$("#id_user").val("");
					$('#hidden_id_user').val("")
				},
				error: function()
				{
					toast('Error found when adding User to Company',"error");
				}
			});
		}
	}
}

function editGroup()
{
	var company = $('#company_name').val();
	var credit_days = $('#group-edit-form input[name="group_credit"]').val();
	var dataparam = $('#group-edit-form').serialize();
  	//save_type =0 save and 1 = Save & Create User
  	var exp = new RegExp('[a-zA-Z]*');
  	if(!company.match(/^[a-zA-Z0-9&-/,.\s]+$/))
    {
        toast("Invalid company name","warning");
        return false;
    }
	if(credit_days < 0){
        toast("Please enter credit days","warning");
        return false;
	}
	if(credit_days == ""){
        toast("Please enter credit days","warning");
        return false;
	}

	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{	
			if(data == 1)
			{
				toast('Company edited successfully.','success');
				$('#editGroup').modal('hide');
				$('.modal-backdrop').removeClass("modal-backdrop");
 			}
			else if(data == 2)
			{
				toast('Error occurred while editing Company.','error');
				$('#editGroup').modal('hide');
				$('.modal-backdrop').removeClass("modal-backdrop");
			}
			cusConfigure(0);
		}
	});
}

function addGroup(save_type)
{
	var dataparam = $('#group-create-form').serialize();
	var company = $('#group-create-form input[name="group_name"]').val();
	var credit_days = $('#group-create-form input[name="group_credit"]').val();
  	//save_type =0 save and 1 = Save & Create User
  	var exp = new RegExp('[a-zA-Z]');
  	if(!company.match(/^[a-zA-Z0-9&-/,.\s]+$/))
    {
        toast("Invalid company name","warning");
        return false;
    }

	if(credit_days < 0){
        toast("Please enter credit days","warning");
        return false;	
	}
	if(credit_days == ""){
        toast("Please enter credit days","warning");
        return false;
	}

	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			if(data[0].id_group == "0")
			{
				toast('Error occurred while creating Company.','error');
				$('#groupCreate').modal('hide');
 			}
			else if(data[0].id_group == "00")
			{
				toast('Company Already Exists.','error');
				$('#groupCreate').modal('hide');
			}
			else{
				
				$('.flowGroup').val('');
				$('#groupCreate').modal('hide');
				$('#group_select, #group_selection2, #group_select_1').append('<option value='+data[0].id_group+'>'+data[0].name+'</option>');
				$('#group-edit-form #group_selection_3').append('<option value='+data[0].id_group+'>'+data[0].name+'</option>');
				$('#customer-edit-form #group_selection_4').append('<option value='+data[0].id_group+'>'+data[0].name+'</option>');
				
				toast('Company  Created Successfully','success');
				if(save_type == 1)
				{
					$("#customer-create-form #company_select").hide();
					$("#customer-create-form #company_text").removeClass('hidden');
					$("#customer-create-form #id_group").val(data[0].id_group);
					$("#customer-create-form #companyName").val(data[0].name);
					
					$('#customerCreate').modal('show');
				}
			}	
		}
	});
}

function openCreateCustomerModel()
{
 	$("#company_select").show();
	$("#company_text").addClass('hidden');
	$('#customer-create-form .form-group input,#group_selection2, #customer-create-form .form-group select').val('');
	$('#customerCreate').modal('show');
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function removeCusGroup(id_customer,id_group,type)
{
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: '&type=5&id_customer='+id_customer+'&id_group='+id_group,
		cache: true,
		success: function(data)
		{
			if(data == 1)
			{
				toast('User removed from Company successfully','success');
				if(type == 0)
					getGroupDetails(7);
				else
					getGroupDetails(12);					
			}
		},
		error: function(){
			toast('Error occured when removing User from Company','error');
		}
	});
}

function getGroupCustomers(type)
{
	dataparam = $('.group_select').val();
	$('#index_viewport').html('');
	$(".ajaxLoaderModal").show();
	$("#index_viewport").load("rm-customer-configure.php?ajax=true&type="+type+"&id_group="+dataparam+"", function( response, status, xhr ) 
	{
	  $(".ajaxLoaderModal").hide();
	});
}

function assignRole()
{
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: $('#role-form').serialize(),
		cache: true,
		success: function(data)
		{
			toast('Roles Created Successfully',"success");
		},
		error: function(){
			toast('Error in Creating Role','error');
		}
	});
}

function assignParent()
{
	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: $('#assign-parent').serialize(),
		cache: true,
		success: function(data)
		{
			toast('Successfully Added',"success");
			getGroupCustomers(11);
		},
		error: function(){
			toast('Error in assigning parent','error');
		}
	});
}

function removeCustomer(id_customer,id_parent,type)
{
	var dataparam;

	if(type == 0)
		dataparam = '&type=8&id_customer='+id_customer+'&id_parent='+id_parent;
	else
		dataparam = '&type=8&id_parent='+id_parent;

	$.ajax(
	{
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: dataparam,
		cache: true,
		success: function(data)
		{
			toast('Successfully Removed',"success");
			getGroupCustomers(11);
		},
		error: function(){
			toast('Error in removing parent','error');
		}
	});
}


function findEscalations(){
	$('#assignEscalationContacts #esc_firstname').val("");
	$('#assignEscalationContacts #esc_lastname').val("");
	$('#assignEscalationContacts #esc_email').val("");
	$('#assignEscalationContacts #esc_mobile').val("");
	$.ajax(
	{
		type: 'GET',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: '&id_group='+$('#assignEscalationContacts #group_selection2 option:selected').val()+'&type=15',
		cache: true,
		success: function(data)
		{	
			$('#assignEscalationContacts #esc_firstname').val(data['firstname']);
			$('#assignEscalationContacts #esc_lastname').val(data['lastname']);
			$('#assignEscalationContacts #esc_email').val(data['email']);
			$('#assignEscalationContacts #esc_mobile').val(data['mobile']);
		}
	});
}

function addEscalations() {
	var id_group = $('#assignEscalationContacts #group_selection2 option:selected').val();
	var esc_mobile = $('#assignEscalationContacts #esc_mobile').val();
	var esc_email = $('#assignEscalationContacts #esc_email').val();
	var esc_firstname = $('#assignEscalationContacts #esc_firstname').val();
	var esc_lastname = $('#assignEscalationContacts #esc_lastname').val();
	if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(esc_email)){
		toast("Please enter email id", "warning");
		return false;
	}
	if(esc_mobile.length != 10){
		toast("Please enter valid mobile number", "warning");
		return false;
	}
	if(esc_firstname.length == ""){
		toast("Please enter name", "warning");
		return false;
	}
	if(esc_lastname.length == ""){
		toast("Please enter name", "warning");
		return false;
	}
	$.ajax({
		type: 'POST',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: '&id_group='+id_group+'&esc_firstname='+esc_firstname+'&esc_lastname='+esc_lastname+'&esc_mobile='+esc_mobile+'&esc_email='+esc_email+'&type=12',
		cache: true,
		success: function(data)
		{
			toast('Escalations added Successfully', "success");
		},
		error: function(){
			toast('Error in adding escalations','error');
		}
	});
}

function findRm(){
	$('#assignRMtoCompany #select2-group_select_5-container').text('Select RM');
	$.ajax(
	{
		type: 'GET',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: '&id_group='+$('#assignRMtoCompany #group_selection2 option:selected').val()+'&type=14',
		cache: true,
		success: function(data)
		{	
			if(data['id_relationship_manager'] > 0){
				$("#assignRMtoCompany #group_select_5 option[value="+data['id_relationship_manager']+"]").attr('selected', 'selected');
				var rm_name = $("#assignRMtoCompany #group_select_5 option[value="+data['id_relationship_manager']+"]").html();
				$('#assignRMtoCompany #select2-group_select_5-container').text(rm_name);
				$('#assignRMtoCompany #id_employee').val(data['id_relationship_manager']);
			}
		}
	});
}

function findKam(){
	$('#assignKAMtoCompany #select2-group_select_7-container').text('Select KAM');
	$.ajax(
	{
		type: 'GET',
		dataType: 'json',
		async: true,
		url: 'rm-customer-configure.php',
		data: '&id_group='+$('#assignKAMtoCompany #group_select_6 option:selected').val()+'&type=14',
		cache: true,
		success: function(data)
		{	
			if(data['id_kam'] > 0){
				$("#assignKAMtoCompany #group_select_7 option[value="+data['id_kam']+"]").attr('selected', 'selected');
				var kam_name = $("#assignKAMtoCompany #group_select_7 option[value="+data['id_kam']+"]").html();
				$('#assignKAMtoCompany #select2-group_select_7-container').text(kam_name);
			}
		}
	});
}
function setRm(){
	$('#assignRMtoCompany #id_employee').val($('#assignRMtoCompany #group_select_5 option:selected').val());
}

function addRmToCompany() 
{
	var id_relationship_manager = $('#assignRMtoCompany #id_employee').val();
	var id_group = $('#assignRMtoCompany #group_selection2 option:selected').val();

	if(id_relationship_manager <= 0 || id_group <= 0 ){
		toast("Please select all fields", "error");
	}
	else {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			async: true,
			url: 'rm-customer-configure.php',
			data: '&id_group='+id_group+'&id_relationship_manager='+id_relationship_manager+'&type=11',
			cache: true,
			success: function(data)
			{
				toast('RM Assigned Successfully', "success");
			},
			error: function(){
				toast('Error in assigning RM','error');
			}
		});
	}
}

function addKAMToCompany() {
	var id_group = $('#group_select_6').val();
	var id_relationship_manager = $('#group_select_7').val();

	if(id_relationship_manager == "" || id_group == "") {
		toast("Please select all fields", "error");
	}
	else {
		$.ajax({
			type: 'POST',
			dataType: 'json',
			async: true,
			url: 'rm-customer-configure.php',
			data: '&id_group='+id_group+'&id_relationship_manager='+id_relationship_manager+'&type=10',
			cache: true,
			success: function(data)
			{
				toast('KAM Assigned Successfully', "success");
			},
			error: function(){
				toast('Error in assigning KAM','error');
			}
		});
	}
}

$(document).ready(function(){
	$("#group_customer_detail, #id_user, #user_assign_rm").autocomplete("rm-customer-configure.php?type=13", {
		minChars: 1,
		max: 10,
		dataType: "json",
		formatItem: function(data, i, max, value, term) {
			return value;
		},
		parse: function(data) {
			if (data == "") {
				return data;
			}
			else {
				var mytab = new Array();
				for (var i = 0; i < data.length; i++) mytab[mytab.length] = {
					data: data[i].firstname + "~" + data[i].lastname + "~" + data[i].id_customer + "~" + data[i].email,
					value: "<div><span class='ul-font-size col-xs-6 col-md-10'>" + data[i].firstname + "</br>" + "Customer Id:" + data[i].id_customer + "</br>" + "Email: " + data[i].email + "</span></div>"
				};
				return mytab;
			}
		},
	}).result(function(event, data, formatted, value) {
		var seperate = data.split('~');
		$("#customers_to_group, #group_customer_detail").val('');
		$("#group_customer_detail, #id_user, #user_assign_rm").val(seperate[0]+"( "+seperate[3]+" )");
		$("#customers_to_group,#hidden_id_user,#hidden_user_assign_rm").val(seperate[2]);
	});
	
});	



	
 