<?php /* Smarty version Smarty-3.1.19, created on 2019-08-03 15:08:16
         compiled from "C:\wamp64\www\kobsterEshop\cortex\cortex-auth.tpl" */ ?>
<?php /*%%SmartyHeaderCode:67915d455608692513-05679984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '880674d6e5d7782de05bc4219037af370ec7b03f' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\cortex\\cortex-auth.tpl',
      1 => 1554533918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67915d455608692513-05679984',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d4556089aa397_30982963',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d4556089aa397_30982963')) {function content_5d4556089aa397_30982963($_smarty_tpl) {?><!DOCTYPE html>
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
    <script src=".././dash/js/jquery.js"></script>
</head>

<body>
<div class="container">
    <div class="left-container">
        <div class="logo-wrapper">
            <div class="logo-container">
                <img src="./app/assets/img/kortex-logo-new.svg">
            </div>
        </div>
        <div class="body-wrapper">
            <div class="content">
                <p class="welcome-text">Welcome to our new, <span class="welcome-text-highlight">KORTEX</span></p>
                <p class="welcome-subtext">Kortex is an AI platform with a range of tools that understand and Automate Business workflow</p>
            </div>
        </div>
        <div class="footer-wrapper">
            <p class="footer-text">Copyright &copy; Kobster 2012-2018. All Rights Reserved.</p>
        </div>
    </div>
    <div class="right-container">
        <div class="auth-container">
            <div class="login-container" id="login-container">
                <div class="title">
                    <h3>Enter PIN</h3>
                </div>
                <div class="login-wrapper" >
                    <input type="hidden" name="foo" autocomplete="off" />
                    <input class="kortex-pin" id="kortex-pin" type="password" name="kortex_pin" maxlength="4" autocomplete="new-password" tabindex="-1">
                    <label class="kortex-pin-label"> </label>
                </div>
                <div class="pin-wrapper" >
                    <a id="kortex_gen_pin" onclick="showPin(); $('#email-pin').focus();">Forgot/Generate New PIN?</a>
                </div>
                <div class="ajaxLoaderModal">
                    <img src="./app/assets/img/loading.svg">
                </div>
                <div class="successLoaderModal">
                    <img id="Capa" src="./app/assets/img/success.svg">
                </div>
                <div class="login-msg-success hidden">
                    <p>Please check your email address</p>
                </div>
                <div class="login-msg-error">
                    <p>Please check your email address</p>
                </div>
            </div>
            <div class="pin-container hide" id="pin-container">
                <div class="title">
                    <h3>Forgot/Generate New PIN</h3>
                </div>
                <div class="email-pin-wrapper">
                    <div class="input-group">
                        <input type="text" name="email-pin" id="email-pin" autocomplete="false" tabindex="-1">
                        <label>@kobster.com</label>
                    </div>
                    <div class="email-pin-btn">
                        <button onclick="generatePin()">Submit</button>
                    </div>
                </div>
                <div class="login-action-wrapper">
                    <a id="login-action-wrapper" onclick="showPin()">Go Back</a>
                </div>
                <div class="ajaxLoaderPinModal">
                    <img src="./app/assets/img/loading.svg">
                </div>
                <div class="pin-msg-success hidden">
                    <p>Please check your email address</p>
                </div>
                <div class="pin-msg-error hidden">
                    <p>Please check your email address</p>
                </div>
            </div>
        </div>
        <div class="auth-footer-wrapper">
            <p class="auth-footer-text" >For any support tech@kobster.com</p>
        </div>
    </div>
</div>
</body>

<script type="text/javascript">

    function showPin(){
        var login = document.getElementById("login-container");
        login.classList.toggle("hide-login");

        var pin = document.getElementById("pin-container");
        pin.classList.toggle("hide");
    }
    function generatePin(){
        var email = $('#email-pin').val()+"@kobster.com";
        $.ajax(
        {
            type: 'POST',
            async: true,
            dataType: 'json',
            url: 'ajax-tab.php',
            data: 'action=generatePin&ajax=1&controller=CortexLogin&kortex_email='+email+'',
            cache: true,
            beforeSend: function() {
                    $(".ajaxLoaderPinModal").show();
                },
            success: function(data)
            {
                if(data['errors'] && data['errors'][0] != ""){
                    $('.pin-msg-error').show();
                    $('.pin-msg-error p').html(data['errors'][0]);
                    $(".ajaxLoaderPinModal").hide();
                }

                if(data['hasErrors'] == false){
                    var login = document.getElementById("login-container");
                    login.classList.toggle("hide-login");

                    var pin = document.getElementById("pin-container");
                    pin.classList.toggle("hide");

                    $('.login-msg-success').show();
                    $('.login-msg-success p').html(data['email']);
                    $('#email-pin').val("");
                }
            },
            complete: function() {
                // $(".ajaxLoaderModal").hide();
            }
        });
    }

    $('#email-pin').keyup(function(e){
        //console.log(e.keyCode);
        $('.pin-msg-error').hide();
        $('.login-msg-success').hide();
        $('.login-msg-error').hide();
        if(e.keyCode == 13)
        {
            generatePin();
        }
    });
    $('.kortex-pin').keydown(function(e){
        //console.log(e.keyCode);
        //console.log("keydown");
        if(e.keyCode == 9 ){
            return false;

        }
    });
    $('.kortex-pin').keyup(function(e){
        //console.log(this.value);
        //console.log(e.keyCode);
        this.value = this.value.replace(/\D/g,'');
        $('.login-msg-error').hide();
        $('.login-msg-success').hide();
        $('.pin-msg-error').hide();
        $('.kortex-pin-label').removeClass('error-shake');
        if(e.keyCode == 9)
        {
            return false;
        }
        if(this.value.length == 4){
            this.blur();
            $.ajax(
            {
                type: 'POST',
                async: true,
                dataType: 'json',
                url: 'ajax-tab.php',
                data: 'action=processLogin&ajax=1&controller=CortexLogin&kortex_pin='+this.value+'',
                cache: true,
                beforeSend: function() {
                        $(".ajaxLoaderModal").show();
                    },
                success: function(data)
                {
                    $(".ajaxLoaderModal").hide();
                    if(data['errors'] && data['errors'][0] != ""){
                        $('.login-msg-error').show();
                        $('.login-msg-error p').html(data['errors'][0]);
                        $('.kortex-pin-label').addClass('error-shake');
                        $('.kortex-pin').val('');
                    }
                    if(data['hasErrors'] == false){
                        setTimeout(function(){
                            $(".successLoaderModal").show();
                            window.location.href=data['redirect'];
                        },500);
                    }
                },
                complete: function() {
                    // $(".ajaxLoaderModal").hide();
                }
            });
        }
    })
    $(document).ready(function(){
        $('.kortex-pin').focus();
    })
</script>
</html><?php }} ?>
