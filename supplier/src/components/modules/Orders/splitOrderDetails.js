import React from 'react'
const splitOrderDetails=(props)=>{
	console.log(props);
  return (
  			<div className="modal-wrapper">
				<div className="modal-message">
			        <table>
			          <thead>
			            <tr>
			              <th>Order</th>
			              <th>Order ID</th>
			              <th>Products</th>
			            </tr>
			          </thead>
			          <tbody>
			          <tr>
			          	<td>New Order</td>
			          	<td>{props.newOrder}</td>
			          	<td>{props.newOrderProducts}</td>
			          </tr>
			          <tr>
			          	<td>Old Order</td>
			          	<td>{props.oldOrder}</td>
			          	<td>{props.oldOrderProducts}</td>
			          </tr>
			          </tbody>
			        </table>
			    </div>
		    </div>
  	)
}

export default splitOrderDetails;