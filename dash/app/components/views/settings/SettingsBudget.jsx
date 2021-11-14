import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import Ripples from 'react-ripples';
import store from '../../../store/configureStore';
import * as G from '../../../api/common-api';
import * as settingsApi from '../../../api/settings-api';
import * as addressApi from '../../../api/address-api';
import { getAddress, deleteAddress } from '../../../api/common-api'
import ConfirmationPop from '../../../components/common/ConfirmationContent'

// Using "Stateless Functional Components"
class SettingsBudget extends React.Component {
  constructor(props){
  	super(props)
  }

  render() {
  	return (
  		<div className="settings">
        <div className="page-header">
          <div className="duration-filter">
            <Ripples className="button-group-item">
              <Link className="button" to="settings/budget/purchase-orders" activeClassName="active">Purchase Orders</Link>
            </Ripples>
            {!(role == 1) && this.props.budgetInstalled == 1 ?
              <Ripples className="button-group-item">
                <Link className="button" to="settings/budget/configs" activeClassName="active">Settings</Link>
              </Ripples> : null}
          </div>
        </div>
        <div className="settings-container-budget">
          {this.props.children}
        </div>
      </div>
	  );
  }
}

const mapStateToProps = function(store) {
  return {
    budgetInstalled: store.commonState.budgetInstalled
  };
};

export default connect(mapStateToProps)(SettingsBudget);
