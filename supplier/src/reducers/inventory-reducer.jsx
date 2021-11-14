import * as types from '../constants/action-types'

const initialState = {
  parentChildStructure: [],
  inventoryLists: [],
  inventoryProducts: [],
  inventoryCount: null,
  defaultInventory: 0,
  isFetching: false,
}

const inventoryReducer = function(state = initialState, action) {

  switch(action.type) {  
  	case types.PARENT_CHILD_STRUCTURE:
      return { ...state, parentChildStructure: action.payload }
    case types.INVENTORY_LISTS:
      return { ...state, inventoryLists: action.payload }
    case types.INVENTORY_PRODUCTS:
      return { ...state, inventoryProducts: action.payload }
    case types.INVENTORY_COUNTS:
      return { ...state, inventoryCount: action.payload } 
    case types.DEFAULT_INVENTORY:
      return { ...state, defaultInventory: action.payload } 
  	case types.INVENTORY_LOADING:
      return {...state, isFetching: action.payload}
    default:
    	return state
  }

}

export default inventoryReducer