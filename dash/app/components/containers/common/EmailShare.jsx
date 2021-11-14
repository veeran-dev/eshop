import React from 'react';
import axios from 'axios';
import Ripples from 'react-ripples';
import { Scrollbars } from 'react-custom-scrollbars';
import Input from './Input'
import * as G from '../../api/common-api'
import validateQuoteForm from './helpers/Validation'

const validationConfigs = {
	form: "mailShare",
	rules: {
        mailTo: {
            required: true
        }
    },

    messages: {
        mailTo: {
            required: "Please provide email."
        }
    }
}

class EmailShare extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			errors: {},
			mailTo: "",
			mailMessage: "",
		}
	}

	onChange(e){
		this.setState({[e.target.name]: e.target.value})
	}

	isValid() {
	    const { errors, isValid } = validateQuoteForm(validationConfigs);
	    if (!isValid)
	      this.setState({ errors });
	  	else
	  	  this.setState({ errors: {} })
	    return isValid;
	}

	onSubmit(e){
		e.preventDefault();
		if (this.isValid()){
			this.props.mailTo()
		}
	}

	render() {
		const { errors } = this.state;
		return (
			<div className="modal-wrapper">
				<form id="mailShare" onSubmit={this.onSubmit.bind(this)}>
					<div className="modal-wrapper">
						<div className="step">
						<div>
							<div className="form-group">
								<div className="form-control">
									<Input name="mailTo" id="mailTo" inputValue={""} type="text" placeholder="E-mail" />
								</div>
							</div>
						</div>
						{errors && <p className="error">{errors.mailTo}</p>}
						</div>
						<div className="step">
							<div className="form-group">
								<div className="form-control">
									<textarea name="mailMessage" id="mailMessage" cols="30" rows="10" onChange={this.onChange.bind(this)} placeholder="Message">{this.state.mailMessage}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div className="modal-footer">
						<button type="submit" className="button-red">Submit</button>
					</div>
				</form>
			</div>
		)
	}
}

export default EmailShare;