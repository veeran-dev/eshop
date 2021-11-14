import React from 'react';
import axios from 'axios';
import {toastr} from 'react-redux-toastr'
import Ripples from 'react-ripples';
import { Scrollbars } from 'react-custom-scrollbars';
import Input from './Input'
import * as G from '../../api/common-api'
import validateQuoteForm from './helpers/Validation'
import Autosuggest from './autocomplete/AutosuggestContainer';

const validationConfigs = {
	form: "bulkEnquiry",
	rules: {
        bq_quantity: {
            required: true,
            numeric: true
        },
        bq_pincode: {
            required: true,
            maxlength: "999999",
            numeric: true
        }
    },

    messages: {
        bq_quantity: {
            required: "Please provide required quantity.",
            numeric: "Please provide numeric value."
        },
        bq_pincode: {
        	required: "Please provide your delivery pincode.",
        	maxlength: "Please provide 6 digits number.",
        	numeric: "Please provide numeric value."
        }
    }
}

class RequestQuote extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			errors: {},
			bq_quantity: "",
			bq_target_price: "",
			bq_other_details: "",
			value: '',
			suggestions: []
		}

		this.onSubmit = this.onSubmit.bind(this);
		this.onChange = this.onChange.bind(this);
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
		let suggestValue = "", inputHiddenValue = ""

		if(document.getElementById("productName") != undefined)
			inputHiddenValue = document.getElementById("productName").value;
		if(document.getElementById("requestQuoteSearch") != undefined)
			suggestValue = document.getElementById("requestQuoteSearch").value

		if (this.isValid()){
			if((inputHiddenValue != undefined && inputHiddenValue != "") || (suggestValue != undefined && suggestValue != "")) {
				G.quoteSubmit("bulkEnquiry", this);
			}
			else {
				toastr.error("Error", "Please select product.", {icon: "icon-error"})
			}
		}
	}

    onChangeHandle(event, { newValue }){
	    this.setState({ value: newValue })
    }

    onSuggestionsFetchRequested = ({ value }) => {
	    setTimeout(() => {
	      if (value === this.state.value) {
	      	if(value.length > 2)
	        	this.getProducts(value)
	      }
	    }, 200);
	};

	onSuggestionsClearRequested = () => {
	    this.setState({
	      suggestions: []
	    });
	};

    getProducts(value) {
	  return axios.get('search.php?q='+value+'&ajaxSearch1=true&ajax=true&id_lang=1', 
					{transformRequest: [function (data) { 
											document.getElementById('loader').style.visibility = 'hidden';
											return data;
										}]}).then(response => {
		  this.setState({suggestions: response.data})
	      return response.data
	  })
	}

	getSuggestionValue(suggestion) {
	  return suggestion.pname;
	}

	// Use your imagination to render suggestions.
	renderSuggestion(suggestion) {
	  return (
	    <div>
	    	<a href="javascript:void(0)" onClick={G.setProductDetails.bind(this, suggestion)}>
				<p className="search-result">
					<span className="category-name">{suggestion.cname}</span> <span className="separator">&#8250;</span> <span>{suggestion.pname}</span>
				</p>
			</a>
	    </div>
	  );
	}

	render() {
		const { errors } = this.state;
		const { value, suggestions } = this.state;
	    // Autosuggest will pass through all these props to the input field.
	    const inputProps = { placeholder: 'Type Product name or Product Code or Manufacturer code', value, onChange: this.onChangeHandle.bind(this), id: "requestQuoteSearch"};

		return (
			<div className="modal-wrapper">
				{/*<Scrollbars 
					autoHide
					// Hide delay in ms
					autoHideTimeout={1000}
					// Duration for hide animation in ms.
					autoHideDuration={200}
					style={{ height: 300}}> */}
					<form id="bulkEnquiry" onSubmit={this.onSubmit}>
						{ errors && <div className="error">{errors.global}</div> }
						<div className="modal-wrapper">
						<div className="modal-description">Request quotation for a product of your choice from Kobser.com, our team of experts will revert back to you with the best quote. For queries contact your Relationship Manager or 1800-121-0405 (Toll-Free)</div>
						<div className="step">
							<div className="form-group">
								<div className="form-control">
									{!this.props.productName ? 
									<div>
										<Autosuggest
											suggestions={suggestions}
											getSuggestionValue={this.getSuggestionValue}
											renderSuggestion={this.renderSuggestion}
											onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
											onSuggestionsClearRequested={this.onSuggestionsClearRequested}
											inputProps={inputProps} 
											className="search-box" />
											<div className="modal-info">If product not found please contact Relationship Manager or 1800-121-0405 (Toll-Free).</div>
									</div>
									: <div>
										<h3>{this.props.productName}</h3>
										<Input type="hidden" inputValue={this.props.productCode} name="id_product" id={"productCode"}/>
										<Input type="hidden" inputValue={this.props.productName} name="product_name" id={"productName"}/>
									  </div>
									}
								</div>
							</div>
						</div>
						<div id="productResult" className="product-result-wrapper"></div>
						<div className="step double-column">
							<div className="form-group quantity">
								<div>
									<div className="form-control inline">
										<Input name="bq_quantity" onChange={this.onChange} inputValue={""} id="bq_quantity" type="text" placeholder="Quantity"/>
										<select name="bq_qty_unit">
											<option value="Units" selected>Units</option>
											<option value="Boxes">Boxes</option>
											<option value="Container">Container</option>
										</select>
									</div>
									{errors && <p className="error">{errors.bq_quantity}</p>}
									
								</div>
							</div>
							<div className="form-group price">
								<div>
									<div className="form-control">
										<span>Rs.</span>
										<Input name="bq_target_price" type="text" onChange={this.onChange} inputValue={""} id={"bq_target_price"} placeholder="Target Price (Tax Included)"/>
									</div>
								</div>
							</div>

						</div>

						<div className="step">
							
							<div className="form-group flex-column-exception">
								<p className="form-control">Do you need Credit Payment Facility?</p>
								<div className="form-control">
									<Input type="radio" name="bq_credit" inputValue="1" id="credit_yes" defaultChecked={true}/>
									<label htmlFor="credit_yes">Yes</label>

									<Input type="radio" name="bq_credit" inputValue="0" id="credit_no" defaultChecked={false}/>
									<label htmlFor="credit_no">No</label>
								</div>
							</div>
						</div>

						<div className="step">
						<div>
							<div className="form-group">
								<div className="form-control">
									<Input name="bq_pincode" id="bq_pincode" maxLength={6}  inputValue={""} type="text" onChange={this.onChange} placeholder="Pin-Code" />
								</div>
							</div>
						</div>
						{errors && <p className="error">{errors.bq_pincode}</p>}
						</div>

						<div className="step">
							<div className="form-group">
								<div className="form-control">
									<textarea name="bq_other_details" id="" cols="30" rows="10" onChange={this.onChange} placeholder="Any other requirements?">{this.state.bq_other_details}</textarea>
								</div>
							</div>
						</div>

						</div>

						<div className="modal-footer">
							<button type="submit" className="button-red">Submit</button>
						</div>
						<Input type="hidden" name="bq_id_customer" inputValue={id_customer} />
						<Input type="hidden" name="ajax" inputValue={true} />
						<Input type="hidden" name="logged" inputValue={1} />
						<Input type="hidden" name="bq_select_price" inputValue={"inr"} />
					</form>
				{/* </Scrollbars> */}
			</div>
		)
	}
}

export default RequestQuote;