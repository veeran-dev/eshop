import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../store/configureStore'
import * as addressApi from '../../api/address-api'

class StateSelectionModal extends React.Component {
	constructor(props){
		super(props)
	}

  componentDidMount(){
    addressApi.getStates()
  }

  getStateText(elementId) {
      var elt = document.getElementById(elementId);
      if (elt.selectedIndex == -1)
          return null;
      return elt.options[elt.selectedIndex].text;
  }


  stateSet(e){
    if(e.target.value != "" && e.target.value != undefined){
      let stateName  = this.getStateText('stateSelect')
      addressApi.stateSet(e.target.value, stateName)
    }
  }

	render(){
		return(
			<div className="modal state-selection" id={"stateSelection"}>
          <div className="modal-dialog animated zoomInRight tooltip-arrow">
            <div className="modal-content">
              <div className="modal-body">
                  <div id={"stateSelectionContent"}>

                    <div className="state-selection-form">
                      <select name={"stateSelect"} id={"stateSelect"} onChange={this.stateSet.bind(this)}>
                        <option value="">Select State</option>
                        {this.props.states.map((state, i) => {
                          return(
                            <option key={i} id={"id_state_"+state.id_state} value={state.id_state}>{state.name}</option>
                          )
                        })}
                      </select>
                      <button className="button-red" onClick={this.stateSet.bind(this)}>Proceed</button>
                    </div>

                    <div className="state-selection-info">
                      <p>The product prices will change based on state tax rates.</p>
                    </div>
                      
                  </div>
              </div>
            </div>
          </div>
      </div>
		)
	}
}

const mapStateToProps = function(store) {
  return {
    states: store.addressState.states
  }
}

export default connect(mapStateToProps)(StateSelectionModal)
