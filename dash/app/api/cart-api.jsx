import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import cookie from 'react-cookie'
import store from '../store/configureStore'
import {toastr} from 'react-redux-toastr'
import * as action from '../actions/cart-actions'
import * as G from './common-api'
import CartResponse from '../components/common/cartAddResponse'
import LoyaltyPoints from '../components/common/loyaltyPoints'
import Vouchers from '../components/common/vouchersList'

// Add products to cart
export function add(products, elementID, router, type, minimalQuantity) 
{
  if(deliveryRegion == "" || deliveryRegion == 0) {
      document.getElementById("citySelection").setAttribute("style", "display: flex; display: -webkit-flex;");
      document.body.classList.add('modal-open');
      return false;
  }

  var data = new FormData()
  data.append('type', 2)
  data.append('id_customer', id_customer)
  data.append('productarray', products)
  data.append('list_id', "")
  data.append('listStatus', 2)  
  store.dispatch(action.requestAddProduct())
  return axios.post('dash-PurchaseList.php', data).then(response => {
    var response = response.data
    var responseArray = new Array()

    this.get()
    this.cartSummary()
    store.dispatch(action.responseAddProduct())

    // If budget configured and is set to value based
    if(response.length > 0){
      for(var i=0; i < response.length; i++){
        if(response[i].msg != "success"){
          responseArray.push({name: response[i].name, message: response[i].msg})
        }
      }

      if(responseArray.length > 0){
        ReactDOM.render(<CartResponse data={responseArray} />, document.getElementById("cResponseContent"))
        G.displayModal("cResponse")
      }
      else{
        if(products.length == 1){
          let productID = products.toString().split("-")[0]
          let quantity = products.toString().split("-")[1]
          if(type == 1) {
            cookie.remove('id_delivery_address')
            cookie.remove('id_billing_address')
            router.push("address")
          }
          document.getElementById(elementID+"_"+productID).value = minimalQuantity
          this.updateCartRowSingle(elemID, quantity)
        }
      }
    }

    return response
  })
}

// Get cart products
export function get() {
  store.dispatch( action.cartRequest() );
  return axios.get('dash-getcartproduct.php?type=0').then(response => {
      store.dispatch( action.dispatchCart(response.data) )
      return response
  })
}

// Update cart
export function update(products, price, oldQuantity, targetId){
  var data = new FormData()
  data.append('type', 2)
  data.append('productarray', products)

  return axios.post('dash-PurchaseList.php', data).then(response => {
    var response = response.data
    let product = products[0].split('-');
    var responseArray = new Array()
    if(response.length > 0){
      for(var i=0; i < response.length; i++){
        if(response[i].msg != "success"){
          responseArray.push({name: response[i].name, message: response[i].msg})
        }
      }
    }

    if(responseArray.length > 0) {
        document.getElementById(targetId+product[0]).value = oldQuantity;
        toastr.error("Error", responseArray[0].message, {icon: "icon-error"});
    }
    else{
      document.getElementById(targetId+product[0]).value = product[1];
      this.updateCartRowSingle(product[0], product[1], price);
      this.cartSummary();
      return response.data
    }
  })
}

// Remove cart
export function remove(router, idOrder, regionFlag = 0){
  var data = new FormData()
  data.append('type', 1)

  return axios.post('dash-getcartproduct.php', data).then(response => {
    this.get()
    this.cartSummary()
    //This is for reordering after clearing cart
    if(idOrder != null && idOrder != undefined && !regionFlag)
      this.reOrderCart(router, idOrder)

    return response
  })
}

// Cart summary
export function cartSummary(){
  store.dispatch( action.cartRequestSummary() );
  return axios.get('dash-getcartproduct.php?type=3&cartSummary=true').then(response => {
      store.dispatch( action.dispatchSummary(response.data) )
      return response
  })
}

// Delete product from cart by idProduct
export function deleteProduct(idProduct, idCombination, idCustomization){
  var data = new FormData()
  data.append('delete', 1)
  data.append('token', static_token)
  data.append('ajax', true)
  data.append('id_product', idProduct)
  data.append('ipa', idCombination ? idCombination : "")

  return axios.post('cart.php', data).then(response => {
      this.get()
      this.cartSummary()
      return response
  })
}

export function reOrderCart(router, idOrder){
   var data = new FormData()
    data.append('type', 3)
    data.append('id_order', idOrder)
    
    return axios.post('dash-history.php', data).then(response => {
        if(response.data){
          // G.closeModal(["viewOrder", "addToExistingCart"])
          
          var success = false;
          for(var i = 0; i < response.data.length; i++) {
            if(response.data[i].msg == "success") {
              success = true;
              break;
            }
          }

          var response = response.data
          var responseArray = new Array()
          if(response.length > 0)
          {
              for(var i=0; i < response.length; i++) {
                if(response[i].msg != "success"){
                  responseArray.push({name: response[i].name, message: response[i].msg})
                }
              }

              if(responseArray.length > 0) {
                ReactDOM.render(<CartResponse data={responseArray} />, document.getElementById("cResponseContent"))
                G.displayModal("cResponse")
              }
              
              if(success) {
                  cookie.remove('id_delivery_address')
                  cookie.remove('id_billing_address')
                  router.push("address")
              }
          }
        }
        
        return response
    });
}

