import React, {PropTypes} from 'react';
import ReactDOM from 'react-dom'
import { connect } from 'react-redux';
import ReactCSSTransitionGroup from 'react-addons-css-transition-group';
import {toastr} from 'react-redux-toastr'
import ReactImageFallback from "react-image-fallback";
import ConfirmationPop from '../../../components/common/ConfirmationContent'
import CalendarPop from '../../common/ScheduleCalendar'
import DateBox from '../../../components/common/dateBox'
import UploadFile from '../../common/upload'
import Timer from '../../common/Timer'
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

  resetOrder() {
    const parent_order = this.props.parent_order
    let items = document.getElementsByClassName("selectProduct")
    let selectAll = document.getElementById('all_action')
    selectAll.checked = false;
    for(let item of items){
      item.classList.remove("selected")
      item.checked = false
      item.disabled= false
    }
    orderApi.viewOrder(parent_order).then(response =>{
      this.setState({
        events: [],
        selectedProducts: [],
        deliverySchedule: [],
        orderDetailProducts: response.data[3], 
        deliveryPlans: response.data[6], 
        canceledProducts: response.data[8],
        hours: response.data[9].split(":")[0]
      },()=>this.checkScheduled())
      return response
    })
  }

  checkScheduled(){
    if(this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] == 6){
      return false;
    }
    let a = 0;
    let x = this.state.deliveryPlans.length > 0 ? this.state.deliveryPlans.map(d=>{a += d.length}) : 0;
    let length = this.state.orderDetailProducts.length;
    if(a == length)
    {
      this.setState({allProductScheduled: true})
    }
    else if(this.state.orderDetailProducts != undefined && this.state.orderDetailProducts.length > 0){
      const parent_order = this.props.parent_order
      this.state.orderDetailProducts.map(items =>{
        if(items.id_order != parent_order){
          let item = document.getElementById(items.id_order_detail+"_action")
          item.classList.add("disabled")
          item.checked = true
          item.disabled= true
        }
      })
    }
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

  viewHistory(id_order){
    orderApi.viewHistory(id_order);
  }

  selectAll=(el)=>{
    let items = document.getElementsByClassName("selectProduct")
    this.setState({selectAll: !this.state.selectAll})
    for(let item of items){
      console.log(item.checked)
      console.log(el.target.checked)
      if(item.classList.contains("selected")){
        continue
      }
      if(item.classList.contains("disabled")){
        continue
      }
      if(item.checked == true && el.target.checked == true){
        continue
      }
      item.checked = el.target.checked == true ? true:false;
      let sp = this.state.selectedProducts;
      if(el.target.checked == true){
        sp.push(item.id);
        this.setState({
            selectedProducts: sp
        })
      }
      else{
        this.setState({
            selectedProducts: []
        })
      }
    }
  }

  enableProduct=(id, el)=>{
    let sp = this.state.selectedProducts;
    if(el.target.checked == true){
      sp.push(id);
      this.setState({
          selectedProducts: sp
      })
    }
    else{
      let data = sp.filter( function (data) {
        return data !== id
      });
      this.setState({
          selectedProducts: data
      })
    }
  }

  removeProduct=(id,el)=>{
    let sp = this.state.removeProductsList
    let isAdded = sp.filter( (data)=>{return data === id})
    console.log(sp.length)
    console.log(this.state.orderDetailProducts.length)
    if(isAdded.length != 0){
      let data = sp.filter( function (data) {
        return data !== id
      });
      this.setState({
          removeProductsList: data
      })
    }
    else{
      if(sp.length+1 == this.state.orderDetailProducts.length){
        document.getElementById(id+'_remove').checked=false
        this.confirmCancel()
      }
      else{
        // let p_name = document.getElementById("name_"+id).innerText;
        if(isAdded.length == 0){
          document.getElementById(id+'_remove').checked=true
          sp.push(id);
          this.setState({
              removeProductsList: sp
          })
        }
        // ReactDOM.render(<ConfirmationPop 
        //                 onCancel={(e)=>{document.getElementById(id+'_remove').checked=false}}  
        //                 onClick={this.removeProductConfirmed.bind(this,id)} 
        //                 message={<>Would you like to cancel <strong>{p_name}</strong> from the order?</>} />, 
        //                 document.getElementById("confirmContent"));
        // G.displayModal("confirm");
      }
    }
  }

  removeProductConfirmed=(id)=>{
    document.getElementById(id+'_remove').checked=true
    G.closeModal(["confirm"]);
    let sp = this.state.removeProductsList
    let isAdded = sp.filter( (data)=>{return data === id})
    if(isAdded.length == 0){
      sp.push(id);
      this.setState({
          removeProductsList: sp
      })
    }
    else{
      let data = sp.filter( function (data) {
        return data !== id
      });
      this.setState({
          removeProductsList: data
      })
    }
  }

  schedule=()=>{
    if(this.state.selectedProducts.length <= 0){
      toastr.warning('Warning', 'Please select atleast one product', { icon: "icon-warning"})
      return false;
    }
    const parent_order = this.props.parent_order
    orderApi.ordersSchedule().then(response =>{
      this.setState({events: response.data['schedule']},()=>{
        ReactDOM.render(<CalendarPop key={parent_order} events={this.state.events} selectedDate={this.selectedDateConfirm.bind(this)} />, document.getElementById("calendarPopContent"));
        G.displayModal("CalendarPop");
      })
    })
    
    G.closeModal(["confirm"]); 
  }

  selectedDateConfirm(el, type){
    let date
    if(type == 1){
      date = el.slots[0]
    }
    else if(type == 2){
      date = el.start
    }
    date = G.getDate(date, 'LL');
    ReactDOM.render(<ConfirmationPop 
                      onCancel={this.schedule.bind(this)}  
                      onClick={this.selectedDate.bind(this,date)} 
                      warning={"Please do schedule date for all products and save"}
                      message={"Please confirm the delivery on "+date+" ?"} />, 
                      document.getElementById("confirmContent"));
    G.displayModal("confirm");
    G.closeModal(["CalendarPop"]);    
  }

  selectedDate(date){
    G.closeModal(["confirm"]); 
    const id_order = this.props.parent_order

    // add to event
    let sp = this.state.events;
    sp.push({
      title: 'Order #'+id_order,
      allDay: true,
      start: date,
      end: date,
    },);

    //add to schedule
    let delivery = this.state.deliverySchedule;
    let items = document.getElementsByClassName("selectProduct")
    let qty = []
    let x = []
    this.state.selectedProducts.map(product=>{
      let quantity = document.getElementById(product.replace("_action","_qty")).innerText;
      qty.push(quantity)
      x.push(product.replace("_action",""))
    })
    delivery.push({
      products: x,
      sDate: date,
      quantity: qty,
    })

    //add to orderProductDetail
    let odp = this.state.orderDetailProducts
    this.state.selectedProducts.map( product=>{
        odp.filter((arr, i)=>{ 
          if(arr.id_order_detail == product.replace("_action", ""))
          {
            arr.estimated_delivery_time=G.getDate(date, 'LL')
          }
        })
    })

    //disable selected products  
    this.state.selectedProducts.map( product =>{
        let item = document.getElementById(product)
        item.classList.add("selected")
        item.disabled= true
    })

    this.setState({
        events: sp,
        deliverySchedule: delivery,
        orderDetailProducts: odp,
        selectedProducts: [],
    })
  }

  reset(){
    this.state.removeProductsList.map(item => {
      document.getElementById(item+'_remove').checked=false
    })
    this.setState({removeProductsList: []})
  }

  acceptOrder(){
    ReactDOM.render(<ConfirmationPop 
                        onCancel={(e)=>console.log(e)}  
                        onClick={this.acceptOrderConfirm.bind(this)} 
                        message={"Would you like to accept the order?"} 
                        warning={"Products canceled cannot be reverted back"} 
                        />, 
                        document.getElementById("confirmContent"));
    G.displayModal("confirm");
  }
  acceptOrderConfirm(){
    G.closeModal(["confirm"]);
    const parent_order = this.props.parent_order
    if(this.state.removeProductsList.length != 0){
      let list = []
      this.state.removeProductsList.map(item => {
        let qty = document.getElementById(item+"_qty").innerText;
        list.push(item+"~"+qty);
      })
      orderApi.removeProducts(parent_order, list).then(response =>this.updateStatus(parent_order, 19))
    }
    else{
      this.updateStatus(parent_order, 19)
    }
  }

  acceptSchedule(){
    let items = document.getElementsByClassName("selectProduct")
    let msg = "";
    msg = "Please confirm to save the delivery schedule"

    ReactDOM.render(<ConfirmationPop 
      onCancel={(e)=>{console.log(e)}}
      onClick={this.splitOrder.bind(this)} 
      message={msg}
      />, 
      document.getElementById("confirmContent"));
    G.displayModal("confirm");
  }

  splitOrder(){
    const parent_order = this.props.parent_order
    //create Loop
    let x = this.state.scheduleLoop;
    let schedule = this.state.deliverySchedule;
    orderApi.splitOrder(parent_order, schedule[x].products, schedule[x].quantity, this.props.orderDetails['0'].po_number, schedule[x].sDate).then(response =>{
      this.setState({scheduleLoop: this.state.scheduleLoop + 1})
      if(x == schedule.length-1){
         //Done looping
       this.setState({scheduleLoop: 0})
        toastr.success('Success', "Delivery plan scheduled succesfully", { icon: "icon-success"})
        orderApi.notifyDeliveryPlan(parent_order)
        orderApi.viewOrder(parent_order).then(response =>{
          this.setState({deliverySchedule:[],orderDetailProducts: response.data[3], deliveryPlans: response.data[6], canceledProducts: response.data[8]},()=>this.checkScheduled())
          return response
        })
      }
      else{
        this.splitOrder()
      }
      return response
    })
    this.setState({selectedProducts: []})
    G.closeModal(["confirm"]);
  }


  updateStatus(id_order, status, id_delivery=null, el){
    const parent_order = this.props.parent_order
    if(el != undefined && !el.currentTarget.classList.contains("active") && status != 6){
      return false;
    }
    if(status == 5){
      let minDate = "";
      const index = this.state.deliveryPlans.map((e) => { 
        minDate = e[0].id_order == id_order ? e[0].date_add: minDate;
      });
      ReactDOM.render(<UploadFile 
          key={id_order}
          minDate={minDate}
          submit={this.uploadAckFiles.bind(this, id_order, id_delivery)}
          warning={<div className="warning"><p>Files such as .PNG, .JPEG and PDF are only acceptable.</p><p>Files Should be less than 2MB.</p></div>}
          />, 
        document.getElementById("UploadFilesContent"));
      G.displayModal("uploadFiles");
      return false;
    }
    if(status == 38){
      ReactDOM.render(<DateBox 
                        submit={this.updatePayment.bind(this, id_order)}
                        title={"Please enter the payment received date"} />, 
                        document.getElementById("getDateContent"));
      G.displayModal("getDate");
      return false
    }
    orderApi.updateOrderStatus(id_order, status, id_delivery).then(response=>{
      if(status == 6){
        G.closeModal(["confirm"]);
      }
      if(status == 25){
        this.downloadFiles(id_order, 3);
      }
      orderApi.viewOrder(parent_order).then(response =>{
        this.setState({orderDetailProducts: response.data[3], deliveryPlans: response.data[6], canceledProducts: response.data[8]})
        if(status == 19){
          this.setState({hours: response.data[9].split(":")[0]})
        }
        if(status == 20){
          this.state.deliveryPlans.map(d=>{
            if(d[0].id_order == id_order && d[0].id_delivery != null){
              this.downloadFiles(d[0].id_delivery, 0);    
            }
          })
        }
        return response
      })
    })
  }

  updatePayment(id_order, date){
    const parent_order = this.props.parent_order
    G.closeModal(["getDate"]);

    orderApi.updatePayment(id_order, date).then(response=>{
        if(response.data != "" && response.data['success'] != undefined) {
          toastr.success('Success', response.data['success'], { icon: "icon-success"})
        }
        orderApi.viewOrder(parent_order).then(response =>{
          this.setState({orderDetailProducts: response.data[3], deliveryPlans: response.data[6], canceledProducts: response.data[8]})
          return response
        })
    })
  }

  uploadAckFiles(id_order, id_delivery, deliveredDate, drFiles, invoiceFiles){
    const parent_order = this.props.parent_order
    orderApi.upload(id_order, id_delivery, deliveredDate, drFiles, invoiceFiles).then(response=>{
      G.closeModal(["uploadFiles"]);
      if(response.data != "" && response.data['success'] != undefined) {
          toastr.success('Success', response.data['success'], { icon: "icon-success"})
      }
      orderApi.viewOrder(parent_order).then(response =>{
        this.setState({orderDetailProducts: response.data[3], deliveryPlans: response.data[6], canceledProducts: response.data[8]})
        return response
      })
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
  confirmCancel(){
    const parent_order = this.props.parent_order
    ReactDOM.render(<ConfirmationPop 
            onCancel={(e)=>{console.log(e)}}  
            onClick={this.updateStatus.bind(this, parent_order, 6)} 
            message={"Please confirm to cancel the order #"+parent_order+" ?"}/>, 
            document.getElementById("confirmContent"))
    G.displayModal("confirm")
  }

  expand(element){
    console.log(element.currentTarget)
    // var element = document.getElementById("myDIV");
    element.currentTarget.classList.toggle("expand");
  }

  timerOver(){
    const parent_order = this.props.parent_order
    orderApi.viewOrder(parent_order).then(response =>{
      this.setState({
        orderDetailProducts: response.data[3], 
        deliveryPlans: response.data[6], 
        canceledProducts: response.data[8],
        hours: response.data[9].split(":")[0]},()=>this.checkScheduled())
      return response
    })
  }

  render(){
    let delivery_number = this.props.orderDetails['0'] != undefined && this.props.orderDetails['0']['delivery_number'] >0 ? (this.props.orderDetails['0']['dr_prefix']+""+this.props.orderDetails['0']['delivery_number']):null;
    return (
        <>
        {this.props.isFetching == true ? <div className="loader"><div className="spinner"></div></div> : null}
        
          <div className="page-header">
            <h3 className="page-title">Order Details</h3>
          </div> 
          <div className="order-detail-container order-detail-responsive-container">
          {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] == 22 ?
            <div className="floating-button">
              <div className="timer">You have <span><Timer hours={this.state.hours} date={this.props.orderDetails['0']['order_date']} timerOver={this.timerOver.bind(this)}/></span> to accept</div>
              <button className="button-blue" onClick={this.acceptOrder.bind(this)} >Accept Order</button>
            </div>
          :null}
          {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] != 6 && this.state.allProductScheduled == false && this.props.orderDetails['0']['id_order_state'] != 22?
            <div className="floating-button">
              <div className="timer">You have <span><Timer hours={this.state.hours} date={this.props.orderDetails['0']['order_date']} timerOver={this.timerOver.bind(this)}/></span> to schedule</div>
              <div className="save">
                <button className="button-black" onClick={this.schedule.bind(this)}>
                  <p>{this.state.selectedProducts.length} Products Selected</p><p>Schedule Delivery Date</p>
                </button>
                <button className={this.state.deliverySchedule.length > 0 ? "button-blue":"button-blue disabled"} onClick={this.acceptSchedule.bind(this)} >Save</button>
              </div>
            </div>
          :null}
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
              {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] == 22 ?
              <div className="sect-close" onClick={this.confirmCancel.bind(this)}><span><i className="icon-cancel"></i></span><span>Cancel</span></div>
              :null}
          </div>
            <div className="content-section">
              <div className="order-sections order-detail">
                <div className="title expand" onClick={this.expand.bind(this)}><span>Order</span> <span><i className="icon-arrow-down" ></i></span></div>
                <div className="body">
                  <div className="body-wrapper">
                  <p><div>Company : </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['company']: ''}</p>
                  <p><div>User : </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['firstname']: ''}</p>
                  <p><div>Email : </div>{this.props.orderDetails['0'] !=undefined ? this.props.orderDetails['0']['email']: ''}</p>
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
                    {this.props.deliveryAddress != undefined && this.props.deliveryAddress != null ?this.fethcAddress(this.props.deliveryAddress):null}
                </div>
                </div>
              </div>
              <div className="order-sections address">
                <div className="title" onClick={this.expand.bind(this)}><span>Billing Address</span> <span><i className="icon-arrow-down" ></i></span></div>
                <div className="body">
                  <div className="body-wrapper">
                    {this.props.invoiceAddress != undefined && this.props.invoiceAddress != null ?this.fethcAddress(this.props.invoiceAddress):null}
                  </div>
                </div>
              </div>
            </div>
            {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] == 22 ?
            <div className="content-section">
              <div className="left-section">
                <div className="products-list">
                <div className="header">
                    <p>Products Lists</p>
                    <button className="no-outline" onClick={this.reset.bind(this)}><i className="icon-refresh"></i> Reset</button>
                </div>
                  <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} transitionEnterTimeout={500} transitionLeaveTimeout={300} component="div" className="list-item-wrapper">
                    {this.props.isFetching ? <div><div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div><div></div></div> : 
                        (this.state.orderDetailProducts != undefined ? this.state.orderDetailProducts.map(products => {
                          return (
                            <div key={products.id_order_detail} className="list-item">
                                {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] == 22 ?
                                <div className="product-select">
                                  <input type="checkbox" className="removeProduct" id={products.id_order_detail+"_remove"} onClick={this.removeProduct.bind(this, products.id_order_detail)}/>
                                  <label htmlFor={products.id_order_detail+"_remove"}>Remove</label>
                                </div>:null}
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
                        }) : <div className="no-results-wrapper"><div><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>Please check with your customers</p></div></div></div>)
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
                  {this.state.allProductScheduled == false ?
                  <button className="no-outline" onClick={this.resetOrder.bind(this)}><i className="icon-refresh"></i> Reset</button>:null}
                </div>
                {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] != 6 && this.state.allProductScheduled == false?
                  <div className="selectAllOption">
                    <div>
                        <input type="checkbox" id={"all_action"} onClick={this.selectAll.bind(this)}/>
                        <label htmlFor={"all_action"}>Select All</label>
                    </div>
                  </div>
                  :null}
                  <ReactCSSTransitionGroup transitionName="grid-animation" transitionAppear={false} transitionAppearTimeout={500} transitionLeaveTimeout={300} transitionEnterTimeout={500} transitionLeaveTimeout={300} component="div" className="list-item-wrapper">
                    {this.props.isFetching ? <div><div className="fetching"><div className="fetching-content"><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div><div className="loading-item"></div></div></div><div></div></div> : 
                        (this.state.orderDetailProducts != undefined ? this.state.orderDetailProducts.map(products => {
                          return (
                            <div key={products.id_order_detail} className="list-item">
                                {this.props.orderDetails['0'] !=undefined && this.props.orderDetails['0']['id_order_state'] != 6 && this.state.allProductScheduled == false ?
                                <div className="product-select">
                                  <input type="checkbox" className="selectProduct" id={products.id_order_detail+"_action"} onClick={this.enableProduct.bind(this, products.id_order_detail+"_action")}/>
                                  <label htmlFor={products.id_order_detail+"_action"}>Select</label>
                                </div>:null}
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
                        }) : <div className="no-results-wrapper"><div><div className="no-results"><img src="../supplier/src/assets/img/no-data.png" alt="No Results"/><h2>No Orders Found!</h2><p>Please check with your customers</p></div></div></div>)
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
                        <>
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
                        </>
                        :<div class="no-data">
                          <h3>No Shipment Found!</h3>
                          <p>Please create shipment to see details</p>
                        </div>}
                      </div>
                      <div className="wrap">
                        <div className="block-head"><h3>Invoice </h3></div>
                        {delivery[0].inv_number  ? 
                        <>
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
                        </>
                        :<div class="no-data">
                          <h3>No Invoice Found!</h3>
                          <p>Please create invoice to see details</p>
                        </div>}
                      </div>
                      <div className="wrap">
                        <div className="block"><span className="head">Status:</span><span className="detail">{delivery[0].name}</span></div>
                        <div className="block">
                          <div className="split-button">
                            <div className={"split-button-default-action"}>
                              <button >Actions</button>
                              <span className="split-button-arrow" onClick={this._splitButton.bind(this)}></span>
                              <ul className={"split-button-dropdown hidden"}>
                                <li className={delivery[0].id_order_state == 22 || delivery[0].id_order_state == 19 ? "active":""} onClick={this.updateStatus.bind(this, delivery[0].id_order, 20, null)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                      Create Shipment
                                  </a>                                      
                                </li>
                                <li className={delivery[0].id_order_state == 20 ? "active":""} onClick={this.updateStatus.bind(this, delivery[0].id_order, 4, null)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                      Mark as shipped
                                  </a>                                      
                                </li>
                                <li className={delivery[0].id_order_state == 4 ? "active":""}  onClick={this.updateStatus.bind(this, delivery[0].id_order, 5, delivery[0].id_delivery)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                      Mark as delivered
                                  </a>                                      
                                </li>
                                <li className={delivery[0].id_order_state == 35 || delivery[0].id_order_state == 5 ? "active":""}  onClick={this.updateStatus.bind(this, delivery[0].id_order, 38, delivery[0].id_delivery)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                      Mark as paid
                                  </a>                                      
                                </li>
                                <li className={(delivery[0].inv_number ==null) && ( delivery[0].id_order_state == 20 || delivery[0].id_order_state == 4 || delivery[0].id_order_state == 5) ? "active":""}  onClick={this.updateStatus.bind(this, delivery[0].id_order, 25, delivery[0].id_delivery)}>
                                  <a className="button button-blue outline" href='javascript:void(0)'>
                                      Create Invoice
                                  </a>                                      
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
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
                                  <div>{product.gst.replace("GST", "")}</div>
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
      </>
    )
  }
}

const mapStateToProps = function({orderState, addressState}) {
  return {
    orderDetails: orderState.orderDetails,    
    orderStatus: orderState.orderStatus,
    orderProducts:orderState.orderProducts,
    invoiceAddress: orderState.invoiceAddress,
    deliveryAddress: orderState.deliveryAddress,
    supplierAddress: addressState.supplierAddress,
    states: addressState.allStates,
    isFetching: false,
  };
};

export default connect(mapStateToProps)(OrderDetailsMobile);