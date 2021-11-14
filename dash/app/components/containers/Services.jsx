import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import { checkWidget, openRequestQuote } from '../../api/common-api';
import store from '../../store/configureStore';
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';
import Ripples from 'react-ripples'

class Services extends React.Component {
  constructor(props){
  	super(props)
  }

  componentWillMount() {
  	checkWidget(7, true)
  }

  render() {
    return (
    	<div>
    	{(this.props.widgetStatus == 1) ?
    		<div className="services">
          <div className="page-header">
            <h3 className="page-title">Services</h3>
              <div className="action-block">
                {/*<Ripples><button className="button-red outline" onClick={openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
              </div>
          </div>
          <div className="page-container service-list">
            <Link to="skyscanner" className="service-list-item">
              <div className="service-list-item-thumb">
                <img src="dash/img/api/flight.jpg" alt="Flights Search"/>
              </div>
              <div className="service-list-item-name">
                <h3>Flight Booking</h3>
              </div>
            </Link>
            <a href="javascript:void(0)" className="service-list-item disabled">
              <div className="service-list-item-thumb">
                <img src="dash/img/api/hotels.jpg" alt="Hotel Booking"/>
              </div>
                
              <div className="service-list-item-name">
                <h3>Hotel Booking</h3>
              </div>
              <h2>Coming Soon!</h2>
            </a>
            <a href="javascript:void(0)" className="service-list-item disabled">
              <div className="service-list-item-thumb">
                <img src="dash/img/api/services.jpg" alt="Professional Services"/>
              </div>
              <div className="service-list-item-name">
                <h3>Professional Services</h3>
              </div>
              <h2>Coming Soon!</h2>
            </a>
          </div>
        </div>:
    	(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={7} /> : 
	    (this.props.widgetStatus == 3) ? <WidgetNoAccess /> : null }
    	</div>
    );
  }
}

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus
  };
};

export default connect(mapStateToProps)(Services);