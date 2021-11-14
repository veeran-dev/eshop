import React from 'react'
import { connect } from 'react-redux'
import { Link } from 'react-router';
import * as orderApi from '../../api/orders-api'

class Thankyou extends React.Component {
  render() {
    return (
    	<div className="thank-you">
        <div className="print-animation-container">
          <div className="printer-top"></div>

          <div className="paper-container">
            <div className="printer-bottom"></div>

            <div className="paper">
              <div className="main-contents">
                <div className="success-icon">
                <span>
                  {this.props.orderComplete.isPlaced ? <i className="icon-check"></i> : <i className="icon-hourglass-empty"></i> }
                </span>
                </div>
                <div className="success-title">
                  {this.props.orderComplete.isPlaced ? "Order Placed!" : "Pending Approval"}
                </div>
                <div className="success-description">
                  Your order is successfully placed {this.props.orderComplete.isPlaced ? "." : " & sent for approval."} You can track the status in <Link to="orders">Orders</Link>. You will also be notified when the status changes.
                </div>
                <div className="order-details">
                  <div className="order-number-label">Order ID</div>
                  <div className="order-number">{this.props.params.id}</div>
                </div>
                <div className="order-footer">Thank you!</div>
              </div>
              <div className="jagged-edge"></div>
            </div>
          </div>
        </div>
	    </div>
    )
  }
}

Thankyou.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    orderComplete: store.orderState.orderComplete
  }
}

export default connect(mapStateToProps)(Thankyou)