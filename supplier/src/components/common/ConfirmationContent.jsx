import React from 'react'
import * as G from '../../api/common-api'

class ConfirmationContent extends React.Component{
	constructor(props){
		super(props)
  }
  close(){
    G.closeModal(["confirm"])
    this.props.onCancel();
    
  }

  	render(){
      return(
        <div className="modal-wrapper">
          <div className="modal-message">
            <p>{this.props.message}</p>
            {this.props.warning ?<p className="warning">{this.props.warning}</p>:null}
          </div>
          <div className="modal-footer">
            <button className="button-red outline" onClick={this.close.bind(this)}>No</button>
            <button className="button-red" onClick={this.props.onClick}>Yes</button>
          </div>
        </div>
      )
    }
}

export default ConfirmationContent