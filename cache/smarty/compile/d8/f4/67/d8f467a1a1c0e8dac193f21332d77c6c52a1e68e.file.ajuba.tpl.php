<?php /* Smarty version Smarty-3.1.19, created on 2018-01-31 14:54:32
         compiled from "dash\ajuba.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8945a718b50b79522-97706218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8f467a1a1c0e8dac193f21332d77c6c52a1e68e' => 
    array (
      0 => 'dash\\ajuba.tpl',
      1 => 1478085772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8945a718b50b79522-97706218',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'img_ps_dir' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a718b50bc7801_29664257',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a718b50bc7801_29664257')) {function content_5a718b50bc7801_29664257($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajuba Solutions India Pvt Ltd - Kobster.com Business">
    <meta name="author" content="Kobster.com">
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
favicon.ico">
	

    <title>Ajuba Solutions India Pvt Ltd - Home Screen - Kobster.com</title>

    <!-- Bootstrap core CSS -->
    <link href="dash/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="dash/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="dash/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="dash/css/style.css?1" rel="stylesheet">
    <link href="dash/css/style-responsive.css" rel="stylesheet" />

	<script src="dash/js/time-home.js"></script>
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="dash/js/html5shiv.js"></script>
    <script src="dash/js/respond.min.js"></script>
	
    <![endif]-->
</head>

<body class="lock-screen" onload="startTime()">
    <div class="lock-wrapper">
        <div id="time"></div>
        <div class="lock-box text-center">
            <div class="lock-name">Samson Shyam</div>
            <img src="dash/images/face/28.png" alt="lock avatar"/>
            <div class="lock-pwd">
                <form id="dash_login_form" role="form" class="form-inline" method="POST" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('dash-login.php');?>
">
                    <div class="form-group">
						<input type="hidden" id="login_email" name="login_email" value="samson.shyam@ajubanet.net"/>
                        <input autofocus type="password" name="login_passwd" id="login_passwd" class="form-control lock-input">
                        <button class="btn btn-lock" type="submit" id="SubmitDashLogin" name="SubmitDashLogin">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
         </div>
    </div>
 </body>
</html>
<?php }} ?>
