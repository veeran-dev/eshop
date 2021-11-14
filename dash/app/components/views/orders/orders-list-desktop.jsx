  import React from 'react';
import ReactDOM from 'react-dom'
import { Link } from 'react-router';
import { connect } from 'react-redux';
import * as orderApi from '../../../api/orders-api';
import * as G from '../../../api/common-api';
import {toastr} from 'react-redux-toastr';
import store from '../../../store/configureStore';
import ReactPaginate from 'react-paginate';
import DayPicker from 'react-day-picker';
import MydateFilter from '../../common/datepicker';
import Input from '../../common/Input'
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

// Using "Stateless Functional Components"
class OrderListDesktop extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      offset:0,
      limit: 10,
      duration: 5,
      fromDate: "",
      toDate: "",
      orderBy: "o.`id_order`",
      orderWay: "DESC",
      q: "",
      idPage: "",
      updatePagination: false
    }
  }

  componentDidMount() {
    this.getOrders(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
  }

  getOrders(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset, updatePagination, dynamicObject){

    if(reset){
      this.refs.orderPerPage.value = 10
      this.refs.searchQuery.value = ""
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

    if(this.refs.orderPerPage.value)
      limit = this.refs.orderPerPage.value
    
    q = this.refs.searchQuery.value != "" ? this.refs.searchQuery.value : ""

    if(fromDate == "" && toDate == "") {
      G.resetDate(this.refs.datePicker)
    }

    orderApi.getOrders(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q);
    
    this.setState({
        limit: limit,
        offset: offset,
        fromDate: fromDate,
        toDate: toDate,
        duration: duration,
        idPage: idPage,
        orderBy: orderBy,
        orderWay: orderWay,
        q: q,
        updatePagination: updatePagination
    })

  }

  view(id_order){
    // this.props.history.push('/orders/'+id_order);
    this.props.view('/orders/'+id_order);
  }

  render(){
    const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination  } = this.state
    return (
        <div>
          <div className="page-header">
            <h3 className="page-title">Order History</h3>
              <div className="action-block">
                {/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
              </div>
          </div> 
          <div className="page-container">
              <div className="table-filter">
                <div className="page-filter">
                  <div className="duration-filter">
                    <MydateFilter ref="datePicker" changeRequested={true} onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                  </div>
                  <div className="reset-button">
                    <Ripples><button onClick={this.getOrders.bind(this, 10, 0, "", "", 5, "", "o.`id_order`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                  </div>

                  <div className="default-duration-filter">
                    <Ripples className="button-group-item"><button className={duration == 1 ? "active" : ""} onClick={this.getOrders.bind(this, limit, offset, "", "", 1, 0, orderBy, orderWay, q, false, true, null)}>Now</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 2 ? "active" : ""} onClick={this.getOrders.bind(this, limit, offset, "", "", 2, 0, orderBy, orderWay, q, false, true, null)}>Day</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 3 ? "active" : ""} onClick={this.getOrders.bind(this, limit, offset, "", "", 3, 0, orderBy, orderWay, q, false, true, null)}>Week</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 4 ? "active" : ""} onClick={this.getOrders.bind(this, limit, offset, "", "", 4, 0, orderBy, orderWay, q, false, true, null)}>Month</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 5 ? "active" : ""} onClick={this.getOrders.bind(this, limit, offset, "", "", 5, 0, orderBy, orderWay, q, false, true, null)}>All Time</button></Ripples>
                  </div>
                </div>

                <div className="pagination-container">
                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}>
                    <option defaultValue={10} selected>10</option>
                    <option defaultValue={25}>25</option>
                    <option defaultValue={50}>50</option>
                    <option defaultValue={100}>100</option>
                  </select>
                  <ReactPaginate 
                    nextLabel={<i className="icon-arrow-right"></i>}
                    previousLabel={<i className="icon-arrow-left"></i>}
                    breakLabel={<a href="javascript: void(0)">...</a>}
                    breakClassName={"break-me"}
                    pageNum={parseInt(this.props.orderCount)}
                    marginPagesDisplayed={0}
                    pageRangeDisplayed={0}
                    totalRecordsDisplay={true}
                    shouldUpdate={updatePagination}
                    containerClassName={"pagination"}
                    clickCallback={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"} />
                </div>
            </div>

            <table>
              <thead>
                <tr>
                  <th>
                    Order ID
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    Ordered On
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, '`date_add`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, '`date_add`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    Supplier
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'supplier_name', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'supplier_name', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th className="text-align-right">
                    Total Price
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, '`total_paid`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, '`total_paid`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    Order Status
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'osl.`name`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'osl.`name`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    Payment Mode
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`payment`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`payment`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    <input ref="searchQuery" type="text" placeholder="Search" 
                      onChange={(e)=>{
                          console.log(e.target.value)
                          if (this.state.typingTimeout) {
                            clearTimeout(this.state.typingTimeout);
                          }
                          this.setState({
                            input: e.target.value,
                            typing: false,
                            typingTimeout: setTimeout(function(){
                                this.getOrders(limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, this.state.input.trim(), false, true, null)
                                console.log("done launch")
                              }.bind(this), 750)
                          });
                      }}/>
                  </th>
                </tr>
              </thead>
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? <tr><td className="fetching" colSpan="7"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (this.props.orders && this.props.orders.length > 0 ? this.props.orders.map(order => {
                      return (
                        <tr id={order.id_order} key={order.id_order}>
                            <td data-title="Order ID"><a href="javascript:void(0)" onClick={this.view.bind(this, order.id_order)}>{order.id_order}</a></td>
                            <td data-title="Ordered On">{order.date_add != null ? order.date_add : "Not Available"}</td>
                            <td data-title="Supplier">{order.supplier_name}</td>
                            <td className="text-align-right" data-title="Total Price">{G.toPrice(order.total_paid ? order.total_paid : '0.00')}</td>
                            <td data-title="Status">{order.order_state}</td>
                            <td data-title="Payment Mode">{order.payment == "PENDING FOR APPROVAL" ? "--" : order.payment}</td>
                            <td data-title="Actions">
                              <button className="button-blue outline" onClick={this.view.bind(this, order.id_order)}>View Order</button>
                              <button className="button-blue" style={{ color: '#fff' }} onClick={G.reOrderView.bind(this, order.id_order, this.props.cart, this.context.router)}>Reorder</button>
                            </td>
                        </tr>
                      );
                    }) : <tr className="no-results-wrapper"><td colSpan="7"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>What keeps you waiting? Just click <Link to="procure">Buy Now!</Link></p></div></td></tr>)
                  }
              </ReactCSSTransitionGroup>
            </table>
        </div> 
      </div>
    )
  }
}

// OrderList.defaultProps = {
//   isFetching: true
// };

OrderListDesktop.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    orders: store.orderState.orders,
    orderCount: store.orderState.orderCount,
    cart: store.cartState.cart,
    isFetching: store.orderState.isFetchingOrders
  };
};

export default connect(mapStateToProps)(OrderListDesktop);
