import * as types from '../constants/action-types';

export function getPendingPaymentSuccess(pendingpayments) {
  return {
    type: types.GET_PENDING_PAYMENT,
    pendingpayments
  };
}

export function requestPendingPayment(data) {
	return {
		type: types.REQUEST_PENDING_PAYMENT,
		loading: data
	}
}