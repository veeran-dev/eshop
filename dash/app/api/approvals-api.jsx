import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/approval-actions'
import * as cartApi from '../api/cart-api'
import * as dashboardApi from '../api/dashboard-api'
import * as G from '../api/common-api'
import {toastr} from 'react-redux-toastr';

/**
 * Get user approvals
 */
export function getApprovals(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, query){
    store.dispatch(action.requestApprovals())
    return axios.get('dash-history.php?ajax=true&type=7&widget=true&id_widget=5&id_customer='+id_customer+"&limit="+limit+"&offset="+offset+"&fromDate="+fromDate+"&toDate="+toDate+"&duration="+duration+"&idPage="+idPage+"&orderBy="+orderBy+"&orderWay="+orderWay+"&q="+query).then(response => {
      store.dispatch(action.getApprovalsSuccess(response.data))
      return response
    })
} 

export function approveOrder(idOrder, idPayment, elementID, dashboard, epayLaterId){
    var data = new FormData()
    data.append('type', 1)
    data.append('orderid', idOrder)
    data.append('id_customer', id_customer)
    data.append('payment_type', idPayment)

    let message = "";
    if(idPayment != 5)
        message = "Order Approved Successfully";
    else
        message = "Order Sent for Approval Successfully"

    if(idPayment == 7) {
        if(epayLaterId != "") {
            data.append('id_pay_later', $epayLaterId);
            return axios.post('dash-approve.php', data).then(response => {
                toastr.success('Success', message, {icon: 'icon-succes'})
                if(dashboard && dashboard == 1){
                    dashboardApi.getApprovals(4, 0, "", "", 5, 0)
                }
                else
                    this.getApprovals(10, 0, "", "", 5, "", "o.`id_order`", "DESC", "")
                return response
            });
        }
        else {}
    }
    else {
        return axios.post('dash-approve.php', data).then(response => {
            toastr.success('Success', message, {icon: 'icon-succes'})
            if(dashboard && dashboard == 1){
                dashboardApi.getApprovals(4, 0, "", "", 5, 0)
            }
            else
                this.getApprovals(10, 0, "", "", 5, "", "o.`id_order`", "DESC", "")
            return response
        });
    }
}

export function rejectOrder(idOrder, cancelReason, elementID, dashboard){
	var data = new FormData()
    data.append('type', 2)
    data.append('orderid', idOrder)
    data.append('id_customer', id_customer)
    data.append('cancel_reason', cancelReason)

    return axios.post('dash-approve.php', data).then(response => {
        toastr.success('Success', 'Order Cancelled Successfully.', {icon: 'icon-succes'})
        if(dashboard){
            dashboardApi.getApprovals(4, 0, "", "", 5, 0)
        }
        else{
            this.getApprovals(10, 0, "", "", 5, "", "o.`id_order`", "DESC", "")
        }
        return response
    });
}

export function reviseOrder(idOrder, router, elementID){
	var data = new FormData()
    data.append('type', 3)
    data.append('orderid', idOrder)
    data.append('id_customer', id_customer)

    G.closeModal([elementID])

    return axios.post('dash-approve.php', data).then(response => {
        // Close the if pop-up is used to reject order
        cartApi.get()
        router.push("procure/purchase-list")
        return response
    });
}