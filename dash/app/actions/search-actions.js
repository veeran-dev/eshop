import * as types from '../constants/action-types';

export function getAllAvailableResults(data){
	return {
		type: types.ALL_AVAILABLE_RESULTS,
		payload: data
	}
}

export function clearResults(data){
	return {
		type: types.CLEAR_RESULTS,
		payload: data
	}
}

export function allCategoryResults(data){
	return {
		type: types.ALL_CATEGORY_RESULTS,
		payload: data
	}
}

export function allManufacturerResults(data){
	return {
		type: types.ALL_BRAND_RESULTS,
		payload: data
	}
}

export function updateCategoryResults(data){
	return {
		type: types.UPDATE_CATEGORY_RESULTS,
		payload: data
	}
}

export function updateManufacturerResults(data){
	return {
		type: types.UPDATE_BRAND_RESULTS,
		payload: data
	}
}

export function zones(data){
	return {
		type: types.ALL_ZONES,
		payload: data
	}
}

export function maxPriceResults(data){
	return {
		type: types.MAX_PRICE,
		payload: data
	}
}

export function searching(){
	return{
		type: types.SEARCHING,
		loading: true
	}
}

export function gotIt(){
	return{
		type: types.GOT_IT,
		loading: false
	}
}

export function searchDetails(data){
	return{
		type: types.SEARCH_DETAILS,
		payload: data
	}
}

export function clearFilters(){
	return{
		type: types.CLEAR_FILTERS,
		payload: true
	}
}