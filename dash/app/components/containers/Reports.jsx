import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import store from '../../store/configureStore';
import * as G from '../../api/common-api';
import * as addressApi from '../../api/address-api'
import Ripples from 'react-ripples';
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';

class Reports extends React.Component {
	constructor(props){
		super(props)
	}

	componentWillMount(){
		G.checkWidget(3, true)
		addressApi.getStatesForReports()
	}

	render(){
		return (
		    <div>
		    {(this.props.widgetStatus == 1) ?
			    <div className="reports">
				    <div className="page-header">
				    	<h3 className="page-title">Reports</h3>
				    	<div className="page-filter">
					    	<div className="sub-page-filter">
						    	<Ripples className="button-group-item">
									<Link className="button" to="reports/purchase-history-report" activeClassName="active">Purchase History</Link>
								</Ripples>
								<Ripples className="button-group-item">
									<Link className="button" to="reports/categories-report" activeClassName="active">Categories Report</Link>
								</Ripples>
								<Ripples className="button-group-item">
									<Link className="button" to="reports/location-based-report" activeClassName="active">Location Based Report</Link>
								</Ripples>
							</div>
				    	</div>
                  		<div className="action-block">
                  			{/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
                  		</div>				    	
				    </div>
				    <div className="reports-container">
				    	{this.props.children}
				    </div>
			    </div> :
			(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={3} /> : 
	        (this.props.widgetStatus == 3) ? <WidgetNoAccess /> : null }
			</div>
	    )
	}
}

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus
  };
};

export default connect(mapStateToProps)(Reports);