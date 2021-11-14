<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}favicon.ico">

    <title>Login | Exclusive Product Upload Portal | kobster.com </title>

    <!--Core CSS -->
    <link href="dash/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="dash/css/bootstrap-reset.css" rel="stylesheet">
    <link href="dash/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="dash/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="catalog/css/app.css">
    <link href="dash/css/style-responsive.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	 <!--Core js-->
    <script src="dash/js/jquery.js"></script>
    <script src="dash/bs3/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="dash/js/jquery.validate.min.js"></script> 
    <script src="catalog/js/catalog-login.js"></script> 
</head>

<body class="login-body">
    	<div class="container">
      <form id="catalog_login_form" class="form-signin cmxform" method="POST" action="{$link->getPageLink('catalog-auth.php')}">
        <h2 class="form-signin-heading"><strong>sign in now</strong></h2>
        <div class="login-wrap">
            <div class="user-login-info form-group">
				{if $login_error == 1}
                    <span class="errors">The Email or Password you entered is incorrect, please try again.</span>
                {elseif $login_error == 7}
                    <span class="errors">You don't have access to this portal</span>
                {/if}
 				<input autofocus type="text" id="catalog_email" placeholder="{if isset($login_error)}Enter Valid E-mail{else} E-mail address {/if}" name="catalog_email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="form-control" />
                <input type="password" name="catalog_passwd" id="catalog_passwd" value="" class="form-control " placeholder="{if isset($login_error)}Enter Valid Password{else}Password {/if}">
            </div>
            <label class="checkbox">
                <!--<input type="checkbox" value="remember-me"> Remember me-->
                <span class="pull-right">
                    <a data-toggle="modal" id="forgot_pwd" href="#myModal"> Forgot Password?</a>
                </span>
            </label>
            <input type="submit" id="SubmitCatalogLogin" name="SubmitCatalogLogin" class="btn btn-lg btn-login btn-block" value="{l s='LOGIN'}" /><br/>
            <div class="registration"> 
                <span class="loginQuery">For Any Queries, Contact to</span>             
                <span style="margin-left:40px;"><a class="loginSupport">support@kobster.com </a>&nbsp;<span class="colorWhite"> or</span>&nbsp; <a class="loginSupport">1800 121 0405</a></span>
            </div>

        </div>

 
      </form>
      <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <form actioin="catalog-auth.php" method="post" id="forgot_password">
                            <p>Enter your E-mail Id below to reset your password.</p>
                            <input type="text" id="email" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                            <span class="error" id="error_span"></span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <input type="button" value="Submit" id="dash-forgot-pwd" onclick="getPassword()" name="dash-forgot-pwd" class="btn btn-success"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>	