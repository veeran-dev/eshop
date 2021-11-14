import * as types from '../constants/action-types';

const initialState = {
  invoices: [],
  count: "",
  deliveryReceipts: [],
  deliveryCount: "",
  isFetchingInvoices: false,
  isFetchingDrs: false
};

const invoiceReducer = function(state = initialState, action) {
  switch(action.type) {
    case types.REQUEST_INVOICE:
      return { ...state, isFetchingInvoices: action.loading }
    case types.REQUEST_DELIVERY_RECIEPT:
      return { ...state, isFetchingDrs: action.loading }
    case types.GET_INVOICES_SUCCESS:
      return { ...state, invoices: action.invoices.results, count: action.invoices.total, isFetchingInvoices: false }
    case types.GET_DR_SUCCESS:
      return { ...state, deliveryReceipts: action.deliveryReceipts.results, deliveryCount: action.deliveryReceipts.total, isFetchingDrs: false }
    default:
      return state
  }

  return state;

}

export default invoiceReducer;
