<div ng-controller="loadCategorySettingsController">
    <div class="row">
        <div class="panel-body">
            <div class="col-sm-4">
               <select class="form-control" name="category" id="category" ng-model="category" ng-change="getAttributes(category)">
                   <option value="">Select Category</option>
                   <option ng-repeat="category in categories" value="{{category.id_category}}">{{category.name}}</option>
               </select>
            </div>
        </div>
    </div>
    <div class="row" ng-show="showSettings == true">
        <div class="panel-body">           
            <div class="features">
                <div class="col-sm-6">
                    <div class="top-stats-panel">
                        <div class="panel">
                            <table class="table table-stripped no-more-tables">
                                <thead>
                                    <tr>
                                        <th>Attribute Name</th>
                                        <th>Assign</th>
                                        <th>Required</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="attribute in attributes">
                                        <td data-title="Attribute Name">
                                            {{attribute.name}}
                                        </td>
                                        <td data-title="Assign">
                                            <input type="checkbox" id="attribute_{{attribute.id_feature}}" ng-checked="attribute.feature_required == 0 || attribute.feature_required == 1" name="setToCategory_{{attribute.id_feature}}" ng-click="setAttribute(category,attribute.id_feature)"/>
                                        </td>
                                        <td data-title="Required">
                                            <input type="checkbox" id="attribute_required_{{attribute.id_feature}}" name="checkBox_{{attribute.id_feature}}" ng-checked="attribute.feature_required == 1" ng-click="setAttribute(category,attribute.id_feature)"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>