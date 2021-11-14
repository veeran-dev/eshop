window.pocLang=new Array();

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
					//data.reverse();
 					for(var i=0; i<data[0].length; i++)
					{	
						var Sno=i+1;
						if(data[0][i].delivery == 1)
 							var delivery ="Yes";
 						else
 							var delivery ="No";
 						if(data[0][i].replacement == 1)
 							var replacement ="Yes";
 						else
 							var replacement ="No";
						
						$('#vendorTable').append("<tr class='vendorList_"+data[0][i].id_vendor+"' id='tr_"+data[0][i].id_vendor+"'>\
							<td class='white-bg serial_no' >"+Sno+"</td>\
							<td class='white-bg table_action'>\
								<span id='save_"+data[0][i].id_vendor+"' class='fa fa-save cur-poi savePart_"+data[0][i].id_vendor+"' style='display:none' onclick='saveVendor("+data[0][i].id_vendor+")'></span>\
								<span id='edit_"+data[0][i].id_vendor+"' class='fa fa-edit cur-poi editPart_"+data[0][i].id_vendor+"' onclick='editVendor("+data[0][i].id_vendor+");'></span>&nbsp;&nbsp;\
								<span id='cancel_"+data[0][i].id_vendor+"' style='display:none' class='fa fa-reply cur-poi savePart_"+data[0][i].id_vendor+"' onclick='cancelEdit("+data[0][i].id_vendor+")'></span>\
								<span id='delete_"+data[0][i].id_vendor+"' class='fa fa-trash-o cur-poi editPart_"+data[0][i].id_vendor+"' onclick='deleteVendor("+data[0][i].id_vendor+")'></span>\
							</td>\
							<td class='white-bg table_name'>\
								<input class='noBorder display-none' type='text' id='name_"+data[0][i].id_vendor+"' name='name_"+data[0][i].id_vendor+"' value='"+data[0][i].name+"'>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" vendor-name-"+data[0][i].id_vendor+"'>"+data[0][i].name+"</span>\
							</td>\
							<td class='fixed_width'>\
								<input class='noBorder display-none' type='text' id='gst_"+data[0][i].id_vendor+"' name='gst_"+data[0][i].id_vendor+"' value='"+data[0][i].gst+"' readonly>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" gst-no-"+data[0][i].id_vendor+"'>"+data[0][i].gst+"</span>\
							</td>\
							<td class='fixed_width'>\
								<input class='noBorder display-none' type='text' id='panNo_"+data[0][i].id_vendor+"' name='panNo_"+data[0][i].id_vendor+"' value='"+data[0][i].pan+"' readonly>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" pan-no-"+data[0][i].id_vendor+"'>"+data[0][i].pan+"</span>\
							</td>\
							<td class='fixed_width'>\
								<input class='noBorder display-none' type='text' id='phone_"+data[0][i].id_vendor+"' name='phone_"+data[0][i].id_vendor+"' value='"+data[0][i].phone+"' readonly>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" phone-no-"+data[0][i].id_vendor+"'>"+data[0][i].phone+"</span>\
							</td>\
							<td class='fixed_width'>\
								<select id='centre_"+data[0][i].id_vendor+"' class='form-control input-sm m-bot15' class='noBorder' readonly></select>\
							</td>\
							<td class='fixed_width'>\
								<select id='payment_"+data[0][i].id_vendor+"' class='form-control input-sm m-bot15' class='noBorder' readonly></select>\
							</td>\
							<td class='fixed_width'>\
								<input class='noBorder display-none' type='text' id='credit_"+data[0][i].id_vendor+"' name='credit_"+data[0][i].id_vendor+"' value='"+data[0][i].credit_days+"' readonly>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" credit-days-"+data[0][i].id_vendor+"'>"+data[0][i].credit_days+"</span>\
							</td>\
							<td class='cur-poi fixed_width' ><a onclick='getBank("+data[0][i].id_vendor+");' data-toggle='modal'  href='#showBank'>View</a></td>\
							<td class='cur-poi fixed_width' ><a onclick='getAddress("+data[0][i].id_vendor+");' data-toggle='modal'  href='#showAddress'>View</a></td>\
							<td class='cur-poi fixed_width' onclick='getPOC("+data[0][i].id_vendor+")'><a data-toggle='modal'  href='#showPoc'>View</a></td>\
							<td class='fixed_width'>\
								<input class='noBorder display-none' type='text' id='website_"+data[0][i].id_vendor+"' name='website_"+data[0][i].id_vendor+"' value='"+data[0][i].website+"' readonly>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" website-"+data[0][i].id_vendor+"'>"+data[0][i].website+"</span>\
							</td>\
							<td class='fixed_width'>\
								<input class='noBorder display-none' type='text' id='delivery_"+data[0][i].id_vendor+"' name='delivery_"+data[0][i].id_vendor+"' value='"+delivery+"' readonly>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" delivery-"+data[0][i].id_vendor+"'>"+delivery+"</span>\
							</td>\
							<td class='fixed_width'>\
								<input class='noBorder display-none' type='text' id='replace_"+data[0][i].id_vendor+"' name='replace_"+data[0][i].id_vendor+"' value='"+replacement+"' readonly>\
								<span class='hide-data-on-edit-"+data[0][i].id_vendor+" replacement-"+data[0][i].id_vendor+"'>"+replacement+"</span>\
							</td>\
							<td class='fixed_width'>\
								<textarea rows='3' class='noBorder' id='comments_"+data[0][i].id_vendor+"' name='comments_"+data[0][i].id_vendor+"' readonly>"+data[0][i].comments+"</textarea>\
							</td>\
						</tr>");	
						for(var x=0;x<data[1].length; x++)
						{
	  						if(data[0][i].id_payment == data[1][x].id_payment)
	 							$("#payment_"+data[0][i].id_vendor+"").append("<option selected='selected' value="+data[1][x].id_payment+">"+data[1][x].paymentMode+"</option>");
	 						else
								$("#payment_"+data[0][i].id_vendor+"").append("<option value="+data[1][x].id_payment+">"+data[1][x].paymentMode+"</option>");
						}
						
						$("#centre_"+data[0][i].id_vendor+"").append("<option >Select Fulfillment Centre</option>");
						for(var k=0;k<data[2].length;k++) 
						{
							if(data[2][k].id_fulfillment_centre == data[0][i].id_fulfillment_centre)
								$("#centre_"+data[0][i].id_vendor+"").append("<option value="+data[2][k].id_fulfillment_centre+" selected='selected'>"+data[2][k].city_name+"</option>");
							else
								$("#centre_"+data[0][i].id_vendor+"").append("<option value="+data[2][k].id_fulfillment_centre+">"+data[2][k].city_name+"</option>");
						}					}
					vendorListSearch('vendorListTab');
				}
 	})
 	getContry(0);
	getPocLang(); 
});

