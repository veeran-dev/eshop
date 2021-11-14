import * as types from '../constants/action-types';

export function getInvoicesSuccess(invoices) {
  return {
    type: types.GET_INVOICES_SUCCESS,
    invoices
  };
}

export function getDRsSuccess(deliveryReceipts){
	return {
		type: types.GET_DR_SUCCESS,
		deliveryReceipts
	}
}

export function requestInvoice() {
	return {
		type: types.REQUEST_INVOICE,
		loading: true
	}
}

export function requestDrs() {
	return {
		type: types.REQUEST_DELIVERY_RECIEPT,
		loading: true
	}
}