import React from 'react'
import * as G from '../../api/common-api'

class ConfirmationContent extends React.Component{
	constructor(props){
		super(props)
	}

  	render(){
      return(
        <div className="modal-wrapper">
          <div className="modal-message">
            <p>{this.props.message}</p>
          </div>
          <div className="modal-footer">
            <button className="button-red outline" onClick={G.closeModal.bind(this, ["confirmationPop"])}>No</button>
            <button className="button-red" onClick={this.props.onClick}>Yes</button>
          </div>
        </div>
      )
    }
}

export default ConfirmationContent