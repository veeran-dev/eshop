import * as types from '../constants/action-types'

const initialState = {
  allCustomers: [],
  rateContract: [],
  productList:[],
  productCount: 0,
  isFetching: false,
  contractCount: 0,
}

const catalogReducer = function(state = initialState, action) {

  switch(action.type) {  
  	case types.CONTRACT_LISTS:
      return { ...state, rateContract: action.payload }
    case types.ALL_CUSTOMERS:
      return { ...state, allCustomers: action.payload } 
    case types.CATALOG_LOADING:
      return {...state, isFetching: action.payload}
    case types.CONTRACT_COUNT:
      return {...state, contractCount: action.payload}
    case types.PRODUCT_LIST:
      return {...state, productList: action.payload}
    case types.PRODUCT_COUNT:
      return {...state, productCount: action.payload}
    default:
    	return state
  }

}

export default catalogReducer