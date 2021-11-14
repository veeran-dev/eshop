import React,{Fragment} from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux'
import Select from 'react-select';

import {authRegister} from '../../api/auth-api'
import {getSelectedCity, getSelectedCategory, getAllStates} from '../../api/common-api'
import store from '../../store/configureStore'

import Input from './Input'
import validateQuoteForm from './helpers/Validation';


const validationConfigs = {
  form: "supplier_register_form",
  rules: {
        companyName: { required: true },
        email: { required: true, email: true },
        password: { required: true, password: true },
        confirmPassword: { required: true, confirmPassword: true },
        enterpriseAddress: { required: true, isAddress: true },
        addressMobile: { required: true, mobile: true },
        addressCity: { required: true, string: true, maxlength: 36 },
        addressState: { required: true},
        addressCountry: { required: true},
        addressPincode: { required: true, pincode: true },
        addressGst: { required: true, gst: true },
        contactName: { required: true, string: true },
        contactMobile: { required: true, mobile: true },
    },

    messages: {
        companyName: {
            required: "Please provide your enterprise name."
        },
        email: {
            required: "Please provide your email.",
            email: "Please enter valid email id"
        },
        password: {
            required: "Please enter your password.",
            password: "password should have minimum of 8 characters"
        },
        confirmPassword:{
            required: "Please enter your confirm password",
            confirmPassword: "Confirm Password is not same as password"
        },
        enterpriseAddress: {
            required: "Please enter your enterprise's address",
            isAddress: "Please avoid special characters",
        },
        addressMobile:{
            required: "Please provide mobile number.",
            mobile: "Please provide valid mobile number.",
        },
        addressCity:{
            required: "Please provide city.",
            string: "Please enter valid city name",
            maxlength: "Please check character limits exceeds"
        },
        addressState:{
            required: "Please provide state"
        },
        addressCountry:{
            required: "Please provide Country"
        },
        addressPincode:{
            required: "Please provide pincode",
            pincode: "Please provide valid pincode"
        },
        addressGst:{
            required: "Please provide GST",
            gst: "Please provide valid GST"
        },
        contactName: {
            required: "Please provide contact person name.",
            string: "Please provide alphabets only."
        },
        contactMobile:{
            required: "Please provide mobile number.",
            mobile: "Please provide valid mobile number.",
        },
    }
}


class Register extends React.Component{
  
  constructor(props) {
    super(props)
    this.state = {
      'errors': {},
      selectedCities: [],
      selectedCategories: [],
      errorsSelectedCategories: "",
      errorsSupplierCity: "",
      registrationComplete: false,
    }
  }

  componentWillMount(){
    getSelectedCity();
    getSelectedCategory();
    getAllStates();
  }
  componentDidMount(){
    this.refs.companyName.focus();
  }

  isValid(e) {
      const { errors, isValid } = validateQuoteForm(validationConfigs);
      if (!isValid)
        this.setState({ errors });
      else
        this.setState({ errors: {} })
      return isValid;
  }

  register = (e) => {
    e.preventDefault();
    console.log(e)
    console.log(e.target.id)
    let enterprise_name = document.getElementById('companyName').value;
    let enterprise_email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let confirm_password = document.getElementById('confirmPassword').value;
    let enterprise_address = document.getElementById('enterpriseAddress').value;
    let address_mobile = document.getElementById('addressMobile').value;
    let address_city = document.getElementById('addressCity').value;
    let address_state = document.getElementById('addressState').value;
    let address_country = document.getElementById('addressCountry').value;
    let address_pincode = document.getElementById('addressPincode').value;
    let address_gst = document.getElementById('addressGst').value;
    let contact_name = document.getElementById('contactName').value;
    let contact_mobile = document.getElementById('contactMobile').value;

    let x = this.state.selectedCategories;
    let y = this.state.selectedCities;
    console.log(x)
    console.log(y)
    if (this.isValid()){
      this.setState({errorsSelectedCategories: x == null || x.length == 0 ? "Please select the category":""})
      this.setState({errorsSupplierCity: y == null || y.length == 0 ? "Please select the city":""})
    }
    else{
      this.setState({errorsSelectedCategories: x == null || x.length == 0 ? "Please select the category":""})
      this.setState({errorsSupplierCity: y == null || y.length == 0 ? "Please select the city":""})
      return false;
    }
    if(x.length == 0 || y.length == 0){
      return false
    }
    else{
      if(e.target.id == "supplier_register_form"){
          let id_customer=this.props.id_customer
          let id_group=this.props.id_group
          authRegister(enterprise_name, enterprise_email, password, enterprise_address, address_mobile, address_city, address_state, address_country, address_pincode, address_gst, contact_name, contact_mobile, x, y, id_group, id_customer)
          .then(response=>{
              if(response.data != "" && response.data['success'] != undefined) {
                  this.setState({registrationComplete: true})
              }
          });
      }
    }
  }

  backStep = event => {
    this.setState({step: 1})
  }

