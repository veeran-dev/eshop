import React from 'react'
import ReactDOM from 'react-dom';
import { connect } from 'react-redux'
import Confirmation  from './quotation-confirm'
import ReactImageFallback from "react-image-fallback";
import cookie from 'react-cookie'
import * as quotationsApi from '../../../api/quotations-api'
import * as G from '../../../api/common-api'
import store from '../../../store/configureStore'
import * as addressApi from '../../../api/address-api'

class QuotationDetailsMobile extends React.Component {
  constructor(props) {
      super(props);

      this.state = {
          hasMoreItems: true,
          page: 0,
          quotations: [],
          query: '',
          isMobile: false,
      };
  }
  
  componentWillMount(){
    addressApi.get();
  }

  toProduct =(id) =>{
    let old_url = window.location.href;
    var new_url = old_url.substring(0, old_url.indexOf("quotations/details"));
    var win = window.open(new_url+'productdetails/'+id, '_blank');
    win.focus();
  }

  toSaveAddress(shippingAddress, billingAddress){
    addressApi.saveAddressToCart(shippingAddress, billingAddress, this.context)
    G.closeModal(["quotationConfirmation"])
  }

  showConfirmation=(option, idSupplier, idQuoteRequest, price, expiry, e)=>{
      ReactDOM.render(<Confirmation
                          idState={this.props.quotations.id_state}
                          address={this.props.address} id_product={this.props.quotations.id_product}
                          name={this.props.quotations.name} quantity={this.props.quotations.quantity} expiry={expiry} key={option+"_key"} 
                          price={price} option={option}  idSupplier={idSupplier} toSaveAddress={this.toSaveAddress.bind(this)}
                          idQuoteRequest={idQuoteRequest} />, document.getElementById("quotationConfirmationContent"))
      G.displayModal("quotationConfirmation")
  }

  render() {
        let quotation = this.props.quotations
        let suppliers = this.props.suppliers
        return (
            <div className="quotation-detail-container">
              {quotation != undefined && quotation['id_quote_request'] > 0 ?
                    <div className="quotation-product-container">
                      <div id={quotation.id_quote_request+"_id"} className={quotation.id_quote_request+"_class quote_details_wrapper"}>
                        <div className="quote_details_image_block">
                            <ReactImageFallback
                              src={quotation.imageLink2}
                              fallbackImage="./img/p/en-default-large.jpg"
                              initialImage="./img/p/en-default-large.jpg"
                              alt={quotation.name}/>
                        </div>
                        <div className="quote_details_product_details">
                            <div className="quote_details_product_name_wrapper">
                                <p className="quote_details_product_name">
                                    {quotation.name} - <span>{quotation.reference}-{suppliers.length}</span>
                                </p>
                                <p className="quote_ref">
                                  <span>Quote Reference</span>
                                  {quotation.id_quote_request.padStart(6, '0')}
                                </p>
                            </div>
                            <div className="quote_details_block_bottom">
                                <div className="detail-block">
                                    <p className="label">Quantity</p>
                                    <p className="detail">{quotation.quantity}</p>
                                </div>
                                <div className="detail-block">
                                    <p className="label">Deadline</p>
                                    <p className="detail">{quotation.deadline}</p>
                                </div>
                                <div className="detail-block">
                                    <p className="label">Payment</p>
                                    <p className="detail">{quotation.payment}</p>
                                </div>
                                <div className="detail-block">
                                    <p className="label">Purchase For</p>
                                    <p className="detail">{quotation.buying_interval}</p>
                                </div>
                                <div className="detail-block">
                                    <p className="label">Purchase</p>
                                    <p className="detail">{quotation.purchase}</p>
                                </div>
                                <div className="detail-block">
                                    <p className="label">Delivery</p>
                                    <p className="detail">{quotation.location}</p>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  : <div className="quotation-product-container">
                      <div className="quote_details_wrapper">
                        <div className="quote_details_image_block">
                          <img src="./img/p/en-default-large.jpg" />
                        </div>
                        <div className="quote_details_product_details">
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                            <div className="fetching-content"><div className="loading-item"></div></div>
                        </div>
                      </div>
                    </div> }
                <div className="quotation-supplier-list">
                {suppliers != undefined && suppliers.length > 0 ? suppliers.map((supplier, i) =>{
                  let ratingsElem = [];
                  for(var j = 0; j < 5; j++){
                    if(suppliers != undefined && supplier['ratings'] > j)
                      ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
                    else
                      ratingsElem.push(<i className="icon-star-empty" key={j}></i>) 
                  }
                  return(
                    <div className="supplier_mobile_wrapper" key={(i+1)+"_key"}>
                        <div className="supplier" >
                            <div className="sp-supplier-reference">{supplier['reference']}</div>
                            <div className="sp-yrs">|  {supplier['est']} years  |</div>
                             <div className="sp-ratings">
                                {ratingsElem}
                            </div>
                        </div>
                        <div className="detail">
                          <p>Price</p>
                          <p>{supplier['high_price'] > 0 ? "Rs."+supplier['high_price'] : "NA"}</p>
                        </div>
                        <div className="detail">
                          <p>Price Expiry</p>
                          <p>{supplier['expiry'] != '0000-00-00' ? supplier['expiry']:"--"}</p>
                        </div>
                        <div className="action">
                            <div>
                              {supplier['expired'] == 0 && supplier['ready'] == 1 && quotation.quoted ==0 && supplier['denied'] ==0?
                              <button className="button-blue" onClick={this.showConfirmation.bind(this, 1, supplier['id_supplier'], quotation.id_quote_request, supplier['high_price'], supplier['expiry'])}>Accept</button>
                              : ""
                              }
                              {supplier['expired'] == 0 && supplier['ready'] == 1 && i < 2 && quotation.negotiated ==0 && quotation.quoted ==0 && supplier['denied'] ==0?
                                  <button className="button-black" onClick={this.showConfirmation.bind(this, 2, supplier['id_supplier'], quotation.id_quote_request, supplier['high_price'], supplier['expiry'])}>Negotiate</button> 
                              : null}
                              {supplier['denied'] == 1 ? <p>Sorry, supplier not interested</p> : null}
                              {supplier['ready'] == 0 ? <p>Please wait till deadline</p> : null}
                              {supplier['expiry'] != '0000-00-00' && supplier['expired'] == 1 && quotation.quoted == 0 ? <p>Sorry, quote expired</p> : null}
                              {quotation.quoted > 0 && supplier['id_supplier'] == quotation.quoted ? <p><i className="icon-check"></i></p> : quotation.quoted > 0 ? <p>NA</p>:""}
                            </div>
                        </div>
                    </div>)})
                    :
                    <div>
                        <div><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Results Found!</h2><p>Please try again with different area.</p></div></div>
                    </div>}
                </div>
                {/*
                {this.props.suppliers != undefined && this.props.suppliers.length > 0 && this.props.suppliers[0]['ready'] == 1 ?
                    <div className="quotation-redirect">
                        <p >Would you like to find more supplier ?</p>
                        <button className="button-blue" onClick={this.toProduct.bind(this, quotation.id_product)}>Yes, take me</button>                        
                    </div>:""}
                  */}
            </div>
        )
    }
}

QuotationDetailsMobile.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function(store) {
  return {
    quotations: store.quotationState.quotationDetails,
    suppliers: store.quotationState.suppliers,
    isFetching: store.quotationState.isFetching,
    address: store.addressState.address
  }
};

export default connect(mapStateToProps)(QuotationDetailsMobile)