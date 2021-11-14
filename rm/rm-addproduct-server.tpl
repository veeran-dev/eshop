<header class="rm_heading">ADD PRODUCTS TO PURCHASE LIST</header>
<div id="pick-customer" class="row">
	<div class="col-xs-12 col-md-6">
		 <div class="btn-group selectlist">
			<button class="btn btn-primary buttonColor dropdown-toggle" type="button" data-toggle="dropdown">
			<span id="listTitle">Select a Customer</span><span class="caret cust_caret"></span>
		  </button>
		  <ul role="menu" class="dropdown-menu" id="lists"></ul>
	 </div>
	</div>
</div>

<div id="add_products" class="row col-lg-12 col-md-12 successSearch">
	<div class="panel">
    	<section class="panel-body">
        	<div class="col-xs-12 col-md-12  panel-body" id="rm-ratecontract" >	
            	<div class="col-lg-3 col-md-4 col-sm-2 col-xs-2">
      				<select id="list_title_select" class="form-control input-sm m-bot15" onchange="displayProduct();">
          			</select> 
        		</div>
        		<div class="col-lg-5 col-md-4">
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
                	<input class="form-control specific_price" name="specificprice" id="specific_price" placeholder="customer price" type="text" disabled="disabled"/>
                </div>
        		<div class="col-lg-2 col-md-1 btn-group" id="addproduct_div">
            		<a class="btn btn-primary"  class="heightSelectButton" onclick="addProductsToList();" id="btn_addproduct">Add</a>
 				</div> 
       			</div>
          </section>
	</div>
 </div>

 	
     <header class="rm_heading successSearch" id="product_heading"></header>
        <div id="products_display" class="successSearch task-info row col-md-12 col-xs-12 col-lg-12 col-sm-12 side-graph-info">
			<div class="panel">
			<section class="panel-body">
            	<div class="top-stats-panel" id="product_table">
					<table id="list-products-table" class="table table-hover general-table">
                  		<thead>
                    	<tr>
                     		<th>Product Code</th>
                      		<th>Product Name</th>
                            <th>Product Price</th>
                           
                      	</tr>
                   		</thead>
                     	<tbody id="products_in_list" role="alert" aria-live="polite"  aria-relevant="all">
                  		</tbody>
                   	</table>
          		</div>
 			
        </section>
	</div>
  </div>

  
                  
 


<script type="text/javascript" src="rm/js/rm-addproduct.js"></script>
<script type="text/javascript">

$(document).ready( function() {
	//getCustomerList(3);3
	getGroups(3);
	$('#group_selection, #customer_selection').select2();
});
</script>