import * as types from '../constants/action-types';

export function customerLogo(logo) {
  return {
    type: types.GET_CUSTOMER_LOGO_SUCCESS,
    customerLogo: (logo != "" ? logo+"?id="+'_'+ Math.random().toString(36).substr(2, 9) : "")
  };
}

export function poOptions(poOptions) {
	return {type: types.GET_PO_OPTIONS_SUCCESS, poOptions: poOptions}; 
}