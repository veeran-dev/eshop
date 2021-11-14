import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/dashboard-actions'
import {toastr} from 'react-redux-toastr';

export function getOrderStatus(limit, offset, fromDate, toDate, duration, idPage) {
  store.dispatch(action.requestOrderStatusDashboard())
  return axios.get('dash-history.php?ajax=true&type=5&limit='+limit+'&offset='+offset+'&fromDate='+fromDate+'&toDate='+toDate+'&duration='+duration+'&idPage='+idPage).then(response => {
      store.dispatch(action.dispatchHistory(response.data))
      return response
  })
}

export function getPoViews(limit, offset, fromDate, toDate, duration, idPage) {
  store.dispatch(action.requestPoStatusDashboard())
  return axios.get('purchase-order.php?ajax=true&type=5&limit='+limit+'&offset='+offset+'&fromDate='+fromDate+'&toDate='+toDate+'&duration='+duration+'&idPage='+idPage).then(response => {
      store.dispatch(action.dispatchPoHistoryDashboard(response.data))
      return response
  })
}

export function getApprovals(limit, offset, fromDate, toDate, duration, idPage){
  store.dispatch(action.requestApprovalsDashboard())
	return axios.get('dash-history.php?ajax=true&type=8&customerid='+id_customer+'&limit='+limit+'&offset='+offset+'&fromDate='+fromDate+'&toDate='+toDate+'&duration='+duration+'&idPage='+idPage).then(response => {
      store.dispatch(action.dispatchApprovals(response.data))
      return response
    })
} 

export function getRM(){
  store.dispatch(action.requestRmDashboard())
	return axios.get('dash-relationship-manager.php?type=0&id_customer='+id_customer).then(response => {
      store.dispatch(action.dispatchRM(response.data))
      return response
    })
}

export function getTop4Products(fromDate, toDate, duration){
  store.dispatch(action.requestTop4Products())
	return axios.get('dash-reports.php?type=5&customerid='+id_customer+'&duration='+duration+'&from_date='+fromDate+'&to_date='+toDate).then(response => {
      store.dispatch(action.dispatchTop4Products(response.data))
      return response
    })
}

export function topCategories(fromDate, toDate, duration){
  store.dispatch(action.requestTopCategoriesDashboard())
	return axios.get('dash-reports.php?type=7&customerid='+id_customer+'&duration='+duration+'&from_date='+fromDate+'&to_date='+toDate).then(response => {
      store.dispatch(action.dispatchTopCategory(response.data))
      return response
    })
}

export function sendPromotionalMailToRM(){
    var data = new FormData()
    data.append('customer_id', id_customer)
    return axios.post('dash-festive.php', data).then(response => {
        toastr.success('Success', 'Thank you. Our Relationship Manager will contact you shortly.', {icon: "icon-succes", "hideDuration": "2500", "timeOut": "2500"});
        return response
    });
}

export function getEliteDealsDetails(){
  return axios.post('dash-festive.php?elite-deals=1&customerid='+id_customer+'').then(response => {
        store.dispatch(action.dispatchEliteDeals(response.data))
        return response
    }); 
}