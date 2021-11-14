<?php /* Smarty version Smarty-3.1.19, created on 2018-02-08 16:50:32
         compiled from "dash\dash-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:47745a7c32808ab3c5-23242815%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a04dc19994d1f287b40ab255b94e92ab792281c8' => 
    array (
      0 => 'dash\\dash-header.tpl',
      1 => 1517202359,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '47745a7c32808ab3c5-23242815',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a7c3280915a46_17773806',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a7c3280915a46_17773806')) {function content_5a7c3280915a46_17773806($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="description" content="Kobster Elite">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="dash/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="dash/ui.css">
    <script src='//cdn.freshmarketer.com/206532/723429.js'></script>
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
