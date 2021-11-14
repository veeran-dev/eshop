import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as cartApi from '../../../api/cart-api'
import * as G from '../../../api/common-api'
import Input from '../../../components/common/Input'
import {toastr} from 'react-redux-toastr'
import { Scrollbars } from 'react-custom-scrollbars'

class CartProductsTable extends React.Component {
	constructor(props){
		super(props)
	}

	removeProduct(idProduct, idCombination, idCustomization, event){
		cartApi.deleteProduct(idProduct, idCombination, idCustomization)
	}

    updateQuantity = (idProduct, price, minimalQuantity, budgetQuantity, type) => {
		let oldQuantity, newQuantity, quantityArray = new Array()
		oldQuantity = document.getElementById("changeQuantityCart_"+idProduct).value

		if(oldQuantity == "")
			oldQuantity = 0

		if(type == 1)
		  	newQuantity = (parseInt(oldQuantity)+1)
		else if(type == 2)
	  		newQuantity = (parseInt(oldQuantity)-1)
		else
			newQuantity = parseInt(oldQuantity)

		if(newQuantity < minimalQuantity){
    		toastr.error('Error', 'Please provide '+minimalQuantity+' or more units.', {icon: 'icon-error'})
    	}
    	else if(budgetConfigured == 1 && newQuantity > budgetQuantity) {
			toastr.error('Error', "You can't add more than PO Balance.", {icon: 'icon-error'});
			quantityArray.push(idProduct+"-"+budgetQuantity)
			cartApi.update(quantityArray, price, oldQuantity, 'changeQuantityCart_')
    	}
    	else{
    		quantityArray.push(idProduct+"-"+newQuantity)
			cartApi.update(quantityArray, price, oldQuantity, 'changeQuantityCart_')
    	}
	}

	quantityIncrease(idProduct, unitPrice, minimalQuantity){
	    this.updateQuantity(idProduct, minimalQuantity, unitPrice, 1)
	}

	quantityDecrease(idProduct, unitPrice,  minimalQuantity){
	    this.updateQuantity(idProduct, minimalQuantity, unitPrice, 2)
	}

	render(){
		return(
			<div className="cart-products-table">
				<div className="fixed-table-header">
					<table>
						<thead>
							<tr>
								<th className="product-name">Name</th>
								<th className="quantity text-align-right">Quantity</th>
								<th className="price text-align-right">Price</th>
								<th className="actions text-align-right"></th>
							</tr>
						</thead>
					</table>
				</div>
				<Scrollbars className="cart-table-wrapper">
					<table className="cart-table">
						<tbody>
						{this.props.isFetching ? <tr><td colSpan="4"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div>
						<div className="loading-item"></div></div></td></tr> :
							(this.props.cart && this.props.cart.length > 0 ? this.props.cart.map( (cart, index) => {
								return(
									<tr key={index}>
										<td className="product-name"><span onClick={G.quickView.bind(this, cart.id_product, cart.id_supplier)}>{cart.name}</span></td>
										<td className="quantity text-align-right">
											<div className="item-quantity">
												<span className="quantity-decrement" onClick={this.updateQuantity.bind(this, cart.id_supplier+"_"+cart.id_product, cart.price, cart.minimal_quantity, cart.available_budget_quantity, 2)}><i className="icon-remove"></i></span>
													<div id={"parentNode_"+cart.id_supplier+"_"+cart.id_product} className="quantity-value-wrapper tooltip">
														<Input 
															className="quantity-value" 
															id={"changeQuantityCart_"+cart.id_supplier+"_"+cart.id_product} 
															inputValue={cart.cart_quantity} 
															min={cart.minimal_quantity}
															max={budgetConfigured == 1 ? cart.available_budget_quantity : ""}
															onBlur={this.updateQuantity.bind(this, cart.id_supplier+"_"+cart.id_product, cart.price, cart.minimal_quantity, cart.available_budget_quantity, 0)} />
                                						<span className="tooltiptext tooltip-right gray-color-text">Please enter {cart.minimal_quantity} or more units.</span>			
													</div>
												<span className="quantity-increment" onClick={this.updateQuantity.bind(this, cart.id_supplier+"_"+cart.id_product, cart.price, cart.minimal_quantity, cart.available_budget_quantity, 1)}><i className="icon-add"></i></span>
											</div>
										</td>
										<td className="price text-align-right">
											<span id={"cartTotal_"+cart.id_supplier+"_"+cart.id_product}>
												{G.formatPrice(cart.total)}
											</span>
										</td>
										<td className="actions text-align-right">
											<span onClick={this.removeProduct.bind(this, cart.id_supplier+"_"+cart.id_product, cart.id_product_attribute, cart.id_customization)} className="cursor-pointer">
												<i className="icon-close"></i>
											</span>
										</td>
									</tr>
								)
							}) : <tr><td colSpan="4"><div className="is-empty small"><img src="dash/img/empty-cart.png" alt="Empty Cart!" /><h2>Empty Cart!</h2></div></td></tr>)}
						</tbody>
					</table>
				</Scrollbars>
			</div>
		)
	}
}

const mapStateToProps = function(store) {
  return {
  	isFetching: store.cartState.isFetchingCart
  }
}

export default connect(mapStateToProps)(CartProductsTable)