import React from 'react'
import * as G from '../../api/common-api'

class Message extends React.Component{
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
            <button className="button-red" onClick={G.closeModal.bind(this, ["messagePop"])}>Ok</button>
          </div>
        </div>
      )
    }
}

export default Message