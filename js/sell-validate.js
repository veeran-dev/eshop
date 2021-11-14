$(document).ready(function(){

	// validate signup form on keyup and submit
	$("#sell_reg_form").validate({
		 
		rules: {
			seller_name: {
				required: true
			},
			firm_name: {
				required: true
			},
			city: {
				required: true
			},
			mobile: {
				required: true
			},
			 email: {
				required: true,
				email: true
			}
		},
		messages: {
			seller_name: {
				required: "Please enter your Name"
			},
			firm_name: {
				required: "Please enter Firm Name"
			},
			city: {
				required: "Please enter City Name"
			},
			mobile: {
				required: "Please enter Mobile Number"
			},
			email: {
				required: "Please enter Email address",
				email: "Please enter a valid Email address"
			}	 
		},

		submitHandler: function(form) {
			var data = $( "#sell_reg_form" ).serialize();
			$.ajax({
				url : 'get_sellerResponse.php',
				data : data,
				type : 'post',
				success : function(data) {
					alert(data);
					if (data == 'success'){
						$("#sell_reg_form").append("<div class='success_report'><h4 class='small-title'>Registered Successfully.!</h4><p>Kindly check your Email</p></div>");
					}
					else if (data == 'failed'){
						$("#sell_reg_form").append("<div class='failed_report'><h4 class='small-title'>Registration Failed.!</h4><p>Kindly try again later</p></div>");
					}
					
				}
			});
			
		}
		
	});

 });

