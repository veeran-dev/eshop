import * as types from '../constants/action-types';

export function dispatchCart(cartProducts){
	return {
		type: types.GET_CART_SUCCESS,
		cartProducts: cartProducts,
		loading: false
	}
}

export function cartRequest(){
	return {
		type: types.REQUEST_CART,
		loading: true
	}
}

export function cartRequestSummary() {
	return {
		type: types.REQUEST_CART_SUMMARY,
		loading: true
	}
}

export function dispatchSummary(cartSummary){
	return {
		type: types.GET_CART_SUMMARY,
		cartSummary: cartSummary,
		loading: false
	}
}

export function dispatchLoyaltyCount(loyaltyPoints){
	return {
		type: types.GET_LOYALTY_COUNT_SUCCESS,
		loyaltyPoints
	}
}

export function requestAddProduct() {
	return { type: types.REQUEST_ADD_PRODUCT, loading: true }
}

export function responseAddProduct() {
	return { type: types.RESPONSE_ADD_PRODUCT, loading: false }
}