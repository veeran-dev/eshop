var firstname;
$(document).ready(function(){
	//easySearch('cus-verification-table');
   // easySearch('group-verification-table');
   $("#user-list").autocomplete("cus-verification.php?&type=3",
	{
		minChars: 1,
		max: 20,
		dataType: "json",
		formatItem: function(data, i, max, value, term)
		{
 			return value;
		},
		parse: function(data)
		{
 			 
			if (data == "")
			{
				return data;
			}
			else
			{
				var mytab = new Array();
				for (var i = 0; i < data.length; i++) mytab[mytab.length] = {
					data: data[i].firstname + "~" + data[i].lastname + "~" + data[i].id_customer + "~" + data[i].email,
					value: "<div onclick=openCustomerDetails(" + data[i].id_customer + ")><span class='ul-font-size col-xs-6 col-md-10' id='search_product_details'>" + data[i].firstname + "</br>" + "Customer Id:" + data[i].id_customer + "</br>" + "Email: " + data[i].email + "</span></div>"
				};
				return mytab;
			}
		},
	}).result(function(event, data, formatted, value)
	{
		var seperate = data.split('~');
 		customer_id = seperate[2];
		firstname = seperate[0];
 	});
	 
});

function uploadDocument(id_customer)
{
	var customer_id= id_customer;
 	var file_id = "buyer-document-"+id_customer;
	var id_customer = "id_customer_"+id_customer;
	
	 var fileInput = document.getElementById(file_id);
    var id_customer = document.getElementById(id_customer);
  	var file = fileInput.files[0];
	var formData = new FormData();
	var file_name = file.name;
	var filename = file_name.split('.').pop();
	
	formData.append('file', file);
	formData.append('id_customer', id_customer.value);
	formData.append('type_ajax',1);
	$.ajax({
        url: 'cus-verification.php',
        type: "POST",
		data: formData,
        processData: false,
        contentType: false,
        success:function(data){

        	if(data == 0)
        		toast("Please Upload Valid File","error");
        	else if(data == 1)
        		toast("File format cannot be accepted","error");
        	else if(data == 2)
        		toast("Maximum Upload Size is 5 MB","warning");
        	else if(data == 3)
        	{
				$("#doc_status").html('<span class="text-success">Verified</span>');
				$("#verification_document").html('<span>Verified</span>');
				$("#verification_alert_sent").html('<button class="btn btn-default">Verified</button>');
				$("#last_sent").html('0000-00-00 00:00:00');
				$("#verification_document").html('<a download   href="Buyer_Verification_Document/'+customer_id+'-'+firstname+'.'+filename+'"><span>'+firstname+'.'+filename+'</span>&nbsp;(<i class="fa fa-download download-group-document">)</i></a>');
				
        		toast("Document Uploaded Successfully","success");
         	}
	       	else if(data == 4)
        		toast("Problem with file upload.Try again after sometimes.","error");
			else
			{
				toast("Document Uploaded Successfully","success");
			}
        }
    });
}

function uploadGroupDocument(group_id)
{
	 
	var file_id = "buyer-document-"+group_id;
	var id_group = "id_customer_"+group_id;
    var fileInput = document.getElementById(file_id);
    var id_group = document.getElementById(id_group);
    var file = fileInput.files[0];
    var formData = new FormData();
     formData.append('file', file);
    formData.append('id_group', id_group.value);
    formData.append('type_ajax',4);
	var file_name = file.name;
	var filename = file_name.split('.').pop();
	var groupname=$("#group_selection option:selected").text();


 //console.log(filename);
      $.ajax({
        url: 'cus-verification.php',
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success:function(data){
			 
            if(data == 0)
                toast("Please Upload Valid File","error");
            else if(data == 1)
                toast("File format cannot be accepted","error");
            else if(data == 2)
                toast("Maximum Upload Size is 5 MB","warning");
            else if(data == 3)
			{
				$("#verification_status").html("Verified");
				$("#upload_document").html("Verified");
				$("#verification_document").html('<a download   href="Buyer_Verification_Document/'+group_id+'-'+groupname+'.'+filename+'"><span>'+groupname+'.'+filename+'</span>&nbsp;(<i class="fa fa-download download-group-document">)</i></a>');
				
                 toast("Document Uploaded Successfully. Please Refresh","success");
			}
            else if(data == 4)
                toast("Problem with file upload.Try again after sometimes.","error");
        }
    });
}

function sendAlert(type,id_customer)
{
	alert();
	$.ajax({
        url: 'cus-verification.php',
        type: "POST",
		data: '&mail_type='+type+'&type_ajax=2&id_customer='+id_customer,
        success:function(data){
        	if(data == 0 || data == 2)
        		toast('Mail Sent Successfully.',"success");
        	else if(data == 1 || data == 3)
        		toast("Resend Alert Sent Successfully","success");
        	cusVerification(0);
        }
    });
}

