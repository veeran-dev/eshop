import React from 'react';
import { connect } from 'react-redux';
import Ripples from 'react-ripples';
import { Link } from 'react-router';
import * as G from '../../api/common-api'
import store from '../../store/configureStore';
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';

class Invoices extends React.Component {
  constructor(props){
  	super(props)
  }

  componentWillMount(){
  	G.checkWidget(20, true)
  }

  render() {
	    return (
	    	<div>
	    	{ (this.props.widgetStatus == 1) ?
		    	<div>
			    	<div>
			            <div className="page-header">
				            <h3 className="page-title">Payments</h3>
				            {/*<div className="page-filter">
				              <Ripples className="button-group-item">
				              	<Link className="button" to="invoices-drs/invoices" activeClassName="active">
				              		Invoices
				              	</Link>
				              </Ripples>
				              <Ripples className="button-group-item">
				              	<Link className="button" to="invoices-drs/delivery-receipts" activeClassName="active">
				              		Delivery Receipts
				              	</Link>
				              </Ripples>
				            </div>*/}
              				<div className="action-block">
              					{/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples> */}
              				</div>				            
				        </div>
					</div>
					<div>
			    		{this.props.children}
			    	</div>
			    </div> :
			 (this.props.widgetStatus == 2) ? 
	            <WidgetNotInstalled idWidget={20} /> : 
	         (this.props.widgetStatus == 3) ? 
		      	<WidgetNoAccess /> : null }
			</div>
		)
  }
}

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus
  }
}

export default connect(mapStateToProps)(Invoices)