import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/settings-actions'
import {toastr} from 'react-redux-toastr';

export function getCustomerLogo(){
    store.dispatch(action.loading(true))
    store.dispatch(action.customerLogo('./src/assets/img/logo/default-customer-logo.jpg'))
    return axios.get('../elite-supplier-settings.php?type=2')
        .then(response => {
          if(response.data != "" && response.data['logo'] != undefined) {
            store.dispatch(action.customerLogo(response.data['logo']))
          }
          else{
            store.dispatch(action.customerLogo('./src/assets/img/logo/default-customer-logo.jpg')) 
          }
          

          store.dispatch(action.loading(false))
          return response
    });
}

export function updateDrDetails(drPrefix, drNumber) {
    store.dispatch(action.loading(true))
    return axios.post('../elite-supplier-settings.php?type=4&drPrefix='+drPrefix.toUpperCase()+"&drNumber="+drNumber)
        .then(response => {
          if(response.data != "" && response.data['success'] != undefined) {
              toastr.success('Success', response.data['success'], { icon: "icon-success"})
              getDrDetails();
          }
          if(response.data != "" && response.data['error'] != undefined) {
              toastr.error('Error', response.data['error'], { icon: "icon-error"})
          }
          store.dispatch(action.loading(false))
          return response
    });
}

export function getDrDetails() {
    store.dispatch(action.loading(true))
    store.dispatch(action.setDrPrefix(""))
    store.dispatch(action.setDrNumber(""))
    return axios.post('../elite-supplier-settings.php?type=3')
        .then(response => {
          if(response.data != "" && response.data['prefix'] != undefined) {
              store.dispatch(action.setDrPrefix(response.data['prefix']))
              store.dispatch(action.setDrNumber(response.data['number']))
          }
          if(response.data != "" && response.data['error'] != undefined) {
              toastr.error('Error', response.data['error'], { icon: "icon-error"})
          }
          store.dispatch(action.loading(false))
          return response
    });
}


export function updateCustomerLogo() {
    store.dispatch(action.loading(true))
    var fileInput = document.getElementById("upload-supplier-profile-picture-input");
    console.log(fileInput);
    if(fileInput.value != "" && fileInput.files[0]){
      var file = fileInput.files[0];
      var data = new FormData();
      data.append("file", file)
      data.append("type", 1)
      if(file.size > 512000){
        toastr.error('Error', "Sorry, File Size should be less than 500kb", { icon: "icon-error"})
        store.dispatch(action.loading(false))
        return false;
      }
      
      return axios.post('../elite-supplier-settings.php?type=1', data)
          .then(response => {
            if(response.data != "" && response.data['success'] != undefined) {
                getCustomerLogo()
                toastr.success('Success', response.data['success'], { icon: "icon-success"})
            }
            if(response.data != "" && response.data['error'] != undefined) {
                toastr.error('Error', response.data['error'], { icon: "icon-error"})
            }
            fileInput.value = "";
            store.dispatch(action.loading(false))
            return response
      });
    }
    else{
      store.dispatch(action.loading(false))
      toastr.error("Error", "Please select file to proceed.", {icon: "icon-error"})
    }
}