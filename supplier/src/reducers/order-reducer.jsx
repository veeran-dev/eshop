import * as types from '../constants/action-types'

const initialState = {
  allCustomers: [],
  orderLists: [],
  orderDetails: [],
  orderStatus: [],
  orderProducts:[],
  orderStatusCount:[],
  orderCount: null,
  orderWidgetList: [],
  orderWidgetCount: null,
  invoiceAddress: null,
  deliveryAddress: null,
  orderEDT:null,
  isFetching: false,
  ordersSchedule: [],
}

const dashboardReducer = function(state = initialState, action) {

  switch(action.type) {  
  	case types.ORDER_LISTS:
      return { ...state, orderLists: action.payload }
    case types.ORDERS_SCHEDULE:
      return { ...state, ordersSchedule: action.payload }
    case types.ORDER_COUNTS:
      return { ...state, orderCount: action.payload } 
    case types.WIDGET_ORDER_LISTS:
      return { ...state, orderWidgetList: action.payload }
    case types.WIDGET_ORDER_COUNTS:
      return { ...state, orderWidgetCount: action.payload }
  	case types.ORDER_DETAILS:
      return { ...state, orderDetails: action.payload }
    case types.ORDER_STATUS:
      return { ...state, orderStatus: action.payload }
    case types.ORDER_PRODUCTS:
      return { ...state, orderProducts: action.payload }
    case types.ORDER_DADDRESS:
      return { ...state, deliveryAddress: action.payload }
    case types.ORDER_IADDRESS:
      return { ...state, invoiceAddress: action.payload }
  	case types.ORDER_LOADING:
      return {...state, isFetching: action.payload}
    case types.ORDER_STATUS_WITH_COUNT:
      return { ...state, orderStatusCount: action.payload } 
    case types.ALL_CUSTOMERS:
      return { ...state, allCustomers: action.payload } 
    default:
    	return state
  }

}

export default dashboardReducer