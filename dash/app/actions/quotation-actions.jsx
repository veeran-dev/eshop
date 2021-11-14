import * as types from '../constants/action-types';

export function quotationsRequestsList(data){
	return {
		type: types.QUOTATIONS_REQUESTS_LISTS,
		payload: data
	}
}

export function loading(status){
	return { type: types.QUOTATIONS_LOADING, payload: status}
}

export function clearQuotationsRequestsList(){
	return { type: types.CLEAR_QUOTATIONS, payload: false}	
}

export function quotationsRequestsListCount(count){
	return {type: types.QUOTATIONS_REQUESTS_LISTS_COUNT, payload: count}
}

export function quotationsDetails(data){
	return {type: types.QUOTATIONS_REQUESTS_DETAILS, payload: data}
}

export function supplierssDetails(data){
	return {type: types.QUOTATIONS_RESPOND_SUPPLIERS, payload: data}
}