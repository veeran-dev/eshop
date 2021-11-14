mainApp.config(['$routeProvider', function($routeProvider) {
   $routeProvider.
   
   when('/', {
      templateUrl: 'catalog/partials/qc/qc-home.tpl',
      controller: 'homeController'
   }).

   when('/products/:status/waiting', {
      templateUrl: 'catalog/partials/common/product-status.tpl',
      controller: 'productStatusController'
   }).

   when('/products/:status/live', {
      templateUrl: 'catalog/partials/common/product-status.tpl',
      controller: 'productStatusController'
   }).

   when('/products/:status/rejected', {
      templateUrl: 'catalog/partials/common/product-status.tpl',
      controller: 'productStatusController'
   }).

   when('/category/attribute/settings', {
      templateUrl: 'catalog/partials/qc/qc-attribute-settings.tpl',
      controller: 'settingsController'
   }).

   when('/category/naming/rules', {
      templateUrl: 'catalog/partials/qc/qc-category-naming.tpl',
      controller: 'settingsController'
   }).

   otherwise({
      redirectTo: '/'
   });
}])
.controller('homeController', function($scope,$http) {
   $http.get('approver-ajax.php',{params:{type:5}}).then(function(response) {
      $scope.result = response.data; 
   });
})
.controller('productStatusController', function($scope,$http,$routeParams) {
   $http.get('approver-ajax.php',{params:{type: 4,id_product_state: $routeParams.status}}).then(function(response) {
      if((response.data).length > 0)
      {
        $scope.result = response.data; 
        $scope.currentPage = 1; //current page
        $scope.entryLimit = 10; //max no of items to display in a page
        $scope.filteredItems = $scope.result.length; //Initially for no filter  
        $scope.totalItems = $scope.result.length;
        $scope.token=admin_token;
        $scope.id_employee = id_employee;
        $scope.load = true;
      }
      else
      {
        $scope.load = false;
      }
      $scope.status = $routeParams.status;
   });

   $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() { 
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };

    $('.checkAll').click(function(){
          if(this.checked) 
          { 
          // check select status
            $('.check_all_ref').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
          }
          else
          {
              $('.check_all_ref').each(function() { //loop through each checkbox
                  this.checked = false; //deselect all checkboxes with class "checkbox1"                       
              });         
          }
    });
})
.controller('productViewController', function($scope, $http, $routeParams) {
       $scope.showFeature = function(idProduct){
             $http.get('catalog-ajax.php', {
                  params: {
                      type: 7,
                      id_product: idProduct
                  }
              }).then(function(response) {
                  $scope.result = response.data;
                  $('#product_features,#product_name').html('');
                  $('#product_name').html($scope.result[0].name[1]);
                  for(var i=0; i < ($scope.result[1]).length; i++)
                    $('#product_features').append('<tr>\
                                                      <td>'+$scope.result[1][i].name+'</td>\
                                                      <td>'+$scope.result[1][i].value+'</td>\
                                                  </tr>');
                  $('#view_feature').modal('show');
              });
        };
    })
.controller('productActionController', function($scope, $http, $routeParams, toastr, $location, $route) {
       $scope.approveProduct = function(idProduct){
         $http.get('approver-ajax.php',{params:{type:3,id_product:idProduct,id_product_state:3,live_state:1}}).then(function(response) {
            if(response.data == 0){
               toastr.success('Product Approved Successfully.');
               $route.reload();
           }
         });
       };

       $scope.rejectProduct = function(idProduct, rejectReason){
         $http.get('approver-ajax.php',{params:{type:3,id_product:idProduct,id_product_state:4,reject_reason:rejectReason}}).then(function(response) {
            if(response.data == 0){
               toastr.success('Product Rejected Successfully.');
               $route.reload();
            }
         });
       };

       $scope.approveProductAll = function(idProduct){
          var product_array = [];
          $('.check_all_ref:checked').each(function(){
              product_array.push(this.value);
          });

          $http.get('approver-ajax.php',{params:{type:15,"product_array[]":product_array,id_product_state:3,live_state:1}}).then(function(response) {
              if(response.data == 0){
                 toastr.success('Products Approved Successfully.');
                 $route.reload();
             }
           });
       };

       $scope.rejectProductAll = function(idProduct){
        var product_array = [];
        $('.check_all_ref:checked').each(function(){
              product_array.push(this.value);
        });

        $http.get('approver-ajax.php',{params:{type:15,"product_array[]":product_array,id_product_state:4}}).then(function(response) {
            if(response.data == 0){
               toastr.success('Products Rejected Successfully.');
               $route.reload();
            }
         });
       };
})
.controller('settingsController', function($scope, $http, $routeParams, toastr, $location) {
    $http.get('approver-ajax.php',{params:{type:10}}).then(function(response) {
        $scope.categories = response.data;
    });
})
.controller('loadCategorySettingsController', function($scope, $http, $routeParams, toastr, $location) {
    $scope.getAttributes = function(id_category){
        $http.get('approver-ajax.php',{params:{type:11,id_category:id_category}}).then(function(response) {
            $scope.attributes = response.data;
            $scope.showSettings = true;
        });
    };

    $scope.setAttribute = function(id_category,id_feature){
       $http.get('approver-ajax.php',{params:{type:14,id_category:id_category,id_feature:id_feature,featureStatus:$('#attribute_'+id_feature).is(':checked'),featureRequired:$('#attribute_required_'+id_feature).is(':checked')}}).then(function(response) {
       });
    };

    $scope.getCategoryFeatures = function(id_category){
      $http.get('approver-ajax.php',{params:{type:12,id_category:id_category}}).then(function(response) {
          $scope.attributes = response.data;
          if($scope.attributes[0].length > 0)
            $scope.features = true;
          else
            $scope.features = false;

          if($scope.attributes[1][0] == null)
            $scope.attributes[1] = [{'id_feature':19,'name':'Brand'}];

          $scope.list1 = $scope.attributes[0];
          $scope.list2 = $scope.attributes[1];
      });
    };

    $scope.sortableOptions = {
        connectWith: '.connectedList',
        placeholder: 'placeholder',
        dropOnEmpty: true,
        update: function(event, ui) {
          // on cross list sortings recieved is not true
          // during the first update
          // which is fired on the source sortable
          if (!ui.item.sortable.received) {
            var originNgModel = ui.item.sortable.sourceModel;
            var itemModel = originNgModel[ui.item.sortable.index];
            
            // check that its an actual moving
            // between the two lists
            if (originNgModel == $scope.attributes[0] &&
                ui.item.sortable.droptargetModel == $scope.attributes[1]) {
              var exists = !!$scope.attributes[1].filter(function(x) {return x.name === itemModel.name }).length;
              if (exists) {
               ui.item.sortable.cancel(); 
              }
            }
          }
        }
    };

  $scope.setNamingRule = function(elem, id_category){
    
    var rule_array = [];

    $('.'+elem).each(function(index, obj) {
        if(obj.value != "")
          rule_array.push(obj.value);
    });

    $http.get('approver-ajax.php',{params:{type:13,id_category:id_category,pattern:rule_array.join("$")}}).then(function(response) {
          if(response.data == 'true')
          {
            toastr.success('Pattern Created Successfully.');
          }
          else
          {
            toastr.success('Error in pattern creation. Contact Tech Team for further action');
          }
    });

  };

});