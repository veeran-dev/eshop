<?php /* Smarty version Smarty-3.1.19, created on 2018-02-10 01:03:04
         compiled from "C:\wamp\www\kobsterEshop\cortex\cortex-auth.tpl" */ ?>
<?php /*%%SmartyHeaderCode:222385a7df770ba11e8-44673358%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '02103bed7a23a2cff44d6386b716f18a2e6ff9ce' => 
    array (
      0 => 'C:\\wamp\\www\\kobsterEshop\\cortex\\cortex-auth.tpl',
      1 => 1517921491,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '222385a7df770ba11e8-44673358',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
    'content_dir' => 0,
    'link' => 0,
    'login_error' => 0,
    'cortex_email' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7df770dc9012_73131728',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7df770dc9012_73131728')) {function content_5a7df770dc9012_73131728($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kobster Cortex, A new age admin tool that streamlines internal processes">
    <link rel="shortcut icon" href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>favicon.ico">
    <title>Login | Kobster Cortex</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,600' rel='stylesheet' type='text/css'>
    <link href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>cortex/app/assets/css/login.css" rel="stylesheet">
    <script type="text/javascript">
        window.onload = function(e){
            var url = window.location.href.split("#"); 
            if(url[1] != undefined){
                window.goTo = "#"+url[1];
                document.getElementById("gotoPageAfterLogin").value = window.goTo;
            }
        }
    </script>
    <script type="text/javascript" src="cortex/app/assets/js/cortex-login.js"></script>
</head>

<body>
    <header class="navbar navbar-fixed-top padding10 business-fixed-header">
        <a class="logo" href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>cortex-index.php">
            <img src="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>dash/img/kobster-elite-logo.svg" alt="Kobster Elite"/>
        </a>
        <div class="conatct-info">
            <p>New Here? <a class="request-demo-button" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
elite" target="_blank">Request for Demo</a> Toll Free <a href="tel:18001210405"> 1800-121-0405</a></p>
        </div>
    </header>
    <div class="container">
        <div class="content-wrapper">
            <div class="welcome">
                <h1>NEW & BETTER!</h1>
                <p>The Tool that Transformed Your Life, Now Transformed for Better!</p>
            </div>
            <form id="dash_login_form" class="login-form" method="POST" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getAdminLink('CortexLogin');?>
">
                <?php if (isset($_smarty_tpl->tpl_vars['login_error']->value)==1) {?><p class="errors">The Email or Password you entered is incorrect, please try again.</p><?php }?>
                <div class="form-group-wrapper">
                    <span class="validation-errors" id="error-email"></span>
                    <div class="form-group">
                        <span class="icon email"></span>
                        <input autofocus type="email" id="cortex_email" placeholder="E-mail ID" name="cortex_email" value="<?php if (isset($_smarty_tpl->tpl_vars['cortex_email']->value)) {?><?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cortex_email']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
<?php }?>" class="form-control" required/>
                    </div>
                    <span class="validation-errors" id="error-password"></span>
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input type="password" name="cortex_passwd" id="cortex_passwd" value="" class="form-control" placeholder="Password" required/>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="submitCredential(event);" id="SubmitCortexLogin" name="SubmitCortexLogin" class="login-button">Login</button>
                        <a class="forget-password" href="#" id="modalLink">Forgot Password?</a>
                    </div>
                    <input type="hidden" name="gotoPageAfterLogin" id="gotoPageAfterLogin" value="" />
                </div>
            </form>
        </div>

        <div role="dialog" tabindex="-1" id="forgetPasswordModal" class="modal" style="display: none">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Forgot Password ?</h4>
                        <button type="button" id="closeButton" class="close-button" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="dash-login.php" method="post" id="forgot_password">
                            <p id="resetHint">Enter your E-mail Address below to reset your password.</p>
                            <span class="validation-errors" id="error_span"></span>
                            <div class="form-group" id="forgetPwdForm">
                                <span class="icon email"></span>
                                <input type="text" id="email" name="email" placeholder="Email Address" autocomplete="off" class="form-control placeholder-no-fix">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="dash-forgot-pwd" onclick="forgotPassword(event)" name="dash-forgot-pwd" class="button-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
<script>

var modal = document.getElementById('forgetPasswordModal');
var modalLink = document.getElementById("modalLink");
var startButton = document.getElementById('getStarted');
var closeButton = document.getElementById("closeButton");
var intro = document.getElementById("introContent");

// When the user clicks the link, open the modal
modalLink.onclick = function(e) {
    e.preventDefault();
    modal.style.display = "flex";
    document.getElementById("dash-forgot-pwd").style.display = "inline";
    document.getElementById("resetHint").style.display = "block";
    document.getElementById("error_span").innerHTML = "";
    document.getElementById("email").value = ""
}


// When the user clicks on close button, close the modal
closeButton.onclick = function() {
    modal.style.display = "none";
}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>

</html><?php }} ?>
