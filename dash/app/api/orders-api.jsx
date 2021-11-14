import React from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import cookie from 'react-cookie'
import {toastr} from 'react-redux-toastr'
import store from '../store/configureStore'
import * as cartApi from './cart-api'
import * as G from './common-api'
import * as action from '../actions/order-actions'
import * as addressActions from '../actions/address-actions'
import * as addressApi from './address-api'
import OrderView from '../components/common/view-order';
import OtpPanel from '../components/views/payment/otp-epaylater'
import EBS from '../components/views/payment/EBS'

/**
 * Get user orders
 */
export function getOrders(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, query, context) {
  // store.dispatch(action.requestOrders())
  store.dispatch(action.loading_order_list(true))
  return axios.get('dash-history.php',
                    {params: {
                      ajax: true,
                      type: 1,
                      widget: true,
                      id_widget: 2,
                      limit: limit,
                      fromDate: fromDate,
                      toDate: toDate,
                      duration: duration,
                      idPage: idPage,
                      orderBy: orderBy,
                      orderWay: orderWay,
                      q: query
                  }}).then(response => {
      let data = [], total = 0
      if(response.data != "") {
        data = response.data.results
        total = response.data.total
      }
        
      store.dispatch( action.getOrdersSuccess(data, total) ) 
      store.dispatch(action.loading_order_list(false))

      return response
  });
}

export function complete(router, idPayment, epayLaterId, epayLaterOtp) {
  var fileInput = document.getElementById("po-file"), poNumber = cookiePONumber;
  var deliveryAddress = cookie.load('id_delivery_address'), billingAddress = cookie.load('id_billing_address');

  if(budgetConfigured == 0) {
    poNumber  = document.getElementById("po-number").value;
  }

  let poMandatory = store.getState().commonState.companyInfo.po_mandatory;

  if(budgetOption != 2 && (poNumber == "" || fileInput.value == "") && poMandatory == 1) {
    toastr.error("Error", "PO number or file is missing. Please upload to complete your purchase.", {icon: "icon-error"});
  }
  else if(budgetOption != 2 && poNumber == "" && fileInput.value != "") {
    toastr.error("Error", "PO number or file is missing. Please upload to complete your purchase.", {icon: "icon-error"});
  }
  else if(deliveryAddress == undefined || billingAddress == undefined) {
    toastr.error('Error', "Shipping address or Billing address is missing. Please add to proceed.");
  }
  else {
    if(idPayment != 4) {
      var data = new FormData()
      data.append('type', (parseInt(idPayment)+1))
      data.append('paymentmode', idPayment)
      data.append('id_customer', id_customer)
      data.append('deliveryAddressId', deliveryAddress)
      data.append('billingAddressId', billingAddress)
      data.append('po-file', (budgetConfigured == 0 && fileInput.value != "" ? fileInput.files[0] : ""))
      data.append('po-number', (poNumber != "" ? poNumber : ""))
      data.append('id_pay_later', epayLaterId);
      data.append('epaylater_otp', epayLaterOtp);
      store.dispatch(action.requestOrderComplete())
      return axios.post('dashpaymentoption.php', data).then(response => {
          if(response.data) 
          {
            if(!response.data.id_order && response.data == 'Please login to continue.') {
              toastr.error('Authentication failed', 'You will be redirected to login page..', { icon: 'icon-error' });
              store.dispatch(action.orderComplete(response.data))
              setTimeout(function() { location.reload(); }, 2000);
              return false;
            }

            cookie.remove('id_delivery_address')
            cookie.remove('id_billing_address')

            //Update cart after order completed
            cartApi.get()
            cartApi.cartSummary()
            G.getNotifications(1);
            if(cookieAddressBudget){
              addressApi.getPurchaseOrdersByAddress(cookieAddressBudget).then(data => {
                if(data && data.length > 0) {
                  store.dispatch(addressActions.purchaseOrders(data));
                }
              });
            }

            store.dispatch(action.orderComplete(response.data))
            console.log(response.data);
            console.log(response.data.id_order);
            router.push('order/'+response.data.id_order+'/success/thankyou')

            if(epayLaterOtp != "") {
              document.getElementById("otp").value = "";
              G.closeModal(["otpPop"])
            }
          }
          else {
            if(epayLaterOtp != undefined && epayLaterOtp != "")
              toastr.error("Error", "OTP Verification failed. Please enter correct OTP to proceed.", {icon: "icon-error"});
            else
              toastr.error("Error", "Problem in creating an order. Please try again or contact your RM for support.", {icon: "icon-error"});
          }

          return response
      })
    }
    else 
    {
      var data = new FormData()
      data.append('ebs_po_upload', 1);
      data.append('po-file', (fileInput.value != "" ? fileInput.files[0] : ""));
      data.append('po-number', (poNumber != "" ? poNumber : ""));
      return axios.post('dashpaymentoption.php', data).then(response => {
        
        if(response.data == 'Please login to continue.') {
          toastr.error('Authentication failed', 'You will be redirected to login page..', { icon: 'icon-error' });
          store.dispatch(action.orderComplete(response.data))
          setTimeout(function() { location.reload(); }, 2000);
          return false;
        }

        router.push("payment")
        return response
      });
    }
  }
}

