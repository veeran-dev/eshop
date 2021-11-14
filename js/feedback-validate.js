// For refernce : https://jqueryvalidation.org
$(document).ready(function(){
	
	
	$("#feedback_message").focus();

	 
	$("#feedback-form").validate({
		 
		rules: {
			message: {
				required: true
			}
		},
		messages: {
			message: {
				required: "Kindly fill your query"
			}
		},

		submitHandler: function(form) {
			$("#feedback-form").hide();
			$("#submit_loading").show();
			var action = "success";
			
			$(".loading").html("Processing, Please wait...");
			var data = $( "#feedback-form" ).serialize();
			$.ajax({
				url : 'get_feedbackResponse.php',
				data : data,
				type : 'post',
				success : function(data) {
					if (data == 1){
						$("#feedback-form").replaceWith("<h3>Feedback submitted Successfully !</h3>");
						$(".loading").hide();
						
						$("#submit_loading").hide();
						$("#feedback-form").show();
					}
					else if (data == 2){
						$("#feedback-form").replaceWith("<h3>Feedback sending Failed.! Kindly try again later</h3>");
						$(".loading").hide();
					}
					
				}
			});
			
		}
		
	});
	
	

	// Added manually for letteronly function
	jQuery.validator.addMethod("lettersonly", function(value, element) 
	{
		return this.optional(element) || /^[a-z," ","."]+$/i.test(value);
	}, "Only alphabets allowed"); 
	

 });

