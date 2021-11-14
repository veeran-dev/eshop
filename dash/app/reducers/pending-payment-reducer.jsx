import * as types from '../constants/action-types';

const initialState = {
  pendingpayments: [],
  count: "",
  invoice_status: [],
  isFetchingPendingPayments: false,
};

const pendingPaymentReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_PENDING_PAYMENT:
      return { ...state, isFetchingPendingPayments: action.loading }
    case types.GET_PENDING_PAYMENT:
      return { ...state, pendingpayments: action.pendingpayments.results,invoice_status:action.pendingpayments.status, count: action.pendingpayments.total, isFetchingPendingPayments: false }
    default:
      return state
  }

  return state;

}

export default pendingPaymentReducer;
