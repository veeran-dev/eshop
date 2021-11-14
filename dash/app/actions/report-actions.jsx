import * as types from '../constants/action-types';

export function getPurchaseHistoryReport(histories){
  return { type: types.GET_HISTORY_SUCCESS, history: histories}
}

export function categoryReport(categories){
	return { type: types.GET_CATEGORY_SUCCESS, categories: categories}
}

export function locationCaptured(newLocation){
	return { type: types.MAP_LOCATION_CAPTURED, newLocation	}
}

export function locationReport(locationData, states){
	return { type: types.GET_LOCATIONS_SUCCESS, locationData: locationData, states: states}
}

export function requestHistoryReport() {
	return { type: types.REQUEST_HISTORY_CHART, loading: true }
}

export function requestCategoryReport() {
	return { type: types.REQUEST_CATEGORY_CHART, loading: true }
}

export function requestLocationsReport() {
	return { type: types.REQUEST_LOCATIONS_CHART, loading: true }
}