function verifyCustomer(id_customer)
{
	var dataparam = '&type_ajax=3&id_customer='+id_customer;
    $.post("cus-verification.php", dataparam)
	    .done(function() {
	        toast("Customer Verified Successfully","success"); //on success show message
	    })
	    .fail(function() {
	        toast("Problem With Customer Verification.Please Check details.","error"); //for if any failure happened
	    })
	    .always(function() {
	        // Refresh table
	        cusVerification(0);
	    });
}
function openCustomerDetails(id_customer)
{
	var type = 2
	var dataparam='&id_customer='+id_customer+'&type='+type;
 	$.ajax({
				type: 'POST',
				dataType:'json',
				async: true,
				url: 'cus-verification.php',
				data: dataparam,
				cache: true,
	 			success: function(data)
				{	
 					$("#id_customer").html("");	
					$("#customer_firstname").html("");	
					$("#mobile").html("");	
					$("#status").html("");	
					$("#download_document").html("");	
					$("#verification_document").html("");	
					$("#verification_alert_sent").html("");	
					$("#last_sent").html("");
					if(data.length >0)
					{
						var document_download="";
						var status="";
						if(data[0].verification_document == 0 || data[0].verification_document== null)
							document_download = "<span>Not Available</span>";
						else
						{					
							var doc_name=  data[0].firstname;
							var doc_name= doc_name.toLowerCase();
							var doc = data[0].verification_document;
							var doc_result = doc.split(".");
							var doc_exe = doc_result[1];
							document_download = "<a href='Buyer_Verification_Document/"+data[0].id_customer+"-"+doc_name+"."+doc_exe+"' download><span>"+doc_name+"."+doc_exe+"	</span>&nbsp;(<i class='fa fa-download download-group-document'></i>)</a>";
						}
						
 						/* if (data[0].verification_status == 0)
                            status="<span class='text-danger'>Not Verified</span>";
                        else if (data[0].verification_status == 1)
                            status="<span onclick='verifyCustomer("+data[0].id_customer+")' class='text-warning'>Verification Pending</span>";
                        else
                            status="<span class='text-success'>Verified</span>";
						*/
						 
						
						
						
 						if(data[0].verification_status == 0)
						{
							status = "<span class='text-danger'>Not Verified</span>";
							document_doc="<form enctype='multipart/form-data' id='submit-document-"+data[0].id_customer+"' method='post' onsubmit='uploadDocument("+data[0].id_customer+"); return false;' ><input type='file' class='padding5' id='buyer-document-"+data[0].id_customer+"' name='buyer-document-"+data[0].id_customer+"' /><input type='hidden' id='id_customer_"+data[0].id_customer+"' name='id_customer_"+data[0].id_customer+"' value="+data[0].id_customer+"><button title='Upload Document' type='submit' class='btn btn-success btn-round'><i class='fa fa-arrow-up'>Upload</i></button></form>";
						}
						else if(data[0].verification_status == 1)
							status = "<span onclick='verifyCustomer("+data[0].id_customer+")' class='text-success'>Verify</span>";
						else
						{
							status = "<span class='text-success'>Verified</span>";
							document_doc = "<span>Verified</span>";
						}
						var alert_sent ="";
						if (data[0].verification_alert_sent == null)
						{
                            if (data[0].verification_status == 0)
                               alert_sent=" <button class='btn btn-primary' onclick='sendAlert(0,"+data.id_customer+")'>Send Alert</button>";
                            else if (data[0].verification_status == 1)
                                alert_sent="<button class='btn btn-warning' onclick='sendAlert(2,"+data[0].id_customer+")'>Send Alert</button><span class='help-block'>(if invalid document found)</span>";
                            else
								alert_sent="<button class='btn btn-default'>Verified</button>";
						}
                         else
						{
                            if (data[0].verification_status == 0)
                                alert_sent=" <button class='btn btn-primary' onclick='sendAlert(1,"+data[0].id_customer+")'>send Alert</button><span class='help-block'>(if document not recieved)</span>";
                            else if (data[0].verification_status == 1)
                                alert_sent="<button class='btn btn-warning' onclick='sendAlert(3,"+data.id_customer+")'>Resend Alert</button><span class='help-block'>(if valid document not recieved)</span>";
                            else
								alert_sent="<button class='btn btn-default'>Verified</button>";
 						}
 						$("#id_customer").html(data[0].id_customer);	
						$("#customer_firstname").html(data[0].firstname+"( "+data[0].email+" )");	
						$("#mobile").html(data[0].mobile);	
						$("#doc_status").html(status);	
						$("#download_document").html(document_download);	
						$("#verification_document").html(document_doc);	
						$("#verification_alert_sent").html(alert_sent);	
						$("#last_sent").html(data[0].verification_alert_sent);
						
						
						
					}
						
				}
			});
}