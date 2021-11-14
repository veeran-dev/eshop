// For refernce : https://jqueryvalidation.org
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
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10
			},
			 email: {
				required: true,
				email: true
			},
			 seller_type: {
				required: true
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
				required: "Please select City"
			},
			mobile: {
				required: "Please enter Mobile Number",
				number: "Please enter digits only",
				minlength: "Please enter atleast 10 digits.",
				maxlength: "Allowed digits is 10"
			},
			email: {
				required: "Please enter Email address",
				email: "Please enter a valid Email address"
			},
			 seller_type: {
				required: "Please select Seller type"
			}	 
		},

		submitHandler: function(form) {
			$("#submit_sell").hide();
			$("#submit_loading").show();
			var data = $( "#sell_reg_form" ).serialize();
			$.ajax({
				url : 'get_sellerResponse.php',
				data : data,
				type : 'post',
				success : function(data) {
					if (data == 'success'){
						$("#sell_reg_form").html("<div class='success_report'><h4 class='small-title'>Hello "+ $("#seller_name").val() +",</h4><p>Thanks for registering with us as Seller. We appreciate your interest. Our Seller Onboarding team will contact you regarding next steps.</p><p>In the mean time, you can read our blogs at <a href='https://www.kobster.com/blogs'>www.kobster.com/blogs</a> or check us out on social media with the links below.</p></div>");
					}
					else if (data == 'failed'){
						$("#sell_reg_form").html("<div class='failed_report'><h4 class='small-title'>Registration Failed.!</h4><p>Kindly try again later</p></div>");
					}
					
				}
			});
			
		}
		
	});


