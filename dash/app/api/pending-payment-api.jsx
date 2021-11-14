import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/pending-payment-actions'


/**
 * Get user pending payments and related documents
 */

export function getPaymentPendings(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, query, filter_status) {
  store.dispatch(action.requestPendingPayment(true))
  return axios.get('dash-pending-payments.php?ajax=true&type=1&widget=true&id_widget=4&id_customer='+id_customer+"&limit="+limit+"&offset="+offset+"&fromDate="+fromDate+"&toDate="+toDate+"&duration="+duration+"&idPage="+idPage+"&orderBy="+orderBy+"&orderWay="+orderWay+"&q="+query+"&filter_status="+filter_status)
    .then(response => {
      store.dispatch( action.getPendingPaymentSuccess(response.data) )
      store.dispatch(action.requestPendingPayment(false))
      return response
    })
}