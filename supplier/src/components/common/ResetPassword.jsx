import React from 'react'
import {resetPassword} from '../../api/auth-api'
import * as G from '../../api/common-api'

class ResetPassword extends React.Component{
  reset=(e)=>{
    e.preventDefault();
    let email = this.email.value;
    resetPassword(email);

  }
  render(){
  return (
        <div className="modal-wrapper">
          <div className="modal-message">
            <div className="form-group">
              <div className="form-control">
                <input ref={(node) => {this.email = node}} type="text" placeholder="Enter Email ID" />
              </div>
            </div>
          </div>
          <div className="modal-footer">
            <button className="button-blue outline" onClick={G.closeModal.bind(this, ["resetPassword"])}>No</button>
            <button className="button-blue" onClick={this.reset.bind(this)}>Yes</button>
          </div>
        </div>
    )
  }
}

export default ResetPassword;