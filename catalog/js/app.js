var mainApp = angular.module("mainApp", ['ngRoute', 'toastr', 'ui.sortable', 'ui.bootstrap']);
mainApp.$inject = ['$scope'];
/*Should install bower for angular toast message
      sudo npm install -g bower
  	And configuration starts below
 */
mainApp.config(function(toastrConfig) {
  angular.extend(toastrConfig, {
    autoDismiss: false,
    containerId: 'toast-container',
    maxOpened: 0,    
    newestOnTop: true,
    positionClass: 'toast-top-center',
    preventDuplicates: false,
    preventOpenDuplicates: false,
    target: 'body', allowHtml: false,
    closeButton: false,
    closeHtml: '<button>&times;</button>',
    extendedTimeOut: 1000,
    iconClasses: {
      error: 'toast-error',
      info: 'toast-info',
      success: 'toast-success',
      warning: 'toast-warning'
    },  
    messageClass: 'toast-message',
    onHidden: null,
    onShown: null,
    onTap: null,
    progressBar: false,
    tapToDismiss: true,
    templates: {
      toast: 'directives/toast/toast.html',
      progressbar: 'directives/progressbar/progressbar.html'
    },
    timeOut: 2000,
    titleClass: 'toast-title',
    toastClass: 'toast',
    showMethod: 'fadeIn',
  	hideMethod: 'fadeOut'
  });
})
.config(function($httpProvider){
  $httpProvider.interceptors.push(function($q) {
    return {
     'request': function(config) {
         $('.ajaxLoaderModal').show();
         return config;
      },

      'response': function(response) {
         $('.ajaxLoaderModal').hide();
         return response;
      }
    };
  });

  $httpProvider.defaults.timeout = 30000;
  
})
.filter('num', function() {
    return function(input) {
      return parseInt(input, 10);
    };
})
.filter('round', function(){
    return function(input){
         return Math.round(input * 100) / 100;
    };
})
.filter('round_full', function(){
    return function(input){
        return Math.round(input);
    };
})
.filter('isNaN', function() {
    return function(input) {
      if(isNaN(input) || input < 1) {return 0;}else{return input;}
    };
})
.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
})
.directive('slideToggle', function() {  
  return {
    restrict: 'A',      
    scope:{
      isOpen: "=slideToggle"
    },  
    link: function(scope, element, attr) {
      var slideDuration = parseInt(attr.slideToggleDuration, 10) || 200;      
      scope.$watch('isOpen', function(newVal,oldVal){
        if(newVal !== oldVal){ 
          element.stop().slideToggle(slideDuration);
        }
      });
    }
  };  
})
.directive('fileModel', ['$parse', function($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function() {
                scope.$apply(function() {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}])
.service('fileUpload', ['$http', '$timeout', '$location', '$window', 'toastr', 
    function($http, $timeout, $location, $window, toastr) {
    this.uploadFileToUrl = function(file, uploadUrl, id_product, uploadStay, scope, pattern) {
        var fd = new FormData();
        var ajaxType = $('#ajaxType').val();
        angular.forEach(file, function (item) {
            fd.append('file[]', item._file);
        });
        fd.append('id_product', id_product);
        fd.append('uploadStay', uploadStay);

        var longDescription = $('#longDescriptions').val();
        if(longDescription != "")
        {
            var long_desc_html = "";
            var long_desc_html = "<ul>";

            angular.forEach(longDescription.split('.'), function(data) {
                if(data != "")
                    long_desc_html += "<li><span style='font-size:13px;'>"+data+".</span></li>";
            });

            fd.append('longDesc', long_desc_html);
        }

        postData = $('#product_upload').serialize();
        angular.forEach(postData.split('&'), function(data) {
            data = data.split('=');
            var value = decodeURIComponent(data[1].split('+').join(' '));
            fd.append(data[0], value);
        });

        var edit_product = $('#edit_price_details').val();

        if((scope.portalPriceDisplay == 0 || isNaN(scope.portalPriceDisplay || scope.portalPriceDisplay == 'undefined')) && (ajaxType == 5 || edit_product==1)){
            toastr.error("Portal price can't be blank.");
        }
        else if((scope.portalPriceDisplay > scope.mrpDisplay) && (ajaxType == 5 || edit_product==1)){
            toastr.error("Portal price should be less than MRP.");
        }
        else if(scope.productName == "" && $('#customProductName').val() == "" && (ajaxType == 5 || edit_product==1)){
            toastr.error("Product name can't be blank.");
        }
        else
        {
            $http.post(uploadUrl, fd, {
                    transformRequest: angular.identity,
                    headers: {
                        'Content-Type': undefined
                    }
                })
                .success(function(data) {
                    if (data == 1) {
                        $("#product_upload").find("input[type='text'],textarea,select").val('');
                        scope.productName = [],scope.portalPriceDisplay = "",scope.mrpDisplay = "";
                        $timeout(function() {
                            angular.element('#removeImage').trigger('click');
                        }, 1);
                        toastr.success('Product Uploaded Successfully.');

                    } else if (data == 2) {
                        $("#product_upload").find("input[type='text'],select").val('');
                        scope.portalPriceDisplay = "",scope.mrpDisplay = "";
                        $timeout(function() {
                            angular.element('#removeImage').trigger('click');
                        }, 1);
                        toastr.success('Product Uploaded Successfully.');

                    } else if (data == 3) {
                        toastr.success('Product Updated Successfully');
                        $window.history.back();
                    }
                    else if(data && data.length > 0) {
                        scope.errors = data;
                    }
                })
                .error(function() {});
        }
    }
}])
.controller('productUploadCtrl', ['$scope', 'fileUpload', '$routeParams', '$http', '$compile', 'toastr', function($scope, fileUpload, $routeParams, $http, $compile, toastr) {
    $('#group_selection').select2();

    $scope.errors = [];

    $scope.uploadFile = function(clear, pattern) {
        var file = $scope.files;
        
        var id_product = $routeParams.productId;
        var uploadUrl = "catalog-ajax.php";
        fileUpload.uploadFileToUrl(file, uploadUrl, id_product, clear, $scope, pattern);
    };

    $scope.setUploadType = function(type){
        if(type == 1)
            $scope.clear = true;
        else
            $scope.clear = false;

    };
    $scope.getTaxGroups =  function(){
         $http.get('approver-ajax.php',{params:{type:9}}).then(function(response) {
            $scope.taxGroups = response.data;
        });
    };
    $scope.showPriceDetails = function(){
            $('#showPriceDetails').toggle();
            var edit_count = $('#edit_price_details').val();
            if(edit_count == 1)
            {
                $('#edit_price_details').val("0");
            }
            else
            {
                $('#edit_price_details').val("1");   
            }

        }

    $scope.mrpriceWithTax = function(taxGroups, mrpWithTaxGroup, mrpWithTax, mrpWithTaxDiscount, mrpWithTaxMargin, mrpWithTaxBp){
        if(mrpWithTaxGroup != "")
        {
            angular.forEach(taxGroups, function(data, key) {if(key == mrpWithTaxGroup)$scope.taxRate = data;});
            //calculate tax exclusive price
            $scope.taxExclusive = $scope.numRound(((parseFloat(mrpWithTax) * 100) / (100 + parseFloat($scope.taxRate))));

            //calculate wholesale price
            if(parseFloat(mrpWithTaxBp) >= 0 &&  mrpWithTaxBp != "")
            {
                mrpWithTaxDiscount = $scope.numRound((1 - parseFloat(mrpWithTaxBp)/parseFloat(mrpWithTax)) * 100);
                if(mrpWithTaxDiscount == 100)
                    mrpWithTaxDiscount = 0;
            }

            if(isNaN(mrpWithTaxMargin)) {
                mrpWithTaxMargin = 0;
            }

            if(isNaN(mrpWithTaxBp)) {
                mrpWithTaxBp = 0;
            }

            $scope.wholesalePrice1 = $scope.numRound(parseFloat($scope.taxExclusive) - (parseFloat(mrpWithTaxDiscount) / 100) * parseFloat($scope.taxExclusive));
            if(mrpWithTaxBp)
                $scope.wholesalePrice = $scope.numRound((parseFloat(mrpWithTaxBp)));
            else
                $scope.wholesalePrice = $scope.wholesalePrice1;

            $scope.mrpDisplay = parseFloat(mrpWithTax);
            //calculate portal price
            $scope.portalPrice1 = $scope.numRound($scope.wholesalePrice1 + $scope.wholesalePrice1 * (parseFloat(mrpWithTaxMargin)/100));
            $scope.portalPriceDisplay = $scope.numRound(parseFloat($scope.portalPrice1) * ((parseFloat($scope.taxRate)/100) + 1));
            $scope.portalPrice = $scope.numRound(parseFloat(mrpWithTax) - parseFloat($scope.portalPriceDisplay));

            //set tax group
            $scope.taxId = mrpWithTaxGroup;
        }
    };

    $scope.mrpriceWithoutTax = function(taxGroups, mrpWithoutTaxGroup, mrpWithoutTax, mrpWithoutTaxDiscount, mrpWithoutTaxMargin){
        if(mrpWithoutTaxGroup != "")
        {
            angular.forEach(taxGroups, function(data, key) {if(key == mrpWithoutTaxGroup)$scope.taxRate = data;});

            if(isNaN(mrpWithoutTaxMargin)) {
                mrpWithoutTaxMargin = 0;
            }

            //calculate tax exclusive price
            $scope.taxExclusive = $scope.numRound((parseFloat(mrpWithoutTax) * 100) / (100 + parseFloat($scope.taxRate)));

            $scope.wholesalePrice1 = $scope.numRound(parseFloat(mrpWithoutTax) - (parseFloat(mrpWithoutTaxDiscount) / 100) * parseFloat(mrpWithoutTax));

            $scope.wholesalePrice = $scope.wholesalePrice1;

            $scope.mrpDisplay = parseFloat(mrpWithoutTax);
            //calculate portal price
            $scope.portalPrice1 = $scope.numRound($scope.wholesalePrice1 + $scope.wholesalePrice1 * (parseFloat(mrpWithoutTaxMargin)/100));
            $scope.portalPriceDisplay = $scope.numRound(parseFloat($scope.portalPrice1) * ((parseFloat($scope.taxRate)/100) + 1));
            $scope.portalPrice = $scope.numRound(parseFloat(mrpWithoutTax) - parseFloat($scope.portalPriceDisplay));

             //set tax group
            $scope.taxId = mrpWithoutTaxGroup;
        }

    };

    $scope.buyPriceWithTax = function(taxGroups, buyingPriceWithTax, buyingPriceWithTaxGroup, buyingPriceWithTaxMargin){
        if(buyingPriceWithTaxGroup != "")
        {
            angular.forEach(taxGroups, function(data, key) {if(key == buyingPriceWithTaxGroup)$scope.taxRate = data;});

            if(isNaN(buyingPriceWithTaxMargin)) {
                buyingPriceWithTaxMargin = 0;
            }

            //calculate tax exclusive price with 15% inflate
            $scope.taxExclusive = $scope.numRound(parseFloat(buyingPriceWithTax) + parseFloat(buyingPriceWithTax) * (15/100));

            //calculate wholesale price
            $scope.wholesalePrice1 = $scope.numRound((parseFloat(buyingPriceWithTax) * 100) / (100 + parseFloat($scope.taxRate)));
            $scope.wholesalePrice = $scope.numRound((parseFloat(buyingPriceWithTax)));

            //calculate portal price
            $scope.portalPrice1 = $scope.numRound($scope.wholesalePrice1 + $scope.wholesalePrice1 * (parseFloat(buyingPriceWithTaxMargin)/100));
            $scope.portalPriceDisplay = $scope.numRound(parseFloat($scope.portalPrice1) * ((parseFloat($scope.taxRate)/100) + 1));
            $scope.mrpDisplay = $scope.numRound((parseFloat($scope.taxExclusive) * ((parseFloat($scope.taxRate)/100) + 1)));
            $scope.portalPrice = $scope.numRound((parseFloat($scope.taxExclusive) * ((parseFloat($scope.taxRate)/100) + 1)) - parseFloat($scope.portalPriceDisplay));

            //set tax group
            $scope.taxId = buyingPriceWithTaxGroup;
        }
    };

    $scope.buyPriceWithoutTax = function(taxGroups, buyingPriceWithoutTax, buyingPriceWithoutTaxGroup, buyingPriceWithoutTaxMargin){
        if(buyingPriceWithoutTaxGroup != "")
        {
            angular.forEach(taxGroups, function(data, key) {if(key == buyingPriceWithoutTaxGroup)$scope.taxRate = data;});

            if(isNaN(buyingPriceWithoutTaxMargin)) {
                buyingPriceWithoutTaxMargin = 0;
            }

            //calculate tax exclusive price
            $scope.taxExclusive_buying = $scope.numRound(parseFloat(buyingPriceWithoutTax));

            //calculate tax exclusive price with 15% inflate
            $scope.taxExclusive = $scope.numRound($scope.taxExclusive_buying + $scope.taxExclusive_buying * (15/100));

            //calculate wholesale price
            $scope.wholesalePrice = $scope.numRound(parseFloat($scope.taxExclusive_buying));

            //calculate portal price
            $scope.portalPrice1 = $scope.numRound($scope.wholesalePrice + $scope.wholesalePrice * parseFloat(buyingPriceWithoutTaxMargin)/100);
            $scope.portalPriceDisplay = $scope.numRound(parseFloat($scope.portalPrice1) * ((parseFloat($scope.taxRate)/100) + 1));
            $scope.mrpDisplay = $scope.numRound((parseFloat($scope.taxExclusive) * ((parseFloat($scope.taxRate)/100) + 1)));
            $scope.portalPrice = $scope.numRound((parseFloat($scope.taxExclusive) * ((parseFloat($scope.taxRate)/100) + 1)) - parseFloat($scope.portalPriceDisplay));

            //set tax group
            $scope.taxId = buyingPriceWithoutTaxGroup;
        }
    };

    $scope.getCategoryPattern = function(id_category){
        $http.get('approver-ajax.php',{params:{type:6, id_category: id_category}}).then(function(response) {
            $scope.pattern = response.data;
        });
    };

    $scope.productName = [];

    $scope.generateName = function(id_feature)
    {
      if($('.check_'+id_feature+'_1').prop('checked') == true)
      {
        $scope.productName.push($('.custom_'+id_feature+'_1').val() + " ");
      }
      else
      {
        var index = $scope.productName.indexOf($('.custom_'+id_feature+'_1').val()+" ");
        if(index > -1)
          $scope.productName.splice(index, 1);
      }
    };

    $scope.numRound =  function(val){
        return Math.round(val * 100) / 100;
    };

    $scope.disableAttribute = function(id_feature, pattern, MODEL){

            if(MODEL != ""){
                $('.custom_'+id_feature+'_1').attr('readonly',true).val($('.predefined_'+id_feature+'_value option:selected').text()).trigger("textarea");
            }
            else{
                $('.custom_'+id_feature+'_1').attr('readonly',false).val('').trigger("textarea");
            }

            if(pattern != 0)
                $scope.generateName(pattern);
    };
    
    $scope.addNewFeature = function(name){
        if($scope.featureName != "" && $scope.featureName != undefined)
        {
            $http.get('approver-ajax.php',{params:{type:8, feature_name: name}}).then(function(response) {
                $scope.new_feature = response.data;
                if($scope.new_feature != "")
                {
                    if($('#features-block-custom_'+$scope.new_feature[0].id_feature+'').html())
                        $('#features-block-custom_'+$scope.new_feature[0].id_feature+'').remove();

                    $scope.html = "";
                    $scope.html += '<div class="col-sm-12 form-group" id="features-block-custom_'+$scope.new_feature[0].id_feature+'">\
                                      <label for="custom_'+$scope.new_feature[0].id_feature+'_1" class="col-sm-2 control-label highlight padding5">'+$scope.new_feature[0].name+'\
                                      </label>\
                                      <div class="col-sm-10">\
                                        <div class="input-group">\
                                            <textarea type="text" placeholder="Enter value" ng-model="custom_'+$scope.new_feature[0].id_feature+'" class="custom_'+$scope.new_feature[0].id_feature+'_1 form-control input-sm" rows="1" name="custom_'+$scope.new_feature[0].id_feature+'_value"></textarea>\
                                            <span class="input-group-addon"><input type="checkbox" class="check_'+$scope.new_feature[0].id_feature+'_1" ng-model="feature_check_'+$scope.new_feature[0].id_feature+'" ng-change="generateName('+$scope.new_feature[0].id_feature+')"/></span>\
                                        </div>\
                                      </div>\
                                    </div> ';
                    angular.element(document.getElementById('space-for-add-more-attribute')).append($compile($scope.html)($scope));
                    $scope.featureName = "";
                }
            });
        }
        else
        {
            toastr.error("Feature name can't be blank.");
        }
    };

    $scope.appendFeature = function(featuresList){
        $http.get('approver-ajax.php',{params:{type:7, id_feature: featuresList.id_feature}}).then(function(response) {
                if(featuresList.id_feature != "")
                {
                    if($('#features-block-custom_'+featuresList.id_feature+'').html())
                        $('#features-block-custom_'+featuresList.id_feature+'').remove();

                    $scope.html = "";
                    $scope.html += '<div class="col-sm-12 form-group" id="features-block-custom_'+featuresList.id_feature+'">\
                                      <label for="custom_'+featuresList.id_feature+'_1" class="col-sm-2 control-label highlight padding5">'+featuresList.name+'\
                                      </label>\
                                      <div class="col-sm-10">\
                                        <div class="input-group">\
                                            <textarea type="text" placeholder="Enter value" ng-model="custom_'+featuresList.id_feature+'" class="custom_'+featuresList.id_feature+'_1 form-control input-sm" rows="1" name="custom_'+featuresList.id_feature+'_value"></textarea>\
                                            <span class="input-group-addon"><input type="checkbox" class="check_'+featuresList.id_feature+'_1" ng-model="feature_check_'+featuresList.id_feature+'" ng-change="generateName('+featuresList.id_feature+')"/></span>\
                                        </div>\
                                      </div>\
                                    </div> ';
                    angular.element(document.getElementById('space-for-add-more-attribute')).append($compile($scope.html)($scope));
                    $('.existFeatureAdd').val('');
                }
            });
    };

    $scope.createCustomProductName = function(name){
        $scope.customizedProductName = name;
    };

    $scope.featuresList = function(featureName) {
        return $http.get("catalog-ajax.php",{params:{type:10, search_query: featureName}}).then(function(response){
          return response.data;
        });
    };
    $scope.edit_product =0;
    $scope.removeProductImage = function(event,photo) {
        var target = event.target;
        var container = $(target).parent().parent();
        container.remove();
        return $http.get("catalog-ajax.php",{params:{type:11, id_image: photo}}).then(function(response){
        });
    };

}])
.config(['$routeProvider', function($routeProvider) {
    $routeProvider.

    when('/product/upload', {
        templateUrl: 'catalog/partials/vendor/upload-product.tpl',
        controller: 'productUploadController'
    }).

    when('/product/buyingPrice', {
        templateUrl: 'catalog/partials/vendor/edit-buy-product.tpl',
        controller: 'productBuyingPriceController'
    }).

    when('/product/perksPrice', {
        templateUrl: 'catalog/partials/vendor/edit-perks-price.tpl',
        controller: 'perksCompetitorPriceController'
    }).

    when('/products', {
        templateUrl: 'catalog/partials/vendor/uploaded-product-detail.tpl',
        controller: 'productsController'
    }).

    when('/products/:productId/edit', {
        templateUrl: 'catalog/partials/vendor/edit-product.tpl',
        controller: 'productEditController'
    }).

    when('/product/indexing', {
        templateUrl: 'catalog/partials/vendor/product-indexing.tpl',
        controller: 'productIndexController'
    }).

    otherwise({
        redirectTo: '/'
    });
}])
.controller('productUploadController', ['$scope', '$routeParams', '$http', function($scope, $routeParams, $http) {
      $http.get('catalog-ajax.php', {
          params: {
              type: 2
          }
      }).then(function(response) {
          $scope.result = response.data;
      });
  }])
.controller('fessCntrl', function($scope) {})
.controller('productsController', function($scope, $http) {
      $http.get('catalog-ajax.php', {
          params: {
              type: 6
          }
      }).then(function(response) {
          $scope.result = response.data;
      });
  })
.controller('priceListForm', function($scope, $routeParams, $http, toastr) {
      $scope.submit = function() {
        if($('#searchProduct').val() == "") {
            toastr.error('Please select product to proceed.');
        }
        else {
            $http.get('catalog-ajax.php', {
                params: $scope.regions
            }).then(function(response) {
                if(response.data == 'success'){
                    toastr.success('Price updated successfully.');
                    $('#searchProduct').val('').trigger('input');
                    $scope.regions = {};
                }
                else{
                    toastr.error(response.data);
                }
            }); 
        }
      };
    })
.controller('perksPriceForm', function($scope, $routeParams, $http, $route, toastr) {
      $scope.addPrice = function() {
            $http.get('catalog-ajax.php', {
                params: {
                  id_product:$('#idProduct').val(),
                  amazon:$scope.amazon,
                  flipkart:$scope.flipkart,
                  snapdeal:$scope.snapdeal,
                  type: 14,
              }
            }).then(function(response) {
                if(response.data == 1)
                {
                    toastr.success('Competitors price saved Successfully');
                    $route.reload();
                }
                else{
                    toastr.error('Sorry, unable to save the prices');
                }
            }); 
      };
    })
.controller('productBuyingPriceController', function($scope, $routeParams, $http) {
    autoCompSearch("#searchProduct","catalog_price");
    $scope.regions = {};
    $http.get('catalog-ajax.php', {
          params: {
              type: 16
          }
    }).then(function(response) {
          $scope.regionsDetail = response.data;
    });

    $scope.processing = function() {
        var input_length = $('#searchProduct').val();
        if (input_length.length < 2) {
            $("#quotation-processing").hide();
        }
        else {
            $('#quotation-processing').show();
        }
    }
  })
.controller('perksCompetitorPriceController', function($scope, $routeParams, $http, $route) {

    autoCompSearch("#searchPerks","catalog_perks");
    $http.get('catalog-ajax.php', {
          params: {
              type: 13
          }
      }).then(function(response) {
          $scope.companiesDetail =  response.data;
      });
      $scope.delete = function($value)
      {
        $http.get('catalog-ajax.php', {
          params: {
              type: 15,
              id_competitors:$value
          }
      }).then(function(response) {
          $route.reload();
      });
      }
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
          //$scope.src = $scope.result[5];
      });
})
.controller('productIndexController', function($scope, $http, toastr) {
    $scope.indexMissingProducts = function() {
        $http({
            url: "kobster_admin/searchcron.php",
            method: "POST",
            params: { catalog: true, id_shop: 1, token: token_admin_global }
        }).success(function(data) {
            if(data == 'success') {
                toastr.success("Indexing completed successfully.");
            }
            else {
                toastr.error("Error in indexing products.");
            }
        });
    }
})
    .directive('ngFileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.ngFileModel);
            var isMultiple = attrs.multiple;
            var modelSetter = model.assign;
            element.bind('change', function () {
                var values = [];
                angular.forEach(element[0].files, function (item) {
                    var value = {
                       // File Name 
                        name: item.name,
                        //File Size 
                        size: item.size,
                        //File URL to view 
                        url: URL.createObjectURL(item),
                        // File Input Value 
                        _file: item
                    };
                    values.push(value);
                });
                scope.$apply(function () {
                    if (isMultiple) {
                        modelSetter(scope, values);
                    } else {
                        modelSetter(scope, values[0]);
                    }
                });
            });
        }
    };
}])
.directive("leveloneCreator", function($compile, $http) {
    return {
        restrict: 'A',
        link: function(scope, element, http) {
            element.bind("change", function(e) {
                scope.$apply(function() {
                    $http.get('catalog-ajax.php', {
                        params: {
                            type: 3,
                            id_parent: scope.leveloneCreator
                        }
                    }).then(function(response) {
                        scope.subcatlevel1 = response.data;
                        scope.level1 = null, scope.level2 = null, scope.level3 = null;
                        if ((scope.subcatlevel1).length > 0 && scope.subcatlevel1[0].id_category != 1) {
                            scope.subcatlevel1 = scope.subcatlevel1;
                            scope.level1 = 1;
                            scope.upload = false;
                            scope.getPattern = false;
                        } else {
                            scope.level1 = null, scope.level2 = null, scope.level3 = null, scope.level4 = null;
                            $http.get('catalog-ajax.php', {
                                params: {
                                    type: 4,
                                    id_category: scope.leveloneCreator
                                }
                            }).then(function(response) {
                                if ((response.data[0]).length > 0) {
                                    $('#space-for-add-more-attribute').html('');
                                    scope.features = response.data;
                                    scope.category = scope.leveloneCreator;
                                    scope.upload = true;
                                    scope.getPattern = true;
                                } else {
                                    scope.upload = false;
                                    scope.getPattern = false;
                                }
                            });
                        }
                    });
                });
            });
        }
    }
})
.directive("leveltwoCreator", function($compile, $http) {
    return {
        restrict: 'A',
        link: function(scope, element, http) {
            element.bind("change", function(e) {
                scope.$apply(function() {
                    $http.get('catalog-ajax.php', {
                        params: {
                            type: 3,
                            id_parent: scope.leveltwoCreator
                        }
                    }).then(function(response) {
                        scope.subcatlevel2 = response.data;
                        if ((scope.subcatlevel2).length > 0 && scope.subcatlevel2[0].id_category != 1) {
                            scope.subcatlevel2 = scope.subcatlevel2;
                            scope.level2 = 1;
                            scope.upload = false;
                            scope.getPattern = false;
                        } else {
                            scope.level2 = null, scope.level3 = null, scope.level4 = null;
                            $http.get('catalog-ajax.php', {
                                params: {
                                    type: 4,
                                    id_category: scope.leveltwoCreator
                                }
                            }).then(function(response) {
                                if ((response.data[0]).length > 0) {
                                    $('#space-for-add-more-attribute').html('');
                                    scope.features = response.data;
                                    scope.category = scope.leveltwoCreator;
                                    scope.upload = true;
                                    scope.getPattern = true;
                                } else {
                                    scope.upload = false;
                                    scope.getPattern = false;
                                }
                            });
                        }
                    });
                });
            });
        }
    }
})
.directive("levelthreeCreator", function($compile, $http) {
    return {
        restrict: 'A',
        link: function(scope, element, http) {
            element.bind("change", function(e) {
                scope.$apply(function() {
                    $http.get('catalog-ajax.php', {
                        params: {
                            type: 3,
                            id_parent: scope.levelthreeCreator
                        }
                    }).then(function(response) {
                        scope.subcatlevel3 = response.data;
                        if ((scope.subcatlevel3).length > 0 && scope.subcatlevel3[0].id_category != 1) {
                            scope.subcatlevel3 = scope.subcatlevel3;
                            scope.level3 = 1;
                            scope.upload = false;
                            scope.getPattern = false;
                        } else {
                            scope.level3 = null, scope.level4 = null;
                            $http.get('catalog-ajax.php', {
                                params: {
                                    type: 4,
                                    id_category: scope.levelthreeCreator
                                }
                            }).then(function(response) {
                                if ((response.data[0]).length > 0) {
                                    $('#space-for-add-more-attribute').html('');
                                    scope.features = response.data;
                                    scope.category = scope.levelthreeCreator;
                                    scope.upload = true;
                                    scope.getPattern = true;
                                } else {
                                    scope.upload = false;
                                    scope.getPattern = false;
                                }
                            });
                        }
                    });
                });
            });
        }
    }
})
.directive("levelfourCreator", function($compile, $http) {
    return {
        restrict: 'A',
        link: function(scope, element, http) {
            element.bind("change", function(e) {
                scope.$apply(function() {
                    $http.get('catalog-ajax.php', {
                        params: {
                            type: 3,
                            id_parent: scope.levelfourCreator
                        }
                    }).then(function(response) {
                        scope.subcatlevel4 = response.data;
                        if ((scope.subcatlevel4).length > 0 && scope.subcatlevel4[0].id_category != 1) {
                            scope.subcatlevel4 = scope.subcatlevel4;
                            scope.level4 = 1;
                            scope.upload = false;
                            scope.getPattern = false;
                        } else {
                            scope.level4 = null;
                            $http.get('catalog-ajax.php', {
                                params: {
                                    type: 4,
                                    id_category: scope.levelfourCreator
                                }
                            }).then(function(response) {
                                if ((response.data[0]).length > 0) {
                                    $('#space-for-add-more-attribute').html('');
                                    scope.features = response.data;
                                    scope.category = scope.levelfourCreator;
                                    scope.upload = true;
                                    scope.getPattern = true;
                                } else {
                                    scope.upload = false;
                                    scope.getPattern = false;
                                }
                            });
                        }
                    });
                });
            });
        }
    }
});

function isNumber(evt){
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
        return false;
    }
    return true;
}