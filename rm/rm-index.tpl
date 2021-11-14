<div class="ajaxLoaderModal">
  <div class="preloader-animation">
    <div class="gif"></div>
    <p>{l s='Progressing...'}</p>
  </div>
</div>
<section id="container"> 
  <!--header start-->
  <header class="header fixed-top clearfix"> 
    <!--logo start-->
    <div class="brand"> <a href="rm-index.php" class="logo"> <img src="dash/images/kobster_rm.png" alt=""> </a>
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
        <!--<li>
      <input type="text" id="dash_user_search_query_top" class="form-control dash-corporate-user-logo " placeholder="SEARCH OVER 3000 PRODUCTS">
        </li>--> 
        <!--<li>
        <a id="dash_user_search_query_top_button" class="cur-poi"><i class="fa fa-search"></i> </a> </li>--> 
        <!--<form method="get" action="{$link->getPageLink('search.php')}" id="searchbox">
<p>
<label for="search_query_top"><!-- image on background </label>
<input type="hidden" name="orderby" value="position" />
<input type="hidden" name="orderway" value="desc" />
<input class="search_query" type="text" id="search_query_top" name="search_query" value="{if isset($smarty.get.search_query)}{$smarty.get.search_query|htmlentities:$ENT_QUOTES:'utf-8'|stripslashes}{/if}" />
<input type="submit" name="submit_search" value="{l s='Search' mod='blocksearch'}" class="button" />
</p>
</form>--> 
        <!-- user login dropdown start-->
        <li id="top-corporuser-info" class="dropdown dash-corporate-user-logo"> <a data-toggle="dropdown" class="dropdown-toggle dash-corporate-user-logo" href="#"> <img id="corporate-logo"  src="apple-icon-72x72.png" alt="" > <span class="username">{$cookie->firstname}</span> <b class="caret"></b> </a>
          <ul class="dropdown-menu extended logout">
            <!--<li><a href="#myProfile" data-toggle="modal"><i class=" fa fa-suitcase"></i>Change Password</a></li>
            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>-->
            <li><a href="{$link->getPageLink('rm-login.php&RMLogout')}"  title="{l s='LOG OUT'}"><i class="fa fa-key"></i> {l s='Log out'}</a></li>
          </ul>
        </li>
        <!-- user login dropdown end -->
        <li>
        	<span id="total_cart_products" onClick="openShoppingCart(1);">0</span>
          <div  class="toggle-right-box">
            <div class="fa fa-shopping-cart shoppingcart"></div>
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
          <li> <a class="active" href="rm-index.php"> <i class="fa fa-home"></i> <span>Home</span> </a> </li>
		      <li> <a  href="#" onClick="placeRMOrder();"> <i class="fa fa-shopping-cart"></i> <span>Place Orders</span> </a> </li>
          <li class="sub-menu dcjq-parent-li">
            <a href="#" class="cur-poi">
              <i class="fa fa-users"></i>
                Company Configuration
            </a>
            <ul class="sub">
              <li class="sub-menu dcjq-parent-li">
                <a href="#" onclick="cusConfigure(0)" class="cur-poi">New Company & User</a>
              </li>
              <li class="sub-menu dcjq-parent-li">
                <a href="#" class="cur-poi" onclick="cusConfigure(1)">Address</a>
              </li>
               
              <li class="sub-menu dcjq-parent-li">
                <a href="#" class="cur-poi">Verification</a>
                <ul class="sub">
                  <li><a href="#" class="cur-poi sub-sub-menu" onClick="groupVerification(1,0)">Verify Company</a></li>
                  <li><a href="#" class="cur-poi sub-sub-menu" onClick="cusVerification(0)">Verify User</a></li>
                </ul>
              </li>
              <!-- <li class="sub-menu dcjq-parent-li">
                <a href="#" class="cur-poi" onClick="openQuote();">Quotations</a>
              </li> -->
              <li class="sub-menu dcjq-parent-li">
				        <a href="#" class="cur-poi" onClick="openCustomerList();">Rate Contract</a>               
              </li>
              
              <li class="sub-menu dcjq-parent-li">
              <a href="#">Approval System</a>
                <ul class="sub">
                  <li><a href="#" class="cur-poi sub-sub-menu" onclick="cusConfigure(8)">Create Roles</a></li>
                  <li><a href="#" class="cur-poi sub-sub-menu" onclick="cusConfigure(10)">Assign Parent</a></li>
                </ul>
              </li>
			  <li class="sub-menu dcjq-parent-li">
                <a href="#" class="cur-poi" onClick="openCustomerPaymentOption();">Payment Options</a>
              </li>
            </ul>
          </li>
          <li class="sub-menu dcjq-parent-li">
              <a class="cur-poi" href="#">
                  <i class="fa fa-file"></i>
                  <span>RFQ</span>
              </a>
              <ul class="sub">
                  <li class="sub-menu dcjq-parent-li">
                    <a class="cur-poi" href="#" onClick="openQuoteModule();">Quotations</a>
                    <input type="hidden" value="" id="quote_type" name="quote_type" />
                  </li>
              </ul>
          </li>
          <!--
          <li> <a class="cur-poi" href="#" onClick="openCustomerDeals();"> <i class="fa fa-tags"></i> <span>Make Deals</span> </a></li> 
          -->
          <li> <a class="cur-poi" href="#"> <i class="fa fa-bar-chart-o"></i> <span>Reports</span> </a>
            <ul class="sub">
                <li><a class="cur-poi" onClick="reports(1);" >History Report</a></li>
                <li><a class="cur-poi" onClick="reports(2);">Categories Reports</a></li>
                <li><a class="cur-poi" onClick="reports(3);">Top 10 Products Reports</a></li>
                <li><a class="cur-poi" onClick="reports(4);">Location Based Reports</a></li>
                <li><a class="cur-poi" onClick="reports(5);">Detailed History Report</a></li>
                <input type="hidden" value="" id="report_type" name="report_type"/> 
          </ul>
          </li>
          <li> 
                <a class="cur-poi" href="#" onClick="openCatalog();"> <i class="fa fa-tags"></i> <span>Catalog</span> </a>
          </li> 
		      <li> <a class="cur-poi" href="#"> <i class="fa fa-bar-chart-o"></i> <span>Order</span> </a>
				    <ul class="sub">
    				  <!--<li><a class="cur-poi" onClick="orderManagement();" >Order Management</a></li>-->
    				   <li class="sub-menu dcjq-parent-li"> 
    						<a href="#" onclick="openOrders(0,0,50,1,'id_order','DESC',0)"> 
    						  <span>Order Management</span> 
    						</a> 
                </li>
                <li class="sub-menu dcjq-parent-li"> 
                  <a href="#" onclick="openDocs()"> 
                    <span>Download DR / Invoice</span> 
                  </a> 
                </li>
                <li class="sub-menu dcjq-parent-li"> 
                  <a href="#" onclick="openWaterDelivery()"> 
                    <span>Water Delivery</span> 
                  </a> 
                </li>
    				</ul>
          </li>
          <li class="sub-menu"><a class="cur-poi"><i class="fa fa-arrow-circle-down"></i></i><span>Receivables</span> </a> 
            <ul class="sub">
              <li><a class="cur-poi sub-sub-menu" onClick="openPendingPayment();">Pending Payment</a></li>
              <li><a class="cur-poi sub-sub-menu" onClick="openAgingSheet();">Ageing Sheet</a></li>
            </ul>
          </li>
          <li> <a class="cur-poi" onClick="openPerks();" > <i class="fa fa-gift"></i> <span>Perks</span> </a> </li>		  
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
      <!--<section class="panel">
