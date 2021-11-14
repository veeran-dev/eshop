import * as types from '../constants/action-types'

const initialState = {
  supplierAddress: "",
  allStates:[],
  isFetching: false,
}

const addressReducer = function(state = initialState, action) {

  switch(action.type) {  
    case types.SUPPLIER_ADDRESS:
      return { ...state, supplierAddress: action.payload }
    case types.ADDRESS_STATES:
      return { ...state, allStates: action.payload }
  	case types.ADDRESS_LOADING:
  		return {...state, isFetching: action.payload}
    default:
    	return state
  }

}

export default addressReducer