mainApp.config(['$routeProvider', function($routeProvider) {
        $routeProvider.

        when('/', {
            templateUrl: 'catalog/partials/vendor/home.tpl',
            controller: 'homeController'
        }).

        when('/products/:status/:type/live', {
            templateUrl: 'catalog/partials/common/product-status.tpl',
            controller: 'productStatusController'
        }).

        when('/products/:status/:type/waiting', {
            templateUrl: 'catalog/partials/common/product-status.tpl',
            controller: 'productWaitingVendorController'
        }).

        when('/products/:status/:type/rejected', {
            templateUrl: 'catalog/partials/common/product-status.tpl',
            controller: 'productStatusController'
        }).

        otherwise({
            redirectTo: '/'
        });
    }])
    .controller('homeController', function($scope, $http) {
        $http.get('catalog-ajax.php', {
            params: {
                type: 1
            }
        }).then(function(response) {
            $scope.result = response.data;
        });
    })
    .controller('productUploadController', ['$scope', '$routeParams', '$http', function($scope, $routeParams, $http) {
        $http.get('catalog-ajax.php', {
            params: {
                type: 2
            }
        }).then(function(response) {
            $scope.result = response.data;
        });
    }])
    .controller('productsController', function($scope, $http) {
        $http.get('catalog-ajax.php', {
            params: {
                type: 6
            }
        }).then(function(response) {
          if((response.data).length > 0)
          {
            $scope.result = response.data;
            $scope.currentPage = 1; //current page
            $scope.entryLimit = 10; //max no of items to display in a page
            $scope.filteredItems = $scope.result.length; //Initially for no filter  
            $scope.totalItems = $scope.result.length;
            $scope.load = true;
          }
          else{
            $scope.load = false;
          }
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
    .controller('productEditController', function($scope, $routeParams, $http) {
        $http.get('catalog-ajax.php', {
            params: {
                type: 7,
                id_product: $routeParams.productId
            }
        }).then(function(response) {
            $scope.result = response.data;
            $scope.customProductName = $scope.result[0].name[1];
            $scope.result[0].description = $($scope.result[0].description).text();
            $scope.reduction_amount=$scope.result[6].reduction;
            $scope.tax_rules = $scope.result[0].id_tax_rules_group;
            $scope.mrpWithoutTaxGroup = $scope.result[0].id_tax_rules_group;
            $scope.edit_product = 1;
            $('#showPriceDetails').toggle();
            $('#editProduct').val("1");
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
    .controller('productWaitingVendorController', function($scope,$http, $routeParams) {
         $http.get('catalog-ajax.php',{params:{type:9}}).then(function(response) {
          if((response.data).length > 0)
          {
            $scope.result = response.data; 
            $scope.currentPage = 1; //current page
            $scope.entryLimit = 10; //max no of items to display in a page
            $scope.filteredItems = $scope.result.length; //Initially for no filter  
            $scope.totalItems = $scope.result.length;
            $scope.load = true;
          }
          else{
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
    .controller('fessCntrl', function($scope) {})
    .controller('productActionController', function($scope, $http, $routeParams, toastr, $location) {})
    .controller('productStatusController', function($scope,$http,$routeParams) {
         $http.get('catalog-ajax.php',{params:{type:6,id_product_state:$routeParams.status}}).then(function(response) {
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
            else{
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
      });