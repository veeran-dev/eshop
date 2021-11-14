import React from 'react'
import ReactDOM from 'react-dom'
import {toastr} from 'react-redux-toastr'
import RelationshipManager from '../modules/dashboard/relationship-manager'
import ReactTooltip from 'react-tooltip'

import * as salesApi from '../../api/sales-api'
import * as G from '../../api/common-api'

import Quotations from '../modules/dashboard/Quotations'
import Orders from '../modules/dashboard/Orders'
import Payments from '../modules/dashboard/Payments'
import TopCustomers from '../modules/dashboard/TopCustomers'
import TopProducts from '../modules/dashboard/TopProducts'
import MonthlyRevenue from '../modules/dashboard/MonthlyRevenue'
import SellingProducts from '../modules/dashboard/SellingProducts'
import ActiveCustomers from '../modules/dashboard/ActiveCustomers'
import InformationPop from '../../components/common/InformationContent'

 class Dashboard extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      dashboardWidgets: [[['filename','order-status'],['id',45]]],
      payments: [],
      orders: [],
      quotations: [],
      MonthlyRevenue: [],
      ActiveCustomers: [],
      SellingProducts: [],
    }
  }

  componentWillMount(){
    salesApi.getDashboardKpi().then(response=>{
      console.log(response.data)
      this.setState({
        payments: response.data['payments'],
        orders: response.data['orders'],
        quotations: response.data['quotations'],
        MonthlyRevenue: response.data['monthlyRevenue'],
        ActiveCustomers: response.data['activeCustomers'],
        SellingProducts: response.data['sellingProducts'],
      })
    })
  }

  comingSoon(){
    ReactDOM.render(<InformationPop message={"The feature is coming soon !!!"} />, document.getElementById("informContent"));
    G.displayModal("inform");
  }

  toProfile(){
    this.props.history.push("/settings")
  }
  redirect(url){
    console.log(url)
    // this.props.history.push(url)
  }

  render() {
    return (
            <div className="dashboard">
                <ReactTooltip />
                <div className="dashboard-container">
                  <div className="widget-container">
                    <Payments data={this.state.payments} redirect={this.redirect.bind(this)}/>
                    <Orders data={this.state.orders} redirect={this.redirect.bind(this)}/>
                    <Quotations data={this.state.quotations} redirect={this.redirect.bind(this)}/>
                    <TopCustomers />
                    <TopProducts />
                    <MonthlyRevenue data={this.state.MonthlyRevenue}/>
                    <ActiveCustomers data={this.state.ActiveCustomers}/>
                    <SellingProducts data={this.state.SellingProducts}/>
                  </div>
                    <div className="static-widgets">
                      <div className="widget-collection">
                        <div className="widget-top-section">
                          <div className="widget-micro" onClick={this.comingSoon.bind(this)}>
                              <div className="widget-micro-wrapper">
                                <i className="icon-truck"></i>
                                <p>Book Delivery</p>
                              </div>
                          </div>
                          <div className="widget-micro" onClick={this.comingSoon.bind(this)}>
                              <div className="widget-micro-wrapper">
                                <i className="icon-credit-card"></i>
                                <p>Get Credit</p>
                              </div>
                          </div>
                          <div className="widget-micro" onClick={this.comingSoon.bind(this)}>
                              <div className="widget-micro-wrapper">
                                <i className="icon-user-plus"></i>
                                <p>Invite Customer</p>
                              </div>
                          </div>
                          <div className="widget-micro" onClick={this.comingSoon.bind(this)}>
                              <div className="widget-micro-wrapper">
                                <i className="icon-document-add"></i>
                                <p>Add Product</p>
                              </div>
                          </div>
                        </div>
                        <div>
                          <button className="button-blue outline" onClick={this.toProfile.bind(this)}>Update Profile</button>
                        </div> 
                      </div>
                      <RelationshipManager />
                    </div>
               </div>
            </div>
      )
  }
}
export default Dashboard;