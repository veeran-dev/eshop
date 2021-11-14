import React from 'react'
import * as G from '../../api/common-api'
import store from '../../store/configureStore'
import { Link } from 'react-router'
import Ripples from 'react-ripples'

// Listing orders for approval purpose
class  OrderView extends React.Component{
	constructor(props){
		super(props)
	}

	render(){
		
	  	let orderStatusFlow = this.props.data[0]
	  	let products = this.props.data[3]
		let taxType = this.props.data[4]
		let orderSummary = this.props.data[5]
		let billingAddress = this.props.data[1]
	    let deliveryAddress = this.props.data[2]

	  	return (
		    <div className="modal-wrapper">
		        <div className="order-flow-container">
		        	<h3 className="section-title">Order flow</h3>
		        	<div className="order-flow">
			        	{orderStatusFlow.map((data, i) => {
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
		    							{orderStatusFlow.length-1 !== i ? <div className="animate-span drawLine"></div> : null}
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
			              {products.map((data, i) => {
			                return(
			                  <tr key={i}>
			                    <td data-title="Order ID">{i+1}</td>
			                    <td data-title="Reference">{data.product_reference}</td>
			                    <td data-title="Product"><span className="data-overflow">{data.product_name}</span></td>
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
			            <p>Discounted Amount({ taxType == 1 ? "Tax Incl." : "Tax Excl."}): <span>{G.formatPrice(orderSummary.total_discounts)}</span></p>
			            <p>Total Amount({ taxType == 1 ? "Tax Incl." : "Tax Excl."}): <span>{G.formatPrice(orderSummary.total_paid)}</span></p>
			        </div>
		        </div>
		        <div className="address-section">
		            <div>
		              <h3 className="section-title">Billing Address</h3>
		              {billingAddress.map((data, i) => {
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
		              {deliveryAddress.map((data, i) => {
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
				<div className="modal-footer">
	            	<button className="button-green" onClick={this.props.reOrder.bind(this, orderSummary.id_order, store.getState().cartState.cart, this.props.routers)}>
	        			Reorder
	        		</button>
	         	</div>      
		    </div>
		)
	}
}

export default OrderView