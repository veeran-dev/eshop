	 function submitMyProfile()
	{
 		$('#error').html('');
		var error=0;
		var old_passwd=$('#old_passwd').val();
		var passwd = $('#passwd').val();
		var confirmPassword = $('#confirmPassword').val();
		
		if(old_passwd =="")  
		{
			$('#old_passwd').val('');
			$('#old_passwd').attr("placeholder",'please enter current password');
 			error=1;
 		}
		if(passwd =="")  
		{
			$('#passwd').attr("placeholder",'please enter New Password');
 			error=1;
 		}
		if(confirmPassword =="")  
		{
			$('#confirmPassword').val('');
			$('#confirmPassword').attr("placeholder",'please enter Confirmation password');
 			error=1;
 		}
		if(error ==1)
			return false;
		if(passwd!=confirmPassword)
		{
			$('#confirmPassword').val('');
			$('#passwd').val('');
			$('#confirmPassword').attr("placeholder",'Confirmation password Mismatch');
			$('.confirmation').addClass('has-error');
 			error=1;
			return false;
 		}
		if(confirmPassword !="" && passwd!="")
		{
			if(old_passwd == confirmPassword || old_passwd == passwd)
			{
				$('#confirmPassword').val('');
				$('#passwd').val('');
				$('#passwd').attr("placeholder",'New password Same as Current password');
				$('#confirmPassword').attr("placeholder",'New password Same as Current password');
				$('.confirmation').addClass('has-error');
				error=1;
			}
		}
		
 		if(error!=0)
		{
  			return false;
		}
		else
		{
			var dataparam ='&old_passwd=' + old_passwd+'&passwd=' + passwd+'&confirmPassword=' + confirmPassword;
 			  $.ajax({
						type: 'POST',
 						async: true,
						url: 'dash-identity.php',
						data: dataparam,
						cache: true,
						success: function(data)
						{
 							if(data==1)
							{
								$('#old_passwd').val('');
 								$('#old_passwd').attr("placeholder",'Current password mismatch');
								return false;
							}
							if(data==2)
								msg="Password and confirmation do not match.";
							if(data==3)
							{
								msg="<strong><label style='color:green'>Successfully Updated.</label></strong>";
								$('#confirmPassword').val('');
								$('#passwd').val('');
								$('#myProfile').modal('hide');
								$("#idGlobalAlert").html("Password Updated Successfully");
								$('#globalAlert').modal('show');
								setTimeout(function() {
									  $('#globalAlert').modal('hide');
								}, 2000);
							}
							if(data==4)
								msg="Cannot update information.";	
							
							$('#error').html(msg);
						}
			});
		}
	}
	
	