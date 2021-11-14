import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as orderApi from '../../../api/orders-api'
import * as G from '../../../api/common-api'

class OrderStatus extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      idPage: 0,
      limit: 4
    }
  }

  componentDidMount() {
    orderApi.getOrders(this.state.limit);
  }

  viewOrderDetail(id_order){
    this.props.history.push("/orders/view/"+id_order);
  }
  handlePaginationCard(idPage, totalPage, type){
    let fromDate = "", toDate = ""
    let pageID = G.getPageID(idPage, totalPage, type)
    
    // if(document.getElementById('from-date').value != "" && document.getElementById('to-date').value != ""){
    //   fromDate = G.getDate(document.getElementById('from-date-hidden').value, "dd-mm-yyyy");
    //   toDate = G.getDate(document.getElementById('to-date-hidden').value, "dd-mm-yyyy");
    // }
    orderApi.getOrders(this.state.limit, null, null, null, null, pageID);
    // dashboardApi.getOrderStatus(4, this.props.parentState.offset, null, null, null, pageID);

    this.setState({ idPage: pageID })
  }

  render() {
    return 	(
        <div className="widget order-status">
              <div className="widget-header">
                <h3>Order Status</h3>
              </div>
        			<table className="widget-compressed-table">
        				<thead>
                  <tr>
        					<th>Order Id</th>
        					<th>Order Status</th>
        					<th>Estimated Delivery Time</th>
                  </tr>
        				</thead>
                <tbody>
        					{this.props.isFetching ? <tr><td className="fetching small" colSpan="3"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (this.props.orderStatus && this.props.orderStatus.length > 0 ? this.props.orderStatus.map((status, i) => {
          						return(
          							<tr key={i}>
      		    						<td data-title="Order Id"><a className="blue-color-text" href="javascript:void(0)" onClick={this.viewOrderDetail.bind(this, status.id_order, status.id_address_delivery, status.id_address_invoice)}>{status.id_order}</a></td>
      		    						<td data-title="Status"><a className="blue-color-text" href="javascript:void(0)" onClick={this.viewOrderDetail.bind(this, status.id_order, status.id_address_delivery, status.id_address_invoice)}>{status.name}</a></td>
      		    						<td data-title="Est. Delivery" className="text-align-right"><a href="javascript:void(0)" onClick={this.viewOrderDetail.bind(this, status.id_order, status.id_address_delivery, status.id_address_invoice)}>{status.estimated_time ? status.estimated_time : "Not Available"}</a></td>
      	    						</tr>
      		    				)
          					}) : <tr className="no-results-wrapper"><td colSpan="4"><div className="no-results small"><h2>No Orders Found!</h2><p>Sorry, currently you don't have any orders.</p></div></td></tr>) }
        				</tbody>
        			</table>
              <div className="pagination-small">
                <a className={"previous"+ (this.state.idPage > 0 ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 1)}><i className="icon-arrow-left"></i> <span>Previous Card</span></a> 
                <a className={"next"+ (this.state.idPage < (this.props.pageCount/this.state.limit) ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 2)}> Next Card <i className="icon-arrow-right"></i></a>
              </div>
    	    </div>
    )
  }
}
const mapStateToProps = function({orderState}) {
  return {
  	orderStatus: orderState.orderWidgetList,
    pageCount: orderState.orderWidgetCount,
    isFetching: orderState.isFetchingHistory
  }
}

export default connect(mapStateToProps)(OrderStatus)