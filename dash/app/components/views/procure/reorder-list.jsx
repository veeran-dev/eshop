import React from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router';
import { connect } from 'react-redux';
import * as orderApi from '../../../api/orders-api';
import * as G from '../../../api/common-api';
import ReactPaginate from 'react-paginate';
import store from '../../../store/configureStore';
import DisplayModel from '../../common/Modal';
import MydateFilter from '../../common/datepicker';
import Ripples from 'react-ripples';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';

class ReorderList extends React.Component {
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
		this.props.history.push('/orders/'+id_order);
	}


    render() {
    	const { limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, updatePagination  } = this.state
        return (
        	<div className="page-container">
        		<div className="table-filter">
	                <div className="page-filter">
	                  <div className="duration-filter">
	                    <MydateFilter ref="datePicker" changeRequested={true} onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, "", 0, orderBy, orderWay, q, false, true)}/>
	                  </div>
	                  <div className="reset-button">
	                    <Ripples><button onClick={this.getOrders.bind(this, 10, 0, "", "", 5, "", "o.`id_order`", "DESC", "", true, true, null)}><i className="icon-refresh"></i><span>Reset</span></button></Ripples>
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
	                    clickCallback={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, idPage, orderBy, orderWay, q, false, false)}
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
									<div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'DESC', q, false, true, null)}></div>
									<div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`id_order`', 'ASC', q, false, true, null)}></div>
								</div>
				            </th>
				            <th>
			            	Ordered On
								<div className="sorting">
			            			<div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'DESC', q, false, true, null)}></div>
            						<div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`date_add`', 'ASC', q, false, true, null)}></div>
								</div>
				            </th>
				            <th>
			            	Supplier
								<div className="sorting">
			            			<div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'supplier_name', 'DESC', q, false, true, null)}></div>
            						<div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'supplier_name', 'ASC', q, false, true, null)}></div>
								</div>
				            </th>
				            <th>
				            	Total Price
											<div className="sorting">
				            		<div className="sorting-icon sort-up" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`total_paid`', 'DESC', q, false, true, null)}></div>
                				<div className="sorting-icon sort-down" onClick={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, 'o.`total_paid`', 'ASC', q, false, true, null)}></div>
											</div>
				            </th>
				            <th>
	                   	<input ref="searchQuery" type="text" placeholder="Search" onChange={this.getOrders.bind(this, limit, offset, fromDate, toDate, duration, 0, orderBy, orderWay, q, false, true, null)}/>	
				            </th>
				        </tr>
				    </thead>
				    <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
				        {this.props.isFetching ? <tr><td className="fetching" colSpan="4"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
					        (this.props.reorderList && this.props.reorderList.length > 0 ? this.props.reorderList.map(order => {
					        	return (
							        <tr key={order.id_order}>
							            <td data-title="Order ID"><a href="javascript:void(0)" onClick={this.view.bind(this, order.id_order)}>{order.id_order}</a></td>
							            <td data-title="Ordered On">{order.date_add != null ? order.date_add : "Not Available"}</td>
							            <td data-title="Supplier">{order.supplier_name}</td>
							     		<td data-title="Total Price" className="red-color-text">{G.formatPrice(order.total_paid)}</td>
							            <td data-title="Actions">
							            	<div>
								            	<button className="button-blue outline" onClick={this.view.bind(this, order.id_order)}>View Order</button>
								            	<button className={`button-blue`} style={{ color: '#fff' }} onClick={G.reOrderView.bind(this, order.id_order, this.props.cart, this.context.router)}>Reorder</button>
								            </div>
							            </td>
							        </tr>
					         	);
			      			}): <tr className="no-results-wrapper"><td colSpan="5"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>What keeps you waiting? Just click <Link to="procure">Buy Now!</Link></p></div></td></tr>)
                  		}
				    </ReactCSSTransitionGroup>
				</table>
		    </div>
    	)
  }
}

ReorderList.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	reorderList: store.orderState.orders,
  	orderCount: store.orderState.orderCount,
    cart: store.cartState.cart,
    isFetching: store.orderState.isFetchingOrders
  };
};

export default connect(mapStateToProps)(ReorderList)