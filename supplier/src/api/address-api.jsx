import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/address-actions'
import * as G  from './common-api'
import * as authAction from '../actions/auth-actions'
import AddAddressView from '../components/modules/Address/AddSupplierAddress'


export function getStates(){
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-address.php',
                    {params: {
                      ajax: true,
                      type: 1,
                  }}).then(response => {
                    store.dispatch(action.setStates(response.data))
                    ReactDOM.render(<AddAddressView allStates={response.data} />, document.getElementById("supplierAddressContent"))
                    G.displayModal("supplierAddress")
                    store.dispatch(action.loading(false))
                    return response
  });  
}

export function getStatesDetails(){
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-address.php',
                    {params: {
                      ajax: true,
                      type: 1,
                  }}).then(response => {
                    store.dispatch(action.setStates(response.data))
                    store.dispatch(action.loading(false))
                    return response
  });  
}

export function addSupplierAddress(data){
  store.dispatch(action.loading(true))
  return axios.post('../elite-supplier-address.php', data).then(response => {
      if(response.data['error'] != 1){
        store.dispatch(action.setSupplierAddress(response.data))
        toastr.success("Success", "Your address added Successfully.", { icon: "icon-succes"})
      }
      else
        toastr.error("Error", "There is an error while creating address.", { icon: "icon-error"})
      return response
    })
}

export function addSupplierAddressOnReg(data){
  store.dispatch(action.loading(true))
  return axios.post('../elite-supplier-address.php', data).then(response => {
      if(response.data['error'] != 1){
        store.dispatch(action.setSupplierAddress(response.data))
        store.dispatch( authAction.regStep(3)) 
      }
      else
        toastr.error("Error", "There is an error while creating address.", { icon: "icon-error"})
      return response
    })
}