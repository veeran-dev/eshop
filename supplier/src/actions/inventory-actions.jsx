import * as types from '../constants/action-types';


export function getHierarchy(data) {
	return {type: types.PARENT_CHILD_STRUCTURE, payload: data}; 
}

export function setInventory(data) {
	console.log(data)
	return {type: types.INVENTORY_LISTS, payload: data}; 
}

export function setInventoryProducts(data) {
	console.log(data)
	return {type: types.INVENTORY_PRODUCTS, payload: data}; 
}

export function setInventoryListCount(data) {
	return {type: types.INVENTORY_COUNTS, payload: data}; 
}

export function loading(status){
	return { type: types.SETTINGS_LOADING, payload: status}
}

export function defaultInventory(data){
	return { type: types.DEFAULT_INVENTORY, payload: data}
}