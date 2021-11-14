import React from 'react'
import { connect } from 'react-redux'
import * as cartApi from '../../../api/cart-api'
import { formatPrice } from '../../../api/common-api'
import store from '../../../store/configureStore'

class CartSummaryTable extends React.Component {
	constructor(props){
		super(props)
	}

	componentDidMount(){cartApi.cartSummary()}

	render(){
		let discounts = this.props.summary.discounts, discountAmount = 0

		if(discounts != undefined) {
			for(var i = 0; i < discounts.length; i++){
				discountAmount += parseFloat(discounts[i].reduction_amount)
			}
		}

		return(
			<div>
				<div className="cart-summary">
					<p className="border-top">Shipping <span className="pull-right">Free Shipping</span></p>
					<p>Tax <span className="pull-right">{this.props.summary.totalTax}</span></p>
					{/*<p>Loyalty Points <span className="pull-right">{this.props.summary.loyaltyPoints}</span></p>*/}
					<p>Discount <span className="pull-right">{formatPrice(discountAmount)}</span></p>
					<p className="total-price border-top">Total Price <span className="pull-right">{this.props.summary.totalPrice}</span></p>
					<p className="total-items">No. of Products <span className="pull-right">{this.props.summary.totalProducts}</span></p>
				</div> 
			</div>
		)
	}
}

const mapStateToProps = function(store) {
  return {
  	summary: store.cartState.summary,
  	isFetching: store.cartState.isFetchingSummary
  }
}

export default connect(mapStateToProps)(CartSummaryTable)