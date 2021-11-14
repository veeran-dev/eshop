<?php /* Smarty version Smarty-3.1.19, created on 2019-08-03 15:08:41
         compiled from "C:\wamp64\www\kobsterEshop\cortex\cortex-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:122195d455621d083b0-14577841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8ab66af6e2844ff2b9ecfe7aca60cf51dcc285c4' => 
    array (
      0 => 'C:\\wamp64\\www\\kobsterEshop\\cortex\\cortex-header.tpl',
      1 => 1537253483,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '122195d455621d083b0-14577841',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'css_files' => 0,
    'css_uri' => 0,
    'media' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d45562225de69_57932451',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d45562225de69_57932451')) {function content_5d45562225de69_57932451($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="description" content="Kobster Cortex">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="dash/favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    <!-- <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'> -->
    <?php if (isset($_smarty_tpl->tpl_vars['css_files']->value)) {?>
        <?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['media']->_loop = false;
 $_smarty_tpl->tpl_vars['css_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value) {
$_smarty_tpl->tpl_vars['media']->_loop = true;
 $_smarty_tpl->tpl_vars['css_uri']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
            <link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['css_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
" type="text/css" media="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['media']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
        <?php } ?>
    <?php }?>
    <title>Kobster Cortex</title>
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
    <link rel="stylesheet" href="react-select.css">
</head>
<body>
<?php }} ?>
