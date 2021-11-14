import React from 'react'
import { Link } from 'react-router'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as cartApi from '../../api/cart-api'
import Input from '../../components/common/Input'
import * as G from '../../api/common-api'
import serialize from 'form-serialize'
import {toastr} from 'react-redux-toastr'
import store from '../../store/configureStore'
import { Scrollbars } from 'react-custom-scrollbars'
import Ripples from 'react-ripples'

class PurchaseList extends React.Component {
	constructor(props){
		super(props)

		this.state = {
			selectedItems: 0,
			searchString: ""
		}
	}

    _handleChange(price, idProduct, event) {
    	document.getElementById("finalPrice_" + idProduct).innerHTML = G.formatPrice(event.target.value * price)
    	document.getElementById("hiddenCartQuantity_" + idProduct).value = (idProduct + "-" + event.target.value)
    	this.updateSelection()
    }

    updateSelection(){
    	var purchaseListForm, quantityObject, quantityResult = new Array(), quantityData

    	purchaseListForm = document.querySelector('#purchaseListForm')
    	quantityObject = serialize(purchaseListForm, { hash: true })

    	quantityData = document.getElementsByTagName('input')
    	quantityResult = new Array()

    	for(var i = 0; i < quantityData.length; i++){
    		if(quantityData[i].className == 'quantity-value checkQty active')
    			if(quantityData[i].value != "" && quantityData[i].value != 0)
    				quantityResult.push(quantityData[i].value)
    	}

    	this.setState({
    		selectedItems: quantityResult.length
    	});
    }

    updateQuantity(idProduct, minimalQuantity, price, type, elementID, purchaseList){
		let oldQuantity, newQuantity
		oldQuantity = document.getElementById(elementID+"_"+idProduct).value

		if(oldQuantity == "")
			oldQuantity = 0

		if(type == 1)
		  newQuantity = (parseInt(oldQuantity)+1)
		else
		  newQuantity = (parseInt(oldQuantity)-1)

		if(newQuantity < minimalQuantity) {
		  toastr.error('Error', 'Requires minimal quantity of '+minimalQuantity, {icon: 'icon-error'})
		  if(purchaseList) {
		  	document.getElementById("listProduct_"+idProduct).value = 0
			  document.getElementById("finalPrice_" + idProduct).innerHTML = G.formatPrice(0)
	    	document.getElementById("hiddenCartQuantity_" + idProduct).value = ""
		  }
		}
		else {
		  document.getElementById(elementID+"_"+idProduct).value = newQuantity
		  if(purchaseList) {
		  	document.getElementById("listProduct_"+idProduct).value = newQuantity
			document.getElementById("finalPrice_" + idProduct).innerHTML = G.formatPrice(newQuantity * price)
	    	document.getElementById("hiddenCartQuantity_" + idProduct).value = (idProduct + "-" + newQuantity)
		  }
		}

		this.updateSelection()
	}

    _onSubmitClick(props){
    	var purchaseListForm, quantityObject, quantityResult, quantityData

    	purchaseListForm = document.querySelector('#purchaseListForm')
    	quantityObject = serialize(purchaseListForm, { hash: true })

    	quantityData = document.getElementsByTagName('input')
    	quantityResult = new Array()

    	for(var i = 0; i < quantityData.length; i++){
    		if(quantityData[i].className == 'quantity-value checkQty active')
    			if(quantityData[i].value != "" && quantityData[i].value != 0)
    				quantityResult.push(quantityData[i].value)
    	}

    	if(typeof quantityResult != "undefined" && quantityResult != null && quantityResult.length > 0){
    		cartApi.add(quantityObject.cartQuantity)
    		purchaseListForm.reset()
    		let hiddenFields = purchaseListForm.querySelectorAll('input[type="hidden"]')
    		for(var j = 0; j < hiddenFields.length; j++){
    			hiddenFields[j].value = ""
    		}

    		let finalPrice = document.getElementsByClassName("finalPrice");
			for(var k = 0; k < finalPrice.length; k++){
				finalPrice[k].innerHTML = G.formatPrice(0)
			}

			this.setState({
				selectedItems: 0
			});
    	}
    	else{
    		toastr.error('Error', 'No products selected', {icon: 'icon-error'})
    	}
    }

    filterData(e) {
      this.setState({
        searchString: e.target.value
      })
    }

