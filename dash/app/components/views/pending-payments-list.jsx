import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import * as pendingpaymentApi from '../../api/pending-payment-api';
import * as G from '../../api/common-api';
import {toastr} from 'react-redux-toastr';
import store from '../../store/configureStore';
import ReactPaginate from 'react-paginate';
import DayPicker from 'react-day-picker';
import MydateFilter from '../common/datepicker';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group'

// Using "Stateless Functional Components"
class pendingPaymentsList extends React.Component {
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
      updatePagination: false,
      selectedStatus:[],
      filter: false
    }
  }
 
  componentDidMount() {
    this.getPaymentPendings(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
    window.addEventListener("click", this.outerControl.bind(this));
    window.addEventListener("click", this.closeFilter.bind(this));
  }

  getPaymentPendings(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset, updatePagination, dynamicObject){

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
    var status="";
    if(this.state.selectedStatus.length >0){
      status = this.state.selectedStatus.toString();
    }

    pendingpaymentApi.getPaymentPendings(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, status);
    // this.setState({filter: false});
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

  _splitButton(e) {

      let allElem = document.getElementsByClassName('split-button-dropdown')
      if(e.target.nextSibling.classList.contains("hidden")){
        for(var i = 0; i < allElem.length; i++){
            allElem[i].classList.add("hidden")
            e.target.nextSibling.classList.remove("hidden")
        }
      }
      else{
        e.target.nextSibling.classList.add("hidden")
        for(var i = 0; i < allElem.length; i++)
            allElem[i].classList.add("hidden")
      }
  }

    outerControl(event){
      var allElem = document.getElementsByClassName('split-button-dropdown');
      for(var i=0; i < allElem.length; i++){
          let box = allElem[i]
          if(event.target != box && event.target.parentNode != box){
            if(box && box.style.display != undefined)
              if(!box.classList.contains("hidden") && !event.target.classList.contains("split-button-arrow"))
                box.className += " hidden"
          }
      }
    }

    closeFilter(event){
      if(event.target.className.split(" ")[0] != 'button-blue' && event.target.className.split(" ")[0] != 'filter-li' && event.target.className.split(" ")[0] != 'icon-filter' && event.target.className.split(" ")[0] != 'filter' && event.target.className.split(" ")[0] != 'icon-check-box'){
        this.setState({filter: false});
      }
    }

  downloadExcel(){
    if(this.props.pendingpayments && this.props.pendingpayments.length > 0) {
     window.open("dash-pending-payments-report.php?id_customer="+id_customer);
    }
    else {
      toastr.error("Error", "No data found.", {icon: "icon-error"})
    }
  }

  downloadFiles(url){
    
    window.open(url);
  }
  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
    window.removeEventListener("click", this.closeFilter.bind(this));
  }


  filter(){
    this.setState({filter: !this.state.filter});
  }

  active(){
    if(this.state.filter==false){
      return "";
    }
    else{
      return "show";
    }
  }

  activeFilter(){
    if(this.state.filter==false){
      return "";
    }
    else{
      return "on";
    }
  }
  addToList(element){
    var parent = element.target;
    var value = element.target.getAttribute("id");
    if(this.state.selectedStatus.indexOf(value) == -1){
        var arr = this.state.selectedStatus;
        arr.push(value);
        this.setState({selectedStatus: arr})
    }
    else{
      var arr = this.state.selectedStatus;
      var position = arr.indexOf(value);
      arr.splice(position, 1);
        this.setState({selectedStatus: arr});
    }
    document.getElementById('filter').click();
    
  }
  checkList(id_value){
    if(this.state.selectedStatus.indexOf(id_value) == -1){
        return "icon-check-box-outline";
    }
    else{
      return "icon-check-box";
    }
  }
  render(){
    const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination  } = this.state
    var status_text = "";
    var status_icon = 0;
    var invoice_age = 0;
    var invoice_due_date = 0;

    return (
        <div>
          <div className="page-container pending-payments">
            <div className="table-filter">
                <div className="page-filter">
                  <div className="duration-filter">
                    <MydateFilter changeRequested={true} ref="datePicker" onChange={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
                  </div>
                  <div className="reset-button">
                    <Ripples><button onClick={this.getPaymentPendings.bind(this, 10, 0, "", "", 5, "", "o.`id_order`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
                  </div>

                  <div className="default-duration-filter">
                    <Ripples className="button-group-item"><button className={duration == 1 ? "active" : ""} onClick={this.getPaymentPendings.bind(this, limit, offset, "", "", 1, 0, orderBy, orderWay, q, false, true, null)}>Now</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 2 ? "active" : ""} onClick={this.getPaymentPendings.bind(this, limit, offset, "", "", 2, 0, orderBy, orderWay, q, false, true, null)}>Day</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 3 ? "active" : ""} onClick={this.getPaymentPendings.bind(this, limit, offset, "", "", 3, 0, orderBy, orderWay, q, false, true, null)}>Week</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 4 ? "active" : ""} onClick={this.getPaymentPendings.bind(this, limit, offset, "", "", 4, 0, orderBy, orderWay, q, false, true, null)}>Month</button></Ripples>
                    <Ripples className="button-group-item"><button className={duration == 5 ? "active" : ""} onClick={this.getPaymentPendings.bind(this, limit, offset, "", "", 5, 0, orderBy, orderWay, q, false, true, null)}>All Time</button></Ripples>
                  </div>
                </div>
                <div className="action-block">
                    <div className="tooltip">
                      <Ripples>
                          <button className="button" onClick={this.downloadExcel.bind(this)}><span><i className="icon-cloud-download"></i></span></button> 
                      </Ripples>
                      <span className="tooltiptext tooltip-bottom gray-color-text">Export as Excel</span>
                    </div>
                </div>
                <div className="pagination-container">
                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" onChange={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}>
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
                    clickCallback={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
                    containerClassName={"pagination"}
                    subContainerClassName={"pages pagination"}
                    activeClassName={"active"} />
                </div>
            </div>
            <table>
              <thead>
                  <tr>
                      <th className="text-align-left">Invoice ID
                      <div className="sorting">
                          <div className="sorting-icon sort-up" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_number`', 'DESC', q, false, true, null)}></div>
                          <div className="sorting-icon sort-down" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_number`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-center">Invoice Date
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_date`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`invoice_date`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-right">Invoice Value
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`total_paid_tax_incl`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`total_paid_tax_incl`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-right">Due Date
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'due_date', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'due_date', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-left invoice_status">
                      <div>
                        Invoice Status
                        <i className={"icon-filter "+ this.activeFilter()} onClick={this.filter.bind(this)}></i>
                        <ul id="filter-box" className={"filter "+this.active()}>
                          {this.props.invoice_status.length>0 ? this.props.invoice_status.map(status =>{
                            return (<li className="filter-li" key={status.id_order_state} id={status.id_order_state} onClick={this.addToList.bind(this)} ><i id={status.id_order_state} className={this.checkList(status.id_order_state)}></i> {status.name}</li>);
                          }) : '' }
                          <button onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'DESC', q, false, true, null)} className="button-blue button-small hidden" id="filter">Filter</button>
                          {/*<button onClick={this.filterReset.bind(this)} className="button button-small">Reset</button>*/}                          
                        </ul>
                      </div>
                      </th>
                      <th className="text-align-left">Order ID
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th className="text-align-right">Outstanding
                      <div className="sorting">
                        <div className="sorting-icon sort-up" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'outstanding', 'DESC', q, false, true, null)}></div>
                        <div className="sorting-icon sort-down" onClick={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, 'outstanding', 'ASC', q, false, true, null)}></div>
                      </div>
                      </th>
                      <th>
                        <input ref="searchQuery" type="text" placeholder="Search" onChange={this.getPaymentPendings.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}/>    
                      </th>
                  </tr>
              </thead>
              <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                  {this.props.isFetching ? <tr><td className="fetching" colSpan="8"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (this.props.pendingpayments.length > 0 ? this.props.pendingpayments.map(pendingpayments => {
                      if(pendingpayments.credit_days-pendingpayments.age <= 0){
                        status_text = "red-color-text";
                        status_icon=1;
                        invoice_age=0;
                      }
                      else if(pendingpayments.credit_days-pendingpayments.age <= 2){
                        status_text = "orange-color-text";
                        status_icon=0;
                        invoice_age = pendingpayments.credit_days-pendingpayments.age;
                      }
                      else{
                        status_text = "green-color-text";
                        status_icon=0;
                        invoice_age = pendingpayments.credit_days-pendingpayments.age;
                      }

                      if(pendingpayments.id_order_state != 6 && pendingpayments.id_order_state != 36 && pendingpayments.id_order_state != 38){
                        invoice_due_date = pendingpayments.due_date
                        invoice_due_date += invoice_age !=0 ? "("+invoice_age+" days)" : "" ;
                      }
                      else if(pendingpayments.id_order_state == 6){
                        status_text = "";
                        status_icon = 0;
                        invoice_due_date = "Not Applicable";
                      }
                      else{
                        status_text = "green-color-text";
                        status_icon = 0;
                        invoice_due_date = "Paid";
                      }

                      return (
                        <tr key={pendingpayments.order_number}>
                            <td data-title="Invoice Number" className="text-align-left">{"#"+G.padDigits(pendingpayments.invoice_number, 6)}</td>
                            <td data-title="Date" className="text-align-center">{pendingpayments.invoice_date}</td>
                            <td className="text-align-right" data-title="Value">{G.formatPrice(pendingpayments.invoice_value)}</td>
                            <td className={"text-align-right "+status_text} data-title="Due Date">
                              {invoice_due_date}{status_icon == 1 ? <i className='icon-warning'></i> :"" }
                            </td>
                            <td className="text-align-left" data-title="Status">{pendingpayments.invoice_status}</td>
                            <td className="text-align-left" data-title="Order">
                              <a href="javascript:void(0)" onClick={G.viewOrderDetail.bind(this, pendingpayments.id_order, pendingpayments.id_address_delivery, pendingpayments.id_address_invoice)}>
                                {pendingpayments.id_order}
                              </a>
                            </td>
                            <td className="text-align-right" data-title="Oustanding">{G.formatPrice(pendingpayments.outstanding)}</td>
                            <td data-title="Actions">
                              <div className="split-button">
                                <div className={"split-button-default-action"}>
                                  <button >Documents</button>
                                  <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                                  <ul className={"split-button-dropdown hidden"}>
                                    <li>
                                      <a className="button button-blue outline" href='javascript:void(0)' onClick={this.downloadFiles.bind(this,baseDir+"index.php?controller=pdf-invoice&id_order="+pendingpayments.order_number)}>
                                          <i className="icon-download"></i> {pendingpayments.invoice_number}
                                      </a>
                                    </li>
                                    
                                    {pendingpayments.invoice_ack ?
                                      <li>
                                      <a className="button button-blue outline" href={baseDir+pendingpayments.invoice_ack}  download>
                                          <i className="icon-download"></i> {pendingpayments.invoice_number} ACK
                                      </a>
                                    </li>:""} 

                                    <li>
                                      <a className="button button-blue outline" href='javascript:void(0)' onClick={this.downloadFiles.bind(this,baseDir+"index.php?controller=pdf-invoice&id_par_delivery="+pendingpayments.id_delivery)}>
                                          <i className="icon-download"></i> {pendingpayments.delivery_number}
                                      </a>
                                      
                                    </li>
                                    {pendingpayments.dr_file && pendingpayments.dr_file.length>0 ?
                                        pendingpayments.dr_file.map(fileName=>{
                                          return (<li>
                                            <a className="button button-blue outline" href={baseDir+""+fileName} download>
                                                <i className="icon-download"></i> {pendingpayments.delivery_number} ACK
                                            </a>
                                          </li>   ) 
                                        })
                                    :""} 
                                  </ul>
                                </div>
                              </div>
                            </td>
                        </tr>
                      );
                    }) : <tr className="no-results-wrapper"><td colSpan="8"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Pending Payments to Show!</h2><p>We are waiting to generate invoices for you. Place orders NOW!</p></div></td></tr>)}
              </ReactCSSTransitionGroup>
            </table>
          </div>
        </div>
    );
  }
}


pendingPaymentsList.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    pendingpayments: store.pendingPaymentState.pendingpayments,
    count: store.pendingPaymentState.count,
    invoice_status: store.pendingPaymentState.invoice_status,
    cart: store.cartState.cart,
    isFetching: store.pendingPaymentState.isFetchingPendingPayments
  };
};

export default connect(mapStateToProps)(pendingPaymentsList);