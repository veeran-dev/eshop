<script type="text/javascript" src="js/autoCompSearch.js"></script>
<section class="panel">
	<header class="panel-heading">
		Edit Buying Price
	</header>
	<div class="panel-body">
		
		<div class="form-group col-md-12">
			<div class="col-md-8">
				<input class="form-control" ng-keyPress="processing()" placeholder="Search Product" type="text" id="searchProduct" ng-model="searchProduct" />
				<div class="pro productNotFound display-none"><span>Product not found.</span></div>
                <div ng-model="quotation_processing" id="quotation-processing" class="display-none">
                    Processing........
                    <div class="progress progress-striped active progress-sm">
                        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success progress-bar-quote">
                            <span class="sr-only">100% Complete</span>
                        </div>
                    </div>
                </div>
			</div>
		</div>
		<form ng-controller="priceListForm" id="priceListForm" ng-submit="submit()">
			<div class="form-group col-md-12">
				<div ng-repeat="data in regionsDetail track by $index">
					<div class="form-group col-md-12">
						<label for="region_price_{{data.id_fulfillment_centre}}" class="col-md-2">{{data.city_name}}</label>
						<div class="col-md-6">
							<input placeholder="Price (Tax Exclusive)" class="form-control input" type="text" name="region_price_{{data.id_fulfillment_centre}}" id="region_price_{{data.id_fulfillment_centre}}" ng-model="regions['region_'+data.id_fulfillment_centre]" value="" />
						</div>
					</div>
					</div>
				</div>
				<div class="col-md-3">
					<input ng-value="" id="type" ng-model="regions['type']" name="type" class="display-none" />
					<input ng-value="" id="product_id" ng-model="regions['product_id']" class="display-none" name="product_id" />
					<input class="btn btn-success" value="Save & Update" type="submit" />	
				</div>			
			</div>		
		</form>
	</div>
</section>