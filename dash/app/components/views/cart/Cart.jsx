import React from 'react'
import { connect } from 'react-redux'
import * as cartApi from '../../../api/cart-api'
import cookie from 'react-cookie'
import {toastr} from 'react-redux-toastr'
import CartProductTable from './cart-products-table'
import CartSummaryTable from './cart-summary-table'
import store from '../../../store/configureStore'

class Cart extends React.Component {
	constructor(props) {
	    super(props)     
	}

	componentDidMount(){
		cartApi.get()
	}

	clearCart(){
		cartApi.remove()
	}

	goToNext(e){
		e.preventDefault();
		if(this.props.cart != "") {
			cookie.remove('id_delivery_address')
        	cookie.remove('id_billing_address')
			this.context.router.push('address')
		}
		else {
			toastr.error("Error", "Please add products to cart.", {icon: "icon-error"})
		}
	}

	render(){
		return(
			<div className="cart-column">
				<div className="sidebar-header">
					<h3 className="text-align-center">Products</h3>
				</div>
				<CartProductTable cart={this.props.cart} />
				<CartSummaryTable />
				{this.props.cart && this.props.cart.saleStatus == 1 ? <p className="sale-alert">Due to GST implementations there won't be any sales from 28th June to 5th July!</p> :
					<div className="footer-actions">
						<button type="button" onClick={this.clearCart.bind(this)}>Clear Cart</button>
						{this.props.nextBtn == true ? <button type="button" className="button-black pull-right address-page-btn" onClick={this.props.onClick}>Next</button>
						: <button type="button" className="button-black pull-right" onClick={this.goToNext.bind(this)}>Next</button>}
					</div>}
			</div>
		)
	}
}

Cart.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	cart: store.cartState.cart
  }
}

export default connect(mapStateToProps)(Cart)