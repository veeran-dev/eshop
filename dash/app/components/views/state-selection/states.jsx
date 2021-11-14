import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../../store/configureStore'
import * as addressApi from '../../../api/address-api'

export default class State extends React.Component {
  constructor(props) {
    super(props);
  }

  getStateText(elementId) {
      var elt = document.getElementById(elementId);
      if (elt.selectedIndex == -1)
          return null;
      return elt.options[elt.selectedIndex].text;
  }


  stateSet(e){
    if(e.target.value != "" && e.target.value != undefined && e.target.value != deliveryRegion){
      addressApi.setDeliveryRegion(e.target.value);
    }
  }
  
	render(){
		return(
			<div id={"stateSelectionContent"}>
        <div className="state-selection-info text-align-center">
          <h2>Please choose your delivery region!</h2>
          <img src="dash/img/delivery-region.png" alt="Delivery Region" />
        </div>   
        <div className="state-selection-form">
          <select name={"stateSelect"} id={"stateSelect"} onChange={this.stateSet.bind(this)}>
            <option value="">Select Region</option>
            {this.props.states.map((state, i) => {
              if(state.id_fulfillment_centre != null) {
                return(
                  <option key={i} id={"id_state_"+state.id_fulfillment_centre} value={state.id_state}>{state.name}</option>
                )
              }
            })}
          </select>
          { /**<button className="button-blue" onClick={this.stateSet.bind(this)}>UPDATE</button> **/ }
        </div>

        <div className="state-selection-info text-align-center">
          <p className="attention">Attention!</p>
          <p>
            {cartProductWithNoRegion == 1 && <span className="red">There are some products already exists in your cart.</span>} 
            By changing the region, your products in the cart will be cleared{cartProductWithNoRegion == 1 && " except selected region products"}!
          </p>
        </div>    
      </div>
		)
	}
}