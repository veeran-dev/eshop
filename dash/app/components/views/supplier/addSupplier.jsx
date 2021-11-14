import React from 'react'
import Select from 'react-select';
import {toastr} from 'react-redux-toastr'

import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import Input from '../../../components/common/Input'
import validateQuoteForm from '../../../components/common/helpers/Validation';

const validationConfigs = {
	form: "supplierAdd",
	rules: {
        contact_person: { required: true, string: true },
        company_name: { required: true },
        email: { required: true, email: true },
        mobile: { required: true, mobile: true },
    },

    messages: {
        contact_person: {
            required: "Please provide contact person name.",
            string: "Please provide alphabets only."
        },
        company_name: {
            required: "Please provide supplier's enterprise name."
        },
        mobile: {
        	required: "Please provide contact person's mobile number.",
        	mobile: "Please provide valid mobile number.",
        },
        email:{
        	required: "Please provide supplier's email id",
        	email: "Please provide valid email id"
        },
    }
}

// Listing orders for approval purpose
class  AddSupplier extends React.Component{
	constructor(props){
		super(props)
		this.state = {
			errors: {},
			selectedCities: [],
			selectedCategories: [],
			chosenCategory: [],
			otherCity: false,
		}
	}
	componentWillMount(){
		G.getSelectedCity().then(response=>{
			console.log(response.data)
			this.setState({selectedCities: response.data['selectedCities']})
			return response
		});
		G.getSelectedCategory().then(response=>{
			this.setState({selectedCategories: response.data['selectedCategories']})
			return response
		});
	}

	isValid() {
	    const { errors, isValid } = validateQuoteForm(validationConfigs);
	    console.log(errors)
	    console.log(isValid)
	    if (!isValid)
	      this.setState({ errors });
	  	else
	  	  this.setState({ errors: {} })
	    return isValid;
	}

	submitAddress(e){
		e.preventDefault();
		if (this.isValid()){
			console.log(this.state.chosenCategory)
			let category = this.state.chosenCategory
			let unique = [...new Set(category.map(item => item.value))];
			let contact_person = document.getElementById('contact_person').value;
			let company_name = document.getElementById('company_name').value;
			let mobile = document.getElementById('mobile').value;
			let email = document.getElementById('email').value;
			let city = document.getElementById('city').value;

			G.addSupplier(contact_person, company_name, mobile, email, city, unique).then(response=>{
				console.log(response.data)
				this.setState({chosenCategory: []});
				document.getElementById('contact_person').value = "";
				document.getElementById('company_name').value = "";
				document.getElementById('mobile').value = "";
				document.getElementById('email').value = "";
				document.getElementById('city').value = "";
				toastr.success("Success", "Supplier invitation sent successfully.", { icon: "icon-succes"})
			})
			// G.addAddress("addressAdd", 2)
		}
	}

	render(){
		const { errors, selectedCategories, selectedCities } = this.state;
	  	return (
	  		<div>
				<div className="page-header">
					<h3 className="page-title">Invite Supplier</h3>
				</div> 
				<div className="page-container invite-supplier-form-container">
				    <div className="edit-address">
	                	{ errors && <div>{errors.global}</div> }
				        <form id="supplierAdd" onSubmit={this.submitAddress.bind(this)}>
					        <div className="form-group">
								<h3>Please Enter Supplier Details</h3>
							</div>
							<div className="form-wrapper">
					        	<div className="step double-column">
									<div className="form-group">
										<div className="form-control">
											<Input name="company_name" id="company_name" maxLength={61} inputValue={""} type="text" placeholder="Supplier's Enterprise Name" onBlur={this.isValid.bind(this)} />
										</div>
										{errors && <p className="error">{errors.company_name}</p>}
									</div>
									<div className="form-group">
										<div className="form-control">
											<Input name="email" maxlength={64} id="email" inputValue={""} type="text" placeholder="Supplier's Email ID" onBlur={this.isValid.bind(this)} />
										</div>
										{errors && <p className="error">{errors.email}</p>}
									</div>
								</div>
								<div className="step double-column">
									<div className="form-group">
										<div className="form-control">
											<Input name="contact_person" maxlength={32} id="contact_person" inputValue={""} type="text" placeholder="Contact Person Name" onBlur={this.isValid.bind(this)} />
										</div>
										{errors && <p className="error">{errors.contact_person}</p>}
									</div>
									<div className="form-group">
										<div className="form-control">
											<Input name="mobile" maxlength={32} id="mobile" inputValue={""} type="text" placeholder="Contact Person Mobile" onBlur={this.isValid.bind(this)} />
										</div>
										{errors && <p className="error">{errors.mobile}</p>}
									</div>
								</div>
								<div className="step double-column">
									<div className="form-group">
										<div>
											<div className="form-control">
												<select name="city" id="city" onBlur={this.isValid.bind(this)} >
													<option value="">Supplier City</option>
													{selectedCities.map((city, i) => {
														console.log(city)
														return(
															<option value={city.value} key={i}>{city.label}</option>
														)
													})}
												</select>
											</div>
										</div>
									</div>
								</div>
								<div className="step">
									<div className="form-group">
										<div className="form-control">
										<input type="hidden" name="category" value={this.state.chosenCategory} />
										<Select 
					                        isMulti={true}
					                        id="selectedCategories"  
					                        className='react-select-container'
					                        classNamePrefix='react-select'
					                        placeholder="Supplier Category." 
					                        options={this.state.selectedCategories} 
					                        value={this.state.chosenCategory}
					                        onChange={(value) =>this.setState({chosenCategory: value})} 
					                        ref={component => { this.addresses = component }} 
					                        onBlur={this.isValid.bind(this)}
					                      />
				                      	</div>
									</div>
								</div>
							</div>
							<div className="form-footer">
								<Input type="hidden" name="type" inputValue={6} />
								<button type="submit" className="button-blue">Invite Supplier</button>
							</div>
				        </form>
				    </div>
			    </div>
		    </div>
		)
	}
}

export default AddSupplier