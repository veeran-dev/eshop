<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="/favicon.ico">

    <title>Login | Supply Chain Portal | kobster.com </title>

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
<!-- New Design-->
<body class="login-body scnBody">
    	<div class="container position-center">
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
            <form id="scn_login_form" class="form-inline" method="POST" action="{$link->getPageLink('scn-login.php')}">
                 <div class="form-group">
            			<input autofocus type="text" id="scn_email" placeholder="{if isset($login_error)}Enter Valid E-mail{else} E-mail address {/if}" name="scn_email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="form-control" />
                    <input type="password" name="scn_passwd" id="scn_passwd" value="" class="form-control " placeholder="{if isset($login_error)}Enter Valid Password{else}Password {/if}">
            		<input type="submit" id="SubmitScnLogin" name="SubmitScnLogin" class="btn btn-success " value="{l s='LOGIN'}" /><br/>
                </div>
            </form>
    </div>
</body>
<!--Old design -->
<!--<body class="login-body">
    	<div class="container">
       <form id="scn_login_form" class="form-signin cmxform" method="POST" action="{$link->getPageLink('scn-login.php')}">
        <h2 class="form-signin-heading"><strong>sign in now</strong></h2>
        <div class="login-wrap">
            <div class="user-login-info form-group">
				{if isset($login_error) == 1}<span class="errors">The Email or Password you entered is incorrect, please try again.</span>{/if}
 				<input autofocus type="text" id="scn_email" placeholder="{if isset($login_error)}Enter Valid E-mail{else} E-mail address {/if}" name="scn_email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="form-control" />
                <input type="password" name="scn_passwd" id="scn_passwd" value="" class="form-control " placeholder="{if isset($login_error)}Enter Valid Password{else}Password {/if}">
             </div>
              <input type="submit" id="SubmitScnLogin" name="SubmitScnLogin" class="btn btn-lg btn-login btn-block" value="{l s='LOGIN'}" />
         </div>
       </form>
     </div>
</body>-->
</html>	
<script type="text/javascript">
var Script = function () {
	$().ready(function() {

			// validate signup form on keyup and submit
			$("#scn_login_form").validate({
				 
				rules: {
					 scn_passwd: {
						required: true,
						minlength: 5
						//digits:true
					},
					 scn_email: {
						required: true,
						email: true
					}
				},
				messages: {
					 scn_passwd: {
						required: "Please provide a password",
						minlength: "Your password must be at least 5 characters long",
						digits:"digits only"
					},
					 scn_email: "Please enter a valid email address",
					 
				}
			});
		});
 }();
</script>
    <!-- Placed js at the end of the document so the pages load faster -->

   
  
