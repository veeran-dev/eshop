import * as types from '../constants/action-types'
const initialState = {
  purchaseList: [],
  purchaseCategories: [],
  purchaseSuppliers: [],
  purchaseCategoryProducts: [],
  categoriesForPurchaseList: [],
  poProducts: [],
  notMatchedProducts: [],
  purchaseListTotal: 0,
  isFetchingPurchaseList: false,
  isFetchingPurchaseCategories: false,
  isFetchingPurchaseProducts: false,
  isUploadingPo: false,
  totalCount: 0,
  productFilters:[],
  productList: [],
  productList1: [],
  total:0,
  purchaseOrderProductsBudget: []
};

const procureBuyReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_PURCHASE_LIST:
      return { ...state, isFetchingPurchaseList: action.loading }
    case types.REQUEST_UPLOAD_PO:
      return { ...state, isUploadingPo: action.loading }
    case types.RESPONSE_UPLOAD_PO:
      return { ...state, isUploadingPo: action.loading }
    case types.REQUEST_PURCHASE_CATEGORIES:
      return { ...state, isFetchingPurchaseCategories: action.loading }
    case types.REQUEST_PURCHASE_CATEGORY_PRODUCTS:
      return { ...state, isFetchingPurchaseProducts: action.loading }
    case types.GET_PURCHASE_LIST_SUCCESS:
     	return { ...state, purchaseList: action.pur_list[0], purchaseListTotal: action.pur_list[1], isFetchingPurchaseList: action.isFetching }
    case types.GET_PURCHASE_CATEGORIES_SUCCESS:
    	return { ...state, purchaseCategories: action.purchaseCategories, isFetchingPurchaseCategories: false }
    case types.GET_PURCHASE_SUPPLIER_SUCCESS:
      return { ...state, purchaseSuppliers: action.purchaseSuppliers, isFetchingPurchaseSuppliers: false }
    case types.GET_CATEGORY_PRODUCTS_SUCCESS:
    	return { ...state, purchaseCategoryProducts: action.purchaseCategoryProducts, isFetchingPurchaseProducts: false, totalCount: action.total }
  	case types.GET_CATEGORY_PRODUCTS_WITH_FILTERS:
   		return { ...state, productFilters: action.purchaseCategoryProductsWithFilters[0],productList: action.purchaseCategoryProductsWithFilters[1], total: action.purchaseCategoryProductsWithFilters[2] }
  	case types.GET_CATEGORY_PRODUCTS_WITH_FILTERS_VALUES:
      		return { ...state,productList: action.purchaseCategory[0],total:action.purchaseCategory[1] }
  	case types.GET_BRAND_PRODUCTS_WITH_FILTERS:
   		return { ...state, productFilters: action.purchaseBrandProductsWithFilters[0],productList: action.purchaseBrandProductsWithFilters[1], total: action.purchaseBrandProductsWithFilters[2] }
  	case types.GET_BRAND_PRODUCTS_WITH_FILTERS_VALUES:
   		return { ...state,productList: action.purchaseBrandProductsWithFiltersValues[0] ,total: action.purchaseBrandProductsWithFiltersValues[1] }
  	case types.GET_PO_PRODUCTS_SUCCESS:
      return { ...state, poProducts: action.poProducts,  notMatchedProducts: action.poNotMatchProducts, isFetching: false }
    case types.PURCHASE_ORDER_BUDGET:
      return { ...state, purchaseOrderProductsBudget: action.purchaseOrderProducts }
    default:
    	return state;
  }
}

export default procureBuyReducer;
