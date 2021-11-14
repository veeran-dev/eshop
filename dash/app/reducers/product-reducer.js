import * as types from '../constants/action-types';

const initialState = {
  product_details: [],
  supplier_details: [],
  loading: false,
};

const ProductReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.PRODUCT_DETAILS:
        return {...state, product_details:action.payload}
    case types.SUPPLIER_DETAILS:
        return {...state, supplier_details:action.payload}
    case types.SUPPLIER_FETCHING:
        return {...state, loading:action.payload}
    default:
      return state
  }
}

export default ProductReducer;