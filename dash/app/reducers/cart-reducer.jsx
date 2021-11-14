import * as types from '../constants/action-types'

const initialState = {
  cart: [],
  summary: [],
  loyaltyCount: [],
  isFetchingCart: false,
  isFetchingSummary: false,
  isAddingProduct: false
}

const cartReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_CART:
        return { ...state, isFetchingCart: true }
    case types.REQUEST_CART_SUMMARY: 
        return { ...state, isFetchingSummary: true }
    case types.REQUEST_ADD_PRODUCT: 
        return { ...state, isAddingProduct: action.loading }
    case types.RESPONSE_ADD_PRODUCT: 
        return { ...state, isAddingProduct: action.loading }
    case types.GET_CART_SUCCESS:
        return { ...state, cart: action.cartProducts, isFetchingCart: action.loading }
    case types.GET_CART_SUMMARY:
        return { ...state, summary: action.cartSummary, isFetchingSummary: action.loading }
    case types.GET_LOYALTY_COUNT_SUCCESS:
        return { ...state, loyaltyCount: action.loyaltyPoints }
    default:
    	return state
  }
}

export default cartReducer
