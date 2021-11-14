import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as action from '../actions/address-actions'
import * as cartAction from '../actions/cart-actions'
import cookie from 'react-cookie'
import * as G from './common-api'
import ConfirmCityChange from '../components/common/ConfirmCityChange'
import CartResponse from '../components/common/cartAddResponse'

// Initialize form object for post requests
var data = new FormData()

export function get() {
  store.dispatch(action.requestAddress())
  return axios.get('dash-address.php?type=3&id_customer='+id_customer).then(response => {
      store.dispatch(action.dispatchAddress(response.data[0]))
      return response
  })
}

export function getById(idAddress, type){
  store.dispatch(action.requestUniqueAddress())
  return axios.get('dash-address.php?type=9&id_address='+idAddress).then(response => {
      if(type == 1)
        store.dispatch(action.dispatchUniqueAddress(response.data))
      else
        store.dispatch(action.dispatchBillingAddress(response.data))
      return response
  })
}

export function getPaymentModes(idOrder){
  store.dispatch(action.requestPaymentModes())
  var deliveryAddressId = cookie.load('id_delivery_address');
  var billingAddressId = cookie.load('id_billing_address');
  return axios.get('dashpaymentoption.php?type=1&id_customer='+id_customer+'&deliveryAddressId='+deliveryAddressId+'&billingAddressId='+billingAddressId).then(response => {
      store.dispatch(action.dispatchPayment(response.data))
      if(idOrder != null && idOrder != undefined)
        store.dispatch(action.dispatchOrderId(idOrder))
      return response
  })
}

export function getStates(){
  return axios.get("B2cState.php?type=3").then(response => {
    store.dispatch(action.dispatchState(response.data))
    return response
  })
}

export function getStatesForReports() {
  return axios.get("B2cState.php?type=6").then(response => {
    store.dispatch(action.dispatchReportsState(response.data))
    return response
  })
}

export function getAllStates(){
  return axios.get("B2cState.php?type=1").then(response => {
    store.dispatch(action.dispatchAllStates(response.data))
    return response
  })
}

export function stateSet(idState, stateName){
  return axios.post('B2cState.php?type=2&set=1&stateId='+idState+'&stateName='+stateName).then(response => {
    if(response.data != "")
      location.reload();
  })
}

export function stateSetWithAddress(idState, addressName, idAddress, id_purchase_order) {
  return axios.post('B2cState.php?type=4&set=1&stateId='+idState+'&addressName='+addressName+'&id_address='+idAddress+'&id_purchase_order='+id_purchase_order+'').then(response => {
    if(response.data) {
      if(response.data.type == 2) {
        toastr.error("Error", response.data.error, { icon: "icon-error" });
      }
      else if(response.data.type == 3) {
        toastr.error("Error", response.data.error, { icon: "icon-error" });
      }
      else {
        cookie.save('id_delivery_address', idAddress);
        cookie.save('id_billing_address', idAddress);
        location.reload();
      }
    }
    else {
      toastr.error("Error", "PO is not configured or expired for the selected address", {icon: "icon-error"});
    }

    return response.data;
  })
}

export function dismissCityChange() {
    G.closeModal(["confirmRegionChange"]);
}

export function getPurchaseOrdersByAddress(id_address) {
  return axios.get('purchase-order.php?id_address='+id_address+'&type=7').then(response => {
      return response.data
  })
}

export function activatePurchaseOrder(id_purchase_order, type) {
  return axios.post('purchase-order.php?type=8&id_purchase_order='+id_purchase_order+'&activate_type='+type).then(response => {
    if(response.data && response.data.proceed == 1) {
      toastr.success("Success", `PO ${type == 1 ? "activated" : (type == 2 ? "deactivated" : 'deleted')} successfully.`, { icon: "icon-success" });
    }
    else {
      location.reload();
    }

    return response.data;
  });
}

export function setDeliveryRegion(delivery_region, new_city_name, display_warning) 
{
  if(delivery_region == id_state) {
    toastr.warning("Warning", "Region is already selected", {icon: "icon-warning"});
  }
  else if(store.getState().cartState.cart && store.getState().cartState.cart.length > 0 && display_warning == 1) {
    ReactDOM.render(<ConfirmCityChange dismissCityChange={this.dismissCityChange} setDeliveryRegion={this.setDeliveryRegion} regionId={delivery_region} oldCity={deliveryRegionName} newCity={new_city_name} />, document.getElementById("confirmRegionChangeContent"))
    G.displayModal("confirmRegionChange")
    return false;
  }
  else {
    return axios.post('B2cState.php?type=5&delivery_region='+delivery_region+'&id_order='+reorder).then(response => {
      if(response.data == 1) {
        location.reload();
      }
      else if(response.data && !response.data.error && response.data.length) {
        var responseArray = new Array()
        for(var i=0; i < response.data.length; i++){
          if(response.data[i].msg != "success"){
            responseArray.push({name: response.data[i].name, message: response.data[i].msg})
          }
        }

        if(responseArray.length > 0){
          G.closeModal(["confirmRegionChange", "citySelection"])
          ReactDOM.render(<CartResponse data={responseArray} reload={true}/>, document.getElementById("cResponseContent"))
          G.displayModal("cResponse")
        }
        else {
          location.reload();
        }
      }
      else {
        toastr.error("Error", response.data.msg, {icon: "icon-error"});
      }
    })
  }
}

export function getDeals(pageID){
  store.dispatch(action.requestDeals())
  return axios.get('dash-deals.php?page='+pageID).then(response => {
    store.dispatch(action.dispatchDeals(response.data))
  })
}

// export function add() {
//   return axios.get('dash-address.php?type=10').then(response => {
//       ReactDOM.render(<AddressAdd states={response.data[1]} />, document.getElementById("addressContent"))
//       displayModal("viewAddress")
//       return response
//   })
// }

export function checkEpayEligibility(stateContext) {
  var dataParam = new FormData();
  dataParam.append('type', 1);
  dataParam.append('id_shipping_address', cookie.load('id_delivery_address'));

  return axios.post('epaylater.php', dataParam).then(response => {
    if(response.data != undefined) {
      if(response.data.paylater == true) {
        stateContext.setState({
          epayLater: true,
          epayLaterOrderId: response.data.id
        })
      }
      else {
        stateContext.setState({
          epayLater: false
        })
      }
    }
    else if(response.data == false) {
      stateContext.setState({
        epayLater: false
      })
    }
  })
}

export function saveAddressToCart(shippingAddress, billingAddress, context) {
  return axios.post('dash-address.php?type=14&id_address_delivery='+shippingAddress+'&id_address_billing='+billingAddress).then(response => {
    if(response.data == 'success') {
        context.router.push('/confirmation')
    }
  })
}

export function updateDeliveryAddress(id_address_delivery) {
  return axios.post('dash-address.php?type=15&id_address_delivery='+id_address_delivery).then(response => {
    let success = false;
    if(response.data && Array.isArray(response.data.products)) {
      const { products, summary } = response.data;
      store.dispatch(cartAction.dispatchCart(products));
      store.dispatch(cartAction.dispatchSummary(summary));
      success = true;
    }
    return success;
  });
}

export function updateInvoiceAddress(id_address_invoice) {
  return axios.post('dash-address.php?type=16&id_address_invoice='+id_address_invoice).then(response => {
    let success = false;
    if(response.data['success'] === true) {
        success = true;
    }
    return success;
  });
}