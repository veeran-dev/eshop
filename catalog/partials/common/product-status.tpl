<p class="text-center" ng-hide="load == true || load == false">
   <i class="fa fa-cog fa-spin fa-3x fa-fw"></i>
   <span class="text-center animated infinite fadeOut">Loading data. Please wait...</span>
</p>
<section class="panel">
    <header class="panel-heading"  ng-if="status == 1 || status == 0">
        Products Waiting for Approval
    </header>
    <header class="panel-heading"  ng-if="status == 2">
        Products for QC Approval 
    </header>
    <header class="panel-heading"  ng-if="status == 3">
        Products In Live
    </header>
    <header class="panel-heading"  ng-if="status == 4">
        Products Rejected
    </header>
    <div class="panel-body" ng-if="load == true">
        <div class="row m-bot20">
            <div class="col-md-6" ng-show="filteredItems > 0">    
                <div pagination="" max-size="8" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
            </div>
            <div class="col-md-1 padding5" ng-show="filteredItems > 0">PageSize:
                <select ng-model="entryLimit" class="form-control input-sm">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                    <option>100</option>
                </select>
            </div>
            <div class="col-md-2 padding5" ng-show="filteredItems > 0">Filter:
                <input type="text" ng-model="search" ng-change="filter()" placeholder="Filter" class="form-control input-sm" />
            </div>
            <div class="col-md-3" ng-controller="productActionController" ng-show="status == 1 || status == 2 && !approve">
                <div class="m-top21">
                    <a  ng-click="approveProductAll(data.id_product)" ng-model="data.id_product" ng-show="filteredItems > 0">
                        <button type="button" class="btn btn-success btn-sm">Approve
                            <i class="fa fa-check" title="Approve"></i>
                        </button>
                    </a>
                    <a ng-click="rejectProductAll(data.id_product)" ng-show="filteredItems > 0">
                        <button type="button" class="btn btn-danger btn-sm">Reject
                            <i class="fa fa-times cur-poi" title="Reject"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <section>
            <table class="table table-striped table-condensed cf no-more-tables">
                <thead class="cf">
                <tr>
                    <th>&nbsp;<input type="checkbox" name="checkAll" class="checkAll" ng-click="checkAll($event)"/></th>
                    <th>Reference&nbsp;<a ng-click="sort_by('reference');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th>Product Name&nbsp;<a ng-click="sort_by('name');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th>Category&nbsp;<a ng-click="sort_by('category');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">MRP&nbsp;<a ng-click="sort_by('mrp');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">BP(W/T)&nbsp;<a ng-click="sort_by('wholesale_price');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">Margin&nbsp;<a ng-click="sort_by('margin');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">SP(W/T)&nbsp;<a ng-click="sort_by('selling_price_without_tax');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">Tax&nbsp;<a ng-click="sort_by('rate');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">SP(T)&nbsp;<a ng-click="sort_by('selling_price');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">Status&nbsp;<a ng-click="sort_by('product_status');"><i class="glyphicon glyphicon-sort cur-poi"></i></a></th>
                    <th class="numeric">Feature</th>
                    <th class="numeric">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="data in filtered = (result | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit">
                    <td data-title="select"><input type="checkbox" name="check_{{data.id_product}}" value="{{data.id_product}}" class="check_{{data.id_product}} check_all_ref"/></td>
                    <td data-title="Reference">{{data.reference}}</td>
                    <td data-title="Product Name">{{data.name}}</td>
                    <td data-title="Category">{{data.category}}</td>
                    <td class="numeric" data-title="MRP"><i class="fa fa-inr"></i>{{data.mrp | round}}</td>
                    <td class="numeric" data-title="Buying Price"><i class="fa fa-inr"></i>{{data.wholesale_price | round}}</td>
                    <td class="numeric" data-title="Margin">{{data.margin | round_full}}%</td>
                    <td class="numeric" data-title="SP(Without Tax)"><i class="fa fa-inr"></i>{{data.selling_price_without_tax | round}}</td>
                    <td class="numeric" data-title="Tax">{{data.rate | round}}%</td>
                    <td class="numeric" data-title="SP(With Tax)"><i class="fa fa-inr"></i>{{data.selling_price | round}}</td>
                    <td class="numeric" data-title="Status">
                        {{data.product_status}}
                    </td>
                    <td class="numeric" data-title="View">
                        <div ng-controller="productViewController">
                            <a class="cur-poi" ng-click="showFeature(data.id_product)">
                                <i class="fa fa-eye text-primary" title="View Features"></i> Feature
                            </a>
                        </div>
                        <div ng-show="id_employee && token">
                            <a class="cur-poi" href="index.php?id_product={{data.id_product}}&controller=product&adtoken={{token}}&ad=kobster_admin&id_employee={{id_employee}}">
                                <i class="fa fa-eye " title="View Features"></i> Preview
                            </a>
                        </div>
                    </td>
                    <td class="numeric" data-title="View" ng-show="data.id_product_state != 3 && data.id_product_state != 4">
                        <a href="#products/{{data.id_product}}/edit" ng-show="data.id_product_state == 1 || {{admin_role}}">
                            <i class="fa fa-edit text-info" title="Edit"></i>
                        </a>
                        <span ng-controller="productActionController" ng-show="status == 1 || status == 2 && !approve">
                            <a  ng-click="approveProduct(data.id_product)" ng-model="data.id_product">
                                <i class="fa fa-check text-success cur-poi" title="Approve"></i>
                            </a>
                            <a ng-click="box1=!box1">
                                    <i class="fa fa-times text-danger cur-poi" title="Reject"></i>
                            </a>
                            <div class="div1 display-none" data-slide-toggle="box1" data-slide-toggle-duration="100" >
                                <textarea class="form-control" ng-model="rejectReason">
                                    
                                </textarea>
                                <div class="padding10"></div>
                                <button type="button" class="btn btn-primary pull-right" ng-click="rejectProduct(data.id_product, rejectReason)" ng-model="data.id_product">
                                    Submit
                                </button>
                            </div>
                        </span>
                    </td>
                    <td class="numeric" ng-show="data.id_product_state == 3 || data.id_product_state == 4">
                        <a href="" ng-click="box2=!box2" ng-show="data.id_product_state == 4">
                            <i class="fa fa-envelope text-info" title="Comment"></i>
                        </a>
                        <a href="#products/{{data.id_product}}/edit" class="pull-right">
                            <i class="fa fa-edit text-info" title="Edit"></i>
                        </a>
                        <div class="div1 display-none" data-slide-toggle="box2" data-slide-toggle-duration="100" >
                            <textarea class="form-control" value={{data.comment}} disabled="true">                                
                            </textarea>
                        </div>
                        
                    </td>
                </tr>    
                </tbody>
            </table>
        </section>
        <div class="row">
            <div class="col-md-12" ng-show="filteredItems > 0">    
                <div pagination="" max-size="8" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" previous-text="&laquo;" next-text="&raquo;"></div>
            </div>
        </div>
    </div>
    <div class="panel-body" ng-if="load == false">
        <div class="row">
            <div class="panel">
                <h5 class="text-center text-danger">No data available here.</h5>
            </div>
        </div>
    </div>
</section>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="view_feature" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h3 class="modal-title text-center text-primary modal-text-font">Features of <b id="product_name"></b></h3>
                </div>
                <div class="modal-body">
                    <table class="table no-more-tables">
                        <thead>
                            <th>Feature Name</th>
                            <th>Value</th>
                        </thead>
                        <tbody id="product_features"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="button" name="cancel" data-dismiss="modal" class="btn btn-default" value="OK" />
                </div> 
            </div>
        </div>
    </div>
</div>