// Perks Authentication Page form Validation
$(document).ready(function() {

    
    // Login Form
    $('#loginForm').validate({
        rules: {                   
            email: {
                required: true,
                email: true
            },
            passwd: "required"
        },
        errorElement: "span" ,                              
        messages: {
            email: "Please enter valid email address",
            passwd: "Please enter valid password"
        },
        submitHandler: function(form) {
            var dataparam = $('#loginForm').serialize();

            $.ajax({
                type: 'POST',
                async: true,
                url: 'perks-register.php',
                data: dataparam,
                datatype: 'json',
                cache: true,
                global: false,
                beforeSend: function() { 
                    $('.inline-loading.login').show();
                },
                success: function(data) {
                    if(data == 'success'){
                        window.location.href = baseDir+"index.php?controller=perksDeals";
                    } else {
                        $('.no-config').show();
                    }

                },
                complete: function() { 
                    $('.inline-loading.login').hide();
                }
            });
        }                
    });

    // Password Reset Form
    $('#passwordResetForm').validate({
        rules: {                   
            email: {
                required: true,
                email: true
            },
        },
        errorElement: "span" ,                              
        messages: {
            email: "Please enter valid email address",
        },
        submitHandler: function(form) {
            var dataparam = $('#passwordResetForm').serialize();

            $.ajax({
                type: 'POST',
                async: true,
                url: 'perks-register.php',
                data: dataparam,
                datatype: 'json',
                cache: true,
                global: false,
                beforeSend: function() { 
                    $('.inline-loading.forgot-passwd').show();
                },
                success: function(data)
                {
                    $('#passResetInfo').show().html(data);
                },
                complete: function() { 
                    $('.inline-loading.forgot-passwd').hide();
                }
            });
        }                
    });
    
	jQuery.validator.addMethod("validate_email", function(value, element) {
		if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
			return true;
		} else {
			return false;
		}
	}, "Please enter a valid Email.");

    // Register Form
    $('#account-creation_form').validate({
        rules: {
            firstname: "required",
            phone_mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },                  
            email: {
                required: true,
                email: true,
                validate_email: true
            },
            passwd1 :{
                required: true,
                minlength: 5
            },
            passwd2 : {
                required: true,
                equalTo : "#passwd1"
            }
        },
        errorElement: "span" ,                              
        messages: {
            firstname: "Please enter your sweet name",
            phone_mobile: {
				required: "Please enter a valid mobile number",
				minlength: "Minimum 10 digits are required",
				maxlength: "Maximum 10 digits only allowed"
			},
            email: "Please enter your official email address",
            passwd1: "Minimum 5 Characters",
            passwd2: "Password doesn't match"
        },
        submitHandler: function(form) {
            var dataparam = $('#account-creation_form').serialize();
            $.ajax({
                type: 'POST',
                async: true,
                url: 'perks-register.php',
                data: dataparam,
                datatype: 'json',
                cache: true,
                global: false,
                beforeSend: function() { 
                    $('.inline-loading.register').show();
                },
                success: function(data) 
                {
                    var result = JSON.parse(data);

                    if(result.error){
                        $('#registerErr').html(result.error).show();
                        $(function() {
                            setTimeout(function() {
                                $("#registerErr").hide()
                            }, 8000);
                        });
                    }
                    else{
                        $('#registerOk').html(result.success).show();
                        $('#registerInfo')
                            .html("<p>If you do not receive the confirmation message within a few minutes of signing up, please check your Spam E-mail folder.</p><p>Or you can resend the email by <a href='"+baseDir+"index.php?controller=perks&resendPassword="+result.id_customer+"'>clicking here!</a>.</p>")
                            .show();
                        $('#account-creation_form').trigger("reset");
                        grecaptcha.reset();
                    }
                },
                complete: function() { 
                    $('.inline-loading.register').hide();
                }
            });
        }                
    });

    // Request for Explore
    $('#requestForExplore').validate({
        rules: {
            cust_name2: {
                required: true
            },
            email2: {
                required: true,
                email: true
            },
            company_name2: {
                required: true
            },
            mobile2: {
                required: true,
                number: true
            },
            city2: {
                required: true,
            },
            customer_type2: {
                required: true
            }
        },
        messages: {
                 
            cust_name2: {
                required: "Please enter your name",
            },
            email2: {
                required: "Please enter Email address",
                email: "Please enter a valid Email address"
            },
            company_name2: {
                required: "Please enter Company name"
            },
            mobile2: {
                required: "Please enter Mobile Number"
            },
            city2: {
                required: "Please select City"
            },
            customer_type2: {
                required: "Please select this field"
            }
        },
        submitHandler: function(form) {
            var dataparam = $('#requestForExplore').serialize() + "&form=3";

            $.ajax({
                type: 'POST',
                async: true,
                url: 'get_eliteResponse1.php',
                data: dataparam,
                cache: true,
                success: function(data) 
                {
                    $('.success_report').show();
                    $('.hero-sign-up').hide();
                }
            });
            return false;
        }                
    });
});