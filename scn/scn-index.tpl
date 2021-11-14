<div class="ajaxLoaderModal">
    <div class="preloader-animation">
        <div class="gif"></div>
        <p>{l s='Progressing...'}</p>
    </div>
</div>
<body>
    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href="scn-index.php" class="logo"> <img src="dash/images/scn-logo.png" alt=""> </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <div class="nav notify-row" id="top_menu">
                <ul class="nav pull-left top-menu">
                    <li class="fa fa-caret-left text-muted">&nbsp;&nbsp;Click here</li>
                </ul>
            </div>
            <!--logo end-->

            <div class="top-nav clearfix">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li id="top-corporuser-info" class="dropdown dash-corporate-user-logo">
                        <a data-toggle="dropdown" class="dropdown-toggle dash-corporate-user-logo" href="#"> <img id="corporate-logo" src="apple-icon-72x72.png" alt=""> <span class="username">{$cookie->firstname}</span> <b class="caret"></b> </a>
                        <ul class="dropdown-menu extended logout">
                            <li>
                                <a href="{$link->getPageLink('scn-login.php&scnLogout')}" title="{l s='LOG OUT'}"><i class="fa fa-key"></i> {l s='Log out'}</a>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                    <li>
                        <div class="toggle-right-box display-none">
                            <div class="fa fa-bars"></div>
                        </div>
                    </li>
                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li class="sub-menu dcjq-parent-li">
                            <a class="active" href="scn-index.php">
                                <i class="fa fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li class="sub-menu dcjq-parent-li">
                            <a href="openVendorForm();">
                                <i class="fa fa-users"></i>
                                <span>Vendor Management</span>
                            </a>
                            <ul class="sub">
                                <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="openVendorForm();">Add a Vendor</a></li>
                                <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="vendorList();">View Vendors</a></li>
                                <li class="sub-menu dcjq-parent-li"><a class="cur-poi">Product & Vendor Mapping</a>
                                    <ul class="sub">
                                        <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="vendorProductMapping();">Map by Product</a>
                                            <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="vendorCategoryMapping();">Map by Category</a>
                                                <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="vendorBrandMapping();">Map by Brand</a>
                                    </ul>
                                </li>
                                <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="reports(5);">Performance Report</a></li>
                                <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="reports(3);">Top 10 Vendors</a></li>
                                <input type="hidden" value="" id="report_type" name="report_type" />
                            </ul>
                        </li>
                        <li class="sub-menu dcjq-parent-li">
                            <a class="cur-poi" href="#">
                                <i class="fa fa-file"></i>
                                <span>RFQ</span>
                            </a>
                            <ul class="sub">
                                <li class="sub-menu dcjq-parent-li">
                                    <a class="cur-poi" href="#" onclick="bqRequest()"><span>Bulk Requests</span></a>
                                </li>
                                <!-- <li class="sub-menu dcjq-parent-li"><a class="cur-poi" onClick="customerSearchView(8)">Quotations</a></li> -->
                                <!-- <input type="hidden" value="" id="quote_type" name="quote_type" /> -->
                            </ul>
                        </li>
                        <li class="sub-menu dcjq-parent-li">
                            <a class="cur-poi" href="#">
                                <i class="fa fa-credit-card"></i>
                                <span>Operations</span>
                            </a>
                            <ul class="sub">
                                <li class="sub-menu dcjq-parent-li"> 
                                    <a href="#" onclick="openOrders(0,0,50,1,'id_order','DESC',0)"> 
                                      <span>Order Management</span> 
                                    </a> 
                                </li>
                                <li class="sub-menu dcjq-parent-li">
                                    <a class="cur-poi" href="#" onClick="loadDeliveryReport(0);">
                                        <span>On-time Delivery Report</span>
                                    </a>
                                </li>

                                <li class="sub-menu dcjq-parent-li">
                                    <a class="cur-poi" href="#" onClick="productHistory();">
                                        <span>Product Buying History</span>
                                    </a>
                                </li>

                                <li class="sub-menu dcjq-parent-li">
                                    <a class="cur-poi" href="#">
                                        <span>Boxes Report</span>
                                    </a>
                                    <ul class="sub dcjq-parent-li">
                                        <li class="sub-menu dcjq-parent-li">
                                            <a class="cur-poi" onClick="trackDelBox(0);">Box Details</a>
                                        </li>
                                        <li class="sub-menu dcjq-parent-li">
                                            <a class="cur-poi" onClick="trackDelBox(1);">Box Sent to Company</a>
                                        </li>
                                        <li class="sub-menu dcjq-parent-li">
                                            <a class="cur-poi" onClick="trackDelBox(2);">Boxes Returned</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="sub-menu dcjq-parent-li">
                            <a class="cur-poi" href="#">
                                <i class="fa fa-truck"></i>
                                <span>Fulfillment</span>
                            </a>
                            <ul class="sub">
                                <li class="sub-menu dcjq-parent-li">
                                    <a class="cur-poi" href="#" onClick="purchasePlan();">
                                        <span>Procurement Plan</span>
                                    </a>
                                </li>
                                <li class="sub-menu dcjq-parent-li">
                                    <a class="cur-poi" onClick="paymentRequest(0);">Make Payment Request</a>
                                </li>
                                <li class="sub-menu dcjq-parent-li">
                                    <a class="cur-poi" onClick="paymentRequest(9);">View Payment Request</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div id="dsr-copyright">
                        <p>&copy; Copyright 2016 - Kobster.com</p>
                    </div>
                </div>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!--mini statistics start-->
                <div class="top-stats-panel" id="index_viewport">
                    <div class="col-md-12">
                        <!--**************************************Corporate customer order Status Details****************************************************************************-->
                        <div class="col-md-12">
                            <div class="row panel">
                                <header class="panel-heading">
                                    <div class="padding5 paddleft0">
                                        <span class="label label-primary pull-left cur-poi padding5" onclick="getAllOrders(0)">Refresh</span> Order's Statuses
                                    </div>
                                    <form class="form-inline pull-left">
                                        <select id="id-fc-scn" onchange="getAllOrders(0)" class="form-control"></select>
                                    </form>
                                    <div class="clear"></div>
                                </header>
                                <div class="panel-body">
                                    <header class="panel-heading">Supply Chain</header>
                                    <table class="table table-hovered table-stripped">
                                        <thead>
                                            <th class="padding5 tex-ali-cen">Order Status</th>
                                            <th class="padding5 tex-ali-cen">24 hrs</th>
                                            <th class="padding5 tex-ali-cen">48 hrs</th>
                                            <th class="padding5 tex-ali-cen">72+ hrs</th>
                                        </thead>
                                        <tbody id="order-statuses-scn">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-body">
                                    <header class="panel-heading">Customer Support</header>
                                    <table class="table table-hovered table-stripped">
                                        <thead>
                                            <th class="padding5 tex-ali-cen">Order Status</th>
                                            <th class="padding5 tex-ali-cen">24 hrs</th>
                                            <th class="padding5 tex-ali-cen">48 hrs</th>
                                            <th class="padding5 tex-ali-cen">72+ hrs</th>
                                        </thead>
                                        <tbody id="order-statuses-rm">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-body">
                                    <header class="panel-heading">Finance</header>
                                    <table class="table table-hovered table-stripped">
                                        <thead>
                                            <th class="padding5 tex-ali-cen">Order Status</th>
                                            <th class="padding5 tex-ali-cen">24 hrs</th>
                                            <th class="padding5 tex-ali-cen">48 hrs</th>
                                            <th class="padding5 tex-ali-cen">72+ hrs</th>
                                        </thead>
                                        <tbody id="order-statuses-finance">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-body">
                                    <header class="panel-heading">Technology</header>
                                    <table class="table table-hovered table-stripped">
                                        <thead>
                                            <th class="padding5 tex-ali-cen">Order Status</th>
                                            <th class="padding5 tex-ali-cen">24 hrs</th>
                                            <th class="padding5 tex-ali-cen">48 hrs</th>
                                            <th class="padding5 tex-ali-cen">72+ hrs</th>
                                        </thead>
                                        <tbody id="order-statuses-tech">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-body">
                                    <header class="panel-heading">Others</header>
                                    <table class="table table-hovered table-stripped">
                                        <thead>
                                            <th class="padding5 tex-ali-cen">Order Status</th>
                                            <th class="padding5 tex-ali-cen">24 hrs</th>
                                            <th class="padding5 tex-ali-cen">48 hrs</th>
                                            <th class="padding5 tex-ali-cen">72+ hrs</th>
                                        </thead>
                                        <tbody id="order-statuses-other">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->
        <!--right sidebar start-->
        <!--right sidebar end-->
    </section>
    <!--My profile form-->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="scnGlobalAlert" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body"> <span id="idScnGlobalAlert"></span> </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!---to show change in quantity-->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="scnDRAlert" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body classScnDRAlert"> <span id="idScnDRAlert"></span> </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!---END-->
    <!-- to show the customers details for the scn-->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="scn_customer_order" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title" id="modal-heading">Order Details</h4>
                </div>
                <div class="modal-body" id="statusorders">
                    <table class="table general-table">
                        <!--<table class="table table-hover general-table">-->
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Name</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Order Placed Date</th>
                            </tr>
                        </thead>
                        <tbody id="status_orders"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!--<script src="dash/js/myprofile.js"></script> -->
    <!-- jSignature div-->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="scnDRsign" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">User Signature</h4>
                </div>
                <div class="modal-body class_scnDRsign">
                    <div id="drReceiptdiv"></div> <span class='col-sm-6' id="idscnDRsign"></span>
                    <div class='col-sm-12'>
                        <input type='text' id="customer_name" class='form-control ' placeholder='Enter Users Name'>
                    </div>
                    <div class='col-sm-12'>
                        <button class='col-sm-3 btn btn-primary signmargin' onclick="clearData();" type="button">Clear</button>
                        <button class='col-sm-3 btn btn-primary signmargin' onclick="importData();" type="button">Submit</button>

                    </div>
                </div>
                <div class="modal-footer error_msg">
                </div>
            </div>
        </div>
    </div>
    <form action="{$link->getPageLink('scn-login.php&scnLogout')}" method="POST" id="logoutForm"></form>
    <!---END-->
    <script language="JavaScript" type="text/javascript" src="js/jSignature.js"></script>
    <script src="js/jSignature.CompressorBase30.js"></script>