<div class="panel-body">
-->
      <div class="top-stats-panel"  id="index_viewport">
        <div class="col-md-12 col-xs-12">
        <!--**************************************Vendor Details****************************************************************************-->
        <div class="col-md-12">
          <div class="row panel">
              <header class="panel-heading">
                <div class="padding5 paddleft0">
                  <span class="label label-primary pull-left cur-poi padding5" onclick="getCustomerOrders(0)">Refresh</span>
                  Order's Statuses
                </div>
                <form class="form-inline pull-left">
                  <select id="id-fc-rm" onchange="getCustomerOrders(0)" class="form-control"></select>
                </form>
                <div class="clear"></div>
              </header>
              <div class="panel-body">
                <header class="panel-heading">Customer Support</header>
                <table class="table table-hovered table-stripped">
                <thead>
                  <th class="padding5 tex-ali-cen">Order Status</th>
                  <th class="padding5 tex-ali-cen">24 hrs</th>
                  <th class="padding5 tex-ali-cen">48 hrs</th>
                  <th class="padding5 tex-ali-cen">72+ hrs</th>
                </thead>
                <tbody id="order-state-rm">
                  
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
                <tbody id="order-state-scn">
                  
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
                <tbody id="order-state-finance">
                  
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
                <tbody id="order-state-tech">
                  
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
                <tbody id="order-state-other">
                  
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
  <!--right sidebar start--> 
  	<div class="right-sidebar">
      <div class="right-stat-bar">
         <div class="target-sell" style="display:none"> </div>
                   
                  <div class="noHover">
                    <section class="panel shoppingCartHeight" >
                      <header class="panel-heading">Products<!--<span onClick="checkOutProcess()" class="btn btn-success btn-sm task-option">NEXT</span>--></header>
                      <div class="shoppingCartTable">
                        <table class="table general-table shoppingCartList">
                          <thead>
                            <tr>
                                <th>Name</th>
                                <th>QTY</th>
                                <th>Price</th>
                                <th></th>
                             </tr>
                          </thead>
                          <tbody id="rm_shopping_cart">
                          </tbody>
                          <thead id="shopping_detail_rm">
                            <tr>
                                <th>Shipping</th>
                                <th></th>
                                <th id="shopping_shipping_rm">0</th>
                                <th></th>
                             </tr>
                             <tr>
                                <th>Tax</th>
                                <th></th>
                                <th id="shopping_tax_rm">0</th>
                                 <th></th>
                              </tr>
                              <tr>
                                <th>Loyalty Points</th>
                                <th></th>
                                <th id="shopping_loyalty_points_rm">0</th>
                                 <th></th>
                              </tr>
							   
							 <tr>
                                <th >Total</th>
                                
                                <th colspan="3" class="shopping_Total">0</th>
                              </tr>
                              <tr>
                              <th >No. of Products</th>
                                <th></th>
                                <th class="cart_total_rm">0</th>
                                <th></th>
                              </tr>
                              </thead>
                        </table>
                       </div>
                      <div class="col-md-12 shoppingTotal">
                        <span id="shopping_Total_label" class=" ">Total:</span>
                        <span class="shopping_Total" id="shopping_Total"> </span>
                      </div>
                      <div class="cart-clear-block">
                            <a href="#cart-clear-form-rm" data-toggle="modal">
                            <input type="button" id="clear_button_rm" class="btn btn-danger col-xs-5" value="CLEAR CART" />
                            </a>
                            <input type="button" class="btn btn-success col-xs-5 col-xs-offset-2" onClick="checkOutProcess()" id="next_button" value="NEXT" />
                        </div>
                     </section>
                  </div>
                </div>
      </div>
  <!--right sidebar end--> 
