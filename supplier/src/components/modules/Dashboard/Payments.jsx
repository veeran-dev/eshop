import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as G from '../../../api/common-api'
class Quotation extends React.Component {

  toRedirect(){
    this.props.redirect("/orders");
  }

  render() {
    return  (
        <div className="widget-sm">
          <div className="widget-wrapper">
            <div className="widget-box">
              <i className="icon-credit-card green"></i>
              <h3>Payments</h3>            </div>
            <div className="widget-box">
              <div className="widget-box" onClick={this.toRedirect.bind(this)}>
                <div><h3>{G.toPrice(this.props.data.pending)}</h3></div>
                <div>Over Due</div>
              </div>
              <div className="widget-box" onClick={this.toRedirect.bind(this)}>
                <div><h3>{G.toPrice(this.props.data.totalDue)}</h3></div>
                <div>Total Receivable</div>
              </div>
            </div>
          </div>
        </div>
    )
  }
}
const mapStateToProps = function({orderState}) {
  return {
    isFetching: orderState.isFetchingHistory
  }
}

export default connect(mapStateToProps)(Quotation)