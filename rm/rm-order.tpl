 <div id="quick-buy" class="row">
    <div class="col-xs-12 col-md-12 col-sm-12 col-xs-12">
            <div class="col-xs-8 col-md-8">
                <h5 >Product Name or Code </h5>
                <input id="focusedInput" class="form-control  dash-search-box"  onKeyPress="toHideEmptyResult();" placeholder="Search"  type="text" tabindex="1">
                <div id="quickbuy-product-not-found" class="pro">
                    <span id="product-not-found-span">
                        Product not found.
                    </span>
                </div>
            
                <div id="quickbuy-processing">Processing........
                    <div class="progress progress-striped active progress-sm">
                        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" 
                            class="progress-bar progress-bar-success progress_bar_rm">
                            <span class="sr-only">100% Complete</span>
                        </div>
                    </div>
                </div>
                
                <div id="search_options">
                    <span>
                        <a href="#" id="rateContractSearchButton" onClick="searchRateContract();" class="btn btn-primary kob_button_white">Rate Contract</a>
                        <a href="#" id="catalogueSearchButton" onClick="searchEntireCatalogue();" class="btn btn-primary kob_button">Catalogue</a><br /><br />
                    </span>
                    <!--<span>
                        <a href="#" id="addNewProductButton" onClick="addNewProductFromSearch();" href="#addNewProductFromSearch" data-toggle="modal" class="btn btn-success kob_button addNewProdExpress">Add Product - Express</a>
                    </span>-->
                </div>
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addNewProductFromSearch" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" id="addNewProductExContent">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Add New Product - Express</h4>
                            </div>
                            <div class="modal-body">

                                <form id="createNewProdEx" name="createNewProdEx" onSubmit="createNewProductExpress(1); return false;">
                                    <div class="form-group">
                                        <label for="productName">Product Name</label>
                                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter Product Name" required="">
                                        <p class="help-block">Format: &lt;Brand Name&gt; &lt;Product Name&gt; &lt;Product Code&gt; &lt;Colour, Size, Volume&gt;</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="priceTI">MRP (Rs.) (Tax Incl.)</label>
                                        <input type="text" class="form-inline" id="priceTI" name="priceTI" placeholder="Enter the MRP" required="">
                                        
                                        <label for="id_tax_rules_group">Tax Group</label>
                                        <select name="id_tax_rules_group" id="id_tax_rules_group" class="form-inline input-sm m-bot15" required="">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="mrp">Customer Price (Rs.) (Tax Excl.)</label>
                                        <input type="text" class="form-inline" name="custPrice" placeholder="Enter the Customer Price" >
                                    </div>
                                    <div class="form-group">											
                                        <label for="purlist">Add to Purchase List?</label>
                                        <select id="purlist" name="purlist" class="form-inline input-sm m-bot15" >
                                            <option value="0">Select</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="customerId" id="customerId" />
                                    <input type="hidden" name="priceTE" id="priceTE" />
                                    <button type="submit" class="btn btn-success">Create Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>			
             <div class="col-xs-2 col-md-1">
                <h5 class="tex-ali-cen">Quantity</h5>
                <input id="dash-corporate-user-quantity-value" class="form-control tex-ali-cen dash-search-box dash-corporate-user-quantity-value" value="1" type="text" maxlength="4" tabindex="2" />
             </div>
            <div class="col-xs-2 col-md-2">
                <a id="dash-corporate-user-add-to-cart"  class="btn btn-primary">ADD<i class="fa fa-arrow-right"></i>
                </a>
            </div> 
    </div>
</div>
<div class="right-sidebar">
  <div class="right-stat-bar">
     <div class="target-sell target_sell_rm"> </div>
               
              <div class="noHover">
                <section class="panel shoppingCartHeight" >
                  <header class="panel-heading">Products</header>
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
                      <tbody id="shopping_cart" class="shopping_cart_rm"></tbody>
                      <thead>
                        <tr>
                            <th>Shipping</th>
                            <th></th>
                            <th id="shopping_shipping">0</th>
                            <th></th>
                         </tr>
                         <tr>
                            <th>Tax</th>
                            <th></th>
                            <th id="shopping_tax">0</th>
                             <th></th>
                          </tr>
                         <tr>
                            <th >Total</th>
                             <th colspan="3" class="shopping_Total">0</th>
                          </tr>
                    </table>
                   </div>
                  <div class="col-md-12 shoppingTotal">
                    <span id="shopping_Total_label" class=" ">Total:</span>
                    <span class="shopping_Total" id="shopping_Total"> </span>
                  </div>
                  <div class="">
                        <input type="button" class="btn btn-success col-xs-12 noRadius" onClick="checkOutProcess()" value="NEXT" />
                    </div>
                 </section>
              </div>
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
<script type="text/javascript" src="dash/js/dash-quickbuy.js"></script>
