import React from 'react'
import * as G from '../../api/common-api'
import store from '../../store/configureStore'
import { Link } from 'react-router'
import Ripples from 'react-ripples'
import PoOrderItem from './poOrderItem'
import Pie from '../views/reports/chart-types/Pie'
import moment from 'moment'

// Listing orders for approval purpose
class PoDetail extends React.Component{
	constructor(props){
		super(props);
	}
	closeModal(){
	    document.body.className = document.body.className.replace('modal-open',"");
	    var modal = document.getElementById('poDetail');
	    modal.style.display = 'none';
	}
	render(){
		const { data } = this.props
	  	return (
		    <div className="modal-wrapper">
		    	<div className="po-information-wrapper">
					<h3 className="section-title">Information</h3>
					<div className="po-information">
						<div className="po-address">
							<div className="po-inline-wrapper">
								<p>PO Number</p> 
								<p>:</p> 
								<p>{data.po.po_number}</p>
							</div>
							<div className="po-inline-wrapper">
								<p>Address</p>
								<p>:</p>
								<p>
									{data.poAddress[0].alias}<br/>
									{data.poAddress[0].company}<br/>
									{data.poAddress[0].address1}<br/>
									{data.poAddress[0].city}, {data.poAddress[0].postcode}<br/>
									{data.poAddress[0].state}, {data.poAddress[0].country}<br/>
									{data.poAddress[0].phone_mobile}
								</p>
							</div>
						</div>
						<div className="po-dates">
							<div className="po-inline-wrapper">
								<p>PO Date</p> <p>:</p> <p>{moment(data.po.po_date).format('LL')}</p>
							</div>
							<div className="po-inline-wrapper">
								<p>Valid From</p> <p>:</p> <p>{moment(data.po.valid_from).format('LL')}</p>
							</div>
							<div className="po-inline-wrapper">
								<p>Valid Through</p> <p>:</p> <p>{moment(data.po.valid_through).format('LL')}</p>
							</div>
						</div>
					</div>
			    </div>
			    <div className="po-list">
					<h3 className="section-title">{data.poOption == 1 ? "Products List" : "Budget"}</h3>
			    	{data.poOption == 1 ?
			 			<div className="poDetailProducts">
			 				<table>
			 					<thead>
			 						<tr>
			 							<th>#</th>
			 							<th>Reference</th>
			 							<th>Product</th>
			 							<th>Allowed Qty</th>
			 							<th>Consumed Qty</th>
			 						</tr>
			 					</thead>
			 					<tbody>
			 						{data.poDetails.map((po, i) => {
					 					return (
					 						<tr key={i}>
					 							<td>{i+1}</td>
					 							<td>{po.reference}</td>
					 							<td>{po.name}</td>
					 							<td>{po.quantity}</td>
					 							<td>{po.consumed_quantity}</td>
					 						</tr>
					 					)
					 				})}
			 					</tbody>
			 				</table>
			 			</div>	
			    	:
			    		<div className="spend-details po-information-wrapper">
			    			<div className="spend-data">
								<div className="po-inline-wrapper">
									<p>Total Expense Limit</p> <p>:</p> <p>{G.formatPrice(data.poDetails[0].value)}</p>
								</div>
								<div className="po-inline-wrapper">
									<p>Spent</p> <p>:</p> <p>{G.formatPrice(data.poDetails[0].consumed_value)}</p>
								</div>
								<div className="po-inline-wrapper">
									<p>Balance</p> <p>:</p> <p><strong>{G.formatPrice(data.poDetails[0].value - data.poDetails[0].consumed_value)}</strong></p>
								</div>
			    			</div>
							<Pie 
								total={data.poDetails[0].value} 
								consumed={data.poDetails[0].consumed_value} 
							/>
			    		</div>
			    	}
			    </div>
			    <div className="po-history">
					<h3 className="section-title">Order History</h3>
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Date</th>
								<th>Total</th>
								<th className="text-align-right">DETAILS</th>
							</tr>
						</thead>
					</table>
			    	{data.poHistory && data.poHistory.length ? 
			    		(data.poHistory.map((history, i) => {
			    			return (
			    				<div key={i}>
									<PoOrderItem 
										id={history.id_order}
										date={history.ordered_date} 
										total={G.formatPrice(history.total_spent)}
									/>
			    					<div className="po-order-products">
			    						<table>
			    							<thead>
			    								<tr>
			    									<th>#</th>
			    									<th>Reference</th>
			    									<th>Product</th>
			    									<th>Unit Price</th>
			    									<th>Quantity</th>
			    									<th>Total Price (TAX INCL.)</th>
			    								</tr>
			    							</thead>
			    							<tbody>
			    								{Object.keys(history.products).map((product, j) => {
					    							return (
					    								<tr key={j}>
					    									<td>{j+1}</td>
					    									<td>{history.products[product].reference}</td>
					    									<td>{history.products[product].name}</td>
					    									<td>{G.formatPrice(history.products[product].unit_price_tax_incl)}</td>
					    									<td>{history.products[product].product_quantity}</td>
					    									<td>{G.formatPrice(history.products[product].total_wt)}</td>
					    								</tr>
					    							)
					    						})}
			    							</tbody>
			    						</table>
			    					</div>
			    				</div>
			    			)
			    		}))
			    	: null}
			    </div>
				<div className="modal-footer">
					<button className="button" onClick={this.closeModal.bind(this)}>Close</button>
				</div>
		    </div>
		)
	}
}

export default PoDetail