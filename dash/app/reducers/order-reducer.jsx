import * as types from '../constants/action-types'

const initialState = {
  orders: [],
  orderComplete: [],
  uniqueOrder:[],
  orderCount: "",
  orderPageDataFlow: [],
  orderPageProducts: [],
  orderPageSummary: [],
  orderPageTax: [],
  billingAddress: [],
  shippingAddress: [],
  isFetching: false,
  isFetchingOrders: false,
  isFetchingOrderComplete: false,
  isFetchingUniqueOrder: false,
  orderPaymentMethod: '',
  orderProcessStatus: true,
  orderDetails: [],
  canceledProducts: [],
  deliveryPlans: [],
  orderDetailProducts: [],
  orderStatuses: [],
};

const orderReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_ORDERS:
        return { ...state, isFetchingOrders: action.loading }
    case types.ORDER_DETAIL_LOADING:
        return { ...state, isFetching: action.isFetching }
    case types.ORDER_DETAILS:
        return { ...state, orderDetails: action.payload }
    case types.ORDER_DELIVERY_ADDRESS:
        return { ...state, shippingAddress: action.payload }
    case types.ORDER_INVOICE_ADDRESS:
        return { ...state, billingAddress: action.payload }
    case types.ORDER_PRODUCT_DETAILS:
        return { ...state, orderDetailProducts: action.payload }
    case types.ORDER_ORDER_STATUS:
        return { ...state, orderStatuses: action.payload }
    case types.ORDER_SCHEDULED_PRODUCT:
        return { ...state, deliveryPlans: action.payload }
    case types.ORDER_CANCELED_PRODUCT:
        return { ...state, canceledProducts: action.payload }
    case types.REQUEST_ORDER_COMPLETE:
        return { ...state, isFetchingOrderComplete: action.loading }
    case types.REQUEST_UNIQUE_ORDER:
        return { ...state, isFetchingUniqueOrder: action.loading }
    case types.GET_ORDERS_SUCCESS:
      	return { ...state, orders: action.orders, orderCount: action.count, isFetchingOrders: false }
    case types.ORDER_COMPLETE_SUCCESS:
      return { ...state, orderComplete: action.completeResponse, isFetchingOrderComplete: false }
    case types.GET_ORDER_BY_ID:
      return { ...state, uniqueOrder: action.orderData, isFetchingUniqueOrder: false }
    case types.GET_ORDER_PAGE_DATA_SUCCESS:
      return { ...state,
        orderPageDataFlow: action.orderPageData[0],
        orderPageProducts: action.orderPageData[3],
        orderPageSummary: action.orderPageData[5],
        orderPageTax: action.orderPageData[4],
        billingAddress: action.orderPageData[1],
        shippingAddress: action.orderPageData[2],
        isFetchingUniqueOrder: false
      }
    case types.CLEAN_ORDER_DETAILS:
      return { ...state,
        orderDetails: [],
        orderDetailProducts: [],
        deliveryPlans: [],
        canceledProducts: [],
        billingAddress: [],
        shippingAddress: [],
      }
    case types.GET_ORDER_PAYMENT_METHOD:
      return { ...state, orderPaymentMethod: action.payload }
    case types.ORDER_PROCESS_STATUS:
      return { ...state, orderProcessStatus: action.payload }
    case types.ORDER_LIST_LOADING:
      return { ...state, isFetching: action.payload}
    default:
    	return state
  }
}

export default orderReducer
