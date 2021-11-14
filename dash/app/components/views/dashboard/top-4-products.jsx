import React from 'react';
import ReactDOM from 'react-dom';
import { connect } from 'react-redux';
import {toastr} from 'react-redux-toastr'
import * as dashboardApi from '../../../api/dashboard-api'
import * as G from '../../../api/common-api'
import * as cartApi from '../../../api/cart-api'
import store from '../../../store/configureStore';
import Input from '../../../components/common/Input'

class Top4Products extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      fromDate: "",
      toDate: "",
      duration: 5
    }
  }

  componentDidMount() {
  	dashboardApi.getTop4Products(this.state.fromDate, this.state.toDate, this.state.duration)
  }

  updateQuantity = (idProduct, minimalQuantity, budgetQuantity, type) => {
    let oldQuantity, newQuantity
    oldQuantity = document.getElementById("top4Product_"+idProduct).value

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
    else if(budgetConfigured == 1 && budgetOption == 1 && newQuantity > budgetQuantity) {
      toastr.error('Error', "You can't add more than PO Balance.", {icon: 'icon-error'});
      document.getElementById("top4Product_"+idProduct).value = budgetQuantity;
    }
    else{
      document.getElementById("top4Product_"+idProduct).value = newQuantity
    }
  }

  render() {
    return <div className="widget top-4-products">
					<div className="widget-header">
            <h3>Top 4 Products</h3>
            <button className="close" onClick={G.uninstallWidget.bind(this, this.props.widgetId)}><i className="icon-close"></i></button>
          </div>
    			<table className="widget-compressed-table">
    				<thead>
            <tr>
    					<th>Product</th>
    					<th>&nbsp;</th>
    					<th>Quantity</th>
    					<th>Action</th>
            </tr>
    				</thead>
    				<tbody>
    					{this.props.isFetching ? <tr><td className="fetching small" colSpan="4"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                (this.props.top4Products && this.props.top4Products.length ? this.props.top4Products.map((data, i) => {
      						if(i <= 3){
  	    						return(
  		    							<tr key={i}>
  		    								<td data-title="Product"><img src={data.imageLink} alt={data.name} /></td>
  		    								<td data-title="Price">
  		    									<p className="product-name"><span onClick={G.quickView.bind(this, data.id_product)}>{data.name}</span></p>
  		    									<p className="product-price">{G.formatPrice(data.price)}</p>
  		    								</td>
                          <td data-title="Quantity">
                            <div className="item-quantity">
                              <span className="quantity-decrement" onClick={this.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.available_budget_quantity, 2)}>
                                <i className="icon-remove"></i>
                              </span>
                              <span id={"top4QuantityParent_"+data.id_product}>
                                <Input type="number" 
                                       min={data.minimal_quantity}
                                       max={budgetConfigured == 1 && data.available_budget_quantity ? data.available_budget_quantity : ""}
                                       id={"top4Product_"+data.id_product} 
                                       className="quantity-value" 
                                       inputValue={data.minimal_quantity}
                                       onBlur={this.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.available_budget_quantity, 0)}/>
                              </span>
                              <span className="quantity-increment" onClick={this.updateQuantity.bind(this, data.id_product, data.minimal_quantity, data.available_budget_quantity, 1)}>
                                <i className="icon-add"></i>
                              </span>
                            </div>
                          </td>
  		    								<td data-title="Actions">
                            <div className="tooltip-container">
                              <button 
                              className={"button-black has-tooltip "+ (budgetConfigured == 1 && budgetOption == 1 && !data.budget_product ? " disabled-light" : "")} 
                              type="button" 
                              onClick={G.addToCart.bind(this, data.id_product, "top4Product", 1, data.minimal_quantity, this.context.router)}>
                              Buy Now 
                              {budgetConfigured == 1 && budgetOption == 1 && !data.budget_product && 
                                <span className="tooltip-wrapper">
                                  <span className="tooltippy">This product is not available in your Purchase Order.</span>
                                </span>
                              }
                              </button>
                            </div>
                            <div className="tooltip-container">
                              <button className={"button-black has-tooltip outline"+ (budgetConfigured == 1 && budgetOption == 1 && !data.budget_product ? " disabled-light" : "")} 
                              type="button" 
                              onClick={G.addToCart.bind(this, data.id_product, "top4Product", 0, data.minimal_quantity, false)}>
                              Add to Cart 
                              {budgetConfigured == 1 && budgetOption == 1 && !data.budget_product && 
                                <span className="tooltip-wrapper">
                                  <span className="tooltippy">This product is not available in your Purchase Order.</span>
                                </span>
                              }
                              </button>
                            </div>
                          </td>
  		    							</tr>
  		    					)
  		    				}
      					}) : <tr className="no-results-wrapper"><td colSpan="4"><div className="no-results small"><h2>No Data Found!</h2></div></td></tr>)
            }
    				</tbody>
    			</table>
    	   </div>
  }
}

Top4Products.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
  	top4Products: store.dashboardState.top4Products,
    isFetching: store.dashboardState.isFetchingTop4Products
  };
};

export default connect(mapStateToProps)(Top4Products);