import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../store/configureStore'
import * as cartApi from '../../api/cart-api'
import * as G from '../../api/common-api'
import Input from '../../components/common/Input'
import Ripples from 'react-ripples';
//import { Scrollbars } from 'react-custom-scrollbars'

class QuickView extends React.Component{
	constructor(props){
		super(props)
	}

	closeModal(productName, productID){
		G.closeModal(["viewProduct"]);
		G.openRequestQuote(productName, productID)
	}

  	render(){
  		let data = this.props.products[0]
	  	return (
	            <div className="product-wrapper">
									<div className="above-the-fold">
										<div className="product-visual-column">
											<img className="product-image" src={data.imageLink} alt={data.name}/>
										</div> 
	                <div className="product-detail-column">
	                  <h2 className="product-name">{data.name}</h2>
	                  <ul className="product-info">
											<li>Reference: <span>{data.reference}</span></li>
											<li>Brand: <span>{data.manufacturer}</span></li>
										</ul>
										<p className="product-price">{G.formatPrice(data.price)}</p>
										<p className="tax-include">Incl. of Tax</p>
										{/*
	                    <p>Tax Exclusive Price: {G.formatPrice(data.price_tax_exc)}</p>
	                    <p>Tax Amount: {G.formatPrice(data.price - data.price_tax_exc)}</p>
										*/}
	                  <div className="moq">
											<p>Quantity</p>
                  		<p>MOQ: {data.minimal_quantity}</p>
											<div className="item-quantity">
	                    	<span className="quantity-decrement" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "qtyBoxProduct")}><i className="icon-remove"></i></span>
	                      <Input className="quantity-value" type="number" inputValue={data.minimal_quantity} id={"qtyBoxProduct_"+data.id_product} />
	                    	<span className="quantity-increment" onClick={G.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "qtyBoxProduct")}><i className="icon-add"></i></span>
											</div>
										</div>
										<div className="cta-section">
											{/*
												<button className="button-red" onClick={G.addToCart.bind(this, data.id_product, "qtyBoxProduct", 1, data.minimal_quantity, this.props.routers)}>Buy Now</button>
											*/}
	                    <button className="button-red" onClick={G.addToCart.bind(this, data.id_product, "qtyBoxProduct", 0, data.minimal_quantity, false)}>Add to Cart</button>
	                    <div className="action-block"><Ripples><button className="button-red outline" onClick={this.closeModal.bind(this, data.name, data.id_product)}>Bulk Enquiry</button></Ripples></div>
	                  </div>
									</div>
									</div>
									<div className="details-section">
	                  {data.features.length > 0 ? <div>
	                    <h3>Features</h3>
	                    <table>
	                      <tbody>
	                        {data.features.map((feature, i) => {
	                          return (
	                            <tr key={i}>
	                              <td className="hidden-tablet">{feature.name}</td>
	                              <td data-title={feature.name}>{feature.value}</td>
	                            </tr>
	                          )
	                        })}
	                      </tbody>
	                    </table>
	                  </div> : undefined}
									</div>
	    </div>
	            
		)
	}
}

export default QuickView