import * as types from '../constants/action-types';

export function setUser(data){
	return {
		type: types.AUTH_DATA,
		payload: data
	}
}

export function setError(status){
	return { type: types.SET_REG_ERROR, payload: status}
}

export function regStep(status){
	return { type: types.SET_REG_STEP, payload: status}
}


export function loading(status){
	return { type: types.AUTH_LOADING, payload: status}
}
