import React from 'react'
import { Link } from 'react-router'
import { connect } from 'react-redux'
import serialize from 'form-serialize'
import {toastr} from 'react-redux-toastr'
import DisplayCart from '../../views/cart/Cart'
import * as addressApi from '../../../api/address-api'
import { getAddress, addAddress } from '../../../api/common-api'
import cookie from 'react-cookie'
import store from '../../../store/configureStore'
import Input from '../../common/Input'
import { openRequestQuote } from '../../../api/common-api' 
import Ripples from 'react-ripples';

class AddressList extends React.Component {
    constructor(props){
        super(props)
        this.state = {
            addressType: 0,
            checked: true,
            addressState: "",
            shippingAddress: "",
            billingAddress: "",
        }
    }

    componentDidMount(){
        addressApi.get()
    }

    proceedCheckOut(){
        let addressListForm, addressObject, billingAddress, shippingAddress
        addressListForm = document.querySelector('#addressSelection')
        addressObject = serialize(addressListForm, { hash: true })
        //Set shipping address
        shippingAddress = addressObject.deliveryAddressCheck;
        if(isNaN(shippingAddress)) {
            toastr.error("Error", "Please select shipping address.", {icon: 'icon-error'})
            return false;
        }
        //Set billing address
        if(addressObject.addressCheck == "on")
            billingAddress = addressObject.deliveryAddressCheck;
        else
            billingAddress = addressObject.billingAddressCheck
        
        if(shippingAddress == "" || shippingAddress == undefined)
            toastr.error("Error", "Please select shipping address.", {icon: 'icon-error'})
        else if(billingAddress == "" || billingAddress == undefined)
            toastr.error("Error", "Please select billing address.", {icon: 'icon-error'})
        else{
            if((this.props.cart.length > 0)){
                cookie.save('id_delivery_address', shippingAddress)
                cookie.save('id_billing_address', billingAddress)
                addressApi.saveAddressToCart(shippingAddress, billingAddress, this.context)
            }
            else{
                toastr.error("Error", "Cart cannot be blank. Please add some products to cart", {icon: "icon-error"})
            }
        }
    }

    billingAddressToggle(e){
        if(e.target.checked == true){
            cookie.remove("id_billing_address")
            this.setState({ 
                checked: true
            })
        }
        else{
            this.setState({ 
                checked: false
            })
        }
    }

    updateDeliveryAddress = (idAddress) => {
        addressApi.updateDeliveryAddress(idAddress).then(response => {
            if(response) {
                cookie.save('id_delivery_address', idAddress);
                toastr.success('Success', 'Delivery address updated successfully.', { icon: 'icon-succes' });
            }
            else {
                toastr.error('Error', 'Error in updating delivery address. Please try agin.', { icon: 'icon-error' });
            }
        });
    }

    updateInvoiceAddress = (idAddress) => {
        addressApi.updateInvoiceAddress(idAddress).then(response => {
            if(response) {
                cookie.save('id_billing_address', idAddress);
                console.log(cookie.load('id_billing_address'));
                toastr.success('Success', 'Invoice address updated successfully.', { icon: 'icon-succes' });
            }
            else {
                toastr.error('Error', 'Error in updating Invoice address. Please try agin.', { icon: 'icon-error' });
            }
        });
    }

