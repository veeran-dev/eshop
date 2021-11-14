import * as types from '../constants/action-types'

const initialState = {
  address: [],
  uniqueAddress: [],
  paymentModes: [],
  states: [],
  orderID: "",
  dealsBanner: [],
  dealsTitle: [],
  dealsHash: [],
  deals1: [],
  deals2: [],
  deals3: [],
  deals4: [],
  billingAddress: [],
  isFetchingDeals: false,
  isFetchingAddress: false,
  isFetchingUniqueAddress: false,
  isFetchingPaymentModes: false,
  allStates: [],
  addressStates: [],
  purchaseOrders: []
}

const addressReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_PAYMENT_MODES:
        return { ...state, isFetchingPaymentModes: action.loading }
    case types.REQUEST_UNIQUE_ADDRESS:
        return { ...state, isFetchingUniqueAddress: action.loading }
    case types.REQUEST_ADDRESS_LIST:
        return { ...state, isFetchingAddress: action.loading }
    case types.REQUEST_DEALS:
        return { ...state, isFetchingDeals: action.loading }
    case types.GET_ADDRESS_SUCCESS:
        return { ...state, address: action.address, isFetchingAddress: false }
    case types.GET_UNIQUE_ADDRESS_SUCCESS:
        return { ...state, uniqueAddress: action.uniqueAddress, isFetchingUniqueAddress: false }
    case types.GET_PAYMENT_SUCCESS:
        return { ...state, paymentModes: action.paymentModes, isFetchingPaymentModes: false }
    case types.GET_STATE_SUCCESS:
        return { ...state, states: action.states}
    case types.GET_ORDER_ID_PAYMENT:
        return { ...state, orderID: action.orderID }
    case types.GET_DEALS_SUCCESS:
        return { ...state, dealsBanner: action.deals[0], dealsTitle: action.deals[1], dealsHash: action.deals[2], 
            deals1: action.deals[3][1], deals2: action.deals[3][2], deals3: action.deals[3][3], deals4: action.deals[3][4], isFetchingDeals: false }
    case types.GET_BILLING_ADDRESS_SUCCESS:
        return { ...state, billingAddress: action.billingAddress, isFetchingUniqueAddress: false }
    case types.ALL_STATES_RESPONSE:
        return { ...state, allStates: action.allStates }
    case types.CUSTOMER_STATES_FOR_REPORTS:
        return {...state, customerStates: action.reportStates}
    case types.PURCHASE_ORDERS_BY_ADDRESS:
        return {...state, purchaseOrders: action.payload }
    default:
    	return state
  }
}

export default addressReducer
