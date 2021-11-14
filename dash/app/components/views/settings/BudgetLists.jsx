import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as dashboardApi from '../../../api/dashboard-api'
import * as addressApi from '../../../api/address-api'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import moment from 'moment'
import { Link } from 'react-router';
import Ripples from 'react-ripples'

class BudgetLists extends Component {
	constructor(props){
		super(props)
		this.state = {
		  idPage: 0,
		  limit: 10,
		  offset: 0,
		  duration: '',
		  idPage: 0
		}
	}

	componentDidMount() {
		dashboardApi.getPoViews(this.state.limit, this.state.offset, "", "", this.state.duration, this.state.idPage);
	}

	handlePaginationCard(idPage, totalPage, type){
		let fromDate = "", toDate = ""
		let pageID = G.getPageID(idPage, totalPage, type)

		this.setState({ idPage: pageID }, () => {
			dashboardApi.getPoViews(this.state.limit, this.state.offset, fromDate, toDate, this.state.duration, this.state.idPage);
		})
	}

	handleAction = (id_purchase_order, type) => {
		addressApi.activatePurchaseOrder(id_purchase_order, type).then(data => {
			if(data.proceed == 1) {
				dashboardApi.getPoViews(this.state.limit, this.state.offset, "", "", this.state.duration, this.state.idPage);
			}
		});
	}

	render() {
		return 	(
		    <div className="widget">
		        <div className="widget-header">
		          <h3>Purchase Orders</h3>
		          {!(role == 1) ? 
		            <Link to="budget-configuration" className="widget-cta">
		              + ADD NEW PO
		            </Link> 
		          : null}
		        </div>
		        <table className="widget-compressed-table">
		          <thead>
		            <tr>
		              <th>PO Number</th>
		              <th>PO Date</th>
		              <th>Spend</th>
		              <th>Validity</th>
		              <th>Actions</th>
		            </tr>
		          </thead>
		          <tbody>
		            {this.props.poViewsDashboard && this.props.poViewsDashboard.length ? this.props.poViewsDashboard.map((po, i) => {
		              return(
		                <tr key={i}>
		                  <td data-title="PO Number"><a className="blue-color-text" href="javascript:void(0)" onClick={G.viewPoDetail.bind(this, po.id_purchase_order)}>{po.po_number}</a></td>
		                  <td data-title="PO Date"><a className="blue-color-text" href="javascript:void(0)" onClick={G.viewPoDetail.bind(this, po.id_purchase_order)}>{moment(po.po_date).format("LL")}</a></td>
		                  <td data-title="Spend">
		                    <div className="spend-bar">
		                      <div className="spend-progressed" style={{"width": po.po_consumption+"%"}}>
		                      </div>
		                    </div>
		                  </td>   
		                  <td data-title="Validity"><a className="blue-color-text" href="javascript:void(0)" onClick={G.viewPoDetail.bind(this, po.id_purchase_order)}>{moment(po.po_validity).isValid() ? moment(po.po_validity).format("LL") : po.po_validity }</a></td>    
		                  <td data-title="Actions">
							{/*{po.active == 1 && po.po_validity != 'Expired' && <Ripples><button className="button-red" onClick={this.handleAction.bind(this, po.id_purchase_order, 2)}>Deactivate</button></Ripples>}
							{po.active == 0 && po.po_validity != 'Expired' && <Ripples><button className="button-green" onClick={this.handleAction.bind(this, po.id_purchase_order, 1)}>Activate</button></Ripples>} */}
							<Ripples><button className={`${cookiePO == po.id_purchase_order ? 'disabled' : ''} button-blue outline`} onClick={this.handleAction.bind(this, po.id_purchase_order, 3)}>Delete</button></Ripples>
		                  </td>
		                </tr>
		              )
		            }) : <tr className="no-results-wrapper">
                      <td colSpan="4">
                        <div className="no-results small"><h2>Purchase order not configured or expired.<br />Please {!(role == 1) ? 'click ADD NEW PO' : 'ask your approver'} to configure new PO.</h2></div>
                      </td>
                    </tr>}
		          </tbody>
		        </table>
		        <div className="pagination-small">
		          <a className={"previous"+ (this.state.idPage > 0 ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 1)}><i className="icon-arrow-left"></i> <span>Previous Card</span></a> 
		          <a className={"next"+ (this.state.idPage < (this.props.pageCount-1) ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 2)}> Next Card <i className="icon-arrow-right"></i></a>
		        </div>
		    </div>
		)
	}
}

BudgetLists.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    poViewsDashboard: store.dashboardState.poViewsDashboard,
    pageCount: store.dashboardState.poViewsCount,
    isFetching: store.dashboardState.isFetchingPoDashboard
  }
}

export default connect(mapStateToProps)(BudgetLists)