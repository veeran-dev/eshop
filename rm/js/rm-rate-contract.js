$(document).ready(function() {
	// For select2 dropdown
	$('#group_selection').select2({
		theme: "bootstrap"
	});
	$('#rate-contract-extend-input').datepicker({format: 'yyyy-mm-dd hi:s:a'});
});

function getRateContract() {
	var id_group = $('#group_selection').val();
	$('#index_viewport').html('');
	$('#index_viewport').load('rm-customerratecontract.php', { 
		smarty: true, 
		id_group: id_group,
		group_selected: true
	}, function() {
		easySearch('customer_rate_contract_table');
	});
}

function changeDate(id_specific_price, id_group, type, to_date, target) {
	var to = to_date.replace("hi:s:a", "23:59:59");
	$.ajax({
		type: 'POST',
		async: true,
		url: 'rm-customerratecontractdata.php',
		data: {type, id_specific_price, id_group, ajax: true, to: target.value, id_employee},
		cache: true,
		success: function(data) {
			var date = new Date(data);
			if(date instanceof Date && !isNaN(date.valueOf())) {
				target.value = data;
				toast("Date changed successfully","success");	
			}
			else {
				$("#"+id_specific_price+"_date").val(to_date);
				toast(data, "error");
			}
		}	
	});
}

function expirePrice(id_specific_price, id_group, type, bulk_expire = false, modal_open = false) 
{
	if(bulk_expire) {
		var id_specific_price = [];
		$('.specific-product-checkbox').each(function() {
			if($(this).is(":checked")) {
				id_specific_price.push($(this).val());
			}
		});

		if(!id_specific_price.length) {
			toast("Please select atleast one product.", "error");
			return false;
		}
		else {
			if(modal_open) {
				$('#confirmation-modal-expire').modal('show');
				return false;
			}
		}
	}

	$.ajax({
		type: 'POST',
		async: true,
		dataType: 'json',
		url: 'rm-customerratecontractdata.php',
		data: {type, id_specific_price, id_group, ajax: true, bulk_expire, id_employee },
		cache: true,
		success: function(data) {
			if(bulk_expire) {
				if(data != 0 && data.length) {
					for(var i = 0; i < data.length; i++) {
						$("#"+data[i].id_specific_price+"_date").val(data[i].date);
					}
					
					// Uncheck selections after request completed
					checkDelBoxes(false);

					$('#confirmation-modal-expire').modal('hide');

					toast("Products expired successfully", "success");
				}
				else {
					toast("Error occurred while deleting products. Please try again.","success");
				}
			}
			else {
				var date = new Date(data);
				if(date instanceof Date && !isNaN(date.valueOf())) {
					$("#"+id_specific_price+"_date").val(data);
					toast("Product expired successfully","success");	
				}
				else {
					toast("Error occurred while deleting product. Please try again.", "error");
				}
			}
		}	
	});
}

function checkDelBoxes(check) {
	$('.specific-product-checkbox').each(function() {
		$(this).prop('checked', check);
	});
}

function extendContract(id_group, modal_open, type) {
	if(modal_open) {
		$('#confirmation-modal-extend').modal('show');
		return false;
	}

	var id_specific_price = [];
	$('.specific-product-checkbox').each(function() {
		if($(this).is(":checked")) {
			id_specific_price.push($(this).val());
		}
	});

	var current_date = Date.parse(new Date());
	var expiry_date = $('#rate-contract-extend-input').val();
	var selected_date = Date.parse(new Date(expiry_date));

	if((current_date > selected_date) || expiry_date == "") {
		toast("Please select valid expiry date.", "error");
	}
	else if(!id_specific_price.length) {
		toast("Please select atleast one product.", "error");
	}
	else {
		$.ajax({
			type: 'POST',
			async: true,
			dataType: 'json',
			url: 'rm-customerratecontractdata.php',
			data: {type, id_specific_price, id_group, ajax: true, to: expiry_date, id_employee },
			cache: true,
			success: function(data) {
				// Close extend date input popup
				$('#confirmation-modal-extend').modal('hide');
				$('#rate-contract-extend-input').val("");

				// Display if any errors in extending contract
				if(data.length > 0) {
					$('#rate-contract-extend-response').html('');
					for(var i = 0; i < data.length; i++) {
						if(!data[i].success) {
							$('#rate-contract-extend-response').append('<tr>\
								<td>'+data[i].name+' (Ref: '+data[i].reference+')'+'</td>\
								<td>'+data[i].message+'</td>\
							</tr>');
						}
						else {
							$("#"+data[i].id_specific_price+"_date").val(data[i].date);
						}
					}

					if($('#rate-contract-extend-response').html()) {
						$('#modal-extend-response').modal('show');
					}
					else {
						toast('Rate contract extended successfully', 'success');
					}

					// Reset check boxes
					checkDelBoxes(false);
				}				
			}
		});
	}
}