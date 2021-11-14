import React from 'react';
import ReactDOM from 'react-dom';
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

  componentWillMount() {
    settingsApi.getPoOptions();
  }

  setPoOption(idOption) {
    settingsApi.setPoOption(idOption);
  }

  addNewPo() {
    this.context.router.push("budget-configuration");
  }

  render() {
    const { poOptions } = this.props
  	return (
  		<div className="settings">
  			<div className="settings-container">
            <div>
            <p>Please choose the type of spend control system : 
              <span className="button-switch">
                {poOptions.map((data, i) => {
                  return (
                    <button key={i} type="button" onClick={this.setPoOption.bind(this, data.id_option)} className={data.active_option == 1 ? "button-blue" : null}>
                      {data.name}
                    </button>
                  );
                })}
              </span>
            </p>
            </div>
  			</div>
  		</div>
	  );
  }
}

SettingsBudget.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    poOptions: store.settingsState.poOptions
  };
};

export default connect(mapStateToProps)(SettingsBudget);