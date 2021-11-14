<!DOCTYPE html>
<html lang="en" ng-app = "mainApp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kobster.com Vendor Dashboard">
    <meta name="author" content="Kobster">
    <link rel="shortcut icon" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}favicon.ico">
    <title>Kobster.com Catalog Dashboard</title>
    <!--Core CSS -->
    <link href="dash/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="dash/css/bootstrap-reset.css" rel="stylesheet">
    <link href="dash/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dash/js/bootstrap-fileupload/bootstrap-fileupload.css">
    <link rel="stylesheet" type="text/css" href="catalog/css/angular-toast.min.css">
    <link rel="stylesheet" type="text/css" href="catalog/css/jquery-ui.min.css">
    <!-- Custom styles for this template -->
    <link href="dash/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="catalog/css/app.css">
    <link href="dash/css/style-responsive.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="rm/js/multiselect/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="catalog/css/animate.css">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="dash/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	  <script>
		 var id_poc = '$cookie->id_poc';
		 var baseDir = '$cookie->content_dir';
   	</script>
</head>
<body>