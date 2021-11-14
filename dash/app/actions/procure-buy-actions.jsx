import * as types from '../constants/action-types';

export function getPurchaseListSuccess(pur_list) {
  return {
    type: types.GET_PURCHASE_LIST_SUCCESS,
    pur_list,
    isFetching: false
  }
}

export function purchaseCategories(purchaseCategories){
	return {
		type: types.GET_PURCHASE_CATEGORIES_SUCCESS,
		purchaseCategories
	}
}

export function purchaseSuppliers(purchaseSuppliers){
	return {
		type: types.GET_PURCHASE_SUPPLIER_SUCCESS,
		purchaseSuppliers
	}
}

export function purchaseCategoryProducts(purchaseCategoryProducts,total=0){
	return {
		type: types.GET_CATEGORY_PRODUCTS_SUCCESS,
		purchaseCategoryProducts,
		total: total
	}
}
export function purchaseCategoryProductsWithFilters(purchaseCategoryProductsWithFilters,total=0){

	return {
		type: types.GET_CATEGORY_PRODUCTS_WITH_FILTERS,
		purchaseCategoryProductsWithFilters,
		total: total
	}
}
export function purchaseCategoryProductsWithFiltersValues(purchaseCategory){
 	return {
		type: types.GET_CATEGORY_PRODUCTS_WITH_FILTERS_VALUES,
		purchaseCategory
	}
}
export function purchaseBrandProductsWithFilters(purchaseBrandProductsWithFilters,total=0){

	return {
		type: types.GET_BRAND_PRODUCTS_WITH_FILTERS,
		purchaseBrandProductsWithFilters,
		total: total
	}
}
export function purchaseBrandProductsWithFiltersValues(purchaseBrandProductsWithFiltersValues,total=0){

	return {
		type: types.GET_BRAND_PRODUCTS_WITH_FILTERS_VALUES,
		purchaseBrandProductsWithFiltersValues,
		total: total
	}
}


export function dispatchPOFetchedProducts(products, noMatchProducts){
	return {
		type: types.GET_PO_PRODUCTS_SUCCESS,
		poProducts: products,
		poNotMatchProducts: noMatchProducts
	}
}

export function requestPurchaseList() {
	return { type: types.REQUEST_PURCHASE_LIST, loading: true }
}

export function requestPurchaseCategories() {
	return { type: types.REQUEST_PURCHASE_CATEGORIES, loading: true }
}

export function requestSupplierProducts() {
	return { type: types.REQUEST_SUPPLIER_PRODUCTS, loading: true }
}

export function requestPurchaseCategoryProducts() {
	return { type: types.REQUEST_PURCHASE_CATEGORY_PRODUCTS, loading: true }
}

export function requestUploadPo() {
	return { type: types.REQUEST_UPLOAD_PO, loading: true }
}

export function responseUploadPo() {
	return { type: types.RESPONSE_UPLOAD_PO, loading: false }
}

export function purchaseOrderProductsBudget(purchaseOrderProducts) {
	return { type: types.PURCHASE_ORDER_BUDGET, purchaseOrderProducts: purchaseOrderProducts }
}