    render() {
    	let listProducts = this.props.myList, searchString = this.state.searchString.trim().toLowerCase(), productAvailability = "disabled";
        
        if(searchString.length > 0){
            // We are searching. Filter the results.
            listProducts = listProducts.filter(function(l){
                return l.name.toLowerCase().match( searchString ) || 
                	   l.reference.toLowerCase().match( searchString );
            });
        }

        return (
        		<div className="purchase-list-column">
		        	<form className="form" id="purchaseListForm">
		        		{/* Static Fixed Table Header */} 
		        		<table className="purchase-list-header">
			        		<thead>
			        			<tr>
				        			<th className="purchase-list-thumb">Product</th>
				        			<th className="purchase-list-product-info">
										<div className="purchase-list-search">
											<select id="pl-category-filter" onChange={this.props.onChange}>
												<option value="0">All categories</option>
												{this.props.categories.map((data, i) => {
													return (
														<option key={i} value={data.id_category}>
															{data.category}
														</option>
													)
												})}
											</select><input onChange={this.filterData.bind(this)} id="pl-search-filter" type="text" placeholder="Search Your Products"/>
										</div>
					        		</th>
				        			<th className="purchase-list-quantity">Quantity</th>
				        			<th className="purchase-list-total-price">Total Price</th>
				        			<th className="purchase-list-order-date">Last Ordered</th>
			        			</tr>
			        		</thead>
		        		</table>

		        		{/* Dynamic Purchase List Table */} 
		        		<Scrollbars className="scroll-table">
					        <table className="purchase-list-table">
							    <tbody>
							    {this.props.isFetching ? <tr><td className="fetching big" colSpan="5"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
							        (listProducts && listProducts.length > 0 ? listProducts.map( (list, index) => {
							        	// Calculate tax inclusive price
										var priceTaxInclusive = (list.price_tax_exc * ((list.tax_value / 100) + 1))
										if(list.discontinued == 1) {
											productAvailability = "disabled"
										}
										else {
											if((list.allow_oosp == 1) || (list.allow_oosp == 0 && list.available_for_order == 1)) {
        										productAvailability = "active"
											}
											else {
												productAvailability = "disabled"
											}
										}
							        	return (
									        <tr key={index}>
									            <td className="purchase-list-thumb"><img src={"http://"	+ list.imageLink} alt={list.name} /></td>
									            <td className="purchase-list-product-info">
									            	<p className="product-name"><span className="black-color-text bold-text" onClick={G.quickView.bind(this, list.id_product)}>{list.name}</span></p>
									            	<p className="product-price"><span className="red-color-text">{G.formatPrice(list.price_tax_exc)}</span> <span className="product-tax-label">(Excl. of Tax)</span></p>
									            	<p className="product-meta">
									            		<span>Reference: <span className="black-color-text">{list.reference}</span></span>
									            		<span className="text-align-right pull-right">Average Consumption: <span className="black-color-text">{list.per_month} units/month</span></span>
									            	</p>
									            </td>
									     		<td className="purchase-list-quantity">
									     			<div className="item-quantity">
									     				<span className={"quantity-decrement "+productAvailability} onClick={this.updateQuantity.bind(this, list.id_product, list.minimal_quantity, priceTaxInclusive, 2, "listProduct", true)}><i className="icon-remove"></i></span>
										     			<span id={"listQuantityParent_"+list.id_product}>
										     				<Input className={"quantity-value checkQty "+productAvailability} type="number" min={list.minimal_quantity} inputValue="0" id={"listProduct_" + list.id_product} onChange={this._handleChange.bind(this, priceTaxInclusive, list.id_product)} ref={"qty_" + list.id_product} />
										     			</span>
										     			<span className={"quantity-increment "+productAvailability} onClick={this.updateQuantity.bind(this, list.id_product, list.minimal_quantity, priceTaxInclusive, 1, "listProduct", true)}><i className="icon-add"></i></span>
									     			</div>			
									     			<Input type="hidden" name="cartQuantity[]" id={"hiddenCartQuantity_" + list.id_product} />
									     			<p className="product-availability text-align-right">
									     				{list.discontinued == 1 ? <span>Discontinued</span> : 
									     				(list.allow_oosp == 1) || (list.allow_oosp == 0 && list.available_for_order == 1) ? 
									     					"Minimum: "+list.minimal_quantity : <span>Out of Stock</span>}
									     			</p>
									     		</td>
									     		<td className="purchase-list-total-price">
									     			<p id={"finalPrice_" + list.id_product} className="text-align-right red-color-text finalPrice">{G.formatPrice(0)}</p>
									     			<p className="text-align-right">VAT: <span className="red-color-text">{list.tax_value}%</span></p>
									     		</td>
									            <td className="purchase-list-order-date">
									            	<p className="text-align-center">{list.last_ordered_date ? list.last_ordered_date : "New Product"}</p>
									            </td>
									        </tr>
							         	)
					      			}) : <tr><td colSpan="5"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Products Found!</h2></div></td></tr>)
                  				}
							    </tbody>
							</table>
						</Scrollbars>

						{/* Footer Sections for Call To Actions */} 
						<div className="footer-actions">
							<Ripples className="pull-right">
								<span className="gray-color-text">{this.props.myTotalList} Products in Your Purchase List.</span>
								<button className="button-blue" type="button" onClick={this._onSubmitClick.bind(this)}>
									{this.props.isAddingProducts ? "Adding Items to Cart..." : "Add "+(this.state.selectedItems != 0 ? this.state.selectedItems : "")+" Items to Cart"}
								</button>
							</Ripples>
						</div>
						
					</form>
				</div>
    	)
    }
}

const mapStateToProps = function(store) {
  return {
  	isFetching: store.procureBuyState.isFetchingPurchaseList,
  	isAddingProducts: store.cartState.isAddingProduct
  }
}

export default connect(mapStateToProps)(PurchaseList)