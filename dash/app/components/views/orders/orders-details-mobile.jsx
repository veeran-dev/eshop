import React, {PropTypes} from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import {toastr} from 'react-redux-toastr'
import ReactImageFallback from "react-image-fallback";
import * as orderApi from '../../../api/orders-api';
import * as G from '../../../api/common-api';


class OrderDetailsMobile extends React.Component {
  constructor(props){
    super(props)
    this.state = {
      id_order_state: null,
      selectedProducts:[],
      selectAll: false,
      run: false,
      deliverySchedule: [],
      canceledProducts: [],
      events: [],
      deliveryPlans: [],
      showDetails: 0,
      drAckFiles: [],
      removeProductsList: [],
      allProductScheduled: false,
      orderDetailProducts: [],
      scheduleLoop: 0,
    }
  }

  componentDidMount() {
    window.addEventListener("click", this.outerControl.bind(this));
    const parent_order = this.props.parent_order
    orderApi.viewOrder(parent_order).then(response =>{
      this.setState({
        orderDetailProducts: response.data[3], 
        deliveryPlans: response.data[6], 
        canceledProducts: response.data[8],
        hours: response.data[9].split(":")[0]
      },()=>this.checkScheduled())
      return response
    })
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

  expand(element){
    console.log(element.currentTarget)
    // var element = document.getElementById("myDIV");
    element.currentTarget.classList.toggle("expand");
  }

  render(){
    let delivery_number = this.props.orderDetails['0'] != undefined && this.props.orderDetails['0']['delivery_number'] >0 ? (this.props.orderDetails['0']['dr_prefix']+""+this.props.orderDetails['0']['delivery_number']):null;
    return (
        <div>
        {this.props.isFetching == true ? <div className="loader"><div className="spinner"></div></div> : null}
        
          <div className="page-header">
            <h3 className="page-title">Order Details</h3>
          </div> 
          <div className="order-detail-container order-detail-responsive-container">
            <div className="content-section heading">
                {this.props.orderDetails['0'] !=undefined ? 
                <div className="title">
                  <div className="sect1">Order <span>#{this.props.orderDetails['0']['id_order']}</span></div>
                  <div className="sect2">
                    <div className="order-status" style={{backgroundColor: this.props.orderDetails['0']['color']}}></div>
                    <span>{this.props.orderDetails['0']['order_status']}</span>
                  </div>
                </div>
                :null}
            </div>
            <div className="content-section">
              <div className="order-sections order-detail">
                <div className="title expand" onClick={this.expand.bind(this)}><span>Order</span> <span><i className="icon-arrow-down" ></i></span></div>
                <div className="body">
                  <div className="body-wrapper">
                  <p><div>User : </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['firstname']: ''}</p>
                  <p><div>Email : </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['email']: ''}</p>
                  <p><div>Supplier : </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['supplier_company']: ''}</p>
                  <p><div>Order Placed : </div>{this.props.orderDetails['0'] !=undefined ? G.getDate(this.props.orderDetails['0']['order_date'], "lll"): ''}</p>
                  <p><div>Purchase Order: </div>{this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['po_number'] !="" ? this.props.orderDetails['0']['po_number']: 'NA'}</p>
                  <p>
                    <div>PO Download: </div>
                    {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['po_file'] !="" ? 
                      <span className="po-download" onClick={this.downloadFiles.bind(this, "", 4)}><i className="icon-download"></i> Download </span>
                      : "NA"}</p>
                  <p><div>SEZ:</div>{this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['isez'] !=undefined && this.props.orderDetails['0']['isez'] ==1 ? 'SEZ': '--'}</p>
                  </div>
                </div>
              </div>
              <div className="order-sections order-detail">
                <div className="title" onClick={this.expand.bind(this)}><span>Amount</span> <span><i className="icon-arrow-down" ></i></span></div>
                <div className="body">
                <div className="body-wrapper">
                  <p><div>Total Value Tax Excl: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['total_paid_tax_excl']) : '0.00'} </p>
                  <p><div>Total GST Value: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['gst']) : '0.00'} </p>
                  <p><div>Total Discount: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['total_discounts']) : '0.00'} </p>
                  <p><div>Total Amount Tax Incl: </div>{this.props.orderDetails['0'] !=undefined ? G.toPrice(this.props.orderDetails['0']['total_paid_tax_incl']) : '0.00'} </p>
                  <p><div>Payment Mode: </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['payment'] : 'NA'} </p>
                </div>
                </div>   
              </div>
              <div className="order-sections address">
                <div className="title" onClick={this.expand.bind(this)}><span>Delivery Address</span> <span><i className="icon-arrow-down" ></i></span></div>
                <div className="body">
                <div className="body-wrapper">
                    {this.props.deliveryAddress != undefined && this.props.deliveryAddress.length >0 ?this.fethcAddress(this.props.deliveryAddress):null}
                </div>
                </div>
              </div>
              <div className="order-sections address">
                <div className="title" onClick={this.expand.bind(this)}><span>Billing Address</span> <span><i className="icon-arrow-down" ></i></span></div>
                <div className="body">
                  <div className="body-wrapper">
                    {this.props.invoiceAddress != undefined && this.props.invoiceAddress.length>0 ?this.fethcAddress(this.props.invoiceAddress):null}
                  </div>
                </div>
              </div>
            </div>
            {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] == 22 ?
            <div className="content-section">
              <div className="left-section">
                <div className="products-list">
                <div className="header">
                  <div>
                    <p>Products Lists</p>
                  </div>
                </div>
                  <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} transitionEnterTimeout={500} transitionLeaveTimeout={300} component="div" className="list-item-wrapper">
                    {this.props.isFetching ? <div><div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div><div></div></div> : 
                        (this.state.orderDetailProducts != undefined ? this.state.orderDetailProducts.map(products => {
                          return (
                            <div key={products.id_order_detail} className="list-item">
                                <div className="product-detail-wrapper">
                                  <div className="product-image">
                                    <ReactImageFallback
                                        src={products.image_link}
                                        fallbackImage=".././img/p/en-default-small_default.jpg"
                                        initialImage=".././img/p/en-default-small_default.jpg"
                                        alt={products.product_name}/>
                                  </div>
                                  <div className="product-detail">
                                    <div className="name-section">
                                      <p id={"name_"+products.id_order_detail}>{products.product_name} <strong>{products.product_reference}</strong></p>
                                    </div>
                                    <div className="price-section">
                                      <div className="group"><span>Unit Price</span><span>{G.toPrice(products.unit_price_tax_excl)}</span></div>
                                      <div className="group"><span>GST</span><span>{G.toPrice(products.gst.replace("GST", ""))}</span></div>
                                      <div className="group"><span>Quantity</span><span id={products.id_order_detail+"_qty"} ref={products.id_order_detail+"_qty"}>{products.product_quantity}</span></div>
                                      <div className="group"><span>Total Price</span><span>{G.toPrice(products.total_price_tax_incl)}</span></div>
                                    </div>
                                  </div>
                                </div>                                
                                <div className="status-section">
                                  <div className="left">
                                  <div className="order-status" style={{backgroundColor: products.color}}></div>
                                    <span className="status">{products.name =="New Order" ? "Being Processed":products.name}</span>
                                  </div>
                                  <div className="right">
                                    <span>Delivery : {products.estimated_delivery_time != '0000-00-00 00:00:00' ? G.getDate(products.estimated_delivery_time, "ll") : "NA"}</span>
                                  </div>
                                </div>
                                
                            </div> 
                          );
                        }) : <div className="no-results-wrapper"><div><div className="no-results"><img src="./dash/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>Please check with your customers</p></div></div></div>)
                      }
                  </ReactCSSTransitionGroup>
                </div>
              </div>
            </div>:null}
            {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] != 22 ?
            <div className="content-section">
              <div className="left-section">
                <div className="products-list">
                <div className="header">
                  <div>
                    <p>Products Lists</p>
                  </div>
                </div>
                  <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} transitionEnterTimeout={500} transitionLeaveTimeout={300} component="div" className="list-item-wrapper">
                    {this.props.isFetching ? <div><div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div><div></div></div> : 
                        (this.state.orderDetailProducts != undefined ? this.state.orderDetailProducts.map(products => {
                          return (
                            <div key={products.id_order_detail} className="list-item">
                                <div className="product-detail-wrapper">
                                  <div className="product-image">
                                    <ReactImageFallback
                                        src={products.image_link}
                                        fallbackImage=".././img/p/en-default-small_default.jpg"
                                        initialImage=".././img/p/en-default-small_default.jpg"
                                        alt={products.product_name}/>
                                  </div>
                                  <div className="product-detail">
                                    <div className="name-section">
                                      <p>{products.product_name} <strong>{products.product_reference}</strong></p>
                                    </div>
                                    <div className="price-section">
                                      <div className="group"><span>Unit Price</span><span>{G.toPrice(products.unit_price_tax_excl)}</span></div>
                                      <div className="group"><span>GST</span><span>{products.gst.replace("GST", "")}</span></div>
                                      <div className="group"><span>Quantity</span><span id={products.id_order_detail+"_qty"} ref={products.id_order_detail+"_qty"}>{products.product_quantity}</span></div>
                                      <div className="group"><span>Total Price</span><span>{G.toPrice(products.total_price_tax_incl)}</span></div>
                                    </div>
                                  </div>
                                </div>                                
                                <div className="status-section">
                                  <div className="left">
                                  <div className="order-status" style={{backgroundColor: products.color}}></div>
                                    <span className="status">{products.name =="New Order" ? "Being Processed":products.name}</span>
                                  </div>
                                  <div className="right">
                                    <span>Delivery : {products.estimated_delivery_time != '0000-00-00 00:00:00' ? G.getDate(products.estimated_delivery_time, "ll") : "NA"}</span>
                                  </div>
                                </div>
                                
                            </div> 
                          );
                        }) : <div className="no-results-wrapper"><div><div className="no-results"><img src="./dash/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>Please check with your customers</p></div></div></div>)
                      }
                  </ReactCSSTransitionGroup>
                </div>
              </div>
            </div>:null}
            <div className="content-section edt-groups">
                {this.state.deliveryPlans != undefined && this.state.deliveryPlans.length>0 ?
                  <div className="page-title">
                    <h3>Shipment List</h3>
                  </div>
                :null}
                {this.state.deliveryPlans != undefined && this.state.deliveryPlans.length>0 ? this.state.deliveryPlans.map( delivery=>{
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
                        :<div class="no-data">
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
                        :<div class="no-data">
                          <h3>No Invoice Found!</h3>
                          <p>Please create invoice to see details</p>
                        </div>}
                      </div>
                      <div className="wrap">
                        <div className="block"><span className="head">Status:</span><span className="detail">{delivery[0].name}</span></div>
                      </div>
                    </div>
                    <div className="product-section">
                    <div className="more" onClick={(e)=>this.setState({showDetails: this.state.showDetails==delivery[0].id_order?0:delivery[0].id_order})}>View Products</div>
                      <div className={this.state.showDetails == delivery[0].id_order ? "table show": "table"}>
                        {delivery.map(product =>{
                          return(
                            <div className="table-row" key={product.id_order_detail} >
                                <div><span>{product.product_name}</span><span><strong> {product.product_reference}</strong></span></div>
                                <div className="bottom-row">
                                  <div>{G.toPrice(product.unit_price_tax_excl)}</div>
                                  <div>{product.  gst.replace("GST", "")}</div>
                                  <div>{product.product_quantity}</div>
                                  <div>{G.toPrice(product.total_price_tax_incl)}</div>
                                </div>
                            </div>
                          )
                        })}
                      </div>
                  </div>
                  </div>)
              }):null}
            </div>
            {this.state.canceledProducts.length > 0 ? 
            <div className="content-section">
              <div className="left-section">
                <div className="products-list">
                <div className="header">
                  <div>
                    <p>Canceled Products</p>
                  </div>
                </div>
                  <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} transitionEnterTimeout={500} transitionLeaveTimeout={300} component="div" className="list-item-wrapper">
                    {this.props.isFetching ? <div><div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div><div></div></div> : 
                        (this.state.canceledProducts.map((products, i) => {
                          return (
                            <div key={"removeProduct_"+products.id_product+"_"+i} className="list-item">
                                <div className="product-detail-wrapper">
                                  <div className="product-image">
                                    <ReactImageFallback
                                        src={products.image_link}
                                        fallbackImage=".././img/p/en-default-small_default.jpg"
                                        initialImage=".././img/p/en-default-small_default.jpg"
                                        alt={products.name}/>
                                  </div>
                                  <div className="product-detail">
                                    <div className="name-section">
                                      <p>{products.name} <strong> {products.reference}</strong></p>
                                    </div>
                                    <div className="price-section">
                                      <div className="group"><span>Unit Price</span><span>{G.toPrice(products.unit_price_tax_excl)}</span></div>
                                      <div className="group"><span>GST</span><span>{this.props.orderDetails['0']['isez'] == 1 ? "0%": products.tax_name}</span></div>
                                      <div className="group"><span>Quantity</span><span id={products.id_order_detail+"_qty"} ref={products.id_order_detail+"_qty"}>{products.product_quantity}</span></div>
                                    </div>
                                  </div>
                                </div>                                
                            </div> 
                          )
                        }) : null)
                      }
                  </ReactCSSTransitionGroup>
                </div>
              </div>
            </div>:null}
          </div> 
      </div>
    )
  }
}

const mapStateToProps = function({orderState}) {
  return {
    orderDetails: orderState.orderDetails,
    orderDetailProducts: orderState.orderDetailProducts,
    deliveryPlans: orderState.deliveryPlans,
    canceledProducts: orderState.canceledProducts,
    invoiceAddress: orderState.billingAddress,
    deliveryAddress: orderState.shippingAddress,
    isFetching: false,
  };
};
export default connect(mapStateToProps)(OrderDetailsMobile);