// Career page form validation	

	$("#career_form").validate({
		 
		rules: {
			fullname: {
				required: true
			},
			email: {
				required: true
			},
			mobile: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10
			},
			department: {
				required: true
			},
            resume: {
                required: true
            }
			 
		},
		messages: {
			fullname: {
				required: "Please enter your Name"
			},
			email: {
				required: "Please enter Email address",
				email: "Please enter a valid Email address"
			},
			mobile: {
				required: "Please enter 10 digit Mobile Number"
			},
			department: {
				required: "Please enter Firm Name"
			},
            resume: {
                required: "Please upload Resume"
            }
				 
		},

		submitHandler: function(form) {
			
			$("#career_submit").hide();
			$("#submit_loading").show();
			
			var form = $('form')[0];
			//var data = $( "#career_form" ).serialize();
			var data =  new FormData(form);
			$.ajax({
				url : 'get_careerResponse.php',
				data : data,
				async: false,
				type : 'POST',
				success : function(result) {
					$(".cta").hide();
					if (result == 'success'){
						$(".career-form").html("<div class='success_report'><h4 class='small-title'>Hi "+ $("#fullname").val() +",</h4><p>Thanks for applying to Kobster. We appreciate your interest. Stay tuned for further updates.</p><p>In the mean time, you can read our blogs at <a href='https://www.kobster.com/blogs'>www.kobster.com/blogs</a> or check us out on social media with the links below.</p>");
					}
					else if (result == 'failed'){
						$(".career-form").html("<div class='failed_report'><h4 class='small-title'>Something went wrong.!</h4><p>Kindly try again later</p></div>");
					}
					
				},
				cache: false,
				contentType: false,
				processData: false
			});
			
		}
		
	});
	
	// File size validation | Developed to work compatible with validate plugin
	$("#resume").change(function(){
		var fileSize = $("#resume")[0].files[0].size; //size in kb | 4000000 kb is 4 Mb
		if (fileSize >  2560000){
			$("#resume").val('');
			if ($("#resume").next().length){
				$("#resume").next().text("File size should be less than 2.5 Mb");
			}
			else {
				$("#resume").after("<label for='resume' class='error'>File size should be less than 2.5 Mb</label>");
			}
		}
		else {
			$("#resume").next().remove();
		}
	});
	
	jQuery.validator.addMethod("lettersonly", function(value, element) 
	{
		return this.optional(element) || /^[a-z," ","."]+$/i.test(value);
	}, "Only alphabets allowed"); 
	
	// Ayudha Pooja page form validation
	$("#ayudha_pooja_form").validate({
		 
		rules: {
			email: {
				required: true,
				email: true
			},
			mobile: {
				required: true,
				number: true
			},
			cust_name: {
				required: true,
				lettersonly: true,
				minlength: 10,
				maxlength: 10
			},
			company_name: {
				required: true
			}
		},
		messages: {
			email: {
				required: "Please enter Email address",
				email: "Please enter a valid Email address"
			},
			mobile: {
				required: "Please enter 10 digit Mobile Number"
			},
			cust_name: {
				required: "Please enter your Name",
			},
			company_name: {
				required: "Please enter your Company Name"
			} 
		},

		submitHandler: function(form) {
			$("#submit_ayudha_pooja").hide();
			$("#submit_loading").show();
			
			var festival = $("#festival").val();
			var festival_name = "Festival";
			if(festival == 1) festival_name = "Ayudha Pooja";
			else if(festival == 2) festival_name = "Diwali";
			
			$(".loading").html("Processing, Please wait...");
			var data = $( "#ayudha_pooja_form" ).serialize();
			$.ajax({
				url : 'get_festivalResponse.php',
				data : data,
				type : 'post',
				success : function(data) {
					if (data == 'success'){
						$("#ayudha_pooja_form").html("<div class='success_report'><h4 class='small-title'>Hi "+ $("#cust_name").val() +",</h4><p>Thank you for your interest on Kobster's "+festival_name+" Sale. Your interest is very valuable to us. Our Team will get back to you shortly.</p><p>Browse more exclusive products at <a href='https://www.kobster.com/'>www.kobster.com</a></p></div>");
						$("#thanks").html("Thank you !");
						$(".loading").hide();
					}
					else if (data == 'failed'){
						$("#ayudha_pooja_form").html("<div class='failed_report'><h4 class='small-title'>Request sending Failed.!</h4><p>Kindly try again later</p></div>");
						$("#thanks").html("Sorry !");
						$(".loading").hide();
					}
					
				}
			});
			
		}
		
	});
	
	// Diary Campaign validation 
	$("#diary_form").validate({
		 
		rules: {
			email: {
				required: true,
				email: true
			},
			mobile: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10
			},
			cust_name: {
				required: true,
				lettersonly: true
			},
			company_name: {
				required: true
			},
			city: {
				required: true,
				lettersonly: true
			}
		},
		messages: {
			email: {
				required: "Please enter Email address",
				email: "Please enter a valid Email address"
			},
			mobile: {
				required: "Please enter 10 digit Mobile Number"
			},
			cust_name: {
				required: "Please enter your Name",
			},
			company_name: {
				required: "Please enter your Company Name"
			},
			city: {
				required: "Please select City"
			} 
		},

		submitHandler: function(form) {
			$("#diary_form").hide();
			$("#submit_loading").show();
			var action = "success";
			
			$(".loading").html("Processing, Please wait...");
			var data = $( "#diary_form" ).serialize();
			$.ajax({
				url : 'get_festivalResponse.php',
				data : data,
				type : 'post',
				success : function(data) {
					alert (data);
					if (data == 'success'){
						$("#diary_form").html("<h3 id='thanks'>Thank you!</h3><div class='success_report'><h4 class='small-title'>Dear "+ $("#cust_name").val() +",</h4><p>Thank you for your interest in Kobster's Diary sale. We are glad that you chose us for your requirement. <br />Our executive will get in touch with you shortly with a quote.</p></div>");
						$(".loading").hide();
						$("#submit_loading").hide();
						$("#diary_form").show();
					}
					else if (data == 'failed'){
						$("#diary_form").html("<h3>Sorry !</h3><div class='failed_report'><h4 class='small-title'>Request sending Failed.!</h4><p>Kindly try again later</p></div>");
						$(".loading").hide();
					}
					
				}
			});
			
		}
		
	});
	
	
	// Elite landing page 
	// Form 1
	
	//$("#elite_lead_form1").load("static/inc/elite_response.php?cust_name=myname");
	
	$("#elite_lead_form1").validate({
		 
		rules: {
			cust_name1: {
				required: true,
			},
			email1: {
				required: true,
				email: true
			},
			company_name1: {
				required: true
			},
			mobile1: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10
			},
			city1: {
				required: true,
			},
			customer_type1: {
				required: true
			}
		},
		messages: {
				 
			cust_name1: {
				required: "Please enter your name",
			},
			email1: {
				required: "Please enter Email address",
				email: "Please enter a valid Email address"
			},
			company_name1: {
				required: "Please enter Company name"
			},
			mobile1: {
				required: "Please enter 10 digit Mobile Number"
			},
			city1: {
				required: "Please select City"
			},
			customer_type1: {
				required: "Please select this field"
			}
		},

		submitHandler: function(form) {
			$("#submit_elite_lead1").hide();
			$("#elite_lead_form1 submit_loading").show();
			
			$("#elite_lead_form1 .loading").html("Processing, Please wait...");
			var data = $( "#elite_lead_form1" ).serialize() + "&form=1";
			$.ajax({
				url : 'get_eliteResponse1.php',
				data : data,
				type : 'post',
				success : function(data) {
					if (data == 'success'){
						$("#elite_lead_form1").load("static/inc/elite_response.php?cust_name="+ $("#cust_name1").val() );
						$("#elite_lead_form1 .loading").hide();
						
					}
					else if (data == 'failed'){
						$("#elite_lead_form1").html("<div class='failed_report'><h4 class='small-title'>Request sending Failed.!</h4><p>Kindly try again later</p></div>");
						$("#elite_lead_form1 .loading").hide();
					}
					
				}
			});
			
		}
		
	});
