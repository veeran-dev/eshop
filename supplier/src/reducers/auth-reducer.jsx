import * as types from '../constants/action-types'

const initialState = {
	supplier: [],
	registration_error: "",
	loading: false,
  step: 1,

}

const authReducer = function(state = initialState, action) {

  switch(action.type) {  
  	case types.AUTH_DATA:
      return { ...state, supplier: action.payload }
  	case types.SET_REG_ERROR:
      return { ...state, registration_error: action.payload }
    case types.SET_REG_STEP:
      console.log(action.payload)
      return { ...state, step: action.payload }
  	case types.AUTH_LOADING:
  		return {...state, loading: action.payload}
    default:
    	return state
  }

}

export default authReducer