export function getById(idOrder, deliveryAddress, invoiceAddress, modal){
    store.dispatch( action.requestById() )
    return axios.get('dash-history.php?type=2&ajax=true&id_order='+idOrder+'&delivery_add='+deliveryAddress+'&invoice_add='+invoiceAddress).then(response => {
        
        if(modal != undefined && modal == true) {
          store.dispatch( action.dispatchOrder(response.data) )
        }
        else {
          ReactDOM.render(<OrderView data={response.data} reOrder={G.reOrderView} />, document.getElementById("orderContent"))
          G.displayModal("viewOrder")
        }

        return response
    });
}

export function sendOTP(epayLaterId, idPayment, routerContext, cartProducts, displayType) {
  var data = new FormData()
  data.append('type', 2)
  data.append('epaylater_id', epayLaterId)
  return axios.post('epaylater.php', data).then(response => {
      let data = response.data
      if(data.status == "agreed" && data.paylater == true){
        if(displayType == 1) {
          ReactDOM.render(<OtpPanel 
                            epayLaterOrderId={epayLaterId} 
                            idPayment={idPayment} 
                            routerContext={routerContext}
                            cartProducts={cartProducts} />, document.getElementById("otpPopContent"));
          G.displayModal("otpPop");
        }
      }
      else {
        toastr.error("Error", "Problem in creating an order. Please try again or contact your RM for support.", {icon: "icon-error"});
      }
      return response
  })
}

export function getPaymentMethod(id_order) {
    return axios.get('dash-PurchaseList.php?type=13&id_order='+id_order).then(response => {
        store.dispatch( action.dispatchPayment(response.data) )
        return response
    });
}

export function getOrderProcessEligibility(id_order) {
  return axios.get('dash-get-group-info.php?type=14&id_order='+id_order).then(response => {
      store.dispatch( action.orderProcessStatus(response.data) )
      return response
  });
}

export function viewOrder(id_order){
  store.dispatch(action.loading_order_detail(true))
  store.dispatch(action.dispatchOrderDetailsClean(true))
  return axios.get('dash-history.php',
                    {params: {
                      ajax: true,
                      type: 9,
                      id_order: id_order,
                  }}).then(response => {
                    console.log("viewOrder");
                    console.log(response);
      // store.dispatch(action.dispatchOrderDetails(response.data))
      if(response.data['0'] != undefined && response.data.length > 0){
        store.dispatch(action.setOrderDetails(response.data[0]))
        store.dispatch(action.setOrderDeliveryAddress(response.data[2]))
        store.dispatch(action.setOrderInvoiceAddress(response.data[1]))
        store.dispatch(action.setOrderProdcutDetails(response.data[3] != undefined && response.data[3].length >0 ? response.data[3] : []))
        store.dispatch(action.setOrderStatus(response.data[4]))
        // store.dispatch(addressActions.setSupplierAddress(response.data[5]))
        store.dispatch(action.setCanceledProdcuts(response.data[8]))
        store.dispatch(action.setScheduledProdcuts(response.data[6] != false && response.data[6].length > 0 ? response.data[6]:[]))
      }
      else{
        store.dispatch(action.setOrderDetails([]))
        store.dispatch(action.setOrderDeliveryAddress([]))
        store.dispatch(action.setOrderInvoiceAddress([]))
        store.dispatch(action.setOrderProdcutDetails([]))
        store.dispatch(action.setOrderStatus([]))
        // store.dispatch(addressActions.setSupplierAddress([]))
        store.dispatch(action.setScheduledProdcuts([]))        
        store.dispatch(action.setCanceledProdcuts([]))
      }
      store.dispatch(action.loading_order_detail(false))
      return response
  });

}