import React from 'react'
import { connect } from 'react-redux';
import serialize from 'form-serialize'

import * as G from '../../../api/common-api'
import {addSupplierAddress, addSupplierAddressOnReg} from '../../../api/address-api'
import store from '../../../store/configureStore'
import Input from '../../../components/common/Input'
import validateQuoteForm from '../../common/helpers/Validation';

const validationConfigs = {
	form: "addressAdd",
	rules: {
        alias: { required: true },
        gst: { required: true, isGst: true },
        contact_person: { required: true, string: true },
        company_name: { required: true },
        address_line: { required: true, isAddress: true },
        pincode: { required: true, numeric: true, maxlength: "999999" },
        city: { required: true },
        state: { required: true },
        mobile: { required: true, numeric: true, mobile: true }
    },

    messages: {
        alias: {
            required: "Please provide address name."
        },
        gst: {
        	required: "Please provide GST number.",
        	isGst: 'Please enter valid GST number'
        },
        contact_person: {
            required: "Please provide contact person name.",
            string: "Please provide alphabets only."
        },
        company_name: {
            required: "Please provide company name."
        },
        address_line: {
            required: "Please provide address.",
            isAddress: "Please avoid special characters"
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
class  AddAddress extends React.Component{
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
			let addressForm = document.querySelector('#addressAdd');
			let data = serialize(addressForm, { hash: false });
			if(this.props.onReg != undefined && this.props.onReg == 1){
				addSupplierAddressOnReg(data)
			}
			else{
				addSupplierAddress(data);
			}
			addressForm.reset()
		}
	}

	render(){
		const { errors } = this.state;
		let stateData = this.props.allStates
	  	return (
		    <div className="edit-address">
		    {this.props.isFetching == true ? <div className="loader"><div className="spinner"></div></div> : null}
		    		<div className="address-header">
		    			<h1>Add Address</h1>
		    			<span>Step 2/2</span>
		    		</div>
                	{ errors && <div>{errors.global}</div> }
			        <form id="addressAdd" onSubmit={this.submitAddress.bind(this)}>
					<div className="modal-wrapper">
			        	<div className="step double-column">
							<div className="form-group">
								<div className="form-control">
									<Input name="alias" id="alias" maxLength={61} inputValue={""} type="text" placeholder="Address Name" />
								</div>
								{errors && <p className="error">{errors.alias}</p>}
							</div>
							<div className="form-group">
								<div className="form-control">
									<Input name="company" maxlength={64} id="company_name" inputValue={""} type="text" placeholder="Company Name" />
								</div>
								{errors && <p className="error">{errors.company_name}</p>}
							</div>
						</div>
						<div className="step double-column">
							<div className="form-group">
								<div className="form-control">
									<Input name="firstname" maxlength={32} id="contact_person" inputValue={""} type="text" placeholder="Contact Person" />
								</div>
								{errors && <p className="error">{errors.contact_person}</p>}
							</div>
							<div className="form-group">
								<div className="form-control">
									<Input name="gst" maxlength={32} id="gst" inputValue={""} type="text" placeholder="GST" />
								</div>
								{errors && <p className="error">{errors.gst}</p>}
							</div>
						</div>
						<div className="step">
							<div className="form-group">
								<div className="form-control">
									<Input name="mobile" id="mobile" inputValue={""} type="text" placeholder="Mobile Number" />
								</div>
								{errors && <p className="error">{errors.mobile}</p>}
							</div>
						</div>
						<div className="step">
							<div className="form-group">
								<div className="form-control">
									<textarea name="address1" maxLength={255} id="address_line" cols="30" rows="10" placeholder="Enter your address">{""}</textarea>
									<div className="modal-info"><i className="icon-info"></i> Invalid characters: !&lt;&gt;;?=()@#"�{}_$%:'</div>
								</div>

								{errors && <p className="error">{errors.address_line}</p>}
							</div>
						</div>
						<div className="step double-column">
							<div className="form-group">
								<div className="form-control">
									<Input name="postcode" id="pincode" inputValue={""} type="text" placeholder="Enter your Pin-Code" />
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
									<select name="id_country" id="country">
										<option value="110" selected>India</option>
									</select>
								</div>
							</div>
							<div className="form-group">
								<div>
									<div className="form-control">
										<select name="state" id="state">
											<option value="">Select State</option>
											{stateData['states'] != undefined && stateData['states'].map((state, i) => {
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
						<div className="address-footer">
						<Input type="hidden" name="type" inputValue={2} />
						<button type="submit" className="button-blue">Submit</button>
						</div>
			        </form>
		    </div>
		)
	}
}

const mapStateToProps = function({addressState}) {
  return {
    allStates: addressState.allStates,
    isFetching: addressState.isFetching,
  }
}

export default connect(mapStateToProps)(AddAddress);