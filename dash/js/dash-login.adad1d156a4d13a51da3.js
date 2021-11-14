const validationConfigs = {
  form: "dash_register_form",
  rules: {
        corporate_name: { required: true },
        corporate_email: { required: true, email: true },
        corporate_pwd: { required: true, password:true },
        corporate_pwd_cnfm: { required: true, confirmPassword: true },
        corporate_address: { required: true, isAddress: true },
        corporate_mobile: { required: true, mobile: true },
        corporate_city: { required: true, string: true, maxlength: 36 },
        corporate_state: { required: true, state: true},
        corporate_country: { required: true},
        corporate_pincode: { required: true, pincode: true },
        corporate_gst: { required: true, gst: true },
        corporate_contact_name: { required: true, string: true },
        corporate_contact_mobile: { required: true, mobile: true },
    },

    messages: {
        corporate_name: {
            required: "Please provide your corporate name."
        },
        corporate_email: {
            required: "Please provide your email.",
            email: "Please enter valid email id"
        },
        corporate_pwd: {
            required: "Please enter your password.",
            password: "password should have minimum of 8 characters"
        },
        corporate_pwd_cnfm:{
        	required: "Please enter confirm password.",
            confirmPassword: "Confirm Password is not same as password"
        },
        corporate_address: {
            required: "Please enter your corporate's address",
            isAddress: "Please avoid special characters",
        },
        corporate_mobile:{
            required: "Please provide mobile number.",
            mobile: "Please provide valid mobile number.",
        },
        corporate_city:{
            required: "Please provide city.",
            string: "Please enter valid city name",
            maxlength: "Please check character limits exceeds"
        },
        corporate_state:{
            required: "Please provide state",
            state: "Please provide state",
        },
        corporate_country:{
            required: "Please provide Country"
        },
        corporate_pincode:{
            required: "Please provide pincode",
            pincode: "Please provide valid pincode"
        },
        corporate_gst:{
            required: "Please provide GST",
            gst: "Please provide valid GST"
        },
        corporate_contact_name: {
            required: "Please provide contact person name.",
            string: "Please provide alphabets only."
        },
        corporate_contact_mobile:{
            required: "Please provide mobile number.",
            mobile: "Please provide valid mobile number.",
        },
    }
}

function isValid(){
	const { errors, isValid } = validateQuoteForm(validationConfigs);
	document.getElementsByClassName("validation-errors").innerHTML = "";
	for (let key in errors){
		var element = document.getElementById("error_"+key).innerHTML = errors[key]
	}
	return isValid;
}

function submitRegister(event){
	event.preventDefault();
	if (this.isValid()){
		var corporate_name = document.getElementById('corporate_name').value;
		var corporate_email = document.getElementById('corporate_email').value;
		var corporate_pwd = document.getElementById('corporate_pwd').value;
		var corporate_address = document.getElementById('corporate_address').value;
		var corporate_mobile = document.getElementById('corporate_mobile').value;
		var corporate_city = document.getElementById('corporate_city').value;
		var corporate_state = document.getElementById('corporate_state').value;
		var corporate_country = document.getElementById('corporate_country').value;
		var corporate_pincode = document.getElementById('corporate_pincode').value;
		var corporate_gst = document.getElementById('corporate_gst').value;
		var corporate_contact_name = document.getElementById('corporate_contact_name').value;
		var corporate_contact_mobile = document.getElementById('corporate_contact_mobile').value;

		document.getElementById("reg_load").style.display = "flex";
		var corporate_sez = document.getElementById('corporate_sez').checked == true ? 1 : 0;
	    var form = document.getElementById('dash_register_form');
		var params ="ajax=true?&corporate_sez="+corporate_sez+"&corporate_name="+corporate_name+"&corporate_email="+corporate_email+"&corporate_pwd="+corporate_pwd+"&corporate_address="+corporate_address+"&corporate_mobile="+corporate_mobile+"&corporate_city="+corporate_city+"&corporate_state="+corporate_state+"&corporate_country="+corporate_country+"&corporate_pincode="+corporate_pincode+"&corporate_gst="+corporate_gst+"&corporate_contact_name="+corporate_contact_name+"&corporate_contact_mobile="+corporate_contact_mobile+"&SubmitDashRegister=1";
		var http = new XMLHttpRequest();
		var url = "dash-login.php";
		http.open("POST", url, true);
		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// http.setRequestHeader("Content-length", params.length);
		// http.setRequestHeader("Connection", "close");

		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
				var response = JSON.parse(http.response);
				document.getElementById("reg_load").style.display = "none";
				if(response.error != undefined){
					document.getElementById('error_corporate_email').innerHTML = response.error;
				}
				else{
					window.location.reload();
				}
			}
		}
		http.send(params);
	}

}

function submitCredential(e) {
	var email = document.getElementsByName("login_email")[0].value;
	var password = document.getElementsByName("login_passwd")[0].value;
	var errors = {};
	
	if(email != "") {
		if(!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
        	errors["login-email"] = "Enter Valid E-mail.";
		}
	}
	else if(email == "") {
		errors["login-email"] = "Please Enter E-mail.";
	}

	if(password == "") {
		errors["login-passwd"] = "Please Enter Password.";
	}

	if(password && password.length < 5) {
		errors["login-passwd"] = "Password should be atleast 5 charaters long.";
	}

	document.getElementById("error-email").innerHTML = (errors["login-email"] != undefined ? errors["login-email"] : "");
	document.getElementById("error-password").innerHTML = (errors["login-passwd"] != undefined ? errors["login-passwd"] : "");

	if(Object.keys(errors).length > 0) {
		e.preventDefault();
	}
}

