<script src="dash/js/dash-order.js"></script>

<div class="row">
  <div class="col-sm-12">
    <section class="panel">
      <header class="panel-heading">Order History</header>
      <div class="panel-body" id="orderHistory1">
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
              <th>Action</th>
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
 

