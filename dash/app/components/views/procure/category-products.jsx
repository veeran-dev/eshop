import React from 'react'
import ReactDOM from 'react-dom'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import ReactCSSTransitionGroup from 'react-addons-css-transition-group'
import * as procureBuyApi from '../../../api/procure-buy-api'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'

class CategoryProducts extends React.Component {
    
    componentDidMount() {
    	procureBuyApi.getListCategoryProducts(this.props.params.categoryId)
  	}

    render() {
        return (
          <ReactCSSTransitionGroup transitionName="grid-animation" transitionEnterTimeout={3000} transitionAppear={true} transitionAppearTimeout={500} transitionLeaveTimeout={300} component="div" className="product-container">
            {this.props.purchaseCategoryProducts.map((products, index) => {
              let ratingsElem = [], disabledBtn = 0, budgetTooltip = 0, regionTooltip = 0
              let ratingsGrade = Math.ceil(products.ratings.grade)
              for(var j = 0; j < 5; j++){
                if(ratingsGrade > j)
                  ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
                else
                  ratingsElem.push(<i className="icon-star-empty" key={j}></i>) 
              }

              if(budgetConfigured == 1 && budgetOption == 1 && !products.budget_product) {
                disabledBtn = 1
                budgetTooltip = 1
              }

              return(
                /* Product Grid Starts */
                <div key={index} className="product">                  
                  {/* Product Image */}
                  <a href="javascript:void(0)" onClick={G.quickView.bind(this, products.id_product)}>
                    <div className="product-visual">
                      {regionTooltip == 1 && <div className="product-error">
                          <div className="wrapper">
                            <h3>Sorry!</h3>
                            <p>The product is not available in {products.selected_region_name} region.</p>
                          </div>
                      </div>}
                      <img src={products.imageLink} alt={products.name} />
                      <button className="quick-view">Quick view</button>
                    </div>
                  </a>

                  {/* Product Name */}
                  <a href="javascript:void(0)" onClick={G.goToProduct.bind(this, products.id_product, products.id_supplier)}>
                    <div className="product-name"><h3>{products.name}</h3></div>
                  </a>

                  {/* Product Details Wrapper */}
                  <div className="product-details">
                    {/* Product Reviews and Ratings */}
                    <div className="product-standard">
                      <div className="product-ratings">
                        <span>
                          {ratingsElem}
                        </span>
                      </div>

                      <div className="product-reviews">{products.nbComments} Reviews</div>
                    </div>

                    {/* Product Price */}
                    <div className="product-value">
                      <div className="product-price">
                        <span>{products.sp_price && products.sp_price > 0 ? G.formatPrice(products.sp_price) : G.formatPrice(products.price_tax_exc)}</span>
                      </div>
                      <div className="market-price">
                        { /*<span className="retail-price">Rs. 12000</span>
                        <span className="offer-percentage">25%</span> */}
                      </div>
                    </div>
                  </div>

                  {/* Product Actions Wrapper */}
                  <div className="product-actions">

                    {/* Product Quantity Stepper Input */}
                    <div className="product-quantity">
                      <div className="minimum-order-quantity">MOQ: <span>1</span></div>
                      <div className="item-quantity">
                        <span className="quantity-decrement" onClick={G.updateQuantity.bind(this, products.id_product, products.minimal_quantity, "", 2, "quantity")}><i className="icon-remove"></i></span>
                        <input className="quantity-value" type="number" id={"quantity_"+products.id_product} defaultValue={products.minimal_quantity} />
                        <span className="quantity-increment" onClick={G.updateQuantity.bind(this, products.id_product, products.minimal_quantity, "", 1, "quantity")}><i className="icon-add"></i></span>
                      </div>  
                    </div>
                    
                    {/* Product Grid Call to Action */}
                    <div className="product-cta tooltip-container">
                      <button className={"button-black has-tooltip"+ (disabledBtn == 1 ? " disabled-light" : "")} type="button" onClick={G.addToCart.bind(this, products.id_product, "quantity", 0, products.minimal_quantity)}>
                        Add to Cart
                        {budgetTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">This product is not available in your Purchase Order.</span></span>}
                        {regionTooltip == 1 && <span className="tooltip-wrapper"><span className="tooltippy">Sorry this product is not available in {products.selected_region_name} region.</span></span>}
                      </button>
                    </div>
                  </div>

                  {budgetConfigured == 1 && budgetOption == 1 && products.budget_product ? <div className="product-po-balance">PO Balance: <span>{products.available_budget_quantity}</span></div> : null}

                </div>
                /* Product Grid End */
              )
            })
          }
        </ReactCSSTransitionGroup>
    	)
  	}
}

CategoryProducts.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	purchaseCategoryProducts: store.procureBuyState.purchaseCategoryProducts
  }
}

export default connect(mapStateToProps)(CategoryProducts) 