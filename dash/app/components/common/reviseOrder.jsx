import React from 'react'

class ReviseOrder extends React.Component{
	constructor(props){
		super(props)
	}

	closeModal(){
		document.body.className = document.body.className.replace('ReactModal__Body--open',"");
	    document.getElementById("reviseOrder").style.display = "none";
	}

  	render(){
	  	return (
			<div className="modal-wrapper">
				<div className="modal-message">
					<p>By revising the order you could add or remove products, but finally a new order would be placed on behalf of this order.</p>
				</div>
				<div className="modal-footer">
		        	<button className="button-red outline" onClick={this.closeModal.bind(this)}>No</button>
					<button className="button-red" onClick={this.props.onClick}>Yes</button>
				</div>
			</div>
		)
	}
}

export default ReviseOrder