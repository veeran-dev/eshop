import React from 'react'

class ApprovalPaymentOption extends React.Component{
	constructor(props){
		super(props)
	}
	render(){
	  	return (
			<div className="modal-wrapper">
				<div className="modal-message">
					<p>Please choose your favourite mode of payment.</p>
				</div>
				<div className="modal-footer">
				{this.props.data && this.props.data.length > 0 ?
					(this.props.data.map((data, i) => {
		        		return (
		        			data.id_payment != 7 ? 
		        				<button 
			        				className="button-blue" 
			        				key={i} 
			        				onClick={this.props.onClick.bind(this, data.id_payment, this.props.orderID, this.props.dashboard, this.props.router, "")}>
			        				{data.payment_name}
			        			</button> :
			        		(data.id_payment == 7 && this.props.epaylaterEligibility &&
			        			<button 
			        				className="button-blue" 
			        				key={i} 
			        				onClick={this.props.onClick.bind(this, data.id_payment, this.props.orderID, this.props.dashboard, this.props.router, this.props.epayLaterId)}>
			        				{data.payment_name}
			        			</button>
			        		)
		        		)
		        	})) : 
                    (this.props.data.saleStatus == 0 ? <div>Sorry we are not taking order from 28th JUNE to 5th MAY due to GST implementations</div> : <div>No payment modes found.</div>)
				}
		        	<input type="hidden" id={"idOrder"} value=""/>
				</div>
			</div>
		)
	}
}

export default ApprovalPaymentOption