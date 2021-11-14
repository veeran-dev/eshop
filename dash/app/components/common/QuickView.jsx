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
	componentDidMount(){
		let data = this.props.products[0]
		document.getElementById("qtyBoxProduct_"+data.id_supplier+"_"+data.id_product).value = 1;
		console.log(document.getElementById("qtyBoxProduct_"+data.id_supplier+"_"+data.id_product).value)
	}

	changeCity(e){
		e.preventDefault();
	}

	closeModal(productName, productID){
		G.closeModal(["viewProduct"]);
		G.openRequestQuote(productName, productID)
	}

  	render(){
  		let data = this.props.products[0]

  		let disabledBtn = 0, budgetTooltip = 0, regionTooltip = 0

	    if(data != undefined && data != "") {
	      if(data.available_in_selected_region == 0) {
	        disabledBtn = 1
	        regionTooltip = 1
	      }
	      else if(budgetConfigured == 1 && budgetOption == 1 && !data.budget_product) {
	        disabledBtn = 1
	        budgetTooltip = 1
	      }
	    }
	    
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
						<p className="product-price">{G.formatPrice(data.price_tax_exc)}</p>
						<p className="tax-include">Excl. of Tax</p>
                  		<div className="moq">
							<p>Quantity</p>
              				<p>MOQ: {data.minimal_quantity}</p>
							<div className="item-quantity">
		                    	<span className="quantity-decrement" onClick={G.updateQuantity.bind(this, data.id_supplier+"_"+data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "qtyBoxProduct")}><i className="icon-remove"></i></span>
		                        <Input key={"qtyBoxProduct_"+data.id_supplier+"_"+data.id_product} className="quantity-value" type="number" inputValue={data.minimal_quantity} id={"qtyBoxProduct_"+data.id_supplier+"_"+data.id_product} />
		                    	<span className="quantity-increment" onClick={G.updateQuantity.bind(this, data.id_supplier+"_"+data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "qtyBoxProduct")}><i className="icon-add"></i></span>
							</div>
						</div>
						<div className="supplier-name">
							<p>Supplier: {data.supplier_name}</p>
						</div>
						{budgetConfigured == 1 && budgetOption == 1 && data.budget_product ? <div className="po-balance">PO Balance: <span>{data.available_budget_quantity}</span></div> : null}
						<div className="cta-section tooltip-container">
                    		<button className={"button-red has-tooltip"+ (disabledBtn == 1 ? " disabled-light" : "")} onClick={G.addToCart.bind(this, data.id_supplier+"_"+data.id_product, "qtyBoxProduct", 0, data.minimal_quantity, false)}>
                    			Add to Cart
                      			{budgetTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">This product is not available in your Purchase Order.</span></span>}
                    			{regionTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">Sorry this product is not available in {data.selected_region_name} region.</span></span>}
                    		</button>
                    		<div className="action-block">
                    			{/*<Ripples><button className="button-red outline" onClick={this.closeModal.bind(this, data.name, data.id_product)}>Bulk Enquiry</button></Ripples>*/}
                    		</div>
                  		</div>
							{regionTooltip == 1 && <div className="product-region-info"><i className="icon-info"></i> Sorry this product is not available in <strong>{data.selected_region_name}</strong> region.</div>}
					</div>
				</div>
				<div className="details-section">
                  {data.features.length > 0 ? 
                  	<div>
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

export default QuickView;