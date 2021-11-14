import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../../store/configureStore'
import * as addressApi from '../../../api/address-api'
import States from './states'
import Addresses from './addresses'

class StateSelectionModal extends React.Component {
	constructor(props) {
		super(props)
	}

  componentDidMount() {
    addressApi.getStates()
  }

	render() {
		return(
			<div className="modal state-selection" id={budgetConfigured == 1 ? 'addressSelection' : 'citySelection'}>
          <div className="modal-dialog animated zoomInRight tooltip-arrow">
            <div className="modal-content">
              <div className="modal-body">
                  {budgetConfigured == 1 ? <Addresses addresses={this.props.states}/> : <States states={this.props.states} />}
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
