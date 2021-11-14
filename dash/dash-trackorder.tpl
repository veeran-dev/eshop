<script src="dash/js/dash-order.js"></script>

<div >

<!--Start of products in purchase list-->
<div class="col-sm-6" >
  <section class="panel" id="list_of_products">
    <header class="panel-heading no-border" id="list_heading"> Track Your Orders</header>
    <div id="orders_list">
      <table class="table  table-hover general-table table-striped" id="orders_list">
        <thead>
          <tr >
			<th>Month Of Order</th>
			<th>Order ID</th>
            <th>Date Of Order</th>
          </tr>
        </thead>
        <tbody id="listOfOrders">
        </tbody>
      </table>
    </div>
    <div aria-hidden="true" aria-labelledby="timeline_history" role="dialog" tabindex="-1" id="timeline_history" class="modal fade">
        <div class="modal-dialog popup-width">
          <div class="modal-content col-sm-12" id="history_popup">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" >Order Id : <span id="order_id"></span></h4>
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
            <div class="modal-footer">
            	<div id="reorder_button"></div>
              <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<div class="col-sm-6" id="trackOrder" style="display:none" >
  <section class="">
      <header class="panel-heading no-border" id="list_heading">Tracking Details</header>
      <div id="timelinediv">
       	<div class="timeline"></div>
       </div>
       
  </section>
</div>
 