<div ng-controller="productUploadCtrl">
	<form name="uploadForm" ng-submit="uploadFile(1)" id="product_upload">
		<fieldset ng-form="innerForm" class="panel-body">
			<div class="m-bot20 col-sm-12">
				<div class="text-center" ng-show="productName">
					<h5><b>Your Product Name:</b> <b class="text-info" id="productFinalName">{{productName.join(" ")}}</b></h5>
				</div>
				<div class="panel">
					<div class="panel-heading">
					    <h4 class="panel-title">
					            Product Attributes
					    </h4>
					</div>
				<div class="col-sm-12 panel">
					<input type="hidden" ng-model="productName" value="{{productName}}" name="productNameObject"></input>
					<textarea type="text" class="display-none" name="product_name">{{productName.join(" ")}}</textarea>
					<div class="col-sm-12 padding10">
						    <div class="col-sm-12 form-group" ng-repeat="data in result[1] track by $index" class="features-block">
						      <label for="custom_{{data.id_feature}}_{{data.id_lang}}" class="col-sm-2 control-label">{{data.name}}
						      	<span ng-if="data.feature_required == 1" class="text-danger">*</span>
						      </label>
						      <div class="col-sm-10">
						      	<div ng-if="data.feature_required == 1" class="input-group">
								  	<textarea type="text" ng-model="data.value" class="custom_{{data.id_feature}}_1 form-control input-sm" rows="1" name="custom_{{data.id_feature}}_value" required placeholder="Enter value">
								  	</textarea>
								  	<span class="input-group-addon"><input type="checkbox" class="check_{{data.id_feature}}_1" ng-model="feature_check_data.id_feature" ng-change="generateName({{data.id_feature}})"/></span>
								</div>
								<div ng-if="data.feature_required == 0" class="input-group">
							      	<textarea type="text" ng-model="data.value" class="custom_{{data.id_feature}}_1 form-control input-sm" rows="1" name="custom_{{data.id_feature}}_value" placeholder="Enter value"></textarea>
							      	<span class="input-group-addon"><input type="checkbox" class="check_{{data.id_feature}}_1" ng-model="feature_check_data.id_feature" ng-change="generateName({{data.id_feature}})"/></span>
							    </div>
						      </div>
						    </div> 
						    <div id="space-for-add-more-attribute"></div>
						    <div class="col-sm-12">
						    	<a class="cur-poi text-info" ng-click="box2=!box2"><i class="fa fa-plus"></i> Click here to Add More</a>
						    	<div class="col-sm-12 panel-body display-none" data-slide-toggle="box2" data-slide-toggle-duration="100">
						    		<div class="col-sm-5 pull-left feature-type-ahead">
					                         <input type="text" typeahead-on-select='appendFeature($item)' placeholder="Search and select feature" class="form-control ng-valid ng-dirty existFeatureAdd" typeahead="feature.name for feature in featuresList($viewValue)" ng-model="selecting" typeahead-wait-ms="delay" aria-autocomplete="list">
						    		</div>
						    		<div class="pull-left col-sm-1"><span class="text-info padding10">(OR)</span></div>
						    		<div class="col-sm-5 pull-left">
						    			<a class="cur-poi text-success" ng-click="box3=!box3">
						    				<i class="fa fa-plus"></i> Click here to Add New Attribute
						    			</a>
						    			<div data-slide-toggle="box3" data-slide-toggle-duration="100" class="panel-body display-none">
						    				<div class="form-group">
						    					<input type="text" value="" ng-model="featureName" name="featureName" class="form-control" placeholder="Enter Attribute Name"/>
						    				</div>
						    				<button type="button" class="btn btn-primary" ng-click="addNewFeature(featureName)">Submit</button>
						    			</div>
						    		</div>
						    	</div>
						    </div> 
						</div>
					</div>
				</div>
			</div>
			<div class="panel-group m-bot20 col-sm-12">
				<div class="panel">
					<div class="panel-heading">
					    <h4 class="panel-title">
					            Product Name and HSN Code
					    </h4>
					</div>
					<div class="panel-body">
						<div class="form-group has-success">
	                        <label class="col-sm-2 control-label col-lg-2" for="customProductName">Product Name</label>
	                        <div class="col-lg-10 col-sm-10">
	                            <input type="text" class="form-control" id="customProductName" ng-model="customProductName" ng-change="createCustomProductName(customProductName)">
	                            <input type="hidden" name="custom_prod_name" value="{{customizedProductName}}"/>
	                            <div class="help-block">
		                        	Note: If you want this block as product name,attribute based name will be skipped.
		                        </div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="col-sm-2 control-label col-lg-2" for="hsnCode">
	                        	HSN Code
	                        	<span class="text-danger">*</span>
	                        </label>
	                        <div class="col-lg-10 col-sm-10">
	                            <input type="text" onkeypress="return isNumber(event)" minlength="4" maxlength="8" value="{{result[0].hsn_code}}" required class="form-control" name="hsnCode" id="hsnCode" ng-model="hsnCode" />
	                        </div>
	                    </div>
	                </div>
				</div>
			</div>
			<!-- <div ng-if="result[0].id_category_default" ng-init="getCategoryPattern(result[0].id_category_default)"></div> -->
			<div class="panel-group m-bot20 col-sm-12">
				<div class="panel-heading">
					
				</div>
				<div class="panel" >
					<div class="panel-heading">
					    <h4 class="panel-title">
					            Price Details
					    </h4>
					    <span class="panel-body pull-left" ng-show="{{edit_product == 0}}">
					    	<input id="edit_price_details" type="checkbox" value="0" ng-click="showPriceDetails();">Add / Edit Price Details	
					    </span>					    
					</div>
					<div ng-init="getTaxGroups()" ng-model="taxGroups" name="taxGroups">
					<div class="panel-body" id="showPriceDetails">
						<!-- <p>
		            		Portal Price: <b class="tar">Rs. {{portalPriceDisplay | isNaN}}</b>
		            	</p> -->
		            	<p>
		            		MRP: <b class="tar">Rs. {{mrpDisplay | isNaN}}</b>
		            	</p>
		            	<span class="help-block">(Note:- Portal price should not be more than MRP)</span>
					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active">
					    	<a href="/#mrpWithTax" aria-controls="mrpWithTax" role="tab" data-toggle="tab">
					    		MRP/Label with Tax
					    	</a>
					    </li>
					    <li role="presentation">
					    	<a href="/#mrpWithoutTax" aria-controls="mrpWithoutTax" role="tab" data-toggle="tab">
					    		MRP/Label without Tax
					    	</a>
					    </li>
					    <li role="presentation">
					    	<a href="/#buyingPriceWithTax" aria-controls="buyingPriceWithTax" role="tab" data-toggle="tab">
					    		Buying Price with Tax
					    	</a>
					    </li>
					    <li role="presentation">
					    	<a href="/#buyingPriceWithoutTax" aria-controls="buyingPriceWithoutTax" role="tab" data-toggle="tab">
					    		Buying Price without Tax
					    	</a>
					    </li>
					  </ul>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="mrpWithTax">
					    	<div class="panel-body">
					    		<div class="col-sm-12 form-group">
							      <label for="mrpWithTax" class="col-sm-3 control-label">MRP / Label</label>
							      <div class="col-sm-8">
							      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="mrpWithTax" ng-model="mrpWithTax" ng-change="mrpriceWithTax(taxGroups, mrpWithTaxGroup, mrpWithTax, mrpWithTaxDiscount, mrpWithTaxMargin, mrpWithTaxBp)" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter MRP">
							      	<div class="text-danger" ng-show="innerForm.mrpWithTax.$error.pattern">
							      		Please enter valid number. (Allowed price format: 11 or 11.22)
							      	</div>
							      </div>
							    </div>
							    <div class="col-sm-12 form-group">
							    	<label for="mrpWithTaxDiscount" class="col-sm-3 control-label">Discount(%) OR BP</label>
								    <div class="col-sm-4">
							      		<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="mrpWithTaxDiscount" ng-model="mrpWithTaxDiscount" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter Discount Percentage( % )" ng-change="mrpriceWithTax(taxGroups, mrpWithTaxGroup, mrpWithTax, mrpWithTaxDiscount, mrpWithTaxMargin, mrpWithTaxBp)">
								      	<div class="text-danger" ng-show="innerForm.mrpWithTaxDiscount.$error.pattern">
								      		Please enter valid number. (Allowed price format: 11 or 11.22)
								      	</div>
							      	</div>
							      	<div class="col-sm-4">
							      		<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="mrpWithTaxBp" ng-model="mrpWithTaxBp" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter Buying Price" ng-change="mrpriceWithTax(taxGroups, mrpWithTaxGroup, mrpWithTax, mrpWithTaxDiscount, mrpWithTaxMargin, mrpWithTaxBp)">
								      	<div class="text-danger" ng-show="innerForm.mrpWithTaxBp.$error.pattern">
								      		Please enter valid number. (Allowed price format: 11 or 11.22)
								      	</div>
							      	</div>
							    </div>
							    <div class="col-sm-12 form-group">
							      <label for="taxGroup" class="col-sm-3 control-label">Tax</label>
							      <div class="col-sm-8">
							      	<select class="form-control input-sm" name="mrpWithTaxGroup" ng-model="mrpWithTaxGroup" ng-change="mrpriceWithTax(taxGroups, mrpWithTaxGroup, mrpWithTax, mrpWithTaxDiscount, mrpWithTaxMargin, mrpWithTaxBp)">
										<option value="" class="ng-binding ng-scope">
											Select Tax Group
										</option>
										<option data-ng-repeat="data in result[3]" value="{{data.id_tax_rules_group}}">{{data.name}}</option>
									</select>
								  </div>
							    </div>
							    <div class="col-sm-12 form-group">
							    	<label for="mrpWithTaxMargin" class="col-sm-3 control-label">Margin in %</label>
								    <div class="col-sm-8">
								      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="mrpWithTaxMargin" ng-model="mrpWithTaxMargin" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter margin percentage( % )" ng-change="mrpriceWithTax(taxGroups, mrpWithTaxGroup, mrpWithTax, mrpWithTaxDiscount,mrpWithTaxMargin, mrpWithTaxBp)">
								      	<div class="text-danger" ng-show="innerForm.mrpWithTaxMargin.$error.pattern">
								      		Please enter valid number. (Allowed price format: 11 or 11.22)
								      	</div>
						    		</div>
						    	</div>
						    </div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="mrpWithoutTax">
					    	<div class="panel-body">
					    		<div class="col-sm-12 form-group">
							      <label for="mrpWithoutTax" class="col-sm-3 control-label">MRP / Label</label>
							      <div class="col-sm-8">
							      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="mrpWithoutTax" ng-model="mrpWithoutTax" ng-change="mrpriceWithoutTax(taxGroups, mrpWithoutTaxGroup, mrpWithoutTax, mrpWithoutTaxDiscount, mrpWithoutTaxMargin)" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter MRP">
							      	<div class="text-danger" ng-show="innerForm.mrpWithoutTax.$error.pattern">
							      		Please enter valid number. (Allowed price format: 11 or 11.22)
							      	</div>
							      </div>
							    </div>
							    <div class="col-sm-12 form-group">
							    	<label for="mrpWithoutTaxDiscount" class="col-sm-3 control-label">Discount in %</label>
								    <div class="col-sm-8">
							      		<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="mrpWithoutTaxDiscount" ng-model="mrpWithoutTaxDiscount" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter Discount Percentage( % )" ng-change="mrpriceWithoutTax(taxGroups, mrpWithoutTaxGroup, mrpWithoutTax, mrpWithoutTaxDiscount, mrpWithoutTaxMargin)">
								      	<div class="text-danger" ng-show="innerForm.mrpWithoutTaxDiscount.$error.pattern">
								      		Please enter valid number. (Allowed price format: 11 or 11.22)
								      	</div>
							      </div>
							    </div>
							    <div class="col-sm-12 form-group">
							      <label for="taxGroup" class="col-sm-3 control-label">Tax</label>
							      <div class="col-sm-8">
							      	<select class="form-control input-sm" name="mrpWithoutTaxGroup" ng-model="mrpWithoutTaxGroup" ng-change="mrpriceWithoutTax(taxGroups, mrpWithoutTaxGroup, mrpWithoutTax, mrpWithoutTaxDiscount, mrpWithoutTaxMargin)">
										<option value="" class="ng-binding ng-scope">
											Select Tax Group
										</option>
										<option ng-selected="{{data.id_tax_rules_group == result[0].id_tax_rules_group}}" data-ng-repeat="data in result[3]" value="{{data.id_tax_rules_group}}">{{data.name}}</option>
									</select>
								  </div>
							    </div>
							    <div class="col-sm-12 form-group">
							    	<label for="mrpWithoutTaxMargin" class="col-sm-3 control-label">Margin in %</label>
								    <div class="col-sm-8">
								      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="mrpWithoutTaxMargin" ng-model="mrpWithoutTaxMargin" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter margin percentage( % )" ng-change="mrpriceWithoutTax(taxGroups, mrpWithoutTaxGroup, mrpWithoutTax, mrpWithoutTaxDiscount, mrpWithoutTaxMargin)">
								      	<div class="text-danger" ng-show="innerForm.mrpWithoutTaxMargin.$error.pattern">
								      		Please enter valid number. (Allowed price format: 11 or 11.22)
								      	</div>
						    		</div>
						    	</div>
						    </div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="buyingPriceWithTax">
					    	<div class="panel-body">
					    		<div class="col-sm-12 form-group">
							      <label for="buyingPriceWithTax" class="col-sm-3 control-label">Buying Price</label>
							      <div class="col-sm-8">
							      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="buyingPriceWithTax" ng-model="buyingPriceWithTax" ng-change="buyPriceWithTax(taxGroups, buyingPriceWithTax, buyingPriceWithTaxGroup, buyingPriceWithTaxMargin)"  ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter MRP">
							      	<div class="text-danger" ng-show="innerForm.buyingPriceWithTax.$error.pattern">
							      		Please enter valid number. (Allowed price format: 11 or 11.22)
							      	</div>
							      </div>
							    </div>
							    <div class="col-sm-12 form-group">
							      <label for="buyingPriceWithTaxGroup" class="col-sm-3 control-label">Tax</label>
							      <div class="col-sm-8">
							      	<select class="form-control input-sm" name="buyingPriceWithTaxGroup" ng-model="buyingPriceWithTaxGroup" ng-change="buyPriceWithTax(taxGroups, buyingPriceWithTax, buyingPriceWithTaxGroup, buyingPriceWithTaxMargin)">
										<option value="" class="ng-binding ng-scope">
											Select Tax Group
										</option>
										<option ng-selected="{{data.id_tax_rules_group == result[0].id_tax_rules_group}}" data-ng-repeat="data in result[3]" value="{{data.id_tax_rules_group}}">{{data.name}}</option>
									</select>
								  </div>
							    </div>
							    <div class="col-sm-12 form-group">
							    	<label for="buyingPriceWithTaxMargin" class="col-sm-3 control-label">Margin in %</label>
								    <div class="col-sm-8">
								      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="buyingPriceWithTaxMargin" ng-model="buyingPriceWithTaxMargin" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter margin percentage( % )" ng-change="buyPriceWithTax(taxGroups, buyingPriceWithTax, buyingPriceWithTaxGroup, buyingPriceWithTaxMargin)">
								      	<div class="text-danger" ng-show="innerForm.buyingPriceWithTaxMargin.$error.pattern">
								      		Please enter valid number. (Allowed price format: 11 or 11.22)
								      	</div>
						    		</div>
						    	</div>
						    </div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="buyingPriceWithoutTax">
					    	<div class="panel-body">
					    		<div class="col-sm-12 form-group">
							      <label for="buyingPriceWithoutTax" class="col-sm-3 control-label">Buying Price</label>
							      <div class="col-sm-8">
							      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="buyingPriceWithoutTax" ng-model="buyingPriceWithoutTax" ng-change="buyPriceWithoutTax(taxGroups, buyingPriceWithoutTax, buyingPriceWithoutTaxGroup, buyingPriceWithoutTaxMargin)" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter MRP">
							      	<div class="text-danger" ng-show="innerForm.buyingPriceWithoutTax.$error.pattern">
							      		Please enter valid number. (Allowed price format: 11 or 11.22)
							      	</div>
							      </div>
							    </div>
							    <div class="col-sm-12 form-group">
							      <label for="buyingPriceWithTaxGroup" class="col-sm-3 control-label">Tax</label>
							      <div class="col-sm-8">
							      	<select class="form-control input-sm" name="buyingPriceWithoutTaxGroup" ng-model="buyingPriceWithoutTaxGroup" ng-change="buyPriceWithoutTax(taxGroups, buyingPriceWithoutTax, buyingPriceWithoutTaxGroup,buyingPriceWithoutTaxMargin)">
										<option value="" class="ng-binding ng-scope">
											Select Tax Group
										</option>
										<option ng-selected="{{data.id_tax_rules_group == result[0].id_tax_rules_group}}" data-ng-repeat="data in result[3]" value="{{data.id_tax_rules_group}}">{{data.name}}</option>
									</select>
								  </div>
							    </div>
							    <div class="col-sm-12 form-group">
							    	<label for="buyingPriceWithoutTaxMargin" class="col-sm-3 control-label">Margin in %</label>
								    <div class="col-sm-8">
								      	<input type="text" onkeypress="return isNumber(event)" class="form-control input-sm" name="buyingPriceWithoutTaxMargin" ng-model="buyingPriceWithoutTaxMargin" ng-pattern="/^[0-9]+(?:\.[0-9]{1,4})?$/" placeholder="Enter margin percentage( % )" ng-change="buyPriceWithoutTax(taxGroups, buyingPriceWithoutTax, buyingPriceWithoutTaxGroup, buyingPriceWithoutTaxMargin)">
								      	<div class="text-danger" ng-show="innerForm.buyingPriceWithoutTaxMargin.$error.pattern">
								      		Please enter valid number. (Allowed price format: 11 or 11.22)
								      	</div>
						    		</div>
						    	</div>
						    </div>
						</div>
					  </div>
					  <div class="help-block fa fa-info-circle ">Please fill all the relevant fields to change the price / TAX details. </div>    					  
					</div>
					<div class="panel-body">
						<!-- Price details -->
					  <div class="col-md-12 form-group">
					  	<div class="row form-group">
					  		<label class="col-md-3">Wholesale Price :</label><span class="col-md-9"><input class="form-control" value="{{result[0].wholesale_price}}" type="text" disabled=""/></span>	
					  	</div>
					  	<div class="row form-group">
					  		<label class="col-md-3">Price(Tax Excl.) :</label><span class="col-md-9"><input class="form-control" value="{{result[0].price}}" type="text" disabled=""/></span>	
					  	</div>
					  	<div class="row form-group">
					  		<label class="col-md-3">Tax Rule :</label><span class="col-md-9" name="tax_rules" ng-repeat="data in result[3]" ng-show="{{data.id_tax_rules_group == result[0].id_tax_rules_group}}"><input class="form-control" value="{{data.name}}" type="text" disabled=""/></span>	
					  	</div>
					  	<div class="row form-group">
					  		<label class="col-md-3">Discount Amount :</label><span class="col-md-9"><input class="form-control" value="{{reduction_amount}}" type="text" disabled=""></span>	
					  	</div>					  	
					  </div>
					</div>
					</div>
				</div>
			</div>
			<div class="panel-group m-bot20 col-sm-12">
				<div class="panel">
					<div class="panel-heading m-bot20">
					    <h4 class="panel-title">
					            Product Description and Images
					    </h4>
					</div>
					<div class="col-sm-12 m-bot20">
						<div class="form-group">
							<label for="shortDescriptions" class="col-sm-3 control-label">Short Description</label>
						    <div class="col-sm-9">
						    	<textarea class="form-control" ng-model="result[0].description_short" id="shortDescriptions" name="shortDescription" placeholder="Enter short description here."></textarea>
				    		</div>
						</div>
					</div>
					<div class="col-sm-12 m-bot20">
						<div class="form-group">
							<label for="longDescriptions" class="col-sm-3 control-label">Long Description</label>
						    <div class="col-sm-9">
						    	<div id="mytoolbar"></div>
						    	<textarea class="form-control" rows="4" ng-model="result[0].description" id="longDescriptions" name="longDescription" placeholder="Enter paragraph here.( Dot seperated sentence )"></textarea>
				    		</div>
						</div>
					</div>
					<div class="col-sm-12 m-bot20">						
			            <div class="form-group" data-ng-repeat="data in result[5]" >
			            	<span>
			            		<img ng-src={{data.image}} width="108" height="108">
		            		</span>
		            		<span>
								<input type="button" ng-click="removeProductImage($event, data.id_image)" class="btn btn-danger" value="Delete this image">
								</input>
		            		</span>
		            	</div>				        
					<div class="form-group">
							<label for="imageUrls" class="col-sm-3 control-label">Image URL</label>
						    <div class="col-sm-9">
						    	<div id="mytoolbar"></div>
						    	<textarea class="form-control" rows="2" id="imageUrls" name="imageUrls" placeholder="Enter multiple images url seperated by double dots( .. )."></textarea>
				    		</div>
						</div>
						<div class="form-group">
							<div class="col-sm-3"></div>
							<div class="col-sm-9">
				    			<div class="checkbox pull-left">
				    				<label><input type="checkbox" name="delete_existing_images" id="delete_existing_images"> Delete Existing Images.</label>
				    			</div>
				    		</div>
						</div>
					</div>
					<div class="col-sm-12 padding10">
						<label for="imageUrls" class="col-sm-3 control-label">Image Upload</label>
						<div class="col-sm-12 last">	                        
	                        <!--<div ng-repeat="input in inputs" class="col-md-3">
	                            <div class="fileupload fileupload-new" data-provides="fileupload"><input type="hidden" value="" name="">
	                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
	                                    <img src="img/catalog-no-image.png" alt="">
	                                </div>
	                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 10px;"></div>
	                                <div>
	                                           <span class="btn btn-white btn-file">
	                                           <span class="fileupload-new btn-sm"><i class="fa fa-paper-clip"></i> Select image</span>
	                                           <span class="fileupload-exists btn-sm"><i class="fa fa-undo"></i> Change</span>
	                                           <input type="file" class="default" name="image_file" id="" file-model="myFile" custom-on-change="loadFileData($file)" multiple>
	                                           </span>
	                                    <button class="btn btn-danger btn-sm fileupload-exists" id="removeImage" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</button>
	                                </div>
	                            </div>
	                        </div>-->	                        
	                        <div class="row upload-image">
	                        	<span ng-if="!files" class="col-md-2 upload">
	                        		<img src="img/catalog-no-image.png" >
	                        	</span>
	                        	<span class="col-md-2" ng-repeat="file in files">
							      <img height="100px" ng-src="{{file.url}}" />
							      <p>{{file.name}}</p>
							    </span>	
	                        </div>
	                        <div class="row browse">
	                        	<input type="file" ng-file-model="files" multiple />
                        	</div>
	                        <div class="col-md-12 note-label">
								<span class="label label-danger">NOTE!</span>
								<span>
								Attached image thumbnail is
								supported in Latest Firefox, Chrome, Opera,
								Safari and Internet Explorer 10 only
								</span>
							</div>
	                    </div>
					</div>
				</div>
			</div>
			<div class="panel-group m-bot20 col-sm-12">
				<div class="col-sm-12 m-bot20">
					<button type="submit" class="btn btn-primary btn-sm col-sm-4 col-sm-offset-4 padding10">Submit</button>
				</div>
				<div class="padding5" ng-repeat="data in errors track by $index">
					<p class="errors">* {{data}}</p>
				</div>
				<input type="hidden" id="ajaxType" value="8" name="type">
				<input type="hidden" value="{{result[0].id_category_default}}" name="category" ng-model="product.category">
				<input type="hidden" ng-model="taxExclusive" value="{{taxExclusive}}" name="taxExclusive"/>
				<input type="hidden" ng-model="wholesalePrice" value="{{wholesalePrice}}" name="wholesalePrice"/>
				<input type="hidden" ng-model="portalPrice" value="{{portalPrice}}" name="portalPrice"/>
				<input type="hidden" ng-model="taxId" value="{{taxId}}" name="taxId">
			</div>
		</fieldset>
	</form>
</div>