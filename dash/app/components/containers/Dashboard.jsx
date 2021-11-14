import React from 'react'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import RelationshipManager from '../views/dashboard/relationship-manager'
import PromotionalBanner from '../views/dashboard/promotional-banner'
import * as G from '../../api/common-api'
import * as dashboardApi from '../../api/dashboard-api'
import store from '../../store/configureStore'
import MydateFilter from '../common/datepicker'
import DashboardWidgets from '../views/dashboard/DashboardWidgets'
import WidgetNotInstalled from '../common/empty-states/widget-not-installed';
import WidgetNoAccess from '../common/empty-states/widget-no-access';
import Ripples from 'react-ripples'

class Dashboard extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      offset:0,
      limit: 4,
      duration: 5,
      fromDate: "",
      toDate: "",
      idPage: 0
    }
  }

  componentWillMount(){
    G.checkWidget(14, true)
  }

  handleDashboardFunctions(limit, offset, fromDate, toDate, duration, idPage, reset, dynamicObject = ""){
    if(this.props.dashboardWidgets != "" && this.props.dashboardWidgets.length > 0) {
        if(reset){
          G.resetDate(this.refs.datePicker)
        }

        if(dynamicObject != null && dynamicObject !== undefined) {
          if((dynamicObject.from && dynamicObject.to)){
            fromDate = G.getDate(dynamicObject.from, "dd-mm-yyyy")
            toDate = G.getDate(dynamicObject.to, "dd-mm-yyyy")
          }
          else if(dynamicObject.selected == 0 || dynamicObject.selected){
            idPage = dynamicObject.selected
          }
        }

        if(fromDate == "" && toDate == "") {
          G.resetDate(this.refs.datePicker)
        }
        
        dashboardApi.getOrderStatus(limit, offset, fromDate, toDate, duration, idPage);
        dashboardApi.getApprovals(limit, offset, fromDate, toDate, duration, idPage);
        dashboardApi.topCategories(fromDate, toDate, duration);
        dashboardApi.getTop4Products(fromDate, toDate, duration);

        this.setState({
          limit: limit,
          offset: offset,
          duration: duration,
          idPage: idPage,
          fromDate: fromDate,
          toDate: toDate
        })
    }
    else {
      toastr.error("Error", "No widgets found to perform this action.", {icon: 'icon-error'})
    }
  }

  viewOrder(url){
    this.props.history.push(url)
  }

  render() {
    const { limit, offset, fromDate, toDate, duration, idPage } = this.state
    const { widgetStatus } = this.props
    return (
          <div>
          {(widgetStatus == 1) ?
            <div className="dashboard">
                <div className="page-header">
                  <h3 className="page-title">Dashboard</h3>
                  <div className="page-filter">
                    <div className="duration-filter">
                      <MydateFilter ref="datePicker" changeRequested={true} onChange={this.handleDashboardFunctions.bind(this, limit, offset, fromDate, toDate, "", idPage, false)}/>
                    </div>
                    <div className="reset-button">
                      <Ripples><button onClick={this.handleDashboardFunctions.bind(this, 4, 0, "", "", 5, 0, true)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                    </div>
                    <div className="default-duration-filter">
                      <Ripples className="button-group-item"><button className={duration == 1 ? "active" : ""} onClick={this.handleDashboardFunctions.bind(this, limit, offset, "", "", 1, idPage, false)}>Now</button></Ripples>
                      <Ripples className="button-group-item"><button className={duration == 2 ? "active" : ""} onClick={this.handleDashboardFunctions.bind(this, limit, offset, "", "", 2, idPage, false)}>Day</button></Ripples>
                      <Ripples className="button-group-item"><button className={duration == 3 ? "active" : ""} onClick={this.handleDashboardFunctions.bind(this, limit, offset, "", "", 3, idPage, false)}>Week</button></Ripples>
                      <Ripples className="button-group-item"><button className={duration == 4 ? "active" : ""} onClick={this.handleDashboardFunctions.bind(this, limit, offset, "", "", 4, idPage, false)}>Month</button></Ripples>
                      <Ripples className="button-group-item"><button className={duration == 5 ? "active" : ""} onClick={this.handleDashboardFunctions.bind(this, limit, offset, "", "", 5, idPage, false)}>All Time</button></Ripples>
                    </div>
                  </div>
                  <div className="action-block">
                    <Ripples><Link to="invite-supplier" className="button button-green">Invite Supplier</Link></Ripples>
                    <Ripples><Link className="button button-red add-widget" to="store">Add Widget</Link></Ripples>
                  </div>
                </div>
                <div className="dashboard-container">
                    <DashboardWidgets state={this.state} viewOrder={this.viewOrder.bind(this)}/>
                    <div className="static-widgets">
                      <RelationshipManager />
                      <PromotionalBanner />
                    </div>
        	     </div>
            </div> :
           (widgetStatus == 2) ? <WidgetNotInstalled idWidget={14} /> : 
	         (widgetStatus == 3) ? <WidgetNoAccess /> : null }
        </div>
      )
  }
}

const mapStateToProps = function(store) {
  return {
    widgetStatus: store.commonState.widgetStatus,
    dashboardWidgets: store.commonState.dashboardWidgets
  };
};

export default connect(mapStateToProps)(Dashboard);