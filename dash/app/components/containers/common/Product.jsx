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
    getProductById(this.props.params.idProduct)
  }

  requestQuote(name, id){
    openRequestQuote(name, id)
  }

  render(){
    let data = this.props.productData[0]
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
                <p className="product-price">{formatPrice(data.price)}</p>
                <p className="tax-include">Incl. of Tax</p>
                {/*
                <p>Tax Exclusive Price: {formatPrice(data.price_tax_exc)} Tax Amount: {formatPrice((data.price - data.price_tax_exc))}</p>
                */}

                <div className="moq">
                  <p>Quantity</p>
                  <p>MOQ: {data.minimal_quantity}</p>
                  <div className="item-quantity">
                    <span className="quantity-decrement" onClick={updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 2, "qtyBoxProduct", false)}><i className="icon-remove"></i></span>
                    <Input className="quantity-value" type="number" inputValue={data.minimal_quantity} id={"qtyBoxProduct_"+data.id_product} />
                    <span className="quantity-increment" onClick={updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.price_tax_exc, 1, "qtyBoxProduct", false)}><i className="icon-add"></i></span>
                  </div>
                </div>

                <div className="cta-section">
                  
                  <Ripples><button className="button-red" onClick={addToCart.bind(this, data.id_product, "qtyBoxProduct", 1, data.minimal_quantity, this.context.router)}>Buy Now</button></Ripples>
                  <Ripples><button className="button-red outline" onClick={addToCart.bind(this, data.id_product, "qtyBoxProduct", 0, data.minimal_quantity)}>Add to Cart</button></Ripples>
                  <Ripples><button className="button-red outline" onClick={this.requestQuote.bind(this, data.name, data.id_product)}>Bulk Enquiry</button></Ripples>
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

export default connect(mapStateToProps)(Product)