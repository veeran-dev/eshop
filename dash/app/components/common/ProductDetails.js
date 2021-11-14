import React from 'react';
import ReactDOM from 'react-dom';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import {toastr} from 'react-redux-toastr'
import { connect } from 'react-redux'
import ReactImageFallback from "react-image-fallback";
import SearchHeader from './SearchHeader'
import SelectArea from './SelectArea'
import Ripples from 'react-ripples'
import Datepicker from './datepickerSingle'
import * as G from '../../api/common-api'
import {getProductDetails, getSupplierDetails, sendQuoteRequest} from '../../api/product-api'
import {resetDate, checkPastDate} from '../../api/common-api'
import {setZone} from '../../api/search-api'
import {get} from '../../api/address-api';
class ProductDetails extends React.Component {
    constructor(props){
        super(props)
        this.state = {
            block: 1,
            supplierForm: 1,
            selectedArea: 'Select Location ...',
            selectedSupplier: [],
            showQuantity: 0,
            credit: 0,
            date: "",
            immediately: 0,
            payment:0,
            buyingPeriod: "",
            getSupplier: 0,
            zone: [],
        }
    }

    componentWillMount(){
        getProductDetails(this.props.params.idProduct);
        get();
    }

    showSelectArea=()=>{
        ReactDOM.render(<SelectArea onSelect={this.getSelectedArea} address={this.props.addresses} selectedAreaProps={this.props.zones} />, document.getElementById("spLocaationContent"))
        G.displayModal("spArea")
    }

    getSelectedArea = (address) =>{
        this.setState({selectedArea: address['selectedArea'], zone: address, deadline: ""},
        function(){
            getSupplierDetails(this.props.params.idProduct, this.state.zone)
        });
        this.refs.quote_quantity.value = "";
        this.refs.datePicker.setState({value:""});
        this.setState({selectedSupplier: [], supplierForm: 1, block: 1, date: "", buyingPeriod: "", payment:0,credit:0,showQuantity:0,immediately:0});
        G.closeModal(["spArea"])
    }

    componentWillReceiveProps(nextProps){
        if(nextProps.zones != undefined && nextProps.zones.length > 0){
            this.setState({selectedArea: nextProps.zone['selectedArea']})
        }
        if(nextProps.zones != "" && this.state.selectedArea != nextProps.zones['selectedArea']){
            this.setState({selectedArea: nextProps.zones['selectedArea'] !=undefined && nextProps.zones['selectedArea'] != "" ? nextProps.zones['selectedArea'] : "Select Location ..."})
        }
        if(nextProps.zones!= undefined && nextProps.zones['trigger'] == true){
            ReactDOM.render(<SelectArea onSelect={this.getSelectedArea} address={this.props.addresses} selectedAreaProps={this.props.zones} />, document.getElementById("spLocaationContent"))
            G.displayModal("spArea")
        }
    }

    toggleSupplier(id_supplier, id_product, e){
        
        let filterChoosen=document.getElementById(id_supplier).checked;
        if(filterChoosen == true)
        {
            document.getElementById(id_supplier).checked=false;
        }
        else if(filterChoosen == false)
        {
            if(this.state.selectedSupplier.length >= 5){
                toastr.error('Error', 'Sorry you can select maximum 5 suppliers only', {icon: 'icon-error'})   
                return false;
            }
            document.getElementById(id_supplier).checked=true;
        }
        if(this.state.selectedSupplier.indexOf(id_supplier) == -1){
           this.setState({selectedSupplier: this.state.selectedSupplier.concat(id_supplier)});
        }
        else{
          this.setState({selectedSupplier: this.state.selectedSupplier.filter(function(selectedSupplier) { 
              return selectedSupplier !== id_supplier
          })})
        }
        
    }

    toForm(){
        if(this.state.selectedSupplier.length > 0){
            this.setState({supplierForm: 2})
        }
        else{
            toastr.error('Error', 'Please select atleast one supplier', {icon: 'icon-error'})
        }
    }

