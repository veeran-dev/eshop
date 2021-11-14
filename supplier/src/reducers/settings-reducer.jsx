import * as types from '../constants/action-types';

const initialState = {
	logo: "",
	prefix: "",
  number: "",
  isFetching: false,
};

const settingsReducer = function(state = initialState, action) {
  switch(action.type) {
  	case types.GET_CUSTOMER_LOGO_SUCCESS:
    	return { ...state, logo: action.payload }
    case types.DR_PREFIX:
    	return { ...state, prefix: action.payload }
    case types.DR_NUMBER:
      return { ...state, number: action.payload }
    case types.SETTINGS_LOADING:
      return {...state, isFetching: action.payload}
    default:
      return state
  }
}

export default settingsReducer;
