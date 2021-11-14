<div ng-controller="loadCategorySettingsController">
    <div class="row">
        <div class="panel-body">
            <div class="col-sm-4">
               <select class="form-control" name="category" id="category" ng-model="category" ng-change="getCategoryFeatures(category)">
                   <option value="">Select Category</option>
                   <option ng-repeat="category in categories" value="{{category.id_category}}">{{category.name}}</option>
               </select>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="panel-body">
          <div ng-show="features == true">
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-body">
                      <div class="top-stats-panel">
                        <h4 class="widget-h">Attributes</h4>
                        <div ui-sortable="sortableOptions" class="connectedList" ng-model="list1">
                            <div ng-repeat="item in attributes[0]" class="app ui-state-default">{{$index + 1|num}}. {{item.name}}</div>
                            <div ng-show="attributes[0].length==0">&nbsp;</div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-body">
                      <div class="top-stats-panel">
                        <h4 class="widget-h">Naming Rule</h4>
                         <div ui-sortable="sortableOptions" class="connectedList" ng-model="list2" id="sortableOptions">
                            <div ng-repeat="item in attributes[1]" class="app ui-state-default">
                              {{$index + 1|num}}. {{item.name}}
                              <input type="hidden" class="featureIds" value="{{item.id_feature}}">
                            </div>
                            <div ng-show="attributes[1].length==0">&nbsp;</div>
                          </div>
                          <button class="btn btn-primary col-sm-12" ng-click="setNamingRule('featureIds', category)">Save</button>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <div ng-show="features == false">
            <div class="col-sm-12">
              <div class="panel">
                <p class="text-center padding5 text-danger">No Attributes found for the selected category. Please add attributes for the category. <a href="#category/attribute/settings" class="text-info">Click here</a> to add attributes.</p>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div>
</div>