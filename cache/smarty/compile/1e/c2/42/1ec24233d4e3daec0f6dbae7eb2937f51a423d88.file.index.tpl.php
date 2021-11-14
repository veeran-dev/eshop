<?php /* Smarty version Smarty-3.1.19, created on 2017-12-15 04:23:06
         compiled from "kobster_kpi\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:263175a3300d2e44b66-29287785%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ec24233d4e3daec0f6dbae7eb2937f51a423d88' => 
    array (
      0 => 'kobster_kpi\\index.tpl',
      1 => 1513291983,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '263175a3300d2e44b66-29287785',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'month' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5a3300d2ec0ff2_89806462',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a3300d2ec0ff2_89806462')) {function content_5a3300d2ec0ff2_89806462($_smarty_tpl) {?><!doctype html>
<html lang="em">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Kobster KPI</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" href="icon.png">
		<link rel="stylesheet" href="./kobster_kpi/css/style.css">
</head>
	<body>
		<header>
			<h1>KOBSTER PERFORMANCE - <?php echo $_smarty_tpl->tpl_vars['month']->value;?>
</h1>
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
                    <div class="col-4">
                        <div class="card padding-zero">
                            <div class="wrapper">
                                <div class="kpi-info">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Average Delivery Time</h2>
                                                <h1>98:56 <span>Hrs</span></h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/delivery-icon.svg" alt="customer-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-12by5">
                                                <h3>BLR</h3>
                                                <p>99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3>CHN</h3>
                                                <p>99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3>DEL</h3>
                                                <p>99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3>HYD</h3>
                                                <p>99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3>MUM</h3>
                                                <p>99:65</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-4">
                        <div class="card padding-zero">
                            <div class="wrapper">
                                <div class="kpi-info">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Pending Orders</h2>
                                                <h1>16</h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/delivery-icon.svg" alt="customer-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-3">
                                                <h3>Rel. Managers</h3>
                                                <p>5</p>
                                            </div>
                                            <div class="col-3">
                                                <h3>Operations</h3>
                                                <p>8</p>
                                            </div>
                                            <div class="col-3">
                                                <h3>Supply Chain</h3>
                                                <p>3</p>
                                            </div>
                                            <div class="col-3">
                                                <h3>Finance</h3>
                                                <p>5</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="card padding-zero">
                            <div class="wrapper">
                                <div class="kpi-info">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Days Sales Outstanding</h2>
                                                <h1>15 <span>days</span></h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/delivery-icon.svg" alt="customer-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Receivables</h3>
                                                <p>₹ 98745600</p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Payables</h3>
                                                <p>₹ 987456</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>

				<!-- Third Section -->
				<div class="row">
                    <div class="col-3">
                        <div class="card padding-zero">
                            <div class="wrapper">
                                <div class="kpi-info">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>New Customers</h2>
                                                <h1>58</h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/delivery-icon.svg" alt="customer-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Active Companies</h3>
                                                <p>600</p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Active Users</h3>
                                                <p>2890</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
					<div class="col-3">
                        <div class="card padding-zero">
                            <div class="wrapper">
                                <div class="kpi-info">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Active Brands</h2>
                                                <h1>70</span></h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/delivery-icon.svg" alt="customer-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Active Products</h3>
                                                <p>5000</p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Out of Stock</h3>
                                                <p>120</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>

					<div class="col-3">
                        <div class="card padding-zero">
                            <div class="wrapper">
                                <div class="kpi-info">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>New Customers</h2>
                                                <h1>58</h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/delivery-icon.svg" alt="customer-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Active Companies</h3>
                                                <p>600</p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Active Users</h3>
                                                <p>2890</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="card">
                            <div class="wrapper">
                                5666
                            </div>
                        </div>
                    </div>
				</div>

			</div>
		</main>
		<script src="./kobster_kpi/js/jquery.min.js"></script>
		<script src="./kobster_kpi/js/jquery.canvasjs.min.js"></script>
		<script src="./kobster_kpi/js/main.js"></script>
	</body>
</html><?php }} ?>
