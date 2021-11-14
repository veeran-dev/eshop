import React, { Component } from 'react'

class RejectOrder extends Component{
	constructor(props){
		super(props)
		this.state = {
			reject_reason: ''
		}
	}

	closeModal(){
		this.setState({ reject_reason: ''}, () => this.props.onClose());
	}

	handleText = (e) => {
		this.setState({ reject_reason: e.target.value });
	}

  	render(){
	  	return (
	  		<div className="modal" tabIndex="-1" id={'rejectOrder'} style={{ 'display': 'flex', 'display': '-webkit-flex'}}>
				<div className={"modal-dialog modal-small animated zoomIn"}>
					<div className="modal-content">
						<div className="modal-header">
							<h4 className="modal-title">Reject Order</h4>
							<button type="button" className="close" onClick={this.closeModal.bind(this)}>
								<i className="icon-close"></i>
							</button>
						</div>
						<div className="modal-body">
							<div id="rejectContent">
								<div className="modal-wrapper">
									<div className="modal-message">
										<p>Are you sure want to reject this order ? If yes, please provide a reason.</p>
										<textarea id="cancel_reason" onChange={this.handleText} defaultValue={this.state.reject_reason} value={this.state.reject_reason} name="cancel_reason" />
									</div>
									<div className="modal-footer">
										<button className="button-red outline" onClick={this.closeModal.bind(this)}>No</button>
										<button className="button-red" onClick={this.props.onClick}>Yes</button>
									</div>
								</div>
							</div>
						</div>		  
					</div>
				</div>
			</div>
		)
	}
}

export default RejectOrder