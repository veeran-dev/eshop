import React from 'react'
import { connect } from 'react-redux'
import * as cartApi from '../../../api/cart-api'
import {toastr} from 'react-redux-toastr'
import CartProductTable from './cart-products-table'
import CartSummaryTable from './cart-summary-table'
import store from '../../../store/configureStore'

class CartPage extends React.Component {
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
		if(this.props.cart != "")
			this.context.router.push('address')
		else
			toastr.error("Error", "Please add products to cart.", {icon: "icon-error"})
	}

	render(){
		return(
			<div className="page-container cart-column">
				<div className="sidebar-header">
					<h3 className="text-align-center">Products</h3>
				</div>
				<CartProductTable cart={this.props.cart} />
				<CartSummaryTable />
				<div className="footer-actions">
					<button type="button" onClick={this.clearCart.bind(this)}>Clear Cart</button>
					{this.props.nextBtn ? <button type="button" className="button-black pull-right" onClick={this.props.onClick}>Next</button>
					: <button type="button" className="button-black pull-right" onClick={this.goToNext.bind(this)}>Next</button>}
				</div>
			</div>
		)
	}
}

CartPage.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	cart: store.cartState.cart
  }
}

export default connect(mapStateToProps)(CartPage)