import * as types from '../constants/action-types'

const initialState = {
  orderHistory: [],
  homeApprovals: [],
  relationshipManager: [],
  top4Products: [],
  topCategory: [],
  eliteDeals: [],
  poViewsDashboard: [],
  orderHistCount: "",
  orderHistPageId: "",
  approvalsCount: "",
  approvalsPageId: "",
  isFetchingHistory: false,
  isFetchingApprovals: false,
  isFetchingRm: false,
  isFetchingTop4Products: false,
  isFetchingCategories: false,
  isFetchingPoDashboard: false
}

const dashboardReducer = function(state = initialState, action) {

  switch(action.type) {
    case types.REQUEST_ORDER_STATUS_DASHBOARD:
      return { ...state, isFetchingHistory: action.loading }
    case types.REQUEST_APPROVALS_DASHBOARD:
      return { ...state, isFetchingApprovals: action.loading }
    case types.REQUEST_RM_DASHBOARD:
      return { ...state, isFetchingRm: action.loading }
    case types.REQUEST_TOP4PRODUCTS_DASHBOARD:
      return { ...state, isFetchingTop4Products: action.loading }
    case types.REQUEST_TOPCATEGORIES_DASHBOARD:
      return { ...state, isFetchingCategories: action.loading }
    case types.GET_ELITE_DEALS:
      return { ...state, eliteDeals: action.deals }
    case types.REQUEST_PO_DASHBOARD:
      return { ...state, isFetchingPoDashboard: action.loading }
    case types.GET_ORDER_HISTORY_SUCCESS:
        return { ...state,
          orderHistory: action.orderHistory.results, 
          orderHistCount: action.orderHistory.total, 
          orderHistPageId: action.orderHistory.pageId, 
          isFetchingHistory: false
        }
    case types.GET_APPROVALS_HOME_SUCCESS:
    	return { ...state,
    		homeApprovals: action.Approvals.results, 
        approvalsCount: action.Approvals.total, 
        approvalsPageId: action.Approvals.pageId, 
        isFetchingApprovals: false
    	}
    case types.GET_PO_DASHBOARD_SUCCESS:
      return { ...state,
        poViewsDashboard: action.poDashboardViews.results, 
        poViewsCount: action.poDashboardViews.total, 
        poPageId: action.poDashboardViews.pageId, 
        isFetchingPoDashboard: false
      }
    case types.GET_RM_SUCCESS:
    	return { ...state, relationshipManager: action.relationshipManager, isFetchingRm: false }
    case types.GET_TOP4_PRODUCTS_SUCCESS:
    	return { ...state, top4Products: action.top4Products, isFetchingTop4Products: false }
    case types.GET_TOP_CATEGORY_SUCCESS:
    	return { ...state, topCategory: action.topCategory[1], isFetchingCategories: false }
    default:
    	return state
  }

}

export default dashboardReducer
