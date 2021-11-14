<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ABB India Limited - Kobster.com Business">
    <meta name="author" content="Kobster.com">
    <link rel="shortcut icon" href="{$img_ps_dir}favicon.ico">
	

    <title>ABB India Limited - Home Screen - Kobster.com</title>

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
			<form id="dash_login_form" role="form" class="form-inline" method="POST" action="{$link->getPageLink('dash-login.php')}">
				<input autofocus type="text" class="form-control lock-name" id="login_email" placeholder="UserName" name="login_email" value=""/>
				<img src="dash/images/face/56.png" alt="lock avatar"/>
				<div class="lock-pwd">
					 <div class="form-group">
						<input  type="password" name="login_passwd" placeholder="Password" id="login_passwd" class="form-control lock-input">
						<button class="btn btn-lock" type="submit" id="SubmitDashLogin" name="SubmitDashLogin">
							<i class="fa fa-arrow-right"></i>
						</button>
					</div>
				</div>
			</form>
        </div>
    </div>
    
</body>
</html>

