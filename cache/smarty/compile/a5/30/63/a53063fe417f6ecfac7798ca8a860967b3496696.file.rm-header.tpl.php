<?php /* Smarty version Smarty-3.1.19, created on 2018-01-31 15:46:34
         compiled from "rm\rm-header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:281485a719782b6b4f3-96130204%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a53063fe417f6ecfac7798ca8a860967b3496696' => 
    array (
      0 => 'rm\\rm-header.tpl',
      1 => 1515146676,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '281485a719782b6b4f3-96130204',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'img_ps_dir' => 0,
    'img_update_time' => 0,
    'cookie' => 0,
    'content_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a719782be5546_90163110',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a719782be5546_90163110')) {function content_5a719782be5546_90163110($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kobster.com - Relationship Managaer - Home">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
favicon.ico?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
">
        <title>
            Kobster.com Relationship Manager Dashboard
        </title>
    <!--Core CSS -->
    <link href="rm/css/bootstrap.min.css" rel="stylesheet">
    <link href="dash/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="dash/css/bootstrap-reset.css" rel="stylesheet">
    <link href="scn/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="dash/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="dash/css/clndr.css" rel="stylesheet">
    <link href="dash/css/style-responsive.css" rel="stylesheet">
    <link href="dash/css/jquery.notify.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dash/js/bootstrap-fileupload/bootstrap-fileupload.css">
    <link rel="stylesheet" href="css/jquery-ui-1.8.10.custom.css">
    <!--clock css -->
    <link href="dash/js/css3clock/css/style.css" rel="stylesheet"> 
    
    
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="dash/js/morris-chart/morris.css"> 
    
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css" href="rm/js/multiselect/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="rm/css/select2-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="scn/css/bootstrap-datetimepicker.min.css">
    <link href="dash/css/style.css" rel="stylesheet">
    <link href="dash/css/style-responsive.css" rel="stylesheet"/>
    <link href="dash/css/jquery.steps.css" rel="stylesheet"/>
    <link rel="stylesheet" href="dash/js/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/msgPop.css"/>
    <link rel="stylesheet" type="text/css" href="rm/css/rm.css">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="dash/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="dash/js/jquery.js"></script>
    <script type="text/javascript" src="dash/js/canvasjs.min.js"></script>
    <script src="dash/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="finance/js/accounting.js"></script>
    <script type="text/javascript" src="finance/js/finance-receivables.js"></script>
	<script>
		 var id_customer = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_customer;?>
';
		 var baseDir = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
';
		 var id_employee= '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->id_employee;?>
';
         var search_url = '<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
search';
		 var currency_format_value = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->currency_format_value;?>
';
		 var emp_profile = '<?php echo $_smarty_tpl->tpl_vars['cookie']->value->profile;?>
';
	</script>
</head>
<body><?php }} ?>
