import React from 'react'
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import * as commonApi from '../../../api/common-api'
import store from '../../../store/configureStore'

class Feedback extends React.Component {
    constructor(props){
        super(props)
        this.state = {
          initialContent: true,
          successFeedback: false,
          unsuccessFeedback: false,
          successText: "",
          unsuccessText: "",
          response: 0
        }
    }

    successFeedback() {
      this.setState({
        successFeedback: true,
        initialContent: false,
        unsuccessFeedback: false
      })
    }

    unsuccessFeedback() {
      this.setState({
        successFeedback: false,
        initialContent: false,
        unsuccessFeedback: true
      })
    }

    changeHandle(e) {
      this.setState({
        [e.target.name]: e.target.value
      })
    }

    submitFeedback(type) {
      commonApi.submitFeedback(this, type);
    }

    render() {
        return (
           <div className="feedback">
            <div className="page-header">
              <button className="back" onClick={this.context.router.goBack.bind(this)}>
                <i className="icon-back-arrow"></i>
              </button>
              <h3 className="page-title">Feedback</h3>
            </div>
            <div className="page-container">
              {this.state.initialContent ? 
                <div className="feedback-question">
                  <h1>How did you find our service?</h1>
                  <div className="feedback-options">
                    <a className="happy" href="javascript:void(0)" onClick={this.successFeedback.bind(this)}>
                      <img src="dash/img/smiles/happy.png" alt="happy"/>
                      <span className="gray-color-text">Loved it. Thanks!</span>
                    </a>
                    <a className="sad" href="javascript:void(0)" onClick={this.unsuccessFeedback.bind(this)}>
                      <img src="dash/img/smiles/sad.png" alt="sad" />
                      <span className="gray-color-text">It was bad! Sorry.</span>
                    </a>
                  </div>
                </div>
              : (this.state.successFeedback ? 
                  <div className="feedback-info">
                    <h3>Glad that you loved our service.<br></br>Thank you!</h3>
                    <textarea name="successText" ref="successFeedback" onChange={this.changeHandle.bind(this)} placeholder="We would love to hear more about this from you.">
                      {this.state.successText}
                    </textarea>
                    <button className="button-blue " type="button" onClick={this.submitFeedback.bind(this, 1)}>SUBMIT FEEDBACK</button>
                  </div> 
                  : (this.state.unsuccessFeedback ? 
                      <div className="feedback-info">
                        <h3>Sorry that you had to go through this experience. We'll address it shortly!</h3>
                        <textarea name="unsuccessText" ref="unsuccessFeedback" onChange={this.changeHandle.bind(this)} placeholder="Help us understand more about your concern.">
                          {this.state.unsuccessText}
                        </textarea>
                        <button className="button-blue" type="button" onClick={this.submitFeedback.bind(this, 2)}>SUBMIT FEEDBACK</button>
                      </div>
                  : null))}
              <div className="response">
                {this.state.response == 1 ?
                  <div className="feedback-info feedback-success empty-state">
                    <div className="empty-state-thumb not-installed"></div>
                    <h3>Glad that you loved our service. Thank you!</h3>
                    <p>Your feedback will help us to serve you more better.</p>
                  </div> 
                : (this.state.response == 2 ? 
                  <div className="feedback-info feedback-success empty-state">
                    <div className="empty-state-thumb not-installed"></div>
                    <h3>Sorry that you had to go through this experience. We'll reddress it shortly! </h3>
                    <p>Your feedback will help us to serve you more better.</p>
                  </div> 
                : null)
                }
              </div>
            </div>
           </div>
        )
    }
} 

Feedback.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {}
}

export default connect(mapStateToProps)(Feedback)