</section>
<!--My profile form-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="voucher" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Active Voucher Code</h4>
            </div>
            <div class="modal-body">
                <table id="cart-products-table" class="table  table-hover general-table">
                    <thead>
                    <tr>
                        <th class="col-md-2">Name </th>
                        <th class="col-md-3">Discription </th>
                        <th class="col-md-3">Action</th>
                     </tr>
                    </thead>
                    <tbody id="vouchercode"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
             </div>
        </div>
    </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="rmGlobalAlert" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Alert !</h4>
      </div>
      <div class="modal-body"> <span id="idrmGlobalAlert"></span> </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
      </div>
    </div>
  </div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="rm_customer_order" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title" id="modal-heading">Order Details</h4>
      </div>
        <div class="modal-body" id="statusorders"> 
            <table class="table general-table"  >
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

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="cart-clear-form-rm" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content col-md-6 col-xs-6 col-xs-offset-3 col-md-offset-3 col-sm-offset-3 col-sm-6 cartClearContent">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    ×
                </button>
                <h4 class="modal-title">
              Are you sure want to clear cart ?
            </h4>
            </div>
                <div class="modal-body">
                    <button class="btn btn-success col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-4 col-xs-offset-1" type="button" onclick="cartClear(0)" id="cart-clear-pop-yes-rm">
                        Yes
                    </button>
                    <button class="btn btn-danger col-md-4 col-md-offset-2 col-sm-4 col-sm-offset-2 col-xs-4 col-xs-offset-2" type="button" onclick="cancelSelection()" id="cart-clear-pop-no-rm">
                        No
                    </button>
                    <button class="btn btn-primary modal-close cancel-selection" data-dismiss="modal" style="display:none;">
                        Close
                    </button>
            </div>
        </div>
    </div>
