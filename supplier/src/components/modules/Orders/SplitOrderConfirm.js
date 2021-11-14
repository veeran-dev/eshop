import React from 'react'
const orderHistory=(props)=>{
	console.log(props.history);
	console.log(props.history.length);
  return (
  			<div className="modal-wrapper">
				<div className="modal-message">
			        <table>
			          <thead>
			            <tr>
			              <th>Product Name</th>
			              <th>Reasons</th>
			            </tr>
			          </thead>
			          <tbody>
			          {props != undefined && props.history.map(function(history){
					  		return(
					  			<tr key={history.ostate_name}>
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