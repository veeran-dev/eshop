import * as types from '../constants/action-types';

export function setSupplierAddress(data){
	return {
		type: types.SUPPLIER_ADDRESS,
		payload: data
	}
}

export function setStates(data){
	return {
		type: types.ADDRESS_STATES,
		payload: data
	}
}

export function loading(status){
	return { type: types.ADDRESS_LOADING, payload: status}
}
