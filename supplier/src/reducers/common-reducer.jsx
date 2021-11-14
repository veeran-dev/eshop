import * as types from '../constants/action-types'

const initialState = {
  allStates: [],
  selectedCities: [],
  selectedCategories: [],
  myBuyers: [],
}

const commonReducer = function(state = initialState, action) {

  switch(action.type) {  
  	case types.ALL_STATE:
      return { ...state, allStates: action.payload }
    case types.SELECTED_CITY:
      return { ...state, selectedCities: action.payload } 
    case types.SELECTED_CATEGORY:
      return { ...state, selectedCategories: action.payload } 
    case types.MY_BUYERS:
      return { ...state, myBuyers: action.payload } 
    default:
    	return state
  }

}

export default commonReducer