</div>    

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myaddress" class="modal fade">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h4 class="modal-title">Add Address</h4>
    </div>
    <div class="modal-body">
      <form class="form-horizontal" role="form" id="newaddress">
        <div class="form-group">
          <label for="inputEmail1" class="col-sm-2 col-sm-2 control-label"></label>
          <div class="col-sm-8" id="error"></div>
        </div>
        <div class="form-group">
          <label   class="col-sm-2 col-sm-2 control-label">Alias</label>
          <div class="col-sm-10">
            <input type="text" class="form-control myAddress" id="alias"  name="alias" placeholder="Address Name" value=""/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control myAddress" id="firstname"  name="firstname" placeholder="Name" value=""/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Company Name</label>
          <div class="col-sm-10">
            <input type="text" class="form-control myAddress" id="company"  name="company" placeholder="Company Name" value=""/>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 col-sm-2 control-label">Address</label>
          <div class="col-sm-10">
             <textarea class="form-control myAddress" id="address1" name="address1" placeholder="Address"  ></textarea>
             <div class="help-block fa fa-info-circle ">Invalid characters: !<>;?=+()@#"�{}_$%:'</div>    
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword1" class="col-sm-2 col-sm-2 control-label">Pincode</label>
          <div class="col-sm-10">
            <input type="text" class="form-control myAddress" maxlength="6" id="postcode" value="" name="postcode" placeholder="Pincode"/>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword1" class="col-sm-2 col-sm-2 control-label">City</label>
          <div class="col-sm-10">
            <input type="text" class="form-control myAddress" id="city" value="" name="city" placeholder="City">
          </div>
        </div>
       
        <div class="form-group">
          <label for="inputPassword1" class="col-sm-2 col-sm-2 control-label">State</label>
          <div class="col-sm-10">
          	<select class="form-control marginTopBottom input-sm m-bot15 " id="state">
            	<option value="0">--Select State--</option>
            </select>
            <label id="state_error" class="error"></label>
           </div>
        </div>
         <div class="form-group">
          <label for="inputPassword1" class="col-sm-2 col-sm-2 control-label">Country</label>
          <div class="col-sm-10">
           	<select class="form-control marginTopBottom input-sm m-bot15 myAddress" readonly id="country">
            	<option value="110" selected>India</option>
            </select>
          </div>
        </div>
          <div class="form-group">
          <label for="inputPassword1" class="col-sm-2 col-sm-2 control-label">Mobile Number</label>
          <div class="col-sm-10">
            <input type="text" class="form-control myAddress" maxlength="12" id="phone_mobile" value="" name="phone_mobile" placeholder="Mobile Number">
          </div>
        </div>
       </form>
    </div>
    <div class="modal-footer">
            <input type="button" onClick="submitMyAddress();"  class="btn btn-primary" value="Submit"/>
			
        </div>
    </div>
  </div>
  </div>
 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="error_cart" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">The Following products are not added to cart.</h4>
      </div>
      <!-- <div class="modal-body"> <span id="error_cart_heading"></span><span id="error_alert"></span> </div> -->
	  <div class="modal-body">
		<table class="table" >
                  <thead>
                    <tr >
                      <th>Product Name</th>
                      <th>Reason</th>
                     </tr>
                  </thead>
                  <tbody id="listoferrors">
                  </tbody>
        </table>
	  </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        <span id="errorFooter" class="display-none">
          <button onclick="setRegion(2)" class="btn btn-primary" type="button">Continue</button>
        </span>
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

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="rmDealExpiryDate" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content col-md-6 col-xs-6 col-xs-offset-3 col-md-offset-3 col-sm-offset-3 col-sm-6 cartClearContent">
            <div class="modal-header">
                <h4 class="modal-title">Enter Expiry Date:</h4>
            </div>
                <div class="modal-body">                    
                    <input type='text' id="deal-expiry-date" class="form-control datepicker cur-poi" placeholder="to">
                    <label class="btn btn-primary expiryDate" onclick="activateDeal(id_specific_price,id_deal);">OK</label>
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
                    <p id="lastCreditAlert"><b>Last credit alert sent on:&nbsp&nbsp&nbsp</b><span id="alertDate"></span></p>
                    <p><b>Note:</b> Customers and Finance Team will receive an alert</p>
                  </div>
                  <input type="hidden" value="" id="hiddenOrderId">                    
                </div>
            </div>
    </div>
</div> 
<form action="{$link->getPageLink('rm-login.php&RMLogout')}" method="POST" id="logoutForm"></form>
 