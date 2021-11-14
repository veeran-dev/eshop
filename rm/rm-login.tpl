<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="/favicon.ico">
 
    <title>Login | Relationship Manger Portal | kobster.com </title>

    <!--Core CSS -->
    <link href="dash/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="dash/css/bootstrap-reset.css" rel="stylesheet">
    <link href="dash/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="dash/css/style.css" rel="stylesheet">
    <link href="dash/css/style-responsive.css" rel="stylesheet" />
	 <!--Core js-->
    <script src="dash/js/jquery.js"></script>
    <script src="dash/bs3/js/bootstrap.min.js"></script>
	<script src="dash/js/dash-login.js"></script> 
	<script type="text/javascript" src="dash/js/jquery.validate.min.js"></script> 
</head>

<body class="login-body rmBody">
    	<div class="container">

      <form id="RM_login_form" class="form-signin cmxform noBackground" method="POST" action="{$link->getPageLink('rm-login.php')}">
        <h2 class="form-signin-heading fontStyle"><strong>sign in now</strong></h2>
        <div class="help-text">
            {if isset($login_error)}
                {if $login_error == 1}
                    <div class="RMerrors text-center">The Email or Password you entered is incorrect, please try again.</div>
                {elseif $login_error == 2}
                    <div class="RMerrors text-center">You don't have an access this portal.</div>
                {elseif $login_error == 3}
                    <div class="RMerrors text-center">Please logout from portal that you have already logged in and then try again.</div>
                {/if}
            {/if}
        </div>
        <div class="login-wrap noBackground">
            <div class="form-group noBackground">
 				<input autofocus type="text" id="RM_email" placeholder="{if isset($login_error)}Enter Valid E-mail{else} E-mail address {/if}" name="RM_email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="form-control" />
                <input type="password" name="RM_passwd" id="RM_passwd" value="" class="form-control " placeholder="{if isset($login_error)}Enter Valid Password{else}Password {/if}"> 
            </div>
            <div class="form-group">
                <input type="submit" id="SubmitRMLogin" name="SubmitRMLogin" class="btn btn-primary RMLoginButton" value="{l s='LOGIN'}" />
            </div>
            <!--<div class="registration"> 
                <span class="loginQuery">For Any Queries, Contact to</span>
                  
                <span style="margin-left:40px;"><a class="">support@kobster.com </a>&nbsp;<span class="colorWhite"> or</span>&nbsp; <a class="">1800 121 0405</a></span>
            </div>-->

        </div>

          

      </form>

    </div>
</body>
</html>	
<script type="text/javascript">
var Script = function () {
	$().ready(function() {

			// validate signup form on keyup and submit
			$("#RM_login_form").validate({
				 
				rules: {
					 RM_passwd: {
						required: true,
						minlength: 5
						//digits:true
					},
					 RM_email: {
						required: true,
						email: true
					}
				},
				messages: {
					 RM_passwd: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						digits:"digits only"
					},
					 RM_email: "Please enter a valid email address",
					 
				}
			});
		});
 }();
</script>
    <!-- Placed js at the end of the document so the pages load faster -->

   
  
