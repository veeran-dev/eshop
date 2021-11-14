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
					{this.props.data.map((data, i) => {
		        		return(
		        			<button className="button-blue" key={i} onClick={this.props.onClick.bind(this, data.id_payment, this.props.orderID, this.props.dashboard, this.props.router)}>{data.payment_name}</button>
		        		)
		        	})}
		        	<input type="hidden" id={"idOrder"} value=""/>
				</div>
			</div>
		)
	}
}

export default ApprovalPaymentOption