import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../store/configureStore'
import { getProductById, formatPrice, updateQuantity, addToCart, openRequestQuote } from '../../api/common-api'
import * as cartApi from '../../api/cart-api'
import Input from '../../components/common/Input'
import Ripples from 'react-ripples';

class Product extends React.Component {
  constructor(props){
    super(props)
  }

  componentDidMount(){
    getProductById(this.props.params.idProduct, this.props.params.idSupplier)
  }

  requestQuote(name, id){
    openRequestQuote(name, id)
  }

  changeCity(e) {
    e.preventDefault();
		this.props.handleMegaMenu();
  }

  render() {
    let data = this.props.productData[0]

    let disabledBtn = 0, budgetTooltip = 0, regionTooltip = 0

    if(data != undefined && data != "") {
      if(budgetConfigured == 1 && budgetOption == 1 && !data.budget_product) {
        disabledBtn = 1
        budgetTooltip = 1
      }
    }

    return (
      <div className="page">
        {data != undefined && data != "" ? 
          <div className="product-wrapper">
            <div className="above-the-fold">
              <div className="product-visual-column">
                <img className="product-image" src={data.imageLink} alt={data.name} />
              </div> 
              <div className="product-detail-column">
                <h1 className="product-name">{data.name}</h1>
                <ul className="product-info">
                  <li>Reference: <span>{data.reference}</span></li>
                  <li>Brand: <span>{data.manufacturer}</span></li>
                </ul>
                <p className="product-price">{formatPrice(data.price_tax_exc)}</p>
                <p className="tax-include">Excl. of Tax</p>
                {/*
                <p>Tax Exclusive Price: {formatPrice(data.price_tax_exc)} Tax Amount: {formatPrice((data.price - data.price_tax_exc))}</p>
                */}

                <div className="moq">
                  <p>Quantity</p>
                  <p>MOQ: {data.minimal_quantity}</p>
                  <div className="item-quantity">
                    <span className="quantity-decrement" onClick={updateQuantity.bind(this, data.id_supplier+"_"+data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "qtyBoxProduct", false)}><i className="icon-remove"></i></span>
                    <Input className="quantity-value" type="number" inputValue={data.minimal_quantity} id={"qtyBoxProduct_"+data.id_supplier+"_"+data.id_product} />
                    <span className="quantity-increment" onClick={updateQuantity.bind(this, data.id_supplier+"_"+data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "qtyBoxProduct", false)}><i className="icon-add"></i></span>
                  </div>
                </div>
                <div className="supplier-name">
                  <p>Supplier: {data.supplier_name}</p>
                </div>
                {budgetConfigured == 1 && budgetOption == 1 && data.budget_product ? <div className="po-balance">PO Balance: <span>{data.available_budget_quantity}</span></div> : null}
                <div className="cta-section">
                  <div className="tooltip-container">
                      <button className={"button-red has-tooltip"+ (disabledBtn == 1 ? " disabled-light" : "")} onClick={addToCart.bind(this, data.id_supplier+"_"+data.id_product, "qtyBoxProduct", 1, data.minimal_quantity, this.context.router)}>
                        Buy Now
                        {budgetTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">This product is not available in your Purchase Order.</span></span>}
                        {regionTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">Sorry this product is not available in {data.selected_region_name} region.</span></span>}
                      </button>
                  </div>
                  <div className="tooltip-container">
                      <button className={"button-red outline has-tooltip"+ (disabledBtn == 1 ? " disabled-light" : "")} onClick={addToCart.bind(this, data.id_supplier+"_"+data.id_product, "qtyBoxProduct", 0, data.minimal_quantity)}>
                        Add to Cart
                        {budgetTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">This product is not available in your Purchase Order.</span></span>}
                        {regionTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">Sorry this product is not available in {data.selected_region_name} region.</span></span>}
                      </button>
                  </div>
                  {/*<Ripples><button className="button-red outline" onClick={this.requestQuote.bind(this, data.name, data.id_supplier+"_"+data.id_product)}>Bulk Enquiry</button></Ripples>*/}
                </div>
               {regionTooltip == 1 && <div className="product-region-info"><i className="icon-info"></i> Sorry this product is not available in <a href="#" onClick={this.changeCity.bind(this)}>{data.selected_region_name}</a> region.</div>}
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

          </div> : undefined}
      </div>
    )
  }
}

Product.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    productData: store.commonState.productDetails,
    cart: store.cartState.cart
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

export default connect(mapStateToProps, mapDispatchToProps)(Product)