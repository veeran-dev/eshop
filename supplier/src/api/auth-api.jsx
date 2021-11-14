import React from 'react'
import ReactDOM from 'react-dom'
import {Redirect} from 'react-router-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/auth-actions'
import {getStatesDetails} from './address-api'
import * as G from './common-api'
/**
 * Get user orders
 */
export function authRegister(enterprise_name, enterprise_email, password, enterprise_address, address_mobile, address_city, address_state, address_country, address_pincode, address_gst, contact_name, contact_mobile, s_cat, s_city, id_group, id_customer){
  // store.dispatch(action.loading(true))
  const s_category = [...new Set(s_cat.map(item => item.value))];
  const s_cities = [...new Set(s_city.map(item => item.value))];
  return axios.get('../elite-supplier-auth.php',
                    {params: {
                      ajax: true,
                      register: 1,
                      enterprise_name:enterprise_name, 
                      enterprise_email:enterprise_email,
                      password:password, 
                      enterprise_address:enterprise_address,
                      address_mobile:address_mobile,
                      address_city:address_city,
                      address_state:address_state, 
                      address_country:address_country,
                      address_pincode:address_pincode,
                      address_gst:address_gst,
                      contact_name:contact_name,
                      contact_mobile:contact_mobile,
                      s_cat:s_category, 
                      s_city:s_cities,
                      id_group: id_group,
                      id_customer: id_customer,
                  }}).then(response => {
                    console.log(response.data)
                  if(response.data != "" && response.data['success'] != undefined) {
                      store.dispatch( action.setUser(response.data))
                  }
                  if(response.data != "" && response.data['error'] != undefined) {
                      toastr.error('Error', response.data['error'], { icon: "icon-error"})
                      store.dispatch( action.setError(response.data['error']) ) 
                  }
                  // store.dispatch(action.loading(false))
                  return response
      });
}

export function authLogin(email, passwd) {  
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-auth.php',
                    {params: {
                      ajax: true,
                      login: 1,
                      email: email,
                      passwd: passwd,
                      supplier_token:true,
                  }}).then(response => {
                  if(response.data != "" && response.data['id_supplier'] != undefined) {
                      store.dispatch( action.setUser(response.data) );
                      window.location= '/supplier/#/dashboard';
                  }
                  if(response.data != "" && response.data['error'] != undefined) {
                      store.dispatch( action.setError(response.data['error']) ) 
                  }
                  store.dispatch(action.loading(false))
                  return response
  });
}

export function resetPassword(email) {  
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-auth.php',
                    {params: {
                      ajax: true,
                      resetPassword: 1,
                      email: email,
                  }}).then(response => {
                  if(response.data != "" && response.data['success'] != undefined) {
                      toastr.success('Success', response.data['success'], { icon: "icon-success"})
                      G.closeModal(["resetPassword"])
                  }
                  if(response.data != "" && response.data['error'] != undefined) {
                      toastr.error('Error', response.data['error'], { icon: "icon-error"})
                  }
                  store.dispatch(action.loading(false))
                  return response
  });
}

export function checkAuth() {  
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-auth.php',
                    {params: {
                      ajax: true,
                      checkAuth: 1,
                  }}).then(response => {
                  console.log(response.data)
                  store.dispatch( action.setUser(response.data) )  
                  store.dispatch(action.loading(false));
                  if(response.data['id_supplier']==0 || response.data['id_supplier']==null){
                    window.location= '/supplier/#/';
                  }
                  else{
                    window.location= '/supplier/#/dashboard';
                  }
                  store.dispatch(action.loading(false))
                  return response
  });
}

export function authenticate() {  
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-auth.php?',
                    {params: {
                      ajax: true,
                      checkAuth: 1,
                  }}).then(response => {
                  store.dispatch( action.setUser(response.data) );
                  store.dispatch(action.loading(false))
                  return response.data;
  });
}


export function clearAuth() {  
  store.dispatch(action.loading(true))
  return axios.get('../elite-supplier-auth.php',
                    {params: {
                      ajax: true,
                      clearAuth: 1,
                  }}).then(response => {
                  store.dispatch(action.loading(false));
                  store.dispatch( action.setUser(response.data) )
                  window.location= '/supplier/#/';
                  return response
  });
}
