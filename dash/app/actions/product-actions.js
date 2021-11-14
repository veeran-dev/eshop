import * as types from '../constants/action-types';

export function setProductDetails(data){
	return {
		type: types.PRODUCT_DETAILS,
		payload: data
	}
}

export function setSupplierDetails(data){
	return {
		type: types.SUPPLIER_DETAILS,
		payload: data
	}
}

export function fetchingSupplier(data){
	return{
		type: types.SUPPLIER_FETCHING,
		payload: data
	}	
}