function deleteVendor(id)
{
	var type=2;
	var dataparam = '&type='+type+'&vendorId='+id;	 
	$.ajax({
				type: 'POST',
 				async: true,
 				url: 'scn-vendorlistdata.php',
				data:dataparam,
				cache: true,
				success: function(data)
				{
					if(data == 1)
					{
						 $("#tr_"+id).remove();
						 toast("Vendor Deleted Successfully","success");
						 vendorList();
					}
					else
					{
						 toast("Problem in Vendor Delete","error");
					}
				}
	})
}
function editVendor(id)
{
	/*$('#edit_'+id).hide();
	$('#save_'+id).show();
	$('#delete_'+id).hide();
	$('#cancel_'+id).show();*/
	$('.savePart_'+id).show();
	$('.editPart_'+id).hide();
	$('.hide-data-on-edit-'+id).hide();
 	$(".vendorList_"+id+">td>input.noBorder").removeClass("noBorder");
	$(".vendorList_"+id+">td>select.noBorder").removeClass("noBorder");
	$(".vendorList_"+id+">td>textarea.noBorder").removeClass("noBorder");
	$(".vendorList_"+id+">td>input").addClass("form-control");
	$(".vendorList_"+id+">td>select").addClass("form-control");
	$(".vendorList_"+id+">td>textarea").addClass("form-control");
  	$('.form-control').attr('readonly',false); 
}
function cancelEdit(id)
{
	/*$('#edit_'+id).show();
	$('#save_'+id).hide();
	$('#delete_'+id).show();
	$('#cancel_'+id).hide();*/
	$('.savePart_'+id).hide();
	$('.editPart_'+id).show();
	$('.hide-data-on-edit-'+id).show();
	
	$(".vendorList_"+id+">td>input.form-control").removeClass("form-control");
	$(".vendorList_"+id+">td>select.form-control").removeClass("form-control");
	$(".vendorList_"+id+">td>textarea.form-control").removeClass("form-control");
	$(".vendorList_"+id+">td>input").addClass("noBorder");
	$(".vendorList_"+id+">td>select").addClass("noBorder");
	$(".vendorList_"+id+">td>textarea").addClass("noBorder");
	$('.noBorder').attr('readonly',true);
}

