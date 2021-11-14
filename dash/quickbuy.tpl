<script type="text/javascript" src="../js/quickbuy.js"></script>

	<div id="quick-buy" class="row">
		<div class="col-xs-12 col-md-8">
				<div class="col-xs-8 col-md-8">
                <h6>Type </h6>
                <input id="focusedInput" class="form-control dash-search-box"  onKeyPress="tohideemptyresult();" placeholder="Search"  type="text">
                <div id="quickbuy-product-not-found" class="pro"> Product not found.</div>
                <div id="quickbuy-processing">Processing........
                <div class="progress progress-striped active progress-sm">
				<div style="width:100%; color:#1FB5AD;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" 
                class="progress-bar progress-bar-success">
				<span class="sr-only">100% Complete</span>
                </div>
				</div>
				</div>
                </div>
                <div class="col-xs-2 col-md-2">
                <h6>Quantity</h6>
         		<input id="dash-corporate-user-quantity-value" class="form-control dash-search-box dash-corporate-user-quantity-value"   
                value="1" type="text" maxlength="4" />
                
                </div>
                <div class="col-xs-2 col-md-2">
               <a id="dash-corporate-user-add-to-cart"   class="btn btn-primary ">ADD
                 <i class="fa fa-arrow-right"></i>
                 </a>
                </div> 
        </div>
    
		<div class="col-xs-12 col-md-4">
           <div id="quick-buy-list" > 
				<table id="quick-buy-table" class="table  table-hover general-table">
				<thead>
				<tr >
                <th  >Product Name </th>
                <th >Quantity</th>
                <th >Price</th>
                <th >Delete</th>
                </tr>
                </thead>
                <tbody id="quickbuy-list-body" role="alert" aria-live="polite"  aria-relevant="all">
                </tbody>
                </table>
            </div>
           <a id="quickbuy-add-to-cart" onClick="loadnewpage();" class='btn btn-primary'>ADD TO CART</a>
		</div>
     </div>
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="noproduct" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                  <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Kobster</h4>
                      </div>
   
                      <div class="modal-body">
                      No Products to add
                      </div>
                                <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                      </div>

                  </div>
              </div>
          </div>
          
          
          
          
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="minimumquantity" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                  <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Kobster</h4>
                      </div>
   
                      <div class="modal-body"> 
                      Please, Enter the Minimum  Quantity
                      </div>
                                <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">OK</button>
                      </div>

                  </div>
              </div>
          </div>