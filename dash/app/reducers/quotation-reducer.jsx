import * as types from '../constants/action-types'

const initialState = {
  quotationRequestsList: [],
  quotationRequestsListCount: 0,
  isFetching: false,
  quotationDetails: [],
  suppliers: [],
}

const quotationsReducer = function(state = initialState, action) {

  switch(action.type) {  
  	case types.QUOTATIONS_REQUESTS_LISTS:
      return { ...state, quotationRequestsList: state.quotationRequestsList.concat(action.payload) }
    case types.QUOTATIONS_REQUESTS_LISTS_COUNT:
      return { ...state, quotationRequestsListCount: action.payload}
    case types.QUOTATIONS_REQUESTS_DETAILS:
      return { ...state, quotationDetails: action.payload}
    case types.QUOTATIONS_RESPOND_SUPPLIERS:
      return { ...state, suppliers: action.payload}
    case types.CLEAR_QUOTATIONS:
      return { ...state, quotationRequestsList: [], quotationRequestsListCount:0}
  	case types.QUOTATIONS_LOADING:
  		return {...state, isFetching: action.payload}
    default:
    	return state
  }

}

export default quotationsReducer