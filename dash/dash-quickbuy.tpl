 <div id="quick-buy" class="row">
    <div class="col-xs-12 col-md-12">
        <div class="col-xs-8 col-md-8">
       		<h5 >Product Name or Code </h5>
        	<input id="focusedInput" class="form-control  dash-search-box"  onKeyPress="toHideEmptyResult();" placeholder="Search for products from your contract"  type="text" tabindex="1">
        	<div id="quickbuy-product-not-found" class="pro"><span id="product-not-found-span">Product not found.</span></div>
            <div id="quickbuy-processing">Processing........
                <div class="progress progress-striped active progress-sm">
                    <div style="width:100%; color:#1FB5AD;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success">
                    	<span class="sr-only">100% Complete</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-2 col-md-1">
        	<h5 class="tex-ali-cen">Quantity</h5>
        	<input id="dash-corporate-user-quantity-value" class="form-control tex-ali-cen dash-search-box dash-corporate-user-quantity-value" value="1" type="text" maxlength="4" tabindex="2" />
         </div>
        <div class="col-xs-2 col-md-3">
		
            <a id="dash-corporate-user-add-to-cart"   class="btn btn-primary">ADD<i class="fa fa-arrow-right"></i></a>
            <!--<a id="quickbuy-add-to-cart" onClick="loadAddressPage();" class='btn btn-primary'>NEXT</a>-->
        </div> 
     </div>
        <!--<div class="col-xs-12 col-md-6">
    	<section class="panel  margin-align-bottom">
		<div class="panel-body  padding-align-bottom">
        	<div class="top-stats-panel">
           		<div id="quick-buy-list" > 
				<table id="quick-buy-table"   class="table  table-hover general-table">
				<thead>
				<tr >
                <th  >Product Name </th>
                <th class="tex-ali-cen" >Quantity</th>
                <th >Price</th>
                <th >Delete</th>
                </tr>
                </thead>
                <tbody id="quickbuy-list-body" role="alert" aria-live="polite"  aria-relevant="all">
      
                </tbody>
                </table>
 
            </div> 
		</div>
     </div>
     </section>
     </div>-->         
     <!-- <a id="quickbuy-add-to-cart" onClick="loadAddressPage();" class='btn btn-primary'>Place Order</a>-->
           
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
          
          <script type="text/javascript" src="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}dash/js/dash-quickbuy.js"></script>
