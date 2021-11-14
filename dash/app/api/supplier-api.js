import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/supplier-actions'

export function getSuppliers(id_group){
 store.dispatch(action.loading(true))
  return axios.get('./elite-supplier.php',
                    {params: {
                      ajax: true,
                      type: 1,
                      id_group: id_group,
                  }}).then(response => {
                    if(response.data != "" && response.data['error'] != undefined) {
                        toastr.error('Error', response.data['error'], { icon: "icon-error"})
                    }
                    else if(response.data['suppliers'].length > 0){ 
                      store.dispatch(action.supplierList(response.data['supplier']))  
                    }
                    store.dispatch(action.loading(false))
                    return response
  });
}