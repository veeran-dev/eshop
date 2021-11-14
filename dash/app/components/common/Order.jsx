import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import store from '../../store/configureStore'
import * as orderApi from '../../api/orders-api'
import * as G from '../../api/common-api'
import Input from '../../components/common/Input'
import Ripples from 'react-ripples';

class Order extends React.Component {
  constructor(props){
    super(props)
  }

  componentDidMount() {
    this.getOrderData(this.props.params.id, 0, 0, true)
  }

  getOrderData(id, deliveryAddress, invoiceAddress, type) {
    orderApi.getById(id, deliveryAddress, invoiceAddress, type)
  }

  reOrder(orderID, cart, route) {
    G.reOrderView(orderID, cart, route)
  }

  componentWillReceiveProps(newProps) {
    if(newProps.params.id != this.props.params.id){
      this.getOrderData(newProps.params.id, 0, 0, true)
    }
  }

  render(){
    return (
      <div className="view-order-details">
        <div className="page-header">
          <button className="back" onClick={this.context.router.goBack.bind(this)}>
					  <i className="icon-back-arrow"></i>
				  </button>
					<h3 className="page-title">Order Details <span className="gray-color-text">(#{this.props.params.id})</span></h3>
					<div className="action-block">
            {/*<Ripples><button className="button-red outline" onClick={G.openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
          </div>
				</div>
        <div className="page-container">
            <div className="order-flow-container">
              <h3 className="section-title">Order flow</h3>
              <div className="order-flow">
                {this.props.dataFlow.map((data, i) => {
                  return(
                    <div key={i} className="status">
                      <div className="status-info">
                        <div className="status-icon">
                          <img src={"img/statusIcon/32/"+data.id_order_state+".png"} alt={data.name} />
                        </div>
                      
                      <div className="status-name">
                        <span>{data.name}</span>
                      </div>
                    </div>
                    <div className="connector">
                      {this.props.dataFlow.length-1 !== i ? <div className="animate-span drawLine"></div> : null}
                    </div>
                    </div>
                  )
                })}
              </div>
              <div style={{'clear': 'both'}}></div>
            </div>
             <div className="product-details-container">
                <h3 className="section-title">Product Details</h3>
                <div className="table-wrapper">
                  <table className="widget-compressed-table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                      </tr>
                    </thead>
                    <tbody>
                    {this.props.products.map((data, i) => {
                      return(
                        <tr key={i}>
                          <td data-title="#">{i+1}</td>
                          <td data-title="Reference">{data.product_reference}</td>
                          <td data-title="Product">{data.product_name}</td>
                          <td data-title="Quantity">{data.product_quantity}</td>
                          <td data-title="Unit Price">{G.formatPrice(data.product_price_wt)}</td>
                          <td data-title="Total Price">{G.formatPrice(data.total_wt)}</td>
                        </tr>
                      )
                    })}
                    </tbody>
                  </table>
              </div>
              <div className="order-total">
                  <p>Discounted Amount({ this.props.orderPageTax == 1 ? "Tax Incl." : "Tax Excl."}): <span>{G.formatPrice(this.props.orderSummary.total_discounts)}</span></p>
                  <p>Total Amount({ this.props.orderPageTax == 1 ? "Tax Incl." : "Tax Excl."}): <span>{G.formatPrice(this.props.orderSummary.total_paid)}</span></p>
              </div>
            </div>
            <div className="address-section">
                <div>
                  <h3 className="section-title">Billing Address</h3>
                  {this.props.billingAddress.map((data, i) => {
                    return(
                        <div key={i}>
                          <div>{data.firstname}</div>
                          <div>{data.address1}</div>
                          <div>{data.city}</div>
                          <div>{data.state}</div>
                          <div>{data.postcode}</div>
                          <div>{data.country}</div>
                          <div>{data.phone_mobile}</div>
                        </div>
                    )
                  })}
                </div>
                <div>
                  <h3 className="section-title">Delivery Address</h3>
                  {this.props.deliveryAddress.map((data, i) => {
                    return(
                        <div key={i}>
                          <div>{data.firstname}</div>
                          <div>{data.address1}</div>
                          <div>{data.city}</div>
                          <div>{data.state}</div>
                          <div>{data.postcode}</div>
                          <div>{data.country}</div>
                          <div>{data.phone_mobile}</div>
                        </div>
                    )
                  })}
                </div>
            </div>
            
            <div className="view-order-details cta">
              <button className="button-green" onClick={this.reOrder.bind(this, this.props.orderSummary.id_order, store.getState().cartState.cart, this.context.router)}>Reorder</button>
            </div>
            </div>
      </div>
    )
  }
}

Order.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    dataFlow: store.orderState.orderPageDataFlow,
    products: store.orderState.orderPageProducts,
    orderSummary: store.orderState.orderPageSummary,
    orderPageTax: store.orderState.orderPageTax,
    billingAddress: store.orderState.billingAddress,
    deliveryAddress: store.orderState.shippingAddress
  }
}

export default connect(mapStateToProps)(Order)