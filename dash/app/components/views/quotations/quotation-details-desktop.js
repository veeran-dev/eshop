import React from 'react'
import ReactDOM from 'react-dom';
import { connect } from 'react-redux'
import ReactImageFallback from "react-image-fallback";
import MiniConfirmation  from './mini-quotation-confirm'
import * as quotationsApi from '../../../api/quotations-api'
import * as G from '../../../api/common-api'
import * as addressApi from '../../../api/address-api'
import store from '../../../store/configureStore'

class QuotationDetailsDesktop extends React.Component {
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

  showMiniConfirmation=(option, idSupplier, idQuoteRequest, price, expiry, e)=>{
    quotationsApi.confirmQuotation(idQuoteRequest, idSupplier, price, 1).then(response => {
        ReactDOM.render(<MiniConfirmation msg={response.data['message']}/>, document.getElementById("quotationMiniConfirmationContent"))
        G.displayModal("quotationMiniConfirmation")
        quotationsApi.getQuotationsDetails(idQuoteRequest);
      return response.data
    })
  }

  // showConfirmation=(option, idSupplier, idQuoteRequest, price, expiry, e)=>{
  //     ReactDOM.render(<Confirmation
  //                         idState={this.props.quotations.id_state}
  //                         address={this.props.address} id_product={this.props.quotations.id_product}
  //                         name={this.props.quotations.name} quantity={this.props.quotations.quantity} expiry={expiry} key={option+"_key"} 
  //                         price={price} option={option}  idSupplier={idSupplier} toSaveAddress={this.toSaveAddress.bind(this)}
  //                         idQuoteRequest={idQuoteRequest} />, document.getElementById("quotationConfirmationContent"))
  //     G.displayModal("quotationConfirmation")
  // }
    render() {
        let  quotation = this.props.quotations
        let  suppliers = this.props.suppliers
        return (
            <div className="quotation-detail-container">
              {quotation != undefined && quotation['id_quote_request'] > 0 ?
                    <div className="quotation-product-container">
                      <div key={quotation.id_quote_request+"_id"} id={quotation.id_quote_request+"_id"} className={quotation.id_quote_request+"_class quote_details_wrapper"}>
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
                                    {quotation.name} - <span>{quotation.reference}</span>
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
                          <img src="http://localhost/kobstereshop/img/p/en-default-large.jpg" />
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
                    <table>
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th className="text-align-left">Supplier</th>
                                <th >Price (Tax Excl)</th>
                                <th >Expiry</th>
                                <th >Action</th>
                            </tr>
                        </thead>
                        {suppliers != undefined && suppliers.length > 0 ? suppliers.map((supplier, i) =>{
                          let ratingsElem = [];
                          for(var j = 0; j < 5; j++){
                            if(suppliers != undefined && supplier['ratings'] > j)
                              ratingsElem.push(<i className="icon-star-filled" key={j}></i>)
                            else
                              ratingsElem.push(<i className="icon-star-empty" key={j}></i>) 
                          }
                          return(
                            <tr >
                                <td data-title="S.no">{i+1}</td>
                                <td data-title="Supplier" className="supplier" >
                                    <div className="sp-supplier-name">
                                        <div className="sp-supplier-details">
                                            <span><i className="icon-account"></i></span>
                                            <span className="sp-supplier-reference">{supplier['reference']}</span>
                                            <span className="sp-yrs">|  {supplier['est']} years  |</span>
                                             <span className="sp-ratings">
                                                {ratingsElem}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td data-title="Price" >{supplier['low_price'] > 0 ? "Rs."+supplier['low_price'] : "NA"}</td>
                                <td data-title="Expiry">{supplier['expiry'] != '0000-00-00' ? supplier['expiry']:"--"}</td>
                                <td data-title="Action" className="action">
                                    <div>
                                      {supplier['expired'] == 0 && supplier['ready'] == 1 && quotation.quoted ==0 && supplier['denied'] ==0?
                                          <button className="button-blue" onClick={this.showMiniConfirmation.bind(this, 1, supplier['id_supplier'], quotation.id_quote_request, supplier['low_price'], supplier['expiry'])}>Accept</button>
                                      : ""
                                      }
                                      {supplier['denied'] == 1 ? <p>Sorry, supplier not interested</p> : null}
                                      {supplier['ready'] == 0 ? <p>Please wait till deadline</p> : null}
                                      {supplier['expiry'] != '0000-00-00' && supplier['expired'] == 1 && quotation.quoted == 0 ? <p>Sorry, quote expired</p> : null}
                                      {quotation.quoted > 0 && supplier['id_supplier'] == quotation.quoted ? <p><i className="icon-check"></i></p> : quotation.quoted > 0 ? <p>NA</p>:""}
                                    </div>
                                </td>
                            </tr>)})
                            :
                            <tr>
                                <td colSpan="5"><div className="no-results"><img src="dash/img/no-data.png" alt="No Results"/><h2>No Results Found!</h2><p>Please try again with different area.</p></div></td>
                            </tr>}
                    </table>
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


QuotationDetailsDesktop.contextTypes = {
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

export default connect(mapStateToProps)(QuotationDetailsDesktop)