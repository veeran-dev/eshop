import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as dashboardApi from '../../../api/dashboard-api'
import * as addressApi from '../../../api/address-api'
import * as orderApi from '../../../api/orders-api'
import * as cartApi from '../../../api/cart-api'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import RejectOrder from '../../common/rejectOrder'
import ApprovalPaymentOptions from '../../common/approvalPaymentOption'

class Approvals extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      idPage: 0,
      epayLater: false,
      epayLaterOrderId: "",
      reject: false,
      id_order: 0,
    }

    this.rejectOrder = this.rejectOrder.bind(this);
  }

  componentDidMount() {
  	dashboardApi.getApprovals(this.props.parentState.limit, this.props.parentState.offset, "", "", this.props.parentState.duration, this.state.idPage)
    window.addEventListener("click", this.outerControl.bind(this));
    //addressApi.checkEpayEligibility(this)
  }

  handlePaginationCard(idPage, totalPage, type){
    let fromDate = "", toDate = ""
    let pageID = G.getPageID(idPage, totalPage, type)

    if(document.getElementById('from-date').value != "" && document.getElementById('to-date').value != ""){
      fromDate = G.getDate(document.getElementById('from-date-hidden').value, "dd-mm-yyyy");
      toDate = G.getDate(document.getElementById('to-date-hidden').value  , "dd-mm-yyyy");
    }

    dashboardApi.getApprovals(4, this.props.parentState.offset, fromDate, toDate, this.props.parentState.duration, pageID)
    this.setState({ idPage: pageID })
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

  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
  }

  rejectOrder(){
    if(G.rejectOrder(this.state.id_order, true)) {
      this.setState({ reject: false })
    }
  }
  
  viewOrder(id_order){
    console.log()
    this.props.viewOrder('/orders/'+id_order);
  }

  render() {

    const {epayLater, epayLaterOrderId} = this.state
    
    return 	( 
      <div className="widget approvals">
          <div className="widget-header">
            <h3>Approvals</h3>
            <button className="close" onClick={G.uninstallWidget.bind(this, this.props.widgetId)}><i className="icon-close"></i></button>
          </div>
    			<table className="widget-compressed-table">
    				<thead>
            <tr>
    					<th>Order ID</th>
    					<th>Name</th>
    					<th>Date</th>
    					<th>Action</th>
              </tr>
    				</thead>
            <tbody>
    					{this.props.isFetching ? <tr><td className="fetching small" colSpan="4"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                (this.props.approvals && this.props.approvals.length > 0 ? this.props.approvals.map((data, i, index) => {
      						return(
      							<tr key={i}>
  		    						<td data-title="Order ID"><a href="javascript:void(0)" onClick={this.viewOrder.bind(this, data.id_order)}>{data.id_order}</a></td>
  		    						<td className="shrinked-name" data-title="Name" title={data.firstname}><span>{data.firstname}</span></td>
  		    						<td data-title="Date">{data.date_add}</td>
  		    						<td data-title="Actions">
                        <div className="split-button">
                          <div className={"split-button-default-action"}>
                            <button onClick={G.getPaymentOption.bind(this, data.id_order, 1, this.context.router, epayLater, epayLaterOrderId)}>Approve</button>
                            <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                            <ul className={"split-button-dropdown hidden"}>
                              { /** <li onClick={G.reviseOrder.bind(this, data.id_order, 0, this.context.router)}>Revise</li> **/ }
                              <li onClick={() => this.setState({ reject: true, id_order: data.id_order })}>Reject</li>
                            </ul>
                          </div>
                        </div>
                      </td>
  	    						</tr>
  		    				)
      					}): <tr className="no-results-wrapper"><td colSpan="4"><div className="no-results small"><h2>No Pending Approvals Found!</h2><p>Approvals have all been cleared by you. Great work.</p></div></td></tr>)}
    				</tbody>
    			</table>

          <div className="pagination-small">
            <a className={"previous"+ (this.state.idPage > 0 ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 1)}><i className="icon-arrow-left"></i> <span>Previous Card</span></a>
            <a className={"next"+ (this.state.idPage < (this.props.pageCount-1) ? "" : " disabled")} href="javascript:void(0);" onClick={this.handlePaginationCard.bind(this, this.state.idPage, this.props.pageCount, 2)}> Next Card <i className="icon-arrow-right"></i></a>
          </div>

          {this.state.reject && <RejectOrder onClick={this.rejectOrder} onClose={() => this.setState({ reject: false })}/>}
    	</div>
    )
  }
}

Approvals.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	approvals: store.dashboardState.homeApprovals,
    cart: store.cartState.cart,
    pageCount: store.dashboardState.approvalsCount,
    isFetching: store.dashboardState.isFetchingApprovals
  }
}

export default connect(mapStateToProps)(Approvals);