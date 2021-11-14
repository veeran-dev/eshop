	var dictionary  = new Typo("en_US");
	document.title = 'Kobster Edge The Most Effective Way To Shop!';
		function searchPro()
		{
			$('#errorWord').hide();
			var searchword = $("#searchProductvalue").val();
 			var result = searchword.split(" ");
 			var checkWord=0;
			for(var i=0; i<result.length;i++)
			{
 				var is_correct_spelling = dictionary.check(result[i]);
				if(is_correct_spelling == true)
				{
					
					checkWord++;
				}
			}
  			if(checkWord != 0)
			{
				/*alert("success");*/
				$('#searchProduct').hide();
 				$('#searchPincode, .successSearch').show();
			}
			else{
				/*alert("fail");*/
				$('#errorWord').show();
				return false;
			}
 		}
		function filterPincode()
		{
			$('#errorpincode').html('');
			var pincode=$('#pincode').val();
			var type=1;
			var dataparam='&pincode='+pincode;
			$.ajax({
				type: 'POST',
				dataType:'json',
				data:dataparam,
				async: true,
 				url: 'edgepincode.php',
 				cache: false,
				success: function(data)
				{
 					if(data['status']=="SUCCESS")
					{
						$('#searchPincode').hide();
						$('#personaldetail').show();
					}
					else
					{
						$('#errorpincode').html("Please Enter a valid pincode");
						return false;
					}
				}
			});
 			
		}
		function savePersonalDetails()
		{
			var name=$('#name').val();
			var email=$('#email').val();
			var phone=$('#phone').val();
			$('#errorname').html('');
			$('#errorphone').html('');
			$('#erroremail').html('');
			var status=0;
			if(name == "")
			{
				$('#errorname').html("Please Enter Name");
				status=1;
			}
 			if(name!="")
			{
				if(!name.match(/^[a-zA-Z ]*$/))
				{
					$('#errorname').html('Please enter a valid Name');
					 status=1;
				}
			}
			if(phone=="")
			{
				$('#errorphone').html('Please enter your Mobile Number');
				status=1;
			}
			if(phone!="")
			{
				if(!phone.match(/^[0-9]+$/))
				{
					$('#errorphone').html('Only numbers allowed');
					status=1;
				}
			}
			if(phone!="")
			{
				if(phone.length<10)
				{
					$('#errorphone').html('Mobile number should be of 10 digits');
					status=1;
				}
			}
			if(email=="")
			{
				$('#erroremail').html('Enter your Mail-id');
				status=1;
			}
			  
 			 if(status == 0)
			 {
				$('#personaldetail').hide();
				$('#optionalFields').show();
			 }
			 else
			 {
 				return false;
			 }
			
 		}
		function saveOptional()
		{
				$('#optionalFields').hide();
				$('#thankyou').show();
		}
		function thankYou()
		{
			$('#searchProductvalue').val('');
			$('#pincode').val('');
			$('#quantity').val('');
			$('#phone').val('');
			$('#name').val('');
			$('#email').val('');
			$('#description').val('');
			$('#thankyou').hide();
			
			$('#searchProduct').show();
		}
		