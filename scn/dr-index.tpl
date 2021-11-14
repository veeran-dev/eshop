<script language="JavaScript" type="text/javascript" src="js/jSignature.js"></script>
<script src="js/jSignature.CompressorBase30.js"></script>
<script type="text/javascript" src="scn/js/dr-index.js"></script>

<!--<div class="ajaxLoaderModal"></div>-->
<body>
{if $cookie->profile==10}<section>


<div id="dr-header" class="col-sm-12 col-xs-12">
  <div id="dr-home" class="col-sm-2 col-xs-2">
      <a class="fa fa-home btn-group col-sm-3 col-xs-3" href="dr-index.php"></a>
    </div>
    <div id="dr-kobster-logo" class="col-sm-8 col-xs-8" align="center">
      <img src="img/logo.png">
    </div>
    
    <div id="dr-dropdown" class="btn-group col-sm-2 col-xs-2">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
      {$cookie->firstname}
        <span class="caret"></span>
      </button>
      <ul class="col-sm-3 col-xs-3 dropdown-menu dropdown-dr" role="menu">
        <li>
          <a href="scn-login.php?scnLogout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
<div id="index_viewport" class="col-sm-12 col-xs-12 dr-tablet-home">
  <div id="home_icons" class="col-sm-6 col-xs-6">
    <button id="scn_dr_report" class="col-sm-6 col-xs-6 dr-icon btn btn-danger" onclick="searchOrder();"><span class="fa fa-list-alt"></span><span> Delivery Receipt</span></button>
  </div>
</div>
</section>{/if}
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
 
<!--<script src="dash/js/myprofile.js"></script> --> 
<!-- jSignature div-->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="scnDRsign" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h4 class="modal-title">Customer Signature</h4>
      </div>
      <div class="modal-body class_scnDRsign"><div id="drReceiptdiv"></div> <span class='col-sm-6 col-xs-6' id="idscnDRsign"></span>
        <div class='col-sm-12 col-xs-12'>
          <input type='text' id="customer_name" class='form-control ' placeholder='Enter Customers Name'>
        </div>
        <div class='col-sm-12 col-xs-12'>
          <button class='col-sm-3 col-xs-3 btn btn-primary signmargin' onclick="clearData();" type="button">Clear</button>
          <button  class='col-sm-3 col-xs-3 btn btn-primary signmargin' onclick="importData();" type="button">Submit</button>
          
        </div>
       </div>
      <div class="modal-footer error_msg">
      </div>
    </div>
  </div>
</div>
        <!---END-->

