import React from 'react'
const orderHistory=(props)=>{
	let history = [];
	history = props.history;
  return (
  			<div className="modal-wrapper">
				<div className="modal-message">
			        <table>
			          <thead>
			            <tr>
			              <th>Order Status</th>
			              <th>Date</th>
			            </tr>
			          </thead>
			          <tbody>
			          {props != undefined && history.map(function(history, i){
					  		return(
					  			<tr id={history.ostate_name+"_"+i} key={history.ostate_name+"_"+i}>
					  				<td>{history.ostate_name}</td>
					  				<td>{history.date_add}</td>
				  				</tr>)
					  	})}
			          </tbody>
			        </table>
			    </div>
		    </div>
  	)
}

export default orderHistory;