    submitForm(){
        let intervalOption = this.state.showQuantity;
        let quoteQuantity = this.refs.quote_quantity.value;
        let buyingPeriod = this.state.buyingPeriod;
        let immediately = this.state.immediately;
        let deadline = this.state.deadline;
        let payment = this.state.payment;
        let credit = this.state.credit;

        if(intervalOption<=0){
            toastr.error('Error', 'Please choose one time or regular order', {icon: 'icon-error'})
            return false;
        }
        if(isNaN(quoteQuantity) || quoteQuantity<=0){
            toastr.error('Error', 'Please enter valid quantity', {icon: 'icon-error'})
            return false;
        }
        if((quoteQuantity - Math.floor(quoteQuantity)) !== 0){
            toastr.error('Error', 'Please enter valid quantity', {icon: 'icon-error'})
            return false;   
        }
        if(intervalOption == 1 && buyingPeriod === ""){
            toastr.error('Error', 'Please select the frequency', {icon: 'icon-error'})
            return false;
        }
        if(immediately == 0){
            toastr.error('Error', 'Please select When you need this product', {icon: 'icon-error'})
            return false;
        }
        if(!checkPastDate(deadline)){
            toastr.error('Error', 'Please check your deadline date', {icon: 'icon-error'})
            return false;
        }
        if(deadline === undefined || deadline === ""){
            toastr.error('Error', 'Please select deadline', {icon: 'icon-error'})
            return false;
        }
        if(payment == 0 && credit !=0){
            credit = this.state.credit;
        }
        else if(payment ==0){
            toastr.error('Error', 'Please check your payment term', {icon: 'icon-error'})
            return false;
        }
        
        sendQuoteRequest(this.props.product_details['id_product'],intervalOption, quoteQuantity, buyingPeriod, immediately, deadline, payment, credit, this.state.selectedSupplier).then(response => {
          this.setState({supplierForm: 3})
          let selectedSupplier = this.state.selectedSupplier;
          selectedSupplier.map(id=>{document.getElementById(id).checked=false;})
          this.refs.datePicker.setState({value:""});
          this.refs.quote_quantity.value = "";
          this.setState({selectedSupplier: [], date: "", buyingPeriod: "", payment:0,credit:0,showQuantity:0,immediately:0});
          return response.data
        })

    }
    render() {
        let product = this.props.product_details;
        let suppliers = this.props.supplier_details;
        let description = product != undefined ? product['description'] : "";
        let ratingsElem = [];
        for(var j = 0; j < 5; j++){
            if(product != undefined && product['ratings'] > j)
                ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
            else
                ratingsElem.push(<i className="icon-star-empty" key={j}></i>) 
        }
        return (
            <div className="">
                <div className="page-header">
                    <h3 className="page-title">Product and supplier Details</h3>
                </div>
                {product['name'] != undefined && product['name'].length > 0 ?
                <div className="sp-product-details-container">
                    <div className="sp-product-wrapper">
                        <div className="sp-image-wrapper">
                            <div className="image-container">
                                <ReactImageFallback
                                    src={product['img']}
                                    fallbackImage="./img/p/en-default-large.jpg"
                                    initialImage="./img/p/en-default-large.jpg"
                                    alt={product['name']}/>
                            </div>
                        </div>
                        <div className="sp-product-details-wrapper">
                            <div className="sp_name">
                                <p className="sp-product-name">{product['name']}</p>
                                <p className="sp-product-reference">{product['reference']}</p>
                                <div className="sp-description" dangerouslySetInnerHTML={{ __html: description }}></div>
                            </div>
                            <div className="sp-details">
                                <div className="sp-price">
                                    <div>Standard Price</div>
                                    <div>Rs. {parseFloat(product['price']).toFixed(2)}</div>
                                </div>
                                <div className="sp-ratings">
                                    <div>
                                        {ratingsElem}
                                    </div>
                                    <div>{product['ratings']} Ratings</div>
                                </div>
                            </div>
                            <div className="sp-cta">
                                <div className="location-cta" onClick={this.showSelectArea.bind(this)}>
                                    <button className="button-oultine location-label">
                                        <i className="menu-icon-red icon-place-pin"></i>
                                        <span>{this.state.selectedArea == "" ? "Select Area": this.state.selectedArea}</span>
                                    </button>
                                    <button className="button-blue">Change</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                :
                <div className="sp-product-details-container">
                    <div className="sp-product-wrapper">
                        <div className="sp-image-wrapper">
                            <div className="image-container">
                                <img src="http://localhost/kobstereshop/img/p/en-default-large.jpg" />
                            </div>
                        </div>
                        <div className="sp-product-details-loading-wrapper">
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                        </div>
                    </div>
                </div> 
                }
                <div className="sp-product-additional-container">
                    <div className="sp-product-additional">
                        <div className="sp-product-additional-nav">
                            <Ripples className="button-group-item">
                                <a className={this.state.block === 1 ? "button active":"button"}  onClick={(e)=>this.setState({block: 1})}>Suppliers</a>
                            </Ripples>
                            <Ripples className="button-group-item">
                                 <a className={this.state.block === 2 ? "button active":"button"}  onClick={(e)=>this.setState({block: 2})}>Features</a>
                            </Ripples>
                        </div>
                        <div className={this.state.block === 1 ? "block-content active":"block-content"}>
                            <div className={this.state.supplierForm == 1 ?"sp-supplier-lists":"sp-supplier-lists hidden"}>
                                <table>
                                    <thead>
                                        <tr>
                                            <th className="text-align-left">Supplier</th>
                                            <th >Response Time</th>
                                            <th >Order Processed</th>
                                            <th >MOQ</th>
                                            <th >Choose</th>
                                        </tr>
                                    </thead>
                                    <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} 
                                        transitionAppearTimeout={500} transitionLeaveTimeout={300} component="tbody">
                                    {suppliers == undefined || this.props.loading == true ? <tr><td className="fetching" colSpan="7"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                                    suppliers != undefined && suppliers.length > 0 ? suppliers.map(supplier => {
                                        let ratingsElem = [];
                                        for(var j = 0; j < 5; j++){
                                            if(product != undefined && supplier['ratings'] > j)
                                                ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
                                            else
                                                ratingsElem.push(<i className="icon-star-empty" key={j}></i>) 
                                        }
                                      return (
                                        <tr >
                                            <td data-title="Supplier" className="supplier" >
                                                <div className="sp-supplier-name">
                                                    <div className="sp-avatar">
                                                        <i className="icon-account"></i>
                                                    </div>
                                                    <div className="sp-supplier-details">
                                                        <div>Supplier Reference</div>
                                                        <div>
                                                            <span className="sp-supplier-reference">{supplier['reference']}</span>
                                                            <span className="sp-yrs">|  {supplier['established']} years  |</span>
                                                             <div className="sp-ratings">
                                                                {ratingsElem}
                                                            </div>
                                                         </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-title="Response Time" >{supplier['response_time']} Hrs</td>
                                            <td data-title="Order Processed">{supplier['orders_processed']} Orders</td>
                                            <td data-title="MOQ">{supplier['moq']}</td>
                                            <td data-title="Choose">
                                                <div>
                                                    <input type="checkbox" name={supplier['id_supplier']} id={supplier['id_supplier']} value="on" defaultChecked={false}/>
                                                    <label for={supplier['id_supplier']} onClick={this.toggleSupplier.bind(this, supplier['id_supplier'], product['id_product'])}></label>
                                                </div>
                                            </td>
                                        </tr>
                                        )}):
                                        <tr>
                                            <td colSpan="5"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Results Found!</h2><p>Please try again with different area.</p></div></td>
                                        </tr>}
                                    </ReactCSSTransitionGroup>
                                </table>
                            </div>
                            <div className={this.state.supplierForm == 3 ?"sp-supplier-form-success":"sp-supplier-form-success hidden"}>
                                <p>Hurray! Quotation request sent succesfully</p>
                                <p>Selected suppliers received your quote will revert you shortly. Kobster Market Place will help you to connect with the selected suppliers. Stay tuned with Kobster Market Place</p>
                                <button className="button-blue" onClick={(e)=>this.setState({supplierForm: 1})}>Done</button>
                            </div>
                            <div className={this.state.supplierForm == 2 ?"sp-supplier-form":"sp-supplier-form hidden"}>
                                <div className="sp-form-group">
                                    <p className="sp-supplier-form-label">1. Will you buy this product?</p>   
                                    <div className="form-group-inline">
                                        <div className="form-group">
                                            <input type="radio"  value="regular" checked={this.state.showQuantity === 1 ? true:false}/>
                                            <label onClick={(e)=>{this.setState({showQuantity: 1})}}>Regular</label>
                                        </div>
                                        <div className="form-group">
                                            <input type="radio" value="one time" checked={this.state.showQuantity === 2 ? true:false}/>
                                            <label onClick={()=>this.setState({showQuantity: 2})}>One time</label>
                                        </div>
                                    </div>
                                </div>
                                <div className={this.state.showQuantity>0? "sp-form-group form-group-inline":"sp-form-group hidden"}>
                                {this.state.showQuantity==1?
                                    <div className="block">
                                        <p className="sp-supplier-form-label">How frequently?</p>   
                                        <div className="form-group-inline">
                                            <div className="form-group">
                                                <select ref="buying period" onChange={(e)=>this.setState({buyingPeriod: e.target.value})}>
                                                    <option value="">Select</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="quaterly">Quaterly</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                :null}
                                    <div className="block">
                                        <p className="sp-supplier-form-label">Please enter the quantity?</p>   
                                        <div className="form-group-inline">
                                            <div className="form-group">
                                                <input type="text" ref="quote_quantity"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="sp-form-group">
                                    <p className="sp-supplier-form-label">2. When you need this product?</p>   
                                    <div className="form-group-inline">
                                        <div className="form-group">
                                            <input type="radio" value="Immediately" checked={this.state.immediately === 1 ? true:false}/>
                                            <label onClick={()=>this.setState({immediately: 1})}>Immediately</label>
                                        </div>
                                        <div className="form-group">
                                            <input type="radio" checked={this.state.immediately === 2 ? true:false}/>
                                            <label onClick={()=>this.setState({immediately: 2})}>1 Month</label>
                                        </div>
                                    </div>
                                </div>
                                <div className="sp-form-group">
                                    <p className="sp-supplier-form-label">3. What is the deadline for quoting?</p>   
                                    <div className="form-group-inline">
                                        <div className="form-group">
                                            <Datepicker ref="datePicker" onChange={(date)=>this.setState({deadline: date})} disablePast={true}/>
                                        </div>
                                    </div>
                                </div>
                                <div className="sp-form-group">
                                    <p className="sp-supplier-form-label">4. Choose your payment term.</p>   
                                    <div className="form-group-inline">
                                        <button onClick={()=>this.setState({payment: 1})} className={this.state.payment === 1 ? "button-blue":""}>Advance </button>
                                        <button onClick={()=>this.setState({payment: 2})} className={this.state.payment === 2 ? "button-blue":""}>On Delivery </button>
                                        <select onChange={(e)=>{this.setState({payment: 0, credit: e.target.value})}}>
                                            <option value="0" selected={this.state.payment !=0}>Credit</option>
                                            <option value="1">7 Days</option>
                                            <option value="2">30 days</option>
                                            <option value="3">45 days</option>
                                        </select>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <button className="button-blue button-large" onClick={this.submitForm.bind(this)}>Get Quote</button>
                                </div>
                                <div className="form-group">
                                    <span className="back-btn" onClick={(e)=>this.setState({supplierForm: 1})}>Go Back</span>
                                </div>
                            </div>

                            <div className="sp-supplier-actions">
                                <div className={this.state.supplierForm == 1 ?"sp-action-wrapper":"sp-action-wrapper hidden"}>
                                    <p>You have selected {this.state.selectedSupplier.length} suppliers</p>
                                    <button className="button-blue button-large" onClick={this.toForm.bind(this)}>Next</button>
                                </div>
                            </div>
                        </div>
                        <div className={this.state.block === 2 ? "block-content active":"block-content"}>
                            <div className="sp-feature-lists">
                                <div className="sp-feature-title">
                                    Features and details
                                </div>
                                {product != undefined && product.features!=undefined && product.features.length > 0 ? product.features.map(feature => {
                                    return(
                                        <div className="sp-feature-item">
                                            <div className="sp-feature-name">{feature.name}</div>
                                            <div className="sp-feature-value">{feature.value}</div>
                                        </div>
                                        )
                                }):null}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

const mapStateToProps = function(store) {
  return {
    loading: store.productState.loading,
    product_details: store.productState.product_details,
    supplier_details: store.productState.supplier_details,
    zones: store.searchState.zones,
    addresses: store.addressState.address
  }
};

export default connect(mapStateToProps)(ProductDetails)  