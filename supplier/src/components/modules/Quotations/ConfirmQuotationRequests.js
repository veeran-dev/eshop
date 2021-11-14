import React, { useState } from 'react'
import DayPickerInput from '../../common/datepickerSingle'
import {toastr} from 'react-redux-toastr'
import {compareDates} from '../../../api/common-api'
class ConfirmQuotationRequests extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      price: "",
      totalLowPrice: "",
    }
  }

  submitQuote =()=>{
    let expiryDate = this.refs.expiryDate.state.value
    
    let n = new Date();
    n.setMonth(n.getMonth() + 1);
    if(this.state.price == 0 || this.state.price == ""){
        toastr.error("Error", "Please check the price.", {icon: "icon-error"}) 
        return false; 
    }
    if(expiryDate == undefined){
      toastr.error("Error", "Please enter valid date.", {icon: "icon-error"})  
    }
    else if(!compareDates(n, expiryDate)){
      toastr.error("Error", "Please give atleast one month of expiry time.", {icon: "icon-error"})  
    }
    else{
      // return false;
      this.props.sendQuote(this.props.idQuoteRequest, this.props.item, this.state.price, expiryDate)
      this.setState({price: "", totalLowPrice: ""})
    }
  }
  componentWillReceiveProps(nextProps){
    if(nextProps.idQuoteRequest != this.props.idQuoteRequest){
      this.setState({price: "", totalLowPrice: ""}) 
    }
  }

  render(){
    let d = new Date();
    d.setMonth(d.getMonth() + 3);

    const { price, totalLowPrice  } = this.state
    return (
          <div className="qr_confirm">
            <div className="qr_margin_wrapper">
              <div className="qr_price_block">
                <div className="qr_title">
                  <span>Please enter your price per unit</span>
                  <div>
                    <div>Tax Excl</div>
                    <div className="low_price"><span>{price ? price:0}</span> * {this.props.quantity} = {totalLowPrice} </div>
                  </div>
                </div>
                <div className="qr_price">
                  <i className="icon-arrow-down"></i>
                  <input type="text" 
                    value={this.state.price}
                    onChange={event =>{
                        let v = event.target.value
                        let decimal_digit = v.split(".")[1] ? v.split(".")[1].length : 0;
                        if( !isNaN(v) && v > 0 && v < 999999999999 && decimal_digit < 3){
                            this.setState({price: v, totalLowPrice: v * this.props.quantity})
                          }
                        else if(v == ""){
                          this.setState({price: "", totalLowPrice: ""})
                        }
                        else{
                          // toastr.error("Error", "Please check the price.", {icon: "icon-error"})
                        }
                      }
                    }
                  />
                </div>
              </div>
              <div className="qr_expiry">
                <span>Please enter the expiry date for your price</span>
                <div className="qr_expiry_action">
                  <i className="icon-calendar"></i>
                  <DayPickerInput ref="expiryDate" selected={d} className={"date-input"}  format={'YYYY-MM-DD'} component={props => <input {...props} />} />
                </div>
                <p className="note">Please give atleast one month of expiry time.</p>
              </div>
              <div className="qr_action">
                <button className="button button-blue" onClick={this.submitQuote.bind(this)} >Quote</button>
              </div>
            </div>
          </div>
      )
  }
}

export default ConfirmQuotationRequests;