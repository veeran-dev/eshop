<?php /* Smarty version Smarty-3.1.19, created on 2017-12-15 01:08:47
         compiled from "kobster-kpi\index.html" */ ?>
<?php /*%%SmartyHeaderCode:305875a32d347688ad7-08026509%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df485eb43a3a8fd4c37515cc723f684d15848ebd' => 
    array (
      0 => 'kobster-kpi\\index.html',
      1 => 1513279429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '305875a32d347688ad7-08026509',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a32d3476b86f5_51516828',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a32d3476b86f5_51516828')) {function content_5a32d3476b86f5_51516828($_smarty_tpl) {?><!doctype html>
<html lang="em">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Kobster KPI</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" href="icon.png">
		<link rel="stylesheet" href="css/style.css">
</head>
	<body>
		<header style="display:none">
			<h1>KOBSTER</h1>
			<p>January 2018</p>
		</header>
		<main>
			<div class="container">
				<!-- First Section -->
				<div class="row">
					<div class="col-4">
							<div class="card">
								<div class="wrapper">
										<div id="totalRevenueChart" style="height: 432px; width: 100%;"></div>
								</div>
							</div>
					</div>
					<div class="col-8">
							<div class="row">
								<div class="col-6">
										<div class="card">
											<div class="wrapper">
												<div id="rmRevenue" style="height: 200px; width: 100%;"></div>
											</div>
										</div>
								</div>
								<div class="col-6">
										<div class="card">
											<div class="wrapper">
												<div id="kamRevenue" style="height: 200px; width: 100%;"></div>
											</div>
										</div>
								</div>
							</div>
							<div class="row">
								<div class="col-4">
										<div class="card">
											<div class="wrapper">
												<div id="fcRevenue" style="height: 200px; width: 100%;"></div>
											</div>
										</div>
								</div>

								<div class="col-4">
										<div class="card">
											<div class="wrapper">
													<div id="categoryRevenue" style="height: 200px; width: 100%;"></div>
											</div>
										</div>
								</div>

								<div class="col-4">
										<div class="card">
											<div class="wrapper">
												<div id="topCustomerRevenue" style="height: 200px; width: 100%;"></div>
											</div>
										</div>
								</div>
							</div>
					</div>
				</div>

				<!-- Second Section -->
				<div class="row">
					<div class="col-3">
							<div class="card">
								<div class="wrapper">
									Active Users and Companies
								</div>
							</div>
					</div>

					<div class="col-6">
							<div class="card">
								<div class="wrapper">
									Operations ADT and Pending Orders
								</div>
							</div>
					</div>

					<div class="col-3">
							<div class="card">
								<div class="wrapper">
									DSO, Receivables and Payables
								</div>
							</div>
					</div>
				</div>

				<!-- Third Section -->
				<div class="row">
					<div class="col-4">
							<div class="card">
								<div class="wrapper">
									Category Stats
								</div>
							</div>
					</div>

					<div class="col-4">
							<div class="card">
								<div class="wrapper">
									Active Products Stats
								</div>
							</div>
					</div>

					<div class="col-4">
							<div class="card">
								<div class="wrapper">
									Vendor stats
								</div>
							</div>
					</div>
				</div>

				<!-- Fourth Section -->
				<div class="row">
					<div class="col-12">
							<div class="card">
								<div class="wrapper">
									Overall Progress of Goal
								</div>
							</div>
					</div>
				</div>

			</div>
		</main>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.canvasjs.min.js"></script>
		<script src="js/main.js"></script>
	</body>
</html><?php }} ?>
