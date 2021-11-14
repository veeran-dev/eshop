import React from 'react'
import { Link } from 'react-router';
import { connect } from 'react-redux'
import ProcureHeader from '../views/procure/procure-header'
import * as G from '../../api/common-api'
import store from '../../store/configureStore'
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';

class Procure extends React.Component {
  constructor(props){
  	super(props)
  }

  componentWillMount(){
  	G.checkWidget(1, true)
  }

  render() {
    return (
    	<div>
    	{(this.props.widgetStatus == 1) ?
	    	<div>
		      <ProcureHeader />
		      <div className="procure-container">
		      	{this.props.children}
		      </div>
		    </div> :
				(this.props.widgetStatus == 2) ? <WidgetNotInstalled idWidget={1} /> : 
	      (this.props.widgetStatus == 3) ? <WidgetNoAccess /> : null }
		</div>
	)
  }
}

const mapStateToProps = function(store) {
  return {
  	widgetStatus: store.commonState.widgetStatus
  }
};

export default connect(mapStateToProps)(Procure)