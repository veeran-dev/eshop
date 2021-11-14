import React, { Component } from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../../store/configureStore'
import * as addressApi from '../../../api/address-api'
import * as commonApi from '../../../api/common-api'

export default class State extends Component {

  constructor(props) {
    super(props);
    this.state = {
      purchase_orders: [],
      addressName: '',
      id_address: '',
      id_state: ''
    }
    this.initialState = this.state;
  }
  
  getStateText = (elementId) => {
      var elt = document.getElementById(elementId);
      if (elt.selectedIndex == -1)
          return null;
      return elt.options[elt.selectedIndex].text;
  }


  getPurchaseOrders = (e) => {
    if(e.target.value != "" && e.target.value != undefined) {
      let addressName  = this.getStateText('stateSelect');
      let value_split = e.target.value.split("-");
      if(budgetOption == 2) {
        addressApi.getPurchaseOrdersByAddress(value_split[1]).then(data => {
          if(data && data.length > 0) {
            var po_data = data.reduce((pv, cv) => {if(cv.value_available > 0) { pv.push(cv); } return pv;}, []);
            if(po_data.length > 0) {
              this.setState({ 
                purchase_orders: po_data,
                addressName,
                id_address: value_split[1],
                id_state: value_split[0]
              });
            }
            else {
              this.setState(this.initialState, () => toastr.error("Error", "PO is not available/expired for the selected address", { icon: "icon-error"}));
            }
          }
          else {
            this.setState(this.initialState, () => toastr.error("Error", "PO is not available/expired for the selected address", { icon: "icon-error"}));
          }
        });
      }
      else {
        this.setState({
          addressName,
          id_address: value_split[1],
          id_state: value_split[0]
        }, () => addressApi.stateSetWithAddress(this.state.id_state, this.state.addressName, this.state.id_address, 0));
      }
    }
  }

  stateSet = (e) => {
    if(e.target.value != "" && e.target.value != undefined) {
      addressApi.stateSetWithAddress(this.state.id_state, this.state.addressName, this.state.id_address, e.target.value);
    }
  }

  getPurchaseOrder = (purchase_orders) => {
    if(purchase_orders) {
      return (
        <div className="state-selection-form">
            <select name={"poSelect"} id={"poSelect"} onChange={this.stateSet.bind(this)} >
              <option value="">Select PO</option>
              {purchase_orders.map((po, i) => {
                  return(
                    <optgroup label={po.po_number} key={i} id={"id_po_"+po.id_purchase_order}>
                      <option className="address-highlight" value={po.id_purchase_order} title="Select this purchase order">
                        {budgetOption == 1 ? `Products available: ${po.product_available}` : `Available Budget: ${commonApi.formatPrice(po.value_available)}`}
                      </option>
                      <option disabled>
                        {budgetOption == 1 ? `Total Products: ${po.product_available_total}` : `Total Budget: ${commonApi.formatPrice(po.value_available_total)}`}
                      </option>
                    </optgroup>
                  )
              })}
          </select>
        </div>
      )
    }
    else {
      toastr.error('Error', "PO is not available/expired for selected address.", { icon: 'icon-error' });
    }
  }
  
	render(){
    const { purchase_orders } = this.state
		return(
			<div id={"stateSelectionContent"}>
        <div className="state-selection-info text-align-center">
          <h2>Please choose your delivery address!</h2>
          <img src="dash/img/delivery-region.png" alt="Delivery Region" />
        </div>
        <div className="state-selection-form">
          <select name={"stateSelect"} id={"stateSelect"} onChange={this.getPurchaseOrders.bind(this)} >
            <option value="">Select Addresses</option>
            {this.props.addresses.map((address, i) => {
              return(
                <optgroup label={address.alias ? address.alias : address.company} key={i} id={"id_address_"+address.id_address}>
                  <option className="address-highlight" value={address.id_state+"-"+address.id_address} title="Select this address">{address.address1.length > 20 ? address.address1.substring(0, 20)+"..." : address.address1}</option>
                  <option disabled>{address.city +", "+ address.state}</option>
                </optgroup>
              )
            })}
          </select>
          {/*<button className="button-red" onClick={this.stateSet.bind(this)}>Proceed</button>*/}
        </div>

        {purchase_orders && budgetOption == 2 && purchase_orders.length > 0 && this.getPurchaseOrder(purchase_orders)}
        
        <div className="state-selection-info">
          <p>Select your address. GST Rates will change based on Delivery State.</p>
        </div>    
      </div>
		)
	}
}