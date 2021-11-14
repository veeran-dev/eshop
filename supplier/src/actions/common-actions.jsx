import * as types from '../constants/action-types';

export function allState(data){
	return { type: types.ALL_STATE, payload: data}
}

export function selectedCity(data){
	return { type: types.SELECTED_CITY, payload: data}
}


export function selectedCategory(data){
	return { type: types.SELECTED_CATEGORY, payload: data}
}


export function myBuyers(data){
	return { type: types.MY_BUYERS, payload: data}
}
