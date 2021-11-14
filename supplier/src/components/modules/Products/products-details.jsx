import React from 'react';
import ReactDOM from 'react-dom'
import { Link } from 'react-router-dom';
import { connect } from 'react-redux';
import * as orderApi from '../../../api/orders-api';
import * as G from '../../../api/common-api';
import store from '../../../store/configureStore';
import ReactPaginate from 'react-paginate';
import MydateFilter from '../../common/datepicker';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import CurrencyFormat from 'react-currency-format';

// Using "Stateless Functional Components"
class ProductsList extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      offset:0,
      limit: 10,
      duration: 5,
      fromDate: "",
      toDate: "",
      orderBy: "ko.`id_order`",
      orderWay: "DESC",
      q: "",
      idPage: "",
      updatePagination: false
    }
  }

  componentDidMount() {
    this.getOrders(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
  }

  viewOrder(id_order){
    this.props.history.push("/orders/view/"+id_order);
  }

  getOrders(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset, updatePagination, dynamicObject){

    if(reset){
      this.refs.orderPerPage.value = 10
      this.refs.searchQuery.value = ""
      G.resetDate(this.datePicker)
      // this.datePicker.reset();
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
      G.resetDate(this.datePicker)
      this.setState({fromDate: "", toDate: ""})
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

  render(){
    const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination  } = this.state
    return (
        <div>
          <div className="page-header">
            <h3 className="page-title">Order Lists</h3>
          </div> 
          <div className="page-container">
              <div className="table-filter">
                <div className="page-filter">
                  <div className="duration-filter">
                    <MydateFilter ref={el => (this.datePicker = el)} changeRequested={true} onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                  </div>
                  <div className="reset-button">
                    <Ripples><button onClick={this.getOrders.bind(this, 10, 0, "", "", 5, "", "ko.`id_order`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                  </div>
                </div>

                <div className="pagination-container">
                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" defaultValue={10} onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}>
                    <option >10</option>
                    <option >25</option>
                    <option >50</option>
                    <option >100</option>
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
                    onPageChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
                    containerClassName={"pagination"}
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
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'ko.`id_order`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'ko.`id_order`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    Customer
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kc.`email`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kc.`email`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th className="text-align-left">
                    Company
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kgl.`id_group`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kgl.`id_group`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th className="text-align-right">
                    Total
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'ko.`total_paid`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'ko.`total_paid`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    Status
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kosl.`id_order_state`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kosl.`id_order_state`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    Order Placed
                    <div className="sorting">
                      <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'koh.`date_add`', 'DESC', q, false, true, null)}></div>
                      <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'koh.`date_add`', 'ASC', q, false, true, null)}></div>
                    </div>
                  </th>
                  <th>
                    <input ref="searchQuery" type="text" placeholder="Search" onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}/>
                  </th>
                </tr>
              </thead>
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} transitionEnterTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (this.props.orders && this.props.orders.length > 0 ? this.props.orders.map(order => {
                      return (
                        <tr key={order.id_order}>
                            <td data-title="Order ID"><a href="javascript:void(0)" onClick={this.viewOrder.bind(this, order.id_order)}>{order.id_order}</a></td>
                            <td data-title="Customer">{order.email}</td>
                            <td data-title="Company">{order.company}</td>
                            <td className="text-align-right" data-title="Total"><CurrencyFormat prefix={'₹'} value={order.total_paid} displayType={'text'} /></td>
                            <td data-title="Status">{order.name}</td>
                            <td data-title="Ordered On">{order.date_add}</td>
                            <td data-title="Actions">
                              <button className="button-blue outline" onClick={this.viewOrder.bind(this, order.id_order,)}>View Order</button>
                            </td>
                        </tr> 
                      );
                    }) : <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>Please check with your customers</p></div></td></tr>)
                  }
              </ReactCSSTransitionGroup>
            </table>
        </div> 
      </div>
    )
  }
}

const mapStateToProps = function({orderState}) {
  return {
    orders: orderState.orderLists,
    isFetching: orderState.isFetching,
  };
};

export default connect(mapStateToProps)(ProductsList);
