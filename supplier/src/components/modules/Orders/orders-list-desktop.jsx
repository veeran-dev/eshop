import React from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import * as orderApi from '../../../api/orders-api';
import * as G from '../../../api/common-api';
import ReactPaginate from 'react-paginate';
import MydateFilter from '../../common/datepicker';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import ConfirmationContent from '../../common/ConfirmationContent'
import ReportContent from '../../common/ReportContent'

// Using "Stateless Functional Components"
class OrderList extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      pageNumber: 0,
      offset:0,
      limit: 10,
      duration: 5,
      fromDate: "",
      toDate: "",
      orderBy: "koha.`date_add`",
      orderWay: "DESC",
      q: "",
      idPage: "",
      updatePagination: false,
      selectedStatus:0,
      selectedCustomer: 0,
      input: '',
    }
  }

  componentDidMount() {
    this.getOrders(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
  }

  selectStatus(type, value, e){
    this.setState({updatePagination: true})
    if(type == 1){
      this.setState({selectedStatus: value},function(){
        this.getOrders(this.state.limit, this.state.offset, this.state.fromDate, this.state.toDate, this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false, null)
      });
    }
    if(type == 2){
      this.setState({selectedCustomer : value},function(){
      this.getOrders(this.state.limit, this.state.offset, this.state.fromDate, this.state.toDate, this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false, null);
      });
    }
  }

  viewOrder(id_order){
    this.props.view("/orders/view/"+id_order);
  }

  cancelOrder(id_order){
    G.closeModal(["confirm"])
    orderApi.updateOrderStatus(id_order, 6).then(response =>{
      this.getOrders(this.state.limit, this.state.offset, this.state.fromDate, this.state.toDate, this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q);
      return response
    });
  }

  confirmCancel(id_order){
    ReactDOM.render(<ConfirmationContent 
            onCancel={(e)=>{console.log(e)}}
            onClick={this.cancelOrder.bind(this, id_order)} 
            message={"Please confirm to cancel the order #"+id_order+" ?"}/>, 
            document.getElementById("confirmContent"))
    G.displayModal("confirm")
  }

  getOrders(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset, updatePagination, dynamicObject){
    if(reset){
      this.refs.orderPerPage.value = 10
      this.refs.searchQuery.value = ""
      G.resetDate(this.datePicker)
      // this.datePicker.reset();
      this.setState({pageNumber: 0, selectedCustomer: 0, selectedStatus:0})
    }
    else{
      this.setState({pageNumber: undefined}) 
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

    if(this.refs.orderPerPage.value){
      limit = this.refs.orderPerPage.value
    }
    if(this.refs.orderPerPage.value != this.state.limit){
      this.setState({pageNumber: 0})
    }
    
    q = this.refs.searchQuery.value != "" ? this.refs.searchQuery.value : ""

    if(fromDate == "" && toDate == "") {
      G.resetDate(this.datePicker)
      this.setState({fromDate: "", toDate: ""})
    }

    orderApi.getOrders(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset?0:this.state.selectedStatus, reset?0:this.state.selectedCustomer);
    
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

  openReportWindow(){
      ReactDOM.render(<ReportContent company={this.props.customers} ids={Math.random(1000)+"_id_report_content"} />,
            document.getElementById("reportContent"))
       G.displayModal("report")
  }

  render(){
    const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination, pageNumber  } = this.state
    let pageCount = parseInt(this.props.orderCount) / parseInt(limit);
    pageCount = pageCount > parseInt(pageCount) ? parseInt(pageCount)+1 : parseInt(pageCount);
    return (
        <div>
          <div className="order-list-search">
            <div className="searchWrapper">
            <input ref="searchQuery" type="text" placeholder="Search your orders and customers" 
            	onChange={(e)=>{
                console.log(e.target.value)
                if (this.state.typingTimeout) {
                  clearTimeout(this.state.typingTimeout);
                }
                this.setState({
                  input: e.target.value,
                  typing: false,
                  typingTimeout: setTimeout(function(){
                      this.getOrders(limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, this.state.input, false, true, null)
                      console.log("done launch")
                    }.bind(this), 750)
                });
            }}/>
            <i className="icon-search"></i>
            </div>
            <div>
              <button className="button-blue outline" onClick={this.openReportWindow.bind(this)}>Download Reports</button>
            </div>
          </div>
          <div className="order-list-container">
            <div className="order-filter-container">
              <div className="filter-header">
                <h3>Filters</h3>
              </div>
              <div className="filter-wrapper">
                <div className="title">Order Status</div>
                <div className="actions">
                  <ul className="order_status_filter">
                    <li className={this.state.selectedStatus == 0 ? "active": ""} onClick={this.selectStatus.bind(this, 1, 0)}>All Status</li>
                    {this.props.orderStatusWithCount.length > 0 ? this.props.orderStatusWithCount.map(function(status, i){
                      return(
                      <li id={status.id_order_state} className={this.state.selectedStatus == status.id_order_state ? "active": ""} key={status.id_order_state} onClick={this.selectStatus.bind(this, 1, status.id_order_state)}>
                        <span>{status.name}</span>
                        <span>{status.cn}</span>
                      </li>
                      )
                    }.bind(this)):
                    <div className="fetching">
                      <div className="fetching-content">
                        <div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item">
                      </div>
                    </div></div>
                    }
                  </ul>
                </div>
              </div>
              <div className="filter-wrapper">
                <div className="title">Customers</div>
                <div className="actions">
                {this.props.customers != undefined && this.props.customers.length >0 ?
                  <ul className="order_status_filter">
                    <li className={this.state.selectedCustomer == 0 ? "active": ""} onClick={this.selectStatus.bind(this, 2, 0)}>All Customers</li>
                    {this.props.customers.length > 0 ? this.props.customers.map(function(customer, i){
                      return(
                      <li id={customer.id_group} className={this.state.selectedCustomer == customer.id_group ? "active": ""} key={status.id_order_state} onClick={this.selectStatus.bind(this, 2, customer.id_group)}>
                        <span>{customer.company}</span>
                        <span>{customer.cn}</span>
                      </li>
                      )
                    }.bind(this)):
                    <div className="fetching">
                      <div className="fetching-content">
                        <div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item">
                      </div>
                    </div></div>
                    }
                  </ul>
                :<div className="no-results">
                    <img src="../supplier/src/assets/img/no-data.png" alt="No Results"/>
                    <h2>No Customers Tagged!</h2>
                    <p>Please contact support team</p>
                  </div>}
                </div>
              </div>
            </div>
              <div className="order-list-wrapper">
                <div className="table-filter">
                  <div className="page-filter">
                    <div className="duration-filter">
                      <MydateFilter ref={el => (this.datePicker = el)} changeRequested={true} onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                    </div>
                    <div className="reset-button">
                      <Ripples><button onClick={this.getOrders.bind(this, 10, 0, "", "", 5, "", "koha.`date_add`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
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
                      pageCount={parseInt(pageCount)}
                      marginPagesDisplayed={0}
                      pageRangeDisplayed={0}
                      totalRecordsDisplay={true}
                      shouldUpdate={updatePagination}
                      onPageChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
                      containerClassName={"pagination"}
                      subContainerClassName={"pages pagination"}
                      activeClassName={"active"}
                      forcePage={pageNumber} />
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
                    <th className="text-align-left">
                      Customers
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kgl.`name`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kgl.`name`', 'ASC', q, false, true, null)}></div>
                      </div>
                    </th>
                    <th className="text-align-right">
                      Total Value
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, '`total_paid_sort`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, '`total_paid_sort`', 'ASC', q, false, true, null)}></div>
                      </div>
                    </th>
                    <th>
                      Status
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kosl.`name`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'kosl.`name`', 'ASC', q, false, true, null)}></div>
                      </div>
                    </th>
                    <th>
                      Order Placed
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'koha.`date_add`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'koha.`date_add`', 'ASC', q, false, true, null)}></div>
                      </div>
                    </th>
                    <th>
                      Actions        
                    </th>
                  </tr>
                </thead>
                <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                    {this.props.isFetching && this.props.orders && this.props.orders.length > 0 ? 
                      <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td><td></td></tr> : 
                      (this.props.orders && this.props.orders.length > 0 ? this.props.orders.map(order => {
                        return (
                          <tr key={order.id_order}>
                              <td data-title="Order ID"><a href="javascript:void(0)" onClick={this.viewOrder.bind(this, order.id_order)}>{order.id_order}</a></td>
                              <td data-title="Company"><strong>{order.company}</strong> <br></br>{order.email}</td>
                              <td className="text-align-center" data-title="Total"><div>{G.toPrice(order.total_paid)}</div><div>{order.quantity} Products</div></td>
                              <td data-title="Status"> <span className="order-status" style={{backgroundColor: order.color}}>{order.name}</span></td>
                              <td data-title="Ordered On">{G.getDate(order.date_add, "lll")}</td>
                              <td data-title="Actions">
                                <button className="button-blue outline" onClick={this.viewOrder.bind(this, order.id_order,)}>View</button>
                                {order.id_order_state == 22 ?
                                <span className="cancel" onClick={this.confirmCancel.bind(this, order.id_order)}>
                                  <i className="icon-cancel"></i>
                                  <span>Cancel</span>
                                </span>
                                :null}
                              </td>
                          </tr> 
                        );
                      }) : <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>Please check with your customers</p></div></td><td></td></tr>)
                    }
                </ReactCSSTransitionGroup>
              </table>
          </div>
        </div> 
      </div>
    )
  }
}

const mapStateToProps = function({orderState}) {
  return {
    orders: orderState.orderLists,
    orderStatusWithCount: orderState.orderStatusCount,
    orderCount: orderState.orderCount,
    customers: orderState.allCustomers,
    isFetching: orderState.isFetching,
  };
};

export default connect(mapStateToProps)(OrderList);
