import * as types from '../constants/action-types'

export function getOrdersSuccess(orders, count) {
  return {
    type: types.GET_ORDERS_SUCCESS,
    orders: orders,
    count: count
  }
}

export function orderComplete(completeResponse){
	return {
		type: types.ORDER_COMPLETE_SUCCESS,
		completeResponse
	}
}

export function dispatchById(orderData){
	return {
		type: types.GET_ORDER_BY_ID,
		orderData
	}
}

export function dispatchOrder(order) {
	return {
		type: types.GET_ORDER_PAGE_DATA_SUCCESS,
		orderPageData: order
	}
}

export function requestOrders() {
	return { type: types.REQUEST_ORDERS, loading: true }
}

export function requestOrderComplete() {
	return { type: types.REQUEST_ORDER_COMPLETE, loading: true }
}

export function requestById() {
	return { type: types.REQUEST_UNIQUE_ORDER, loading: true } 
}

export function dispatchPayment(payload) {
	return { type: types.GET_ORDER_PAYMENT_METHOD, payload: payload }
}

export function orderProcessStatus(payload) {
	return { type: types.ORDER_PROCESS_STATUS, payload: payload }
}

export function dispatchOrderDetails(order) {
	return {
		type: types.SET_ORDER_DETAILS,
		orderDetails: order
	}
}

export function dispatchOrderDetailsClean(order) {
	return {
		type: types.CLEAN_ORDER_DETAILS,
		orderDetails: order
	}
}

export function loading_order_detail(payload) {
	return { type: types.ORDER_DETAIL_LOADING, isFetching: payload }
}

export function loading_order_list(payload) {
	return { type: types.ORDER_LIST_LOADING, isFetching: payload }
}

export function setOrderDetails(payload) {
	return { type: types.ORDER_DETAILS, payload: payload }
}

export function setOrderDeliveryAddress(payload) {
	return { type: types.ORDER_DELIVERY_ADDRESS, payload: payload }
}

export function setOrderInvoiceAddress(payload) {
	return { type: types.ORDER_INVOICE_ADDRESS, payload: payload }
}

export function setOrderProdcutDetails(payload) {
	return { type: types.ORDER_PRODUCT_DETAILS, payload: payload }
}

export function setOrderStatus(payload) {
	return { type: types.ORDER_ORDER_STATUS, payload: payload }
}

export function setScheduledProdcuts(payload) {
	return { type: types.ORDER_SCHEDULED_PRODUCT, payload: payload }
}

export function setCanceledProdcuts(payload) {
	return { type: types.ORDER_CANCELED_PRODUCT, payload: payload }
}