function forgotPassword(e) {
	e.preventDefault();
	var email = document.getElementById("email").value;
	var error = "";
	
	if(email != "") {
		if(!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)){
        	error = "Enter Valid E-mail.";
		}
	}
	else if(email == "") {
		error = "Please Enter E-mail.";
	}

	document.getElementById("error_span").innerHTML = error;

	if(error == "") {
	    document.getElementById("load_gif").style.display = "inline";
	    document.getElementById("dash-forgot-pwd").style.display = "none";
		var http = new XMLHttpRequest();
		var url = "dash-login.php";
		var params = "ajax=true&email="+email;
		http.open("POST", url, true);
		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.setRequestHeader("Content-length", params.length);
		http.setRequestHeader("Connection", "close");

		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
				if(http.responseText != 0 && http.responseText != 1) {
				    document.getElementById("load_gif").style.display = "none";
				    document.getElementById("dash-forgot-pwd").style.display = "inline";
					if(http.responseText == 2) {
						document.getElementById("error_span").innerHTML = "Invalid E-mail Id";
					}
					else if(http.responseText == 3) {
						document.getElementById("error_span").innerHTML = "There is no account registered to this E-mail ID.";
					}
					else if(http.responseText == 4) {
						document.getElementById("error_span").innerHTML = "You can regenerate your password once every 360 minutes.";
					}
					else if(http.responseText == 5) {
						var modal = document.getElementById('forgetPasswordModal');
						modal.style.display = "none";
						var modalResponse = document.getElementById('forgetPasswordResponseModal');
						modalResponse.style.display = "flex";
						// document.getElementById("error_span").innerHTML = "A link to reset your password has been sent to your email. Kindly follow the instructions given in the mail. Thank you.";
						// document.getElementById("forgetPwdForm").style.display = "none";
						// document.getElementById("dash-forgot-pwd").style.display = "none";
    					// document.getElementById("resetHint").style.display = "none";
					}
					else if(http.responseText == 6) {
						document.getElementById("error_span").innerHTML = "Error occurred when sending the E-mail.";
					}
					else if(http.responseText == 7) {
						document.getElementById("error_span").innerHTML = "An error occurred with your account and your new password cannot be sent to your e-mail. Please report your problem using the contact form.";
					}
				}
			}
		}

		http.send(params);
	}
	else {
		e.preventDefault();
	}
}

function validateQuoteForm(config) {
  let validForm = document.getElementById(config.form), errors = {}
  if(validForm != null && validForm.tagName == 'FORM'){
    let rules = config.rules, messages = config.messages
    if(rules == undefined){
      errors.global = "Validation rule is not defined"
    }
    else{
	    for(var key in rules){
	      let data = document.getElementById(key).value
	      document.getElementById("error_"+key).innerHTML = "";
	      // Validating field is required
	      if(data.trim() == "")
	        errors[key] = messages[key].required
	      // Validating field is numeric and is negative number
	      if(rules[key].numeric){
	        if(data.length > 0 && !data.match(/^[0-9]+$/))
	          errors[key] = messages[key].numeric
	        if(data && data == 0)
	          errors[key] = "Number should be greater than zero."
	        if(data && data < 0)
	          errors[key] = "Negative numbers not allowed."
	      }
	      if(rules[key].state){
	      		if(data == 0){
	      			errors[key] = messages[key].state	
	      		}
	      }
	      //validation Address
	      if(rules[key].isAddress){
	          if(data.match(/[!@#$%^&*_+\=\[\]{};':"\\|<>\?]+/)){
	            errors[key] = messages[key].isAddress
	          }
	      }
	      // Validating GST          
	      if(rules[key].isGst){
	        let re ='\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}';
	        if(!data.match(/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}/)){
	          	errors[key] = messages[key].isGst
	        }
	      }
	      // Validating maximun of input size
	      if(rules[key].maxlength){
	        if(data.length > 0 && data.match(/^[0-9]+$/) && (data.length !== rules[key].maxlength.length))
	          errors[key] = messages[key].maxlength
	      }
	      if(rules[key].email){
	        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	        if(!re.test(data))
	          errors[key] = messages[key].email
	      }
	      
	      // Validating mobile number
	      if(rules[key].mobile){
	        if(!data.match(/^\d{10}$/))
	          errors[key] = messages[key].mobile
	      }
	      // Validate pincode
	      if(rules[key].pincode){
	        var regex=/^\d{6}$/;
	        if(!regex.test(data)){
	          errors[key] = messages[key].pincode
	        }
	      }
	      // String validation
	      if(rules[key].string) {
	        var regex = /^[a-zA-Z '.]*$/;
	        if(!regex.test(data))
	          errors[key] = messages[key].string
	      }
	      if(rules[key].gst){
	        var regex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
	        if(!regex.test(data)){
	          errors[key] = messages[key].gst   
	        }
	      }
	      // if(rules[key].password) {
	      //   var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
	      //   if(!regex.test(data)){
	      //     errors[key] = messages[key].password
	      //   }
	      // }
	      
  	      if(rules[key].password){
	      	if(data.length < 8){
	      		errors[key] = messages[key].password
	      	}
	      }
	      if(rules[key].confirmPassword) {
	        var password = document.getElementById('corporate_pwd').value;
	        if(password !== data){
	          errors[key] = messages[key].confirmPassword
	        }
	      }
	    }
    }

    if(messages == undefined){
      errors.global = "Validation messages not specified."
    }
  }
  else{
    errors.global = "Invalid form element is supplied."
  }

  return {
    errors,
    isValid: JSON.stringify(errors) === '{}'
  }
}