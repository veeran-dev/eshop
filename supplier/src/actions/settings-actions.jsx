import * as types from '../constants/action-types';

export function customerLogo(logo) {
  return {
    type: types.GET_CUSTOMER_LOGO_SUCCESS,
    payload: logo
  };
}

export function setDrPrefix(data) {
	return {type: types.DR_PREFIX, payload: data}; 
}

export function setDrNumber(data) {
	return {type: types.DR_NUMBER, payload: data}; 
}

export function loading(status){
	return { type: types.SETTINGS_LOADING, payload: status}
}
