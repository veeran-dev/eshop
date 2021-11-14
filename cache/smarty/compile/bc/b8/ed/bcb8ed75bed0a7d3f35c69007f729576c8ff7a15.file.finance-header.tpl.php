<?php /* Smarty version Smarty-3.1.19, created on 2017-10-09 12:11:32
         compiled from "finance\finance-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2591159db1a1cbd62c3-97127685%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bcb8ed75bed0a7d3f35c69007f729576c8ff7a15' => 
    array (
      0 => 'finance\\finance-header.tpl',
      1 => 1478086142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2591159db1a1cbd62c3-97127685',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'img_update_time' => 0,
    'cookie' => 0,
    'content_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_59db1a1d4b7608_90275662',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59db1a1d4b7608_90275662')) {function content_59db1a1d4b7608_90275662($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kobster.com - Finance Department - Home">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="img/favicon.ico?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
">
        <title>
            Kobster.com Finance Dashboard
        </title>
    <!--Core CSS -->
    <link href="dash/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="dash/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="dash/css/bootstrap-reset.css" rel="stylesheet">
    <link href="dash/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="dash/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="dash/css/clndr.css" rel="stylesheet">
    <link href="dash/css/style-responsive.css" rel="stylesheet">
	<link href="dash/css/jquery.notify.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dash/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="rm/js/multiselect/css/select2.min.css">
    <!--clock css -->
    <link href="dash/js/css3clock/css/style.css" rel="stylesheet"> 
    
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="dash/js/morris-chart/morris.css"> 
	
    <!-- Custom styles for this template -->
    <link href="dash/css/style.css" rel="stylesheet">
    <link href="dash/css/bxslider.css" rel="stylesheet">
    <link href="dash/css/style-responsive.css" rel="stylesheet"/>
	<link href="dash/css/jquery.steps.css" rel="stylesheet"/>
	<link rel="stylesheet" href="dash/js/data-tables/DT_bootstrap.css" />
     <link rel="stylesheet" type="text/css" href="css/msgPop.css"/>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="dash/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="dash/js/jquery.js"></script>
    <script src="dash/js/jquery-1.8.3.min.js"></script>
	<script>
		 var id_customer = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_customer;?>
';
		 var baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
		 var id_employee= '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_employee;?>
';
		 var currency_format_value = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->currency_format_value;?>
';
		 var search_url = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
search';
	</script>
	
</head>
<body><?php }} ?>
