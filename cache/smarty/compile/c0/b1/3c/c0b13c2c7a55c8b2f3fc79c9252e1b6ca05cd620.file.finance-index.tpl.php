<?php /* Smarty version Smarty-3.1.19, created on 2018-09-21 17:41:31
         compiled from "finance\finance-index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:153815ba4dff3a97952-77342489%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0b13c2c7a55c8b2f3fc79c9252e1b6ca05cd620' => 
    array (
      0 => 'finance\\finance-index.tpl',
      1 => 1536131913,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153815ba4dff3a97952-77342489',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cookie' => 0,
    'link' => 0,
    'finance_order_status_details' => 0,
    'sales' => 0,
    'purchaseBill' => 0,
    'purchase' => 0,
    'order_status' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ba4dff3e134b8_97357546',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ba4dff3e134b8_97357546')) {function content_5ba4dff3e134b8_97357546($_smarty_tpl) {?>
<body>
<div class="ajaxLoaderModal coin_loading">
  <div class="preloader-animation">
    <div class="gif"></div>
    <p><?php echo smartyTranslate(array('s'=>'Progressing...'),$_smarty_tpl);?>
</p>
  </div>
</div>
<section id="container"> 
  <!--header start-->
  <header class="header fixed-top clearfix"> 
    <!--logo start-->
    <div class="brand"> <a href="finance-index.php" class="logo"> <img src="dash/images/kobster_finance.png" alt=""> </a>
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
      </div>
    </div>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu"> 
        <ul  class="nav pull-left top-menu">
          <li class="fa fa-caret-left text-muted">&nbsp;&nbsp;Click here</li>
        </ul>
    </div>
    <div class="top-nav clearfix"> 
      <!--search & user info start-->
      <ul  class="nav pull-right top-menu">
        <!-- user login dropdown start-->
        <li id="top-corporuser-info" class="dropdown dash-corporate-user-logo"> <a data-toggle="dropdown" class="dropdown-toggle dash-corporate-user-logo" href="#"> <img id="corporate-logo"  src="apple-icon-72x72.png" alt="" > <span class="username"><?php echo $_smarty_tpl->tpl_vars['cookie']->value->firstname;?>
</span> <b class="caret"></b> </a>
          <ul class="dropdown-menu extended logout">
            <!--<li><a href="#myProfile" data-toggle="modal"><i class=" fa fa-suitcase"></i>Change Password</a></li>
            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>-->
            <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('finance-login.php&FinanceLogout');?>
"  title="<?php echo smartyTranslate(array('s'=>'LOG OUT'),$_smarty_tpl);?>
"><i class="fa fa-key"></i> <?php echo smartyTranslate(array('s'=>'Log out'),$_smarty_tpl);?>
</a></li>
          </ul>
        </li>
        <!-- user login dropdown end -->
        <!--<li>
          <span id="total_cart_products" onClick="openShoppingCart(1);">0</span>
          <div  class="toggle-right-box">
            <div class="fa fa-shopping-cart shoppingcart"></div>
          </div>
        </li>-->
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
          <li> 
            <a class="active" href="finance-index.php"> 
              <i class="fa fa-home"></i> <span>Home</span> 
            </a> 
          </li>
          <li class="sub-menu"> <a class="cur-poi"><i class="fa fa-arrow-circle-up"></i><span>Payables</span> </a> 
            <ul class="sub">
              <li><a class="cur-poi" onClick="fianance_procurement();">Procurement Plan</a></li>
              <li><a class="cur-poi" onClick="openPaymentRequests(6);">Payment Request</a></li>
              <li class="sub-menu">
                <a class="cur-poi">Vendors</a>
                <ul class="sub">
                  <li><a class="cur-poi sub-menu1 sub-sub-menu" onClick="openVendorForm();">Add Vendor</a></li>
                  <li><a class="cur-poi sub-menu1 sub-sub-menu" onClick="vendorList();">Vendor List</a></li>
                  <li><a class="cur-poi sub-menu1 sub-sub-menu" onClick="bankDetails();">Bank Details</a></li>
                </ul>
              </li>
              <li><a class="cur-poi">Purchase Bill</a>
                <ul class="sub">
                  <li><a class="cur-poi sub-menu1 sub-sub-menu" onClick="addPurchaseBill();">Add Purchase Bill</a></li>
                  <li><a class="cur-poi sub-menu1 sub-sub-menu" onClick="viewPurchaseBill();">View Purchase Bill</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="sub-menu"><a class="cur-poi"><i class="fa fa-arrow-circle-down"></i></i><span>Receivables</span> </a> 
            <ul class="sub">
              <li><a class="cur-poi sub-sub-menu" onClick="openPendingPayment();">Pending Payment</a></li>
              <li><a class="cur-poi sub-sub-menu" onClick="openAgingSheet();">Ageing Sheet</a></li>
              <li><a class="cur-poi sub-sub-menu" onClick="releaseOrders();">Order Holds</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a class="cur-poi"><i class="fa fa-book"></i><span>Invoice</span> </a> 
            <ul class="sub">
              <li><a class="cur-poi" onClick="generate_invoice();">Invoice Consolidation</a></li>
              <li><a class="cur-poi" onClick="changeVat();">Change TAX</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a class="cur-poi"> <i class="fa fa-bar-chart-o"></i> <span>Reports</span> </a> 
            <ul class="sub">              
              <li><a class="cur-poi sub-sub-menu" onClick="ExcelReports();">Export Purchase and Sales Bill</a></li>
              <li><a class="cur-poi sub-sub-menu" onClick="salesReports();">Master Sales Report</a></li>
              <li><a class="cur-poi sub-sub-menu" onClick="rateContractReport();">Rate Contract Report</a></li>
            </ul>
          </li>
        </ul>
        <div id="dsr-copyright"><p>&copy; Copyright 2016 - Kobster.com</p></div>
      </div>
    <!-- sidebar menu end--> 
    </div>
  </aside>
  <!--sidebar end--> 
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper"> 
      
      <!--mini statistics start--> 
     
      <div class="top-stats-panel"  id="index_viewport">
        <div class="col-md-12 col-xs-12" id="finance_view">           
       <!-- <div class="row">
      <div class="col-md-12">
        <section class="panel">
          <div class="panel-body">
            <section class="panel">
                        <header class="panel-heading no-border">Procurement Plan</header>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Company Name</th>
                                    <th>Fulfillment Center</th>
                                    <th>Order Value</th>
                                </tr>
                                </thead>
                                <tbody id="finance_procurement_details">
                                 </tbody>
                 
                            </table>
                        </div>
                    </section>
          </div>
        </section>
      </div>
       </div> -->
       <section class="panel monthly-sales">
        <header class="panel-heading">
            Monthly Sales
            <span class="tools pull-right">
                <a class="fa fa-chevron-down" href="javascript:;"></a>
             </span>
        </header>
        <div class="panel-body cur-poi">
          <div class="finance-slider1">      
            <?php  $_smarty_tpl->tpl_vars['sales'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sales']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['finance_order_status_details']->value[1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sales']->key => $_smarty_tpl->tpl_vars['sales']->value) {
$_smarty_tpl->tpl_vars['sales']->_loop = true;
?>
            <?php if ($_smarty_tpl->tpl_vars['sales']->value['month']) {?>
             <div class="slide finance-sale-slider">
                <div class="finance-sales-month"><?php echo $_smarty_tpl->tpl_vars['sales']->value['month'];?>
</div>
                <div class="finance-sales-total"><?php echo $_smarty_tpl->tpl_vars['sales']->value['total_value'];?>
</div>
                <div class="month hidden"><?php echo $_smarty_tpl->tpl_vars['sales']->value['date_month'];?>
</div>
              </div>
              <?php }?>
              <?php } ?>
            </div>
          </div>
        </section>

        <section class="panel monthly-Purchase">
        <header class="panel-heading">
            Monthly Purchase
            <span class="tools pull-right">
                <a class="fa fa-chevron-down" href="javascript:;"></a>
             </span>
        </header>
        <div class="panel-body cur-poi">        
          <div class="finance-slider2">           
            <?php  $_smarty_tpl->tpl_vars['purchase'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['purchase']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['purchaseBill']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['purchase']->key => $_smarty_tpl->tpl_vars['purchase']->value) {
$_smarty_tpl->tpl_vars['purchase']->_loop = true;
?>
             <div class="slide finance-purchase-slider">
                <div class="finance-purchase-month"><?php echo $_smarty_tpl->tpl_vars['purchase']->value['month'];?>
</div>
                <div class="finance-sales-total"><?php echo $_smarty_tpl->tpl_vars['purchase']->value['total_value'];?>
</div>
                <div class="month hidden"><?php echo $_smarty_tpl->tpl_vars['purchase']->value['month_year'];?>
</div>
              </div>
              <?php } ?>
            </div>
            </div>          
        </section>

         <section class="panel payment-outstanding col-md-8">
              <header class="panel-heading">
                  Payments Outstanding
                  <span class="tools pull-right">
                      <a class="fa fa-chevron-down" href="javascript:;"></a>
                   </span>
              </header>
              <div class="panel-body cur-poi">
                <?php  $_smarty_tpl->tpl_vars['order_status'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order_status']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['finance_order_status_details']->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order_status']->key => $_smarty_tpl->tpl_vars['order_status']->value) {
$_smarty_tpl->tpl_vars['order_status']->_loop = true;
?>
                <div class="col-md-12" onclick="openPendingPayment();">
                <span class="col-md-8"><?php echo $_smarty_tpl->tpl_vars['order_status']->value['name'];?>
</span>
                <span class="col-md-4 amount"><b>
                <?php if (isset($_smarty_tpl->tpl_vars['order_status']->value['total'])) {?>
                  <?php echo $_smarty_tpl->tpl_vars['order_status']->value['total'];?>

                <?php } else { ?>
                  0.00
                <?php }?></b>
                </span>
                </div>
                <?php } ?>                
              </div>
          </section>

      </div>

        <div class="col-md-12">
              <div class="row panel">
                  <header class="panel-heading">
                    <div class="padding5 paddleft0">
                      <span class="label label-primary pull-left cur-poi padding5" onclick="getAllOrders(0)">Refresh</span>
                      <b>Order Status</b>
                    </div>
                    <form class="form-inline pull-left">
                      <select id="id-fc-finance" onchange="getAllOrders(0)" class="form-control"></select>
                    </form>
                    <div class="clear"></div>
                  </header>
                  <div class="panel-body">
                      <header class="panel-heading">Finance</header>
                      <table class="table table-hovered table-stripped">
                        <thead>
                          <th class="padding5 tex-ali-cen">Order Status</th>
                          <th class="padding5 tex-ali-cen">24 hrs</th>
                          <th class="padding5 tex-ali-cen">48 hrs</th>
                          <th class="padding5 tex-ali-cen">72+ hrs</th>
                        </thead>
                        <tbody id="order-states-finance">
                          
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
                        <tbody id="order-states-rm">
                          
                        </tbody>
                      </table>
                  </div>      
                  <div class="panel-body">
                  <header class="panel-heading">Supply Chain</header>
                      <table class="table table-hovered table-stripped">
                        <thead>
                          <th class="padding5 tex-ali-cen">Order Status</th>
                          <th class="padding5 tex-ali-cen">24 hrs</th>
                          <th class="padding5 tex-ali-cen">48 hrs</th>
                          <th class="padding5 tex-ali-cen">72+ hrs</th>
                        </thead>
                        <tbody id="order-states-scn">
                          
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
                        <tbody id="order-states-tech">
                          
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
                        <tbody id="order-states-other">
                          
                        </tbody>
                      </table>
                  </div>             
              </div>
            </div>
        </div>

        </div>
      </div>
     </section>
  </section>
  <!--main content end--> 


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="globalAlert" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Alert</h4>
      </div>
      <div class="modal-body">
        <span id="idGlobalAlert"></span> 
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
      </div>
    </div>
  </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="orderCredit" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content col-md-12 col-xs-12 col-sm-12">
            <div class="modal-header">
                <h3 class="modal-title">Credit Days Customization</h3>
            </div>
                <div class="modal-body font_color">
                  <div id="changeCredit" class="creditDiv" align="center">
                  <h5><b>Extend/Shorten Credit Days for Order #<span id="externId"></span></b></h5>
                  <p><span>Credit Days for this Order :</span><span id="creditAvailable"></span></p>
                  <p><span>Credit Days Available :</span><span id="creditRemaining"></span></p>
                  <input type="text" class="" onkeydown='numbersOnly(event)' id="creditDaysNumber" >
                  <label class="btn btn-primary" onclick="changeCreditDays();">Change Order's Credit Days</label>
                  </div>
                  <div id="triggerCreditalert" class="creditDiv" align="center">
                    <h5><b>Send Credit Payment Alert</b></h5>
                    <button id="sendCreditAlertBtn" class="btn btn-primary mrg_btm"  onclick="sendCreditAlert();">Send Alert</button>
                    <p id="lastCreditAlert"><b>Last credit alert on:&nbsp&nbsp&nbsp</b><span id="alertDate"></span></p>
                    <p><b>Note:</b> Customers and Finance Team will receive an alert</p>
                  </div>
                  <input type="hidden" value="" id="hiddenOrderId">                    
                </div>
            </div>
    </div>
</div>

<!-- to show the customers details for the finance-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="finance_customer_order" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title" id="modal-heading">Order Details</h4>
      </div>
        <div class="modal-body" id="statusorders"> 
            <table class="table general-table"  ><!--<table class="table table-hover general-table">-->
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

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="confirm" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
    <!--<div id="confirm" class="modal hide">-->
      <div class="modal-body">
        Do you want to change the status of order #<span id="order_id_confirm"></span>
      </div>

      <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Yes</button>
      <button type="button" data-dismiss="modal" class="btn">NO</button>
      </div>
    </div>
  </div>
</div>
<form action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('finance-login.php&FinanceLogout');?>
" method="POST" id="logoutForm"></form>
<script src="finance/js/finance-index.js"></script>
<script type="text/javascript">
  var count1='<?php echo count($_smarty_tpl->tpl_vars['finance_order_status_details']->value[1]);?>
';
  var count2='<?php echo count($_smarty_tpl->tpl_vars['purchaseBill']->value);?>
';
</script><?php }} ?>
