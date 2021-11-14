import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import { Link } from 'react-router'
import * as dashboardApi from '../../../api/dashboard-api'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'

class OrderStatus extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      idPage: 0
    }
  }

  componentDidMount() {
    dashboardApi.getOrderStatus(this.props.parentState.limit, this.props.parentState.offset, "", "", this.props.parentState.duration, this.state.idPage);
  }

  handlePaginationCard(idPage, totalPage, type){
    let fromDate = "", toDate = ""
    let pageID = G.getPageID(idPage, totalPage, type)
    
    if(document.getElementById('from-date').value != "" && document.getElementById('to-date').value != ""){
      fromDate = G.getDate(document.getElementById('from-date-hidden').value, "dd-mm-yyyy");
      toDate = G.getDate(document.getElementById('to-date-hidden').value, "dd-mm-yyyy");
    }

    dashboardApi.getOrderStatus(4, this.props.parentState.offset, fromDate, toDate, this.props.parentState.duration, pageID);

    this.setState({ idPage: pageID })
  }
  viewOrder(id_order){
    this.props.viewOrder('/orders/'+id_order);
  }

  render() {
    return 	(
        <div className="widget order-status">
              <div className="widget-header">
                <h3>Order Status</h3>
                <button className="close" onClick={G.uninstallWidget.bind(this, this.props.widgetId)}><i className="icon-close"></i></button>
              </div>
        			<table className="widget-compressed-table">
        				<thead>
                  <tr>
        					<th>Order Id</th>
        					<th>Order Status</th>
        					<th>Order Placed On</th>
                  </tr>
        				</thead>
                <tbody>
        					{this.props.isFetching ? <tr><td className="fetching small" colSpan="4"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (this.props.orderStatus && this.props.orderStatus.length > 0 ? this.props.orderStatus.map((status, i) => {
          						return(
          							<tr key={i}>
      		    						<td data-title="Order Id" className="text-align-left"><a className="blue-color-text" href="javascript:void(0)" onClick={this.viewOrder.bind(this, status.id_order)}>{status.id_order}</a></td>
      		    						<td data-title="Status"><a className="blue-color-text" href="javascript:void(0)" onClick={this.viewOrder.bind(this, status.id_order)}>{status.order_state}</a></td>
      		    						<td data-title="Est. Delivery" className="text-align-center"><a href="javascript:void(0)" onClick={this.viewOrder.bind(this, status.id_order)}>{status.date_add ? status.date_add : "Not Available"}</a></td>
      	    						</tr>
      		    				)
          					}) : <tr className="no-results-wrapper"><td colSpan="4"><div className="no-results small"><h2>No Orders Found!</h2><p>What keeps you waiting? Just click <Link to="procure">Buy Now!</Link></p></div></td></tr>) }
        				</tbody>
        			</table>
              <div className="pagination-small">
                <a className={"previous"+ (this.state.idPage > 0 ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 1)}><i className="icon-arrow-left"></i> <span>Previous Card</span></a> 
                <a className={"next"+ (this.state.idPage < (this.props.pageCount-1) ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 2)}> Next Card <i className="icon-arrow-right"></i></a>
              </div>
    	    </div>
    )
  }
}

OrderStatus.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	orderStatus: store.dashboardState.orderHistory,
    pageCount: store.dashboardState.orderHistCount,
    cart: store.cartState.cart,
    isFetching: store.dashboardState.isFetchingHistory
  }
}

export default connect(mapStateToProps)(OrderStatus)