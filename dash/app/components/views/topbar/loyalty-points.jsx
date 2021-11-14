import React from 'react'
import { connect } from 'react-redux'
import * as cartApi from '../../../api/cart-api'
import * as G from '../../../api/common-api'
import {toastr} from 'react-redux-toastr'
import CartProductTable from '../cart/cart-products-table'
import CartSummaryTable from '../cart/cart-summary-table'
import store from '../../../store/configureStore'

class LoyaltyPoints extends React.Component {
	constructor(props) {
	    super(props)     
	}

	componentDidMount(){
		cartApi.getLoyaltyPoints()
	}

	viewLoyaltyPoints(){
		cartApi.viewLoyaltyPoints()
	}

	viewVouchers(){
		cartApi.loadDicounts()
	}


	render(){
		return(
			<div className="topbar-item loyalty-points sss">
				<div>
					<div className="loyalty-points-wrapper">
						<div className="count-cards">
							<div className="card">
								<span className="count-label">Loyalty Points</span>
								<span className="count" id="loyaltyCount">{this.props.loyaltyCount[0]}</span>
							</div>
							<div className="card">
								<span className="count-label">Claim Amount</span>
								<span className="count" id="loyaltyAmount">{G.formatPrice(this.props.loyaltyCount[1])}</span>
							</div>
						</div>
						<div className="footer-action">
							<button className="button-red" onClick={this.viewLoyaltyPoints.bind(this)}>Create Voucher</button>
							<button className="button-red outline" onClick={this.viewVouchers.bind(this)}>View Vouchers</button>
						</div>
					</div>
				</div>
			</div>
		)
	}
}

LoyaltyPoints.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	cart: store.cartState.cart,
  	loyaltyCount: store.cartState.loyaltyCount
  }
}

export default connect(mapStateToProps)(LoyaltyPoints)