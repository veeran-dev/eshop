import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/invoice-actions'

/**
 * Get user invoices
 */

export function getInvoices(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, query) {
  store.dispatch(action.requestInvoice())
  return axios.get('dash-invoicedata.php?ajax=true&type=1&widget=true&id_widget=4&id_customer='+id_customer+"&limit="+limit+"&offset="+offset+"&fromDate="+fromDate+"&toDate="+toDate+"&duration="+duration+"&idPage="+idPage+"&orderBy="+orderBy+"&orderWay="+orderWay+"&q="+query)
    .then(response => {
      store.dispatch( action.getInvoicesSuccess(response.data) )
      return response
    })
}

/**
 * Get user Delivery Receipts
 */
export function getDRs(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, query) {
  store.dispatch(action.requestDrs())
  return axios.get('dash-deliverydata.php?ajax=true&widget=true&id_widget=4&id_customer='+id_customer+"&limit="+limit+"&offset="+offset+"&fromDate="+fromDate+"&toDate="+toDate+"&duration="+duration+"&idPage="+idPage+"&orderBy="+orderBy+"&orderWay="+orderWay+"&q="+query)
    .then(response => {
      store.dispatch( action.getDRsSuccess(response.data) )
      return response
    })
}