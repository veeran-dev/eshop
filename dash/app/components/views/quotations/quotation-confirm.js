import React from 'react'
import { connect } from 'react-redux'
import {toastr} from 'react-redux-toastr'
import * as quotationsApi from '../../../api/quotations-api'
import * as G from '../../../api/common-api'
import * as cartApi from '../../../api/cart-api'
import * as addressApi from '../../../api/address-api'
import store from '../../../store/configureStore'
import Input from '../../common/Input'
import cookie from 'react-cookie'

class ConfirmQuotation extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            stage: 0,
            message: "",
            option:0,
            chance: true,
            price: 0,
            note: "",
            billingAddress: false,
        };
    }

    getPrice(){
        return this.state.price>0 ? this.state.price : this.props.price;
    }

    getAddress(idQuoteRequest, idSupplier, e){
        id_state = this.props.idState;
        let obj = this.props.address.find(o => o.id_state === id_state);
        this.setState({stage:9, addressCount: obj})
    }

    checkPrice(idQuoteRequest, idSupplier, e){
        let target_price = this.refs.target_price.value
        if(target_price <= 0 || isNaN(target_price)){
            toastr.error('Error', 'Please enter valid price', {icon: 'icon-error'})   
            return false;
        }

        if(parseFloat(target_price)>parseFloat(this.props.price)){
            toastr.error('Error', 'Please check your price', {icon: 'icon-error'})   
            return false;   
        }
        quotationsApi.checkPrice(idQuoteRequest, idSupplier, target_price, this.state.chance).then(response => {
            quotationsApi.getQuotationsDetails(idQuoteRequest);
            if(response['data']['result'] == 1){
                this.setState({price:target_price, stage:0, message: "Your price is accepted by our supplier, please continue to."})
            }
            else if(response['data']['result'] == 0 && this.state.chance == true){
                this.setState({chance: false, stage:3, message: "Sorry our supplier not accepted your price, You have only one more chance left."})
            }
            else if(response['data']['result'] == 0 && this.state.chance == false){
                this.setState({
                    stage:5, 
                    message: "We are very sorry, your price is not accepted by our supplier.",
                    note:"Note: your negotiation chances are over, you are not allowed to negotiate for this quote again."})
            }
            else if(response['data']['result'] == 2){
                this.setState({
                    stage:5, 
                    message: "We are very sorry, your price is not accepted by our supplier.",
                    note:"Note: your negotiation chances are over, you are not allowed to negotiate for this quote again."})
            }
            return response.data
        })
    }

    confirm(idQuoteRequest, idSupplier){
        let price = this.getPrice();
        // cartApi.remove()
        quotationsApi.confirmQuotation(idQuoteRequest, idSupplier, price, this.state.option).then(response => {
            if(response['data'].msg == 'success'){
                this.setState({stage:8})
                quotationsApi.getQuotationsDetails(idQuoteRequest);
            }
            else if(response['data']['result'] == true){
                quotationsApi.getQuotationsDetails(idQuoteRequest);
                this.setState({stage:7})
            }
            return response.data
        })
    }

    cont(){
        if(this.state.option==1 || this.state.option==2){
            this.setState({stage: 1})
        }
        else{
            toastr.error('Error', 'Please select valid option', {icon: 'icon-error'})   
        }
    }

    next(){
        var shippingAddress = [];
        var billingAddress = [];
        var sas = document.getElementsByName('shippingAddressCheck');
        var bas = document.getElementsByName('billingAddressCheck');
        
        for (var i=0;i<sas.length;i++){
            if ( sas[i].checked ) {
                shippingAddress.push(sas[i].value);
            }
        }

        if(this.state.billingAddress){
            for (var i=0;i<bas.length;i++){
              if ( bas[i].checked ) {
                billingAddress.push(bas[i].value);
              }
            }
        }
        if(shippingAddress.length <= 0){
            toastr.error('Error', 'Please select address', {icon: 'icon-error'})
            return false
        }
        if(this.state.billingAddress == true && billingAddress.length <=0){
            toastr.error('Error', 'Please select billing address', {icon: 'icon-error'})   
            return false
        }
        cartApi.remove();
        quotationsApi.placeOrder(shippingAddress, this.props.idQuoteRequest, this.props.idSupplier, this.props.id_product, this.props.quantity).then(response => {
            if(response['data']['id_state'] > 0){
                id_state = response['data']['id_state']
                deliveryRegionName = response['data']['delivery_region_name']
                deliveryRegion = response['data']['delivery_region']
                cookie.save('id_delivery_address', shippingAddress)
                if(this.state.billingAddress === false){
                    cookie.save('id_billing_address', shippingAddress)
                }
                else{
                    cookie.save('id_billing_address', billingAddress)    
                }
                
                this.props.toSaveAddress(shippingAddress, billingAddress)
            }
        })
    }

    componentWillMount(){
        this.setState({stage: this.props.option == 1 ? 0:3 })
    }

    // componentWillReceiveProps(nextProps){
    //     console.log(nextProps)
    //     // this.setState({stage: this.nextProps.option == 1 ? 0:3 })
    //     console.log(nextProps.address)
    // }

    render() {
        var addressCount = 0;
        return (
            <div className="quotation-confirmation-container" key={this.props.option+"_qcc"} id={this.props.option+"_qcc"}>
                {this.state.stage == 0 ?
                    <div className="stage_1">
                        {this.state.message != "" ?
                        <div className="message">
                            <span><i className="icon-check"></i></span>
                            <p>{this.state.message}</p>
                        </div>
                        :""}
                        <div className="wrapper">
                            <div className="option">
                                <div className="image">
                                    <i className="icon-procure"></i>
                                    <p>Buy Now</p>
                                </div>
                                <input type="radio" checked={this.state.option === 1 ? true:false}/>
                                <label onClick={()=>this.setState({option: 1})}>Place order first and get supplier details later</label>
                            </div>
                            <div className="option">
                                <div className="image">
                                    <i className="icon-reports"></i>
                                    <p>Onboard Supplier</p>
                                </div>
                                <input type="radio" checked={this.state.option === 2 ? true:false}/>
                                <label onClick={()=>this.setState({option: 2})}>Onboard supplier first and place order later</label>
                            </div>
                        </div>
                        <div className="wrapper">
                            <button onClick={this.cont.bind(this)} className="button-blue button-small">Continue</button>
                        </div>
                        <p className="note">{this.state.note}</p>
                    </div>:null}
                {this.state.stage == 1 ?
                    <div className="stage_2">
                        <i className="icon-info"></i>
                        <p>I confirm to purchase <strong>{this.props.name} </strong> - {this.props.quantity} quantity before {this.props.expiry} at Rs.{this.getPrice()}/-</p>
                        <p><span>Disclaimer:</span> Failure to do so will result in suspension of your account.</p>
                        <button className="button-blue" onClick={this.confirm.bind(this, this.props.idQuoteRequest, this.props.idSupplier)} >I Confirm</button>
                    </div>:null}
                {this.state.stage == 3 ?
                    <div className="stage_3">
                        <div className="message">
                            <i className="icon-info"></i>
                            <p>Please choose your target price carefull as you won't get multiple chances</p>
                        </div>
                        <div className="price_container">
                            <div>
                                <input ref="target_price" placeholder="" type="text" />
                            </div>
                            <div>
                                <button className="button-blue" onClick={this.checkPrice.bind(this, this.props.idQuoteRequest, this.props.idSupplier)}>Negotiate</button>
                            </div>
                        </div>
                        {this.state.message != "" ? <p className="warning">{this.state.message}</p> : null}
                    </div>
                :null}
                {this.state.stage == 4?
                    <div className="stage_4">
                        <p className="message">{this.state.message}</p>
                        <div className="stage_1">
                            <button className="button-blue" onClick={(e)=>this.setState({option:1, stage: 1})}><span>Buy Now</span><span>Onboard Supplier Later</span></button>
                            <button className="button-blue" onClick={(e)=>this.setState({option:2, stage: 1})}><span>Onboard Supplier</span><span>Buy Later</span></button>
                        </div>
                        <p className="note">Note: you're negotiation chances are over, you are not allowed to negotiate for this quote again.</p>
                    </div>
                :null}
                {this.state.stage == 5?
                    <div className="stage_5">
                        <p className="message">{this.state.message}</p>
                        <p className="note">{this.state.note}</p>
                    </div>
                :null}
                {this.state.stage == 7?
                    <div className="stage_6">
                        <i className='icon-succes'></i>
                        <p>Thanks for accepting the quote <br/>Please await until customer shares the required documents</p>
                    </div>
                :null}
                {this.state.stage == 8 ?
                <div className="stage_7">
                    <i className="icon-cart"></i>
                    <p>Your product is added to your purchase list, please check at <a href="#/procure/purchase-list" onClick={(e)=>G.closeModal(["quotationConfirmation"])}>Procure / Buy</a></p>
                    <p>Would you like to place order ?</p>
                    <div>
                        <button className="button-outline" onClick={(e)=>G.closeModal(["quotationConfirmation"])} >No, Thanks</button>
                        <button className="button-blue"  onClick={this.getAddress.bind(this, this.props.idQuoteRequest, this.props.idSupplier)}>Place Order</button>
                    </div>
                    <p><span>Disclaimer:</span> Your cart will be cleared for placing the order.</p>
                </div>:null}
                {this.state.stage == 9?
                    <div>
                    <div className="address-list">
                        <div className="address-list-column">
                            <h3>Shipping address</h3>
                            <p className="info">Please choose your shipping address from below: </p> 
                            <div className="address-item-wrapper">
                                {(this.props.address && this.props.address.length > 0 ? this.props.address.map( (address, index) => {
                                    if(id_state == address.id_state) {
                                        ++addressCount;
                                    return(
                                        <div className={"address_"+address.id_address +" address-item"}  key={index}>
                                            <div className="form-control">
                                                <Input type="radio" inputValue={address.id_address} id={"shipping-address-check-"+index} name={"shippingAddressCheck"} />
                                                <label htmlFor={"shipping-address-check-"+index}>{address.alias}</label>
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
                                            <p className="gst-number">{address.vat_number ? "GST#: " + address.vat_number : <span>Please contact RM for adding GST Number</span>}</p>
                                            <p className="sez">
                                                <input type="checkbox" id={"billing-sez-check-"+index} defaultChecked={address.sez == 1 ? true : false} />
                                                <label className="alias" htmlFor={"billing-sez-check-"+index}>Special Economic Zone (SEZ)</label>
                                            </p>
                                        </div>
                                    )
                                    }
                                 }) : null)}
                            </div>
                            {this.state.addressCount == 0?
                            <div>
                                <div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Results Found!</h2><p>Please try again with different area.</p></div>
                            </div>
                            :null}
                        </div>
                        <div className="address-list-column">
                            <h3>Billing address</h3>
                            <div className="form-control-group">
                                <div className="form-control">
                                    <input type="checkbox" id="address-check" name="addressCheck" onClick={()=>this.setState({billingAddress: !this.state.billingAddress})} checked={!this.state.billingAddress} />
                                    <label htmlFor="address-check">Use the same as Shipping Address</label>
                                </div>
                            </div>
                            {this.state.billingAddress ?
                            <div className="address-item-wrapper">
                                {(this.props.address && this.props.address.length > 0 ? this.props.address.map( (address, index) => {
                                    return(
                                        <div className={"address_"+address.id_address +" address-item"}  key={index}>
                                            <div className="form-control">
                                                <Input type="radio" inputValue={address.id_address} id={"billing-address-check-"+index} name={"billingAddressCheck"} />
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
                                            <p className="gst-number">{address.vat_number ? "GST#: " + address.vat_number : <span>Please contact RM for adding GST Number</span>}</p>
                                            <p className="sez">
                                                <input type="checkbox" id={"billing-sez-check-"+index} defaultChecked={address.sez == 1 ? true : false} />
                                                <label className="alias" htmlFor={"billing-sez-check-"+index}>Special Economic Zone (SEZ)</label>
                                            </p>
                                        </div>
                                    )
                                 }) : null)}
                            </div>:null}
                            {this.state.addressCount == 0?
                            <div>
                                <div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Results Found!</h2><p>Please try again with different area.</p></div>
                            </div>
                            :null}
                        </div>
                    </div>
                    <div className="next">
                        <button className="button-blue" onClick={this.next.bind(this)}>Next</button>
                    </div>
                    </div>
                :null}
            </div>
        )
    }
}

export default ConfirmQuotation