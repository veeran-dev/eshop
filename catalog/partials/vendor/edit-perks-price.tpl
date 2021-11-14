<script type="text/javascript" src="js/autoCompSearch.js"></script>
<section class="panel">
	<header class="panel-heading">
		Add / Edit Perks Competitor Price
	</header>
	<div class="panel-body">		
		<form ng-controller="perksPriceForm" ng-submit="addPrice()">
			<div class="form-group col-md-12">
				<div class="col-md-4">
					<label>Search Product</label>
					<div class="form-group">
						<div class="">
							<input class="form-control" ng-keyPress="processing()" placeholder="Search Product" type="text" id="searchPerks" ng-model="searchPerks" />
							<div class="pro productNotFound display-none"><span>Product not found.</span></div>
			                <div ng-model="quotation-processing" id="quotation-processing" class="display-none">
			                    Processing........
			                    <div class="progress progress-striped active progress-sm">
			                        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="45" role="progressbar" class="progress-bar progress-bar-success progress-bar-quote">
			                            <span class="sr-only">100% Complete</span>
			                        </div>
			                    </div>
			                </div>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<label>Amazon</label>
					<input type="number" class="form-control" ng-model="amazon">
				</div>
				<div class="col-md-2">
					<label>Flipkart</label>
					<input type="number" class="form-control" ng-model="flipkart">
				</div>
				<div class="col-md-2">
					<label>Snapdeal</label>
					<input type="number" class="form-control" ng-model="snapdeal">
				</div>
				<div class="col-md-2 ptop-22">
					<input type="hidden" class="form-control" ng-model="idProduct" id="idProduct">
					<button type="submit" class="btn btn-success">Add</button>
				</div>
			</div>
		</form>
		<table id="perks_price_table" class="table table-inverse">
			<thead>
				<tr>
					<th>S.No</th>
					<th class="col-md-1">Product ID</th>
					<th class="col-md-4">Product Name</th>
					<th>Amazon</th>
					<th>Flipkart</th>
					<th>Snapdeal</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="perks_price_table_body">
				<tr ng-repeat="details in companiesDetail">
					<td ng-model="">{{$index+1}}</td>
					<td>
                        <input type="text" class="form-control text-center" ng-model="details.id_product" readonly />
                    </td>
                    <td>
                        <input type="text" class="form-control text-center" ng-model="details.name" readonly />
                    </td>
                    <td>
                        <input type="text" class="form-control text-center" ng-model="details.amazon" readonly/>
                    </td>
                    <td>
                        <input type="text" class="form-control text-center" ng-model="details.flipkart" readonly/>
                    </td>
                    <td>
                        <input type="email" class="form-control text-center" ng-model="details.snapdeal" readonly/>
                    </td>
                    <td>
                    	<input type="hidden" class="form-control text-center" ng-model="details.id_competitors" readonly/>
                    	<span class="fa fa-trash-o" ng-click="delete(details.id_competitors)" data={{details.id_competitors}}></span>
                    </td>
                </tr>
			</tbody>
		</table>
	</div>		
</section>