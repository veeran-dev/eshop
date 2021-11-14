import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/order-actions'
import * as addressActions from '../actions/address-actions'

import ViewHistory from '../components/modules/Orders/order-history'
import SplitOrderDetails from '../components/modules/Orders/splitOrderDetails'
import * as G  from './common-api'

export function getOrders(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, status, idGroup){
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-order.php',
                    {params: {
                      ajax: true,
                      type: 1,
                      limit: limit,
                      offset: offset,
                      fromDate: fromDate,
                      toDate: toDate,
                      duration: duration,
                      idPage: idPage,
                      orderBy: orderBy,
                      orderWay: orderWay,
                      q:q,
                      status: status,
                      idGroup:idGroup,
                  }}).then(response => {
                  if(response.data != undefined ){
                    
                    if(limit > 9){
                      store.dispatch(action.setOrderLists(response.data['orders']))
                      store.dispatch(action.setOrderCount(response.data['order_count']))
                      store.dispatch(action.setOrderStatusWithCount(response.data['order_states']))
                      store.dispatch(action.setAllCustomers(response.data['customers']))
                    }
                    else if(limit < 9){
                      store.dispatch(action.setWidgetOrderLists(response.data['orders']))
                      store.dispatch(action.setWidgetOrderCount(response.data['order_count']))
                    }
                  }
                  else{
                    store.dispatch(action.setOrderLists([])) 
                  }
                  store.dispatch(action.loading(false))
                  return response
  });
}

export function viewOrder(id_order){
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-order.php',
                    {params: {
                      ajax: true,
                      type: 2,
                      id_order: id_order,
                  }}).then(response => {
                  if(response.data['0'] != undefined && response.data.length > 0){
                    store.dispatch(action.setOrderDetails(response.data[0]))
                    store.dispatch(action.setOrderStatus(response.data[4]))
                    store.dispatch(action.setOrderProducts(response.data[3]))
                    store.dispatch(action.setOrderDeliveryAddress(response.data[2]))
                    store.dispatch(action.setOrderInvoiceAddress(response.data[1]))
                    store.dispatch(addressActions.setSupplierAddress(response.data[5]))
                  }
                  else{
                    store.dispatch(action.setOrderDetails([])) 
                    store.dispatch(action.setOrderStatus([]))
                    store.dispatch(action.setOrderProducts([]))
                    store.dispatch(action.setOrderDeliveryAddress([]))
                    store.dispatch(action.setOrderInvoiceAddress([]))
                    store.dispatch(addressActions.setSupplierAddress([]))
                  }
                  store.dispatch(action.loading(false))
                  return response
  });
}

export function updateEDT(id_order, date){
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-order.php',
                    {params: {
                      ajax: true,
                      type: 4,
                      id_order: id_order,
                      date: date,
                  }}).then(response => {
                    if(response.data != "" && response.data['success'] != undefined) {
                        toastr.success('Success', response.data['success'], { icon: "icon-success"})
                        viewOrder(id_order)
                    }
                    else if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                  store.dispatch(action.loading(false))
                  return response
  }); 
}

export function updateOrderStatus(id_order, id_order_state){
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-order.php',
                    {params: {
                      ajax: true,
                      type: 3,
                      id_order: id_order,
                      id_order_state: id_order_state,
                  }}).then(response => {
                    if(response.data != "" && response.data['success'] != undefined) {
                        toastr.success('Success', response.data['success'], { icon: "icon-success"})
                        viewOrder(id_order)
                    }
                    else if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                  store.dispatch(action.loading(false))
                  return response
  }); 
}

export function viewHistory(id_order){
 store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-order.php',
                    {params: {
                      ajax: true,
                      type: 5,
                      id_order: id_order,
                  }}).then(response => {
                    ReactDOM.render(<ViewHistory history={response.data}/>, document.getElementById("orderHistoryContent"))
                    G.displayModal("orderHistory")
                    store.dispatch(action.loading(false))
                    return response
  });  
}

export function removeProducts(id_order, list){
 store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-order.php',
                    {params: {
                      ajax: true,
                      type: 6,
                      id_order: id_order,
                      list: list,
                  }}).then(response => {
                    if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                    else if(response.data['0'] != undefined && response.data.length > 0){
                      store.dispatch(action.setOrderDetails(response.data[0]))
                      store.dispatch(action.setOrderStatus(response.data[4]))
                      store.dispatch(action.setOrderProducts(response.data[3]))
                      store.dispatch(action.setOrderDeliveryAddress(response.data[2]))
                      store.dispatch(action.setOrderInvoiceAddress(response.data[1]))
                      toastr.success('Success', "Product's quantity removed successfully", { icon: "icon-success"})
                    }
                    store.dispatch(action.loading(false))
                    return response
  });  
}

export function splitOrder(id_order, id_order_detail, cancelQuantity, po_number, edt){
 store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-split-order.php',
                    {params: {
                      ajax: true,
                      type: 1,
                      id_order: id_order,
                      id_order_detail:id_order_detail,
                      cancelQuantity:cancelQuantity,
                      po_number: po_number,
                      split_order: true,
                      edt: edt,
                  }}).then(response => {
                    if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                    else if(response.data['0'] != undefined && response.data.length > 0){
                      let result = response.data.split('~')
                      let newOrder= result[0]
                      let oldOrder=id_order;
                      let newOrderProducts=result[2]
                      let oldOrderProducts=result[3];
                      // ReactDOM.render(<SplitOrderDetails newOrder={newOrder} oldOrder={oldOrder} newOrderProducts={newOrderProducts} oldOrderProducts={oldOrderProducts}/>, document.getElementById("splitOrderContent"))
                      // G.displayModal("splitOrder")
                      // viewOrder(id_order)
                    }
                    store.dispatch(action.loading(false))
                    return response
  });  
}

 export function notifyDeliveryPlan(id_order){
  return axios.post('../elite-supplier-order.php?type=9&id_order='+id_order).then(response => {
    return response
  })
 }

 export function ordersSchedule(){
  return axios.post('../elite-supplier-order.php?type=10').then(response => {
    store.dispatch(action.ordersSchedule(response['schedule']))
    return response
  })
 }

 export function upload(id_order, id_delivery, drDate, dr, invoice){

    const data = new FormData();
    data.append('id_order', id_order)
    data.append('id_delivery', id_delivery)
    data.append('dr_date', drDate)
    if(dr){
      dr.map(x=>{data.append('dr_files[]', x)})  
    }
    if(invoice){
      invoice.map(y=>{data.append('invoice_files[]', y)})
    }
    
    store.dispatch(action.loading(true))
    return axios.post('../elite-supplier-order.php?type=7', data)
      .then(response => {
        store.dispatch(action.loading(false))
        return response
      })
 }

 export function updatePayment(id_order, date){
  return axios.post('../elite-supplier-order.php?type=8&id_order='+id_order+'&date='+date).then(response => {
    return response
  })
 }