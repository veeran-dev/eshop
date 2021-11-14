<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kobster.com - Finance Department - Home">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="img/favicon.ico?{$img_update_time}">
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
		 var id_customer = '{$cookie->id_customer}';
		 var baseDir = '{$content_dir}';
		 var id_employee= '{$cookie->id_employee}';
		 var currency_format_value = '{$cookie->currency_format_value}';
		 var search_url = '{$content_dir}search';
	</script>
	
</head>
<body>