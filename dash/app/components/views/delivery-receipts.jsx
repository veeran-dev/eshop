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

class DeliveryReceipts extends React.Component {
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
    this.getDRs(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
  }

  getDRs(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset, updatePagination, dynamicObject){

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

    invoiceApi.getDRs(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q);
    
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
                    <MydateFilter changeRequested={true} ref="datePicker" onChange={this.getDRs.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                  </div>
                  <div className="reset-button">
                    <Ripples><button onClick={this.getDRs.bind(this, 10, 0, "", "", 5, "", "o.`id_order`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                  </div>

                  <div className="default-duration-filter">
                    <Ripples className="button-group-item"><button className={duration == 1 ? "active" : ""} onClick={this.getDRs.bind(this, limit, offset, "", "", 1, 0, orderBy, orderWay, q, false, true, null)}>Now</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 2 ? "active" : ""} onClick={this.getDRs.bind(this, limit, offset, "", "", 2, 0, orderBy, orderWay, q, false, true, null)}>Day</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 3 ? "active" : ""} onClick={this.getDRs.bind(this, limit, offset, "", "", 3, 0, orderBy, orderWay, q, false, true, null)}>Week</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 4 ? "active" : ""} onClick={this.getDRs.bind(this, limit, offset, "", "", 4, 0, orderBy, orderWay, q, false, true, null)}>Month</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 5 ? "active" : ""} onClick={this.getDRs.bind(this, limit, offset, "", "", 5, 0, orderBy, orderWay, q, false, true, null)}>All Time</button></Ripples>
                  </div>
                </div>

                <div className="pagination-container">
                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" onChange={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}>
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
                    pageNum={parseInt(this.props.deliveryCount)}
                    marginPagesDisplayed={0}
                    pageRangeDisplayed={0}
                    totalRecordsDisplay={true}
                    shouldUpdate={updatePagination}
                    clickCallback={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
                    containerClassName={"pagination"}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"} />
                </div>
            </div>
            <table className="delivery-receipts">
              <thead>
                  <tr>
                      <th className="text-align-right">Order ID 
                        <div className="sorting">
                          <div className="sorting-icon sort-up" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'DESC', q, false, true, null)}></div>
                          <div className="sorting-icon sort-down" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'ASC', q, false, true, null)}></div>
                        </div>
                      </th>
                      <th className="text-align-center">Delivery Receipt ID
                        <div className="sorting">
                          <div className="sorting-icon sort-up" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'd.`delivery_number`', 'DESC', q, false, true, null)}></div>
                          <div className="sorting-icon sort-down" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'd.`delivery_number`', 'ASC', q, false, true, null)}></div>
                        </div>
                      </th>
                      <th className="text-align-right">Ordered On
                        <div className="sorting">
                          <div className="sorting-icon sort-up" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'DESC', q, false, true, null)}></div>
                          <div className="sorting-icon sort-down" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'ASC', q, false, true, null)}></div>
                        </div>
                      </th>
                      <th className="text-align-left">Delivery Status
                        <div className="sorting">
                          <div className="sorting-icon sort-up" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'osl.`name`', 'DESC', q, false, true, null)}></div>
                          <div className="sorting-icon sort-down" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'osl.`name`', 'ASC', q, false, true, null)}></div>
                        </div>
                      </th>
                      <th className="text-align-right">Delivery Date
                        <div className="sorting">
                          <div className="sorting-icon sort-up" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`delivery_date`', 'DESC', q, false, true, null)}></div>
                          <div className="sorting-icon sort-down" onClick={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`delivery_date`', 'ASC', q, false, true, null)}></div>
                        </div>
                      </th>
                      <th>
                        <input ref="searchQuery" type="text" placeholder="Search" onChange={this.getDRs.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}/>
                      </th>
                  </tr>
              </thead>
              <tbody>
                {this.props.isFetching ? <tr><td className="fetching" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                  (this.props.deliveryReceipts && this.props.deliveryReceipts.length > 0 ? this.props.deliveryReceipts.map((data, i) => {
                    return (
                      <tr key={i}>
                          <td data-title="Order ID" className="blue-color-text text-align-right">
                            <a href="javascript:void(0)" onClick={G.viewOrderDetail.bind(this, data.id_order, data.id_address_delivery, data.id_address_invoice)}>
                              {data.id_order}
                            </a>
                          </td>
                          <td data-title="DR ID" className="text-align-center">{data.delivery_number}</td>
                          <td className="text-align-right" data-title="Ordered On">{data.added_date}</td>
                          <td className="text-align-left" data-title="Total Price">{data.status}</td>
                          <td className="text-align-right" data-title="Invoice Date">{data.delivery_date}</td>
                          <td data-title="Actions">
                            <a className="button button-blue outline" download target="_blank" href={baseDir+"index.php?controller=pdf-invoice&id_par_delivery="+data.id_delivery}>
                                <i className="icon-download"></i>Download DR
                            </a>
                            {data.dr_file_name ? <a className="button button-blue outline" download target="_blank" href={baseDir+"scanedDRs/"+data.dr_file_name}>
                                <i className="icon-download"></i>Download ACK Copy
                            </a> : <span className="disabled">ACK Copy not available</span> }
                          </td>
                      </tr>
                    );
                  }) : <tr className="no-results-wrapper"><td colSpan="6"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Delivery Receipts to Show!</h2><p>The delivery is on its pace along with your DR!</p></div></td></tr>)}
              </tbody>
            </table>
          </div>
        </div>
    );
  }
}

DeliveryReceipts.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    deliveryReceipts: store.invoiceState.deliveryReceipts,
    deliveryCount: store.invoiceState.deliveryCount,
    cart: store.cartState.cart,
    isFetching: store.invoiceState.isFetchingDrs
  };
};

export default connect(mapStateToProps)(DeliveryReceipts);
