import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import * as addressApi from '../../../api/address-api'
import * as orderApi from '../../../api/orders-api'
import store from '../../../store/configureStore'

class Payment extends React.Component {
    constructor(props){
        super(props)
        this.state = {
          epayLater: false,
          epayLaterOrderId: ""
        }
    }

    componentDidMount(){
      addressApi.getPaymentModes()
      //addressApi.checkEpayEligibility(this)
    }

    handleClick(idPayment, event){
      if(this.props.cartProducts.length > 0) {
        orderApi.complete(this.context.router, idPayment, this.state.epayLaterOrderId)
      }
      else {
        toastr.error("Error", "Please add products to cart to proceed payment.", {icon: "icon-error"})
      }
    }

    sendOTP(idPayment){
      var fileInput = document.getElementById("po-file");
      var poNumber  = document.getElementById("po-number").value;
      let poMandatory = store.getState().commonState.companyInfo.po_mandatory;
      if((poNumber == "" || fileInput.value == "") && poMandatory == 1) {
        toastr.error("Error", "PO number or file is missing. Please upload to complete your purchase.", {icon: "icon-error"});
      }
      else {
        orderApi.sendOTP(this.state.epayLaterOrderId, idPayment, this.context.router, this.props.cartProducts, 1);
      }
    }

    render() {
        return (
           <div className="payment-mode">
               <h3 className="block-header">Complete your purchase</h3>
               <div className="payment-button-group">
               {this.props.isFetching ? 
                <div className="fetching-content fetching-buttons">
                  <div className="payment-button-item"></div>
                  <div className="payment-button-item"></div>
                  <div className="payment-button-item"></div>
                </div> : 
                (this.props.paymentModes && this.props.paymentModes.length > 0 ?
                   this.props.paymentModes.map((payment, index) => {
                      return (
                          payment.id_payment != 7 ? 
                          <div className="payment-button-item" key={index}>
                              <div className="payment-button" id={payment.payment_name} onClick={this.handleClick.bind(this, payment.id_payment)}>
                                <img src={"dash/img/payment-methods/" + payment.id_payment +".svg"} alt={payment.payment_name} />
                                <span>{payment.payment_name}</span>
                              </div>
                          </div> : 
                              (payment.id_payment == 7 && this.state.epayLater &&
                                <div className="payment-button-item" key={index}>
                                  <div className="payment-button" id={payment.payment_name} onClick={this.sendOTP.bind(this, payment.id_payment)}>
                                    <img src={"dash/img/payment-methods/" + payment.id_payment +".svg"} alt={payment.payment_name} />
                                    <span>{payment.payment_name}</span>
                                  </div>
                                </div>)
                      )
                    }) :
                    (this.props.paymentModes.saleStatus == 1 ? <div className="sale-alert">Sorry we are not taking any orders from 28th JUNE to 5th MAY due to GST implementations!</div> : <div>No payment modes found.</div>)
                )}
               </div>
           </div>
        )
    }
}

Payment.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    paymentModes: store.addressState.paymentModes,
    orderComplete: store.orderState.orderComplete,
    cartProducts: store.cartState.cart,
    isFetching: store.addressState.isFetchingPaymentModes
  }
}

export default connect(mapStateToProps)(Payment)