import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import * as addressApi from '../../../api/address-api'
import * as orderApi from '../../../api/orders-api'
import { closeModal } from '../../../api/common-api'
import store from '../../../store/configureStore'
import Input from '../../../components/common/Input'

class OtpPanel extends React.Component {
    constructor(props){
        super(props)
        this.state = {
          confirmButton : false
        }
    }
    enableConfButton(e){
      if(e.target.value.length > 3){
        this.setState({
          confirmButton : true
        })
      } else {
        this.setState({
          confirmButton : false
        })
      }
    }

    resendOTP() {
      orderApi.sendOTP(this.props.epayLaterOrderId, 2);
    }

    cancelProcess() {
      document.getElementById("otp").value = "";
      closeModal(["otpPop"]);
    }

    confirmOrder() {
      if(this.props.cartProducts.length > 0) {
        let otp = document.getElementById("otp").value;
        orderApi.complete(this.props.routerContext, this.props.idPayment, this.props.epayLaterOrderId, otp);
      }
      else {
        toastr.error("Error", "Please add products to cart to proceed payment.", {icon: "icon-error"})
      }
    }

    render() {
        return (
          <div className="modal-wrapper">
             <div className="otp-epaylater">
              <div className="step">
                <p>Please enter the verification code sent to your mobile.</p>
                <div className="form-group">
                  <div className="form-control">
                    <Input name="otp" id="otp" maxLength={10} inputValue={""} type="text" placeholder="••••" onChange={this.enableConfButton.bind(this)}/>
                  </div>
                </div>
                <p>Didn't get the OTP? <a href="javascript:void(0)" onClick={this.resendOTP.bind(this)}>Resend OTP </a></p>
              </div>
              <div className="modal-footer">
                <button onClick={this.cancelProcess.bind(this)}>Cancel</button>
                <button className={this.state.confirmButton ? "button-red" : "button-red disabled"} onClick={this.confirmOrder.bind(this)}>Confirm</button>
              </div>
             </div>
          </div>
        )
    }
}

OtpPanel.contextTypes = {
  router: React.PropTypes.object.isRequired
};

export default OtpPanel