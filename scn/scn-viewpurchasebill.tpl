<script src="scn/js/scn-viewpurchasebill.js"></script>
 
<div class="panel">
    <div class="panel-body">
    <section class="panel">
    	<header class="panel-heading">View Purchase Bill</header>
        <table class="table table-striped table-hover table-bordered" id="purchasebils">
            <thead>
                <tr>
                	<th>S.No</th>
                    <th>Bill No</th>
                    <th>Bill Date</th>
                    <th>Vendor Name</th>
                    <th>Payment Mode</th>
                    <th>Total(Tax Excl..)</th>
                    <th class="action">Action</th>
             	</tr>
            </thead>
            <tbody id="bill_view">
            </tbody>
        </table>
     </section>
     <!--pop up for bill details -->
     <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="purchase_bill_details" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title" id="modal-heading">Purchase Bill Details - Bill No <span id="head_bill_no"></span></h4>
          </div>
            <div class="modal-body" id="statusorders"> 
                <table class="table general-table"  ><!--<table class="table table-hover general-table">-->
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Bill No</th>
                            <th>Bill Date</th>
                            <th>Product Name</th>
                            <th>QTY</th>
                            <th>Unit Price</th>
                            <th>Total Price(Tax Excl..)</th>
                            <th>Tax</th>
                            <th class="action">Action</th>
                        </tr>
                    </thead>
                    <tbody id="bill_details"></tbody>
                </table>
            </div>
          <div class="modal-footer">
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">Total (Tax Excl): &nbsp;&nbsp;<b><span id="total_exc">0</span></b></div>
             <div class="col-lg-6 col-md-5 col-sm-5 col-xs-5">Total (Tax Incl):&nbsp;&nbsp;<b><span id="total_inc">0</span></b></div>
             <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><button data-dismiss="modal" class="btn btn-default" type="button">OK</button></div>
                
                
                
          </div>
        </div>
      </div>
    </div>
     
     
  </div>
</div>
 <script type="text/javascript" src="dash/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="dash/js/data-tables/DT_bootstrap.js"></script>
 
 
