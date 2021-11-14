import axios from 'axios'
import store from '../store/configureStore'
import * as action from '../actions/inventory-actions'
import {toastr} from 'react-redux-toastr';

export function getInventory() {
    store.dispatch(action.loading(true))
    return axios.post('../elite-supplier-inventory.php?type=1')
        .then(response => {
          if(response.data != "" && response.data['inventories'] != undefined) {
              store.dispatch(action.setInventory(response.data['inventories']))
              store.dispatch(action.defaultInventory(response.data['inventories'][0]))
          }
          else{
              // toastr.error('Error', "No inventory available", { icon: "icon-error"})
          }
          store.dispatch(action.loading(false))
          return response
    });
}

export function getInventoryProductsList(inventory) {
    store.dispatch(action.loading(true))
    return axios.post('../elite-supplier-inventory.php?type=3&id_inventory='+inventory)
        .then(response => {
          if(response.data != "" && response.data['inventory_products'] != undefined) {
              store.dispatch(action.setInventoryProducts(response.data['inventory_products']))
          }
          store.dispatch(action.loading(false))
          return response
    });
}

export function createInventory(inventory_name, user_email, password, inventory_address, address_mobile, address_city, address_state, address_country, address_pincode, address_gst, contact_name, contact_mobile){
  store.dispatch(action.loading(true))
  return axios.post('../elite-supplier-inventory.php?type=2&inventory_name='+inventory_name+'&user_email='+user_email+'&password='+password+'&inventory_address='+inventory_address+'&address_mobile='+address_mobile+'&address_city='+address_city+'&address_state='+address_state+'&address_country='+address_country+'&address_pincode='+address_pincode+'&address_gst='+address_gst+'&contact_name='+contact_name+'&contact_mobile='+contact_mobile)
        .then(response => {
          console.log(response);
          if(response.data != "" && response.data['success'] != undefined) {
              toastr.success('Success', response.data['structure'], { icon: "icon-success"})
          }
          else{
              toastr.error('Error', "No inventory available", { icon: "icon-error"})
          }
          store.dispatch(action.loading(false))
          return response
    });
     
}

export function UploadInventoryProducts($id_inventory){
  var fileInput = document.getElementById("uploadFile");
  if(fileInput.value != ""){
    var file = fileInput.files[0];
    var data = new FormData();
    data.append("file", file)
    data.append("type", 4)
    data.append("id_inventory", $id_inventory)
    
    store.dispatch(action.loading(true))
    return axios.post('../elite-supplier-inventory.php', data).then(response => {
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
          document.getElementById("upload-inventory-product").value = "";
          document.getElementById("upload-inventory-product").value = "";
          toastr.success("Success", "Your Products will be uploaded to the inventory")
        }
        store.dispatch(action.loading(false))
        return response
    });
  }
  else{
    toastr.error("Error", "please select file to proceed.", {icon: "icon-error"})
  }
}