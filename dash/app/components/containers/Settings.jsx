import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import * as G from '../../api/common-api';
import store from '../../store/configureStore';
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';
import Ripples from 'react-ripples';

class Settings extends React.Component {
  constructor(props){
  	super(props)
  }

  componentWillMount() {
  	G.checkWidget(8, true)
    G.checkBudgetInstalled()
  }

  render() {
    return (
    	<div>
    	{(this.props.widgetStatus == 1) ?
        <div className="settings">
            <div className="page-header">
              <h3 className="page-title">Settings</h3>
              <div className="page-filter">
                <div className="sub-page-filter">
                  <Ripples className="button-group-item">
                  <Link className="button" to="settings/profile" activeClassName="active">Profile</Link>
                </Ripples>
                <Ripples className="button-group-item">
                  <Link className="button" to="settings/address" activeClassName="active">Address</Link>
                </Ripples>
                {!(role == 1) && this.props.budgetInstalled == 1 ?
                  <Ripples className="button-group-item">
                    <Link className="button" to="settings/budget" activeClassName="active">Spend Control</Link>
                  </Ripples> : null}
              </div>
              </div>
              <div className="action-block">
                {/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
              </div>              
            </div>
            <div className="settings-container">
              {this.props.children}
            </div>
          </div> :
    	(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={8} /> : 
	    (this.props.widgetStatus == 3) ? <WidgetNoAccess /> : null }
    	</div>
    );
  }
}

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus,
    budgetInstalled: store.commonState.budgetInstalled
  };
};

export default connect(mapStateToProps)(Settings);