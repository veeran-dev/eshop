<header class="rm_heading">ADD PRODUCTS TO RATE CONTRACT</header>
<!--<div id="pick-customer" class="row">
	<div class="col-xs-12 col-md-6">
		 <div class="btn-group selectlist">
			<button class="btn btn-primary buttonColor dropdown-toggle" type="button" data-toggle="dropdown">
			<span id="listTitle">Select a Customer</span><span class="caret cust_caret"></span>
		  </button>
		  <ul role="menu" class="dropdown-menu" id="lists"></ul>
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
                            <select id="customer_selection" class="populate placeholder select2-offscreen form-control" tabindex="-1" title="" name="customer_selection" onchange="setselectCustomer(3);" required>
                            		<option value="0">Select User</option>
                             </select>
							 
                    </div>
                    
                   
				</div>
			</div>
		</div>
		
		
	</section>
</div>
<div id="add_products" class="row col-lg-12 col-md-12 successSearch">
	<div class="panel">
    	<section class="panel-body">
        	<div class="col-xs-12 col-md-12  panel-body" id="rm-ratecontract" >	
            	<!--<div class="col-lg-3 col-md-4 col-sm-2 col-xs-2">
      				<select id="list_title_select" class="form-control input-sm m-bot15" onchange="displayProduct(1);">
          			</select> 
        		</div>-->
        		<div class="col-lg-6 col-md-4">
                	<input id="type_product" class="form-control add_products_input" placeholder="Add products to the list from catalogue " type="text" disabled="disabled"/>
					<div id="quickbuy-product-not-found" class="pro"><span id="product-not-found-span">Product not found.</span>
                	</div>
            		<div id="quickbuy-processing">Processing........
                	<div class="progress progress-striped active progress-sm">
                    <div style="width:100%; color:#1FB5AD;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success">
                    		<span class="sr-only">100% Complete</span>
                    </div>
                	</div>
            		</div>
          		</div>
      			<div class="col-xs-4 col-md-3 col-sm-1 col-lg-2">
                	<input class="form-control specific_price" name="specificprice" id="specific_price" placeholder="customer price" data-toggle="tooltip" title="Enter tax excl price" type="text" disabled="disabled"/>
                </div>
        		<div class="col-lg-1 col-md-1 btn-group" id="addproduct_div">
            		<a class="btn btn-primary"  class="heightSelectButton" onclick="addProductsToList();" id="btn_addproduct">Add</a>
 				</div> 
       			</div>
				<!--<div>
					<a href="#" id="addNewProductButtonthird" onClick="addNewProductFromSearch();" href="#addNewProductFromSearch" data-toggle="modal" class="btn btn-success kob_button addNewProdExpressthird priceincart">Add Product - Express</a>
				</div>-->
			
          </section>
	</div>
 </div>

 	
     <header class="rm_heading successSearch" id="product_heading"></header>
        <div id="products_display" class="successSearch task-info row col-md-12 col-xs-12 col-lg-12 col-sm-12 side-graph-info">
			<div class="panel">
			<section class="panel-body">
            	<div class="top-stats-panel" id="product_table">
					<table id="list-products-table" class="table general-table">
                  		<thead>
                      	 <tr>
                         	<th>Product Code</th>
                          	<th>Product Name</th>
                            <th>Product Price(tax exc)</th>
      						<th>Actions</th>
                         </tr>
                   		</thead>
                     	<tbody id="products_in_list" role="alert" aria-live="polite"  aria-relevant="all">
                  		</tbody>
                   	</table>
          		</div>
 			
        </section>
	</div>
  </div>

  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="addNewProductFromSearch" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content" id="addNewProductExContent">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                <h4 class="modal-title">Add New Product - Express</h4>
                            </div>
                            <div class="modal-body">

                                <form id="createNewProdEx" name="createNewProdEx" onSubmit="createNewProductExpress(3); return false;">
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

  
                  
 
<script type="text/javascript" src="dash/js/dash-quickbuy.js"></script>
<script type="text/javascript" src="rm/js/rm-index.js"></script>
<script type="text/javascript" src="rm/js/rm-addproduct.js"></script>
<script type="text/javascript">

$(document).ready( function() {
	//getCustomerList(3);
	getGroups(3);
	$('#group_selection, #customer_selection').select2();
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
  });
});
</script>