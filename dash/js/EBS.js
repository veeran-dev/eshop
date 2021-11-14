// JavaScript Document

$(document).ready(function()
{
   	$.ajax({
			type: 'POST',
			url: 'dash-EBSdata.php',
			async: true,
			cache: false,
			dataType : "json",
			data:{orderid:creater_order_no,type:creater_order_approver},
			success: function(data)
			{
				$("#EBS_form").attr("action", data.EBSUrl)
				$('#account_id').val(data.account_id);
				$('#reference_no').val(data.cartID);
				$('#amount').val(data.total);
				$('#description').val("Test Order Description");
				$('#name').val(data.address.firstname);
				$('#address').val(data.address.address1);
				$('#city').val(data.address.city);
				$('#state').val(data.state);
				$('#postal_code').val(data.address.postcode);
				$('#country').val(data.country.iso_code);
				$('#email').val(data.customer.email);
				$('#phone').val(data.address.phone_mobile);
				$('#ship_name').val(data.address.firstname);
				$('#ship_address').val(data.address.address1);
				$('#ship_city').val(data.address.city);
				$('#ship_state').val(data.state);
				$('#ship_postal_code').val(data.address.postcode);
				$('#ship_country').val(data.country.iso_code);
				$('#ship_phone').val(data.address.phone_mobile);
				$('#return_url').val(data.return_url);
				$('#mode').val(data.mode);
				$('#secure_hash').val(data.secure_hash);
				$('#EBS_form').submit();
			}
	});
});