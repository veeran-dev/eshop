<div class="row">
	<div class="col-lg-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li><a href="#/"><i class="fa fa-home"></i> Home</a></li>
              <li class="active">Add New Product</li>
          </ul>
          <!--breadcrumbs end -->
    </div>
</div>
<div class="row">
	<div class="padding10"></div>
	<div class="col-md-12" ng-controller="fessCntrl">
		<div class="col-md-3">
			<select class="form-control input-sm m-bot15" levelone-creator ng-model="leveloneCreator">
				<option value="">
					Select Category
				</option>
				<option ng-repeat="data in result | orderBy:['name']" value="{{data.id_category}}">{{data.name}}</option>
			</select>
		</div>
		<div class="col-md-3" ng-show="level1 == 1">
			<select class="form-control input-sm m-bot15" leveltwo-creator ng-model="leveltwoCreator">
				<option value="">
					Select Sub Category
				</option>
				<option ng-repeat="data in subcatlevel1 | orderBy:['name']" value="{{data.id_category}}">{{data.name}}</option>
			</select>
		</div>
		<div class="col-md-3" ng-show="level2 == 1">
			<select class="form-control input-sm m-bot15" levelthree-creator ng-model="levelthreeCreator">
				<option value="">
					Select Sub Category
				</option>
				<option ng-repeat="data in subcatlevel2 | orderBy:['name']" value="{{data.id_category}}">{{data.name}}</option>
			</select>
		</div>
		<div class="col-md-3" ng-show="level3 == 1">
			<select class="form-control input-sm m-bot15" levelfour-creator ng-model="levelfourCreator">
				<option value="">
					Select Sub Category
				</option>
				<option ng-repeat="data in subcatlevel3 | orderBy:['name']" value="{{data.id_category}}">{{data.name}}</option>
			</select>
		</div>			
		<div class="col-md-12" ng-show="upload == true">
			<div ng-include="'catalog/partials/product-upload-form.tpl'"></div>
		</div>
	</div>
</div>