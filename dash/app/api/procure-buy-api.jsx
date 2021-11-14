import axios from 'axios'
import store from '../store/configureStore'
import {toastr} from 'react-redux-toastr'
import * as action from '../actions/procure-buy-actions'
import serialize from 'form-serialize'
import * as commonAction from '../actions/common-actions'

/**
 * Get user purchase list
 */
export function getPurchaseList(supplier_id, searchQuery = "") {
  store.dispatch(action.requestPurchaseList())
  return axios.get('dash-PurchaseList.php?type=9&id_customer='+id_customer+'&id_category=""&supplier_id='+supplier_id+'&search_key_word='+searchQuery)
    .then(response => {
      store.dispatch(action.getPurchaseListSuccess(response.data))
      return response
    });
}

export function getListCategories(){
  store.dispatch(action.requestSupplierProducts())
	return axios.get('dash-PurchaseList.php?type=11&id_customer='+id_customer)
    .then(response => {
      store.dispatch(action.purchaseCategories(response.data))
      return response
    });
}

export function getSupplierProducts(){
  store.dispatch(action.requestPurchaseCategories())
  return axios.get('dash-PurchaseList.php?type=15&id_customer='+id_customer)
    .then(response => {
      store.dispatch(action.purchaseSuppliers(response.data))
      return response
    });
}

export function getListCategoryProducts(idCategory){
  store.dispatch(action.requestPurchaseCategoryProducts())
	return axios.get('dash-PurchaseList.php?type=9&id_customer='+id_customer+'&category_id='+idCategory)
    .then(response => {
      store.dispatch(action.purchaseCategoryProducts(response.data[0]))
      return response
    });
}

export function getListCategoryProductsWithFilters(idCategory){
  //store.dispatch(action.requestPurchaseCategoryProducts())
	return axios.get('dash-category.php?type=1&id_customer='+id_customer+'&id_category='+idCategory)
    .then(response => {
      store.dispatch(action.purchaseCategoryProductsWithFilters(response.data))
      return response
    });
}

export function downloadPurchaseOrder(){
  window.open("generate-purchase-order.php?&id_customer=" + id_customer);
}

export function downloadBudgetPurchaseOrder(poNumber, poDate, poFromDate, poToDate) {
  window.open("generate-purchase-order-budget.php?id_customer="+id_customer+"&poNumber="+poNumber+"&poDate="+poDate+"&poFromDate="+poFromDate+"&poToDate="+poToDate);
}

export function uploadPO(router){
  var fileInput = document.getElementById("upload-purchase-order-input");
  if(fileInput.value != ""){
    var file = fileInput.files[0];
    var data = new FormData();
    data.append("file", file)
    data.append("type", 1)
    
    // Start loading when upload
    store.dispatch(action.requestUploadPo())
    
    return axios.post('upload-po.php', data).then(response => {
        console.log(response);
        let data = response.data

        // Stop loading when upload response came
        store.dispatch(action.responseUploadPo())

        if(data == 1){
          toastr.error("Error", "File format not supported.", {icon: "icon-error"})
        }
        else if(data == 2){
          toastr.error("Error", "File is too large.", {icon: "icon-error"})
        }
        else if(data == 3){
          toastr.error("Error", "Error in uploading file.", {icon: "icon-error"})
        }
        else{

            store.dispatch(action.dispatchPOFetchedProducts(data[0], data[1]));
            
            if(data[0] && data[0].length > 0){
              router.push("procure/upload-po/fetched-products");
            }
            else{
              toastr.error("Error", "The PO you have uploaded is missing necessary data. Please check the file you have uploaded.", {icon: "icon-error"})
            }
        }

        return response
    });
  }
  else{
    toastr.error("Error", "please select file to proceed.", {icon: "icon-error"})
  }
}

/*
* Function to upload purchase order for 
* Budget Control System
*/
export function uploadBudgetPO(router, poNumber) 
{
  var fileInput = document.getElementById("upload-purchase-order-budget-input");

  if(fileInput.value != "") 
  {
    var file = fileInput.files[0];
    var data = new FormData();
    data.append("file", file);
    data.append("type", 1);
    data.append("po_number", poNumber);
    
    // Start loading when upload
    store.dispatch(action.requestUploadPo())
    
    return axios.post('purchase-order.php', data).then(response => {
        let data = response.data
        // Stop loading when upload response came
        store.dispatch(action.responseUploadPo())

        if(data == 1){
          toastr.error("Error", "File format not supported.", {icon: "icon-error"})
        }
        else if(data == 2){
          toastr.error("Error", "File is too large.", {icon: "icon-error"})
        }
        else if(data == 3){
          toastr.error("Error", "Error in uploading file.", {icon: "icon-error"})
        }
        else if(data == 4) {
          toastr.error("Error", "Error in uploaded file.", {icon: "icon-error"})
        }
        else{

            if(data && data.length > 0) {
              store.dispatch(action.purchaseOrderProductsBudget(data))
            }
            else{
              toastr.error("Error", "The PO you have uploaded is missing necessary data. Please check the file you have uploaded.", {icon: "icon-error"})
            }
        }

        return response
    });
  }
  else{
    toastr.error("Error", "please select file to proceed.", {icon: "icon-error"})
  }
}