function saveVendor(id)
{
	var type = 2;
	var delivery  = $('#delivery_'+id).val();
	var replacement = $('#replace_'+id).val();

	if(delivery == "Yes" || delivery == "yes")
 		delivery = 1;
 	else
 		delivery = 0;

 	if(replacement == "Yes" || replacement == "yes")
 		replacement = 1;
 	else
 		replacement = 0;

 	var fc=$('#centre_'+id+' :selected').val();
  	var dataparam = '&type='+type+'&vendorId='+id+'&fc='+fc+'&vendorName='+$('.DTFC_LeftBodyLiner #name_'+id).val()+'&gstNo='+$('#gst_'+id).val()+'&website='+$('#website_'+id).val()+'&creditDays='+$('#credit_'+id).val()+'&paymentMode='+$('#payment_'+id).val()+'&replacement='+replacement+'&vendorComment='+$('#comments_'+id).val()+'&delivery='+delivery+'&panNo='+$('#panNo_'+id).val()+'&phoneNo='+$('#phone_'+id).val();
	
	$.ajax({
		type: 'POST',
		async: true,
		url: 'scn-vendor.php',
		data:dataparam,
		cache: true,
		success: function(data)
		{
			if(data == 1)
			{
				$('.vendor-name-'+id).html($('.DTFC_LeftBodyLiner #name_'+id).val());
				$('.gst-no-'+id).html($('#gst_'+id).val());
				$('.website-'+id).html($('#website_'+id).val());
				$('.credit-days-'+id).html($('#credit_'+id).val());
				$('.replacement-'+id).html($('#replace_'+id).val());
				$('.delivery-'+id).html($('#delivery_'+id).val());
				$('.pan-no-'+id).html($('#panNo_'+id).val());
				$('.phone-no-'+id).html($('#phone_'+id).val());
				cancelEdit(id);
			    toast("Vendor Updated Successfully","success");
			}
			else
			{
				 toast("Problem in Vendor update","error");
			}
		}
	});
}

