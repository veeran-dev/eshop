import React from 'react';
import ReactDOM from 'react-dom'
import { Link } from 'react-router';
import { connect } from 'react-redux';
import * as approvalsApi from '../../api/approvals-api';
import * as addressApi from '../../api/address-api';
import * as orderApi from '../../api/orders-api'
import * as cartApi from '../../api/cart-api';
import * as G from '../../api/common-api';
import RejectOrder from '../../components/common/rejectOrder';
import {toastr} from 'react-redux-toastr';
import store from '../../store/configureStore';
import ReactPaginate from 'react-paginate';
import DayPicker from 'react-day-picker';
import MydateFilter from '../common/datepicker';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

// Listing orders for approval purpose
class ApprovalList extends React.Component{
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
	      epayLaterOrderId: "",
	      epayLater: false,
	      reject: false,
	      id_order: 0
	    }

   		this.rejectOrder = this.rejectOrder.bind(this);
	}

	componentDidMount() {
	    this.getApprovals(this.state.limit, this.state.offset, "", "", this.state.duration, "", this.state.orderBy, this.state.orderWay, this.state.q, false, false);
		//addressApi.checkEpayEligibility(this)
	}

	getApprovals(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, reset, updatePagination, dynamicObject){

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

	    approvalsApi.getApprovals(limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q);
	    
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

	rejectOrder(){
		if(G.rejectOrder(this.state.id_order, false)) {
			this.setState({ reject: false })
		}
	}
	view(id_order){
		this.props.history.push('/orders/'+id_order);
	}


  	render(){
    	const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination, epayLater, epayLaterOrderId } = this.state
		return (
		    <div>
				<div className="page-header">
					<h3 className="page-title">Approvals</h3>
					<div className="action-block">
						{/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
					</div>
				</div>

				<div className="page-container">
					<div className="table-filter">
		                <div className="page-filter">
		                  <div className="duration-filter">
		                    <MydateFilter changeRequested={true} ref="datePicker" onChange={this.getApprovals.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
		                  </div>
		                  <div className="reset-button">
		                    <Ripples><button onClick={this.getApprovals.bind(this, 10, 0, "", "", 5, "", "o.`id_order`", "DESC", "", true, true, null)}><i className="icon-refresh"></i> <span>Reset</span></button></Ripples>
		                  </div>

		                  <div className="default-duration-filter">
		                    <Ripples className="button-group-item"><button className={duration == 1 ? "active" : ""} onClick={this.getApprovals.bind(this, limit, offset, "", "", 1, 0, orderBy, orderWay, q, false, true, null)}>Now</button></Ripples>
		                    <Ripples className="button-group-item"><button className={duration == 2 ? "active" : ""} onClick={this.getApprovals.bind(this, limit, offset, "", "", 2, 0, orderBy, orderWay, q, false, true, null)}>Day</button></Ripples>
		                    <Ripples className="button-group-item"><button className={duration == 3 ? "active" : ""} onClick={this.getApprovals.bind(this, limit, offset, "", "", 3, 0, orderBy, orderWay, q, false, true, null)}>Week</button></Ripples>
		                    <Ripples className="button-group-item"><button className={duration == 4 ? "active" : ""} onClick={this.getApprovals.bind(this, limit, offset, "", "", 4, 0, orderBy, orderWay, q, false, true, null)}>Month</button></Ripples>
		                    <Ripples className="button-group-item"><button className={duration == 5 ? "active" : ""} onClick={this.getApprovals.bind(this, limit, offset, "", "", 5, 0, orderBy, orderWay, q, false, true, null)}>All Time</button></Ripples>
		                  </div>
		                </div>

		                <div className="pagination-container">
		                  <select ref="orderPerPage" className="pagination-select" name="orderPerPage" onChange={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}>
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
		                    pageNum={parseInt(this.props.approvalsCount)}
		                    marginPagesDisplayed={0}
		                    pageRangeDisplayed={0}
		                    totalRecordsDisplay={true}
		                    shouldUpdate={updatePagination}
		                    clickCallback={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
		                    containerClassName={"pagination"}
		                    subContainerClassName={"pages pagination"}
		                    activeClassName={"active"} />
		                </div>
		            </div>
					<table>
					    <thead>
					        <tr>
					            <th>Order ID
											<div className="sorting">
					            	<div className="sorting-icon sort-up" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'DESC', q, false, true, null)}></div>
                    		<div className="sorting-icon sort-down" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'ASC', q, false, true, null)}></div>
											</div>
					            </th>
					            <th>Ordered By
											<div className="sorting">
					            	<div className="sorting-icon sort-up" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'cus.`firstname`', 'DESC', q, false, true, null)}></div>
                    		<div className="sorting-icon sort-down" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'cus.`firstname`', 'ASC', q, false, true, null)}></div>
											</div>
					            </th>
					            <th>Ordered On
											<div className="sorting">
					            	<div className="sorting-icon sort-up" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'DESC', q, false, true, null)}></div>
                    		<div className="sorting-icon sort-down" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'ASC', q, false, true, null)}></div>
											</div>
					            </th>
					            <th>Status
											<div className="sorting">
					            	<div className="sorting-icon sort-up" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'osl.`name`', 'DESC', q, false, true, null)}></div>
                    		<div className="sorting-icon sort-down" onClick={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, 'osl.`name`', 'ASC', q, false, true, null)}></div>
											</div>
					            </th>
					            <th>
                    				<input ref="searchQuery" type="text" placeholder="Search" onChange={this.getApprovals.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}/>			            	
					           	</th>
					        </tr>
					    </thead>
					    <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
					       {this.props.isFetching ? <tr><td className="fetching" colSpan="5"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
						        (this.props.approvals && this.props.approvals.length > 0 ? this.props.approvals.map(approval => {
						        	return (
								        <tr key={approval.id_order}>
								            <td data-title="Order ID"><a href="javascript:void(0)" onClick={this.view.bind(this, approval.id_order)}>{approval.id_order}</a></td>
								            <td data-title="Ordered By">{approval.firstname}</td>
								            <td data-title="Ordered On">{approval.date_add}</td>
								            <td data-title="Status">{approval.status}</td>
								            <td data-title="Actions"><div>
									            	<Ripples><button className="button-green" onClick={G.getPaymentOption.bind(this, approval.id_order, null, this.context.router, epayLater, epayLaterOrderId)}>Approve</button></Ripples>
									            	{ /** <Ripples><button className="button-orange" onClick={G.reviseOrder.bind(this, approval.id_order, 0, this.context.router)}>Revise</button></Ripples> **/ }
									            	<Ripples><button className="button-red outline" onClick={() => this.setState({ reject: true, id_order: approval.id_order })}>Reject</button></Ripples>
									            </div>
								            </td>
								        </tr>
						         	)
				      			}): <tr className="no-results-wrapper"><td colSpan="5"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Pending Approvals Found!</h2><p>Approvals have all been cleared by you. Great work.</p></div></td></tr>)
						    }
					    </ReactCSSTransitionGroup>
					</table>
				</div>

				{this.state.reject && <RejectOrder onClick={this.rejectOrder} onClose={() => this.setState({ reject: false })} />}
		    </div>
		)
	}
}

ApprovalList.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    approvals: store.approvalState.approvals,
    cart: store.cartState.cart,
    approvalsCount: store.approvalState.approvalsCount,
    approvalsPageId: store.approvalState.approvalsPageId,
    isFetching: store.approvalState.isFetchingApprovalWidget
  };
};

export default connect(mapStateToProps)(ApprovalList);

