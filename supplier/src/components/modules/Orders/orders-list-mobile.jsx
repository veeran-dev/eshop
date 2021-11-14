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

// Using "Stateless Functional Components"
class OrderList extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      showFilter: false,
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
      selectedStatusName: "",
      selectedCustomer: 0,
      selectedCustomerName: "",
    }
  }

  componentDidMount() {
    this.getOrders(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
  }

  selectStatus(type, value, name, e){
    this.setState({updatePagination: true})
    
    if(type == 1){
      if(this.state.selectedStatus != 0 && this.state.selectedStatus == value){
        value = "";
        name = "";
      }
      if(value == "" || value == 0){
        document.getElementById("status_"+this.state.selectedStatus).checked = false;
      }
      if(this.state.selectedStatus != 0 && this.state.selectedStatus != value){
        document.getElementById("status_"+this.state.selectedStatus).checked = false;
      }
      
      this.setState({selectedStatus: value, selectedStatusName: name},function(){
        this.getOrders(this.state.limit, this.state.offset, this.state.fromDate, this.state.toDate, this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false, null)
      });
    }
    if(type == 2){
      if(this.state.selectedCustomer != 0 && this.state.selectedCustomer == value){
        value = "";
        name = "";
      }
      if(value == "" || value == 0){
        document.getElementById("company_"+this.state.selectedCustomer).checked = false;
      }
      if(this.state.selectedCustomer != 0 && this.state.selectedCustomer != value){
        document.getElementById("company_"+this.state.selectedCustomer).checked = false;
      }
      this.setState({selectedCustomer : value, selectedCustomerName: name},function(){
      this.getOrders(this.state.limit, this.state.offset, this.state.fromDate, this.state.toDate, this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false, null);
      });
    }
    if(type == 3){
      this.setState({fromDate : "", toDate: ""},function(){
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
        updatePagination: updatePagination,
        showFilter: false,
    })
  }

  render(){
    const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination, pageNumber  } = this.state
    let pageCount = parseInt(this.props.orderCount) / parseInt(limit);
    pageCount = pageCount > parseInt(pageCount) ? parseInt(pageCount)+1 : parseInt(pageCount);
    return (
        <div className="order-container">
          <div className="page-header">
            <h3 className="page-title">Order Lists</h3>
          </div> 
          <div className="order-list-search order-list-responsive-search">
            <div className="search-section">
              <input ref="searchQuery" type="text" placeholder="Search your orders and customers" onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}/>
              <i className="icon-search"></i>
            </div>
            <div className="filter-section"><i className="icon-filter" onClick={(e)=>this.setState({showFilter: !this.state.showFilter})}></i></div>
          </div>
          <div className="order-list-container order-list-responsive">
            <div className={this.state.showFilter?"showFilter order-filter-container":"order-filter-container"}>
              <div className="filter-header">
                <h3>Filters</h3>
                <span><i className="icon-close" onClick={(e)=>this.setState({showFilter: !this.state.showFilter})}></i></span>
              </div>
              <div className="filter-wrapper-container">
              <div className="filter-wrapper">
                <div className="title">Date Range</div>
                <div className="actions dateFilter">
                  <MydateFilter ref={el => (this.datePicker = el)} numberOfMonths={1}  changeRequested={true} onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                </div>
              </div>
              <div className="filter-wrapper">
                <div className="title">Order Status</div>
                <div className="actions">
                  <ul className="order_status_filter">
                    {this.props.orderStatusWithCount.length > 0 ? this.props.orderStatusWithCount.map(function(status, i){
                      return(
                      <li id={status.id_order_state} className={this.state.selectedStatus == status.id_order_state ? "active": ""} key={status.id_order_state} >
                        <span>
                          <input type="checkbox" id={"status_"+status.id_order_state}  checked={this.state.selectedStatus==status.id_order_state}/>
                          <label htmlFor={"status_"+status.id_order_state} onClick={this.selectStatus.bind(this, 1, status.id_order_state, status.name)}>{status.name}</label>
                        </span>
                      </li>
                      )
                    }.bind(this)):
                    <div className="fetching">
                      <div className="fetching-content">
                        <div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item">
                      </div>
                    </div>
                    </div>
                    }
                  </ul>
                </div>
              </div>
              <div className="filter-wrapper">
                <div className="title">Customers</div>
                <div className="actions">
                  <ul className="order_status_filter">
                    {this.props.customers.length > 0 ? this.props.customers.map(function(customer, i){
                      return(
                      <li id={customer.id_group} className={this.state.selectedCustomer == customer.id_group ? "active": ""} key={status.id_order_state} >
                        <span>
                          <input type="checkbox" id={"company_"+customer.id_group} checked={this.state.selectedCustomer==customer.id_group}/>
                          <label htmlFor={"company_"+customer.id_group} onClick={this.selectStatus.bind(this, 2, customer.id_group, customer.company)}>{customer.company}</label>
                        </span>
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
              </div>
            </div>
            <div className="order-list-wrapper">
            <div className="filters">
                    {this.state.selectedStatus ? <div className="filter-detail">{this.state.selectedStatusName} <i className="icon-close" onClick={this.selectStatus.bind(this, 1, 0, "")}></i></div> : null}
                    {this.state.selectedCustomer ? <div className="filter-detail">{this.state.selectedCustomerName} <i className="icon-close" onClick={this.selectStatus.bind(this, 2, 0, "")}></i></div> : null}
                    {this.state.fromDate ? <div className="filter-detail">{this.state.fromDate+" - "+this.state.toDate} <i className="icon-close" onClick={this.selectStatus.bind(this, 3, 0, "")}></i></div> : null}
            </div>
              <div className="table-filter">
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
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="div" className="order-list-responsive-wrapper">
                  {this.props.isFetching ? <div><div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div><div></div></div> : 
                    (this.props.orders && this.props.orders.length > 0 ? this.props.orders.map(order => {
                      return (
                        <div key={order.id_order} className="order-detail-container" onClick={this.viewOrder.bind(this, order.id_order)}>
                          <div className="top-section">
                            <div>
                              <p>Order ID</p>
                              <a href="javascript:void(0)" onClick={this.viewOrder.bind(this, order.id_order)}>{order.id_order}</a>
                            </div>
                            <div>
                              <p><strong>{order.company}</strong> </p>
                              <p>{order.email}</p>
                            </div>
                            <div>{G.toPrice(order.total_paid)}</div>
                          </div>
                          <div className="bottom-section">
                            <div>{G.getDate(order.date_add, "lll")}</div>
                            <div className="order-status-wrapper"> <div className="order-status" style={{backgroundColor: order.color}}></div><span>{order.name}</span></div>
                          </div>
                        </div> 
                      );
                    }) : <div className="no-results-wrapper"><div><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>Please check with your customers</p></div></div></div>)
                  }
              </ReactCSSTransitionGroup>
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
