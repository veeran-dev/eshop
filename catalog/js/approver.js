mainApp.config(['$routeProvider', function($routeProvider) {
   $routeProvider.
   
   when('/', {
      templateUrl: 'catalog/partials/approver/approver-home.tpl',
      controller: 'homeController'
   }).

   when('/products/:status/:type/waiting', {
      templateUrl: 'catalog/partials/common/product-status.tpl',
      controller: 'productStatusController'
   }).
   
   when('/products/:status/:type/approved', {
      templateUrl: 'catalog/partials/common/product-status.tpl',
      controller: 'productStatusController'
   }).

   when('/products/:status/:type/live', {
      templateUrl: 'catalog/partials/common/product-status.tpl',
      controller: 'productStatusController'
   }).

   when('/products/:status/:type/rejected', {
      templateUrl: 'catalog/partials/common/product-status.tpl',
      controller: 'productStatusController'
   }).

   otherwise({
      redirectTo: '/'
   });
}])
.controller('homeController', function($scope,$http) {
   $http.get('approver-ajax.php',{params:{type:1}}).then(function(response) {
      $scope.result = response.data;  
   });
})
.controller('productStatusController', function($scope,$http, $routeParams, $timeout) {
      $('.ajaxLoaderModal').show();
      $scope.result = [];
       $http.get('approver-ajax.php',{params:{type: 2, id_product_state: $routeParams.status, status_type: $routeParams.type}}).then(function(response) {
        if((response.data).length > 0)
        {
          for(var i=0; i < (response.data).length; i++){
            for(var j = 0; j < (response.data[i]).length; j++){
              $scope.result.push(response.data[i][j]);
            }
          }

          $scope.currentPage = 1; //current page
          $scope.entryLimit = 10; //max no of items to display in a page
          $scope.filteredItems = $scope.result.length; //Initially for no filter  
          $scope.totalItems = $scope.result.length;
          $scope.token=admin_token;
          $scope.admin_role=admin_role;
          $scope.id_employee = id_employee;
          $scope.load = true;
        }
        else{
          $scope.load = false;
        }

        $scope.status = $routeParams.status;
        $('.ajaxLoaderModal').hide();
        
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

      if($routeParams.status == 4)
          $scope.rejected = true;
      $scope.approve = 1;
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
         $http.get('approver-ajax.php',{params:{type:3,id_product:idProduct,id_product_state:2}}).then(function(response) {
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

          $http.get('approver-ajax.php',{params:{type:15,"product_array[]":product_array,id_product_state:2}}).then(function(response) {
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
});