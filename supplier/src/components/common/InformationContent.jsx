import React from 'react'
import * as G from '../../api/common-api'

class InformationContent extends React.Component{
	constructor(props){
		super(props)
  }
  close(){
    G.closeModal(["inform"])
  }

  	render(){
      return(
        <div className="modal-wrapper">
          <div className="modal-message">
            <p>{this.props.message}</p>
          </div>
          <div className="modal-footer">
            <button className="button-blue outline" onClick={this.close.bind(this)}>Okay</button>
          </div>
        </div>
      )
    }
}

export default InformationContent