import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/catalog-actions'
import * as G  from './common-api'

export function getProducts(){
  // store.dispatch(action.loading(true))
  // return axios.post('../elite-supplier-address.php', data).then(response => {
  //     if(response.data['error'] != 1){
  //       store.dispatch(action.setSupplierAddress(response.data))
  //       toastr.success("Success", "Your address added Successfully.", { icon: "icon-succes"})
  //     }
  //     else
  //       toastr.error("Error", "There is an error while creating address.", { icon: "icon-error"})
  //     return response
  //   })
}

export function getContractList(limit, offset, idPage, query, idGroup){
  store.dispatch(action.loading(true))
  store.dispatch(action.setContractLists([]))
  return axios.get('../elite-supplier-catalog.php',
                  {params: {
                      ajax: true,
                      type: 2,
                      limit: limit,
                      offset: offset,
                      idPage: idPage,
                      query:query,
                      idGroup:idGroup,
                  }}).then(response => {
      if(response.data['contract'] != undefined && response.data['contract'].length > 0){
        store.dispatch(action.setContractLists(response.data['contract']))
        store.dispatch(action.setAllCustomers(response.data['customers']))
        store.dispatch(action.setContractCount(response.data['contractCount']))
      }
      store.dispatch(action.loading(false))
      return response
    })
}

export function getProductList(limit, offset, idPage, query){
  store.dispatch(action.loading(true))
  store.dispatch(action.setProductLists([]))
  return axios.get('../elite-supplier-catalog.php',
                  {params: {
                      ajax: true,
                      type: 3,
                      limit: limit,
                      offset: offset,
                      idPage: idPage,
                      query:query,
                  }}).then(response => {
      if(response.data['productList'] != undefined && response.data['productList'].length > 0){
        store.dispatch(action.setProductLists(response.data['productList']))
        store.dispatch(action.setProductCount(response.data['productCount']))
      }
      store.dispatch(action.loading(false))
      return response
    })
}

export function uploadCatalog(){
  var fileInput = document.getElementById("upload-product-details-input");
  if(fileInput.value != ""){
    var file = fileInput.files[0];
    var data = new FormData();
    data.append("file", file)
    data.append("type", 1)
    
    store.dispatch(action.loading(true))
    return axios.post('../elite-supplier-catalog.php', data).then(response => {
        let data = response.data
        if(data == 1){
          toastr.error("Error", "File format not supported.", {icon: "icon-error"})
        }
        else if(data == 2){
          toastr.error("Error", "File size should be less than 5mb.", {icon: "icon-error"})
        }
        else if(data == 3){
          toastr.error("Error", "Error in uploading file.", {icon: "icon-error"})
        }
        else{
          document.getElementById("upload-product-details-input").value = "";
          document.getElementById("upload-product-details-input").value = "";
          toastr.success("Success", "Your Catalog will be uploaded shortly, our team will contact you soon")
        }
        store.dispatch(action.loading(false))
        return response
    });
  }
  else{
    toastr.error("Error", "please select file to proceed.", {icon: "icon-error"})
  }
}
