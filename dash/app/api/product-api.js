import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/product-actions'
import {zones} from '../actions/search-actions'

export function getProductDetails(idProduct){
  return axios.get('elite-product-api.php?type=1&id_product='+idProduct).then(response => {
      store.dispatch(action.setProductDetails(response.data['product_details']))
      store.dispatch(action.setSupplierDetails(response.data['supplier_details']))
      store.dispatch(zones(response.data['zone']))
      return response  
  })
}

export function getSupplierDetails(idProduct, zone){
	store.dispatch(action.fetchingSupplier(true))
  return axios.get('elite-product-api.php?type=2&id_product='+idProduct+'&zone='+JSON.stringify(zone)).then(response => {
      console.log(response.data['supplier_details'])
      store.dispatch(action.setSupplierDetails(response.data['supplier_details']))
      store.dispatch(zones(response.data['zone']))
      store.dispatch(action.fetchingSupplier(false))
      return response  
  })
}       

export function sendQuoteRequest(id_product, intervalOption, quoteQuantity, buyingPeriod, immediately, deadline, payment, credit, suppliers){
  return axios.get('elite-product-api.php?type=3&id_customer='+id_customer+'&id_product='+id_product+'&intervalOption='+intervalOption+'&quoteQuantity='+quoteQuantity+'&buyingPeriod='+buyingPeriod+'&immediately='+immediately+'&deadline='+deadline+'&payment='+payment+'&credit='+credit+'&suppliers='+suppliers).then(response => {
      return true  
  })
}