import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import * as cartApi from '../../../api/cart-api'
import { quickView, formatPrice } from '../../../api/common-api'
import Input from '../../../components/common/Input'
import store from '../../../store/configureStore'
import { Scrollbars } from 'react-custom-scrollbars'
import ReactImageFallback from "react-image-fallback";

class ProductsSummary extends React.Component {
    constructor(props){
        super(props)
        this.state = {
          searchString: ""
        }
    }

    componentDidMount(){
      cartApi.get()
    }

    updateQuantity = (idProduct, price, minimalQuantity, budgetQuantity, type) => {
      let oldQuantity, newQuantity, quantityArray = new Array()
      oldQuantity = document.getElementById("orderConfirmProducts_"+idProduct).value

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
        cartApi.update(quantityArray, price, oldQuantity, 'orderConfirmProducts_')
      }
      else{
        quantityArray.push(idProduct+"-"+newQuantity)
        cartApi.update(quantityArray, price, oldQuantity, 'orderConfirmProducts_')
      }
    }

    removeProduct(idProduct, idCombination, idCustomization, event){
      cartApi.deleteProduct(idProduct, idCombination, idCustomization)
    }

    filterData(e) {
      this.setState({
        searchString: e.target.value
      })
    }

    render() {
        
        let summaryProducts = this.props.product, searchString = this.state.searchString.trim().toLowerCase();
        
        if(searchString.length > 0){
            // We are searching. Filter the results.
            summaryProducts = summaryProducts.filter(function(l){
                return l.name.toLowerCase().match( searchString );
            });
        }

        return (
            <div className="product-summary">
              <h3 className="block-header">Products Summary</h3>
              <table className="purchase-list-header">
                <thead>
                  <tr>
                    <th className="purchase-list-serial">#</th>
                    <th className="purchase-list-thumb">Product</th>
                    <th className="purchase-list-product-info"><input type="text" placeholder="Search Your Products" onChange={this.filterData.bind(this)}/></th>
                    <th className="purchase-list-quantity">Quantity</th>
                    <th className="purchase-list-total-price">Price</th>
                    <th className="purchase-list-actions text-align-right">Remove</th>
                  </tr>
                </thead>
              </table>
              <Scrollbars className="scroll-table">
                <table className="purchase-list-table">
                  <tbody>
                  {this.props.isFetching ? <tr><td className="fetching medium" colSpan="6"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                    (summaryProducts && summaryProducts.length > 0 ? summaryProducts.map( (product, index) => {
                      var priceTaxInclusive = (product.price_tax_exc * ((product.tax_value / 100) + 1))
                      return(
                        <tr key={index}>
                          <td data-title="Serial" className="purchase-list-serial">{index + 1}</td>
                          <td data-title="Image" className="purchase-list-thumb">
                            <ReactImageFallback
                                src={product[0]}
                                className="image-responsive"
                                fallbackImage="./img/p/en-default-small.jpg"
                                initialImage="./img/p/en-default-small.jpg"
                                alt={product.name}/>
                          </td>
                          <td data-title="Name" className="purchase-list-info"><span onClick={quickView.bind(this, product.id_product, product.id_supplier)}>{product.name}</span><div className="red-color-text">{product.supplier_name}</div></td>
                          <td data-title="QTY" className="purchase-list-quantity">
                            <div className="item-quantity">
                              <span className="quantity-decrement" onClick={this.updateQuantity.bind(this, product.id_supplier+"_"+product.id_product, product.price, product.minimal_quantity, product.available_budget_quantity, 2)}><i className="icon-remove"></i></span>
                              <div id={"parentNodeSummary_"+product.id_supplier+"_"+product.id_product} className="tooltip">
                                <Input className="quantity-value" 
                                       type="number" 
                                       id={"orderConfirmProducts_"+product.id_supplier+"_"+product.id_product} 
                                       inputValue={product.cart_quantity} 
                                       min={product.minimal_quantity}
                                       max={budgetConfigured == 1 ? product.available_budget_quantity : ""}
                                       onBlur={this.updateQuantity.bind(this, product.id_supplier+"_"+product.id_product, product.price, product.minimal_quantity, product.available_budget_quantity, 0)}/>
                                <span className="tooltiptext tooltip-right gray-color-text">Please enter {product.minimal_quantity} or more units.</span>
                              </div>
                              <span className="quantity-increment" onClick={this.updateQuantity.bind(this, product.id_supplier+"_"+product.id_product, product.price, product.minimal_quantity, product.available_budget_quantity, 1)}><i className="icon-add"></i></span>
                            </div>
                          </td>
                          <td data-title="Price" className="purchase-list-total-price"><span id={"finalSummaryTotal_"+product.id_supplier+"_"+product.id_product}>{formatPrice(product.total)}</span></td>
                          <td data-title="Remove" className="purchase-list-actions text-align-right">
                            <span onClick={this.removeProduct.bind(this, product.id_supplier+"_"+product.id_product, product.id_product_attribute, product.id_customization)}><i className="icon-close"></i></span>
                          </td>
                        </tr>
                      )
                    }) : <tr><td><div className="no-results"><h2>Sorry, no products found</h2></div></td></tr>)}
                  </tbody>
                </table>
              </Scrollbars>
            </div>
        )
    }
}

ProductsSummary.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    product: store.cartState.cart,
    isFetching: store.cartState.isFetchingCart
  }
}

export default connect(mapStateToProps)(ProductsSummary)