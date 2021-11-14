import React from 'react'
import ReactDOM from 'react-dom'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import OrderStatus from './order-status'
import Approvals from './approvals'
import TopCategories from './top-categories'
import Top4Products from './top-4-products'
import ViewPo from './view-po'
import EliteDeals from './elite-Deals'
import RelationshipManager from './relationship-manager'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import MydateFilter from '../../common/datepicker'
import Ripples from 'react-ripples'

const widgetsByName = { OrderStatus: OrderStatus, Approvals: Approvals, TopCategories: TopCategories, Top4Products: Top4Products, ViewPo: ViewPo};

class DashboardWidgets extends React.Component {
  constructor(props){
    super(props)
  }
  componentWillMount(){
    G.getDashboardWidgets()
  }

  viewOrder(url){
    // this.props.history.push(url)
    this.props.viewOrder(url);
  }
  render() {
    let componentLoop = new Array()
    for(var i = 0; i < this.props.dashboardWidgets.length; i++) {
      this.props.dashboardWidgets.new = widgetsByName[this.props.dashboardWidgets[i].technical_name]
      componentLoop.push(<this.props.dashboardWidgets.new key={i} viewOrder={this.viewOrder.bind(this)} parentState={this.props.state} widgetId={this.props.dashboardWidgets[i].id_widget} />);
    }

    return (
        <div className="widget-container">
          {this.props.isFetching ? 
            <div className="widget-container dummy">
              <div className="widget"></div>
              <div className="widget"></div>
              <div className="widget"></div>
              <div className="widget"></div>
            </div> 
          : (this.props.dashboardWidgets && this.props.dashboardWidgets.length > 0 ? componentLoop : <div className="empty-state-container">
                <div className="empty-state">
                    <div className="empty-state-thumb not-installed"></div>
                    <h1>Looks like you have not installed any widget yet!</h1>
                    <p>Fortunately, it's very easy to install one</p>
                    <Link to="store">Add Widget</Link>
                </div>
            </div>)}
        </div>
    )
  }
}

const mapStateToProps = function(store) {
  return {
    dashboardWidgets: store.commonState.dashboardWidgets,
    isFetching: store.commonState.isFetchingDashboardWidgets
  };
};

export default connect(mapStateToProps)(DashboardWidgets);