  render(){
    const { errors, selectedCategories, selectedCities } = this.state;
    return(
      <div className="signup-container">
        {this.state.registrationComplete === false?
          <div className="register-form">
            { errors && <div>{errors.global}</div> }
            <form id="supplier_register_form" onSubmit={this.register.bind(this)}>
              <div className="form-group">
                <h3>Basic Details</h3>
              </div>
              <div className="form-wrapper">
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input ref="companyName" name="companyName" id="companyName" maxLength={61} inputValue={""} type="text" placeholder="Enterprise Name" onBlur={this.register.bind(this)} autoFocus={true}/>
                    </div>
                    {errors && <p className="error">{errors.companyName}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="email" maxlength={64} id="email" inputValue={""} type="text" placeholder="Enterprise Email ID" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.email}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="password" maxlength={32} id="password" inputValue={""} type="password" placeholder="Password" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.password}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="confirmPassword" maxlength={32} id="confirmPassword" inputValue={""} type="Password" placeholder="Confirm Password" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.confirmPassword}</p>}
                  </div>
                </div>
              </div>
              <div className="form-group">
                <h3>Address Details</h3>
              </div>
              <div className="form-wrapper">
                <div className="step">
                  <div className="form-group">
                    <div className="form-control">
                      <textarea name="enterpriseAddress" id="enterpriseAddress" cols="30" rows="10" placeholder="Enterprise address" onBlur={this.register.bind(this)}>{""}</textarea>
                    </div>
                    {errors && <p className="error">{errors.enterpriseAddress}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="addressMobile" row={"3"} maxlength={32} id="addressMobile" inputValue={""} type="text" placeholder="Mobile" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.addressMobile}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="addressCity" maxlength={32} id="addressCity" inputValue={""} type="text" placeholder="City" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.addressCity}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div>
                      <div className="form-control">
                        <select name="addressState" id="addressState" onBlur={this.register.bind(this)} >
                          <option value="">State</option>
                          {this.props.states != undefined && this.props.states.map((state, i) => {
                            return(
                              <option value={state.id_state} key={i}>{state.name}</option>
                            )
                          })}
                        </select>
                      </div>
                      {errors && <p className="error">{errors.addressState}</p>}
                    </div>
                  </div>
                  <div className="form-group">
                    <div>
                      <div className="form-control">
                        <select name="addressCountry" id="addressCountry" onBlur={this.register.bind(this)} >
                          <option value="110" selected>India</option>
                        </select>
                      </div>
                      {errors && <p className="error">{errors.addressCountry}</p>}
                    </div>
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="addressPincode" row={"3"} maxlength={32} id="addressPincode" inputValue={""} type="text" placeholder="Pincode" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.addressPincode}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="addressGst" row={"3"} maxlength={32} id="addressGst" inputValue={""} type="text" placeholder="GST" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.addressGst}</p>}
                  </div>
                </div>
              </div>
              <div className="form-group">
                <h3>Contact Details</h3>
              </div>
              <div className="form-wrapper">
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="contactName" id="contactName" maxLength={61} inputValue={""} type="text" placeholder="Contact Name" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.contactName}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="contactMobile" maxlength={64} id="contactMobile" inputValue={""} type="text" placeholder="Contact Mobile" onBlur={this.register.bind(this)} />
                    </div>
                    {errors && <p className="error">{errors.contactMobile}</p>}
                  </div>
                </div>
              </div>
              <div className="form-group">
                <h3>What Categories of product you can supply ?</h3>
              </div>
              <div className="form-wrapper">
                <div className="step">
                  <div className="form-group">
                    <div className="form-control">
                      <Select 
                        isMulti={true}
                        id="selectedCategories"  
                        className='react-select-container'
                        classNamePrefix='react-select'
                        placeholder="Select Category." 
                        options={this.props.categories} 
                        value={this.state.selectedCategories}
                        onChange={(value) =>this.setState({selectedCategories: value})} 
                        onBlur={this.register.bind(this)}
                        ref={component => { this.categories = component }} 
                      />
                    </div>
                    {this.state.errorsSelectedCategories != "" && <p className="error">{this.state.errorsSelectedCategories}</p>}
                  </div>
                </div>
              </div>
              <div className="form-group">
                <h3>What Cities i can supply ?</h3>
              </div>
              <div className="form-wrapper">
                <div className="step ">
                  <div className="form-group">
                    <div className="form-control">
                      <Select 
                        isMulti={true}
                        id="selectedCities"  
                        className='react-select-container'
                        classNamePrefix='react-select'
                        placeholder="Select City." 
                        options={this.props.cities} 
                        value={this.state.selectedCities}
                        onChange={(value) =>this.setState({selectedCities: value})} 
                        ref={component => { this.cities = component }} 
                        onBlur={this.register.bind(this)}
                      />
                    </div>
                    {this.state.errorsSupplierCity != "" && <p className="error">{this.state.errorsSupplierCity}</p>}
                  </div>
                </div>
              </div>
              <div className="form-footer">
                <Input type="hidden" name="type" inputValue={6} />
                <button type="submit" className="button-blue">Register</button>
              </div>
            </form>
          </div>
          :
          <div className="form-group-wrapper">
            <div className="successLoaderModal">
              <img id="Capa" src={"./src/assets/img/success.svg"} />
            </div>
            <h3>Welcome to kobster</h3>
            <p>{this.props.reg_success}</p>
            <p><a href="/supplier/#/dashboard" className="button button-blue" style={{ color: '#fff' }}>LOGIN</a></p>
          </div>
        }
      </div>
      )
  }
}
const mapStateToProps = function(store) {
  return {
    states: store.commonState.allStates,
    cities: store.commonState.selectedCities,
    categories: store.commonState.selectedCategories
  };
};

export default connect(mapStateToProps)(Register);