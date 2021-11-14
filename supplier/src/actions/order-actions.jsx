import * as types from '../constants/action-types';

export function setOrderLists(data){
	return {
		type: types.ORDER_LISTS,
		payload: data
	}
}

export function setWidgetOrderLists(data){
	return {
		type: types.WIDGET_ORDER_LISTS,
		payload: data
	}
}

export function setOrderCount(data){
	return {
		type: types.ORDER_COUNTS,
		payload: data
	}
}

export function setWidgetOrderCount(data){
	return {
		type: types.WIDGET_ORDER_COUNTS,
		payload: data
	}
}

export function setOrderDetails(data){
	return {
		type: types.ORDER_DETAILS,
		payload: data
	}
}

export function setOrderStatus(data){
	return {
		type: types.ORDER_STATUS,
		payload: data
	}
}

export function setOrderProducts(data){
	return {
		type: types.ORDER_PRODUCTS,
		payload: data
	}
}


export function setOrderDeliveryAddress(data){
	return {
		type: types.ORDER_DADDRESS,
		payload: data
	}
}
export function setOrderInvoiceAddress(data){
	return {
		type: types.ORDER_IADDRESS,
		payload: data
	}
}

export function loading(status){
	return { type: types.ORDER_LOADING, payload: status}
}

export function setOrderStatusWithCount(data){
	return {
		type: types.ORDER_STATUS_WITH_COUNT,
		payload: data
	}
}

export function setAllCustomers(data){
	return {
		type: types.ALL_CUSTOMERS,
		payload: data
	}
}

export function ordersSchedule(data){
	return {
		type: types.ORDERS_SCHEDULE,
		payload: data
	}
}