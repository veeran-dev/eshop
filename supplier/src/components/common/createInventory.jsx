import React from 'react';
import { useState, useEffect } from 'react';
import { getStates } from '../../api/address-api'
import { createInventory } from '../../api/inventory-api'
import axios from 'axios'
import Input from './Input'
import validateQuoteForm from './helpers/Validation';
import 'babel-polyfill';
import {toastr} from 'react-redux-toastr'

function CreateInventory() {

    const [values, setValues] = useState({ val: []});
    const [errors, setErrors] = useState({ val: []});
    const [states, setStates] = useState({ val: []});
    const [success, setSuccess] = useState(false);

    const validationConfigs = {
        form: "createWarehouseForm",
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

    useEffect(() => {
      getStates()
    }, []);

    async function getStates(){
      const result = await axios('../elite-supplier-address.php?ajax=true&type=1');
      // const result = await result.json();
      console.log(result);
      setStates(result.data['states']);
    };

    function handleChange(event) {
      let vals = [...values.val];
      vals[this] = event.target.value;
      setValues({ val: vals });
    }

    const isValid = () =>{
      console.log("isValid")
      const { errors, isValid } = validateQuoteForm(validationConfigs);
      setErrors(errors);
    }

    const handleSubmit = event => {
      event.preventDefault();
      let inventory_name = document.getElementById('companyName').value;
      let user_email = document.getElementById('email').value;
      let password = document.getElementById('password').value;
      let confirm_password = document.getElementById('confirmPassword').value;
      let inventory_address = document.getElementById('enterpriseAddress').value;
      let address_mobile = document.getElementById('addressMobile').value;
      let address_city = document.getElementById('addressCity').value;
      let address_state = document.getElementById('addressState').value;
      let address_country = document.getElementById('addressCountry').value;
      let address_pincode = document.getElementById('addressPincode').value;
      let address_gst = document.getElementById('addressGst').value;
      let contact_name = document.getElementById('contactName').value;
      let contact_mobile = document.getElementById('contactMobile').value;

      createInventory(inventory_name, user_email, password, inventory_address, address_mobile, address_city, address_state, address_country, address_pincode, address_gst, contact_name, contact_mobile)
      .then(response=>{
          console.log(response.data)
          document.getElementById("createWarehouseForm").reset();
          if(response.data != "" && response.data['success'] != undefined) {
              setSuccess(true);
          }
          else if(response.data != "" && response.data['error'] != undefined) {
              setError(true);
              let msg = "";
              if(response.data['error'] == 1){

              }
              toastr.error("Error", msg, {icon: "icon-error"})
          }
      });
    }

    return (
      <>
      {success === false ? 
      <form id="createWarehouseForm" onSubmit={handleSubmit} className="register-form">
              <div className="form-group">
                <h3>Contact Details</h3>
              </div>
              <div className="form-wrapper">
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="contactName" id="contactName" maxLength={61} inputValue={""} type="text" placeholder="Contact Name" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.contactName}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="contactMobile" maxlength={64} id="contactMobile" inputValue={""} type="text" placeholder="Contact Mobile" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.contactMobile}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="companyName" id="companyName" maxLength={61} inputValue={""} type="text" placeholder="Inventory Name" onBlur={isValid} autoFocus={true}/>
                    </div>
                    {errors && <p className="error">{errors.companyName}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="email" maxlength={64} id="email" inputValue={""} type="text" placeholder="User Email ID" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.email}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="password" maxlength={32} id="password" inputValue={""} type="password" placeholder="Password" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.password}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="confirmPassword" maxlength={32} id="confirmPassword" inputValue={""} type="Password" placeholder="Confirm Password" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.confirmPassword}</p>}
                  </div>
                </div>
              </div>
              <div className="form-group">
                <h3>Inventory Address</h3>
              </div>
              <div className="form-wrapper">
                <div className="step">
                  <div className="form-group">
                    <div className="form-control">
                      <textarea name="enterpriseAddress" id="enterpriseAddress" cols="30" rows="10" placeholder="Inventory address" onBlur={isValid}>{""}</textarea>
                    </div>
                    {errors && <p className="error">{errors.enterpriseAddress}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="addressMobile" row={"3"} maxlength={32} id="addressMobile" inputValue={""} type="text" placeholder="Mobile" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.addressMobile}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="addressCity" maxlength={32} id="addressCity" inputValue={""} type="text" placeholder="City" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.addressCity}</p>}
                  </div>
                </div>
                <div className="step double-column">
                  <div className="form-group">
                    <div>
                      <div className="form-control">
                        <select name="addressState" id="addressState" onBlur={isValid} >
                          <option value="">State</option>
                          {states != undefined && states.length > 0 && states.map((state, i) => {
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
                        <select name="addressCountry" id="addressCountry" onBlur={isValid} >
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
                      <Input name="addressPincode" row={"3"} maxlength={32} id="addressPincode" inputValue={""} type="text" placeholder="Pincode" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.addressPincode}</p>}
                  </div>
                  <div className="form-group">
                    <div className="form-control">
                      <Input name="addressGst" row={"3"} maxlength={32} id="addressGst" inputValue={""} type="text" placeholder="GST" onBlur={isValid} />
                    </div>
                    {errors && <p className="error">{errors.addressGst}</p>}
                  </div>
                </div>
              </div>
              <div className="form-footer">
                <Input type="hidden" name="type" inputValue={6} />
                <button type="submit" className="button-blue">Register</button>
              </div>
            </form>
      :
      <h1>success</h1>}
      </>
    );

}

export default CreateInventory;