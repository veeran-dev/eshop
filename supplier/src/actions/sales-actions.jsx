import * as types from '../constants/action-types';

export function setTopCustomers(data) {
	return {type: types.TOP_CUSTOMERS, payload: data}; 
}


export function setMonthlySales(data) {
	return {type: types.MONTHLY_SALES, payload: data}; 
}

export function loading(status){
	return { type: types.SALES_LOADING, payload: status}
}

export function monthlySalesLoading(status){
	return { type: types.MONTHLY_SALES_LOADING, payload: status}
}

export function topCustomersLoading(status){
	return { type: types.TOP_CUSTOMERS_LOADING, payload: status}
}

export function setTopSoldProducts(status){
	return { type: types.TOP_SOLD_PRODUCTS, payload: status}
}

export function topProductsLoading(status){
	return { type: types.TOP_PRODUCTS_LOADING, payload: status}
}

export function dashboardKpi(data){
	return { type: types.DASHBOARD_KPI, payload:data}
}