import * as types from '../constants/action-types';

const initialState = {
	customerLogo: "",
	poOptions: []
};

const settingsReducer = function(state = initialState, action) {
  switch(action.type) {
  	case types.GET_CUSTOMER_LOGO_SUCCESS:
    	return { ...state, customerLogo: action.customerLogo }
    case types.GET_PO_OPTIONS_SUCCESS:
    	return { ...state, poOptions: action.poOptions }
    default:
      return state
  }
}

export default settingsReducer;
