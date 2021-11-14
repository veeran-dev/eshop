import React from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import {toastr} from 'react-redux-toastr'
import ReactImageFallback from "react-image-fallback";
import * as orderApi from '../../../api/orders-api';
import * as G from '../../../api/common-api';


class OrderDetailsDesktop extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      id_order_state: null,
      selectedProducts:[],
      selectAll: false,
      deliverySchedule: [],
      deliveryPlans: [],
      showDetails: 0,
      drAckFiles: [],
      canceledProducts: [],
    }
  }

  componentWillMount() {
    window.addEventListener("click", this.outerControl.bind(this));    
    orderApi.viewOrder(this.props.parent_order).then(response =>{
    });

  }

  componentWillUnmount(){
    window.removeEventListener("click", this.outerControl.bind(this));
  }

  _splitButton(e) {

    let allElem = document.getElementsByClassName('split-button-dropdown')
    if(e.target.nextSibling.classList.contains("hidden")){
      for(var i = 0; i < allElem.length; i++){
          allElem[i].classList.add("hidden")
          e.target.nextSibling.classList.remove("hidden")
      }
    }
    else{
      e.target.nextSibling.classList.add("hidden")
      for(var i = 0; i < allElem.length; i++)
          allElem[i].classList.add("hidden")
    }
}

  outerControl(event){
    var allElem = document.getElementsByClassName('split-button-dropdown');
    for(var i=0; i < allElem.length; i++){
        let box = allElem[i]
        if(event.target != box && event.target.parentNode != box){
          if(box && box.style.display != undefined)
            if(!box.classList.contains("hidden") && !event.target.classList.contains("split-button-arrow"))
              box.className += " hidden"
        }
    }
  }

  fethcAddress(address){
    let ad = "";
    return address.split('<br />').map((element, i) =>{
          return(<p className={i == 0 ? "head":""}>{element}</p>)
        })
  }

  downloadFiles(num, type){
    let url = "";
    if(type == 0){
      url ="/index.php?controller=pdf-invoice&id_par_delivery="+num
      window.open(url);
    }
    else if(type == 1){
      G.downloadAll(num[0]['files'])
    }
    else if(type == 2){
      G.downloadAll(num)
    }
    else if(type == 3){
      url ="/index.php?controller=pdf-invoice&id_order="+num
      window.open(url);
    }
    else if(type == 4){
      this.props.orderDetails[0]['po_file'].map(file =>{
        window.open("../"+file);
      })
    }
  }

  render(){
    return (
      <div>
      {this.props.isFetching == true ? <div id="loader"><div className="spinner"></div></div> : null}
        <div className="page-header">
          <h3 className="page-title">Order Details</h3>
        </div> 
        <div className="order-detail-container">
          <div className="content-section heading">
            {this.props.orderDetails['0'] !=undefined ? <div className="title">Order <span>#{this.props.orderDetails['0']['id_order']}</span><span className="order-status" style={{backgroundColor: this.props.orderDetails['0']['color']}}>{this.props.orderDetails['0']['order_status']}</span></div>:null}
          </div>
          <div className="content-section">
            <div className="order-sections order-detail">
              <div className="title">Order</div>
              <div className="body">
                <p><span>User : </span>
                  <span>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['firstname']: ''}</span>
                </p>
                <p><span>Email : </span>
                  <span>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['email']: ''}</span>
                </p>
                <p><span>Supplier : </span>
                  <span>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['supplier_company']: ''}</span>
                </p>
                <p><span>Order Placed : </span><span>{this.props.orderDetails['0'] !=undefined &&this.props.orderDetails['0']['order_date'] != null? G.getDate(this.props.orderDetails['0']['order_date'], "lll"): 'Not Available'}</span></p>
                <p><span>Purchase Order: </span>{this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['po_number'] !="" ? <span>{this.props.orderDetails['0']['po_number']}</span>: <span>NA</span>}</p>
                <p>
                  <span>PO Download: </span>
                  {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['po_file'] !="" ? 
                    <span className="po-download" onClick={this.downloadFiles.bind(this, "", 4)}><i className="icon-download"></i> Download </span>
                    : <span>NA</span> }</p>
                <p><span>SEZ:</span><span>{this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['isez'] !=undefined && this.props.orderDetails['0']['isez'] ==1 ? 'SEZ': '--'}</span></p>
              </div>
            </div>
            <div className="order-sections order-detail">
              <div className="title">Amount</div>
              <div className="body">
                <p><div>Total Value Tax Excl: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['total_paid_tax_excl']) : '0.00'} </p>
                <p><div>Total GST Value: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['gst']) : '0.00'} </p>
                <p><div>Total Discount: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['total_discounts']) : '0.00'} </p>
                <p><div>Total Amount Tax Incl: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['total_paid_tax_incl']) : '0.00'} </p>
                <p><div>Payment Mode: </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['payment'] =="PENDING FOR APPROVAL"? "--" : this.props.orderDetails['0']['payment'] : 'NA'} </p>
              </div>   
            </div>
            <div className="order-sections address">
              <div className="title">Delivery Address</div>
              <div className="body">
                  {this.props.deliveryAddress != undefined && this.props.deliveryAddress.length>0 ?this.fethcAddress(this.props.deliveryAddress):null}</div>
            </div>
            <div className="order-sections address">
              <div className="title">Billing Address</div>
              <div className="body">
                  {this.props.invoiceAddress != undefined && this.props.invoiceAddress.length>0 ?this.fethcAddress(this.props.invoiceAddress):null}</div>
            </div>
          </div>
          {this.props.orderDetails['0'] !=undefined ?
            <div className="content-section accept-section">
              <div className="left-section">
                <div className="products-list">
                <div className="table-filter">
                  <div>
                    <h3>Product Lists</h3>
                  </div>
                </div>
                  <table>
                    <thead>
                      <tr>  
                        <th>S.No</th>
                        <th className="text-align-left">Image</th>
                        <th className="text-align-left">Product</th>
                        <th className="text-align-center">Status</th>
                        <th className="text-align-right">Unit Price (Tax Excl)</th>
                        <th className="text-align-right">GST</th>
                        <th className="text-align-center">Quantity</th>
                        <th className="text-align-right">Total (Tax Incl)</th>
                      </tr>
                    </thead>
                    <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} transitionEnterTimeout={500} transitionLeaveTimeout={300} component="tbody">
                      {this.props.isFetching ? <tr><td className="fetching" colSpan="8"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></td></tr> : 
                        (this.props.orderDetailProducts != undefined ? this.props.orderDetailProducts.map((products, i) => {
                          return (
                            <tr key={products.id_order_detail} id={products.id_order_detail+"_tr"}>
                                <td>{i+1}</td>
                                <td data-title="Image">
                                  <ReactImageFallback
                                    src={products.image_link}
                                    fallbackImage=".././img/p/en-default-small_default.jpg"
                                    initialImage=".././img/p/en-default-small_default.jpg"
                                    alt={products.product_name}/>
                                </td>
                                <td data-title="Product"><p id={"name_"+products.id_order_detail}>{products.product_name}</p><span><strong> {products.product_reference}</strong></span></td>
                                <td className="text-align-center" data-title="Status" ><span className="status">{products.name =="New Order" ? "Being Processed":products.name}</span> <br/> <span>Scheduled Delivery : {products.estimated_delivery_time != '0000-00-00 00:00:00' ? G.getDate(products.estimated_delivery_time, "ll") : "NA"}</span></td>
                                <td className="text-align-right" data-title="Unit Price">{G.toPrice(products.unit_price_tax_excl)}</td>
                                <td className="text-align-right" data-title="GST">{products.gst.replace("GST", "")}</td>
                                <td className="text-align-center" data-title="Quantity" id={products.id_order_detail+"_qty"} ref={products.id_order_detail+"_qty"}>{products.product_quantity}</td>
                                <td className="text-align-right" data-title="Total Tax Incl">{G.toPrice(products.total_price_tax_incl)}</td>
                            </tr> 
                          );
                        }) : <tr className="no-results-wrapper"><td colSpan="8"><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No Products Found!</h2><p>There is no products in your order.<br/> please contact your Relationship Manager for any issues</p></div></td></tr>)
                      }
                  </ReactCSSTransitionGroup>
                  </table>
                </div>
              </div>
            </div>
          :null}
          <div className="content-section edt-groups">
                {this.props.deliveryPlans != undefined && this.props.deliveryPlans.length>0 ?
                  <div className="page-title">
                    <h3>Shipment List</h3>
                  </div>
                :null}
                {this.props.deliveryPlans != undefined && this.props.deliveryPlans.length>0 ? this.props.deliveryPlans.map( delivery=>{
                  <div className="page-title">
                    <h3>Shipment List</h3>
                  </div>
                  return(
                  <div className="edt-wrapper" >
                    <div className="title-section">
                      <div className="block"><span className="head"><h3>Created ON:</h3></span><span className="detail">{G.getDate(delivery[0].created, "ll")}</span></div>
                    </div>
                    <div className="detail-section">
                      <div className="wrap">
                        <div className="block-head"><h3>Shipment</h3></div>
                        <div className="block"><span className="head">Scheduled Delivery:</span><span className="detail">{G.getDate(delivery[0].estimated_delivery_time, "ll")}</span></div>
                        <div className="block"><span className="head">Total Products:</span><span className="detail">{delivery.length} Products</span></div>
                        <div className="block"><span className="head">Total value:</span><span className="detail">{G.toPrice(delivery[0].sm)}</span></div>
                      </div>
                      <div className="wrap">
                        <div className="block-head"><h3>Delivery Receipt</h3></div>
                        {delivery[0].delivery_number  ? 
                        <div>
                        <div className="block"><span className="head">DR Number:</span><span className="detail">{delivery[0].delivery_number }</span></div>
                        <div className="block"><span className="head">DR Date:</span><span className="detail">{G.getDate(delivery[0].dr_date, "ll")}</span></div>
                        <div className="block">
                          <div className="split-button">
                            <div className={"split-button-default-action"}>
                              <button >Downloads</button>
                              <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                              <ul className={"split-button-dropdown hidden"}>
                                {delivery[0].delivery_number  ?
                                <li className={"active"} onClick={this.downloadFiles.bind(this, delivery[0].id_delivery, 0)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                    <i className="icon-download"></i><span>Delivery Receipt</span>
                                  </a>                                      
                                </li>
                                :null}
                                {delivery[0]['dr_Ack'] != undefined && delivery[0]['dr_Ack'].length > 0?
                                <li className={"active"} onClick={this.downloadFiles.bind(this, delivery[0]['dr_Ack'], 1)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                    <i className="icon-download"></i><span>Delivery ACK</span>
                                  </a>                                      
                                </li>
                                :null}
                              </ul>
                            </div>
                          </div>
                        </div>
                        </div>
                        :<div className="no-data">
                          <h3>No Shipment Found!</h3>
                          <p>Please create shipment to see details</p>
                        </div>}
                      </div>
                      <div className="wrap">
                        <div className="block-head"><h3>Invoice </h3></div>
                        {delivery[0].inv_number  ? 
                        <div>
                        <div className="block"><span className="head">Invoice No:</span><span className="detail">{delivery[0].inv_number}</span></div>
                        <div className="block"><span className="head">Invoice Date:</span><span className="detail">{G.getDate(delivery[0].inv_date, "ll")}</span></div>
                        <div className="block">
                          <div className="split-button">
                            <div className={"split-button-default-action"}>
                              <button >Downloads</button>
                              <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                              <ul className={"split-button-dropdown hidden"}>
                                {delivery[0]['inv_number'] > 0 ?
                                <li className={"active"} onClick={this.downloadFiles.bind(this, delivery[0]['id_order'], 3)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                    <i className="icon-download"></i><span>Invoice</span>
                                  </a>                                      
                                </li>
                                :null}
                                {delivery[0]['inv_Ack'] != undefined?
                                <li className={"active"} onClick={this.downloadFiles.bind(this, delivery[0]['inv_Ack'], 2)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                    <i className="icon-download"></i><span>Invoice ACK</span>
                                  </a>                                      
                                </li>
                                :null}
                              </ul>
                            </div>
                          </div>
                        </div>
                        </div>
                        :<div>
                        <div className="no-data">
                          <h3>No Invoice Raised!</h3>
                          <p>Please create invoice to see details</p>
                        </div>
                        {delivery[0]['inv_Ack'] != undefined?
                          <div className="block">
                            <div className="split-button">
                              <div className={"split-button-default-action"}>
                                <button >Downloads</button>
                                <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                                <ul className={"split-button-dropdown hidden"}>
                                  {delivery[0]['inv_Ack'] != undefined?
                                  <li className={"active"} onClick={this.downloadFiles.bind(this, delivery[0]['inv_Ack'], 2)}>
                                    <a className="button button-blue outline" href='javascript:void(0)'>
                                      <i className="icon-download"></i><span>Invoice ACK</span>
                                    </a>                                      
                                  </li>
                                  :null}
                                </ul>
                              </div>
                            </div>
                          </div>:null}
                          </div>
                      }
                      </div>
                      <div className="wrap">
                        <div className="block"><span className="head">Status:</span><span className="detail">{delivery[0].name =="New Order" ? "Being Processed":delivery[0].name}</span></div>
                      </div>
                    </div>
                    <div className="product-section">
                    <div className="more" onClick={(e)=>this.setState({showDetails: this.state.showDetails==delivery[0].id_order?0:delivery[0].id_order})}>View Products</div>
                    <div className={this.state.showDetails == delivery[0].id_order ? "table show": "table"}>
                      <table className="animated">
                        <thead>
                          <tr>
                          <th className="text-align-left">PRODUCT</th>
                          <th className="text-align-center">UNIT PRICE (TAX EXCL)</th>
                          <th className="text-align-center">GST</th>
                          <th className="text-align-center">QUANTITY  </th>
                          <th className="text-align-right">TOTAL PRICE(TAX INCL)</th>
                          </tr>
                        </thead>
                        <tbody>
                        {delivery.map(product =>{
                          return(
                            <tr key={product.id_order_detail} >
                                <td className="product-name"><span>{product.product_name}</span><span> | <strong>{product.product_reference}</strong></span></td>
                                <td className="text-align-center">{G.toPrice(product.unit_price_tax_excl)}</td>
                                <td className="text-align-center">{product.gst.replace("GST", "")}</td>
                                <td className="text-align-center">{product.product_quantity}</td>
                                <td className="text-align-right">{G.toPrice(product.total_price_tax_incl)}</td>
                            </tr>
                          )
                        })}
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>)
              }):null}
            </div>
          {this.props.canceledProducts.length > 0 ? 
            <div className="content-section">
              <div className="left-section">
                <div className="products-list">
                  <div className="page-title">
                    <h3>Canceled Products</h3>
                  </div>
                  <table>
                    <thead>
                      <tr>  
                        <th>S.NO</th>
                        <th className="text-align-left">Image</th>
                        <th className="text-align-left">Product</th>
                        <th className="text-align-center">Status</th>
                        <th className="text-align-right">Unit Price (Tax Excl)</th>
                        <th className="text-align-right">GST</th>
                        <th className="text-align-center">Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                      {this.props.canceledProducts.map((products, i) => {
                        return (
                          <tr key={products.id_order_detail}>
                              <td>{i+1}</td>
                              <td data-title="Image">
                                <ReactImageFallback
                                  src={products.imageLink}
                                  fallbackImage=".././img/p/en-default-small_default.jpg"
                                  initialImage=".././img/p/en-default-small_default.jpg"
                                  alt={products.imageLink}/>
                              </td>
                              <td data-title="Product"><p>{products.name}</p><span> <strong>{products.reference}</strong></span></td>
                              <td className="text-align-center" data-title="Status" ><span className="status">Canceled</span></td>
                              <td className="text-align-right" data-title="Unit Price">{G.toPrice(products.unit_price_tax_excl)}</td>
                              <td className="text-align-right" data-title="GST">{this.props.orderDetails['0']['isez'] == 1 ? "0%": products.tax_name}</td>
                              <td className="text-align-center" data-title="Quantity" >{products.product_quantity}</td>
                          </tr> 
                        );
                      })}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>:null}
        </div>
      </div>
    )
  }
}

OrderDetailsDesktop.contextTypes = {
  router: React.PropTypes.object.isRequired
};

const mapStateToProps = function({orderState}) {
  return {
    orderDetails: orderState.orderDetails,
    orderDetailProducts: orderState.orderDetailProducts,
    deliveryPlans: orderState.deliveryPlans,
    canceledProducts: orderState.canceledProducts,
    invoiceAddress: orderState.billingAddress,
    deliveryAddress: orderState.shippingAddress,
    isFetching: orderState.isFetching,
  };
};

export default connect(mapStateToProps)(OrderDetailsDesktop);