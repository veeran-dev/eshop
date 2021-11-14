import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/quotation-actions'

export function getQuotationsRequests(query, page, clear, sort){
 store.dispatch(action.loading(true))
 if(clear)   {
    store.dispatch(action.clearQuotationsRequestsList([]))  
 }
  return axios.get('../elite-supplier-split-quotation-requests.php',
                    {params: {
                      ajax: true,
                      type: 1,
                      query: query,
                      page: page,
                      sort: sort
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

export function sendQuoteConfirm(expiryDate, lowPrice, id_quote_request, name, quantity, id_customer){
  store.dispatch(action.loading(true))
   return axios.get('../elite-supplier-split-quotation-requests.php',
                    {params: {
                      ajax: true,
                      type: 2,
                      expiryDate: expiryDate,
                      lowPrice: lowPrice,
                      id_quote_request: id_quote_request,
                      name: name,
                      quantity: quantity,
                      id_customer: id_customer,
                  }}).then(response => {
                    if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                    else if(response.data['success'].length > 0){ 
                      store.dispatch(action.quotationsRequestsList(response.data['success']))  
                      store.dispatch(action.quotationsRequestsListCount(response.data['count']['count']))  
                    }
                    store.dispatch(action.loading(false))
                    return response
  });
}

export function rejectQuote(id_quote_request){
  store.dispatch(action.loading(true))
   return axios.get('../elite-supplier-split-quotation-requests.php',
                    {params: {
                      ajax: true,
                      type: 3,
                      id_quote_request: id_quote_request,
                  }}).then(response => {
                    store.dispatch(action.loading(false))
                    return response
  });
}

export function getAcceptedCustomer(query, page, limit, clear){
    store.dispatch(action.loading(true))
    return axios.get('../elite-supplier-split-quotation-requests.php',
        {params: {
          ajax: true,
          type: 4,
          query: query,
          page: page,
          limit: limit,
      }}).then(response => {
        if(response.data != "" && response.data['error'] != undefined) {
            toastr.error('Error', response.data['error'], { icon: "icon-error"})
        }
        else if(response.data['success'] == true){ 
          store.dispatch(action.getAcceptedCustomerAction(response.data['lists']))  
          store.dispatch(action.getAcceptedCustomerCountAction(response.data['count']))  
        }
        store.dispatch(action.loading(false))
        return response
    }); 
}

export function acceptCustomer(option, id_quote_request){
    store.dispatch(action.loading(true))
    return axios.get('../elite-supplier-split-quotation-requests.php',
        {params: {
          ajax: true,
          type: 5,
          option: option,
          id_quote_request: id_quote_request,
      }}).then(response => {
        if(response.data != "" && response.data['error'] != undefined) {
            toastr.error('Error', response.data['error'], { icon: "icon-error"})
        }
        store.dispatch(action.loading(false))
        return response
    }); 
}