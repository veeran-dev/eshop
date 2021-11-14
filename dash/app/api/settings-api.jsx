import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/settings-actions'
import * as G from '../api/common-api'
import {toastr} from 'react-redux-toastr';
import serialize from 'form-serialize'

export function uploadProfilePicture(router){
  var fileInput = document.getElementById("upload-profile-picture-input");
  if(fileInput.value != ""){
    var file = fileInput.files[0];
    var data = new FormData();
    data.append("file", file)
    data.append("type", 1)
    return axios.post('settings.php', data).then(response => {
        let data = response.data
        if(data == 1){
          toastr.error("Error", "File format not supported.", {icon: "icon-error"})
        }
        else if(data == 2){
          toastr.error("Error", "File is too large.", {icon: "icon-error"})
        }
        else if(data == 3){
          toastr.error("Error", "Error in uploading file.", {icon: "icon-error"})
        }
        else{
            this.getCustomerLogo()
            toastr.success("Success", "Profile photo updated successfully.", {icon: "icon-succes"})
            document.getElementById("upload-profile-picture").reset();
        }

        return response
    });
  }
  else{
    toastr.error("Error", "Please select file to proceed.", {icon: "icon-error"})
  }
}

export function getCustomerLogo(){
    return axios.get('settings.php?type=2&id_customer='+id_customer)
        .then(response => {
          store.dispatch(action.customerLogo(response.data))
          if(store.getState().settingsState.customerLogo != "")
            document.getElementById("customerLogo").src = baseDir+store.getState().settingsState.customerLogo;
          else
            document.getElementById("customerLogo").src = baseDir+'img/logo/avatar.png';
          return response
    });
}

export function updatePassword(cpwd, newpwd) {
    return axios.post('settings.php?type=3&oldPassword='+cpwd.value+"&newPassword="+newpwd.value)
        .then(response => {
          if(response.data == 0) {
            toastr.error("Error", "Existing password is entered incorrect.", {icon: "icon-error"});
          }
          else if(response.data == 1) {
            toastr.warning("Password changed successfully.", "You will be logged out. Please login again with your new password.", {icon: "icon-info", timeOut: 5000})
            setTimeout(function(){
                document.getElementById("logoutLink").click();
            }, 5000);
          }
          return response
    });
}

export function getPoOptions() {
  return axios.get('settings.php?type=4').then(response => {
    store.dispatch(action.poOptions(response.data))
  });
}

export function setPoOption(idOption) {
  return axios.post('settings.php?type=5&id_po_option='+idOption).then(response => {
    if(response.data == 1) {
      toastr.success("Success", "Purchase option changed successfully.", {icon: "icon-succes"});
      window.location = baseDir+'index.php?controller=dash-index';
    }
    else {
      toastr.error("Error", "Error occured while changing option.", {icon: "icon-error"});
    }
  });
}