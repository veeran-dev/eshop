import React from 'react'

class RejectOrder extends React.Component{
	constructor(props){
		super(props)
	}

	closeModal(){
		document.body.className = document.body.className.replace('modal-open',"");
	    document.getElementById("rejectOrder").style.display = "none";
	}

  	render(){
	  	return (
			<div className="modal-wrapper">
				<div className="modal-message">
					<p>Are you sure want to reject this order ? If yes, please provide a reason.</p>
					<textarea id="cancel_reason" name="cancel_reason"></textarea>
				</div>
				<div className="modal-footer">
					<button className="button-red outline" onClick={this.closeModal.bind(this)}>No</button>
					<button className="button-red" onClick={this.props.onClick}>Yes</button>
				</div>
			</div>
		)
	}
}

export default RejectOrder