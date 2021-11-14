import React from 'react';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import * as G from '../../api/common-api';
import store from '../../store/configureStore';
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';

class Orders extends React.Component {
	constructor(props){
		super(props)
	}

	componentWillMount(){
		G.checkWidget(2, true)
	}

	render() {
		return (
			<div>
		    	{(this.props.widgetStatus == 1) ? <div>{this.props.children}</div> : 
		    	(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={2} /> : 
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

export default connect(mapStateToProps)(Orders);