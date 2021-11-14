import React from 'react'
import { connect } from 'react-redux'
import { Link } from 'react-router';
import cookie from 'react-cookie';
import * as orderApi from '../../api/orders-api'

class Thankyou extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      orderPlaced: false
    }
  }

  componentDidMount() {
    cookie.remove('id_delivery_address')
    cookie.remove('id_billing_address')
    orderApi.getPaymentMethod(this.props.params.id);
    orderApi.getOrderProcessEligibility(this.props.params.id);
  }

  getContent = () => {
    // Render status icon based on order status 
    if(typeof this.props.orderPlacedStatus == 'boolean') {
      if(!this.props.orderPlacedStatus) {
        return [
          <div>
            <div className="success-icon error">
              <span><i className="icon-hourglass-empty"></i></span>
            </div>
            <div className="success-title">
              Pending Approval
            </div>
          </div>,
          <div className="success-description">
            Your order is successfully placed & sent for approval.
            <span>You can track the status in <Link to='orders'>Orders</Link>. You will also be notified when the status changes</span> 
          </div>,
          <div className="order-details">
            <div className="order-number-label">Order ID</div>
            <div className="order-number">{this.props.params.id.split('_').join(', ')}</div>
          </div>,
          <div className="order-footer">Thank you!</div>
        ]
      }

      return [
        <div>
          <div className="success-icon">
            <span><i className="icon-check"></i></span>
          </div>
          <div className="success-title">
            Order Placed!
          </div>
        </div>,
        <div className="success-description">
          Your order is successfully placed.
          <span>You can track the status in <Link to='orders'>Orders</Link>. You will also be notified when the status changes</span> 
        </div>,
        <div className="order-details">
          <div className="order-number-label">Order ID</div>
          <div className="order-number">{this.props.params.id.split('_').join(', ')}</div>
        </div>,
        <div className="order-footer">Thank you!</div>
      ]
    }
    else if(this.props.params.status == 'Failed') {
      return [
        <div>
          <div className="success-icon error">
            <span><i className="icon-error"></i></span>
          </div>
          <div className="success-title">
            Order Failed!
          </div>
        </div>,
        <div className="success-description">
          Sorry, your order has been failed!
        </div>,
        <div className="order-details">
          <div className="order-number-label">Order ID</div>
          <div className="order-number">{this.props.params.id.split('_').join(', ')}</div>
        </div>,
        <div className="order-footer">Thank you!</div>
      ]
    }
  }

  render() {
    return (
    	<div className="thank-you">
        <div className="print-animation-container">
          <div className="printer-top"></div>

          <div className="paper-container">
            <div className="printer-bottom"></div>

            <div className="paper">
              <div className="main-contents">
                {typeof this.props.orderPlacedStatus == 'boolean' ? 
                  this.getContent() : 
                  <table>
                    <tbody>
                      <tr>
                        <td className="fetching big" colSpan="5">
                          <div className="fetching-content">
                            <div className="loading-item"></div>
                            <div className="loading-item"></div>
                            <div className="loading-item"></div>
                            <div className="loading-item"></div>
                            <div className="loading-item"></div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                }
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
    orderPlacedStatus: store.orderState.orderPaymentMethod,
    orderProcessStatus: store.orderState.orderProcessStatus
  }
}

export default connect(mapStateToProps)(Thankyou)