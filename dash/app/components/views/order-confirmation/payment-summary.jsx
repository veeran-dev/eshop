import React from 'react'
import { connect } from 'react-redux'
import * as cartApi from '../../../api/cart-api'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'

class PaymentSummary extends React.Component {
    constructor(props){
        super(props)
    }

    componentDidMount(){
      cartApi.cartSummary()
    }

    render() {
        var discountValue = 0
        if(this.props.paymentSummary.discounts != undefined && this.props.paymentSummary.discounts.length > 0){
          for(var i = 0; i < this.props.paymentSummary.discounts.length; i++){
              discountValue += parseFloat(this.props.paymentSummary.discounts[i].reduction_amount)
          }
        }
        return (
            <div className="payment-summary">
                <h3 className="block-header">Payment Summary</h3>
                {this.props.isFetching ? <div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div> : null } 
                <table>
                    <tbody>
                        <tr>
                            <td data-title="Discount">Discount</td>
                            <td data-title="Discount" className="bold-text text-align-right">{discountValue != "" ? G.formatPrice(discountValue) : G.formatPrice(0)}</td>
                        </tr>
                        <tr>
                            <td data-title="Shipping Cost">Shipping Cost</td>
                            <td data-title="Shipping Cost" className="bold-text text-align-right">Free Shipping</td>
                        </tr>
                        <tr>
                            <td data-title="Tax">Tax</td>
                            <td data-title="Tax" className="bold-text text-align-right">{this.props.paymentSummary.totalTax}</td>
                        </tr>
                        {/*<tr>
                            <td data-title="Voucher Offer">Loyalty Points</td>
                            <td data-title="Voucher Offer" className="bold-text text-align-right">{this.props.paymentSummary.loyaltyPoints}</td>
                        </tr>*/}
                        <tr>
                            <td data-title="Total">Total</td>
                            <td data-title="Total" className="bold-text text-align-right">{this.props.paymentSummary.totalPrice}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        )
    }
}

PaymentSummary.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    paymentSummary: store.cartState.summary,
    isFetching: store.cartState.isFetchingSummary
  }
}

export default connect(mapStateToProps)(PaymentSummary)