<?php /* Smarty version Smarty-3.1.19, created on 2019-10-28 15:58:58
         compiled from "rm\rm-login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:268815db6c2ea5d6910-89927127%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1341e0dfae7d47bfe68b29afa67e7e065d3786f8' => 
    array (
      0 => 'rm\\rm-login.tpl',
      1 => 1508851672,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '268815db6c2ea5d6910-89927127',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'login_error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5db6c2ea719010_72146507',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db6c2ea719010_72146507')) {function content_5db6c2ea719010_72146507($_smarty_tpl) {?><!DOCTYPE html>
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

      <form id="RM_login_form" class="form-signin cmxform noBackground" method="POST" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('rm-login.php');?>
">
        <h2 class="form-signin-heading fontStyle"><strong>sign in now</strong></h2>
        <div class="help-text">
            <?php if (isset($_smarty_tpl->tpl_vars['login_error']->value)) {?>
                <?php if ($_smarty_tpl->tpl_vars['login_error']->value==1) {?>
                    <div class="RMerrors text-center">The Email or Password you entered is incorrect, please try again.</div>
                <?php } elseif ($_smarty_tpl->tpl_vars['login_error']->value==2) {?>
                    <div class="RMerrors text-center">You don't have an access this portal.</div>
                <?php } elseif ($_smarty_tpl->tpl_vars['login_error']->value==3) {?>
                    <div class="RMerrors text-center">Please logout from portal that you have already logged in and then try again.</div>
                <?php }?>
            <?php }?>
        </div>
        <div class="login-wrap noBackground">
            <div class="form-group noBackground">
 				<input autofocus type="text" id="RM_email" placeholder="<?php if (isset($_smarty_tpl->tpl_vars['login_error']->value)) {?>Enter Valid E-mail<?php } else { ?> E-mail address <?php }?>" name="RM_email" value="<?php if (isset($_POST['email'])) {?><?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
<?php }?>" class="form-control" />
                <input type="password" name="RM_passwd" id="RM_passwd" value="" class="form-control " placeholder="<?php if (isset($_smarty_tpl->tpl_vars['login_error']->value)) {?>Enter Valid Password<?php } else { ?>Password <?php }?>"> 
            </div>
            <div class="form-group">
                <input type="submit" id="SubmitRMLogin" name="SubmitRMLogin" class="btn btn-primary RMLoginButton" value="<?php echo smartyTranslate(array('s'=>'LOGIN'),$_smarty_tpl);?>
" />
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

   
  
<?php }} ?>