export function updateCartRowSingle(idProduct, quantity, price){
  let cart = document.getElementById("changeQuantityCart_"+idProduct);
  let cartTopBar = document.getElementById("cartTopQty_"+idProduct);
  let cartTotal = document.getElementById("cartTotal_"+idProduct);
  let orderConfirmProduct = document.getElementById("orderConfirmProducts_"+idProduct);
  let finalSummary = document.getElementById("finalSummaryTotal_"+idProduct);

  if(cart != undefined && cart && cart.value != ""){
    document.getElementById("changeQuantityCart_"+idProduct).value = quantity;
    document.getElementById("cartTotal_"+idProduct).innerHTML = G.formatPrice(quantity * price)
  }

  if(cartTopBar != "" && cartTopBar != undefined)
    document.getElementById("cartTopQty_"+idProduct).value = quantity;
  
  if(orderConfirmProduct != "" && orderConfirmProduct != undefined){
    document.getElementById("orderConfirmProducts_"+idProduct).value = quantity;
    document.getElementById("finalSummaryTotal_"+idProduct).innerHTML = G.formatPrice(quantity * price)
  }
}

export function getLoyaltyPoints(){
  return axios.get('dash-display-points.php', {params:{id_customer: id_customer, type: 6, ajax: true}, transformRequest: [function (data) { 
                        document.getElementById('loader').style.visibility = 'hidden';
                        return data;
                      }]}).then(response => {
      store.dispatch(action.dispatchLoyaltyCount(response.data))
      return response
  });
}

// Vouchers creation view - loyalty points
export function viewLoyaltyPoints(){
  let totalPoints = parseInt(document.getElementById('loyaltyCount').innerHTML);
  if(totalPoints > 0) 
  {
    return axios.get('dash-display-points.php', {params:{id_customer: id_customer, type: 1, ajax: true}}).then(response => {
        if(response.data[1].length > 0){
          let loyaltyData = response.data[1]
          let pointValue = response.data[2]
          ReactDOM.render(<LoyaltyPoints pointValue={pointValue} data={loyaltyData} />, document.getElementById("loyaltyResponseContent"))
          G.displayModal("loyaltyResponse")
        }
        else {
          document.getElementById('loyaltyCount').innerHTML = 0
          document.getElementById('loyaltyAmount').innerHTML = 0
          document.getElementById('loyaltyMenuCounter').innerHTML = 0
          G.closeModal(["loyaltyResponse"])
        }

        return response
    })
  }
  else {
    toastr.error("Error", "No loyalty points found", {icon: "icon-error"})
  }
}

export function generateVoucher(orderIDs, state){
  var formData = new FormData()
  formData.append("type", 3)
  formData.append("id_customer", id_customer)
  formData.append("totalPoints", state.totalLoyaltyPoints)
  formData.append("totalValue", state.totalLoyaltyValue)
  formData.append("orderIDs", orderIDs)

  return axios.post('dash-display-points.php', formData).then(response => {
      if(response.data == 1){
        document.querySelector("#loyaltyPointsForm").reset()
        state.totalLoyaltyPoints = 0
        state.totalLoyaltyValue = 0
        this.getLoyaltyPoints()
        this.viewLoyaltyPoints()
        toastr.success("Success", "Voucher created successfully", {icon: "icon-succes"})
      }
      return response
  })
}

export function loadDicounts(){
  return axios.get('dash-shopping-cart.php', {params:{id_customer: id_customer, type: 1, ajax: true}}).then(response => {
      let data = response.data
      if(data[0].length > 0){
        ReactDOM.render(<Vouchers data={data[0]} used={data[1]} />, document.getElementById("voucherContent"))
        G.displayModal("vouchers")
      }
      else {
        toastr.error("Error", "No vouchers found.", {icon: 'icon-error'})
      }
      return response
  });
}

export function applyDiscount(idDiscount, discountName){
  var data = new FormData()
  data.append("type", 2)
  data.append("id_discount", idDiscount)
  data.append("discount_name", discountName)
  return axios.post('dash-shopping-cart.php', data).then(response => {
      if(response.data[0] == "success"){
        G.closeModal(["vouchers"])
        this.cartSummary()
        toastr.success("Success", "Voucher applied successfully.", {icon: 'icon-succes'})
        document.getElementById("voucherCode").value = ""
      }
      else if(response.data[0] == "Discount amount exceeds total shopping value.") {
        toastr.error("Error", response.data[0], {icon: 'icon-error'})
      }
      else{
        toastr.error("Error", response.data, {icon: 'icon-error'})
      }
      return response
  });
}

export function deleteDiscount(idDiscount, discountName){
  var data = new FormData()
  data.append("type", 3)
  data.append("id_discount", idDiscount)
  return axios.post('dash-shopping-cart.php', data).then(response => {
      G.closeModal(["vouchers"])
      this.cartSummary()
      toastr.success("Success", "Voucher cancelled successfully", {icon: 'icon-succes'})
      return response
  });
}