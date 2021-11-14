/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$(document).ready(function(){
 	if (typeof formatedAddressFieldsValuesList !== 'undefined')
		updateAddressesDisplay(true);
	
	 
	
	//$this->context->cart->id_address_invoice
	/*$(document).on('change', 'select[name=id_address_delivery], select[name=id_address_invoice]', function(){
		updateAddressesDisplay();
		if (typeof opc !=='undefined' && opc)
			updateAddressSelection();
	});*/
	/*$(document).ready(function(){
		});*/
	/*$(document).on('click','#changePincode',function(){
		$("#error_modal").modal("hide");
		$('#kob_state').modal('show');
	});*/
	$(document).on('click', 'input[name=same]', function(){
		updateAddressesDisplay();
		if (typeof opc !=='undefined' && opc)
			updateAddressSelection();
	});
	
	 
	 //$("#order_address").click(function()
 	$(document).on('click','#order_address',function(){
	if($("#new_order_address").hasClass("unvisible"))
	{
		$("#order_address").html("Cancel");
		$("#new_order_address").removeClass("unvisible");
	}
	else
	{
		$("#order_address").html("Add a new address");
		$("#new_order_address").addClass("unvisible");
	}
	});
	
	
});
function submitProcessAddress()
{
	$("#processAddress").click();

	//var state_name=$("").val();
	/*var sort=$(".address_delivery input[name='id_address_delivery']:checked").val();
	var state_name=$("#address_delivery_"+sort+" .address_state_name").html();
	state_name=state_name.toUpperCase();	
	state_name=removeDiacritics(state_name);	
	
 	if(state_name==name_state_vat){
 		
 		$("#processAddress").click();
 	}
 	else{ 		
 		$("#error_modal").modal("show");
 		$("#error_modal .modal-error").html("Pincode entered and the address chosen are different<br> Tax varies based on State<br><div><span id='changePincode'><a>Click here</a></span> to change the pincode</div>");
 	}*/
}
function removeDiacritics (state_name) {

	var defaultDiacriticsRemovalMap = [
	    {'base':'A', 'letters':/[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g},
	    {'base':'E', 'letters':/[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g},
	    {'base':'I', 'letters':/[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g},
	    {'base':'O', 'letters':/[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g},
	    {'base':'U', 'letters':/[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g},
	    {'base':'a', 'letters':/[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g},
	    {'base':'e', 'letters':/[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g},
	    {'base':'i', 'letters':/[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g},
	    {'base':'o', 'letters':/[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g},
	    {'base':'u','letters':/[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g}
	];
	var changes;
    if(!changes) {
        changes = defaultDiacriticsRemovalMap;
    }
    var str=state_name;
    for(var i=0; i<changes.length; i++) {
        str = str.replace(changes[i].letters, changes[i].base);
    }
    return str;
}
function saveAddress()
{
 	$('.error_msg').html('');
	
	
	var firstname=$("#firstname").val();
	var company=$("#company").val();
	var address1=$("#address1").val();
	var postcode=$("#add_address #postcode").val();
	var city=$("#city").val();
	var phone_mobile=$("#add_address #phone_mobile").val();
	var state=$("#id_state").val();
	var country=$("#id_country").val();
	var status=true;

	if(firstname=="")
	{
		$('#error_name').html('Please enter your name');
		status=false;
	}
 	if(firstname!="")
	{
		if(!firstname.match(/^[a-zA-Z ]*$/))
		{
			$('#error_name').html('Please enter a valid Name');
			 status=false;
		}
	}
 	if(address1=="")
	{
		$('#error_address').html('Please enter your Address');
		status=false;
	}
	if(address1!="")
	{
		if(!address1.match(/^[a-zA-Z0-9-#.,()&'\/\"\s]*$/))
		{
			$('#error_address').html('Please enter a valid address');
			 status=false;
		}
	}
 	if(postcode=="")
	{
		$('#error_postcode').html('Please enter your Pincode');	
		status=false;	
	}
	if(postcode!="")
	{
		if(postcode.length<6)
		{
			$('#error_postcode').html('Pincode should be of 6 characters');	
			status=false;	
		}
	}
	if(postcode!="")
	{
		if(!postcode.match(/^[0-9]+$/))
		{
			$('#error_postcode').html('Pincode should contain only numbers');
			status=false;
		}
	}
	if(city=="")
	{
		$('#error_city').html('Please enter your City');
		status=false;
	}
	if(city!="")
	{
		if(!city.match(/^[a-zA-Z ]*$/))
		{
			$('#error_city').html('Please enter a valid City');
			 status=false;
		}
	}
	if(phone_mobile=="")
	{
		$('#error_mobile').html('Please enter your Mobile Number');
		status=false;
	}
	if(phone_mobile!="")
	{
		if(!phone_mobile.match(/^[0-9]+$/))
		{
			$('#error_mobile').html('Only numbers allowed');
			status=false;
		}
	}
	if(phone_mobile!="")
	{
		if(phone_mobile.length<10)
		{
			$('#error_mobile').html('Mobile number should be of 10 digits');
			status=false;
		}
	}
	if(state=="")
	{
		$('#error_state').html('Please select state');
		status=false;
	}
	if(company=="")
	{
		$('#error_company').html('Please enter Company');
		status=false;
	}
 	return status;
 }


//update the display of the addresses
function updateAddressesDisplay(first_view)
{
	
	// update content of delivery address
	updateAddressDisplay('delivery');
	var txtInvoiceTitle = "";
	try{
		var adrs_titles = getAddressesTitles();
		txtInvoiceTitle = adrs_titles.invoice;
	}
	catch (e)
	{}
	// update content of invoice address
	//if addresses have to be equals...
	if ($('#addressesAreEquals:checked').length === 1 && ($('#multishipping_mode_checkbox:checked').length === 0))
	{
		if ($('#multishipping_mode_checkbox:checked').length === 0) {
			$('#address_invoice_form:visible').hide('fast');
		}
		$('ul#address_invoice').html($('ul#address_delivery').html());
		$('ul#address_invoice li.address_title').html(txtInvoiceTitle);
		// var firstInput = $('form').find('input[type=radio][name="id_address_delivery"]').filter(':visible:first');
  //       if (firstInput != null) {
  //           firstInput.attr('checked',true);
  //       }
	}
	else
	{
		$('#address_invoice_form:hidden').show('fast');
		//alert($('#id_address_invoice').val());
		//if ($('#id_address_invoice').val())
			updateAddressDisplay('invoice');
		/*else
		{
			$('ul#address_invoice').html($('ul#address_delivery').html());
			$('ul#address_invoice li.address_title').html(txtInvoiceTitle);
		}*/
		// var firstInput = $('form').find('input[type=radio][name="id_address_delivery"]').filter(':visible:first');
  //       if (firstInput != null) {
  //           firstInput.attr('checked',true);
  //       }
	}
	if(!first_view)
	{
		if (orderProcess === 'order')
			updateAddresses();
	}
	return true;
}

function updateAddressDisplay(addressType)
{
  	if (formatedAddressFieldsValuesList.length <= 0)
		return false;
	
	$('input:radio[name="id_address_'+addressType+'"]').each(function() {
		
		var idAddress = $(this).val();
		buildAddressBlock(idAddress, addressType, $('#address_'+ addressType + '_' + idAddress));	
	});
	/*if (typeof formatedAddressFieldsValuesList == 'undefined' || formatedAddressFieldsValuesList.length <= 0)
		return;

	var idAddress = parseInt($('#id_address_' + addressType + '').val());
	buildAddressBlock(idAddress, addressType, $('#address_' + addressType));

	// change update link
	var link = $('ul#address_' + addressType + ' li.address_update a').attr('href');
	var expression = /id_address=\d+/;
	if (link)
	{
		link = link.replace(expression, 'id_address=' + idAddress);
		$('ul#address_' + addressType + ' li.address_update a').attr('href', link);
	}*/
}

function updateAddresses()
{
	var idAddress_delivery = parseInt($('#id_address_delivery').val());
	var idAddress_invoice = $('#addressesAreEquals:checked').length === 1 ? idAddress_delivery : parseInt($('#id_address_invoice').val());

   	if(isNaN(idAddress_delivery) == false && isNaN(idAddress_invoice) == false)
	{
		$('.addresses .waitimage').show();
		$('[name="processAddress"]').prop('disabled', 'disabled');
		$.ajax({
			type: 'POST',
			headers: { "cache-control": "no-cache" },
			url: baseUri + '?rand=' + new Date().getTime(),
			async: true,
			cache: false,
			dataType : "json",
			data: {
				processAddress: true,
				step: 2,
				ajax: 'true',
				controller: 'order',
				'multi-shipping': $('#id_address_delivery:hidden').length,
				id_address_delivery: idAddress_delivery,
				id_address_invoice: idAddress_invoice,
				token: static_token
			},
			success: function(jsonData)
			{
				if (jsonData.hasError)
				{
					var errors = '';
					for(var error in jsonData.errors)
						//IE6 bug fix
						if(error !== 'indexOf')
							errors += $('<div />').html(jsonData.errors[error]).text() + "\n";
		            if (!!$.prototype.fancybox)
		                $.fancybox.open([
		                    {
		                        type: 'inline',
		                        autoScale: true,
		                        minHeight: 30,
		                        content: '<p class="fancybox-error">' + errors + '</p>'
		                    }
		                ], {
		                    padding: 0
		                });
		            else
		                alert(errors);
				}
				$('.addresses .waitimage').hide();
				$('[name="processAddress"]').prop('disabled', '');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$('.addresses .waitimage').hide();
				$('[name="processAddress"]').prop('disabled', '');
				if (textStatus !== 'abort')
				{
					error = "TECHNICAL ERROR: unable to save adresses \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus;
		            if (!!$.prototype.fancybox)
		                $.fancybox.open([
		                    {
		                        type: 'inline',
		                        autoScale: true,
		                        minHeight: 30,
		                        content: '<p class="fancybox-error">' + error + '</p>'
		                    }
		                ], {
		                    padding: 0
		                });
		            else
		                alert(error);
				}
			}
		});
	}
}

function getAddressesTitles()
{
	if (typeof titleInvoice !== 'undefined' && typeof titleDelivery !== 'undefined')
		return {
			'invoice': titleInvoice,
			'delivery': titleDelivery
		};
	else
		return {
			'invoice': '',
			'delivery': ''
		};
}

function buildAddressBlock(id_address, address_type, dest_comp)
{
  	if (isNaN(id_address))
		return;
	var adr_titles_vals = getAddressesTitles();
	var li_content = formatedAddressFieldsValuesList[id_address]['formated_fields_values'];
	var ordered_fields_name = ['title'];
	var reg = new RegExp("[ ]+", "g");
	ordered_fields_name = ordered_fields_name.concat(formatedAddressFieldsValuesList[id_address]['ordered_fields']);
	ordered_fields_name = ordered_fields_name.concat(['update']);
	dest_comp.html('');
	///li_content['title'] = adr_titles_vals[address_type];
	/*li_content['title'] ='<input type="radio" id="id_address_'+address_type+'_'+id_address+'" value="'+id_address+'" style="margin-right:5px;" name="id_address_'+address_type+'" />'+adr_titles_vals[address_type]+edit_button;*/
	if (typeof liUpdate !== 'undefined')
	{
		var items = liUpdate.split(reg);
		var regUrl = new RegExp('(https?://[^"]*)', 'gi');
		liUpdate = liUpdate.replace(regUrl, addressUrlAdd + parseInt(id_address));
		li_content['update'] = liUpdate;
	}
	appendAddressList(dest_comp, li_content, ordered_fields_name);
}

 


function appendAddressList(dest_comp, values, fields_name)
{
	for (var item in fields_name)
	{
		var name = fields_name[item].replace(/,/g, "");
		var value = getFieldValue(name, values);
		if (value != "")
		{
			var new_li = document.createElement('li');
			var reg = new RegExp("[ ]+", "g");
			var classes = name.split(reg);
			new_li.className = '';
			for (clas in classes)
				new_li.className += 'address_' + classes[clas].toLowerCase().replace(":", "_") + ' ';
			new_li.className = $.trim(new_li.className);
			new_li.innerHTML = value;
			dest_comp.append(new_li);
		}
	}
}

function getFieldValue(field_name, values)
{
	var reg = new RegExp("[ ]+", "g");
	var items = field_name.split(reg);
	var vals = new Array();
	for (var field_item in items)
	{
		items[field_item] = items[field_item].replace(/,/g, "");
		vals.push(values[items[field_item]]);
	}
	return vals.join(" ");
}