function getAddress(vendorid)
{
	clear(1);
	$('#id_vendor').val(vendorid);
	$('.form-control>input').html('');
	$('.form-control>textarea').html('');
	$('.form-control>radio').html('');
	$('.form-control>select').html('');
	var type=3;
	var dataparam = '&type='+type+'&vendorId='+vendorid;
 	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
				$('#aliseAddress').html('');
				
				for(var i=0; i<data.length; i++)
				{
					$('#aliseAddress').append('<div><button class="btn btn-primary col-sm-12 margin" id="button_'+data[i].id_address+'" onclick="getAddressDetails('+data[i].id_address+','+vendorid+')" type="button">'+data[i].alise+'</button></div>');
				}
				
			}
			
	})	
}
function getAddressDetails(addressId,vendorid)
{
	var type=4;
	clear(1);
	var dataparam = '&type='+type+'&addressId='+addressId+'&vendorId='+vendorid;
	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
  				 
				$('.form-control>input').html('');
				$('.form-control>textarea').html('');
				$('.form-control>radio').html('');
				$('.form-control>select').html('');
				
				$('#alise').val(data[0].alise);
				$('#address1').val(data[0].address1);
				$('#city').val(data[0].city);
				$('#pincode').val(data[0].pincode);
				$('#landmark').val(data[0].landmark);
				$('#phone').val(data[0].phone);
				$('#fax').val(data[0].fax);
				$('#WorkingDays').val(data[0].working_days);
				$('#WorkingHours').val(data[0].working_hour);
				if(data[0].delivery == 1)
				{
 					$('#deliveryYes').prop( "checked", true );
				}
				else
				{
 					$('#deliveryFalse').prop( "checked", true );
				}
				if(data[0].id_default_address == data[0].id_address)
				{
 					$('#defaultYes').prop( "checked", true );
				}
				else
				{
 					$('#defaultNo').prop( "checked", true );
				}
				/*$( "input" ).on( "click", function() {
				$( "#log" ).html( $( "input:checked" ).val() + " is checked!" );
				});*/
				
				$('#defaultAddress').val();
				$('#comments').val(data[0].comments);
				getContry(data[0].country,data[0].id_state);
 				
				$('#id_vendor').val(vendorid);
				$('#id_address').val(addressId);
				
			}
	})	
}
function getContry(id,id_state)
{
 	$.ajax({
			type: 'POST',
			url: 'dash-address.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{type:1},
			success: function(data)
			{
				$("#country").html('');
 				for(var i=0; i<data.length; i++)
				{
					if(data[i].id == id)
					{
						getState(data[i].id,id_state);
 						$("#country").append('<option selected="selected" value='+data[i].id+'>'+data[i].name+'</option>');
					}
					else
						$("#country").append('<option  value="'+data[i].id+'">'+data[i].name+'</option>');
				}
			}
	})
}
function getState(id_country,id_state)
{
	if(id_country==0)
	{
		var id_country = $("#country").val();
	}
 	$.ajax({
			type: 'POST',
			url: 'dash-address.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{type:4,id_country:id_country},
			success: function(stateData)
			{
				console.log(stateData);
 				$("#state").html('');
				for(var j=0; j<stateData.length; j++)
				{
					if(stateData[j].id_state == id_state)
					{
						$("#state").append('<option selected="selected" value="'+stateData[j].id_state+'">'+stateData[j].name+'</option>');
					}
					else
					{
						$("#state").append('<option  value="'+stateData[j].id_state+'">'+stateData[j].name+'</option>');
					}
				}
			}
			
	})
}
function saveEditValue()
{
	
			var vendorId = $('#id_vendor').val();
			var addressAlise= $('#alise').val();
			var address =	$('#address1').val();
			
			var city=	$('#city').val();
			var state = $('#state').val();
			var country= $('#country').val();
 			var pincode =$('#pincode').val();
			var landmark =$('#landmark').val();
			var phone =	$('#phone').val();
			var fax =$('#fax').val();
			var workingDays =	$('#WorkingDays').val();
			var workingHours =	$('#WorkingHours').val();
			var addressComment =	$('#comments').val();
 			var defaultAddress = $('input[name=defaultAddress]:checked').val(); 
			var addressDelivery = $('input[name=AddressDelivery]:checked').val(); 
			var addressId=$('#id_address').val();
			if(addressId=="")
			{
				var type=3;
			}
			else
			{
				var type=4;
			}
			var dataparam='&type='+type+'&addressAlise='+addressAlise+'&address='+address+'&city='+city+'&state='+state+'&country='+country+'&pincode='+pincode+'&landmark='+landmark+'&phone='+phone+'&fax='+fax+'&workingDays='+workingDays+'&workingHours='+workingHours+'&addressComment='+addressComment+'&defaultAddress='+defaultAddress+'&addressDelivery='+addressDelivery+'&vendorId='+vendorId+'&addressId='+addressId;
  			$.ajax({
			type: 'POST',
			url: 'scn-vendor.php',
			async: true,
			cache: false,
			dataType : "json",
			data:dataparam,
			success: function(data)
			{
 				if(data == addressId )
				{
					 $('#button_'+data).html(addressAlise);
					 /*$("#idScnGlobalAlert").html(alertmsg);
					 //$('#showAddress').modal('hide');
					 $('#scnGlobalAlert').modal('show');*/
					 toast("Address Updated successfully","success");
					 clear(1);
				}
				else
				{
 					$('#aliseAddress').append('<div><button class="btn btn-primary col-sm-12 margin" id="button_'+data+'" onclick="getAddressDetails('+data+','+vendorId+')" type="button">'+addressAlise+'</button></div>');
					toast("Address added successfully","success");
					 /*$("#idScnGlobalAlert").html(alertmsg);
					 //$('#showAddress').modal('show');
					 $('#scnGlobalAlert').modal('show');*/
					 clear(1);
				}
 			}
			
	})
				
}
/*To get POC*/
function getPOC(vendorid)
{
	clear(2);
	$('#address_poc').html('');
	$('#pocName').html('');
	$('#id_vendor_poc').val(vendorid);
	var type=5;
	var dataparam = '&type='+type+'&vendorId='+vendorid;
 	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
				$('#aliseAddress').html('');
				
				for(var i=0; i<data[0].length; i++)
				{
					$('#pocName').append('<div id="poc_'+data[0][i].id_poc+'"><button class="btn btn-primary col-sm-7 margin" onclick="getPocDetails('+data[0][i].id_poc+','+vendorid+')" type="button">'+data[0][i].firstname+'</button><button class="btn btn-warning col-sm-3 margin" onclick="deletePOC('+data[0][i].id_poc+')" type="button">Delete</button></div>');
 				}
				for(var z=0; z<data[1].length;z++)
				{
 					$('#address_poc').append('<option value="'+data[1][z].id_address+'">'+data[1][z].alise+'</option>');
				}
			}
			
	})
	
}
/*to get particular details of POC*/
function getPocDetails(poc,vendorId)
{
	var type=6;
 	var dataparam = '&type='+type+'&poc='+poc+'&vendorId='+vendorId;
 	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
  				$('.form-control>input').html('');
				$('.form-control>textarea').html('');
				$('.form-control>radio').html('');
				$('.form-control>select').html('');
				$('#address_poc').html('');
				$('#poc_lang').html('');
  				$('#firstname').val(data[0][0].firstname);
				$('#designation').val(data[0][0].designation);
				/*$('#designation').val(data[0][0].id_address);*/
				$('#phone1').val(data[0][0].phone1);
				$('#mobile').val(data[0][0].phone2);
				$('#email').val(data[0][0].email);
 				$('#pocComments').val(data[0][0].comments);
				if(data[0][0].smart_phone == 1)
				{
 					$('#smartphoneYes').prop( "checked", true );
				}
				else
				{
 					$('#smartphoneNo').prop( "checked", true );
				}
				if(data[0][0].id_default_poc == poc)
				{
 					$('#defaultPocYes').prop( "checked", true );
				}
				else
				{
 					$('#defaultPocNo').prop( "checked", true );
				}
				for (var k=0;k<data[1].length;k++)
				{
					$('#poc_lang').append("<span id='lang_"+data[1][k].id_lang+"'><span class='btn btn-info btn-xs margin' id="+data[1][k].id_lang+">"+data[1][k].name+"</span><span class='btn btn-warning btn-xs margin' onclick='deletePOCLang("+data[1][k].id_lang+","+poc+")'>Delete</span></br></span>");
				}
				for(var z=0; z<data[2].length;z++)
				{
					if(data[2][z].id_address==data[0][0].id_address)
						$('#address_poc').append('<option select="selected" value="'+data[2][z].id_address+'">'+data[2][z].alise+'</option>');
					else
						$('#address_poc').append('<option value="'+data[2][z].id_address+'">'+data[2][z].alise+'</option>');
				}
				getPocLang();
				 $('#id_poc').val(poc);
				 $('#id_vendor_poc').val(vendorId);
 			}
	})	
}
function savePocEditValue()
{
	
	var pocName = $('#firstname').val();
	var designation = $('#designation').val();
	var addressId = $('#address_poc').val();
	var pocMobile1 = $('#phone1').val();
	var pocMobile2 = $('#mobile').val();
	var pocEmail = $('#email').val();
	var pocComment =$('#pocComments').val();
	var pocSmartPhone = $('input[name=Smartphone]:checked').val(); 
	var defaultPoc =$('input[name=defaultPoc]:checked').val(); 
 	var poc =  $('#id_poc').val();
	var language =  pocLang;
 	
	if(poc=="")
	{
		var type=10;//add new poc
	}
	else
	{
		var type=9;//Edit Existing Poc
	}
  	
	var vendorId =  $('#id_vendor_poc').val();
	var dataparam='&type='+type+'&pocName='+pocName+'&designation='+designation+'&addressId='+addressId+'&pocMobile1='+pocMobile1+'&pocMobile2='+pocMobile2+'&pocEmail='+pocEmail+'&pocComment='+pocComment+'&pocSmartPhone='+pocSmartPhone+'&defaultPoc='+defaultPoc+'&poc='+poc+'&vendorId='+vendorId+'&language='+language;
  	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
  				if(data==1)
				{
 					$('#id_poc').val("");
					toast("POC Updated successfully","success");
					 /*$("#idScnGlobalAlert").html(alertmsg);
					 //$('#showPoc').modal('hide');
					 $('#scnGlobalAlert').modal('show');*/
					 clear(2);
				}
				else
				{
					var vendorId =  $('#id_vendor_poc').val();
					$('#pocName').append('<div id="poc_'+data+'"><button class="btn btn-primary col-sm-7 margin" onclick="getPocDetails('+data+','+vendorId+')" type="button">'+pocName+'</button><button class="btn btn-warning col-sm-3 margin" onclick="deletePOC('+data+')" type="button">Delete</button></div>');
 					$('#id_poc').val("");
					toast("POC Added successfully","success");
					clear(2);
					
				}

				
			}
			
	})	
 	
}
function saveLangValue()
{
	var language = $('#language').val();
	var testLangPoc=$('#language option:selected').text();
	var poc =  $('#id_poc').val();
	if(poc=="")
	{
		pocLang.push(language);
		$('#poc_lang').append("<span id='lang_"+language+"'><span class='btn btn-info btn-xs margin' id="+language+">"+testLangPoc+"</span><span class='btn btn-warning btn-xs margin' onclick='deletePOCLang("+language+",0)'>Delete</span></br></span>");
	}
	else
	{
		
	var type=7
	var dataparam = '&type='+type+'&poc='+poc+'&language='+language;
  	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
  				$('#poc_lang').append("<span id='lang_"+data[0].id_lang+"'><span class='btn btn-info btn-xs margin' id="+data[0].id_lang+">"+data[0].name+"</span><span class='btn btn-warning btn-xs margin' onclick='deletePOCLang("+data[0].id_lang+","+poc+")'>Delete</span></br></span>");
			}
	})
	}
}
function deletePOCLang(id,poc)
{
 	if(poc==0)
	{
		var y=pocLang
		var removeItem = id;
		y = y.splice( $.inArray(removeItem,y) ,id );
		$('#lang_'+id).remove();
		return false;
	}
 	var type=8;
 	var dataparam = '&type='+type+'&poc='+poc+'&language='+id;
 	$.ajax({
			type: 'POST',
			async: true,
			/*dataType:'json',*/
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
				if(data==1)
				{
					$('#lang_'+id).remove();
				}
 			}
	})
}
function getPocLang()
{
	$("#language").html("");
	$.ajax({
			type: 'POST',
			url: 'dash-address.php',
			async: true,
			cache: false,
			dataType : "json",
		
			data:{type:5},
			success: function(data)
			{
				
 				for(var i=0; i<data.length; i++)
				{
						$("#language").append('<option  value="'+data[i].id_lang+'">'+data[i].name+'</option>');
				}
			}
	})
}
function clear(stage)
{
 	if(stage==1)
	{
 		$('#id_address').val("");
 		$('#alise').val("");
		$('#address1').val("");
		
		$('#city').val("");
		$('#state').val("");
		$('#country').val("");
		$('#pincode').val("");
		$('#landmark').val("");
		$('#phone').val("");
		$('#fax').val("");
		$('#WorkingDays').val("");
		$('#WorkingHours').val("");
		$('#comments').val("");
		$('#deliveryYes').val("");
		$('#deliveryFalse').val("");
		$('#defaultYes').val("");
		$('#defaultNo').val("");
		 
 	}
	if(stage==2)
	{
		$('#firstname').val('');
		$('#designation').val('');
		$('#phone1').val('');
		$('#mobile').val('');
		$('#poc_lang').html('');
		$('#email').val('');
		$('#pocComments').val('');
		$('#smartphoneYes').val('');
		$('#smartphoneNo').val('');
		$('#defaultPocYes').val('');
		$('#defaultPocNo').val('');
 	}
	if(stage==3)
	{
		$('#selectVendor').val('');
		$('#vendorAddress').val('');
		$('#bankName').val('');
		$('#bankBranch').val('');
		$('#bankAddress').val('');
		$('#accountName').val('');
		$('#accountNumber').val('');
		$('#ifsccode').val('');
		$('#accountType').val(''); 
	}
 }
 
 function deletePOC(pocID)
 {
	var type=11;
	var dataparam = '&type='+type+'&poc='+pocID;
 	$.ajax({
			type: 'POST',
			async: true,
			/*dataType:'json',*/
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
  				if(data==1)
				{
					$("#poc_"+pocID).remove();
				}
			}
	})
 }
 function getBank(vendorId)
 {
	 clear(3);
	var type=12;
 	$('#vendorAddress').html('');
	$('#id_bank_vendor').val(vendorId);
  	$('#selectVendor').val($('#name_'+vendorId).val());
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
				
				$('#BankName').html('');
				
				for(var i=0; i<data[0].length; i++)
				{
  					$('#BankName').append('<div id="bank_'+data[0][i].id_bank+'"><button class="btn btn-primary col-sm-7 margin" id="bankButton_'+data[0][i].id_bank+'" onclick="getBankDetails('+data[0][i].id_bank+','+vendorId+')" type="button">'+data[0][i].bank_name+'/'+data[0][i].branch+'</button><button class="btn btn-warning col-sm-3 margin" onclick="deleteBank('+data[0][i].id_bank+')" type="button">Delete</button></div>');
 				}
				for(var j=0; j<data[1].length;j++)
				{
					$("#vendorAddress").append("<option value='"+data[1][j].id_address+"'>"+data[1][j].alise+"</option>");
				}
				
			}
			
	})
 }
 function getBankDetails(bankId,vendorId)
 {
	 clear(3);
	 var type=13;
	var dataparam = '&type='+type+'&vendorId='+vendorId+'&bankId='+bankId;
  	$.ajax({
			type: 'POST',
			async: true,
			dataType:'json',
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
  				$('#selectVendor').val(data[0][0].name);
				$('#bankName').val(data[0][0].bank_name);
				$('#bankBranch').val(data[0][0].branch);
				$('#bankAddress').val(data[0][0].branch_address);
				$('#accountName').val(data[0][0].account_name);
 				$('#accountNumber').val(data[0][0].account_no);
				$('#ifsccode').val(data[0][0].ifsc_code);
				$('#vendorAddress').html('');
 				for(var i=0; i<data[1].length; i++)
				{
 					if(data[1][i].id_address==data[0][0].id_address)
					{
						$('#vendorAddress').append("<option selected='selected' value="+data[1][i].id_address+">"+data[1][i].alise+"</option>");
					}
					else
						$('#vendorAddress').append("<option value="+data[1][i].id_address+">"+data[1][i].alise+"</option>");
				}
  				 if(data[0][0].account_type==1)
				 {
					$('#accountType').val(1); 
				 }
				 if(data[0][0].account_type==2)
				 {
					$('#accountType').val(2); 
				 }
				 if(data[0][0].account_type==3)
				 {
					$('#accountType').val(3); 
				 }
				 $('#id_bank').val(bankId);
  			}
			
	})
 }
 function saveBankEditValue()
 {
	 var vendorId=$('#id_bank_vendor').val();
 	 var bankId=$('#id_bank').val();
 	 var bankName=$('#bankName').val();
	 var vendorAddress=$('#vendorAddress').val();
	 var bankBranch=$('#bankBranch').val();
	 var bankAddress=$('#bankAddress').val();
	 var accountName=$('#accountName').val();
	 var accountType=$('#accountType').val();
	 var accountNumber=$('#accountNumber').val();
	 var ifsccode=$('#ifsccode').val();
	 if(bankId!="")
 	 	var type=14;
	else
		var type=16;
	 var dataparam = '&type='+type+'&bankId='+bankId+'&bankName='+bankName+'&bankBranch='+bankBranch+'&bankAddress='+bankAddress+'&accountName='+accountName+'&accountType='+accountType+'&accountNumber='+accountNumber+'&ifsccode='+ifsccode+'&vendorAddress='+vendorAddress+'&selectVendor='+vendorId;
      	$.ajax({
			type: 'POST',
			async: true,
			/*dataType:'json',*/
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
				if(type==14)
				{
					if(data==1)
					{
						clear(3);
						$("#bankButton_"+bankId).html(bankName+"/"+bankBranch);
						toast("Bank Details Updated Successfully","success");
					}
					else
						toast("Oops something went wrong while updating please update one more time","error");
				}
				if(type==16)
				{
					if(data!=0)
					{
						clear(3);
						toast("Bank Details Added Successfully","success");
						$('#BankName').append('<div id="bank_'+data+'"><button class="btn btn-primary col-sm-7 margin" onclick="getBankDetails('+data+','+vendorId+')" id="bankButton_'+data+'" type="button">'+bankName+'/'+bankBranch+'</button><button class="btn btn-warning col-sm-3 margin" onclick="deleteBank('+data+')" type="button">Delete</button></div>');
					}
					else
						toast("Oops something went wrong while updating please update one more time","error");
				}
			}
	});
	 
 }
 function deleteBank(bankId)
 {
 	 var type=15;
	 var dataparam = '&type='+type+'&bankId='+bankId;
 	 $.ajax({
			type: 'POST',
			async: true,
			/*dataType:'json',*/
			url: 'scn-vendorlistdata.php',
			data:dataparam,
			cache: true,
			success: function(data)
			{
 				if(data==1)
				{
					$('#bank_'+bankId).remove();
					clear(3);
					toast("Bank Details Deleted Successfully","success");
				}
				else
					toast("Oops something went wrong while deleting please delete one more time","error");
			}
	});
 }