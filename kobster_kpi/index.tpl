<!doctype html>
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
			<div><img src="kobster_kpi/img/kobster-logo-tm.png" /></div>
            <div id="clock" class="timer"></div>
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
                    <div class="col-5">
                        <div class="card padding-zero">
                            <div class="wrapper">
                                <div class="kpi-info delivery">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Average Delivery Time</h2>
                                                <h1> <span id="adt">98:56</span> <span class="unit">Hrs</span></h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/truck.svg" alt="truck-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-12by5">
                                                <h3 id="adt_1_name">BLR</h3>
                                                <p id="adt_1">99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3 id="adt_2_name">CHN</h3>
                                                <p id="adt_2">99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3 id="adt_3_name">DEL</h3>
                                                <p id="adt_3">99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3 id="adt_4_name">HYD</h3>
                                                <p id="adt_4">99:65</p>
                                            </div>
                                            <div class="col-12by5">
                                                <h3 id="adt_5_name">MUM</h3>
                                                <p id="adt_5">99:65</p>
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
                                <div class="kpi-info order-status">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Pending Orders</h2>
                                                <h1 id="tot_ord_pending_count">16</h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/pending.svg" alt="pending-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-3">
                                                <h3>Rel. Managers</h3>
                                                <p id="ord_pending_count_rm">5</p>
                                            </div>
                                            <div class="col-3">
                                                <h3>Operations</h3>
                                                <p id="ord_pending_count_ops">8</p>
                                            </div>
                                            <div class="col-3">
                                                <h3>Category</h3>
                                                <p id="ord_pending_count_scn">3</p>
                                            </div>
                                            <div class="col-3">
                                                <h3>Finance</h3>
                                                <p id="ord_pending_count_fin">5</p>
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
                                <div class="kpi-info finance">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Days Sales Outstanding</h2>
                                                <h1><span id="dso">15</span> <span class="unit">days</span></h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/finance.svg" alt="finance-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Receivables</h3>
                                                <p>₹<span id="fin_receivables"></span></p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Payables</h3>
                                                <p>₹<span id="fin_payables">987456</span></p>
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
                                <div class="kpi-info customers">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>New Customers</h2>
                                                <h1 id="new_customers">58</h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/user.svg" alt="customer-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Active Companies</h3>
                                                <p id="active_companies">600</p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Active Users</h3>
                                                <p id="active_customer">2890</p>
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
                                <div class="kpi-info brands">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>Active Brands</h2>
                                                <h1 id="active_brands">70</span></h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/brands.svg" alt="brands-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Active Products</h3>
                                                <p id="active_products">5000</p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Out of Stock</h3>
                                                <p id="oos">120</p>
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
                                <div class="kpi-info vendors">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <h2>New Vendors</h2>
                                                <h1 id="new_vendors">58</h1>
                                            </div>
                                            <div class="col-4 icon">
                                                <img src="kobster_kpi/img/store.svg" alt="store-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Total Vendors</h3>
                                                <p id="total_vendors">600</p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Active Vendors</h3>
                                                <p id="active_vendors">2890</p>
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
                                <div class="kpi-info annual-revenue-target">
                                    <div class="kpi-info-primary">
                                        <div class="row">
                                            <div class="col-9">
                                                <h2>Annual Revenue Target Achieved</h2>
                                                <h1><span id="revenuePercent">100</span>%</h1>
                                            </div>
                                            <div class="col-3 icon">
                                                <img src="kobster_kpi/img/target.svg" alt="target-icon" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kpi-info-secondary padding-zero">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3>Target</h3>
                                                <p>₹<span id="target">99999999</span></p>
                                            </div>
                                            <div class="col-6">
                                                <h3>Achieved</h3>
                                                <p>₹<span id="achieved">99999999</span></p>
                                            </div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progressed" id="progressBar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

			</div>
		</main>
        <footer>&copy; Kobster 2018. All rights reserved.</footer>
		<script src="./kobster_kpi/js/jquery.min.js"></script>
        <script src="./kobster_kpi/js/moment.min.js"></script>
		<script src="./kobster_kpi/js/jquery.canvasjs.min.js"></script>
		<script src="./kobster_kpi/js/main.js"></script>
	</body>
</html>