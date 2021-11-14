import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as dashboardApi from '../../../api/dashboard-api'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import moment from 'moment'
import { Link } from 'react-router';

class ViewPo extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      idPage: 0
    }
  }

  componentDidMount() {
    dashboardApi.getPoViews(this.props.parentState.limit, this.props.parentState.offset, "", "", this.props.parentState.duration, this.state.idPage);
  }

  handlePaginationCard(idPage, totalPage, type){
    let fromDate = "", toDate = ""
    let pageID = G.getPageID(idPage, totalPage, type)
    
    if(document.getElementById('from-date').value != "" && document.getElementById('to-date').value != ""){
      fromDate = G.getDate(document.getElementById('from-date-hidden').value, "dd-mm-yyyy");
      toDate = G.getDate(document.getElementById('to-date-hidden').value, "dd-mm-yyyy");
    }

    dashboardApi.getPoViews(4, this.props.parentState.offset, fromDate, toDate, this.props.parentState.duration, pageID);

    this.setState({ idPage: pageID })
  }

  render() {
    return 	(
        <div className="widget spend-control-widget">
            <div className="widget-header">
              <h3>Purchase Orders</h3>
              {!(role == 1) ? 
                <Link to="budget-configuration" className="widget-cta">
                  + ADD NEW PO
                </Link> 
              : null}

              <div className="action">
                <i className="icon-settings cursor-pointer" onClick={() => this.context.router.push('settings/budget/purchase-orders')}></i>
                <i className="icon-close cursor-pointer" onClick={G.uninstallWidget.bind(this, this.props.widgetId)}></i>
              </div>
            </div>
            <table className="widget-compressed-table">
              <thead>
                <tr>
                  <th>PO Number</th>
                  <th>PO Date</th>
                  <th>Spend</th>
                  <th>Validity</th>
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

ViewPo.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    poViewsDashboard: store.dashboardState.poViewsDashboard,
    pageCount: store.dashboardState.poViewsCount,
    isFetching: store.dashboardState.isFetchingPoDashboard
  }
}

export default connect(mapStateToProps)(ViewPo)