/*							$("#elite_lead_form1").html("<div class='success_report'><h4 class='small-title'>Hello "+ $("#cust_name1").val() +",</h4><p>Thank you for your interest with Kobster Elite. Our Elite Onboarding team will contact you regarding next steps.</p><p>In the mean time, you can read our blogs at <a href='https://www.kobster.com/blogs'>www.kobster.com/blogs</a> or check us out on social media with the links below.</p><br /><div></div></div>");*/
	// Form 2
	$("#elite_lead_form2").validate({
		 
		rules: {
			cust_name2: {
				required: true,
				lettersonly: true
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
				number: true,
				minlength:10,
				maxlength:10
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
				required: "Please enter a valid Mobile Number",
				minlength: "Minimum 10 Digits are Required",
				maxlength: "Maximum 10 Digits only allowed"
			},
			city2: {
				required: "Please select City"
			},
			customer_type2: {
				required: "Please select this field"
			}
		},

		submitHandler: function(form) {
			$("#submit_elite_lead2").hide();
			$("#elite_lead_form2 submit_loading").show();
			
			$("#elite_lead_form2 .loading").html("Processing, Please wait...");
			var data = $( "#elite_lead_form2" ).serialize() + "&form=2";
			$.ajax({
				url : 'get_eliteResponse2.php',
				data : data,
				type : 'post',
				success : function(data) {
					if (data == 'success'){
						//$("#elite_lead_form2").load("static/inc/elite_response.php?cust_name="+ $("#cust_name2").val() );
						$("#elite_lead_form2 .loading").hide();
						$("#elite_lead_form2").html("<div class='success_report'><h4 class='small-title'>Success!</h4><p>Your request has been successfully submitted. We will contact you shortly.</p></div>");
					}
					else if (data == 'failed'){
						$("#elite_lead_form2").html("<div class='failed_report'><h4 class='small-title'>Request sending Failed.!</h4><p>Kindly try again later</p></div>");
						$("#elite_lead_form2 .loading").hide();
					}
					
				}
			});
			
		}
		
	});
	
	

 }); // end of document ready