/*
* Function to configure budget products
*/
export function configureBudget(poNumber, poDate, poFromDate, poToDate, details, poAddress, state) {
  var data = new FormData();
  if(budgetOption == 2) {
    var fileInput = document.getElementById("upload-purchase-order-budget-input");
    if(fileInput.value != "") {
      var file = fileInput.files[0];
      data.append("file", file);
    }
  }  
  data.append("type", 2);
  data.append("po_number", poNumber);
  data.append("po_date", poDate);
  data.append("valid_from", poFromDate);
  data.append("valid_through", poToDate);
  data.append("po_details", details);
  data.append("po_option", budgetOption);
  data.append('id_address[]', poAddress);
  // if(poAddress && poAddress.length > 0) {
  //   poAddress.map(d => data.append('id_address[]', d.id_address));
  // }

  return axios.post('purchase-order.php', data).then(response => {
    if(response.data == "success"){
      toastr.success("Success", "Purchase order configured successfully.", {icon: "icon-succes"});
      state.context.router.push('dashboard');
      location.reload(true);
    }
    else if(response.data == 1) {
      toastr.error("Error", "Please upload file less than 5MB.", {icon: "icon-error"});
    }
    else if(response.data == 2) {
      toastr.error("Error", "Error in uploading file.", {icon: "icon-error"});
    }
    else {
      toastr.error("Error", response.data, {icon: "icon-error"});
    }
    return response;
  });
}


{/*After click the Brand Page this function will perform*/}
export function getBrandById(idBrand, limit, idPage, searchType){
  	if(searchType == 1)
		var customerID = 0;
	else
		var customerID = id_customer;
	

	return axios.get('dash-brand.php?id_brand='+idBrand+'&type=1&id_customer='+customerID+'&pagenum='+idPage+'&limit='+limit).then(response => {
  	  store.dispatch(action.purchaseBrandProductsWithFilters(response.data))
      return response
	})
	
}
{/*Return the Brand Name*/}
export function getBrandNameById(brandId) {
  return axios.get('dash-brand.php?id_brand='+brandId+'&type=2').then(response => {
      document.getElementById("brandSearchKeyword").innerHTML = '"'+response.data+'"';
      return response
  })
}

{/*After click the filter values this function will perform*/}
export function getFilterValues(limit, idPage, searchType, fromPage, id, values)//fromPage 1->category Page 2-> brand 3-> search
{
  	if(searchType == 1)
		var customerID = 0;
	else  
		var customerID = id_customer;
	var actionType;

 	let categoryFilter = document.querySelector('#categoryFilterForm');
	let manufacturerFilter= document.querySelector('#manufacturerFilterForm');
	let priceFilter = document.querySelector('#priceFilterForm');
	
	var categoriesId =serialize(categoryFilter, { hash: false});
	var ManufacturerId=serialize(manufacturerFilter, { hash: false });
	var price=serialize(priceFilter, { hash: false });
	if(fromPage==1)	{
		var data = categoriesId+'&'+ManufacturerId+'&'+price+'&type=1&id_customer='+customerID+'&pagenum='+idPage+'&limit='+limit+'&categoryId='+id+'&priceMax='+values.max+'&priceMin='+values.min;
		return axios.post('dash-filter.php',data).then(response => {
 		   store.dispatch(action.purchaseCategoryProductsWithFiltersValues(response.data))
		  return response
		});
	}
	else if(fromPage==2) {
 		var data = categoriesId+'&'+ManufacturerId+'&'+price+'&type=1&id_customer='+customerID+'&pagenum='+idPage+'&limit='+limit+'&brand='+id+'&priceMax='+values.max+'&priceMin='+values.min;
		return axios.post('dash-filter.php',data).then(response => {
 		   store.dispatch(action.purchaseBrandProductsWithFiltersValues(response.data))
		  return response
		});
	}
	else if(fromPage==3) {
		var data = categoriesId+'&'+ManufacturerId+'&'+price+'&type=1&id_customer='+customerID+'&pagenum='+idPage+'&limit='+limit+'&searchQuery='+id+'&priceMax='+values.max+'&priceMin='+values.min;
		return axios.post('dash-filter.php',data).then(response => {
   		   store.dispatch(commonAction.searchFilterResults(response.data))
		  return response
		});
	}
	
}