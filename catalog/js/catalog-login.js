$(document).ready(function(){
	$("#catalog_login_form").validate({			 
		rules: {
			 catalog_passwd: {
				required: true,
				minlength: 5
				//digits:true
			},
			 catalog_email: {
				required: true,
				email: true
			}
		},
		messages: {
			 catalog_passwd: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long",
				digits:"Please enter digits only"
			},
			catalog_email: "Please enter a valid email address"
		}
	});
});