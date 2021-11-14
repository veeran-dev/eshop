import React from 'react'
import { Link } from 'react-router'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import * as cartApi from '../../../../api/cart-api'
import Input from '../../../../components/common/Input'
import * as G from '../../../../api/common-api'
import serialize from 'form-serialize'
import {toastr} from 'react-redux-toastr'
import store from '../../../../store/configureStore'
import { Scrollbars } from 'react-custom-scrollbars'
import Ripples from 'react-ripples'
import CONTROLLED_MEGAMENU from '../../../../constants/action-types';

class PurchaseList extends React.Component {
	constructor(props){
		super(props)

		this.state = {
			selectedItems: 0,
			searchString: "",
			supplier_id: null,
		}
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

    updateQuantity = (idProduct, minimalQuantity, price, type, elementID, purchaseList, budgetQuantity) => {
		let oldQuantity, newQuantity
		oldQuantity = document.getElementById(elementID+"_"+idProduct).value

		if(oldQuantity == "")
			oldQuantity = 0

		if(type == 1)
		  	newQuantity = (parseInt(oldQuantity)+1)
		else if(type == 2)
	  		newQuantity = (parseInt(oldQuantity)-1)
		else
			newQuantity = parseInt(oldQuantity)

		if(budgetQuantity < 0)
			budgetQuantity = 0
		if(!newQuantity){
			return false;
		}
		if(newQuantity < minimalQuantity) {
		  toastr.error('Error', 'Requires minimal quantity of '+minimalQuantity, {icon: 'icon-error'})
		  if(purchaseList) {
		  	document.getElementById("listProduct_"+idProduct).value = 0
			document.getElementById("finalPrice_" + idProduct).innerHTML = G.formatPrice(0)
	    	document.getElementById("hiddenCartQuantity_" + idProduct).value = ""
		  }
		}
		else if(budgetConfigured == 1 && budgetOption == 1 && newQuantity > budgetQuantity) {
			toastr.error('Error', "You can't add more than PO Balance.", {icon: 'icon-error'})
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
    	// return false;
    	quantityData = document.getElementsByTagName('input')
    	quantityResult = new Array()

    	for(var i = 0; i < quantityData.length; i++){
    		if(quantityData[i].className == 'quantity-value checkQty active')
    			if(quantityData[i].value != "" && quantityData[i].value != 0)
    				quantityResult.push(quantityData[i].value)
    	}

    	if(typeof quantityResult != "undefined" && quantityResult != null && quantityResult.length > 0){
    		cartApi.add(quantityObject.cartQuantity)
    		let searchStringTemp = this.searchString.value;
    		purchaseListForm.reset()
    		this.searchString.value = searchStringTemp;
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
		var quantityData = document.getElementsByTagName('input')
    	for(var i = 0; i < quantityData.length; i++){
    		if(quantityData[i].className == 'quantity-value checkQty active'){
    			quantityData[i].value=0;
    		}
    	}
      this.setState({
        searchString: e.target.value,
        selectedItems:0
      })
    }

    changeCity() {
		this.props.handleMegaMenu();
    }

    setSupplier = (e)=>{
        	this.setState({supplier_id: e.target.value, searchString: "", selectedItems: 0})
        	this.props.onChange(e)
        	this.searchString.value =""
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
										{/*<div className="purchase-list-search">
											<select id="pl-category-filter" onChange={this.props.onChange}>
												<option value="0">All categories</option>
												{this.props.categories && this.props.categories.length > 0 ? this.props.categories.map((data, i) => {
													return (
														<option key={i} value={data.id_category}>
															{data.category}
														</option>
													)
												}) : null}
											</select><input onChange={this.filterData.bind(this)} id="pl-search-filter" type="text" placeholder="Search Your Products"/>
										</div>*/}
										<div className="supplier-list-search">
											<select id="pl-supplier-filter" onChange={this.setSupplier.bind(this)} value={this.state.supplier_id && this.state.supplier_id != null ? this.state.supplier_id:0}>
												<option value="0">All suppliers</option>
												{this.props.suppliers && this.props.suppliers.length > 0 ? this.props.suppliers.map((data, i) => {
													return (
														<option key={i} value={data.id_supplier}>
															{data.name}
														</option>
													)
												}) : null}
											</select><input ref={(node) => {this.searchString = node}} onChange={this.filterData.bind(this)} id="pl-search-filter" type="text" placeholder="Search Your Products"/>
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
										var priceTaxInclusive = (list.price_tax_exc * ((list.tax_value / 100) + 1)), statusLabel = ""
										
										if(list.allow_oosp == 1) {
											productAvailability = "disabled"
											statusLabel = <span>Out of Stock</span>
										}
										else{
											productAvailability = "active"
											statusLabel=""
										}
										{/* Highlight 'Pack' string in porduct name */}
										var str = list.name;
										var pattern  = str.search("Pack");
										var beforePart = str.slice(0, pattern);
										var afterPart = str.slice(pattern + 4, str.length);
										var productName;
										if (pattern === -1){
											productName = str;
										} else {
											productName = [beforePart, <strong>Pack</strong>, afterPart];
										}
							        	return (
									        <tr key={"table_row_"+list.id_supplier+"_"+list.id_product} id={"table_row_"+list.id_supplier+"_"+list.id_product}>
									            <td className="purchase-list-thumb"><img src={list.imageLink} alt={list.name} /></td>
									            <td className="purchase-list-product-info">
									            	<p className="product-name"><span className="black-color-text bold-text" onClick={G.quickView.bind(this, list.id_product, list.id_supplier)}>{productName}</span></p>
									            	<p className="product-price"><span className="red-color-text">{G.formatPrice(list.price_tax_exc)}</span> <span className="product-tax-label">(Excl. of Tax)</span></p>
									            	<p className="product-meta">
									            		<span>Reference: <span className="black-color-text">{list.reference}</span></span>
									            		<span className="text-align-right pull-right">Average Consumption: <span className="black-color-text">{list.per_month} units/month</span></span>
									            	</p>
									            </td>
									     		<td className="purchase-list-quantity">
									     			<div className="item-quantity">
									     				<span className={"quantity-decrement "+productAvailability} onClick={this.updateQuantity.bind(this, list.id_supplier+"_"+list.id_product, list.minimal_quantity, priceTaxInclusive, 2, "listProduct", true, list.available_budget_quantity)}><i className="icon-remove"></i></span>
										     			<span id={"listQuantityParent_"+list.id_supplier+"_"+list.id_product}>
										     				<Input 
										     					className={"quantity-value checkQty "+productAvailability} 
										     					type="number" 
										     					min={list.minimal_quantity} 
										     					max={budgetConfigured == 1 && budgetOption == 1 ? list.available_budget_quantity : ""} 
										     					inputValue="0" 
										     					id={"listProduct_" + list.id_supplier+"_"+list.id_product} 
										     					key={"listProduct_" + list.id_supplier+"_"+list.id_product} 
										     					onBlur={this.updateQuantity.bind(this, list.id_supplier+"_"+list.id_product, list.minimal_quantity, priceTaxInclusive, 0, "listProduct", true, list.available_budget_quantity)} 
										     					ref={"qty_" + list.id_supplier+"_"+list.id_product} />
										     			</span>
										     			<span className={"quantity-increment "+productAvailability} onClick={this.updateQuantity.bind(this, list.id_supplier+"_"+list.id_product, list.minimal_quantity, priceTaxInclusive, 1, "listProduct", true, list.available_budget_quantity)}><i className="icon-add"></i></span>
									     			</div>			
									     			<Input type="hidden" name="cartQuantity[]" id={"hiddenCartQuantity_" + list.id_supplier+"_"+list.id_product} />
									     			<p className="product-availability text-align-right">
									     				{statusLabel}
									     			</p>
									     		</td>
									     		<td className="purchase-list-total-price">
									     			<p id={"finalPrice_" + list.id_supplier+"_"+list.id_product} className="text-align-right red-color-text finalPrice">{G.formatPrice(0)}</p>
									     			<p className="text-align-right">GST: <span className="red-color-text">{list.tax_value}%</span></p>
									     			
									     		</td>
									            <td className="purchase-list-order-date">
									            	<p className="text-align-center">{list.last_ordered_date ? list.last_ordered_date : "New Product"}</p>
									            	<p className="name"><span className="red-color-text">{list.supplier_name}</span></p>
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
								<span className="gray-color-text">{listProducts.length} Products in Your Purchase List.</span>
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

const mapDispatchToProps = function(dispatch) {
    return({
        handleMegaMenu: () => {dispatch({
    		type: "CONTROLLED_MEGAMENU",
    		megaMenu: true
  		})}
    })
}

export default connect(mapStateToProps, mapDispatchToProps)(PurchaseList)