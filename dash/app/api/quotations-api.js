import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/quotation-actions'

export function getQuotationsRequests(query, page, limit, clear){
 store.dispatch(action.loading(true))
 if(clear)   {
    store.dispatch(action.clearQuotationsRequestsList([]))  
 }
  return axios.get('./elite-quotation-api.php',
                    {params: {
                      ajax: true,
                      type: 1,
                      query: query,
                      page: page,
                      limit: limit,
                      id_customer: id_customer,
                  }}).then(response => {
                    if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                    else if(response.data['success'].length > 0){ 
                      if(clear)   {
                          store.dispatch(action.clearQuotationsRequestsList([]))  
                       }
                      store.dispatch(action.quotationsRequestsList(response.data['success']))  
                      store.dispatch(action.quotationsRequestsListCount(response.data['count'][0]['count']))  
                    }
                    store.dispatch(action.loading(false))
                    return response
  });
}

export function cancelQuotationsRequests(id){
  return axios.get('./elite-quotation-api.php',
                    {params: {
                      ajax: true,
                      type: 8,
                      id: id,
                  }}).then(response => {
                    if(response.data != "" && response.data['error'] !== undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                    else if(response.data['success'] !== undefined){ 
                        toastr.success('Success', response.data['success'], { icon: "icon-succes"}) 
                        document.getElementById(id+"_status").innerHTML="Cancelled";
                        document.getElementById(id+"_cancel").remove();
                    }
                    return response
  });
}

export function getQuotationsDetails(id){
  store.dispatch(action.loading(true))

  return axios.get('./elite-quotation-api.php',
                    {params: {
                      ajax: true,
                      type: 2,
                      id_customer: id_customer,
                      id_quotation: id,
                  }}).then(response => {
                    console.log(response)
                    if(response.data['details'].length > 0){ 
                      store.dispatch(action.quotationsDetails(response.data['details'][0]))  
                      store.dispatch(action.supplierssDetails(response.data['supplier']))  
                    }
                    store.dispatch(action.loading(false))
                    return response
  });
}

export function confirmQuotation(idQuoteRequest, idSupplier, price, option){
  store.dispatch(action.loading(true))
  return axios.get('./elite-quotation-api.php',
                    {params: {
                      ajax: true,
                      type: 3,
                      option: option,
                      idSupplier: idSupplier,
                      idQuoteRequest: idQuoteRequest,
                      price: price,
                  }}).then(response => {
                    console.log(response)
                    store.dispatch(action.loading(false))
                    return response
  });
}

export function acceptQuotation(idQuoteRequest, idSupplier){
  store.dispatch(action.loading(true))
  return axios.get('./elite-quotation-api.php',
                    {params: {
                      ajax: true,
                      type: 9,
                      idSupplier: idSupplier,
                      idQuoteRequest: idQuoteRequest,
                      price: price,
                  }}).then(response => {
                    console.log(response)
                    store.dispatch(action.loading(false))
                    return response
  });
}

export function checkPrice(idQuoteRequest, idSupplier, target_price, chance){
  store.dispatch(action.loading(true))
  return axios.get('./elite-quotation-api.php',
                    {params: {
                      ajax: true,
                      type: 4,
                      idSupplier: idSupplier,
                      idQuoteRequest: idQuoteRequest,
                      target_price: target_price,
                      chance: chance,
                  }}).then(response => {
                    console.log(response)
                    store.dispatch(action.loading(false))
                    return response
  });
}

export function placeOrder(shippingAddress, idQuoteRequest, idSupplier, id_product, quantity){
  store.dispatch(action.loading(true))
  return axios.get('./elite-quotation-api.php',
                    {params: {
                      ajax: true,
                      type: 5,
                      shippingAddress: shippingAddress,
                      idSupplier: idSupplier,
                      idQuoteRequest: idQuoteRequest,
                      id_product: id_product,
                      quantity: quantity,
                  }}).then(response => {
                    console.log(response)
                    store.dispatch(action.loading(false))
                    return response
  });
}
