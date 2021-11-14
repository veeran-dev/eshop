import * as types from '../constants/action-types';

export function setContractLists(data){
	return {
		type: types.CONTRACT_LISTS,
		payload: data
	}
}

export function loading(status){
	return { type: types.CATALOG_LOADING, payload: status}
}

export function setAllCustomers(data){
	return {
		type: types.ALL_CUSTOMERS,
		payload: data
	}
}

export function setProductLists(data){
	return {
		type: types.PRODUCT_LIST,
		payload: data
	}
}

export function setContractCount(data){
	return {
		type: types.CONTRACT_COUNT,
		payload: data
	}
}

export function setProductCount(data){
	return {
		type: types.PRODUCT_COUNT,
		payload: data
	}
}