import * as types from '../constants/action-types';

export function dispatchHistory(orderHistory){
	return {
		type: types.GET_ORDER_HISTORY_SUCCESS,
		orderHistory
	}
}

export function dispatchApprovals(Approvals){
	return {
		type: types.GET_APPROVALS_HOME_SUCCESS,
		Approvals
	}
}

export function dispatchRM(relationshipManager){
	return {
		type: types.GET_RM_SUCCESS,
		relationshipManager
	}
}

export function dispatchTop4Products(top4Products){
	return {
		type: types.GET_TOP4_PRODUCTS_SUCCESS,
		top4Products
	}
}

export function dispatchTopCategory(topCategory){
	return {
		type: types.GET_TOP_CATEGORY_SUCCESS,
		topCategory
	}
}


export function dispatchEliteDeals(deals){
	return {
		type: types.GET_ELITE_DEALS,
		deals
	}
}

export function requestOrderStatusDashboard() {
	return {
		type: types.REQUEST_ORDER_STATUS_DASHBOARD,
		loading: true
	}
}

export function requestApprovalsDashboard() {
	return {
		type: types.REQUEST_APPROVALS_DASHBOARD,
		loading: true
	}
}

export function requestRmDashboard() {
	return {
		type: types.REQUEST_RM_DASHBOARD,
		loading: true
	}
}

export function requestTop4Products() {
	return {
		type: types.REQUEST_TOP4PRODUCTS_DASHBOARD,
		loading: true
	}
}

export function requestTopCategoriesDashboard() {
	return {
		type: types.REQUEST_TOPCATEGORIES_DASHBOARD,
		loading: true
	}
}

export function requestPoStatusDashboard() {
	return { type: types.REQUEST_PO_DASHBOARD, loading: true }
}

export function dispatchPoHistoryDashboard(poDashboardViews) {
	return { type: types.GET_PO_DASHBOARD_SUCCESS, poDashboardViews }
}