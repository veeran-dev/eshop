import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import * as invoiceApi from '../../api/invoice-api';
import * as G from '../../api/common-api';
import {toastr} from 'react-redux-toastr';
import store from '../../store/configureStore';
import ReactPaginate from 'react-paginate';
import DayPicker from 'react-day-picker';
import MydateFilter from '../common/datepicker';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group'

// Using "Stateless Functional Components"
class InvoiceList extends React.Component {
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
    this.getInvoices(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
  }

  getInvoices(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset, updatePagination, dynamicObject){

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

    invoiceApi.getInvoices(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q);
    
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
          <div className="page-container">
            <div className="table-filter">
                <div className="page-filter">
                  <div className="duration-filter">
                    <MydateFilter changeRequested={true} ref="datePicker" onChange={this.getInvoices.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                  </div>
                  <div className="reset-button">
                    <Ripples><button onClick={this.getInvoices.bind(this, 10, 0, "", "", 5, "", "o.`id_order`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                  </div>

                  <div className="default-duration-filter">
                    <Ripples className="button-group-item"><button className={duration == 1 ? "active" : ""} onClick={this.getInvoices.bind(this, limit, offset, "", "", 1, 0, orderBy, orderWay, q, false, true, null)}>Now</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 2 ? "active" : ""} onClick={this.getInvoices.bind(this, limit, offset, "", "", 2, 0, orderBy, orderWay, q, false, true, null)}>Day</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 3 ? "active" : ""} onClick={this.getInvoices.bind(this, limit, offset, "", "", 3, 0, orderBy, orderWay, q, false, true, null)}>Week</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 4 ? "active" : ""} onClick={this.getInvoices.bind(this, limit, offset, "", "", 4, 0, orderBy, orderWay, q, false, true, null)}>Month</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 5 ? "active" : ""} onClick={this.getInvoices.bind(this, limit, offset, "", "", 5, 0, orderBy, orderWay, q, false, true, null)}>All Time</button></Ripples>
                  </div>
                </div>

                <div className="pagination-container">
                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" onChange={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}>
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
                    pageNum={parseInt(this.props.count)}
                    marginPagesDisplayed={0}
                    pageRangeDisplayed={0}
                    totalRecordsDisplay={true}
                    shouldUpdate={updatePagination}
                    clickCallback={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
                    containerClassName={"pagination"}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"} />
                </div>
            </div>
            <table>
              <thead>
                  <tr>
                      <th className="text-align-right">Order ID
                      <div className="sorting">
                          <div className="sorting-icon sort-up" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'DESC', q, false, true, null)}></div>
                          <div className="sorting-icon sort-down" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-center">Invoice ID
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_number`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_number`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-right">Ordered On
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-right">Total Price
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`total_paid`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`total_paid`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-right">Invoice Date
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_date`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_date`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th>
                        <input ref="searchQuery" type="text" placeholder="Search" onChange={this.getInvoices.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}/>    
                      </th>
                  </tr>
              </thead>
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (this.props.invoices && this.props.invoices.length > 0 ? this.props.invoices.map(invoice => {
                      return (
                        <tr key={invoice.id_order}>
                            <td data-title="Order ID" className="blue-color-text text-align-right">
                              <a href="javascript:void(0)" onClick={G.viewOrderDetail.bind(this, invoice.id_order, invoice.id_address_delivery, invoice.id_address_invoice)}>
                                {invoice.id_order}
                              </a>
                            </td>
                            <td data-title="Invoice ID" className="text-align-center">{"#"+G.padDigits(invoice.invoice_number, 6)}</td>
                            <td className="text-align-right" data-title="Ordered On">{invoice.added_date}</td>
                            <td className="text-align-right" data-title="Total Price">{G.formatPrice(invoice.total_paid)}</td>
                            <td className="text-align-right" data-title="Invoice Date">{invoice.invoice_date}</td>
                            <td data-title="Actions">
                              <a className="button button-blue outline" target="_blank" href={baseDir+"index.php?controller=pdf-invoice&id_order="+invoice.id_order}>
                                  <i className="icon-download"></i>Download Invoice
                              </a>
                            </td>
                        </tr>
                      );
                    }) : <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Invoices to Show!</h2><p>We are waiting to generate invoices for you. Place orders NOW!</p></div></td></tr>)}
              </ReactCSSTransitionGroup>
            </table>
          </div>
        </div>
    );
  }
}

InvoiceList.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    invoices: store.invoiceState.invoices,
    count: store.invoiceState.count,
    cart: store.cartState.cart,
    isFetching: store.invoiceState.isFetchingInvoices
  };
};

export default connect(mapStateToProps)(InvoiceList);
