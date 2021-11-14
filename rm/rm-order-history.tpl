<header class="rm_heading">ORDERS HISTORY FOR CUSTOMERS</header>
 <!--<div id="pick-customer" class="row">
	<div class="col-xs-12 col-md-6">
		 <div class="btn-group selectlist">
		  <button class="btn btn-primary buttonColor dropdown-toggle padding" type="button" data-toggle="dropdown">
			<span id="listTitle">Select a Customer</span><span class="caret cust_caret"></span>
		  </button>
		  <ul role="menu" class="dropdown-menu" id="lists"></ul>
		 </div>
	</div>
</div>
</div>-->

<div class="row">
  <section class="panel-body">
    <div class="col-xs-12 col-md-12 col-sm-12 panel-body">
      <div class="">
        <div class="">
          <!-- SELECT CUSTOMER GROUP -->
          <div class="form-group col-md-3 col-sm-3 col-xs-3 col-lg-3">
                            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                              <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                                <span class="select2-chosen" id="select2-chosen-3">Select Company</span>
                                <abbr class="select2-search-choice-close"></abbr>
                                <span class="select2-arrow" role="presentation">
                                  <b role="presentation"></b>
                                </span>
                              </a>
                              <label for="s2id_autogen3" class="select2-offscreen"></label>
                              <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3"></div>
                            <select id="group_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="group_id" onchange="getCustomer()" required>
                                <option value="0">Select Company</option>
                             </select>
                    </div>
                    <!-- SELECT CUSTOMER WITH EMAIL ID -->
          <div class="form-group col-md-7 col-sm-7 col-xs-7 col-lg-7">
                            <div class="select2-container populate placeholder js-example-basic-single js-states form-control select2-hidden-accessible" id="s2id_e2">
                              <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1">   
                                <span class="select2-chosen" id="select2-chosen-3">Select Customer</span>
                                <abbr class="select2-search-choice-close"></abbr>
                                <span class="select2-arrow" role="presentation">
                                  <b role="presentation"></b>
                                </span>
                              </a>
                              <label for="s2id_autogen3" class="select2-offscreen"></label>
                              <input class="select2-focusser select2-offscreen form-control" type="text" aria-haspopup="true" role="button" aria-labelledby="select2-chosen-3" id="s2id_autogen3"></div>
                            <select id="customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="customer_selection" onchange="setselectCustomer(8);" required>
                                <option value="0">Select User</option>
                             </select>
               
                    </div>
                    
                   
        </div>
      </div>
    </div>
    
    
  </section>
</div>
<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      <div class="panel-body successSearch" id="orderHistory">
      	<header class="panel-heading">Order History</header>
        <table class="table table-hover general-table"  id="customer_orders">
          <thead>
            <tr>
              <th>Month Of Order</th>
			        <th> Order ID</th>
              <th>Date</th>
              <th>Total Price</th>
              <th>Credit Days</th>
              <th>Payment Mode</th>
              <th>Status</th>
              <th>PDF Invoice</th>
            </tr>
          </thead>
          <tbody id="order_history">
          </tbody>
        </table>
      </div>
      <div aria-hidden="true" aria-labelledby="status_history" role="dialog" tabindex="-1" id="status_history" class="modal fade">
        <div class="modal-dialog popup-width">
          <div class="modal-content col-sm-12" id="history_popup">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" >Order id : <span id="order_id"></span></h4>
            </div>
             <div id="orderflow"></div>
             <div class="row">
              <div class="col-sm-6 orderAddress" id="billingAddress"></div>
              <div class="col-sm-6 orderAddress" id="deliveryAddress"></div>
            </div>
             <div class="row" id="detail_order"> 
                <table class="table table-hover general-table">
                  <thead>
                    <tr>
                    <th>S.no</th>
                      <th>Reference</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Unit price</th>
                      <th class="price">Total prices</th>
                    </tr>
                  </thead>
                  <tbody id="productsTable">
                  </tbody>
                </table>
            </div>
            <div class="modal-footer Reorder">
            	<div id="reorder_button"></div>
              <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
          </div>
        </div>
      </div>
     </section>
  </div>
</div>

<script type="text/javascript" src="dash/js/table-editable.js"></script>
<script type="text/javascript" src="dash/js/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript">
$('#group_selection, #customer_selection').select2();
$(document).ready( function() {
	/*getCustomerList(8);*/
  getGroups(8);
});
</script>
