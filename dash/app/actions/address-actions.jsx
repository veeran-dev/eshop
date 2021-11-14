import * as types from '../constants/action-types';

export function dispatchAddress(address){
	return {
		type: types.GET_ADDRESS_SUCCESS,
		address
	}
}

export function dispatchUniqueAddress(uniqueAddress){
	return{
		type: types.GET_UNIQUE_ADDRESS_SUCCESS,
		uniqueAddress
	}
}

export function dispatchBillingAddress(billingAddress) {
	return {
		type: types.GET_BILLING_ADDRESS_SUCCESS,
		billingAddress
	}
}

export function dispatchPayment(paymentModes){
	return{
		type: types.GET_PAYMENT_SUCCESS,
		paymentModes
	}
}

export function dispatchState(states){
	return{
		type: types.GET_STATE_SUCCESS,
		states
	}
}

export function dispatchOrderId(orderID){
	return{
		type: types.GET_ORDER_ID_PAYMENT,
		orderID
	}
}

export function dispatchDeals(deals){
	return{
		type: types.GET_DEALS_SUCCESS,
		deals
	}
}

export function requestPaymentModes() {
	return { type: types.REQUEST_PAYMENT_MODES, loading: true }
}

export function requestUniqueAddress() {
	return { type: types.REQUEST_UNIQUE_ADDRESS, loading: true }
}

export function requestAddress() {
	return { type: types.REQUEST_ADDRESS_LIST, loading: true }
}

export function requestDeals() {
	return { type: types.REQUEST_DEALS, loading: true }
}

export function dispatchAllStates(states) {
	return { type: types.ALL_STATES_RESPONSE, allStates: states}
}

export function dispatchReportsState(states) {
	return { type: types.CUSTOMER_STATES_FOR_REPORTS, reportStates: states}
}

export function purchaseOrders(payload) {
	return { type: types.PURCHASE_ORDERS_BY_ADDRESS, payload }
}