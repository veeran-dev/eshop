<?php /* Smarty version Smarty-3.1.19, created on 2020-08-28 17:00:28
         compiled from "dash\dash-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13748043325f48ead477c720-69535281%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49b17d776405b31776f66bd3b4bbd257b4d172f6' => 
    array (
      0 => 'dash\\dash-header.tpl',
      1 => 1576932183,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13748043325f48ead477c720-69535281',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5f48ead480fed2_05010542',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f48ead480fed2_05010542')) {function content_5f48ead480fed2_05010542($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="description" content="Kobster Elite">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="dash/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="dash/dist/ui.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAVWQfd_coykhZWXDenMNjrk46gNVfWjc&libraries=places"></script>
    <title>Kobster Elite</title>
    <style>
        #preloader{
            display: flex;
            display: -webkit-flex;
            justify-content: center;
            -webkit-justify-content: center;
            flex-direction: column;
            -webkit-flex-direction: column;
            align-items:  center;
            -webkit-align-items:  center;
            background: #ffffff;
            height: 100vh;
            transition: opacity 300ms fade-in;
        }
        #preloader span, #preloader img{
            display: block;
            margin: 16px;
            color: #323232;
        }
    </style>
    <?php if ($_smarty_tpl->tpl_vars['mode']->value=='LIVE') {?>
        <script>
        
              (function(i, s, o, g, r, a, m) {
                 i['GoogleAnalyticsObject'] = r;
                 i[r] = i[r] || function() {
                     (i[r].q = i[r].q || []).push(arguments)
                 }, i[r].l = 1 * new Date();
                 a = s.createElement(o),
                     m = s.getElementsByTagName(o)[0];
                 a.async = 1;
                 a.src = g;
                 m.parentNode.insertBefore(a, m)
             })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
             ga('create', 'UA-68709246-1', 'auto');
             ga('send', 'pageview');
             ga('set', '& uid', {$cookie->id_customer}); // Set the user ID using signed-in user_id.
        
        </script>
    <?php }?>
</head>
<body><?php }} ?>
