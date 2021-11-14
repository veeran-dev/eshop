<header class="panel-heading">Product Buying History</header>
<div class="panel">
    <div class="panel-body">
		<div class="row">
		  <div class="col-sm-12">
			  <section id="" class="panel-body">
				<div class="col-sm-8">
					<input type="text" placeholder="Search Product" id="search_product_history"  class="form-control">
					<div id="quickbuy-product-not-found" class="pro form-control"><span id="product-not-found-span">Product not found.</span></div>
					<div id="quickbuy-processing"> 
	                    Processing........
						<div class="progress progress-striped active progress-sm">
							<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success progress-bar-quote">
								<span class="sr-only">100% Complete</span>
							</div>
						</div>
					</div>
					<div class="help-block"><strong >Product Name :</strong> <strong id="product_name"></strong></div>
				</div> 
				<div class="col-sm-4">
					<select class="form-control" id="fulFillmentCentreProdHistory" onchange="productHistoryData()"></select>
				</div>
			  </section>
		  </div>
	  </div>	  
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">
				Buying Price<br>
				<i class="fa fa-arrow-down label label-warning"> Rs. <span id="low_cost"></span></i>
				<i class="fa fa-arrow-up label label-danger"> Rs. <span id="high_cost"></span></i>
			</header>
			<div class="panel-body" id="product_history_table">
				<table class="table table-hover general-table" id="id_product_history">
				  <thead>
					<tr>
					  <th>Bill No</th>
					  <th>Vendor</th>
					  <th>Date</th>
					  <th>Quantity</th>
					  <th>Unit Price</th>
					</tr>
				  </thead>
				  <tbody id="product_history">
				  </tbody>
				</table>
			</div>
		
		</section>
	</div>
	<div class="col-sm-6">
		<section class="panel">
			<header class="panel-heading">Price Flow </header>
			<div class="panel-body" class="product_history_container">
				<div id="product_history_Container"></div>
			</div>
		</section>
	</div>
</div>
<input type="hidden" id="prodHistIdProduct" name="prodHistIdProduct"/>
<link rel="stylesheet" type="text/css" href="dash/css/style.css">
<script type="text/javascript" src="scn/js/scn-producthistory.js"></script>