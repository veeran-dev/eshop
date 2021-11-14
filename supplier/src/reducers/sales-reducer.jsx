import * as types from '../constants/action-types';

const initialState = {
  top_customer: [],
  monthly_sales: [],
  top_sold_products: [],
  dashboardKPI: [],
  isFetching: false,
  isFetchingMonthlySales: false,
  isFetchingTopProducts: false,
  isFetchingTopCustomers: false,
};

const salesReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.TOP_CUSTOMERS:
      return { ...state, top_customer: action.payload }
    case types.MONTHLY_SALES:
      return { ...state, monthly_sales: action.payload }
    case types.TOP_SOLD_PRODUCTS:
      return {...state, top_sold_products: action.payload}
    case types.DASHBOARD_KPI:
      return {...state, dashboardKPI: action.payload}
    case types.SALES_LOADING:
      return {...state, isFetching: action.payload}
    case types.TOP_CUSTOMERS_LOADING:
      return {...state, isFetchingTopCustomers: action.payload}
    case types.MONTHLY_SALES_LOADING:
      return {...state, isFetchingMonthlySales: action.payload}
    case types.TOP_PRODUCTS_LOADING:
      return {...state, isFetchingTopProducts: action.payload}
    default:
      return state
  }
}

export default salesReducer;
