import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import ReactTooltip from 'react-tooltip'

class ActiveCustomer extends React.Component {
  render() {
    let x 
    return  (
        <div className="widget-sm">
          <div className="widget-wrapper">
            <div className="widget-box">
              <i className="icon-round-account blue"></i>
            </div>
            <div className="widget-box">
                <div>
                  <h3>Active Customer</h3>
                  <p>{Object.keys(this.props.data).length > 0 ? this.props.data.activeCustomerCurrentMonth[0]['total_cus'] : 0}</p>
                </div>
            </div>
            <div className="widget-box" >
                <i
                  data-tip={Object.keys(this.props.data).length > 0 ? "Last Month Active Customer: "+this.props.data.activeCustomerPreviousMonth[0]['total_cus']:""} 
                  className={Object.keys(this.props.data).length > 0 && this.props.data.activeCustomerCurrentMonth[0]['total_cus'] == this.props.data.activeCustomerPreviousMonth[0]['total_cus'] ? "icon-info":
                            (Object.keys(this.props.data).length > 0 && this.props.data.activeCustomerCurrentMonth[0]['total_cus'] < this.props.data.activeCustomerPreviousMonth[0]['total_cus'] ? "icon-trending_down":"icon-trending_down invert")}></i>
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

export default connect(mapStateToProps)(ActiveCustomer)