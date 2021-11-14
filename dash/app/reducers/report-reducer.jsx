import * as types from '../constants/action-types'

const initialState = {
  purchaseHistory: [],
  categories: [],
  defaultCenter: [],
  defaultZoom: 10,
  center: [],
  markers: [],
  currentPlace: {},
  currentSelectedMarker: "",
  locationData: [],
  locationStateWise: [],
  isFetchingHistory: false,
  isFetchingCategory: false,
  isFetchingLocations: false
};

export default function report(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_HISTORY_CHART:
        return { ...state, isFetchingHistory: action.loading }
    case types.REQUEST_CATEGORY_CHART:
        return { ...state, isFetchingCategory: action.loading }
    case types.REQUEST_LOCATIONS_CHART:
        return { ...state, isFetchingLocations: action.loading }
    case types.GET_HISTORY_SUCCESS:
      	return { ...state, purchaseHistory: action.history, isFetchingHistory: false }
    case types.GET_CATEGORY_SUCCESS:
    	return { ...state, categories: action.categories, isFetchingCategory: false }
    case types.MAP_LOCATION_CAPTURED:
      return { ...state, center: action.newLocation }
    case types.GET_LOCATIONS_SUCCESS:
      return { ...state, locationData: action.locationData, locationStateWise: action.states, isFetchingLocations: false }
    default:
    	return state
  }
}