    render() {
        const { checked } = this.state
        let cookieBillingAddress = cookie.load("id_billing_address")
        var addressCount = 0;
        return (
            <div className="address-container">
            {this.props.isFetching ? <div className="fetching fetching-address"><div className="fetching-content"><div></div></div></div> : 
                this.props.address && this.props.address.length > 0 ?
                <div className="address-list-wrapper">
                    <div className="page-header">
                        <h3 className="page-title">Select Your Delivery Address</h3>
                        <div className="action-block">
                            {/*<Ripples><button className="button-red outline" onClick={openRequestQuote.bind(this, null, null)}>Request Quote</button></Ripples>*/}
                        </div>
                    </div>
                    <form id="addressSelection">
                        <div className="address-list">
                            <div className="address-list-column">
                                <h3>Shipping address</h3>
                                <p className="info">Please choose your shipping address from below:</p> 
                                <div className="address-item-wrapper">
                                     {this.props.isFetching ? <div className="fetching fetching-address"><div className="fetching-content"><div></div><div></div></div></div> : 
                                         (this.props.address && this.props.address.length > 0 ? this.props.address.map( (address, index) => {
                                            if(budgetConfigured == 1 && address.id_address == cookieAddressBudget) {
                                                return (
                                                    <div className={"address_"+address.id_address +" address-item"}  key={index}>
                                                        <div className="form-control">
                                                            <Input type="radio" inputValue={address.id_address} id={"delivery-address-check-"+index} name={"deliveryAddressCheck"} defaultChecked={true} />
                                                            <label className="alias" htmlFor={"delivery-address-check-"+index}>{address.alias}</label>
                                                        </div>
                                                        <p className="full-name">{address.firstname+" "+address.lastname}</p>
                                                        <p className="company">{address.company}</p>
                                                        <p className="address">
                                                            {address.address1}, <br></br>
                                                            {address.city}, <br></br>
                                                            {address.postcode}, <br></br>
                                                            {address.state}, <br></br>
                                                            {address.country}
                                                        </p>
                                                        
                                                        <p className="phone">{address.phone_mobile}</p>
                                                        <p class="gst-number">{address.vat_number ? "GST#: " + address.vat_number : <span>Please contact RM for adding GST Number</span>}</p>
                                                        <p className="sez">
                                                            <input type="checkbox" id={"sez-check-"+index} defaultChecked={address.sez == 1 || address.isez == 1 ? true : false} />
                                                            <label className="alias" htmlFor={"sez-check-"+index}>Special Economic Zone (SEZ)</label>
                                                        </p>
                                                        <div className="address-item-actions">
                                                            { /**<button type="button" onClick={getAddress.bind(this, address.id_address)} className="button-blue outline">Edit</button> **/}
                                                        </div>
                                                    </div>
                                                )
                                            }
                                            else if(budgetConfigured != 1) {
                                                if(id_state == address.id_state) {
                                                    ++addressCount;
                                                    return (
                                                        <div className={"address_"+address.id_address +" address-item"}  key={index}>
                                                            <div className="form-control">
                                                                <Input type="radio" 
                                                                    inputValue={address.id_address} 
                                                                    id={"delivery-address-check-"+index} 
                                                                    name={"deliveryAddressCheck"} 
                                                                    defaultChecked={(cookie.load('id_delivery_address') == address.id_address ? true : (addressCount == 1 ? true : false))}
                                                                    onClick={this.updateDeliveryAddress.bind(this, address.id_address)} 
                                                                />
                                                                <label className="alias" htmlFor={"delivery-address-check-"+index}>{address.alias}</label>
                                                            </div>
                                                            <p className="full-name">{address.firstname+" "+address.lastname}</p>
                                                            <p className="company">{address.company}</p>
                                                            <p className="address">
                                                                {address.address1}, <br></br>
                                                                {address.city}, <br></br>
                                                                {address.postcode}, <br></br>
                                                                {address.state}, <br></br>
                                                                {address.country}
                                                            </p>
                                                            <p className="phone">{address.phone_mobile}</p>
                                                            <p class="gst-number">{address.vat_number ? "GST#: " + address.vat_number : <span>Please contact RM for adding GST Number</span>}</p>
                                                            <p className="sez">
                                                                <input type="checkbox" id={"sez-check-"+index} defaultChecked={address.sez == 1 || address.isez == 1 ? true : false} />
                                                                <label className="alias" htmlFor={"sez-check-"+index}>Special Economic Zone (SEZ)</label>
                                                            </p>
                                                            <div className="address-item-actions">
                                                                { /**<button type="button" onClick={getAddress.bind(this, address.id_address)} className="button-blue outline">Edit</button> **/}
                                                            </div>
                                                        </div>
                                                    )
                                                }
                                            }
                                        }) : null)}
                                </div>
                            </div>
                            <div className="address-list-column">
                                <h3>Billing address</h3>
                                <div className="form-control-group">
                                    <div className="form-control">
                                        <input type="checkbox" id="address-check" name="addressCheck" defaultChecked={((cookieBillingAddress != undefined && cookieBillingAddress != "") ? false : true)} onClick={this.billingAddressToggle.bind(this)} />
                                        <label htmlFor="address-check">Use the same as Shipping Address</label>
                                    </div>
                                </div>
                                { (!checked || (cookieBillingAddress != undefined && cookieBillingAddress != "")) ? <div className="address-item-wrapper">
                                        {(this.props.address && this.props.address.length > 0 ? this.props.address.map( (address, index) => {
                                            return(
                                                <div className={"address_"+address.id_address +" address-item"}  key={index}>
                                                    <div className="form-control">
                                                        <Input type="radio" inputValue={address.id_address} id={"billing-address-check-"+index} name={"billingAddressCheck"} defaultChecked={cookie.load('id_billing_address') == address.id_address ? true : false} onClick={this.updateInvoiceAddress.bind(this, address.id_address)}  />
                                                        <label htmlFor={"billing-address-check-"+index}>{address.alias}</label>
                                                    </div>
                                                    <p className="full-name">{address.firstname+" "+address.lastname}</p>
                                                    <p className="company">{address.company}</p>
                                                    <p className="address">
                                                        {address.address1}, <br></br>
                                                        {address.city}, <br></br>
                                                        {address.postcode}, <br></br>
                                                        {address.state}, <br></br>
                                                        {address.country}
                                                    </p>
                                                    <p className="phone">{address.phone_mobile}</p>
                                                    <p class="gst-number">{address.vat_number ? "GST#: " + address.vat_number : <span>Please contact RM for adding GST Number</span>}</p>
                                                        <p className="sez">
                                                            <input type="checkbox" id={"billing-sez-check-"+index} defaultChecked={address.sez == 1 ? true : false} />
                                                            <label className="alias" htmlFor={"billing-sez-check-"+index}>Special Economic Zone (SEZ)</label>
                                                        </p>
                                                    <div className="address-item-actions">
                                                        { /**<button type="button" onClick={getAddress.bind(this, address.id_address)} className="button-blue outline">Edit</button>**/ }
                                                    </div>
                                                </div>
                                            )
                                         }) : null)}
                                </div> : null}
                            </div>
                            <DisplayCart nextBtn={true} onClick={this.proceedCheckOut.bind(this)}/>
                        </div>
                    </form>
                </div> : <div className="empty-state-container"><div className="empty-state"><div className="empty-state-thumb not-installed"></div><h1>No addresses added yet!</h1><p>Kindly add shipping address and/or billing address to proceed checkout.</p><a className="add-address-big" href="javascript:void(0)" onClick={addAddress.bind(this, "", 1)}>Add Shipping Address & Proceed</a></div></div>}
            </div>
        )
    }
}

AddressList.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    address: store.addressState.address,
    cart: store.cartState.cart,
    isFetching: store.addressState.isFetchingAddress
  }
}

export default connect(mapStateToProps)(AddressList)