import React from 'react'
import * as G from '../../api/common-api'
import * as addressApi from '../../api/address-api'
import store from '../../store/configureStore'
import Input from '../../components/common/Input'
import { Link } from 'react-router'
import Ripples from 'react-ripples'
import { Scrollbars } from 'react-custom-scrollbars';
import validateQuoteForm from './helpers/Validation';

const validationConfigs = {
	form: "addressView",
	rules: {
        alias: { required: true },
        contact_person: { required: true },
        company_name: { required: true },
        address_line: { required: true },
        pincode: { required: true, numeric: true, maxlength: "999999" },
        city: { required: true },
        state: { required: true },
        mobile: { required: true, numeric: true, mobile: true }
    },

    messages: {
        alias: {
            required: "Please provide address name."
        },
        contact_person: {
            required: "Please provide contact person name."
        },
        company_name: {
            required: "Please provide company name."
        },
        address_line: {
            required: "Please provide address."
        },
        pincode: {
            required: "Please provide pin-code.",
            numeric: "Please provide numeric value.",
            maxlength: "Please provide 6 digit pin-code."
        },
        city: {
            required: "Please provide city name."
        },
        state: {
            required: "Please select state."
        },
        mobile: {
            required: "Please provide mobile number.",
            numeric: "Please provide numeric value.",
            mobile: "Please provide valid mobile number"
        }
    }
}

// Listing orders for approval purpose
class  AddressView extends React.Component{
	constructor(props){
		super(props)
		this.state = {
			errors: {}
		}
	}

	isValid() {
	    const { errors, isValid } = validateQuoteForm(validationConfigs);
	    if (!isValid)
	      this.setState({ errors });
	  	else
	  	  this.setState({ errors: {} })
	    return isValid;
	}

	submitAddress(e){
		e.preventDefault();
		if (this.isValid()){
			addressApi.add("addressAdd")
		}
	}

	render(){
		const { errors } = this.state;
	  	return (
		    <div className="add-address">
		        <Scrollbars
					autoHide
			        // Hide delay in ms
			        autoHideTimeout={1000}
			        // Duration for hide animation in ms.
			        autoHideDuration={200}
                	style={{ height: 412}}>
                	{ errors && <div>{errors.global}</div> }
			        <form id="addressAdd" onSubmit={this.submitAddress.bind(this)}>
					<div className="modal-wrapper">
			        	<div className="step double-column">
							<div className="form-group">
								<div className="form-control">
									<Input name="alias" id="alias" inputValue={""} type="text" placeholder="Address Name" />
								</div>
								{errors && <p className="error">{errors.alias}</p>}
							</div>
							<div className="form-group">
								<div className="form-control">
									<Input name="company_name" id="company_name" inputValue={""} type="text" placeholder="Company Name" />
								</div>
								{errors && <p className="error">{errors.company_name}</p>}
							</div>
						</div>
						<div className="step double-column">
							<div className="form-group">
								<div className="form-control">
									<Input name="contact_person" id="contact_person" inputValue={""} type="text" placeholder="Contact Person Name" />
								</div>
								{errors && <p className="error">{errors.contact_person}</p>}
							</div>
							<div className="form-group">
								<div className="form-control">
									<Input name="mobile" id="mobile" inputValue={""} type="text" placeholder="Pin-Code" />
								</div>
								{errors && <p className="error">{errors.mobile}</p>}
							</div>
						</div>
						<div className="step">
							<div className="form-group">
								<div className="form-control">
									<textarea name="address_line" id="address_line" cols="30" rows="10" placeholder="Enter your address">{""}</textarea>
								</div>
								{errors && <p className="error">{errors.address_line}</p>}
							</div>
						</div>
						<div className="step double-column">
							<div className="form-group">
								<div className="form-control">
									<Input name="pincode" id="pincode" inputValue={""} type="text" placeholder="Enter your Pin-Code" />
								</div>
								{errors && <p className="error">{errors.pincode}</p>}
							</div>
							<div className="form-group">
								<div className="">
									<div className="form-control">
										<Input name="city" id="city" inputValue={""} type="text" placeholder="Enter your city" />
									</div>
								</div>
								{errors && <p className="error">{errors.city}</p>}
							</div>
						</div>
						<div className="step double-column">
							<div className="form-group">
								<div className="form-control">
									<select name="country" id="country">
										<option value="110" selected>India</option>
									</select>
								</div>
							</div>
							<div className="form-group">
								<div>
									<div className="form-control">
										<select name="state" id="state">
											<option value="">Select State</option>
											{this.props.states.map((state, i) => {
												return(
													<option value={state.id_state} key={i}>{state.name}</option>
												)
											})}
										</select>
									</div>
								</div>
								{errors && <p className="error">{errors.state}</p>}
							</div>
						</div>

						</div>
						<div className="modal-footer">
						<Input type="hidden" name="id_address" inputValue={""} />
						<Input type="hidden" name="type" inputValue={2} />
						<button className="button-red">Submit</button>
						</div>
			        </form>
			    </Scrollbars>
		    </div>
		)
	}
}

export default AddressAdd